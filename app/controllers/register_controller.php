<?php

    /**
     * ════════════════════════════════════════════════════════════════════════════════
     *                                INSCRIPTION CONTROLLER
     * ════════════════════════════════════════════════════════════════════════════════
     *
     * - Validation des données du formulaire d'inscription
     * - Création de nouveaux comptes utilisateur avec sécurisation
     * - Gestion des erreurs et messages de confirmation
     * - Redirection automatique vers la page de connexion
     *
     * @package ChienGo
     * @subpackage Controllers
     * @author Corfù
     * @version 1.0.0
     * @since 2025-July-09
     */

    // autoload
    use app\models\user;

    $errors = [];
    $pageTitle = "Inscription || ChienGo";

        // si formulaire soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pseudo = trim($_POST['pseudo'] ?? '');
            $nom = trim($_POST['nom'] ?? '');
            $prenom = trim($_POST['prenom'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

        // valide sur serveur email et password
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Email invalide.";
        }

        if (strlen($password) < 6) {
            $errors[] = "Mot de passe trop court.";
        }

        if (empty($errors)) {
            try {
                $data = [
                    'nom' => $nom,
                    'prenom' => $prenom,
                    'email' => $email,
                    'password' => $password,
                    'role' => 'educateur'
                ];

                $userModel = new User();
                if ($userModel->create($data)) {
                    $_SESSION['success'] = "Compte créé avec succès";
                    header('Location: index.php?page=login');
                    exit;
                }
            } catch (Exception $e) {
                $errors[] = "Erreur lors de la création du compte: " . $e->getMessage();
            }
        }
    }

// affiche formulaire
include_once __DIR__ . '/../views/sections/register.php';