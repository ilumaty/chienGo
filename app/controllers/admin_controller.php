<?php
    // autoload
    use app\models\User;
    use app\models\TypeSeance;

    // vérifie la connexion et du rôle admin
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: index.php?page=login&error=unauthorized');
            exit;
        }

    $action = $_GET['action'] ?? 'dashboard';
    $errors = [];
    $success = '';

    try {
        switch ($action) {
            case 'dashboard':
                // dashboard admin
                $userModel = new User();
                $typeSeanceModel = new TypeSeance();

                $totalUsers = count($userModel->getAll());
                $totalEducateurs = count($userModel->getEducateurs());
                $totalTypesSeances = count($typeSeanceModel->findAll());

                break;

            case 'users':
                // gestion des users
                $userModel = new User();
                $users = $userModel->getAll();
                break;

            case 'types_seances':
                // gestion des types de séances
                $typeSeanceModel = new TypeSeance();
                $typeAction = $_GET['type_action'] ?? 'list';

                switch ($typeAction) {
                    case 'list':
                        $typesSeances = $typeSeanceModel->findAll();
                        break;

                    case 'edit':
                        $typeId = (int)($_GET['type_id'] ?? 0);
                        $typeSeance = $typeSeanceModel->findById($typeId);

                        if (!$typeSeance) {
                            throw new RuntimeException("Type de séance non trouvé");
                        }

                        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                            try {
                                $data = [
                                    'nom' => trim($_POST['nom']),
                                    'description' => trim($_POST['description'] ?? ''),
                                    'duree_minutes' => (int)($_POST['duree_minutes'] ?? 60),
                                    'prix' => !empty($_POST['prix']) ? (float)$_POST['prix'] : null,
                                    'couleur' => $_POST['couleur'] ?? '#3B82F6'
                                ];

                                if ($typeSeanceModel->update($typeId, $data)) {
                                    $_SESSION['success'] = "Type de séance modifié avec succès";
                                    header('Location: ' . URL_ADMIN_TYPES_SEANCES);
                                    exit;
                                }
                                throw new RuntimeException("Erreur lors de la modification");

                            } catch (Exception $e) {
                                $errors[] = $e->getMessage();
                            }
                        }
                        break;

                    case 'create':
                        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                            try {
                                $data = [
                                    'nom' => trim($_POST['nom']),
                                    'description' => trim($_POST['description'] ?? ''),
                                    'duree_minutes' => (int)($_POST['duree_minutes'] ?? 60),
                                    'prix' => !empty($_POST['prix']) ? (float)$_POST['prix'] : null,
                                    'couleur' => $_POST['couleur'] ?? '#3B82F6'
                                ];

                                if ($typeSeanceModel->create($data)) {
                                    $_SESSION['success'] = "Type de séance créé avec succès";
                                    header('Location: ' . URL_ADMIN_TYPES_SEANCES);
                                    exit;
                                }
                                throw new RuntimeException("Erreur lors de la création");

                            } catch (Exception $e) {
                                $errors[] = $e->getMessage();
                            }
                        }
                        break;

                    case 'delete':
                        $typeId = (int)($_GET['type_id'] ?? 0);

                        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                            try {
                                if ($typeSeanceModel->delete($typeId)) {
                                    $_SESSION['success'] = "Type de séance supprimé avec succès";
                                }
                            } catch (Exception $e) {
                                $_SESSION['error'] = $e->getMessage();
                            }
                            header('Location: ' . URL_ADMIN_TYPES_SEANCES);
                            exit;
                        }

                        $typeSeance = $typeSeanceModel->findById($typeId);
                        if (!$typeSeance) {
                            throw new RuntimeException("Type de séance non trouvé");
                        }
                        break;
                }
                break;

            default:
                header('Location: ' . URL_ADMIN_DASHBOARD);
                exit;
        }

    } catch (Exception $e) {
        $errors[] = $e->getMessage();
    }

    // msg de succès/erreur depuis les redirections
    if (isset($_SESSION['success'])) {
        $success = $_SESSION['success'];
        unset($_SESSION['success']);
    }

    if (isset($_GET['error'])) {
        $errors[] = $_GET['error'];
    }

    // inclue la vue appropriée
    $pageTitle = "Administration || ChienGo";

    switch ($action) {
        case 'users':
            include_once __DIR__ . '/../views/admin/users.php';
            break;
        case 'types_seances':
            include_once __DIR__ . '/../views/admin/types_seances.php';
            break;
        default:
            include_once __DIR__ . '/../views/admin/dashboard.php';
            break;
    }