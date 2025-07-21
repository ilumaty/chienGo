<?php

    /**
     * ════════════════════════════════════════════════════════════════════════════════
     *                            CONNEXION CONTRÔLEUR
     * ════════════════════════════════════════════════════════════════════════════════
     *
     * - Validation des identifiants utilisateur
     * - Gestion des sessions et cookies "Se souvenir de moi"
     * - Redirection intelligente après connexion
     * - Logging des tentatives de connexion pour sécurité
     * - Gestion des messages d'erreur et de succès
     *
     * @package ChienGo
     * @subpackage Controllers
     * @author Corfù
     * @version 1.0.0
     * @since 2025-July-09
     */

    //autoload
    use app\models\User;

    $errors = [];
    $success = '';
    $pageTitle = "Connexion - ChienGo";

    // si l'utilisateur est déjà connecté redirection vers le dashboard
    if (isset($_SESSION['user'])) {
        header('Location: index.php?page=dashboard');
        exit;
    }

    // msg de succès après déconnexion
    if (isset($_SESSION['logout_success'])) {
        $success = $_SESSION['logout_success'];
        unset($_SESSION['logout_success']);
    }

    // msg d'info selon les paramètres GET
    if (isset($_GET['info'])) {
        switch ($_GET['info']) {
            case 'session_expired':
                $errors[] = "Votre session a expiré. Veuillez vous reconnecter.";
                break;
            case 'unauthorized':
                $errors[] = "Accès non autorisé. Veuillez vous connecter.";
                break;
            case 'required':
                $errors[] = "Vous devez être connecté pour accéder à cette page.";
                break;
        }
    }

    // traitement du form
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $remember_me = !empty($_POST['remember-me']);

        // gestion des erreurs
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Adresse email invalide.";
        }

        if (empty($password)) {
            $errors[] = "Mot de passe requis.";
        }

        // si tout est valide
        if (empty($errors)) {
            try {
                // Crée une instance de User
                $userModel = new User();

                // recherche l'utilisateur par email
                $user = $userModel->findByEmail($email);

                if ($user && User::verifyPassword($password, $user['password'])) {
                    // Connexion réussie
                    $_SESSION['user'] = [
                        'id' => $user['id'],
                        'nom' => $user['nom'],
                        'prenom' => $user['prenom'],
                        'email' => $user['email'],
                        'role' => $user['role'],
                        'telephone' => $user['telephone'] ?? '',
                        'ville' => $user['ville'] ?? '',
                        'login_time' => time()
                    ];

                    // Gestion du "Se souvenir de moi"
                    if ($remember_me) {
                        // Durée du cookie : 30 jours
                        $cookieLifetime = 30 * 24 * 60 * 60;
                        setcookie(session_name(), session_id(), time() + $cookieLifetime, '/');
                        $_SESSION['remember_me'] = true;
                    }

                    // MAJ dernière connexion via l'instance
                    $userModel->updateLastLogin($user['id']);

                    // Log de connexion réussie
                    error_log("Connexion réussie: {$user['email']} (ID: {$user['id']}) - " . date('Y-m-d H:i:s'));

                    // Redirection sécurisée
                    $redirect = $_GET['redirect'] ?? 'dashboard';
                    $allowedRedirects = ['dashboard', 'seances', 'clients'];
                    $redirect = in_array($redirect, $allowedRedirects, true) ? $redirect : 'dashboard';

                    header("Location: index.php?page=$redirect");
                    exit;

                }

                $errors[] = "Identifiants incorrects.";
                error_log("Tentative de connexion échouée pour: $email - " . date('Y-m-d H:i:s'));
            } catch (Exception $e) {
                error_log("Erreur login: " . $e->getMessage());
                $errors[] = "Erreur de connexion. Veuillez réessayer.";
            }
        }
    }

    // affichage du form
    include_once __DIR__ . '/../views/sections/login.php';
