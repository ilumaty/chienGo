<?php

    /**
     * ════════════════════════════════════════════════════════════════════════════════
     *                            DASHBOARD CONTRÔLEUR
     * ════════════════════════════════════════════════════════════════════════════════
     *
     * - Vérification de l'authentification et des rôles autorisés
     * - Récupération des statistiques en temps réel
     * - Calcul des métriques d'activité (séances, clients, revenus)
     * - Affichage personnalisé selon le rôle utilisateur
     *
     * @package ChienGo
     * @subpackage Controllers
     * @author Corfù
     * @version 1.0.0
     * @since 2025-July-09
     */

    // autoload
    use app\models\Seance;
    use app\models\Client;

    // check l'user est connecté
    if (!isset($_SESSION['user'])) {
        header('Location: index.php?page=login');
        exit;
    }

    $user = $_SESSION['user'];
    $pageTitle = "Dashboard - ChienGo";

    // défini les rôles autorisés
    $allowedRoles = ['admin', 'educateur'];
    $userRole = $user['role'] ?? 'guest';

    if (!in_array($userRole, $allowedRoles, true)) {
        header('Location: index.php?page=login&error=unauthorized');
        exit;
    }

    // logic dashboard selon le rôle
    $isAdmin = ($user['role'] === 'admin');
    $isEducateur = ($user['role'] === 'educateur');

    // initialisation variables par défaut
    $nbSeancesToday = 0;
    $nbSeancesWeek = 0;
    $nbClients = 0;
    $revenu = 0;

    // récupère les states avec autoload
    try {

        $seanceModel = new Seance();
        $clientModel = new Client();

        $nbSeancesToday = $seanceModel->countToday($_SESSION['user']['id']);
        $nbSeancesWeek = $seanceModel->countThisWeek($_SESSION['user']['id']);
        $revenu = $seanceModel->sumRevenue($_SESSION['user']['id']);
        $nbClients = Client::countActive($_SESSION['user']['id']);

    } catch (Exception $e) {
        error_log("Erreur dashboard: " . $e->getMessage());
    }

    // affichage de la vue dashboard
include_once __DIR__ . '/../views/dashboard.php';
