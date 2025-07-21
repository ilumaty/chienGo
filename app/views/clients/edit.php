<?php include_once __DIR__ . '/../components/header.php'; ?>

<?php
// vérify de sécurité pour $client
if (!isset($client)) {
    header('Location: index.php?page=clients&action=list');
    exit;
}
?>

    <main class="min-h-screen bg-chien-beige-50">
        <div class="container mx-auto px-4 py-8">
            <!-- en-tête -->
            <div class="flex items-center mb-8">
                <a href="<?= URL_CLIENTS_VIEW . $client['id'] ?>"
                   class="text-chien-primary hover:text-chien-primary-dark mr-4">
                    ← Retour
                </a>
                <div>
                    <h1 class="text-3xl font-bold text-chien-terracotta-800">
                        Modifier le client
                    </h1>
                    <p class="text-chien-neutral">
                        <?= htmlspecialchars($client['prenom'] . ' ' . $client['nom']) ?>
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

            <!-- formulaire -->
            <div class="bg-white rounded-xl shadow-md p-8">
                <form method="POST" class="space-y-6">
                    <!-- informations personnelles -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="prenom" class="block text-sm font-medium text-chien-terracotta-700 mb-2">
                                Prénom <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                   id="prenom"
                                   name="prenom"
                                   value="<?= htmlspecialchars($_POST['prenom'] ?? $client['prenom']) ?>"
                                   required
                                   class="w-full px-4 py-3 border border-chien-beige-300 rounded-lg focus:border-chien-primary focus:ring-2 focus:ring-chien-primary/20">
                        </div>

                        <div>
                            <label for="nom" class="block text-sm font-medium text-chien-terracotta-700 mb-2">
                                Nom <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                   id="nom"
                                   name="nom"
                                   value="<?= htmlspecialchars($_POST['nom'] ?? $client['nom']) ?>"
                                   required
                                   class="w-full px-4 py-3 border border-chien-beige-300 rounded-lg focus:border-chien-primary focus:ring-2 focus:ring-chien-primary/20">
                        </div>
                    </div>

                    <!-- contact -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="email" class="block text-sm font-medium text-chien-terracotta-700 mb-2">
                                Email
                            </label>
                            <input type="email"
                                   id="email"
                                   name="email"
                                   value="<?= htmlspecialchars($_POST['email'] ?? $client['email']) ?>"
                                   class="w-full px-4 py-3 border border-chien-beige-300 rounded-lg focus:border-chien-primary focus:ring-2 focus:ring-chien-primary/20">
                        </div>

                        <div>
                            <label for="telephone" class="block text-sm font-medium text-chien-terracotta-700 mb-2">
                                Téléphone
                            </label>
                            <input type="tel"
                                   id="telephone"
                                   name="telephone"
                                   value="<?= htmlspecialchars($_POST['telephone'] ?? $client['telephone']) ?>"
                                   placeholder="+41 79 123 45 67"
                                   class="w-full px-4 py-3 border border-chien-beige-300 rounded-lg focus:border-chien-primary focus:ring-2 focus:ring-chien-primary/20">
                        </div>
                    </div>

                    <!-- adresse -->
                    <div>
                        <label for="adresse" class="block text-sm font-medium text-chien-terracotta-700 mb-2">
                            Adresse
                        </label>
                        <input type="text"
                               id="adresse"
                               name="adresse"
                               value="<?= htmlspecialchars($_POST['adresse'] ?? $client['adresse']) ?>"
                               placeholder="Rue et numéro"
                               class="w-full px-4 py-3 border border-chien-beige-300 rounded-lg focus:border-chien-primary focus:ring-2 focus:ring-chien-primary/20">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="ville" class="block text-sm font-medium text-chien-terracotta-700 mb-2">
                                Ville
                            </label>
                            <input type="text"
                                   id="ville"
                                   name="ville"
                                   value="<?= htmlspecialchars($_POST['ville'] ?? $client['ville']) ?>"
                                   class="w-full px-4 py-3 border border-chien-beige-300 rounded-lg focus:border-chien-primary focus:ring-2 focus:ring-chien-primary/20">
                        </div>

                        <div>
                            <label for="code_postal" class="block text-sm font-medium text-chien-terracotta-700 mb-2">
                                Code postal
                            </label>
                            <input type="text"
                                   id="code_postal"
                                   name="code_postal"
                                   value="<?= htmlspecialchars($_POST['code_postal'] ?? $client['code_postal']) ?>"
                                   placeholder="1000"
                                   maxlength="6"
                                   class="w-full px-4 py-3 border border-chien-beige-300 rounded-lg focus:border-chien-primary focus:ring-2 focus:ring-chien-primary/20">
                        </div>
                    </div>

                    <!-- notes -->
                    <div>
                        <label for="notes" class="block text-sm font-medium text-chien-terracotta-700 mb-2">
                            Notes / Remarques
                        </label>
                        <textarea id="notes"
                                  name="notes"
                                  rows="4"
                                  style="resize: none;"
                                  placeholder="Notes sur le client, préférences, remarques particulières..."
                                  class="w-full px-4 py-3 border border-chien-beige-300 rounded-lg focus:border-chien-primary focus:ring-2 focus:ring-chien-primary/20"><?= htmlspecialchars($_POST['notes'] ?? $client['notes']) ?></textarea>
                    </div>

                    <!-- boutons -->
                    <div class="flex justify-end gap-4 pt-6 border-t border-chien-beige-200">
                        <a href="<?= URL_CLIENTS_VIEW . $client['id'] ?>"
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
    </main>

<?php include_once __DIR__ . '/../components/footer.php'; ?>