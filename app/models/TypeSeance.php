<?php

    /**
     * ════════════════════════════════════════════════════════════════════════════════
     *                             TYPE DE SÉANCE MODÈLE
     * ════════════════════════════════════════════════════════════════════════════════
     *
     * - CRUD (create, read, update, delete)
     * - Configuration des durées et tarifs par type
     * - Validation des données avec contraintes métier
     * - Gestion des couleurs pour l'affichage du planning
     * - Contrôles d'intégrité avant suppression
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

    class TypeSeance {
        private PDO $db;

        public function __construct() {
            $this->db = Database::getInstance()->getConnection();
        }

        /**
         * Crée un nouveau type de séance dans la bdd.
         *
         * @return array Liste des types de séances (en tableaux associatifs)
         * @throws PDOException En cas d'erreur SQL
         */
        public function findAll(): array
        {
            $sql = "SELECT * FROM types_seances ORDER BY nom";
            return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        }

        /**
         * Récupère un type de séance par son id.
         *
         * @param int $id L'identifiant du type de séance.
         * @return array|null Les données du type de séance sous forme de tableau associatif, ou null si non trouvé.
         * @throws PDOException En cas d'erreur SQL.
         */
        public function findById(int $id): ?array
        {
            $sql = "SELECT * FROM types_seances WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        /**
         * Crée un nouveau type de séance dans la bdd.
         *
         * @param array $data Données du type de séance à insérer.
         * @return bool True si l'insertion a réussi, False sinon.
         * @throws InvalidArgumentException Si les données sont invalides.
         * @throws PDOException En cas d'erreur SQL.
         */
        public function create(array $data): bool
        {
            $this->validateTypeData($data);

            $sql = "INSERT INTO types_seances (nom, description, duree_minutes, prix, couleur) 
                    VALUES (:nom, :description, :duree_minutes, :prix, :couleur)";

            return $this->db->prepare($sql)->execute([
                'nom' => trim($data['nom']),
                'description' => trim($data['description'] ?? ''),
                'duree_minutes' => $data['duree_minutes'] ?? 60,
                'prix' => $data['prix'] ?? null,
                'couleur' => $data['couleur'] ?? '#3B82F6'
            ]);
        }

        /**
         * Met à jour un type de séance dans la bdd.
         *
         * @param int $id   L'identifiant du type de séance à mettre à jour.
         * @param array $data Les nouvelles données du type de séance.
         * @return bool True si la mise à jour a réussi, False sinon.
         * @throws InvalidArgumentException Si les données sont invalides.
         * @throws PDOException En cas d'erreur SQL.
         */
        public function update(int $id, array $data): bool
        {
            $this->validateTypeData($data);

            $sql = "UPDATE types_seances 
                    SET nom = :nom, description = :description, duree_minutes = :duree_minutes,
                        prix = :prix, couleur = :couleur
                    WHERE id = :id";

            return $this->db->prepare($sql)->execute([
                'id' => $id,
                'nom' => trim($data['nom']),
                'description' => trim($data['description'] ?? ''),
                'duree_minutes' => $data['duree_minutes'] ?? 60,
                'prix' => $data['prix'] ?? null,
                'couleur' => $data['couleur'] ?? '#3B82F6'
            ]);
        }

        /**
         * Supprime un type de séance s'il n'est pas utilisé dans des séances.
         *
         * @param int $id Identifiant du type de séance à supprimer.
         * @return bool True si la suppression a réussi, False sinon.
         * @throws RuntimeException Si le type est utilisé dans des séances.
         * @throws PDOException En cas d'erreur SQL.
         */
        public function delete(int $id): bool
        {
            // vérifier s'il y a des séances associées
            $sqlCheck = "SELECT COUNT(*) FROM seances WHERE type_seance_id = :type_id";
            $stmtCheck = $this->db->prepare($sqlCheck);
            $stmtCheck->execute(['type_id' => $id]);

            if ($stmtCheck->fetchColumn() > 0) {
                throw new RuntimeException("Impossible de supprimer ce type : il y a des séances associées.");
            }

            $sql = "DELETE FROM types_seances WHERE id = :id";
            return $this->db->prepare($sql)->execute(['id' => $id]);
        }

        /**
         * Valide les données d'un type de séance.
         *
         * @param array $data Les données à valider.
         * @throws InvalidArgumentException Si les données sont invalides.
         */
        private function validateTypeData(array $data): void
        {
            $errors = [];

            // nom requis
            if (empty(trim($data['nom'] ?? ''))) {
                $errors[] = "Le nom est requis";
            }

            // durée valide
            $duree = $data['duree_minutes'] ?? 60;
            if (!is_numeric($duree) || $duree < 15 || $duree > 480) {
                $errors[] = "La durée doit être entre 15 et 480 minutes";
            }

            // prix valide
            $prix = $data['prix'] ?? null;
            if ($prix !== null && (!is_numeric($prix) || $prix < 0)) {
                $errors[] = "Le prix doit être un nombre positif";
            }

            // couleur valide
            $couleur = $data['couleur'] ?? '#3B82F6';
            if (!preg_match('/^#([a-f0-9]{6}|[a-f0-9]{3})$/i', $couleur)) {
                $errors[] = "Le format de couleur est invalide (ex: #3B82F6 ou #FFF)";
            }

            if (!empty($errors)) {
                throw new InvalidArgumentException(implode("\n", $errors));
            }
        }
    }