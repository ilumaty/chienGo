<?php include_once __DIR__ . '/../components/header.php'; ?>

<?php
// vérify de sécurité pour $client
if (!isset($client)) {
    header('Location: URL_CLIENT_LIST');
    exit;
}

// initialise $chiens si pas défini
if (!isset($chiens)) {
    $chiens = [];
}

?>



    <main class="min-h-screen bg-chien-beige-50">
        <div class="container mx-auto px-4 py-8">
            <!-- en-tête -->
            <div class="flex justify-between items-center mb-8">
                <div class="flex items-center">
                    <a href="<?= URL_CLIENTS_LIST ?>"
                       class="text-chien-primary hover:text-chien-primary-dark mr-4">
                        ← Retour à la liste
                    </a>
                    <div>
                        <h1 class="text-3xl font-bold text-chien-terracotta-800">
                            <?= htmlspecialchars($client['prenom'] . ' ' . $client['nom']) ?>
                        </h1>
                        <p class="text-chien-neutral">
                            Client depuis le <?= date('d/m/Y', strtotime($client['date_creation'])) ?>
                        </p>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="<?= URL_CLIENTS_EDIT?><?= $client['id'] ?>"
                       class="bg-chien-secondary text-white px-4 py-2 rounded-lg hover:bg-chien-peach-600 transition-colors w-full sm:w-auto text-center">
                        Modifier
                    </a>
                    <a href="<?= URL_CLIENTS_DELETE?><?= $client['id'] ?>"
                       class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition-colors w-full sm:w-auto text-center"
                       onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce client ?')">
                        Supprimer
                    </a>
                </div>
            </div>

            <!-- messages -->
            <?php if (!empty($success)): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    <?= htmlspecialchars($success) ?>
                </div>
            <?php endif; ?>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- informations client -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-md p-6 mb-6">
                        <h2 class="text-xl font-bold text-chien-terracotta-700 mb-4">
                            Informations personnelles
                        </h2>

                        <div class="space-y-3">
                            <div>
                                <span class="text-sm font-medium text-chien-neutral">
                                    Nom complet :
                                </span>
                                <p class="text-chien-terracotta-700 font-medium">
                                    <?= htmlspecialchars($client['prenom'] . ' ' . $client['nom']) ?>
                                </p>
                            </div>

                            <?php if (!empty($client['email'])): ?>
                                <div>
                                    <span class="text-sm font-medium text-chien-neutral">
                                        Email:
                                    </span>
                                    <p class="text-chien-terracotta-700">
                                        <a href="mailto:<?= htmlspecialchars($client['email']) ?>"
                                           class="hover:text-chien-primary transition-colors">
                                            <?= htmlspecialchars($client['email']) ?>
                                        </a>
                                    </p>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($client['telephone'])): ?>
                                <div>
                                    <span class="text-sm font-medium text-chien-neutral">
                                        Téléphone:
                                    </span>
                                    <p class="text-chien-terracotta-700">
                                        <a href="tel:<?= htmlspecialchars($client['telephone']) ?>"
                                           class="hover:text-chien-primary transition-colors">
                                            <?= htmlspecialchars($client['telephone']) ?>
                                        </a>
                                    </p>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($client['adresse']) || !empty($client['ville'])): ?>
                                <div>
                                    <span class="text-sm font-medium text-chien-neutral">
                                        Adresse:
                                    </span>
                                    <div class="text-chien-terracotta-700">
                                        <?php if (!empty($client['adresse'])): ?>
                                            <p><?= htmlspecialchars($client['adresse']) ?></p>
                                        <?php endif; ?>
                                        <?php if (!empty($client['ville']) || !empty($client['code_postal'])): ?>
                                            <p>
                                                <?= htmlspecialchars($client['code_postal']) ?>
                                                <?= htmlspecialchars($client['ville']) ?>
                                            </p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php if (!empty($client['notes'])): ?>
                        <div class="bg-white rounded-xl shadow-md p-6">
                            <h2 class="text-xl font-bold text-chien-terracotta-700 mb-4">
                                Notes
                            </h2>
                            <div class="bg-chien-beige-50 rounded-lg p-4">
                                <p class="text-chien-neutral whitespace-pre-wrap">
                                    <?= htmlspecialchars($client['notes']) ?>
                                </p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- chiens du client -->
                <div class="lg:col-span-2">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold text-chien-terracotta-700">
                            Ses chiens (<?= count($chiens) ?>)
                        </h2>
                        <a href="<?= URL_CHIENS_CREATE_WITH_CLIENT . $client['id'] ?>"
                           class="bg-chien-primary text-white px-4 py-2 rounded-lg hover:bg-chien-primary-dark transition-colors text-sm">
                            Ajouter un chien
                        </a>
                    </div>

                    <?php if (empty($chiens)): ?>
                        <div class="bg-white rounded-xl shadow-md p-12 text-center">
                            <div class="text-6xl mb-4">🐕</div>
                            <h3 class="text-xl font-bold text-chien-terracotta-700 mb-2">
                                Aucun chien enregistré
                            </h3>
                            <p class="text-chien-neutral mb-6">
                                Ce client n'a pas encore de chien dans le système
                            </p>
                            <a href="<?= URL_CHIENS_CREATE_WITH_CLIENT . $client['id'] ?>"
                               class="bg-chien-primary text-white px-6 py-3 rounded-lg hover:bg-chien-primary-dark transition-colors font-medium">
                                Ajouter son premier chien
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <?php foreach ($chiens as $chien): ?>
                                <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow border border-chien-peach-100">
                                    <div class="p-6">
                                        <div class="flex justify-between items-start mb-4">
                                            <div>
                                                <h3 class="text-lg font-bold text-chien-terracotta-700 mb-1">
                                                    <?= htmlspecialchars($chien['nom']) ?>
                                                </h3>
                                                <?php if (!empty($chien['race'])): ?>
                                                    <p class="text-chien-neutral text-sm">
                                                        <?= htmlspecialchars($chien['race']) ?>
                                                    </p>
                                                <?php endif; ?>
                                            </div>

                                            <div class="text-right">
                                                <?php if (!empty($chien['sexe'])): ?>
                                                    <span class="inline-block w-6 h-6 rounded-full text-center text-xs leading-6 text-white mb-1 <?= $chien['sexe'] === 'male' ? 'bg-blue-500' : 'bg-pink-500' ?>">
                                                    <?= $chien['sexe'] === 'male' ? '♂' : '♀' ?>
                                                </span>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <div class="space-y-2 text-sm text-chien-neutral mb-4">
                                            <?php if (!empty($chien['age'])): ?>
                                                <p>🎂 <?= $chien['age'] ?> an<?= $chien['age'] > 1 ? 's' : '' ?></p>
                                            <?php endif; ?>

                                            <?php if (!empty($chien['poids'])): ?>
                                                <p>⚖️ <?= $chien['poids'] ?> kg</p>
                                            <?php endif; ?>

                                            <?php if (!empty($chien['couleur'])): ?>
                                                <p>🎨 <?= htmlspecialchars($chien['couleur']) ?></p>
                                            <?php endif; ?>
                                        </div>

                                        <?php if (!empty($chien['caractere']) || !empty($chien['problèmes_comportement'])): ?>
                                            <div class="bg-chien-beige-50 rounded-lg p-3 mb-4 text-sm">
                                                <?php if (!empty($chien['caractere'])): ?>
                                                    <p class="text-chien-neutral mb-1">
                                                        <strong>
                                                            Caractère:
                                                        </strong> <?= htmlspecialchars($chien['caractere']) ?>
                                                    </p>
                                                <?php endif; ?>

                                                <?php if (!empty($chien['problèmes_comportement'])): ?>
                                                    <p class="text-chien-neutral">
                                                        <strong>
                                                            Problèmes:
                                                        </strong> <?= htmlspecialchars($chien['problèmes_comportement']) ?>
                                                    </p>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>

                                        <div class="flex gap-2">
                                            <a href="<?= URL_CHIENS_VIEW . $chien['id'] ?>"
                                               class="flex-1 bg-chien-primary text-white text-center py-2 px-3 rounded-lg hover:bg-chien-primary-dark transition-colors text-sm">
                                                Voir
                                            </a>
                                            <a href="<?= URL_SEANCES_CREATE_WITH_CHIEN . $chien['id'] ?>"
                                               class="flex-1 bg-chien-secondary text-white text-center py-2 px-3 rounded-lg hover:bg-chien-peach-600 transition-colors text-sm">
                                                Séance
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <!-- actions rapides -->
                    <div class="mt-8 bg-white rounded-xl shadow-md p-6">
                        <h3 class="text-lg font-bold text-chien-terracotta-700 mb-4">
                            Actions rapides
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <a href="<?= URL_SEANCES_CREATE_WITH_CLIENT . $client['id'] ?>"
                               class="bg-chien-primary text-white p-4 rounded-lg hover:bg-chien-primary-dark transition-colors text-center">
                                <div class="text-2xl mb-2">📅</div>
                                <div class="font-medium">
                                    Nouvelle séance
                                </div>
                            </a>

                            <a href="<?= URL_SEANCES_BY_CLIENT . $client['id'] ?>"
                               class="bg-chien-secondary text-white p-4 rounded-lg hover:bg-chien-peach-600 transition-colors text-center">
                                <div class="text-2xl mb-2">📋</div>
                                <div class="font-medium">
                                    Historique séances
                                </div>
                            </a>

                            <?php if (!empty($client['email'])): ?>
                                <a href="mailto:<?= htmlspecialchars($client['email']) ?>"
                                   class="bg-chien-accent text-white p-4 rounded-lg hover:bg-chien-mauve-700 transition-colors text-center">
                                    <div class="text-2xl mb-2">📧</div>
                                    <div class="font-medium">
                                        Envoyer email
                                    </div>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

<?php include_once __DIR__ . '/../components/footer.php'; ?>