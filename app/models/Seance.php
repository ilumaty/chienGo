<?php

     /**
     * ════════════════════════════════════════════════════════════════════════════════
     *                               SÉANCE MODÈLE
     * ════════════════════════════════════════════════════════════════════════════════
     *
     * - CRUD (create, read, update, delete)
     * - Planning et organisation des séances par éducateur
     * - Détection automatique des conflits d'horaires
     * - Calcul des statistiques et revenus
     * - Validation des données avec contraintes métier
     * - Formatage intelligent des dates et valeurs
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

    class Seance
    {
        private PDO $db;

        public function __construct()
        {
            $this->db = Database::getInstance()->getConnection();
        }

        /**
         * Crée une nouvelle séance dans la base de données.
         *
         * @param array $data Données de la séance à insérer.
         * @return bool True si l'insertion a réussi, False sinon.
         * @throws InvalidArgumentException Si les données sont invalides.
         * @throws PDOException En cas d'erreur SQL.
         */
        public function create(array $data): bool
        {
            echo "DEBUG: Début de Seance->create()<br>";
            print_r($data);

            $this->validateSeanceData($data);

            $allowedColumns = [
                'titre', 'description', 'date_seance', 'duree_minutes',
                'prix', 'statut', 'lieu', 'notes_educateur',
                'user_id', 'client_id', 'chien_id'
            ];

            $params = [];
            $columns = [];

            foreach ($allowedColumns as $col) {
                if (array_key_exists($col, $data)) {
                    $columns[] = $col;
                    $params[":$col"] = $this->formatValue($col, $data[$col]);
                }
            }

            if (!empty($data['type_seance_id'])) {
                $columns[] = 'type_seance_id';
                $params[':type_seance_id'] = (int)$data['type_seance_id'];
            }

            $placeholders = array_map(static fn($col) => ":$col", $columns);
            $sql = "INSERT INTO seances (" . implode(', ', $columns) . ")
                VALUES (" . implode(', ', $placeholders) . ")";

            echo "DEBUG SQL: " . $sql . "<br>";
            echo "DEBUG PARAMS: ";
            print_r($params);

            return $this->db->prepare($sql)->execute($params);
        }


        /**
         * Récupère une séance par son identifiant et l'utilisateur associé.
         *
         * @param int $id      L'identifiant de la séance.
         * @param int $userId  L'identifiant de l'utilisateur (educ).
         * @return array|null  Les données de la séance ou null si non trouvée.
         * @throws PDOException En cas d'erreur SQL.
         */
        public function findById(int $id, int $userId): ?array
        {
            $sql = "SELECT s.*, 
                   c.nom as client_nom, c.prenom as client_prenom, c.telephone as client_telephone,
                   ch.nom as chien_nom, ch.race as chien_race,
                   ts.nom as type_nom, ts.couleur as type_couleur
            FROM seances s
            JOIN clients c ON s.client_id = c.id
            JOIN chiens ch ON s.chien_id = ch.id
            LEFT JOIN types_seances ts ON s.type_seance_id = ts.id
            WHERE s.id = :id AND s.user_id = :user_id";

            $stmt = $this->db->prepare($sql);
            $stmt->execute(['id' => $id, 'user_id' => $userId]);

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return $result !== false ? $result : null;
        }

        /**
         * Récupère toutes les séances d'un educ avec possibilité de filtrer par statut, période ou client.
         *
         * @param int $userId  L'identifiant de l'utilisateur (educ).
         * @param array $filters Filtres optionnels : 'statut', 'date_debut', 'date_fin', 'client_id'.
         * @return array[] Liste des séances (chaque élément est un tableau associatif avec les infos séance, client, chien, type).
         * @throws PDOException En cas d'erreur SQL.
         */
        public function findByUserId(int $userId, array $filters = []): array
        {
            $sql = "SELECT s.*, 
                           c.nom as client_nom, c.prenom as client_prenom,
                           ch.nom as chien_nom,
                           ts.nom as type_nom, ts.couleur as type_couleur
                    FROM seances s
                    JOIN clients c ON s.client_id = c.id
                    JOIN chiens ch ON s.chien_id = ch.id
                    LEFT JOIN types_seances ts ON s.type_seance_id = ts.id
                    WHERE s.user_id = :user_id";

            $params = ['user_id' => $userId];

            // filtres
            if (!empty($filters['statut'])) {
                $sql .= " AND s.statut = :statut";
                $params['statut'] = $filters['statut'];
            }

            if (!empty($filters['date_debut'])) {
                $sql .= " AND s.date_seance >= :date_debut";
                $params['date_debut'] = $filters['date_debut'];
            }

            if (!empty($filters['date_fin'])) {
                $sql .= " AND s.date_seance <= :date_fin";
                $params['date_fin'] = $filters['date_fin'];
            }

            if (!empty($filters['client_id'])) {
                $sql .= " AND s.client_id = :client_id";
                $params['client_id'] = $filters['client_id'];
            }

            $sql .= " ORDER BY s.date_seance ASC";

            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        /**
         * Récupère toutes les séances du jour pour un educ donné.
         *
         * @param int $userId L'identifiant de l'utilisateur (educ).
         * @return array[] Liste des séances du jour (tableaux associatifs).
         * @throws PDOException En cas d'erreur SQL.
         */
        public function findToday(int $userId): array
        {
            $sql = "SELECT s.*, 
                           c.nom as client_nom, c.prenom as client_prenom, c.telephone as client_telephone,
                           ch.nom as chien_nom,
                           ts.nom as type_nom, ts.couleur as type_couleur
                    FROM seances s
                    JOIN clients c ON s.client_id = c.id
                    JOIN chiens ch ON s.chien_id = ch.id
                    LEFT JOIN types_seances ts ON s.type_seance_id = ts.id
                    WHERE s.user_id = :user_id 
                    AND DATE(s.date_seance) = CURDATE()
                    ORDER BY s.date_seance ASC";

            $stmt = $this->db->prepare($sql);
            $stmt->execute(['user_id' => $userId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        /**
         * Récupère les prochaines séances d'un educ, limité à un nombre donné.
         *
         * @param int $userId L'identifiant de l'utilisateur (educ).
         * @param int $limit Nombre maximum de séances à retourner (par défaut 5).
         * @return array[] Liste des prochaines séances (tableaux associatifs).
         * @throws PDOException En cas d'erreur SQL.
         */
        public function findUpcoming(int $userId, int $limit = 5): array
        {
            $sql = "SELECT s.*, 
                           c.nom as client_nom, c.prenom as client_prenom,
                           ch.nom as chien_nom,
                           ts.nom as type_nom, ts.couleur as type_couleur
                    FROM seances s
                    JOIN clients c ON s.client_id = c.id
                    JOIN chiens ch ON s.chien_id = ch.id
                    LEFT JOIN types_seances ts ON s.type_seance_id = ts.id
                    WHERE s.user_id = :user_id 
                    AND s.date_seance > NOW()
                    AND s.statut IN ('planifiee', 'confirmee')
                    ORDER BY s.date_seance ASC
                    LIMIT :limit";

            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        /**
         * Met à jour les informations d'une séance dans la base de données.
         *
         * @param int $id      L'identifiant de la séance à mettre à jour.
         * @param array $data    Les nouvelles données de la séance.
         * @param int $userId  L'identifiant de l'utilisateur (educ).
         * @return bool True si la mise à jour a réussi, False sinon.
         * @throws InvalidArgumentException Si les données de la séance sont invalides.
         * @throws PDOException En cas d'erreur SQL.
         */
        public function update(int $id, array $data, int $userId): bool
        {
            $this->validateSeanceData($data);

            $sql = "UPDATE seances 
                    SET titre = :titre, description = :description, date_seance = :date_seance,
                        duree_minutes = :duree_minutes, prix = :prix, statut = :statut, lieu = :lieu,
                        notes_educateur = :notes_educateur, client_id = :client_id, chien_id = :chien_id,
                        type_seance_id = :type_seance_id, date_modification = CURRENT_TIMESTAMP
                    WHERE id = :id AND user_id = :user_id";

            return $this->db->prepare($sql)->execute([
                'titre' => $this->formatValue('titre', $data['titre']),
                'description' => $this->formatValue('description', $data['description'] ?? ''),
                'date_seance' => $this->formatValue('date_seance', $data['date_seance']),
                'duree_minutes' => $this->formatValue('duree_minutes', $data['duree_minutes'] ?? 60),
                'prix' => $this->formatValue('prix', $data['prix'] ?? null),
                'statut' => $this->formatValue('statut', $data['statut'] ?? 'planifiee'),
                'lieu' => $this->formatValue('lieu', $data['lieu'] ?? ''),
                'notes_educateur' => $this->formatValue('notes_educateur', $data['notes_educateur'] ?? ''),
                'client_id' => $this->formatValue('client_id', $data['client_id']),
                'chien_id' => $this->formatValue('chien_id', $data['chien_id']),
                'type_seance_id' => !empty($data['type_seance_id']) ? (int)$data['type_seance_id'] : null,
                'id' => $id,
                'user_id' => $userId
            ]);
        }

        /**
         * Supprime une séance de la base de données.
         *
         * @param int $id     L'identifiant de la séance à supprimer.
         * @param int $userId L'identifiant de l'utilisateur (educ).
         * @return bool True si la suppression a réussi, False sinon.
         * @throws PDOException En cas d'erreur SQL.
         */
        public function delete(int $id, int $userId): bool
        {
            $sql = "DELETE FROM seances WHERE id = :id AND user_id = :user_id";
            return $this->db->prepare($sql)->execute(['id' => $id, 'user_id' => $userId]);
        }

        /**
         * Compte le nombre de séances du jour pour un educ donné.
         *
         * @param int $userId L'identifiant de l'utilisateur (educ).
         * @return int Le nombre de séances du jour.
         * @throws PDOException En cas d'erreur SQL.
         */
        public function countToday(int $userId): int
        {
            $sql = "SELECT COUNT(*) FROM seances 
            WHERE user_id = :user_id AND DATE(date_seance) = CURDATE()";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['user_id' => $userId]);
            return (int) $stmt->fetchColumn();
        }


        /**
         * Compte le nombre de séances de la semaine en cours.
         *
         * @param int $userId ID de l'utilisateur
         * @return int Nombre de séances
         * @throws PDOException
         */
        public function countThisWeek(int $userId): int
        {
            $sql = "SELECT COUNT(*) FROM seances 
            WHERE user_id = :user_id 
            AND WEEK(date_seance, 1) = WEEK(CURDATE(), 1)
            AND YEAR(date_seance) = YEAR(CURDATE())";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['user_id' => $userId]);
            return (int) $stmt->fetchColumn();
        }

        /**
         * Calcule le revenu total des séances terminées.
         *
         * @param int $userId ID de l'utilisateur
         * @param string $period Période (week/month/year)
         * @return float Revenu total
         * @throws PDOException
         */
        public function sumRevenue(int $userId, string $period = 'month'): float
        {
            $sql = match ($period) {
                'week' => "SELECT SUM(prix) FROM seances 
                    WHERE user_id = :user_id 
                    AND WEEK(date_seance, 1) = WEEK(CURDATE(), 1)
                    AND YEAR(date_seance) = YEAR(CURDATE())
                    AND statut = 'terminee'",
                'year' => "SELECT SUM(prix) FROM seances 
                    WHERE user_id = :user_id 
                    AND YEAR(date_seance) = YEAR(CURDATE())
                    AND statut = 'terminee'",
                default => "SELECT SUM(prix) FROM seances 
                    WHERE user_id = :user_id 
                    AND MONTH(date_seance) = MONTH(CURDATE())
                    AND YEAR(date_seance) = YEAR(CURDATE())
                    AND statut = 'terminee'",
            };

            $stmt = $this->db->prepare($sql);
            $stmt->execute(['user_id' => $userId]);
            return (float) ($stmt->fetchColumn() ?: 0);
        }

        /**
         * Vérifie les conflits d'horaires pour une séance donnée d'un utilisateur.
         *
         * @param int $userId L'identifiant de l'utilisateur (educ).
         * @param string $dateSeance La date et l'heure de début de la séance (format 'Y-m-d H : i : s').
         * @param int $dureeMinutes La durée de la séance en minutes.
         * @param int|null $excludeId Identifiant d'une séance à exclure de la vérification.
         * @return bool True s'il y a un conflit, False sinon.
         * @throws PDOException En cas d'erreur SQL.
         */
        public function checkConflict(int $userId, string $dateSeance, int $dureeMinutes, ?int $excludeId = null): bool
        {
            $dateDebut = $dateSeance;
            $dateFin = date('Y-m-d H:i:s', strtotime($dateSeance . ' +' . $dureeMinutes . ' minutes'));

            $sql = "SELECT COUNT(*) FROM seances 
                    WHERE user_id = :user_id 
                    AND statut IN ('planifiee', 'confirmee', 'en_cours')
                    AND (
                        (date_seance <= :date_debut AND DATE_ADD(date_seance, INTERVAL duree_minutes MINUTE) > :date_debut)
                        OR 
                        (date_seance < :date_fin AND DATE_ADD(date_seance, INTERVAL duree_minutes MINUTE) >= :date_fin)
                        OR
                        (date_seance >= :date_debut AND date_seance < :date_fin)
                    )";

            $params = [
                'user_id' => $userId,
                'date_debut' => $dateDebut,
                'date_fin' => $dateFin
            ];

            if ($excludeId !== null) {
                $sql .= " AND id != :exclude_id";
                $params['exclude_id'] = $excludeId;
            }

            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchColumn() > 0;
        }

        /**
         * Valide les données d'une séance avant insertion ou mise à jour.
         *
         * @param array $data Les données de la séance à valider.
         * @throws InvalidArgumentException Si les données sont invalides.
         */
        private function validateSeanceData(array $data): void
        {
            $errors = [];

            // titre requis
            if (empty(trim($data['titre']))) {
                $errors[] = "Le titre est requis";
            }

            // date valide pour user_id
            if (empty($data['user_id']) || !is_numeric($data['user_id'])) {
                $errors[] = "Utilisateur requis";
            }

            // date seance valide
            if (empty($data['date_seance']) || !strtotime($data['date_seance'])) {
                $errors[] = "Date de séance requise";
            } else {
                try {
                    $this->formatDateTime($data['date_seance']);
                } catch (InvalidArgumentException $e) {
                    $errors[] = "Format de date invalide" - $e->getMessage();
                }
            }

            // durée valide
            if (!empty($data['duree_minutes']) && (!is_numeric($data['duree_minutes']) || $data['duree_minutes'] < 15 || $data['duree_minutes'] > 480)) {
                $errors[] = "La durée doit être entre 15 et 480 minutes";
            }

            // prix valide
            if (!empty($data['prix']) && (!is_numeric($data['prix']) || $data['prix'] < 0)) {
                $errors[] = "Le prix doit être un nombre positif";
            }

            // statut valide
            $statutsValides = ['planifiee', 'confirmee', 'en_cours', 'terminee', 'annulee'];
            if (!empty($data['statut']) && !in_array($data['statut'], $statutsValides, true)) {
                $errors[] = "Statut invalide";
            }

            // client et chien requis
            if (empty($data['client_id']) || !is_numeric($data['client_id'])) {
                $errors[] = "Client requis";
            }

            if (empty($data['chien_id']) || !is_numeric($data['chien_id'])) {
                $errors[] = "Chien requis";
            }

            if (!empty($errors)) {
                throw new InvalidArgumentException(implode(', ', $errors));
            }
        }

        /**
         * Formate une valeur selon le type de colonne pour l'insertion en base de données.
         *
         * - Convertit les IDs et durées en entiers
         * - Convertit les prix en nombres décimaux
         * - Nettoie les chaînes de caractères (trim)
         * - Formate les dates pour MySQL
         * - Retourne null pour les valeurs vides
         *
         * @param string $column Le nom de la colonne de la bdd
         * @param mixed $value La valeur à formater (peut être string, int, float, null)
         * @return mixed La valeur formatée selon le type de colonne, ou null si vide
         *
         * @throws InvalidArgumentException Si le format de date est invalide (via formatDateTime)
         *
         * @example
         * $this->formatValue('duree_minutes', '60'); // retourne (int) 60
         * $this->formatValue('prix', '49.99'); // retourne (float) 49.99
         * $this->formatValue('titre', '  Mon titre  '); // retourne 'Mon titre'
         * $this->formatValue('date_seance', '2024-12-25T14:30'); // retourne '2024-12-25 14:30:00'
         */
        private function formatValue(string $column, mixed $value): mixed
        {
            if ($value === null || $value === '') {
                return null;
            }

            return match($column) {
                'duree_minutes', 'client_id', 'chien_id', 'user_id' => (int)$value,
                'prix' => is_numeric($value) ? (float)$value : null,
                'titre', 'description', 'lieu', 'notes_educateur', 'statut' => trim((string)$value),
                'date_seance' => $this->formatDateTime($value),
                default => $value
            };
        }

        /**
         * Convertit date en format HTML datetime-local vers le format MySQL DATETIME.
         *
         * - Format datetime-local HTML5: "YYYY-MM-DDTHH:MM" → "YYYY-MM-DD HH:MM:SS"
         * - Format MySQL déjà correct: "YYYY-MM-DD HH:MM:SS" → inchangé
         * - Valeurs vides → null
         *
         * @param mixed $value La valeur de date à formater (string attendu)
         * @return string|null La date formatée pour MySQL ou null si vide
         *
         * @throws InvalidArgumentException Si données non valides
         *
         * @example
         * $this->formatDateTime('2024-12-25T14:30'); // retourne '2024-12-25 14:30:00'
         * $this->formatDateTime('2024-12-25 14:30:00'); // retourne '2024-12-25 14:30:00'
         * $this->formatDateTime(''); // retourne null
         * $this->formatDateTime('invalid-date'); // throw InvalidArgumentException
         */
        private function formatDateTime(mixed $value): ?string
        {
            if (empty($value)) {
                return null;
            }

            // format datetime-local (YYYY-MM-DDTHH:MM) vers MySQL
            if (preg_match('/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}$/', $value)) {
                return str_replace('T', ' ', $value) . ':00';
            }

            // si c'est déjà au bon format MySQL
            if (preg_match('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/', $value)) {
                return $value;
            }

            throw new InvalidArgumentException("Format de date invalide: $value");
        }
    }