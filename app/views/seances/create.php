<?php
    require_once __DIR__ . '/../../config/config.php';
    include_once __DIR__ . '/../components/header.php';
    ?>

<?php
// vérif de sécurité
if (!isset($typesSeances)) {
    $typesSeances = [];
}
if (!isset($clients)) {
    $clients = [];
}
if (!isset($preselectedClient)) {
    $preselectedClient = null;
}
if (!isset($preselectedChien)) {
    $preselectedChien = null;
}
?>

    <main class="min-h-screen bg-chien-beige-50">
        <div class="container mx-auto px-4 py-8">
            <!-- en-tête -->
            <div class="flex items-center mb-8">
                <a href="<?= URL_SEANCES_PRIVATE ?>"
                   class="text-chien-primary hover:text-chien-primary-dark mr-4">
                    ← Retour au planning
                </a>
                <div>
                    <h1 class="text-3xl font-bold text-chien-terracotta-800">
                        Nouvelle Séance
                    </h1>
                    <p class="text-chien-neutral">
                        Planifiez une nouvelle séance d'éducation canine
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
                                        <label
                                                for="titre"
                                                class="block text-sm font-medium text-chien-terracotta-700 mb-2">
                                            Titre de la séance <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text"
                                               id="titre"
                                               name="titre"
                                               value="<?= htmlspecialchars($_POST['titre'] ?? '') ?>"
                                               required
                                               placeholder="Ex: Séance d'éducation de base avec Max"
                                               class="w-full px-4 py-3 border border-chien-beige-300 rounded-lg focus:border-chien-primary focus:ring-2 focus:ring-chien-primary/20">
                                    </div>

                                    <div>
                                        <label
                                                for="type_seance_id"
                                                class="block text-sm font-medium text-chien-terracotta-700 mb-2">
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
                                                    <?= ($_POST['type_seance_id'] ?? '') === $type['id'] ? 'selected' : '' ?>>
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
                                            <option value="planifiee" <?= ($_POST['statut'] ?? 'planifiee') === 'planifiee' ? 'selected' : '' ?>>
                                                Planifiée
                                            </option>
                                            <option value="confirmee" <?= ($_POST['statut'] ?? '') === 'confirmee' ? 'selected' : '' ?>>
                                                Confirmée
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
                                               value="<?= $_POST['date_seance'] ?? '' ?>"
                                               required
                                               min="<?= date('Y-m-d\TH:i') ?>"
                                               class="w-full px-4 py-3 border border-chien-beige-300 rounded-lg focus:border-chien-primary focus:ring-2 focus:ring-chien-primary/20">
                                    </div>

                                    <div>
                                        <label for="duree_minutes" class="block text-sm font-medium text-chien-terracotta-700 mb-2">
                                            Durée (minutes)
                                        </label>
                                        <input type="number"
                                               id="duree_minutes"
                                               name="duree_minutes"
                                               value="<?= $_POST['duree_minutes'] ?? '60' ?>"
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
                                               value="<?= $_POST['prix'] ?? '' ?>"
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
                                           value="<?= htmlspecialchars($_POST['lieu'] ?? '') ?>"
                                           placeholder="Ex: Parc de la Grange, À domicile, Cabinet..."
                                           class="w-full px-4 py-3 border border-chien-beige-300 rounded-lg focus:border-chien-primary focus:ring-2 focus:ring-chien-primary/20">
                                </div>
                            </div>

                            <!-- client et chien -->
                            <div class="border-b border-chien-beige-200 pb-6">
                                <h2 class="text-xl font-bold text-chien-terracotta-700 mb-4">👤 Client et chien</h2>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="client_id" class="block text-sm font-medium text-chien-terracotta-700 mb-2">
                                            Client <span class="text-red-500">*</span>
                                        </label>
                                        <select id="client_id"
                                                name="client_id"
                                                class="w-full px-4 py-3 border border-chien-beige-300 rounded-lg focus:border-chien-primary focus:ring-2 focus:ring-chien-primary/20">
                                            <option value="">
                                                Sélectionner un client
                                            </option>
                                            <?php foreach ($clients as $client): ?>
                                                <option value="<?= $client['id'] ?>"
                                                    <?= ($_POST['client_id'] ?? $preselectedClient) === $client['id'] ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($client['prenom'] . ' ' . $client['nom']) ?>
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
                                                        <?= ($_POST['chien_id'] ?? $preselectedChien) === $chien['id'] ? 'selected' : '' ?>>
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
                                                  style="resize: none;"
                                                  placeholder="Objectifs de la séance, exercices prévus..."
                                                  class="w-full px-4 py-3 border border-chien-beige-300 rounded-lg focus:border-chien-primary focus:ring-2 focus:ring-chien-primary/20"><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
                                    </div>

                                    <div>
                                        <label for="notes_educateur" class="block text-sm font-medium text-chien-terracotta-700 mb-2">
                                            Notes éducateur
                                        </label>
                                        <textarea id="notes_educateur"
                                                  name="notes_educateur"
                                                  rows="3"
                                                  style="resize: none;"
                                                  placeholder="Notes privées, préparation, matériel nécessaire..."
                                                  class="w-full px-4 py-3 border border-chien-beige-300 rounded-lg focus:border-chien-primary focus:ring-2 focus:ring-chien-primary/20"><?= htmlspecialchars($_POST['notes_educateur'] ?? '') ?></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- boutons -->
                            <div class="flex justify-end gap-4 pt-6 border-t border-chien-beige-200">
                                <a href="<?= URL_SEANCES_PRIVATE ?>"
                                   class="px-6 py-3 border border-chien-beige-300 text-chien-neutral rounded-lg hover:bg-chien-beige-50 transition-colors">
                                    Annuler
                                </a>
                                <button type="submit"
                                        class="bg-chien-primary text-white px-6 py-3 rounded-lg hover:bg-chien-primary-dark transition-colors font-medium shadow-md">
                                    Créer la séance
                                </button>
                            </div>
                        </form>
                        <div id="customModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
                            <div class="bg-white rounded-lg shadow-lg max-w-sm w-full p-6 text-center">
                                <p id="customModalMessage" class="text-chien-terracotta-700 mb-4 font-medium"></p>
                                <div class="flex justify-center gap-4">
                                    <button id="customModalCancel" class="px-4 py-2 border border-chien-beige-300 rounded hover:bg-chien-beige-50">
                                        Annuler
                                    </button>
                                    <button id="customModalOk" class="px-4 py-2 bg-chien-primary text-white rounded hover:bg-chien-primary-dark">
                                        OK
                                    </button>
                                </div>
                            </div>
                        </div>
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
                                • Sélectionnez un type de séance pour pré-remplir la durée et le prix
                            </li>
                            <li>
                                • Vérifiez votre planning pour éviter les conflits d'horaires
                            </li>
                            <li>
                                • Les notes Educ ne sont visibles que par vous
                            </li>
                            <li>
                                • Pensez à confirmer la séance avec le client
                            </li>
                        </ul>
                    </div>

                    <!-- prochaines séances (pour éviter les conflits) -->
                    <?php if (!empty($seancesUpcoming)): ?>
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <h3 class="font-bold text-chien-terracotta-700 mb-3">
                                Prochaines séances
                            </h3>
                            <div class="space-y-2">
                                <?php foreach (array_slice($seancesUpcoming, 0, 3) as $seance): ?>
                                    <div class="text-sm p-2 bg-chien-beige-50 rounded">
                                        <div class="font-medium"><?= date('d/m H:i', strtotime($seance['date_seance'])) ?></div>
                                        <div class="text-chien-neutral"><?= htmlspecialchars($seance['chien_nom']) ?></div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- types de séances disponibles -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="font-bold text-chien-terracotta-700 mb-3">
                            Types de séances
                        </h3>
                        <div class="space-y-2">
                            <?php foreach ($typesSeances as $type): ?>
                                <div class="text-sm p-3 border border-chien-beige-200 rounded-lg hover:bg-chien-beige-50 cursor-pointer"
                                     onclick="selectType(<?= $type['id'] ?>, '<?= htmlspecialchars($type['nom']) ?>', <?= $type['duree_minutes'] ?>, <?= $type['prix'] ?? 0 ?>)">
                                    <div class="font-medium text-chien-terracotta-700"><?= htmlspecialchars($type['nom']) ?></div>
                                    <div class="text-chien-neutral">
                                        <?= $type['duree_minutes'] ?> min
                                        <?php if ($type['prix']): ?>
                                            • <?= number_format($type['prix']) ?> CHF
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script
        src="<?= ASSETS_JS ?>seances-form.js">
    </script>


    <?php if (!empty($preselectedChien) || !empty($preselectedClient)): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            <?php
            try {
            if (!empty($preselectedChien)):
            $clientJson = json_encode($preselectedClient ?? null, JSON_THROW_ON_ERROR);
            $chienJson = json_encode($preselectedChien, JSON_THROW_ON_ERROR);
            ?>
            setPreselectedData(<?= $clientJson ?>, <?= $chienJson ?>);
            <?php
            elseif (!empty($preselectedClient)):
            $clientJson = json_encode($preselectedClient, JSON_THROW_ON_ERROR);
            ?>
            setPreselectedData(<?= $clientJson ?>, null);
            <?php
            endif;
            } catch (JsonException $e) {
            // En cas d'erreur JSON, on affiche un console.error
            echo "console.error('Erreur JSON: " . addslashes($e->getMessage()) . "');";
        }
            ?>
        });
    </script>
    <?php endif; ?>


<?php include_once __DIR__ . '/../components/footer.php'; ?>