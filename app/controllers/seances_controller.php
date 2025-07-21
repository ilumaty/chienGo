<?php

    /**
     * ════════════════════════════════════════════════════════════════════════════════
     *                               SÉANCES CONTRÔLEUR
     * ════════════════════════════════════════════════════════════════════════════════
     *
     *  Affichage public des séances et tarifs
     * - Création, modification, suppression de séances (users connectés)
     * - Gestion du planning et détection des conflits d'horaires
     * - Interface AJAX pour la sélection dynamique des chiens
     *
     * @package ChienGo
     * @subpackage Controllers
     * @author Corfù
     * @version 1.0.0
     * @since 2025-July-09
     */

    //autoload
    use app\models\Seance;
    use app\models\Client;
    use app\models\Chien;
    use app\models\TypeSeance;

    $action = $_GET['action'] ?? 'public';
    $errors = [];
    $success = '';


    /**
    * Construit un tableau de données de séance à partir des données POST
    *
     * Fonction centralise la récupération et le formatage des données
    * de formulaire pour éviter la duplication de code entre create/edit.
     *
     * @return array Tableau associatif contenant les données de la séance
    * @throws RuntimeException Si des données obligatoires sont manquantes
    */
    function buildSeanceDataFromPost(): array
    {
        return [
            'titre' => trim($_POST['titre'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'date_seance' => $_POST['date_seance'] ?? '',
            'duree_minutes' => (int)($_POST['duree_minutes'] ?? 60),
            'prix' => !empty($_POST['prix']) ? (float)$_POST['prix'] : null,
            'statut' => $_POST['statut'] ?? 'planifiee',
            'lieu' => trim($_POST['lieu'] ?? ''),
            'notes_educateur' => trim($_POST['notes_educateur'] ?? ''),
            'user_id' => $_SESSION['user']['id'],
            'client_id' => (int)($_POST['client_id'] ?? 0),
            'chien_id' => (int)($_POST['chien_id'] ?? 0),
            'type_seance_id' => !empty($_POST['type_seance_id']) ? (int)$_POST['type_seance_id'] : null
        ];
    }

    try {
        /**
         * Contrôle d'accès : vérification de l'authentification
         *
         * Les actions publiques (public, list-public) sont accessibles à tous.
         * Toutes les autres actions nécessitent une session users active.
         */
        if (empty($_SESSION['user']) && !in_array($action, ['public', 'list-public'])) {
            header('Location: index.php?page=login');
            exit;
        }

    // initialisation des modèles
    $seanceModel = new Seance();
    $clientModel = new Client();
    $chienModel = new Chien();
    $typeSeanceModel = new TypeSeance();

    /**
    * Routeur principal : dispatch des actions selon le paramètre GET
    **
     * - public/list-public : Affichage public des séances
     * - list : Liste des séances pour l'éducateur connecté
     * - view : Détail d'une séance
     * - create : Création d'une nouvelle séance
     * - edit : Modification d'une séance existante
     * - delete : Suppression d'une séance
     * - ajax_chiens : API JSON pour récupérer les chiens d'un client
    */
    switch ($action) {
        case 'public':
        case 'list-public':
            $pageTitle = "Nos Séances d'Éducation Canine || ChienGo";
            include_once __DIR__ . '/../views/sections/seances.php';
            break;

        case 'list':
            $filters = [];
            if (!empty($_GET['statut'])) {
                $filters['statut'] = $_GET['statut'];
            }
            if (!empty($_GET['client_id'])) {
                $filters['client_id'] = $_GET['client_id'];
            }
            if (!empty($_GET['date_debut'])) {
                $filters['date_debut'] = $_GET['date_debut'] . ' 00:00:00';
            }
            if (!empty($_GET['date_fin'])) {
                $filters['date_fin'] = $_GET['date_fin'] . ' 23:59:59';
            }

            $seances = $seanceModel->findByUserId($_SESSION['user']['id'], $filters);
            $clients = $clientModel->findByUserId($_SESSION['user']['id']);
            $seancesToday = $seanceModel->findToday($_SESSION['user']['id']);
            $seancesUpcoming = $seanceModel->findUpcoming($_SESSION['user']['id']);
            include_once __DIR__ . '/../views/seances/list.php';
            break;

        case 'view':
            $id = (int)($_GET['id'] ?? 0);
            $seance = $seanceModel->findById($id, $_SESSION['user']['id']);
            if (!$seance) {
                throw new RuntimeException("Séance non trouvée");
            }
            $typeDetails = null;
            if (!empty($seance['type_seance_id'])) {
                $typeDetails = $typeSeanceModel->findById($seance['type_seance_id']);
            }
            include_once __DIR__ . '/../views/seances/view.php';
            break;

        case 'create':

            $clients = $clientModel->findByUserId($_SESSION['user']['id']);
            $typesSeances = $typeSeanceModel->findAll();
            $preselectedClient = $_GET['client_id'] ?? null;
            $preselectedChien = $_GET['chien_id'] ?? null;
            $chiensClient = [];

            if ($preselectedChien) {
                $chien = $chienModel->findById($preselectedChien);
                if ($chien) {
                    $preselectedClient = $chien['client_id'];
                    $chiensClient = [$chien];
                }
            } else if ($preselectedClient) {
                $chiensClient = $chienModel->findByClientId($preselectedClient);
            }

            $seancesUpcoming = $seanceModel->findUpcoming($_SESSION['user']['id']);


            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                try {
                    $data = buildSeanceDataFromPost();

                    if (empty($data['titre'])) {
                        throw new RuntimeException("Le titre est requis");
                    }
                    if (empty($data['date_seance'])) {
                        throw new RuntimeException("La date est requise");
                    }
                    if (empty($data['client_id']) || empty($data['chien_id'])) {
                        throw new RuntimeException("Client et chien sont requis");
                    }

                    if ($seanceModel->create($data)) {
                        $_SESSION['success'] = "Séance créée avec succès";
                        header('Location: index.php?page=seances&action=list');
                        exit;
                    }

                    throw new RuntimeException("Erreur lors de la création de la séance");
                } catch (Exception $e) {
                    $errors[] = $e->getMessage();
                }
            }

            include_once __DIR__ . '/../views/seances/create.php';
            break;

        case 'edit':
            $id = (int)($_GET['id'] ?? 0);
            $seance = $seanceModel->findById($id, $_SESSION['user']['id']);
            if (!$seance) {
                throw new RuntimeException("Séance introuvable");
            }

            $clients = $clientModel->findByUserId($_SESSION['user']['id']);
            $typesSeances = $typeSeanceModel->findAll();
            $chiensClient = $chienModel->findByClientId($seance['client_id']);

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                try {
                    $data = buildSeanceDataFromPost();

                    if ($seanceModel->update($id, $data, $_SESSION['user']['id'])) {
                        $_SESSION['success'] = "Séance modifiée avec succès";
                        header("Location: ". URL_SEANCES_VIEW . $id);
                        exit;
                    }

                    throw new RuntimeException("Erreur lors de la mise à jour");
                } catch (Exception $e) {
                    $errors[] = $e->getMessage();
                }
            }
            include_once __DIR__ . '/../views/seances/edit.php';
            break;

        case 'delete':
            $id = (int)($_GET['id'] ?? 0);
            $seance = $seanceModel->findById($id, $_SESSION['user']['id']);
            if (!$seance) {
                throw new RuntimeException("Séance non trouvée");
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                try {
                    // vérifie la confirmation
                    if (empty($_POST['confirmation'])) {
                        throw new RuntimeException("Veuillez confirmer la suppression");
                    }

                    if ($seanceModel->delete($id, $_SESSION['user']['id'])) {
                        $_SESSION['success'] = "Séance supprimée avec succès";
                        header('Location: index.php?page=seances&action=list');
                        exit;
                    }

                    throw new RuntimeException("Erreur lors de la suppression");
                } catch (Exception $e) {
                    $errors[] = $e->getMessage();
                }
            }

            include_once __DIR__ . '/../views/seances/delete.php';
            break;

        case 'ajax_chiens':
            header('Content-Type: application/json');
            $clientId = (int)($_GET['client_id'] ?? 0);
            try {
                $chiens = $chienModel->findByClientId($clientId);
                echo json_encode($chiens, JSON_THROW_ON_ERROR);
            } catch (Exception $e) {
                echo json_encode(['error' => $e->getMessage()], JSON_THROW_ON_ERROR);
            }
            exit;

        default:
            throw new RuntimeException('Unexpected value');
    }

    } catch (Exception $e) {
        /**
         * Gestionnaire d'erreurs global
         */
        $errors[] = $e->getMessage();
        error_log("Erreur dans seances_controller.php: " . $e->getMessage());
    }