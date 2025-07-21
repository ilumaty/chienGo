<?php include_once __DIR__ . '/../components/header.php'; ?>

    <main class="min-h-screen bg-chien-beige-50">
        <div class="container mx-auto px-4 py-8">
            <!-- En-tête -->
            <div class="flex justify-between items-center mb-8">
                <div class="flex items-center">
                    <a href="<?= URL_SEANCES_PRIVATE ?>"
                       class="text-chien-primary hover:text-chien-primary-dark mr-4">
                        ← Retour au planning
                    </a>
                    <div>
                        <h1 class="text-3xl font-bold text-chien-terracotta-800">
                            <?= htmlspecialchars($seance['titre'] ?? 'Détails de la séance') ?>
                        </h1>
                        <p class="text-chien-neutral">
                            Séance du <?= isset($seance['date_seance']) ? date('d/m/Y à H:i', strtotime($seance['date_seance'])) : '' ?>
                        </p>
                    </div>
                </div>

                <div class="flex gap-3">
                    <a href="<?= URL_SEANCES_EDIT . $seance['id'] ?? '' ?>"
                       class="bg-chien-secondary text-white px-4 py-2 rounded-lg hover:bg-chien-peach-600 transition-colors">
                        Modifier
                    </a>
                    <a href="<?= URL_SEANCES_DELETE . $seance['id'] ?? '' ?>"
                       class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition-colors"
                       onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette séance ?')">
                        Supprimer
                    </a>
                </div>
            </div>

            <!-- contenu Hero -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- info de la séance -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <h2 class="text-xl font-bold text-chien-terracotta-700 mb-4">
                            📋 Informations de la séance
                        </h2>

                        <?php if (isset($seance)): ?>
                            <div class="space-y-4">
                                <div>
                                    <span class="text-sm font-medium text-chien-neutral">
                                        Titre :
                                    </span>
                                    <p class="text-chien-terracotta-700 font-medium">
                                        <?= htmlspecialchars($seance['titre']) ?>
                                    </p>
                                </div>

                                <div>
                                    <span class="text-sm font-medium text-chien-neutral">
                                        Date et heure :
                                    </span>
                                    <p class="text-chien-terracotta-700">
                                        <?= date('d/m/Y à H:i', strtotime($seance['date_seance'])) ?>
                                        (<?= $seance['duree_minutes'] ?> minutes)
                                    </p>
                                </div>

                                <div>
                                    <span class="text-sm font-medium text-chien-neutral">
                                        Statut :
                                    </span>
                                    <span class="px-2 py-1 text-xs rounded-full text-white ml-2
                                    <?php
                                    echo match($seance['statut']) {
                                        'planifiee' => 'bg-blue-500',
                                        'confirmee' => 'bg-green-500',
                                        'en_cours' => 'bg-orange-500',
                                        'terminee' => 'bg-gray-500',
                                        'annulee' => 'bg-red-500',
                                        default => 'bg-gray-400'
                                    };
                                    ?>">
                                    <?= ucfirst($seance['statut']) ?>
                                </span>
                                </div>

                                <?php if (!empty($seance['lieu'])): ?>
                                    <div>
                                        <span class="text-sm font-medium text-chien-neutral">
                                            Lieu :
                                        </span>
                                        <p class="text-chien-terracotta-700">
                                            <?= htmlspecialchars($seance['lieu']) ?>
                                        </p>
                                    </div>
                                <?php endif; ?>

                                <?php if (!empty($seance['prix'])): ?>
                                    <div>
                                        <span class="text-sm font-medium text-chien-neutral">
                                            Prix :
                                        </span>
                                        <p class="text-chien-primary font-bold text-lg">
                                            <?= number_format($seance['prix']) ?> CHF
                                        </p>
                                    </div>
                                <?php endif; ?>

                                <?php if (!empty($seance['description'])): ?>
                                    <div>
                                        <span class="text-sm font-medium text-chien-neutral">
                                            Description :
                                        </span>
                                        <div class="bg-chien-beige-50 rounded-lg p-4 mt-2">
                                            <p class="text-chien-neutral whitespace-pre-wrap">
                                                <?= htmlspecialchars($seance['description']) ?>
                                            </p>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <?php if (!empty($seance['notes_educateur'])): ?>
                                    <div>
                                        <span class="text-sm font-medium text-chien-neutral">
                                            Notes éducateur :
                                        </span>
                                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mt-2">
                                            <p class="text-gray-700 whitespace-pre-wrap">
                                                <?= htmlspecialchars($seance['notes_educateur']) ?>
                                            </p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php else: ?>
                            <p class="text-red-600">
                                Séance non trouvée
                            </p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- info client et chien -->
                <div class="lg:col-span-1 space-y-6">
                    <?php if (isset($seance)): ?>
                        <!-- Client -->
                        <div class="bg-white rounded-xl shadow-md p-6">
                            <h3 class="text-lg font-bold text-chien-terracotta-700 mb-4">
                                👤 Client
                            </h3>
                            <div class="space-y-2">
                                <p class="font-medium text-chien-terracotta-700">
                                    <?= htmlspecialchars($seance['client_prenom'] . ' ' . $seance['client_nom']) ?>
                                </p>
                                <?php if (!empty($seance['client_telephone'])): ?>
                                    <p class="text-sm text-chien-neutral">
                                        📞 <a href="tel:<?= htmlspecialchars($seance['client_telephone']) ?>"
                                             class="hover:text-chien-primary">
                                            <?= htmlspecialchars($seance['client_telephone']) ?>
                                        </a>
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- chien -->
                        <div class="bg-white rounded-xl shadow-md p-6">
                            <h3 class="text-lg font-bold text-chien-terracotta-700 mb-4">
                                🐕 Chien
                            </h3>
                            <div class="space-y-2">
                                <p class="font-medium text-chien-terracotta-700">
                                    <?= htmlspecialchars($seance['chien_nom']) ?>
                                </p>
                                <?php if (!empty($seance['chien_race'])): ?>
                                    <p class="text-sm text-chien-neutral">
                                        Race : <?= htmlspecialchars($seance['chien_race']) ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- type de séance -->
                        <?php if (!empty($seance['type_nom'])): ?>
                            <div class="bg-white rounded-xl shadow-md p-6">
                                <h3 class="text-lg font-bold text-chien-terracotta-700 mb-4">
                                    Type de séance
                                </h3>
                                <div class="flex items-center">
                                    <div class="w-4 h-4 rounded-full mr-3"
                                         style="background-color: <?= $seance['type_couleur'] ?? '#3B82F6' ?>"></div>
                                    <span class="font-medium text-chien-terracotta-700">
                                    <?= htmlspecialchars($seance['type_nom']) ?>
                                </span>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>

                    <!-- action rapides -->
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <h3 class="text-lg font-bold text-chien-terracotta-700 mb-4">
                            Actions rapides
                        </h3>
                        <div class="space-y-3">
                            <a href="<?= URL_SEANCES_CREATE_WITH_CLIENT . $seance['client_id'] ?? '' ?>"
                               class="w-full bg-chien-primary text-white py-2 px-4 rounded-lg hover:bg-chien-primary-dark transition-colors text-center block">
                                Nouvelle séance
                            </a>
                            <a href="<?= URL_CLIENTS_VIEW . $seance['client_id'] ?? '' ?>"
                               class="w-full bg-chien-secondary text-white py-2 px-4 rounded-lg hover:bg-chien-peach-600 transition-colors text-center block">
                                Voir le client
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

<?php include_once __DIR__ . '/../components/footer.php'; ?>