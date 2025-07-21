<?php include_once __DIR__ . '/../components/header.php'; ?>

    <main class="min-h-screen bg-chien-beige-50">
        <div class="container mx-auto px-4 py-8">
            <!-- En-tête -->
            <div class="flex justify-between items-center mb-8">
                <div class="flex items-center">
                    <a href="<?= URL_ADMIN_DASHBOARD ?>"
                       class="text-chien-primary hover:text-chien-primary-dark mr-4">
                        Administration
                    </a>
                    <div>
                        <h1 class="text-3xl font-bold text-chien-terracotta-800">
                            Types de Séances
                        </h1>
                        <p class="text-chien-neutral">
                            Configuration des types disponibles
                        </p>
                    </div>
                </div>

                <a href="<?= URL_ADMIN_TYPES_CREATE ?>"
                   class="bg-chien-primary text-white px-6 py-3 rounded-lg hover:bg-chien-primary-dark transition-colors font-medium shadow-md">
                    Nouveau Type
                </a>
            </div>

            <!-- msg -->
            <?php if (!empty($success)): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    <?= htmlspecialchars($success) ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($_SESSION['error'])): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    <?= htmlspecialchars($_SESSION['error']) ?>
                    <?php unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <!-- Liste des types -->
            <?php if (empty($typesSeances)): ?>
                <div class="bg-white rounded-xl shadow-md p-12 text-center">
                    <div class="text-6xl mb-4">⚙️</div>
                    <h3 class="text-xl font-bold text-chien-terracotta-700 mb-2">
                        Aucun type de séance
                    </h3>
                    <p class="text-chien-neutral mb-6">
                        Commencez par créer votre premier type de séance
                    </p>
                    <a href="<?=URL_ADMIN_TYPES_CREATE ?>"
                       class="bg-chien-primary text-white px-6 py-3 rounded-lg hover:bg-chien-primary-dark transition-colors font-medium">
                        Créer un type
                    </a>
                </div>
            <?php else: ?>
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-chien-primary text-white">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-medium uppercase tracking-wider">
                                    Type
                                </th>
                                <th class="px-6 py-3 text-left text-sm font-medium uppercase tracking-wider">
                                    Description
                                </th>
                                <th class="px-6 py-3 text-left text-sm font-medium uppercase tracking-wider">
                                    Durée
                                </th>
                                <th class="px-6 py-3 text-left text-sm font-medium uppercase tracking-wider">
                                    Prix
                                </th>
                                <th class="px-6 py-3 text-center text-sm font-medium uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-chien-beige-200">
                            <?php foreach ($typesSeances as $type): ?>
                                <tr class="hover:bg-chien-beige-50">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="w-4 h-4 rounded-full mr-3"
                                                 style="background-color: <?= htmlspecialchars($type['couleur']) ?>"></div>
                                            <div>
                                                <div class="font-bold text-chien-terracotta-700">
                                                    <?= htmlspecialchars($type['nom']) ?>
                                                </div>
                                                <div class="text-xs text-gray-500">
                                                    #<?= $type['id'] ?>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-chien-neutral text-sm max-w-xs">
                                            <?= htmlspecialchars(substr($type['description'] ?? '', 0, 100)) ?>
                                            <?= strlen($type['description'] ?? '') > 100 ? '...' : '' ?>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="bg-chien-beige-100 text-chien-terracotta-700 px-2 py-1 rounded-full text-sm">
                                            <?= $type['duree_minutes'] ?> min
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php if ($type['prix']): ?>
                                            <span class="font-bold text-chien-primary">
                                                <?= number_format($type['prix']) ?> CHF
                                            </span>
                                        <?php else: ?>
                                            <span class="text-gray-400">
                                                Non défini
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex justify-center gap-2">
                                            <a href="<?= URL_ADMIN_TYPES_EDIT ?><?= $type['id'] ?>"
                                               class="bg-chien-secondary text-white px-3 py-1 rounded text-sm hover:bg-chien-peach-600 transition-colors">
                                                Modifier
                                            </a>
                                            <a href="<?= URL_ADMIN_TYPES_DELETE ?><?= $type['id'] ?>"
                                               class="bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600 transition-colors"
                                               onclick="return confirm('Supprimer ce type de séance ?')">
                                                🗑️
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- states -->
                <div class="mt-8 bg-white rounded-xl shadow-md p-6">
                    <h3 class="text-lg font-bold text-chien-terracotta-700 mb-4">
                        Statistiques
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="text-center p-4 bg-chien-beige-50 rounded-lg">
                            <div class="text-2xl font-bold text-chien-primary mb-1"><?= count($typesSeances) ?></div>
                            <div class="text-sm text-chien-neutral">
                                Types configurés
                            </div>
                        </div>
                        <div class="text-center p-4 bg-chien-beige-50 rounded-lg">
                            <div class="text-2xl font-bold text-chien-primary mb-1">
                                <?= number_format(array_sum(array_filter(array_column($typesSeances, 'prix'))) / max(count(array_filter(array_column($typesSeances, 'prix'))), 1)) ?>
                            </div>
                            <div class="text-sm text-chien-neutral">
                                Prix moyen (CHF)
                            </div>
                        </div>
                        <div class="text-center p-4 bg-chien-beige-50 rounded-lg">
                            <div class="text-2xl font-bold text-chien-primary mb-1">
                                <?= round(array_sum(array_column($typesSeances, 'duree_minutes')) / max(count($typesSeances), 1)) ?>
                            </div>
                            <div class="text-sm text-chien-neutral">
                                Durée moyenne (min)
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </main>

<?php include_once __DIR__ . '/../components/footer.php'; ?>