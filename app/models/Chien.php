<?php

     /**
     * ════════════════════════════════════════════════════════════════════════════════
     *                                CHIEN MODÈLE
     * ════════════════════════════════════════════════════════════════════════════════
     *
     * - CRUD (create, read, update, delete)
     * - Recherche et filtrage des chiens par éducateur
     * - Validation des données avec contraintes métier
     * - Statistiques et analyses (races populaires, répartition par sexe)
     * - Gestion des relations avec clients et séances
     *
     * @package ChienGo
     * @subpackage Models
     * @author Corfù
     * @version 1.0.0
     * @since 2025-July-09
     */



    //autoload
    namespace app\models;

    use app\config\Database;

    use InvalidArgumentException;
    use PDO;
    use PDOException;
    use RuntimeException;

    class Chien {
        private PDO $db;

        public function __construct() {
            $this->db = Database::getInstance()->getConnection();
        }

        // create new chien
        public function create($data): bool
        {
            $this->validateChienData($data);

            $sql = "INSERT INTO chiens (nom, race, age, poids, couleur, sexe, caractere, problemes_comportement, client_id) 
                    VALUES (:nom, :race, :age, :poids, :couleur, :sexe, :caractere, :problemes_comportement, :client_id)";

            return $this->db->prepare($sql)->execute([
                'nom' => trim($data['nom']),
                'race' => trim($data['race'] ?? ''),
                'age' => $data['age'] ?? null,
                'poids' => $data['poids'] ?? null,
                'couleur' => trim($data['couleur'] ?? ''),
                'sexe' => $data['sexe'] ?? null,
                'caractere' => trim($data['caractere'] ?? ''),
                'problemes_comportement' => trim($data['problemes_comportement'] ?? ''),
                'client_id' => $data['client_id']
            ]);
        }

        /**
         * Récupère un chien par son id unique.
         *
         * @param int $id L'identifiant du chien.
         * @return array|null Les données du chien ou null si non trouvé.
         */
        public function findById(int $id): ?array
        {
            $sql = "SELECT ch.*, c.nom as client_nom, c.prenom as client_prenom
                    FROM chiens ch
                    JOIN clients c ON ch.client_id = c.id
                    WHERE ch.id = :id";

            $stmt = $this->db->prepare($sql);
            $stmt->execute(['id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        /**
         * Récupère tous les chiens associés à un client donné.
         *
         * @param int $clientId L'identifiant du client.
         * @return array Liste des chiens du client (tableaux associatifs).
         */
        public function findByClientId(int $clientId): array
        {
            $sql = "SELECT * FROM chiens WHERE client_id = :client_id ORDER BY nom";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['client_id' => $clientId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        /**
         * Récupère tous les chiens associés à un educ (user) avec les infos du client et le nombre de séances.
         *
         * @param int $userId L'identifiant de l'utilisateur (educ).
         * @return array[] Liste des chiens (chaque élément est un tableau associatif contenant les infos du chien, du client et le nombre de séances).
         * @throws PDOException En cas d'erreur SQL.
         * @throws InvalidArgumentException Si les données du chien sont invalides.
         */
        public function findByUserId(int $userId): array
        {
            $sql = "SELECT ch.*, c.nom as client_nom, c.prenom as client_prenom,
                           COUNT(s.id) as nb_seances
                    FROM chiens ch
                    JOIN clients c ON ch.client_id = c.id
                    LEFT JOIN seances s ON ch.id = s.chien_id
                    WHERE c.user_id = :user_id
                    GROUP BY ch.id
                    ORDER BY ch.nom";

            $stmt = $this->db->prepare($sql);
            $stmt->execute(['user_id' => $userId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        /**
         * Met à jour les infos d'un chien dans la bdd.
         *
         * @param int $id   L'identifiant du chien à mettre à jour.
         * @param array $data Les nouvelles données du chien.
         * @return bool True si la mise à jour a réussi, False sinon.
         * @throws PDOException En cas d'erreur SQL.
         * @throws InvalidArgumentException Si les données du chien sont invalides.
         */
        public function update(int $id, array $data): bool
        {
            $this->validateChienData($data);

            $sql = "UPDATE chiens 
                    SET nom = :nom, race = :race, age = :age, poids = :poids, couleur = :couleur,
                        sexe = :sexe, caractere = :caractere, problemes_comportement = :problemes_comportement,
                        date_modification = CURRENT_TIMESTAMP
                    WHERE id = :id";

            return $this->db->prepare($sql)->execute([
                'id' => $id,
                'nom' => trim($data['nom']),
                'race' => trim($data['race'] ?? ''),
                'age' => $data['age'] ?? null,
                'poids' => $data['poids'] ?? null,
                'couleur' => trim($data['couleur'] ?? ''),
                'sexe' => $data['sexe'] ?? null,
                'caractere' => trim($data['caractere'] ?? ''),
                'problemes_comportement' => trim($data['problemes_comportement'] ?? '')
            ]);
        }

        /**
         * Supprime un chien s'il n'a pas de séances associées.
         *
         * @param int $id Identifiant du chien à supprimer.
         * @return bool True si la suppression a réussi.
         * @throws RuntimeException Si le chien a des séances associées.
         * @throws PDOException En cas d'erreur SQL.
         */
        public function delete(int $id): bool
        {
            // contrôle s'il y a des séances associées
            $sqlCheck = "SELECT COUNT(*) FROM seances WHERE chien_id = :chien_id";
            $stmtCheck = $this->db->prepare($sqlCheck);
            $stmtCheck->execute(['chien_id' => $id]);

            if ($stmtCheck->fetchColumn() > 0) {
                throw new RuntimeException("Impossible de supprimer ce chien : il a des séances associées.");
            }

            $sql = "DELETE FROM chiens WHERE id = :id";
            return $this->db->prepare($sql)->execute(['id' => $id]);
        }

        /**
         * Recherche des chiens selon un terme, parmi ceux associés à un educ (user).
         *
         * @param string $term    Le terme de recherche.
         * @param int $userId  L'identifiant de l'utilisateur (educ).
         * @return array[] Liste des chiens correspondants (chaque élément est un tableau associatif avec les infos du chien et du client).
         * @throws PDOException En cas d'erreur SQL.
         */
        public function search(string $term, int $userId): array
        {
            $term = '%' . trim($term) . '%';
            $sql = "SELECT ch.*, c.nom as client_nom, c.prenom as client_prenom
                    FROM chiens ch
                    JOIN clients c ON ch.client_id = c.id
                    WHERE c.user_id = :user_id 
                    AND (ch.nom LIKE :term OR ch.race LIKE :term OR c.nom LIKE :term OR c.prenom LIKE :term)
                    ORDER BY ch.nom";

            $stmt = $this->db->prepare($sql);
            $stmt->execute(['user_id' => $userId, 'term' => $term]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        /**
         * Valide les données d'un chien avant insertion ou mise à jour.
         *
         * @param array $data Données du chien à valider.
         * @throws InvalidArgumentException Si une ou plusieurs validations échouent.
         */
        private function validateChienData(array $data): void
        {
            $errors = [];

            // nom requis
            if (empty(trim($data['nom']))) {
                $errors[] = "Le nom du chien est requis";
            }

            // age valide
            if (!empty($data['age']) && (!is_numeric($data['age']) || $data['age'] < 0 || $data['age'] > 20)) {
                $errors[] = "L'âge doit être entre 0 et 20 ans";
            }

            // poids valide
            if (!empty($data['poids']) && (!is_numeric($data['poids']) || $data['poids'] < 0 || $data['poids'] > 100)) {
                $errors[] = "Le poids doit être entre 0 et 100 kg";
            }

            // sexe valide
            if (!empty($data['sexe']) && !in_array($data['sexe'], ['male', 'femelle'])) {
                $errors[] = "Le sexe doit être 'male' ou 'femelle'";
            }

            // client ID requis
            if (empty($data['client_id']) || !is_numeric($data['client_id'])) {
                $errors[] = "Client requis";
            }

            if (!empty($errors)) {
                throw new InvalidArgumentException(implode(', ', $errors));
            }
        }

        /**
         * Récupère les races de chiens les plus populaires associées à un educ.
         *
         * @param int $userId L'identifiant de l'utilisateur (educ).
         * @param int $limit Nombre maximum de races à retourner (par défaut 10).
         * @return array[] Liste des races avec leur occurrence, format [['race' → string, 'count' → int]].
         * @throws PDOException En cas d'erreur SQL.
         */
        public function getPopularRaces(int $userId, int $limit = 10): array
        {
            $sql = "SELECT race, COUNT(*) as count 
                    FROM chiens ch
                    JOIN clients c ON ch.client_id = c.id
                    WHERE c.user_id = :user_id AND race != ''
                    GROUP BY race
                    ORDER BY count DESC
                    LIMIT :limit";

            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        /**
         * Récupère les statistiques des chiens par sexe pour un educ donné.
         *
         * @param int $userId L'identifiant de l'utilisateur (educ).
         * @return array[] Liste des sexes avec leur nombre, format [['sexe' → string, 'count' → int]].
         * @throws PDOException En cas d'erreur SQL.
         */
        public function getStatsBySexe(int $userId): array
        {
            $sql = "SELECT sexe, COUNT(*) as count 
                    FROM chiens ch
                    JOIN clients c ON ch.client_id = c.id
                    WHERE c.user_id = :user_id AND sexe IS NOT NULL
                    GROUP BY sexe";

            $stmt = $this->db->prepare($sql);
            $stmt->execute(['user_id' => $userId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }