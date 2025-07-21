<?php
/**
 * ════════════════════════════════════════════════════════════════════════════════
 *                     OUTIL DE DIAGNOSTIC - ChienGo (DÉV)
 * ════════════════════════════════════════════════════════════════════════════════
 *
 * - Vérifier l'architecture et l'intégrité des fichiers
 * - Diagnostiquer les problèmes de configuration
 * - Tester les inclusions et le routing
 * - Valider le fonctionnement des contrôleurs admin
 *
 * Usage: Accéder à /public/diagno.php pendant le développement
 *
 * @package ChienGo
 * @author Corfù
 * @version 1.0.0
 * @since 2025-July-21
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

echo "<h1>Diagnostic ChienGo</h1>";

// Test 1: PHP de base
echo "<h2>✅ PHP fonctionne</h2>";
echo "<p>Version PHP: " . PHP_VERSION . "</p>";

// Test 2: Chemins
echo "<h2>Vérification des chemins</h2>";
echo "<p>Dossier actuel: " . __DIR__ . "</p>";
echo "<p>Dossier parent: " . dirname(__DIR__) . "</p>";

// Test 3: Fichiers de config
echo "<h2>Fichiers de configuration</h2>";
$configFiles = [
    '../app/config/config.php',
];

foreach ($configFiles as $file) {
    $path = __DIR__ . '/' . $file;
    $exists = file_exists($path);
    echo "<p>$file : " . ($exists ? '✅ Existe' : '❌ Manquant') . "</p>";

    if ($exists) {
        echo "<p style='margin-left: 20px; color: gray;'>Taille: " . filesize($path) . " octets</p>";

        // Test d'inclusion
        try {
            ob_start();
            include_once $path;
            ob_end_clean();
            echo "<p style='margin-left: 20px; color: green;'>✅ Inclusion OK</p>";
        } catch (Exception $e) {
            echo "<p style='margin-left: 20px; color: red;'>❌ Erreur inclusion: " . $e->getMessage() . "</p>";
        } catch (ParseError $e) {
            echo "<p style='margin-left: 20px; color: red;'>❌ Erreur de syntaxe: " . $e->getMessage() . "</p>";
        } catch (Error $e) {
            echo "<p style='margin-left: 20px; color: red;'>❌ Erreur fatale: " . $e->getMessage() . "</p>";
        }
    }
}

// Test 4: Contrôleurs
echo "<h2>Contrôleurs</h2>";
$controllers = [
    'home_controller.php',
    'login_controller.php',
    'dashboard_controller.php'
];

foreach ($controllers as $controller) {
    $path = __DIR__ . '/../app/controllers/' . $controller;
    $exists = file_exists($path);
    echo "<p>$controller : " . ($exists ? '✅ Existe' : '❌ Manquant') . "</p>";

    if ($exists) {
        echo "<p style='margin-left: 20px; color: gray;'>Taille: " . filesize($path) . " octets</p>";

        // Aperçu du contenu
        $content = file_get_contents($path, false, null, 0, 200);
        echo "<p style='margin-left: 20px; font-family: monospace; background: #f5f5f5; padding: 5px;'>" .
            htmlspecialchars(substr($content, 0, 100)) . "...</p>";
    }
}

// Test 5: Session
echo "<h2>Session</h2>";
try {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    echo "<p>✅ Session démarrée</p>";
    echo "<p>ID Session: " . session_id() . "</p>";
} catch (Exception $e) {
    echo "<p>❌ Erreur session: " . $e->getMessage() . "</p>";
}

// Test 6: Test d'inclusion simple
echo "<h2>Test d'inclusion</h2>";
$testFile = __DIR__ . '/../app/config/config.php';
if (file_exists($testFile)) {
    echo "<p>Test d'inclusion de config.php...</p>";
    try {
        ob_start();
        $error = error_get_last();
        require_once $testFile;
        $newError = error_get_last();

        if ($newError && $newError !== $error) {
            echo "<p style='color: red;'>⚠️ Avertissement: " . $newError['message'] . "</p>";
        } else {
            echo "<p style='color: green;'>✅ Config inclus sans erreur</p>";
        }

        // Vérifier si des constantes sont définies
        if (defined('BASE_URL')) {
            echo "<p>✅ BASE_URL défini: " . BASE_URL . "</p>";
        } else {
            echo "<p>⚠️ BASE_URL non défini</p>";
        }

        ob_end_clean();
    } catch (Exception $e) {
        ob_end_clean();
        echo "<p style='color: red;'>❌ Erreur: " . $e->getMessage() . "</p>";
    }

// Test 7: Diagnostic Admin Spécifique
    echo "<h2>🔧 Diagnostic Admin Spécifique</h2>";

// Test admin_controller
    $adminController = __DIR__ . '/../app/controllers/admin_controller.php';
    echo "<h3>admin_controller.php</h3>";
    if (file_exists($adminController)) {
        echo "<p>✅ admin_controller.php existe (" . filesize($adminController) . " octets)</p>";

        $content = file_get_contents($adminController);

        // Vérifications spécifiques
        $checks = [
            'case \'types_seances\':' => 'Gestion case types_seances',
            'switch ($action)' => 'Switch action final',
            'include_once __DIR__ . \'/../views/admin/types_seances.php\';' => 'Inclusion types_seances.php'
        ];

        foreach ($checks as $search => $description) {
            if (strpos($content, $search) !== false) {
                echo "<p style='margin-left: 20px; color: green;'>✅ $description</p>";
            } else {
                echo "<p style='margin-left: 20px; color: red;'>❌ $description MANQUANT</p>";
            }
        }

        // Affiche les dernières lignes
        echo "<h4>Dernières 20 lignes du admin_controller.php :</h4>";
        $lines = explode("\n", $content);
        $lastLines = array_slice($lines, -20);
        echo "<pre style='background: #f5f5f5; padding: 10px; border: 1px solid #ddd; max-height: 300px; overflow-y: auto;'>";
        foreach ($lastLines as $i => $line) {
            $lineNum = count($lines) - 20 + $i;
            echo sprintf("%3d: %s\n", $lineNum, htmlspecialchars($line));
        }
        echo "</pre>";

    } else {
        echo "<p>❌ admin_controller.php MANQUANT</p>";
    }


// Test views admin
    echo "<h3>Vues Admin</h3>";
    $adminViews = [
        'dashboard.php' => __DIR__ . '/../app/views/admin/dashboard.php',
        'users.php' => __DIR__ . '/../app/views/admin/users.php',
        'types_seances.php' => __DIR__ . '/../app/views/admin/types_seances.php'
    ];

    foreach ($adminViews as $name => $path) {
        if (file_exists($path)) {
            echo "<p>✅ $name existe (" . filesize($path) . " octets)</p>";
        } else {
            echo "<p>❌ $name MANQUANT : $path</p>";
        }
    }

// Test 8: Simulation du routing
    echo "<h2>Test de Routing Simulé</h2>";

// Simule les paramètres
    $_GET['page'] = 'admin';
    $_GET['action'] = 'types_seances';

    echo "<p>Simulation avec page=admin et action=types_seances</p>";

// Test du router index.php
    $indexPath = __DIR__ . '/index.php';
    if (file_exists($indexPath)) {
        $indexContent = file_get_contents($indexPath);

        if (strpos($indexContent, 'case \'admin\':') !== false) {
            echo "<p>✅ index.php contient case 'admin'</p>";
        } else {
            echo "<p>❌ index.php ne contient PAS case 'admin'</p>";
            echo "<p style='color: orange;'>🎯 PROBLÈME TROUVÉ : Ajoutez case 'admin' dans index.php</p>";
        }

        // Cherche la section switch dans index.php
        preg_match('/switch\s*\(\s*\$page\s*\)\s*\{(.*?)\}/s', $indexContent, $matches);
        if ($matches) {
            echo "<h4>Section switch de index.php :</h4>";
            echo "<pre style='background: #f0f8ff; padding: 10px; border: 1px solid #0066cc; max-height: 250px; overflow-y: auto;'>";
            echo htmlspecialchars($matches[0]);
            echo "</pre>";
        }
    }

// Test 9: Simulation d'exécution
    echo "<h2>Test d'Exécution Directe</h2>";

    try {
        // Prépare l'environnement
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['user'] = ['role' => 'admin', 'id' => 1, 'nom' => 'Test'];

        echo "<p>Tentative d'inclusion directe du admin_controller...</p>";

        // Capture la sortie
        ob_start();
        $errors = [];

        // Include config d'abord
        if (file_exists(__DIR__ . '/../app/config/config.php')) {
            include_once __DIR__ . '/../app/config/config.php';
        }

        // admin controller
        if (file_exists($adminController)) {
            include $adminController;
            echo "<p style='color: green;'>✅ admin_controller inclus avec succès</p>";
        } else {
            echo "<p style='color: red;'>❌ admin_controller introuvable</p>";
        }

        $output = ob_get_clean();

        echo "<h4>Résultat de l'inclusion :</h4>";
        echo "<pre style='background: #f8f8f8; padding: 10px; border: 1px solid #ccc; max-height: 300px; overflow-y: auto;'>";
        echo htmlspecialchars($output);
        echo "</pre>";

    } catch (Exception $e) {
        ob_end_clean();
        echo "<p style='color: red;'>❌ Exception : " . $e->getMessage() . "</p>";
        echo "<p style='color: red;'>Fichier : " . $e->getFile() . " ligne " . $e->getLine() . "</p>";
    } catch (Error $e) {
        ob_end_clean();
        echo "<p style='color: red;'>❌ Erreur fatale : " . $e->getMessage() . "</p>";
        echo "<p style='color: red;'>Fichier : " . $e->getFile() . " ligne " . $e->getLine() . "</p>";
    }

// Test final
    echo "<h2>Résumé du Diagnostic</h2>";
    echo "<ol>";
    echo "<li><strong>Étape 1 :</strong> Vérifiez que index.php contient 'case admin'</li>";
    echo "<li><strong>Étape 2 :</strong> Vérifiez que admin_controller.php se termine par le bon switch</li>";
    echo "<li><strong>Étape 3 :</strong> Vérifiez que types_seances.php existe dans views/admin/</li>";
    echo "</ol>";

    echo "<h3> Liens de test</h3>";
    echo "<p><a href='index.php?page=admin&action=dashboard'>Test : Dashboard Admin</a></p>";
    echo "<p><a href='index.php?page=admin&action=types_seances'>Test : Types Séances</a></p>";
    echo "<p><a href='index.php?page=admin&action=users'>Test : Gestion Users</a></p>";


}

echo "<h2>Actions suggérées</h2>";
echo "<ol>";
echo "<li>Si ce diagnostic s'affiche, le problème n'est pas PHP</li>";
echo "<li>Si un fichier a une erreur de syntaxe, corrigez-le</li>";
echo "<li>Si tout semble OK, le problème est dans index.php</li>";
echo "</ol>";

echo "<p><a href='index.php'>← Tester index.php</a></p>";