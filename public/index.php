<?php

    /**
     * ════════════════════════════════════════════════════════════════════════════════
     *                          ROUTEUR PRINCIPAL - ChienGo
     * ════════════════════════════════════════════════════════════════════════════════
     *
     *
     * PAGES PUBLIC :
     * - Accueil et présentation des services
     * - Inscription et connexion des éduc
     * - Gestion des erreurs 404 personnalisées
     *
     * PAGES PRIVÉES (éduc connectés) :
     * - Dashboard avec statistiques
     * - Gestion des clients et chiens
     * - Planning et organisation des séances
     *
     *  ADMINISTRATION (Admins uniquement) :
     *  - Dashboard administrateur avec statistiques globales
     *  - Gestion des utilisateurs (éduc et admins)
     *  - Configuration des types de séances (prix, durées, couleurs)
     *  - Interface sécurisée avec contrôle d'accès par rôles
     *
     * FONCTIONNALITÉS :
     * - Autoloading PSR-4 avec Composer - MVC
     * - Gestion centralisée des erreurs avec mode débug
     * - Mode debug pour le développement
     * - Routage sécurisé avec validation d'accès
     *
     * @package ChienGo
     * @author Corfù
     * @version 1.0.0
     * @since 2025-July-09
     * @updated 2025-07-10 add panel administration
     */

    // autoloader
    require_once __DIR__ . '/../vendor/autoload.php';

    // config
    require_once __DIR__ . '/../app/config/config.php';

    // récupération de la page
    $page = $_GET['page'] ?? 'sections';

    // router principal
    try {
        switch ($page) {
            // pages publiques
            case 'sections':
            case 'home':
                include_once __DIR__ . '/../app/controllers/home_controller.php';
                break;

            case 'login':
                include_once __DIR__ . '/../app/controllers/login_controller.php';
                break;

            case 'register':
                include_once __DIR__ . '/../app/controllers/register_controller.php';
                break;

            case 'about':
            case 'contact':
                // pages pas encore dév = error 404
                http_response_code(404);
                $pageTitle = "Page non trouvée || ChienGo";
                include_once __DIR__ . '/../app/views/errors/404.php';
                break;

            case 'logout':
                // vérifie si l'utilisateur est connecté
                if (!isset($_SESSION['user'])) {
                    header('Location: index.php?page=login');
                    exit;
                }

                // si c'est POST, déconnecter
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    session_unset();
                    session_destroy();

                    // reboot pour les msg
                    session_start();
                    $_SESSION['logout_success'] = "Vous avez été déconnecté avec succès !";

                    header('Location: index.php?page=login');
                    exit;
                }

                // sinon afficher la page de confirmation
                $pageTitle = "Déconnexion || ChienGo";
                include_once __DIR__ . '/../app/views/sections/logout.php';
                break;

            // pages d'administration (with connexion)
            case 'dashboard':
                include_once __DIR__ . '/../app/controllers/dashboard_controller.php';
                break;

            case 'clients':
                include_once __DIR__ . '/../app/controllers/clients_controller.php';
                break;

            case 'chiens':
                include_once __DIR__ . '/../app/controllers/chiens_controller.php';
                break;

            case 'seances':
                include_once __DIR__ . '/../app/controllers/seances_controller.php';
                break;

            case 'admin':
                include_once __DIR__ . '/../app/controllers/admin_controller.php';
                break;

            default:
                // page 404
                http_response_code(404);
                $pageTitle = "Page non trouvée || ChienGo";
                include_once __DIR__ . '/../app/views/errors/404.php';
                break;
        }


    } catch (Exception $e) {
        // gestion des erreurs globales
        if (defined('APP_DEBUG') && APP_DEBUG) {
            // en mode debug, afficher l'erreur
            echo "<div style='background: #ffebee; border: 1px solid #f44336; padding: 15px; margin: 15px; border-radius: 5px; font-family: Arial, sans-serif;'>";
            echo "<h1 style='color: #d32f2f; margin-top: 0;'>❌ Erreur de l'application</h1>";
            echo "<p><strong>Message:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
            echo "<p><strong>Fichier:</strong> " . htmlspecialchars($e->getFile()) . " (ligne " . $e->getLine() . ")</p>";
            echo "<h3>Stack trace:</h3>";
            echo "<pre style='background: #f5f5f5; padding: 10px; overflow-x: auto;'>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
            echo "</div>";
        } else {
            // en prod, afficher une erreur générique
            http_response_code(500);
            echo "<!DOCTYPE html>";
            echo "<html><head><title>Erreur - ChienGo</title></head>";
            echo "<body style='font-family: Arial, sans-serif; text-align: center; padding: 50px;'>";
            echo "<h1>Erreur temporaire</h1>";
            echo "<p>Une erreur inattendue s'est produite. Veuillez réessayer plus tard.</p>";
            echo "<a href='index.php' style='color: #ce7c5e;'>← Retour à l'accueil</a>";
            echo "</body></html>";
        }
    }