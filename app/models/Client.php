<?php

     /**
     * ════════════════════════════════════════════════════════════════════════════════
     *                               CLIENT MODÈLE
     * ════════════════════════════════════════════════════════════════════════════════
     *
     * - CRUD (create, read, update, delete)
     * - Recherche et filtrage des clients par éducateur
     * - Validation des données avec contraintes métier
     * - Gestion des relations avec chiens et séances
     * - Contrôles d'unicité et de sécurité des données
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

    class Client {
        private PDO $db;

        public function __construct() {
            $this->db = Database::getInstance()->getConnection();
        }

        /**
         * Crée un nouveau client dans la bdd.
         *
         * @param array $data Données du client à insérer.
         * @return bool True si l'insertion a réussi, False sinon.
         * @throws InvalidArgumentException Si les données du client sont invalides.
         * @throws PDOException En cas d'erreur SQL.
         */
        public function create(array $data): bool
        {
            $this->validateClientData($data);

            $sql = "INSERT INTO clients (nom, prenom, email, telephone, adresse, ville, code_postal, notes, user_id) 
                    VALUES (:nom, :prenom, :email, :telephone, :adresse, :ville, :code_postal, :notes, :user_id)";

            return $this->db->prepare($sql)->execute([
                'nom' => trim($data['nom']),
                'prenom' => trim($data['prenom']),
                'email' => trim($data['email']),
                'telephone' => trim($data['telephone']),
                'adresse' => trim($data['adresse'] ?? ''),
                'ville' => trim($data['ville'] ?? ''),
                'code_postal' => trim($data['code_postal'] ?? ''),
                'notes' => trim($data['notes'] ?? ''),
                'user_id' => $data['user_id']
            ]);
        }

        /**
         * Récupère un client par son identifiant et l'identifiant utilisateur associé.
         *
         * @param int $id      L'identifiant du client.
         * @param int $userId  L'identifiant de l'utilisateur (educ).
         * @return array|null  Les données du client sous forme de tableau associatif ou null si non trouvé.
         * @throws PDOException En cas d'erreur SQL.
         */
        public function findById(int $id, int $userId): ?array
        {
            $sql = "SELECT * FROM clients WHERE id = :id AND user_id = :user_id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['id' => $id, 'user_id' => $userId]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        /**
         * Récupère tous les clients d'un educ avec le nombre de chiens associés.
         *
         * @param int $userId L'identifiant de l'utilisateur (educ).
         * @return array[] Liste des clients (chaque élément est un tableau associatif contenant les infos du client et le nombre de chiens).
         * @throws PDOException En cas d'erreur SQL.
         */
        public function findByUserId(int $userId): array
        {
            $sql = "SELECT c.*, COUNT(ch.id) as nb_chiens 
                    FROM clients c 
                    LEFT JOIN chiens ch ON c.id = ch.client_id 
                    WHERE c.user_id = :user_id 
                    GROUP BY c.id 
                    ORDER BY c.nom, c.prenom";

            $stmt = $this->db->prepare($sql);
            $stmt->execute(['user_id' => $userId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        /**
         * Met à jour les informations d'un client dans la bdd.
         *
         * @param int $id      L'identifiant du client à mettre à jour.
         * @param array $data    Les nouvelles données du client.
         * @param int $userId  L'identifiant de l'utilisateur (educ).
         * @return bool True si la mise à jour a réussi, False sinon.
         * @throws InvalidArgumentException Si les données du client sont invalides.
         * @throws PDOException En cas d'erreur SQL.
         */
        public function update(int $id, array $data, int $userId): bool
        {
            $this->validateClientData($data);

            $sql = "UPDATE clients 
                    SET nom = :nom, prenom = :prenom, email = :email, telephone = :telephone,
                        adresse = :adresse, ville = :ville, code_postal = :code_postal, notes = :notes,
                        date_modification = CURRENT_TIMESTAMP
                    WHERE id = :id AND user_id = :user_id";

            return $this->db->prepare($sql)->execute([
                'id' => $id,
                'nom' => trim($data['nom']),
                'prenom' => trim($data['prenom']),
                'email' => trim($data['email']),
                'telephone' => trim($data['telephone']),
                'adresse' => trim($data['adresse'] ?? ''),
                'ville' => trim($data['ville'] ?? ''),
                'code_postal' => trim($data['code_postal'] ?? ''),
                'notes' => trim($data['notes'] ?? ''),
                'user_id' => $userId
            ]);
        }

        /**
         * Supprime un client s'il n'a pas de chiens associés.
         *
         * @param int $id Identifiant du client à supprimer.
         * @param int $userId Identifiant de l'utilisateur (educ).
         * @return bool True si la suppression a réussi.
         * @throws RuntimeException Si le client a des chiens associés.
         * @throws PDOException En cas d'erreur SQL.
         */
        public function delete(int $id, int $userId): bool
        {
            // vérifie s'il y a des chiens associés
            $sqlCheck = "SELECT COUNT(*) FROM chiens WHERE client_id = :client_id";
            $stmtCheck = $this->db->prepare($sqlCheck);
            $stmtCheck->execute(['client_id' => $id]);

            if ($stmtCheck->fetchColumn() > 0) {
                throw new RuntimeException("Impossible de supprimer ce client : il a des chiens associés.");
            }

            $sql = "DELETE FROM clients WHERE id = :id AND user_id = :user_id";
            return $this->db->prepare($sql)->execute(['id' => $id, 'user_id' => $userId]);
        }

        /**
         * Recherche des clients selon un terme, parmi ceux associés à un educ.
         *
         * @param string $term    Le terme de recherche.
         * @param int $userId  L'identifiant de l'utilisateur (educ).
         * @return array[] Liste des clients correspondants (tableaux associatifs).
         * @throws PDOException En cas d'erreur SQL.
         */
        public function search(string $term, int $userId): array
        {
            $term = '%' . trim($term) . '%';
            $sql = "SELECT * FROM clients 
            WHERE user_id = :user_id 
            AND (nom LIKE :term_nom OR prenom LIKE :term_prenom OR email LIKE :term_email)
            ORDER BY nom, prenom";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'user_id' => $userId,
                'term_nom' => $term,
                'term_prenom' => $term,
                'term_email' => $term
            ]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        /**
         * Compte le nombre de clients actifs associés à un educ.
         *
         * @param int $userId L'identifiant de l'utilisateur (educ).
         * @return int Le nombre de clients actifs.
         * @throws PDOException En cas d'erreur SQL.
         */
        public static function countActive(int $userId): int
        {
            $db = Database::getInstance()->getConnection();
            $sql = "SELECT COUNT(*) FROM clients WHERE user_id = :user_id";
            $stmt = $db->prepare($sql);
            $stmt->execute(['user_id' => $userId]);
            return (int) $stmt->fetchColumn();
        }

        /**
         * Valide les données d'un client avant insertion ou mise à jour.
         *
         * @param array $data Les données du client à valider.
         * @throws InvalidArgumentException Si les données sont invalides.
         */
        private function validateClientData(array $data): void
        {
            $errors = [];

            // nom requis
            if (empty(trim($data['nom']))) {
                $errors[] = "Le nom est requis";
            }

            // prénom requis
            if (empty(trim($data['prenom']))) {
                $errors[] = "Le prénom est requis";
            }

            // email valide
            if (!empty($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $errors[] = "L'email n'est pas valide";
            }

            // téléphone
            if (!empty($data['telephone']) && !preg_match('/^[\+]?[0-9\s\-\(\)]{8,20}$/', $data['telephone'])) {
                $errors[] = "Le numéro de téléphone n'est pas valide";
            }

            // code postal
            if (!empty($data['code_postal']) && !preg_match('/^[0-9]{4,6}$/', $data['code_postal'])) {
                $errors[] = "Le code postal n'est pas valide";
            }

            // gestion des erreurs
            if (!empty($errors)) {
                throw new InvalidArgumentException(implode(', ', $errors));
            }
        }

        /**
         * Vérifie si une adresse email existe déjà pour un utilisateur, en option exclut un client donné (utile lors d'une modif).
         *
         * @param string $email     L'adresse email à vérifier.
         * @param int $userId    L'identifiant de l'utilisateur (educ).
         * @param int|null $excludeId L'identifiant du client à exclure de la recherche
         * @return bool True si l'email existe déjà, False sinon.
         * @throws PDOException En cas d'erreur SQL.
         */
        public function emailExists(string $email, int $userId, ?int $excludeId = null): bool
        {
            $sql = "SELECT COUNT(*) FROM clients WHERE email = :email AND user_id = :user_id";
            $params = ['email' => $email, 'user_id' => $userId];

            if ($excludeId !== null) {
                $sql .= " AND id != :exclude_id";
                $params['exclude_id'] = $excludeId;
            }

            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchColumn() > 0;
        }
    }