<?php

    /**
     * ════════════════════════════════════════════════════════════════════════════════
     *                             DÉCONNEXION CONTRÔLEUR
     * ════════════════════════════════════════════════════════════════════════════════
     *
     * - Vérification de l'authentification utilisateur
     * - Destruction complète et sécurisée de la session
     * - Suppression des cookies de session
     * - Logging des déconnexions pour audit
     * - Redirection avec message de confirmation
     *
     * @package ChienGo
     * @subpackage Controllers
     * @author Corfù
     * @version 1.0.0
     * @since 2025-July-09
     */

    // vérifie que l'utilisateur est bien connecté
    if (!isset($_SESSION['user'])) {
        // si pas connecté, redirige vers la page de connexion
        header('Location: index.php?page=login');
        exit;
    }

    // var pour les messages
    $errors = [];
    $success = '';

    // traite la déconnexion
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {
            // log de la déconnexion
            $userId = $_SESSION['user']['id'] ?? 'unknown';
            $userName = $_SESSION['user']['nom'] ?? 'Utilisateur';

            error_log("Déconnexion utilisateur: ID $userId ($userName) - " . date('Y-m-d H:i:s'));

            // destructure complète de la session

            // 1. vide les variables de session
            $_SESSION = [];

            // 2. détruis le cookie de session s'il existe
            if (ini_get("session.use_cookies")) {
                $params = session_get_cookie_params();
                setcookie(session_name(), '', time() - 42000,
                    $params["path"], $params["domain"],
                    $params["secure"], $params["httponly"]
                );
            }

            // 3. détruie la session
            session_destroy();

            // 4. reboot une nouvelle session pour les messages flash
            session_start();
            $_SESSION['logout_success'] = "Vous avez été déconnecté avec succès. À bientôt !";

            // 5. redirige vers la page de connexion
            header('Location: index.php?page=login');
            exit;

        } catch (Exception $e) {
            error_log("Erreur lors de la déconnexion: " . $e->getMessage());
            $errors[] = "Erreur lors de la déconnexion. Veuillez réessayer.";
        }
    }

    // si on arrive ici par GET cela affiche la page de confirmation
    $pageTitle = "Déconnexion || ChienGo";
    include_once __DIR__ . '/../views/sections/logout.php';