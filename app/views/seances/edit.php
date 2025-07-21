<?php include_once __DIR__ . '/../components/header.php'; ?>

<?php
// vérif sécurité
if (!isset($seance)) {
    header('Location: ' . URL_SEANCES_PRIVATE);
    exit;
}
if (!isset($typesSeances)) {
    $typesSeances = [];
}
if (!isset($clients)) {
    $clients = [];
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
                    <h1 class="text-3xl font-bold text-chien-terracotta-800">
                        Modifier la Séance
                    </h1>
                    <p class="text-chien-neutral">
                        Modification de "<?= htmlspecialchars($seance['titre']) ?>"
                    </p>
                </div>
            </div>

            <!-- msg d'erreur -->
            <?php if (!empty($errors)): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    <ul class="list-disc list-inside">
                        <?php foreach ($errors as $error): ?>
                            <li><?= htmlspecialchars($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- form principal -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl shadow-md p-8">
                        <form method="POST" id="seanceForm" class="space-y-6">
                            <!-- informations de base -->
                            <div class="border-b border-chien-beige-200 pb-6">
                                <h2 class="text-xl font-bold text-chien-terracotta-700 mb-4">
                                    Informations générales
                                </h2>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="md:col-span-2">
                                        <label for="titre" class="block text-sm font-medium text-chien-terracotta-700 mb-2">
                                            Titre de la séance <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text"
                                               id="titre"
                                               name="titre"
                                               value="<?= htmlspecialchars($_POST['titre'] ?? $seance['titre']) ?>"
                                               required
                                               placeholder="Ex: Séance d'éducation de base avec Max"
                                               class="w-full px-4 py-3 border border-chien-beige-300 rounded-lg focus:border-chien-primary focus:ring-2 focus:ring-chien-primary/20">
                                    </div>

                                    <div>
                                        <label for="type_seance_id" class="block text-sm font-medium text-chien-terracotta-700 mb-2">
                                            Type de séance
                                        </label>
                                        <select id="type_seance_id"
                                                name="type_seance_id"
                                                class="w-full px-4 py-3 border border-chien-beige-300 rounded-lg focus:border-chien-primary focus:ring-2 focus:ring-chien-primary/20">
                                            <option value="">
                                                Sélectionner un type
                                            </option>
                                            <?php foreach ($typesSeances as $type): ?>
                                                <option value="<?= $type['id'] ?>"
                                                        data-duree="<?= $type['duree_minutes'] ?>"
                                                        data-prix="<?= $type['prix'] ?>"
                                                    <?= ($_POST['type_seance_id'] ?? $seance['type_seance_id']) === $type['id'] ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($type['nom']) ?>
                                                    <?php if ($type['prix']): ?>
                                                        (<?= number_format($type['prix']) ?> CHF)
                                                    <?php endif; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div>
                                        <label for="statut" class="block text-sm font-medium text-chien-terracotta-700 mb-2">
                                            Statut
                                        </label>
                                        <select id="statut"
                                                name="statut"
                                                class="w-full px-4 py-3 border border-chien-beige-300 rounded-lg focus:border-chien-primary focus:ring-2 focus:ring-chien-primary/20">
                                            <option value="planifiee" <?= ($_POST['statut'] ?? $seance['statut']) === 'planifiee' ? 'selected' : '' ?>>
                                                Planifiée
                                            </option>
                                            <option value="confirmee" <?= ($_POST['statut'] ?? $seance['statut']) === 'confirmee' ? 'selected' : '' ?>>
                                                Confirmée
                                            </option>
                                            <option value="en_cours" <?= ($_POST['statut'] ?? $seance['statut']) === 'en_cours' ? 'selected' : '' ?>>
                                                En cours
                                            </option>
                                            <option value="terminee" <?= ($_POST['statut'] ?? $seance['statut']) === 'terminee' ? 'selected' : '' ?>>
                                                Terminée
                                            </option>
                                            <option value="annulee" <?= ($_POST['statut'] ?? $seance['statut']) === 'annulee' ? 'selected' : '' ?>>
                                                Annulée
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- date et durée -->
                            <div class="border-b border-chien-beige-200 pb-6">
                                <h2 class="text-xl font-bold text-chien-terracotta-700 mb-4">
                                    Planification
                                </h2>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <div>
                                        <label for="date_seance" class="block text-sm font-medium text-chien-terracotta-700 mb-2">
                                            Date et heure <span class="text-red-500">*</span>
                                        </label>
                                        <input type="datetime-local"
                                               id="date_seance"
                                               name="date_seance"
                                               value="<?= $_POST['date_seance'] ?? date('Y-m-d\TH:i', strtotime($seance['date_seance'])) ?>"
                                               required
                                               class="w-full px-4 py-3 border border-chien-beige-300 rounded-lg focus:border-chien-primary focus:ring-2 focus:ring-chien-primary/20">
                                    </div>

                                    <div>
                                        <label for="duree_minutes" class="block text-sm font-medium text-chien-terracotta-700 mb-2">
                                            Durée (minutes)
                                        </label>
                                        <input type="number"
                                               id="duree_minutes"
                                               name="duree_minutes"
                                               value="<?= $_POST['duree_minutes'] ?? $seance['duree_minutes'] ?>"
                                               min="15"
                                               max="480"
                                               step="15"
                                               class="w-full px-4 py-3 border border-chien-beige-300 rounded-lg focus:border-chien-primary focus:ring-2 focus:ring-chien-primary/20">
                                    </div>

                                    <div>
                                        <label for="prix" class="block text-sm font-medium text-chien-terracotta-700 mb-2">
                                            Prix (CHF)
                                        </label>
                                        <input type="number"
                                               id="prix"
                                               name="prix"
                                               value="<?= $_POST['prix'] ?? $seance['prix'] ?>"
                                               min="0"
                                               step="0.01"
                                               placeholder="0.00"
                                               class="w-full px-4 py-3 border border-chien-beige-300 rounded-lg focus:border-chien-primary focus:ring-2 focus:ring-chien-primary/20">
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <label for="lieu" class="block text-sm font-medium text-chien-terracotta-700 mb-2">
                                        Lieu de la séance
                                    </label>
                                    <input type="text"
                                           id="lieu"
                                           name="lieu"
                                           value="<?= htmlspecialchars($_POST['lieu'] ?? $seance['lieu']) ?>"
                                           placeholder="Ex: Parc de la Grange, À domicile, Cabinet..."
                                           class="w-full px-4 py-3 border border-chien-beige-300 rounded-lg focus:border-chien-primary focus:ring-2 focus:ring-chien-primary/20">
                                </div>
                            </div>

                            <!-- client et chien -->
                            <div class="border-b border-chien-beige-200 pb-6">
                                <h2 class="text-xl font-bold text-chien-terracotta-700 mb-4">
                                    Client et chien
                                </h2>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="client_id" class="block text-sm font-medium text-chien-terracotta-700 mb-2">
                                            Client <span class="text-red-500">*</span>
                                        </label>
                                        <select id="client_id"
                                                name="client_id"
                                                required
                                                onchange="loadChiens(this.value)"
                                                class="w-full px-4 py-3 border border-chien-beige-300 rounded-lg focus:border-chien-primary focus:ring-2 focus:ring-chien-primary/20">
                                            <option value="">
                                                Sélectionner un client
                                            </option>
                                            <?php foreach ($clients as $clientItem): ?>
                                                <option value="<?= $clientItem['id'] ?>"
                                                    <?= ($_POST['client_id'] ?? $seance['client_id']) === $clientItem['id'] ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($clientItem['prenom'] . ' ' . $clientItem['nom']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div>
                                        <label for="chien_id" class="block text-sm font-medium text-chien-terracotta-700 mb-2">
                                            Chien <span class="text-red-500">*</span>
                                        </label>
                                        <select id="chien_id"
                                                name="chien_id"
                                                required
                                                class="w-full px-4 py-3 border border-chien-beige-300 rounded-lg focus:border-chien-primary focus:ring-2 focus:ring-chien-primary/20">
                                            <option value="">
                                                Sélectionner un chien
                                            </option>
                                            <?php if (!empty($chiensClient)): ?>
                                                <?php foreach ($chiensClient as $chien): ?>
                                                    <option value="<?= $chien['id'] ?>"
                                                        <?= ($_POST['chien_id'] ?? $seance['chien_id']) === $chien['id'] ? 'selected' : '' ?>>
                                                        <?= htmlspecialchars($chien['nom']) ?>
                                                        <?php if (!empty($chien['race'])): ?>
                                                            (<?= htmlspecialchars($chien['race']) ?>)
                                                        <?php endif; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- description et notes -->
                            <div>
                                <h2 class="text-xl font-bold text-chien-terracotta-700 mb-4">
                                    Détails
                                </h2>

                                <div class="space-y-4">
                                    <div>
                                        <label for="description" class="block text-sm font-medium text-chien-terracotta-700 mb-2">
                                            Description
                                        </label>
                                        <textarea id="description"
                                                  name="description"
                                                  rows="3"
                                                  placeholder="Objectifs de la séance, exercices prévus..."
                                                  class="w-full px-4 py-3 border border-chien-beige-300 rounded-lg focus:border-chien-primary focus:ring-2 focus:ring-chien-primary/20"><?= htmlspecialchars($_POST['description'] ?? $seance['description']) ?></textarea>
                                    </div>

                                    <div>
                                        <label for="notes_educateur" class="block text-sm font-medium text-chien-terracotta-700 mb-2">
                                            Notes éducateur
                                        </label>
                                        <textarea id="notes_educateur"
                                                  name="notes_educateur"
                                                  rows="3"
                                                  placeholder="Notes privées, préparation, matériel nécessaire..."
                                                  class="w-full px-4 py-3 border border-chien-beige-300 rounded-lg focus:border-chien-primary focus:ring-2 focus:ring-chien-primary/20"><?= htmlspecialchars($_POST['notes_educateur'] ?? $seance['notes_educateur']) ?></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- boutons -->
                            <div class="flex justify-end gap-4 pt-6 border-t border-chien-beige-200">
                                <a href="<?= URL_SEANCES_VIEW . $seance['id'] ?>"
                                   class="px-6 py-3 border border-chien-beige-300 text-chien-neutral rounded-lg hover:bg-chien-beige-50 transition-colors">
                                    Annuler
                                </a>
                                <button type="submit"
                                        class="bg-chien-primary text-white px-6 py-3 rounded-lg hover:bg-chien-primary-dark transition-colors font-medium shadow-md">
                                    Enregistrer les modifications
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- sidebar aide -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- aide -->
                    <div class="bg-chien-peach-50 border border-chien-peach-200 rounded-lg p-6">
                        <h3 class="font-bold text-chien-terracotta-700 mb-3">
                            💡 Conseils
                        </h3>
                        <ul class="text-sm text-chien-neutral space-y-2">
                            <li>
                                • Vérifiez que la nouvelle date ne conflicte pas avec d'autres séances
                            </li>
                            <li>
                                • Pensez à prévenir le client en cas de changement
                            </li>
                            <li>
                                • Les notes éducateur ne sont visibles que par vous
                            </li>
                            <li>
                                • Changez le statut selon l'avancement de la séance
                            </li>
                        </ul>
                    </div>

                    <!-- informations actuelles -->
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <h3 class="font-bold text-chien-terracotta-700 mb-3">
                            Informations actuelles
                        </h3>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-chien-neutral">Créée le :</span>
                                <span class="font-medium"><?= date('d/m/Y', strtotime($seance['date_creation'])) ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-chien-neutral">Modifiée le :</span>
                                <span class="font-medium"><?= date('d/m/Y', strtotime($seance['date_modification'])) ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-chien-neutral">Statut :</span>
                                <span class="px-2 py-1 text-xs rounded-full text-white
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script
        src="<?= ASSETS_JS ?>seances-form.js">
    </script>

<?php include_once __DIR__ . '/../components/footer.php'; ?>