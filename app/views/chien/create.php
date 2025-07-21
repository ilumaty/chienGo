<?php include_once __DIR__ . '/../components/header.php'; ?>
<?php $val = fn($name) => htmlspecialchars($_POST[$name] ?? ''); ?>


    <main class="min-h-screen bg-chien-beige-50">
        <div class="container mx-auto px-4 py-8">
            <h1 class="text-3xl font-bold text-chien-terracotta-800 mb-8 text-center">
                Ajouter un nouveau chien
            </h1>

            <?php if (!empty($_SESSION['error'])): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    <?= htmlspecialchars($_SESSION['error']) ?>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <?php if (!empty($_SESSION['success'])): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    <?= htmlspecialchars($_SESSION['success']) ?>
                </div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>

            <div class="bg-white rounded-xl shadow-md p-6 max-w-2xl mx-auto">
                <form
                    method="POST"
                    action="<?= URL_CHIENS_CREATE ?>"
                    class="space-y-4">
                    <div>
                        <label
                                class="block text-sm font-medium text-chien-terracotta-700 mb-1"
                                for="nom">
                            Nom <span class="text-red-500">*</span>
                        </label>
                        <input
                                type="text"
                                id="nom"
                                name="nom" required
                                value="<?= $val('nom') ?>"
                                class="w-full px-4 py-3 border border-chien-beige-300 rounded-lg focus:border-chien-primary focus:ring-2 focus:ring-chien-primary/20">
                    </div>

                    <div>
                        <label
                                class="block text-sm font-medium text-chien-terracotta-700 mb-1"
                                for="race">
                                Race
                        </label>
                        <input
                            type="text"
                            id="race"
                            name="race"
                            value="<?= $val('race') ?>"
                            class="w-full px-4 py-3 border border-chien-beige-300 rounded-lg focus:border-chien-primary focus:ring-2 focus:ring-chien-primary/20">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label
                                    class="block text-sm font-medium text-chien-terracotta-700 mb-1"
                                    for="age">
                                Âge
                            </label>
                            <input
                                type="number"
                                id="age"
                                name="age"
                                min="0"
                                max="20"
                                value="<?= $val('age') ?>"
                                class="w-full px-4 py-3 border border-chien-beige-300 rounded-lg focus:border-chien-primary focus:ring-2 focus:ring-chien-primary/20">
                        </div>

                        <div>
                            <label
                                    class="block text-sm font-medium text-chien-terracotta-700 mb-1"
                                    for="poids">
                                Poids (kg)
                            </label>
                            <input
                                type="number"
                                id="poids"
                                name="poids"
                                min="0"
                                max="100"
                                value="<?= $val('poids') ?>"
                                class="w-full px-4 py-3 border border-chien-beige-300 rounded-lg focus:border-chien-primary focus:ring-2 focus:ring-chien-primary/20">
                        </div>
                    </div>

                    <div>
                        <label
                                class="block text-sm font-medium text-chien-terracotta-700 mb-1"
                                for="couleur">
                            Couleur
                        </label>
                        <input
                            type="text"
                            id="couleur"
                            name="couleur"
                            value="<?= $val('couleur') ?>"
                            class="w-full px-4 py-3 border border-chien-beige-300 rounded-lg focus:border-chien-primary focus:ring-2 focus:ring-chien-primary/20">
                    </div>

                    <div>
                        <label
                                class="block text-sm font-medium text-chien-terracotta-700 mb-1"
                                for="sexe">
                            Sexe
                        </label>
                        <select
                                id="sexe"
                                name="sexe"
                            class="w-full px-4 py-3 border border-chien-beige-300 rounded-lg focus:border-chien-primary focus:ring-2 focus:ring-chien-primary/20">
                            <option value="">
                                -- Choisir --
                            </option>
                            <option value="male" <?= ($_POST['sexe'] ?? '') === 'male' ? 'selected' : '' ?>>
                                Mâle
                            </option>
                            <option value="femelle" <?= ($_POST['sexe'] ?? '') === 'femelle' ? 'selected' : '' ?>>
                                Femelle
                            </option>
                        </select>
                    </div>

                    <div>
                        <label
                                class="block text-sm font-medium text-chien-terracotta-700 mb-1"
                                for="caractere">
                            Caractère
                        </label>
                        <input
                            type="text"
                            id="caractere"
                            name="caractere"
                            value="<?= $val('caractere') ?>"
                            class="w-full px-4 py-3 border border-chien-beige-300 rounded-lg focus:border-chien-primary focus:ring-2 focus:ring-chien-primary/20">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-chien-terracotta-700 mb-1"
                                for="p-comportement">Problèmes de comportement
                        </label>
                        <textarea
                                name="problemes_comportement"
                                id="p-comportement"
                                rows="4"
                                class="w-full px-4 py-3 border border-chien-beige-300 rounded-lg focus:border-chien-primary focus:ring-2 focus:ring-chien-primary/20 resize-none"><?= trim($val('problemes_comportement')) ?></textarea>
                    </div>

                    <input
                        type="hidden"
                        name="client_id"
                        value="<?= htmlspecialchars($_GET['client_id'] ?? $_POST['client_id'] ?? '') ?>">

                    <div class="flex justify-center gap-4 mt-6">
                        <button type="submit"
                                class="bg-chien-primary text-white px-6 py-3 rounded-lg hover:bg-chien-primary-dark transition-colors">
                            Ajouter
                        </button>
                        <a href="<?= URL_CLIENTS_VIEW ?><?= htmlspecialchars($_GET['client_id'] ?? '') ?>"
                           class="text-sm text-chien-primary hover:underline">
                            Retour au client
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </main>

<?php include_once __DIR__ . '/../components/footer.php'; ?>