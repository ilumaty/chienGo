<?php include_once __DIR__ . '/../components/header.php'; ?>

    <main class="min-h-screen bg-chien-beige-50">
        <div class="container mx-auto px-4 py-8">

            <div class="flex justify-between items-center mb-8">
                <div class="flex items-center">
                    <a href="<?= URL_ADMIN_DASHBOARD ?>"
                       class="text-chien-primary hover:text-chien-primary-dark mr-4">
                        Administration
                    </a>
                    <div>
                        <h1 class="text-3xl font-bold text-chien-terracotta-800">
                            Gestion des Utilisateurs
                        </h1>
                        <p class="text-chien-neutral">
                            Liste des éducateurs et administrateurs
                        </p>
                    </div>
                </div>
            </div>

            <!-- Messages -->
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

            <!-- listes des users -->
            <?php if (empty($users)): ?>
                <div class="bg-white rounded-xl shadow-md p-12 text-center">
                    <div class="text-6xl mb-4">👥</div>
                    <h3 class="text-xl font-bold text-chien-terracotta-700 mb-2">
                        Aucun utilisateur trouvé
                    </h3>
                    <p class="text-chien-neutral">
                        Il n'y a actuellement aucun utilisateur dans le système
                    </p>
                </div>
            <?php else: ?>
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-chien-primary text-white">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-medium uppercase tracking-wider">
                                    Utilisateur
                                </th>
                                <th class="px-6 py-3 text-left text-sm font-medium uppercase tracking-wider">
                                    Email
                                </th>
                                <th class="px-6 py-3 text-left text-sm font-medium uppercase tracking-wider">
                                    Rôle
                                </th>
                                <th class="px-6 py-3 text-left text-sm font-medium uppercase tracking-wider">
                                    Inscription
                                </th>
                                <th class="px-6 py-3 text-center text-sm font-medium uppercase tracking-wider">
                                    Statut
                                </th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-chien-beige-200">
                            <?php foreach ($users as $user): ?>
                                <tr class="hover:bg-chien-beige-50">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div class="h-10 w-10 rounded-full bg-chien-primary flex items-center justify-center text-white font-bold">
                                                    <?= strtoupper(substr($user['prenom'] ?? $user['nom'], 0, 1)) ?>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="font-bold text-chien-terracotta-700">
                                                    <?= htmlspecialchars(($user['prenom'] ? $user['prenom'] . ' ' : '') . $user['nom']) ?>
                                                </div>
                                                <?php if (!empty($user['ville'])): ?>
                                                    <div class="text-sm text-chien-neutral">
                                                        📍 <?= htmlspecialchars($user['ville']) ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-chien-terracotta-700">
                                            <?= htmlspecialchars($user['email']) ?>
                                        </div>
                                        <?php if (!empty($user['telephone'])): ?>
                                            <div class="text-sm text-chien-neutral">
                                                📞 <?= htmlspecialchars($user['telephone']) ?>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                            <?= $user['role'] === 'admin' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800' ?>">
                                            <?= $user['role'] === 'admin' ? '🛠️ Admin' : '🎓 Éducateur' ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-chien-neutral">
                                        <?= date('d/m/Y', strtotime($user['date_creation'])) ?>
                                        <div class="text-xs">
                                            <?= date('H:i', strtotime($user['date_creation'])) ?>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <?php if ($user['is_active']): ?>
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                Actif
                                            </span>
                                        <?php else: ?>
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                                Inactif
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- statistiques -->
                <div class="mt-8 bg-white rounded-xl shadow-md p-6">
                    <h3 class="text-lg font-bold text-chien-terracotta-700 mb-4">
                        Statistiques
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="text-center p-4 bg-chien-beige-50 rounded-lg">
                            <div class="text-2xl font-bold text-chien-primary mb-1">
                                <?= count($users) ?>
                            </div>
                            <div class="text-sm text-chien-neutral">
                                Utilisateurs total
                            </div>
                        </div>
                        <div class="text-center p-4 bg-chien-beige-50 rounded-lg">
                            <div class="text-2xl font-bold text-chien-primary mb-1">
                                <?= count(array_filter($users, static fn($u) => $u['role'] === 'educateur')) ?>
                            </div>
                            <div class="text-sm text-chien-neutral">Éducateurs</div>
                        </div>
                        <div class="text-center p-4 bg-chien-beige-50 rounded-lg">
                            <div class="text-2xl font-bold text-chien-primary mb-1">
                                <?= count(array_filter($users, static fn($u) => $u['role'] === 'admin')) ?>
                            </div>
                            <div class="text-sm text-chien-neutral">Administrateurs</div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- action rapides -->
            <div class="mt-8 bg-chien-peach-50 border border-chien-peach-200 rounded-lg p-6">
                <h4 class="font-bold text-chien-terracotta-700 mb-3">
                    Informations
                </h4>
                <div class="text-sm text-chien-neutral space-y-2">
                    <p>
                        • Les nouveaux éducateurs s'inscrivent via la page d'inscription publique
                    </p>
                    <p>
                        • Seuls les administrateurs peuvent accéder à cette page
                    </p>
                    <p>
                        • Pour des actions avancées (désactivation, changement de rôle), contactez le développeur
                    </p>
                </div>
                <div class="mt-4">
                    <a href="<?= URL_ADMIN_TYPES_SEANCES ?>" class="text-chien-primary hover:underline">
                        Gérer les types de séances
                    </a>
                </div>
            </div>
        </div>
    </main>

<?php include_once __DIR__ . '/../components/footer.php'; ?>