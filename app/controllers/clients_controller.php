<?php

    /**
     * ════════════════════════════════════════════════════════════════════════════════
     *                          CLIENTS CONTRÔLEUR
     * ════════════════════════════════════════════════════════════════════════════════
     *
     * - Affichage de la liste des clients avec recherche
     * - Visualisation détaillée d'un client et ses chiens
     * - Création, modification et suppression de clients
     * - Validation des données et gestion des doublons email
     * - Contrôles d'accès et de sécurité
     *
     * @package ChienGo
     * @subpackage Controllers
     * @author Corfù
     * @version 1.0.0
     * @since 2025-July-09
     */

    //autoload
        use app\models\client;
        use app\models\chien;

    // vérification de la connexion
    if (!isset($_SESSION['user'])) {
        header('Location: index.php?page=login');
        exit;
    }

    $clientModel = new client();
    $chienModel = new chien();
    $action = $_GET['action'] ?? 'list';
    $errors = [];
    $success = '';

    /**
     * Routeur principal : dispatch des actions CRUD
     *
     * - list : Affichage de la liste avec recherche
     * - view : Détail d'un client et ses chiens
     * - create : Création d'un nouveau client
     * - edit : Modification d'un client existant
     * - delete : Suppression avec confirmation
     */
    try {
        switch ($action) {
            case 'list':
                // liste des clients
                $search = $_GET['search'] ?? '';
                if (!empty($search)) {
                    $clients = $clientModel->search($search, $_SESSION['user']['id']);
                } else {
                    $clients = $clientModel->findByUserId($_SESSION['user']['id']);
                }
                break;

            case 'view':
                // voir un client
                $id = $_GET['id'] ?? 0;

                $client = $clientModel->findById($id, $_SESSION['user']['id']);
                if (!$client) {
                    throw new RuntimeException("Client non trouvé");
                }
                $chiens = $chienModel->findByClientId($id);
                break;

            case 'create':
                // créer un client
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    try {
                        $data = [
                            'nom' => $_POST['nom'],
                            'prenom' => $_POST['prenom'],
                            'email' => $_POST['email'],
                            'telephone' => $_POST['telephone'],
                            'adresse' => $_POST['adresse'],
                            'ville' => $_POST['ville'],
                            'code_postal' => $_POST['code_postal'],
                            'notes' => $_POST['notes'],
                            'user_id' => $_SESSION['user']['id']
                        ];

                        // vérifier email unique
                        if (!empty($data['email']) && $clientModel->emailExists($data['email'], $_SESSION['user']['id'])) {
                            throw new RuntimeException("Cette adresse email est déjà utilisée");
                        }

                        if ($clientModel->create($data)) {
                            $_SESSION['success'] = "Client créé avec succès";
                            header('Location: ' . URL_CLIENT_LIST);
                            exit;
                        }
                    } catch (Exception $e) {
                        $errors[] = $e->getMessage();
                    }
                }
                break;

            case 'edit':
                // modifier un client
                $id = $_GET['id'] ?? 0;

                $client = $clientModel->findById($id, $_SESSION['user']['id']);
                if (!$client) {
                    throw new RuntimeException("Client non trouvé");
                }

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    try {
                        $data = [
                            'nom' => $_POST['nom'],
                            'prenom' => $_POST['prenom'],
                            'email' => $_POST['email'],
                            'telephone' => $_POST['telephone'],
                            'adresse' => $_POST['adresse'],
                            'ville' => $_POST['ville'],
                            'code_postal' => $_POST['code_postal'],
                            'notes' => $_POST['notes']
                        ];

                        // vérifier email unique (exclure le client actuel)
                        if (!empty($data['email']) && $clientModel->emailExists($data['email'], $_SESSION['user']['id'], $id)) {
                            throw new RuntimeException("Cette adresse email est déjà utilisée");
                        }

                        if ($clientModel->update($id, $data, $_SESSION['user']['id'])) {
                            $_SESSION['success'] = "Client modifié avec succès";
                            header('Location: ' . URL_CLIENTS_VIEW . $id);
                            exit;
                        }
                    } catch (Exception $e) {
                        $errors[] = $e->getMessage();
                    }
                }
                break;

            case 'delete':
                // delete un client
                $id = $_GET['id'] ?? 0;

                // afficher la confirmation de suppression
                $client = $clientModel->findById($id, $_SESSION['user']['id']);
                if (!$client) {
                    throw new RuntimeException("Client non trouvé");
                }

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    try {
                        if ($clientModel->delete($id, $_SESSION['user']['id'])) {
                            $_SESSION['success'] = "Client supprimé avec succès";
                            header('Location: ' . URL_CLIENTS_LIST);
                            exit;
                        }
                    } catch (Exception $e) {
                        $errors[] = $e->getMessage();
                        // rediriger vers la vue du client en cas d'erreur
                        header('Location: ' . URL_CLIENTS_VIEW . $id . '&error=' . urlencode($e->getMessage()));
                        exit;
                    }
                }

                break;

            default:
                header('Location: ' . URL_CLIENTS_LIST);
                exit;
        }

    } catch (Exception $e) {
        $errors[] = $e->getMessage();
        if ($action !== 'list') {
            header('Location: ' . URL_CLIENTS_WITH_ERROR . urlencode($e->getMessage()));
            exit;
        }
    }

    // messages de succès/erreur depuis les redirections
    if (isset($_SESSION['success'])) {
        $success = $_SESSION['success'];
        unset($_SESSION['success']);
    }

    if (isset($_GET['error'])) {
        $errors[] = $_GET['error'];
    }

    // inclure la vue appropriée
    $pageTitle = "Gestion des Clients || ChienGo";
    switch ($action) {
        case 'view':
            include_once __DIR__ . '/../views/clients/view.php';
            break;
        case 'create':
            include_once __DIR__ . '/../views/clients/create.php';
            break;
        case 'edit':
            include_once __DIR__ . '/../views/clients/edit.php';
            break;
        case 'delete':
            include_once __DIR__ . '/../views/clients/delete.php';
            break;
        default:
            include_once __DIR__ . '/../views/clients/index.php';
    }