<?php

    /**
     * ════════════════════════════════════════════════════════════════════════════════
     *                           CHIENS CONTRÔLEUR
     * ════════════════════════════════════════════════════════════════════════════════
     *
     * - Création de nouveaux profils de chiens
     * - Modification des informations d'un chien existant
     * - Suppression de chiens avec vérifications de sécurité
     * - Contrôles d'accès et validation des droits éducateur
     * - Gestion des redirections et messages de confirmation
     *
     * @package ChienGo
     * @subpackage Controllers
     * @author Corfù
     * @version 1.0.0
     * @since 2025-July-09
    */

    //autoload
    use app\models\Chien;
    use app\models\Client;

    // vérification de la connexion
    if (!isset($_SESSION['user'])) {
        header('Location: index.php?page=login');
        exit;
    }

    $chienModel = new Chien();
    $clientModel = new Client();
    $action = $_GET['action'] ?? 'create';
    $errors = [];
    $success = '';

    /**
     * Routeur principal : dispatch des actions CRUD
     *
     * - create : Création d'un nouveau chien
     * - update : Modification d'un chien existant
     * - delete : Suppression avec vérifications
     */
    try {
        switch ($action) {
            case 'create':
                // créer un chien – traitement POST uniquement
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    try {
                        // vérifier que le client appartient à l'éducateur
                        $client = $clientModel->findById($_POST['client_id'], $_SESSION['user']['id']);
                        if (!$client) {
                            throw new RuntimeException("Client non trouvé ou accès non autorisé");
                        }

                        $data = [
                            'nom' => $_POST['nom'],
                            'race' => $_POST['race'] ?? '',
                            'age' => $_POST['age'] ?: null,
                            'poids' => $_POST['poids'] ?: null,
                            'couleur' => $_POST['couleur'] ?? '',
                            'sexe' => $_POST['sexe'] ?: null,
                            'caractere' => $_POST['caractere'] ?? '',
                            'problemes_comportement' => $_POST['problemes_comportement'] ?? '',
                            'client_id' => $_POST['client_id']
                        ];

                        if ($chienModel->create($data)) {
                            $_SESSION['success'] = "Chien créé avec succès";
                        }
                    } catch (Exception $e) {
                        $_SESSION['error'] = $e->getMessage();
                    }

                    header('Location: ' . URL_CLIENTS_VIEW . $_POST['client_id']);
                    exit;
                }

                // si ce n'est pas un POST, afficher le formulaire
                if (!empty($_GET['client_id'])) {
                    $client = $clientModel->findById($_GET['client_id'], $_SESSION['user']['id']);
                    if (!$client) {
                        $_SESSION['error'] = "Client non trouvé ou accès non autorisé";
                        header('Location: ' . URL_CLIENTS_LIST);
                        exit;
                    }
                    include __DIR__ . '/../views/chien/create.php';
                    exit;
                }
                $_SESSION['error'] = "Client non précisé";
                header('Location: ' . URL_CLIENTS_LIST);
                exit;

            case 'update':
                // modifier un chien, traitement POST uniquement
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $id = $_POST['chien_id'] ?? 0;
                    $clientId = $_POST['client_id'] ?? null;

                    try {
                        $chien = $chienModel->findById($id);
                        if (!$chien) {
                            throw new RuntimeException("Chien non trouvé");
                        }

                        $clientId = $chien['client_id'];

                        // vérifier l'accès
                        $client = $clientModel->findById($chien['client_id'], $_SESSION['user']['id']);
                        if (!$client) {
                            throw new RuntimeException("Accès non autorisé");
                        }

                        $data = [
                            'nom' => $_POST['nom'],
                            'race' => $_POST['race'],
                            'age' => $_POST['age'] ?: null,
                            'poids' => $_POST['poids'] ?: null,
                            'couleur' => $_POST['couleur'],
                            'sexe' => $_POST['sexe'] ?: null,
                            'caractere' => $_POST['caractere'],
                            'problemes_comportement' => $_POST['problemes_comportement']
                        ];

                        if ($chienModel->update($id, $data)) {
                            $_SESSION['success'] = "Chien modifié avec succès";
                        }
                    } catch (Exception $e) {
                        $_SESSION['error'] = $e->getMessage();
                    }

                    header('Location: ' . URL_CLIENTS_VIEW . $clientId);
                    exit;
                }
                break;

            case 'delete':
                // supprimer un chien
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $id = $_POST['chien_id'] ?? 0;
                    $clientId = $_POST['client_id'] ?? 1;

                    try {
                        $chien = $chienModel->findById($id);
                        if (!$chien) {
                            throw new RuntimeException("Chien non trouvé");
                        }

                        $clientId = $chien['client_id'];

                        // vérifier l'accès
                        $client = $clientModel->findById($chien['client_id'], $_SESSION['user']['id']);
                        if (!$client) {
                            throw new RuntimeException("Accès non autorisé");
                        }

                        $clientId = $chien['client_id'];

                        if ($chienModel->delete($id)) {
                            $_SESSION['success'] = "Chien supprimé avec succès";
                        }

                        header('Location: ' . URL_CLIENTS_VIEW . $clientId);
                        exit;
                    } catch (Exception $e) {
                        $_SESSION['error'] = $e->getMessage();
                        header('Location: ' . URL_CLIENTS_VIEW . $clientId);
                        exit;
                    }
                }
                break;

            default:
                // par défaut redirige vers la liste des clients
                header('Location: ' . URL_CLIENTS_LIST);
                exit;
        }

    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
        header('Location: ' . URL_CLIENTS_LIST);
        exit;
    }