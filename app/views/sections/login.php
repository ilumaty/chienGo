<?php
$pageTitle = "Connexion || ChienGo";
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
                    Connexion <span class="text-chien-primary">ChienGo</span>
                </h1>
                <p class="font-pogonia text-gray-600">
                    Accédez à votre espace éducateur
                </p>
            </div>

            <!-- form to connect -->
            <div class="font-pogonia bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
                <form class="space-y-6" action="<?= URL_LOGIN ?>" method="POST">

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Adresse email
                        </label>
                        <div class="relative">
                            <input
                                id="email"
                                name="email"
                                type="email"
                                required
                                class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-chien-primary focus:ring-4 focus:ring-blue-50 transition-all duration-200 text-gray-900 placeholder-gray-400"
                                placeholder="votre@email.com"
                            >
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Mot de passe
                        </label>
                        <div class="relative">
                            <input
                                id="password"
                                name="password"
                                type="password"
                                required
                                class="w-full pl-12 pr-12 py-3 border-2 border-gray-200 rounded-xl focus:border-chien-primary focus:ring-4 focus:ring-blue-50 transition-all duration-200 text-gray-900 placeholder-gray-400"
                                placeholder="••••••••"
                            >
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <button
                                type="button"
                                class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600"
                                onclick="togglePassword()"
                            >
                                <svg id="eye-closed" class="h-5 w-5" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L8.464 8.464m1.414 1.414L12 7.756l2.122 2.122m-4.242 4.242L8.464 15.536m1.414-1.414L12 16.244l2.122-2.122m4.242-4.242L21.536 8.464" />
                                </svg>
                                <svg id="eye-open" class="h-5 w-5 hidden" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- options -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input
                                id="remember-me"
                                name="remember-me"
                                type="checkbox"
                                class="h-4 w-4 text-chien-primary border-gray-300 rounded focus:ring-chien-primary focus:ring-2"
                            >
                            <label for="remember-me" class="ml-2 block text-sm text-gray-700">
                                Se souvenir de moi
                            </label>
                        </div>
                        <a href="#" class="text-sm text-chien-primary hover:text-chien-secondary font-medium transition-colors">
                            Mot de passe oublié ?
                        </a>
                    </div>

                    <!-- bouton de connexion -->
                    <button
                        type="submit"
                        class="w-full bg-chien-primary hover:bg-chien-secondary text-white font-semibold py-3 px-4 rounded-xl transition-all duration-200 transform hover:scale-105 hover:shadow-lg focus:outline-none focus:ring-4 focus:ring-blue-200"
                    >
                        Se connecter
                    </button>
                </form>

                <!-- diviser -->
                <div class="mt-6">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-200"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-4 bg-white text-gray-500">ou</span>
                        </div>
                    </div>
                </div>

                <!-- lien inscription -->
                <div class="mt-6 text-center">
                    <p class="text-gray-600">
                        Pas encore de compte ?
                        <a href="<?= URL_REGISTER ?>"
                           class="text-chien-primary hover:text-chien-secondary font-medium transition-colors ml-1">
                            Créer un compte
                        </a>
                    </p>
                </div>
            </div>

            <div class="font-pogonia text-center">
                <p class="text-sm text-gray-500">
                    En vous connectant, vous acceptez nos
                    <a href="#" class="text-chien-primary hover:underline">conditions d'utilisation</a>
                    et notre
                    <a href="#" class="text-chien-primary hover:underline">politique de confidentialité</a>
                </p>
            </div>
        </div>
    </main>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeClosed = document.getElementById('eye-closed');
            const eyeOpen = document.getElementById('eye-open');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeClosed.classList.add('hidden');
                eyeOpen.classList.remove('hidden');
            } else {
                passwordInput.type = 'password';
                eyeClosed.classList.remove('hidden');
                eyeOpen.classList.add('hidden');
            }
        }

        // animation d'entrée au chargement
        document.addEventListener('DOMContentLoaded', function() {
            const elements = document.querySelectorAll('.max-w-md > *');
            elements.forEach((el, index) => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    el.style.transition = 'all 0.6s ease';
                    el.style.opacity = '1';
                    el.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>

<?php include_once __DIR__ . '/../components/footer.php'; ?>