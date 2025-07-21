<?php include_once __DIR__ . '/../components/header.php'; ?>

<main class="min-h-screen bg-chien-beige-50">
    <div class="container mx-auto px-4 py-8">
        <!-- en-tête -->
        <div class="flex items-center mb-8">
            <a href="<?= URL_CLIENTS_LIST ?>"
               class="text-chien-primary hover:text-chien-primary-dark mr-4">
                ← Retour à la liste
            </a>
            <div>
                <h1 class="text-3xl font-bold text-chien-terracotta-800">
                    Nouveau Client
                </h1>
                <p class="text-chien-neutral">
                    Ajoutez un nouveau client à votre carnet
                </p>
            </div>
        </div>

        <!-- messages error -->
        <?php if (!empty($errors)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <ul class="list-disc list-inside">
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <!-- form -->
        <div class="bg-white rounded-xl shadow-md p-8">
            <form method="POST" class="space-y-6">
                <!-- informations perso -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="prenom" class="block text-sm font-medium text-chien-terracotta-700 mb-2">
                            Prénom <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               id="prenom"
                               name="prenom"
                               value="<?= htmlspecialchars($_POST['prenom'] ?? '') ?>"
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
                               value="<?= htmlspecialchars($_POST['nom'] ?? '') ?>"
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
                               value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                               class="w-full px-4 py-3 border border-chien-beige-300 rounded-lg focus:border-chien-primary focus:ring-2 focus:ring-chien-primary/20">
                    </div>

                    <div>
                        <label for="telephone" class="block text-sm font-medium text-chien-terracotta-700 mb-2">
                            Téléphone
                        </label>
                        <input type="tel"
                               id="telephone"
                               name="telephone"
                               value="<?= htmlspecialchars($_POST['telephone'] ?? '') ?>"
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
                           value="<?= htmlspecialchars($_POST['adresse'] ?? '') ?>"
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
                               value="<?= htmlspecialchars($_POST['ville'] ?? '') ?>"
                               class="w-full px-4 py-3 border border-chien-beige-300 rounded-lg focus:border-chien-primary focus:ring-2 focus:ring-chien-primary/20">
                    </div>

                    <div>
                        <label for="code_postal" class="block text-sm font-medium text-chien-terracotta-700 mb-2">
                            Code postal
                        </label>
                        <input type="text"
                               id="code_postal"
                               name="code_postal"
                               value="<?= htmlspecialchars($_POST['code_postal'] ?? '') ?>"
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
                              placeholder="Notes sur le client, préférences, remarques particulières..."
                              class="w-full px-4 py-3 border border-chien-beige-300 rounded-lg focus:border-chien-primary focus:ring-2 focus:ring-chien-primary/20"><?= htmlspecialchars($_POST['notes'] ?? '') ?></textarea>
                </div>

                <!-- boutons -->
                <div class="flex justify-end gap-4 pt-6 border-t border-chien-beige-200">
                    <a href="<?= URL_CLIENTS_LIST ?>"
                       class="px-6 py-3 border border-chien-beige-300 text-chien-neutral rounded-lg hover:bg-chien-beige-50 transition-colors">
                        Annuler
                    </a>
                    <button type="submit"
                            class="bg-chien-primary text-white px-6 py-3 rounded-lg hover:bg-chien-primary-dark transition-colors font-medium shadow-md">
                        Créer le client
                    </button>
                </div>
            </form>
        </div>

        <!-- aide -->
        <div class="mt-6 bg-chien-peach-50 border border-chien-peach-200 rounded-lg p-4">
            <h3 class="font-bold text-chien-terracotta-700 mb-2">
                Conseils
            </h3>
            <ul class="text-sm text-chien-neutral space-y-1">
                <li>
                    Les champs marqués d'un <span class="text-red-500">*</span> sont obligatoires…
                </li>
                <li>
                    Vous pourrez ajouter les chiens du client après sa création
                </li>
                <li>
                    L'email sera utilisé pour les notifications automatiques
                </li>
                <li>
                    Les notes vous aident à personnaliser vos séances
                </li>
            </ul>
        </div>
    </div>
</main>

<?php include_once __DIR__ . '/../components/footer.php'; ?> /