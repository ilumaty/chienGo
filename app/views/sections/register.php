<?php
$pageTitle = "Inscription || ChienGo";
$basePath = ".";
$baseUrl = ".";

include_once __DIR__ . '/../components/header.php';
?>

    <main class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-blue-100 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div class="text-center">
                <div class="flex justify-center mb-6">
                    <div class="bg-white p-4 rounded-full shadow-lg">
                        <img src="<?= ASSETS_LOGO ?>CG_O_B.svg"
                             alt="ChienGo Logo"
                             class="h-18 w-18">
                        <span class="hidden text-4xl">
                            🐾
                        </span>
                    </div>
                </div>
                <h1 class="font-wash text-5xl font-bold text-gray-900 mb-2">
                    Rejoindre <span class="text-chien-primary">ChienGo</span>
                </h1>
                <p class="font-pogonia text-gray-600">
                    Créez votre compte éducateur
                </p>
            </div>

            <!-- form -->
            <div class="font-pogonia bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
                <form class="space-y-6" action="#" method="POST">

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="nom" class="block text-sm font-medium text-gray-700 mb-2">
                                Nom
                            </label>
                            <input
                                id="nom"
                                name="nom"
                                type="text"
                                required
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-chien-primary focus:ring-4 focus:ring-blue-50 transition-all duration-200"
                                placeholder="Hook"
                            >
                        </div>
                        <div>
                            <label
                                    for="prenom"
                                    class="block text-sm font-medium text-gray-700 mb-2">
                                Prénom
                            </label>
                            <input
                                id="prenom"
                                name="prenom"
                                type="text"
                                required
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-chien-primary focus:ring-4 focus:ring-blue-50 transition-all duration-200"
                                placeholder="Tim"
                            >
                        </div>
                    </div>

                    <div>
                        <label
                                for="email"
                                class="block text-sm font-medium text-gray-700 mb-2">
                            Adresse email
                        </label>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            required
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-chien-primary focus:ring-4 focus:ring-blue-50 transition-all duration-200"
                            placeholder="tim@example.com"
                        >
                    </div>

                    <div>
                        <label for="telephone" class="block text-sm font-medium text-gray-700 mb-2">
                            Téléphone
                        </label>
                        <input
                            id="telephone"
                            name="telephone"
                            type="tel"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-chien-primary focus:ring-4 focus:ring-blue-50 transition-all duration-200"
                            placeholder="+41 79 123 45 67"
                        >
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Mot de passe
                        </label>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            required
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-chien-primary focus:ring-4 focus:ring-blue-50 transition-all duration-200"
                            placeholder="••••••••••••"
                        >
                    </div>

                    <div>
                        <label for="password_confirm" class="block text-sm font-medium text-gray-700 mb-2">
                            Confirmer le mot de passe
                        </label>
                        <input
                            id="password_confirm"
                            name="password_confirm"
                            type="password"
                            required
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-chien-primary focus:ring-4 focus:ring-blue-50 transition-all duration-200"
                            placeholder="••••••••••••"
                        >
                    </div>

                    <div class="flex items-center">
                        <input
                            id="conditions"
                            name="conditions"
                            type="checkbox"
                            required
                            class="h-4 w-4 text-chien-primary border-gray-300 rounded focus:ring-chien-primary focus:ring-2"
                        >
                        <label for="conditions" class="ml-2 block text-sm text-gray-700">
                            J'accepte les <a href="#" class="text-chien-primary hover:underline">conditions d'utilisation</a>
                        </label>
                    </div>

                    <button
                        type="submit"
                        class="w-full bg-chien-primary hover:bg-chien-secondary text-white font-semibold py-3 px-4 rounded-xl transition-all duration-200 transform hover:scale-105 hover:shadow-lg"
                    >
                        Créer mon compte
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-gray-600">
                        Déjà un compte ?
                        <a href="<?= URL_LOGIN ?>" class="text-chien-primary hover:text-chien-secondary font-medium transition-colors ml-1">
                            Se connecter
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </main>

<?php include_once __DIR__ . '/../components/footer.php'; ?>