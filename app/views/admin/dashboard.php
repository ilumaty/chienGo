<?php include_once __DIR__ . '/../components/header.php'; ?>

    <main class="min-h-screen bg-chien-beige-50">
        <div class="container mx-auto px-4 py-8">

            <div class="mb-8">
                <h1 class="text-3xl font-bold text-chien-terracotta-800 mb-2">
                    Administration ChienGo
                </h1>
                <p class="text-chien-neutral">
                    Panel d'administration - Accès réservé aux administrateurs
                </p>
            </div>

            <!-- msg -->
            <?php if (!empty($success)): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    <?= htmlspecialchars($success) ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($errors)): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    <?php foreach ($errors as $error): ?>
                        <p><?= htmlspecialchars($error) ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- states rapides -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white p-6 rounded-xl shadow-md border border-chien-peach-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-chien-neutral text-sm">Utilisateurs total</p>
                            <p class="text-2xl font-bold text-chien-primary">
                                <?= $totalUsers ?? 0 ?>
                            </p>
                        </div>
                        <span class="text-3xl">👥</span>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-md border border-chien-peach-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-chien-neutral text-sm">Éducateurs</p>
                            <p class="text-2xl font-bold text-chien-primary">
                                <?= $totalEducateurs ?? 0 ?>
                            </p>
                        </div>
                        <span class="text-3xl">🎓</span>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-md border border-chien-peach-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-chien-neutral text-sm">
                                Types de séances
                            </p>
                            <p class="text-2xl font-bold text-chien-primary">
                                <?= $totalTypesSeances ?? 0 ?>
                            </p>
                        </div>
                        <span class="text-3xl">⚙️</span>
                    </div>
                </div>
            </div>

            <!-- action d'administration -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h3 class="text-xl font-bold text-chien-terracotta-700 mb-4">
                        Gestion des Utilisateurs
                    </h3>
                    <p class="text-chien-neutral mb-4">
                        Voir et gérer les comptes utilisateurs, éducateurs et administrateurs.
                    </p>
                    <a href="<?= URL_ADMIN_USERS ?>"
                       class="bg-chien-primary text-white px-6 py-3 rounded-lg hover:bg-chien-primary-dark transition-colors inline-block">
                        Gérer les utilisateurs
                    </a>
                </div>

                <div class="bg-white rounded-xl shadow-md p-6">
                    <h3 class="text-xl font-bold text-chien-terracotta-700 mb-4">
                        Types de Séances
                    </h3>
                    <p class="text-chien-neutral mb-4">
                        Configurer les types de séances, prix, durées et couleurs d'affichage.
                    </p>
                    <a href="<?= URL_ADMIN_TYPES_SEANCES ?>"
                       class="bg-chien-secondary text-white px-6 py-3 rounded-lg hover:bg-chien-peach-600 transition-colors inline-block">
                        Gérer les types
                    </a>
                </div>
            </div>

            <!-- action rapides -->
            <div class="mt-8 bg-chien-peach-50 border border-chien-peach-200 rounded-lg p-6">
                <h4 class="font-bold text-chien-terracotta-700 mb-3">
                    Actions rapides
                </h4>
                <div class="flex flex-wrap gap-4">
                    <a href="<?= URL_ADMIN_TYPES_CREATE ?>"
                       class="text-chien-primary hover:underline">
                        Nouveau type de séance
                    </a>
                    <a href="<?= URL_DASHBOARD ?>"
                       class="text-chien-primary hover:underline">
                        Dashboard éducateur
                    </a>
                </div>
            </div>
        </div>
    </main>

<?php include_once __DIR__ . '/../components/footer.php'; ?>