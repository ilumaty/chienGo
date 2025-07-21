<?php
    namespace app\models;

    use app\config\Database;

    use InvalidArgumentException;
    use PDO;


    class User
    {
        private PDO $db;

        public function __construct()
        {
            $this->db = Database::getInstance()->getConnection();
        }

        /**
         * Recherche un utilisateur actif par email.
         *
         * @param string $email Email de l'utilisateur.
         * @return array|null Données utilisateur ou null si non trouvé.
         */
        public function findByEmail(string $email): ?array
        {
            $sql = "SELECT * FROM users WHERE email = :email AND is_active = 1 LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['email' => $email]);
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
        }

        /**
         * Vérifie la correspondance mot de passe/hash.
         *
         * @param string $password Mot de passe clair.
         * @param string $hashedPassword Hash stocké.
         * @return bool Résultat de la vérification.
         */
        public static function verifyPassword(string $password, string $hashedPassword): bool
        {
            return password_verify($password, $hashedPassword);
        }

        /**
         * Valide les données utilisateur.
         *
         * @param array $data Données à valider.
         * @throws InvalidArgumentException Si données invalides.
         */
        private function validateUserData(array $data): void
        {
            $errors = [];

            if (empty(trim($data['nom'] ?? ''))) {
                $errors[] = "Le nom est requis";
            }

            if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Email invalide";
            }

            if (empty($data['password']) || strlen($data['password']) < 8) {
                $errors[] = "Le mot de passe doit contenir au moins 8 caractères";
            }

            $validRoles = ['admin', 'educateur', 'client'];
            $role = $data['role'] ?? 'educateur';
            if (!in_array($role, $validRoles, true)) {
                $errors[] = "Rôle invalide";
            }

            if ($errors) {
                throw new InvalidArgumentException(implode(', ', $errors));
            }
        }

        /**
         * Crée un nouvel utilisateur.
         *
         * @param array $data Données utilisateur.
         * @return bool Succès de l'opération.
         * @throws InvalidArgumentException Si données invalides.
         */
        public function create(array $data): bool
        {
            $this->validateUserData($data);

            $sql = "INSERT INTO users (nom, prenom, email, password, telephone, adresse, ville, code_postal, role) 
                    VALUES (:nom, :prenom, :email, :password, :telephone, :adresse, :ville, :code_postal, :role)";

            return $this->db->prepare($sql)->execute([
                'nom' => trim($data['nom']),
                'prenom' => trim($data['prenom'] ?? ''),
                'email' => trim($data['email']),
                'password' => password_hash($data['password'], PASSWORD_DEFAULT),
                'telephone' => $data['telephone'] ?? null,
                'adresse' => $data['adresse'] ?? null,
                'ville' => $data['ville'] ?? null,
                'code_postal' => $data['codePostal'] ?? null,
                'role' => $data['role'] ?? 'educateur'
            ]);
        }

        /**
         * Récupère un utilisateur par ID.
         *
         * @param int $id ID utilisateur.
         * @return array|null Données utilisateur ou null.
         */
        public function findById(int $id): ?array
        {
            $sql = "SELECT * FROM users WHERE id = :id AND is_active = 1 LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
        }

        /**
         * Met à jour la date de dernière connexion.
         *
         * @param int $userId ID utilisateur.
         * @return bool Succès de l'opération.
         */
        public function updateLastLogin(int $userId): bool
        {
            $sql = "UPDATE users SET date_modification = CURRENT_TIMESTAMP WHERE id = :id";
            return $this->db->prepare($sql)->execute(['id' => $userId]);
        }

        /**
         * Récupère tous les utilisateurs actifs.
         *
         * @return array Liste des utilisateurs.
         */
        public function getAll(): array
        {
            $sql = "SELECT id, nom, prenom, email, telephone, ville, role, date_creation, is_active 
                    FROM users WHERE is_active = 1 ORDER BY date_creation DESC";
            return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        }

        /**
         * Récupère tous les educ actifs.
         *
         * @return array Liste des educ.
         */
        public function getEducateurs(): array
        {
            $sql = "SELECT id, nom, prenom, email, telephone, ville 
                    FROM users WHERE role = 'educateur' AND is_active = 1 ORDER BY nom, prenom";
            return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        }

        /**
         * Désactive un utilisateur (soft delete).
         *
         * @param int $userId ID utilisateur.
         * @return bool Succès de l'opération.
         */
        public function deactivate(int $userId): bool
        {
            $sql = "UPDATE users SET is_active = 0 WHERE id = :id";
            return $this->db->prepare($sql)->execute(['id' => $userId]);
        }

        /**
         * Met à jour le profil utilisateur.
         *
         * @param int $userId ID utilisateur.
         * @param array $data Nouvelles données.
         * @return bool Succès de l'opération.
         */
        public function updateProfile(int $userId, array $data): bool
        {
            $sql = "UPDATE users SET 
                    nom = :nom, 
                    prenom = :prenom, 
                    email = :email, 
                    telephone = :telephone, 
                    adresse = :adresse, 
                    ville = :ville, 
                    code_postal = :code_postal,
                    date_modification = CURRENT_TIMESTAMP
                    WHERE id = :id";

            return $this->db->prepare($sql)->execute([
                'id' => $userId,
                'nom' => trim($data['nom']),
                'prenom' => trim($data['prenom']),
                'email' => trim($data['email']),
                'telephone' => $data['telephone'] ?? null,
                'adresse' => $data['adresse'] ?? null,
                'ville' => $data['ville'] ?? null,
                'code_postal' => $data['code_postal'] ?? null
            ]);
        }

        /**
         * Modifie le mot de passe d'un utilisateur.
         *
         * @param int $userId ID utilisateur.
         * @param string $newPassword Nouveau mot de passe.
         * @return bool Succès de l'opération.
         */
        public function changePassword(int $userId, string $newPassword): bool
        {
            $sql = "UPDATE users SET password = :password, date_modification = CURRENT_TIMESTAMP WHERE id = :id";
            return $this->db->prepare($sql)->execute([
                'id' => $userId,
                'password' => password_hash($newPassword, PASSWORD_DEFAULT)
            ]);
        }
}
