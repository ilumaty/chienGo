<?php include_once __DIR__ . '/../components/header.php'; ?>

    <main class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-blue-100 flex items-center justify-center py-8 px-4">
        <div class="w-full max-w-sm md:max-w-md space-y-6">

            <!-- logo et titre -->
            <div class="text-center">
                <div class="flex justify-center mb-4">
                    <div class="bg-white p-3 md:p-4 rounded-full shadow-lg">
                        <img src="<?= ASSETS_LOGO ?>CG_O_B.svg"
                             alt="ChienGo Logo"
                             class="h-12 w-12 md:h-18 md:w-18">
                        <span class="hidden text-3xl md:text-4xl">
                            🐾
                        </span>
                    </div>
                </div>
                <h1 class="font-wash text-3xl md:text-4xl font-bold text-gray-900 mb-2">
                    Disconnect
                    <span class="text-chien-primary">
                        ChienGo
                    </span>
                </h1>
                <p class="font-pogonia text-gray-600 text-sm md:text-base">
                    Êtes-vous sûr de vouloir vous déconnecter ?
                </p>
            </div>

            <!-- infos user connecté -->
            <div class="font-pogonia bg-white rounded-xl md:rounded-2xl shadow-xl p-6 md:p-8 border border-gray-100">

                <!-- infos user -->
                <div class="text-center mb-6">
                    <div class="w-14 h-14 md:w-16 md:h-16 bg-chien-primary rounded-full flex items-center justify-center mx-auto mb-3 md:mb-4">
                    <span class="text-white text-xl md:text-2xl font-bold">
                        <?= strtoupper(substr($_SESSION['user']['prenom'] ?? $_SESSION['user']['nom'] ?? 'U', 0, 1)) ?>
                    </span>
                    </div>
                    <h3 class="text-base md:text-lg font-medium text-gray-900">
                        <?= htmlspecialchars($_SESSION['user']['prenom'] ?? '') ?>
                        <?= htmlspecialchars($_SESSION['user']['nom'] ?? '') ?>
                    </h3>
                    <p class="text-gray-500 text-xs md:text-sm break-all">
                        <?= htmlspecialchars($_SESSION['user']['email'] ?? '') ?>
                    </p>
                    <p class="text-gray-400 text-xs mt-2">
                        Connecté en tant que <?= $_SESSION['user']['role'] === 'admin' ? 'administrateur' : 'éducateur' ?>
                    </p>
                </div>

                <!-- form de déconnexion -->
                <form method="POST" class="space-y-4">

                    <!-- btn d'action -->
                    <div class="flex flex-col md:flex-row md:justify-center md:gap-4 space-y-3 md:space-y-0">
                        <button type="submit"
                                class="w-full md:w-auto bg-red-600 text-white py-3 px-6 rounded-lg font-medium hover:bg-red-700 transition-colors focus:outline-none focus:ring-4 focus:ring-red-200 text-sm md:text-base">
                            Oui, me déconnecter
                        </button>

                        <a href="<?= URL_DASHBOARD ?>"
                           class="w-full md:w-auto bg-gray-500 text-white py-3 px-6 rounded-lg font-medium hover:bg-gray-600 transition-colors text-center text-sm md:text-base">
                            Annuler
                        </a>
                    </div>

                    <!-- lien retour dashboard -->
                    <div class="text-center">
                        <a href="<?= URL_DASHBOARD ?>"
                           class="text-chien-primary hover:text-chien-secondary font-medium text-sm transition-colors">
                            ← Retour au tableau de bord
                        </a>
                    </div>
                </form>

                <!-- action alternatives + !masquées sur mobile! -->
                <div class="mt-6 pt-6 border-t border-gray-200 hidden sm:block">
                    <h4 class="text-sm font-medium text-gray-700 mb-3">
                        Actions rapides
                    </h4>
                    <div class="grid grid-cols-2 gap-2">
                        <a href="<?= URL_SEANCES_CREATE ?>"
                           class="text-center py-2 px-3 text-xs md:text-sm bg-chien-primary text-white rounded-lg hover:bg-chien-primary-dark transition-colors">
                            Nouvelle séance
                        </a>
                        <a href="<?= URL_CLIENTS_LIST?>"
                           class="text-center py-2 px-3 text-xs md:text-sm bg-chien-secondary text-white rounded-lg hover:bg-chien-peach-600 transition-colors">
                            Mes clients
                        </a>
                    </div>
                </div>
            </div>

            <!-- infos de sécurité -->
            <div class="font-pogonia text-center">
                <p class="text-xs md:text-sm text-gray-500 px-2">
                    Pour votre sécurité, votre session expirera automatiquement après
                    <strong>60 minutes</strong> d'inactivité.
                </p>
            </div>
        </div>
    </main>

    <script>
        // animation entrée au loading
        document.addEventListener('DOMContentLoaded', function() {
            const elements = document.querySelectorAll('.w-full.max-w-sm > *, .w-full.max-w-sm .md\\:max-w-md > *');
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

        // confirm avant déconnexion
        document.querySelector('form').addEventListener('submit', function(e) {
            const confirmed = confirm('Êtes-vous certain de vouloir vous déconnecter ?');
            if (!confirmed) {
                e.preventDefault();
            }
        });
    </script>

<?php include_once __DIR__ . '/../components/footer.php'; ?>