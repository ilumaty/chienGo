<?php
$pageTitle = "Dashboard || ChienGo";

include_once __DIR__ . '/components/header.php';
?>

<?php
// vérif sécurité
if (!isset($nbSeancesToday)) {
    $nbSeancesToday = 0;
}
if (!isset($nbSeancesWeek)) {
    $nbSeancesWeek = 0;
}
if (!isset($nbClients)) {
    $nbClients = 0;
}
if (!isset($revenu)) {
    $revenu = 0;
}
if (!isset($seancesToday)) {
    $seancesToday = [];
}
?>

    <main class="min-h-screen bg-chien-beige-50">
        <section class="py-16">
            <div class="container mx-auto px-4">
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-chien-terracotta-800 mb-2">
                        Tableau de Bord
                    </h1>
                    <p class="text-chien-neutral">
                        Bienvenue <?= htmlspecialchars($user['prenom'] ?? $user['nom'] ?? 'Éducateur') ?> ! Gérez votre activité depuis ce tableau de bord.
                    </p>
                </div>

                <!-- statistiques rapides -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <div class="bg-chien-surface p-6 rounded-xl shadow-md border border-chien-peach-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-chien-neutral text-sm">
                                    Séances aujourd'hui
                                </p>
                                <p class="text-2xl font-bold text-chien-primary">
                                    <?= $nbSeancesToday ?>
                                </p>
                            </div>
                            <span class="text-3xl">📅</span>
                        </div>
                    </div>

                    <div class="bg-chien-surface p-6 rounded-xl shadow-md border border-chien-peach-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-chien-neutral text-sm">
                                    Cette semaine
                                </p>
                                <p class="text-2xl font-bold text-chien-primary">
                                    <?= $nbSeancesWeek ?>
                                </p>
                            </div>
                            <span class="text-3xl">📊</span>
                        </div>
                    </div>

                    <div class="bg-chien-surface p-6 rounded-xl shadow-md border border-chien-peach-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-chien-neutral text-sm">
                                    Clients actifs
                                </p>
                                <p class="text-2xl font-bold text-chien-primary">
                                    <?= $nbClients ?>
                                </p>
                            </div>
                            <span class="text-3xl">
                                👥
                            </span>
                        </div>
                    </div>

                    <div class="bg-chien-surface p-6 rounded-xl shadow-md border border-chien-peach-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-chien-neutral text-sm">
                                    Revenus du mois
                                </p>
                                <p class="text-2xl font-bold text-chien-primary">
                                    <?= number_format($revenu) ?> CHF
                                </p>
                            </div>
                            <span class="text-3xl">
                                💰
                            </span>
                        </div>
                    </div>
                </div>

                <!-- actions rapides -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="bg-chien-surface p-6 rounded-xl shadow-md border border-chien-peach-100">
                        <h3 class="text-xl font-bold text-chien-terracotta-700 mb-4">
                            Actions Rapides
                        </h3>
                        <div class="space-y-4">
                            <a href="<?= URL_SEANCES_CREATE ?>" class="block w-full bg-chien-primary text-white py-3 px-4 rounded-lg hover:bg-chien-primary-dark transition-colors text-left mb-4">
                                Nouvelle séance
                            </a>
                            <a href="<?= URL_CLIENTS_CREATE ?>" class="block w-full bg-chien-secondary text-white py-3 px-4 rounded-lg hover:bg-chien-peach-600 transition-colors text-left mb-4">
                                Ajouter un client
                            </a>
                            <a href="<?= URL_SEANCES_PRIVATE ?>" class="block w-full bg-chien-accent text-white py-3 px-4 rounded-lg hover:bg-chien-mauve-700 transition-colors text-left mb-4">
                                Voir le planning
                            </a>
                        </div>
                    </div>
                    <div class="bg-chien-surface p-6 rounded-xl shadow-md border border-chien-peach-100">
                        <h3 class="text-xl font-bold text-chien-terracotta-700 mb-4">
                            Prochaines Séances
                        </h3>
                    <?php if (!empty($seancesToday)): ?>
                        <div class="space-y-4">
                            <?php foreach (array_slice($seancesToday, 0, 3) as $seance): ?>
                                <div class="flex justify-between items-center p-3 bg-chien-beige-50 rounded-lg">
                                    <div>
                                        <p class="font-medium text-chien-terracotta-700">
                                            <?= htmlspecialchars($seance['chien_nom'] ?? 'Séance') ?> - <?= htmlspecialchars($seance['type_nom'] ?? 'Formation') ?>
                                        </p>
                                        <p class="text-sm text-chien-neutral">
                                            <?= date('H:i', strtotime($seance['date_seance'])) ?> - <?= htmlspecialchars($seance['client_nom'] ?? '') ?>
                                        </p>
                                    </div>
                                    <span class="text-chien-primary font-bold">
                                        Aujourd'hui
                                    </span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-8">
                            <div class="text-4xl mb-2">🎉</div>
                            <p class="text-chien-neutral">
                                Aucune séance aujourd'hui
                            </p>
                            <p class="text-sm text-chien-neutral">
                                Profitez de cette journée !
                            </p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    </main>

<?php include_once __DIR__ . '/components/footer.php'; ?>