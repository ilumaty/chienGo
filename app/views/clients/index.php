<?php include_once __DIR__ . '/../components/header.php'; ?>

    <main class="min-h-screen bg-chien-beige-50">
        <div class="container mx-auto px-4 py-8">
            <!-- en-tête -->
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-chien-terracotta-800 mb-2">
                        Mes Clients
                    </h1>
                    <p class="text-chien-neutral">
                        Gérez votre carnet de clients et leurs compagnons
                    </p>
                </div>

                <a href="<?= URL_CLIENTS_CREATE ?>"
                   class="bg-chien-primary text-white px-6 py-3 rounded-lg hover:bg-chien-primary-dark transition-colors font-medium shadow-md">
                    Nouveau Client
                </a>
            </div>

            <!-- messages -->
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

            <!-- barre de recherche -->
            <div class="bg-white rounded-xl shadow-md p-6 mb-6">
                <form
                        method="GET"
                        class="flex gap-4">
                    <input
                            type="hidden"
                            name="page"
                            value="clients">

                    <input
                            type="hidden"
                            name="action"
                            value="list">

                    <div class="flex-1">
                        <label
                                for="search"
                                class="sr-only">
                            Rechercher un client
                        </label>
                        <input type="text"
                               id="search"
                               name="search"
                               value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"
                               placeholder="Rechercher un client (nom, prénom, email...)"
                               class="w-full px-4 py-2 border border-chien-beige-300 rounded-lg focus:border-chien-primary focus:ring-2 focus:ring-chien-primary/20">
                    </div>
                    <button type="submit"
                            class="bg-chien-secondary text-white px-6 py-2 rounded-lg hover:bg-chien-peach-600 transition-colors">
                        Rechercher
                    </button>
                    <?php if (!empty($_GET['search'])): ?>
                        <a href="<?= URL_CLIENTS_LIST ?>"
                           class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition-colors">
                            ✕ Effacer
                        </a>
                    <?php endif; ?>
                </form>
            </div>

            <!-- liste des clients -->
            <?php if (empty($clients)): ?>
                <div class="bg-white rounded-xl shadow-md p-12 text-center">
                    <div class="text-6xl mb-4">👥</div>
                    <h3 class="text-xl font-bold text-chien-terracotta-700 mb-2">
                        <?= !empty($_GET['search']) ? 'Aucun résultat trouvé' : 'Aucun client pour le moment' ?>
                    </h3>
                    <p class="text-chien-neutral mb-6">
                        <?= !empty($_GET['search']) ? 'Essayez avec d\'autres mots-clés' : 'Commencez par ajouter votre premier client' ?>
                    </p>
                    <?php if (empty($_GET['search'])): ?>
                        <a href="<?= URL_CLIENTS_CREATE?>"
                           class="bg-chien-primary text-white px-6 py-3 rounded-lg hover:bg-chien-primary-dark transition-colors font-medium">
                            Ajouter un client
                        </a>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach ($clients as $client): ?>
                        <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow border border-chien-peach-100">
                            <div class="p-6">
                                <div class="flex justify-between items-start mb-4">
                                    <div class="flex-1">
                                        <h3 class="text-lg font-bold text-chien-terracotta-700 mb-1">
                                            <?= htmlspecialchars($client['prenom'] . ' ' . $client['nom']) ?>
                                        </h3>
                                        <?php if (!empty($client['email'])): ?>
                                            <p class="text-sm text-chien-neutral mb-1">
                                                📧 <?= htmlspecialchars($client['email']) ?>
                                            </p>
                                        <?php endif; ?>
                                        <?php if (!empty($client['telephone'])): ?>
                                            <p class="text-sm text-chien-neutral mb-1">
                                                📞 <?= htmlspecialchars($client['telephone']) ?>
                                            </p>
                                        <?php endif; ?>
                                        <?php if (!empty($client['ville'])): ?>
                                            <p class="text-sm text-chien-neutral">
                                                📍 <?= htmlspecialchars($client['ville']) ?>
                                            </p>
                                        <?php endif; ?>
                                    </div>

                                    <div class="flex flex-col items-end">
                                    <span class="bg-chien-peach-100 text-chien-peach-800 text-xs px-2 py-1 rounded-full mb-2">
                                        <?php $nbChiens = (int)($client['nb_chiens'] ?? 0); ?>
                                        <?= $nbChiens ?> chien<?= $nbChiens > 1 ? 's' : '' ?>
                                    </span>
                                    </div>
                                </div>

                                <?php if (!empty($client['notes'])): ?>
                                    <div class="bg-chien-beige-50 rounded-lg p-3 mb-4">
                                        <p class="text-sm text-chien-neutral">
                                            "<?= htmlspecialchars(strlen($client['notes']) > 100 ? substr($client['notes'], 0, 100) . '...' : $client['notes']) ?>"
                                        </p>
                                    </div>
                                <?php endif; ?>

                                <div class="flex gap-2">
                                    <a href="<?= URL_CLIENTS_VIEW . $client['id'] ?>"
                                       class="flex-1 bg-chien-primary text-white text-center py-2 px-3 rounded-lg hover:bg-chien-primary-dark transition-colors text-sm">
                                        Voir
                                    </a>
                                    <a href="<?= URL_CLIENTS_EDIT . $client['id'] ?>"
                                       class="flex-1 bg-chien-secondary text-white text-center py-2 px-3 rounded-lg hover:bg-chien-peach-600 transition-colors text-sm">
                                        Modifier
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- statistiques -->
                <?php
                $totalChiens = array_sum(array_map(static fn($c) => (int)($c['nb_chiens'] ?? 0), $clients));
                $totalClients = count($clients);
                $moyenneChiens = $totalClients > 0 ? number_format($totalChiens / $totalClients, 1) : '0';
                ?>

                <div class="mt-8 bg-white rounded-xl shadow-md p-6">
                    <h3 class="text-lg font-bold text-chien-terracotta-700 mb-4">
                        Statistiques
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="text-center p-4 bg-chien-beige-50 rounded-lg">
                            <div class="text-2xl font-bold text-chien-primary mb-1"><?= $totalClients ?></div>
                            <div class="text-sm text-chien-neutral">Client<?= $totalClients > 1 ? 's' : '' ?> total</div>
                        </div>
                        <div class="text-center p-4 bg-chien-beige-50 rounded-lg">
                            <div class="text-2xl font-bold text-chien-primary mb-1"><?= $totalChiens ?></div>
                            <div class="text-sm text-chien-neutral">
                                Chiens au total
                            </div>
                        </div>
                        <div class="text-center p-4 bg-chien-beige-50 rounded-lg">
                            <div class="text-2xl font-bold text-chien-primary mb-1"><?= $moyenneChiens ?></div>
                            <div class="text-sm text-chien-neutral">
                                Chiens/client moyen
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </main>

<?php include_once __DIR__ . '/../components/footer.php'; ?>