<?php include_once __DIR__ . '/../components/header.php'; ?>

<?php

// vérif de sécurité
if (!isset($seancesToday)) {
    $seancesToday = [];
}
if (!isset($seances)) {
    $seances = [];
}
if (!isset($clients)) {
    $clients = [];
}
if (!isset($seancesUpcoming)) {
    $seancesUpcoming = [];
}
?>

    <main class="min-h-screen bg-chien-beige-50">
        <div class="container mx-auto px-4 py-8">
            <!-- en-tête -->
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-chien-terracotta-800 mb-2">
                        Planning des Séances
                    </h1>
                    <p class="text-chien-neutral">
                        Gérez vos séances d'éducation canine
                    </p>
                </div>

                <a href="<?= URL_SEANCES_CREATE ?>"
                   class="bg-chien-primary text-white px-6 py-3 rounded-lg hover:bg-chien-primary-dark transition-colors font-medium shadow-md">
                    Nouvelle Séance
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

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <!-- sidebar avec dashboard rapide -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- séances d'aujourd'hui -->
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <h3 class="text-lg font-bold text-chien-terracotta-700 mb-4">
                            Aujourd'hui (<?= count($seancesToday) ?>)
                        </h3>

                        <?php if (empty($seancesToday)): ?>
                            <p class="text-chien-neutral text-sm">Aucune séance prévue</p>
                        <?php else: ?>
                            <div class="space-y-3">
                                <?php foreach ($seancesToday as $seance): ?>
                                    <div class="border-l-4 pl-3 py-2" style="border-color: <?= $seance['type_couleur'] ?? '#3B82F6' ?>">
                                        <div class="text-sm font-medium text-chien-terracotta-700">
                                            <?= date('H:i', strtotime($seance['date_seance'])) ?> - <?= htmlspecialchars($seance['chien_nom']) ?>
                                        </div>
                                        <div class="text-xs text-chien-neutral">
                                            <?= htmlspecialchars($seance['client_nom'] . ' ' . $seance['client_prenom']) ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- prochaines séances -->
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <h3 class="text-lg font-bold text-chien-terracotta-700 mb-4">
                            Prochaines séances
                        </h3>

                        <?php if (empty($seancesUpcoming)): ?>
                            <p class="text-chien-neutral text-sm">
                                Aucune séance programmée
                            </p>
                        <?php else: ?>
                            <div class="space-y-3">
                                <?php foreach ($seancesUpcoming as $seance): ?>
                                    <div class="text-sm">
                                        <div class="font-medium text-chien-terracotta-700">
                                            <?= date('d/m à H:i', strtotime($seance['date_seance'])) ?>
                                        </div>
                                        <div class="text-chien-neutral">
                                            <?= htmlspecialchars($seance['chien_nom']) ?> - <?= htmlspecialchars($seance['client_nom']) ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- statistiques rapides -->
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <h3 class="text-lg font-bold text-chien-terracotta-700 mb-4">
                            Statistiques
                        </h3>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-sm text-chien-neutral">
                                    Total séances:
                                </span>
                                <span class="font-bold text-chien-primary"><?= count($seances) ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-chien-neutral">
                                    Cette semaine:
                                </span>
                                <span class="font-bold text-chien-primary">

                                <?php
                                // calcule les séances de la semaine
                                $thisWeekCount = 0;
                                $startOfWeek = date('Y-m-d', strtotime('monday this week'));
                                $endOfWeek = date('Y-m-d', strtotime('sunday this week'));

                                foreach ($seances as $seance) {
                                    $seanceDate = date('Y-m-d', strtotime($seance['date_seance']));
                                    if ($seanceDate >= $startOfWeek && $seanceDate <= $endOfWeek) {
                                        $thisWeekCount++;
                                    }
                                }
                                echo $thisWeekCount;
                                ?>
                            </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-chien-neutral">Revenus mois:</span>
                                <span class="font-bold text-chien-primary">
                                <?php
                                // calcule le revenu du mois
                                $thisMonthRevenue = 0;
                                $currentMonth = date('Y-m');

                                foreach ($seances as $seance) {
                                    $seanceMonth = date('Y-m', strtotime($seance['date_seance']));
                                    if ($seanceMonth === $currentMonth && $seance['statut'] === 'terminee' && !empty($seance['prix'])) {
                                        $thisMonthRevenue += $seance['prix'];
                                    }
                                }
                                echo number_format($thisMonthRevenue);
                                ?> CHF
                            </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- liste principale -->
                <div class="lg:col-span-3">
                    <!-- filtres -->
                    <div class="bg-white rounded-xl shadow-md p-6 mb-6">
                        <h3 class="text-lg font-bold text-chien-terracotta-700 mb-4">🔍 Filtres</h3>
                        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <input type="hidden" name="page" value="seances">
                            <input type="hidden" name="action" value="list">

                            <div>
                                <label
                                        class="block text-sm font-medium text-chien-neutral mb-1"
                                        for="statut">
                                    Statut
                                </label>
                                <select
                                        name="statut"
                                        id="statut"
                                        class="w-full px-3 py-2 border border-chien-beige-300 rounded-lg focus:border-chien-primary">
                                    <option value="">
                                        Tous
                                    </option>
                                    <option value="planifiee" <?= ($_GET['statut'] ?? '') === 'planifiee' ? 'selected' : '' ?>>Planifiée</option>
                                    <option value="confirmee" <?= ($_GET['statut'] ?? '') === 'confirmee' ? 'selected' : '' ?>>Confirmée</option>
                                    <option value="en_cours" <?= ($_GET['statut'] ?? '') === 'en_cours' ? 'selected' : '' ?>>En cours</option>
                                    <option value="terminee" <?= ($_GET['statut'] ?? '') === 'terminee' ? 'selected' : '' ?>>Terminée</option>
                                    <option value="annulee" <?= ($_GET['statut'] ?? '') === 'annulee' ? 'selected' : '' ?>>Annulée</option>
                                </select>
                            </div>

                            <div>
                                <label
                                        class="block text-sm font-medium text-chien-neutral mb-1"
                                        for="client">
                                    Client
                                </label>
                                <select
                                        name="client_id"
                                        id="client"
                                        class="w-full px-3 py-2 border border-chien-beige-300 rounded-lg focus:border-chien-primary">
                                    <option value="">Tous les clients</option>
                                    <?php foreach ($clients as $client): ?>
                                        <option value="<?= $client['id'] ?>" <?= ($_GET['client_id'] ?? '') === $client['id'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($client['prenom'] . ' ' . $client['nom']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div>
                                <label
                                        class="block text-sm font-medium text-chien-neutral mb-1"
                                        for="date">
                                    Du
                                </label>
                                <input
                                        type="date"
                                        id="date"
                                        name="date_debut"
                                        value="<?= $_GET['date_debut'] ?? '' ?>"
                                       class="w-full px-3 py-2 border border-chien-beige-300 rounded-lg focus:border-chien-primary">
                            </div>

                            <div>
                                <label
                                        class="block text-sm font-medium text-chien-neutral mb-1"
                                        for="date-two">
                                    Au
                                </label>
                                <input
                                        type="date"
                                        id="date-two"
                                        name="date_fin" value="<?= $_GET['date_fin'] ?? '' ?>"
                                       class="w-full px-3 py-2 border border-chien-beige-300 rounded-lg focus:border-chien-primary">
                            </div>

                            <div class="md:col-span-4 flex gap-2">
                                <button type="submit" class="bg-chien-secondary text-white px-4 py-2 rounded-lg hover:bg-chien-peach-600 transition-colors">
                                    Filtrer
                                </button>
                                <a href="i<?= URL_SEANCES_PRIVATE ?>" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors">
                                    Réinitialiser
                                </a>
                            </div>
                        </form>
                    </div>

                    <!-- liste des séances -->
                    <?php if (empty($seances)): ?>
                        <div class="bg-white rounded-xl shadow-md p-12 text-center">
                            <div class="text-6xl mb-4">
                                📅
                            </div>
                            <h3 class="text-xl font-bold text-chien-terracotta-700 mb-2">
                                Aucune séance trouvée
                            </h3>
                            <p class="text-chien-neutral mb-6">
                                Commencez par créer votre première séance
                            </p>
                            <a href="<?= URL_SEANCES_CREATE ?>"
                               class="bg-chien-primary text-white px-6 py-3 rounded-lg hover:bg-chien-primary-dark transition-colors font-medium">
                                Créer une séance
                            </a>
                        </div>
                    <?php else: ?>
                        <!-- vue par jour -->
                        <?php
                        $seancesParJour = [];
                        foreach ($seances as $seance) {
                            $jour = date('Y-m-d', strtotime($seance['date_seance']));
                            $seancesParJour[$jour][] = $seance;
                        }
                        ?>

                        <div class="space-y-6">
                            <?php foreach ($seancesParJour as $jour => $seancesJour): ?>
                                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                                    <div class="bg-chien-primary text-white px-6 py-3">
                                        <h3 class="text-lg font-bold">
                                            <?php
                                            try {
                                                $dateJour = new DateTime($jour);
                                                $aujourd_hui = new DateTime();
                                                $demain = (clone $aujourd_hui)->add(new DateInterval('P1D'));

                                                if ($dateJour->format('Y-m-d') === $aujourd_hui->format('Y-m-d')) {
                                                    echo "Aujourd'hui";

                                                } elseif ($dateJour->format('Y-m-d') === $demain->format('Y-m-d')) {
                                                    echo "Demain";

                                                } else {
                                                    echo date('l d F Y', $dateJour->getTimestamp());
                                                }

                                            } catch (Exception $e) {
                                                echo htmlspecialchars($jour);
                                            }
                                            ?>
                                            <span class="ml-2 text-sm opacity-75">(<?= count($seancesJour) ?> séance<?= count($seancesJour) > 1 ? 's' : '' ?>)</span>
                                        </h3>
                                    </div>

                                    <div class="divide-y divide-chien-beige-200">
                                        <?php foreach ($seancesJour as $seance): ?>
                                            <div class="p-6 hover:bg-chien-beige-50 transition-colors">
                                                <div class="flex justify-between items-start">
                                                    <div class="flex-1">
                                                        <div class="flex items-center mb-2">
                                                            <div class="w-4 h-4 rounded-full mr-3" style="background-color: <?= $seance['type_couleur'] ?? '#3B82F6' ?>"></div>
                                                            <h4 class="text-lg font-bold text-chien-terracotta-700">
                                                                <?= htmlspecialchars($seance['titre']) ?>
                                                            </h4>
                                                            <span class="ml-3 px-2 py-1 text-xs rounded-full text-white
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

                                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-chien-neutral">
                                                            <div>
                                                                <strong>🕐 Horaire:</strong>
                                                                <?= date('H:i', strtotime($seance['date_seance'])) ?>
                                                                (<?= $seance['duree_minutes'] ?> min)
                                                            </div>
                                                            <div>
                                                                <strong>🐕 Chien:</strong>
                                                                <?= htmlspecialchars($seance['chien_nom']) ?>
                                                            </div>
                                                            <div>
                                                                <strong>👤 Client:</strong>
                                                                <?= htmlspecialchars($seance['client_nom'] . ' ' . $seance['client_prenom']) ?>
                                                            </div>
                                                        </div>

                                                        <?php if (!empty($seance['lieu'])): ?>
                                                            <div class="mt-2 text-sm text-chien-neutral">
                                                                <strong>📍 Lieu:</strong> <?= htmlspecialchars($seance['lieu']) ?>
                                                            </div>
                                                        <?php endif; ?>

                                                        <?php if (!empty($seance['prix'])): ?>
                                                            <div class="mt-2 text-sm font-bold text-chien-primary">
                                                                💰 <?= number_format($seance['prix']) ?> CHF
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>

                                                    <div class="flex gap-2 ml-4">
                                                        <a href="<?= URL_SEANCES_VIEW . $seance['id'] ?>"
                                                           class="bg-chien-primary text-white px-3 py-1 rounded text-sm hover:bg-chien-primary-dark transition-colors">
                                                            Voir
                                                        </a>
                                                        <a href="<?= URL_SEANCES_EDIT . $seance['id'] ?>"
                                                           class="bg-chien-secondary text-white px-3 py-1 rounded text-sm hover:bg-chien-peach-600 transition-colors">
                                                            Modifier
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>

<?php include_once __DIR__ . '/../components/footer.php'; ?>