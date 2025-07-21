<?php include_once __DIR__ . '/../components/header.php'; ?>

<?php
// vérif de var $seance
if (!isset($seance)) {
    header('Location: ' . URL_SEANCES_PRIVATE);
    exit;
}
?>

<main class="min-h-screen bg-chien-beige-50">
    <div class="container mx-auto px-4 py-8">
        <!-- en-tête -->
        <div class="flex items-center mb-8">
            <a href="<?= URL_SEANCES_VIEW . $seance['id'] ?>"
               class="text-chien-primary hover:text-chien-primary-dark mr-4">
                ← Retour aux détails
            </a>
            <div>
                <h1 class="text-3xl font-bold text-red-600">
                    Supprimer la Séance
                </h1>
                <p class="text-chien-neutral">
                    Cette action est irréversible.
                </p>
            </div>
        </div>

        <!-- messages d'erreur -->
        <?php if (!empty($errors)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <ul class="list-disc list-inside">
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <div class="max-w-2xl mx-auto">
            <!-- carte de confirmation -->
            <div class="bg-white rounded-xl shadow-md border-l-4 border-red-500 p-8">
                <div class="flex items-center mb-6">
                    <div class="bg-red-100 p-3 rounded-full mr-4">
                        <svg class="w-8 h-8 text-red-600" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-red-600 mb-1">
                            Confirmer la suppression
                        </h2>
                        <p class="text-gray-600">
                            Êtes-vous sûr de vouloir supprimer cette séance ?
                        </p>
                    </div>
                </div>

                <!-- détails de la séance à supprimer -->
                <div class="bg-gray-50 rounded-lg p-6 mb-6">
                    <h3 class="font-bold text-gray-700 mb-4">
                        📋 Détails de la séance
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="text-gray-500">Titre :</span>
                            <p class="font-medium text-gray-800">
                                <?= htmlspecialchars($seance['titre']) ?>
                            </p>
                        </div>

                        <div>
                            <span class="text-gray-500">Date et heure :</span>
                            <p class="font-medium text-gray-800">
                                <?= date('d/m/Y à H:i', strtotime($seance['date_seance'])) ?>
                            </p>
                        </div>

                        <div>
                            <span class="text-gray-500">Client :</span>
                            <p class="font-medium text-gray-800">
                                <?= htmlspecialchars($seance['client_prenom'] . ' ' . $seance['client_nom']) ?>
                            </p>
                        </div>

                        <div>
                            <span class="text-gray-500">Chien :</span>
                            <p class="font-medium text-gray-800">
                                <?= htmlspecialchars($seance['chien_nom']) ?>
                                <?php if (!empty($seance['chien_race'])): ?>
                                    <span class="text-gray-500">(<?= htmlspecialchars($seance['chien_race']) ?>)</span>
                                <?php endif; ?>
                            </p>
                        </div>

                        <div>
                            <span class="text-gray-500">Statut :</span>
                            <span class="px-2 py-1 text-xs rounded-full text-white ml-1
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

                        <?php if (!empty($seance['prix'])): ?>
                            <div>
                                <span class="text-gray-500">Prix :</span>
                                <p class="font-medium text-gray-800">
                                    <?= number_format($seance['prix']) ?> CHF
                                </p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <?php if (!empty($seance['lieu'])): ?>
                        <div class="mt-4">
                            <span class="text-gray-500">Lieu :</span>
                            <p class="font-medium text-gray-800">
                                <?= htmlspecialchars($seance['lieu']) ?>
                            </p>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- avertissements -->
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-yellow-600 mt-0.5 mr-3 flex-shrink-0" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                        <div>
                            <h4 class="font-bold text-yellow-800 mb-1">⚠️ Attention</h4>
                            <ul class="text-sm text-yellow-700 space-y-1">
                                <li>- Cette action supprimera définitivement la séance</li>
                                <li>- Toutes les informations associées seront perdues</li>
                                <li>- Pensez à prévenir le client si nécessaire</li>
                                <?php if ($seance['statut'] === 'confirmee'): ?>
                                    <li class="font-medium">
                                       - ⚠️ Cette séance est confirmée – le client pourrait avoir prévu de venir
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- formulaire de confirmation -->
                <form method="POST" class="space-y-6">
                    <div class="flex items-center">
                        <input type="checkbox"
                               id="confirmation"
                               name="confirmation"
                               required
                               class="h-4 w-4 text-red-600 border-gray-300 rounded focus:ring-red-500">
                        <label for="confirmation" class="ml-2 text-sm text-gray-700">
                            Je confirme vouloir supprimer définitivement cette séance
                        </label>
                    </div>

                    <!-- boutons -->
                    <div class="flex justify-end gap-4 pt-6 border-t border-gray-200">
                        <a href="<?= URL_SEANCES_VIEW . $seance['id'] ?>"
                           class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                            Annuler
                        </a>
                        <button type="submit"
                                class="bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition-colors font-medium shadow-md">
                            Supprimer définitivement
                        </button>
                    </div>
                </form>
            </div>

            <!-- alternatives -->
            <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
                <h3 class="font-bold text-blue-800 mb-3">
                    Alternatives à la suppression
                </h3>
                <div class="space-y-2 text-sm text-blue-700">