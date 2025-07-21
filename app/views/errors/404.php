<?php include_once __DIR__ . '/../components/header.php'; ?>

    <link rel="stylesheet" href="<?= ASSETS_CSS ?>404.css">

    <main class="relative min-h-screen bg-chien-beige-50 flex items-center justify-center overflow-hidden">

        <div class="absolute inset-0 flex items-center justify-center">
            <img src="<?= ASSETS_IMG ?>404.webp"
                 alt="Chien regardant droit devant"
                 class="w-96 h-96 md:w-[500px] md:h-[500px] object-cover opacity-20">
        </div>

        <div class="relative z-10 text-center px-4 max-w-2xl">
            <div class="mb-8">
                <div class="text-8xl md:text-9xl font-bold text-chien-terracotta-800 mb-6 drop-shadow-lg">
                    404
                </div>

                <h1 class="text-3xl md:text-4xl font-bold text-chien-terracotta-700 mb-4">
                    Wouf...! Cette page a filé comme un chien sans rappel.
                </h1>

                <p class="text-chien-neutral text-lg md:text-xl mb-8 leading-relaxed">
                    Pas encore bien dressée... mais on lui apprendra le rappel !
                </p>
            </div>

            <div class="space-y-4">
                <a href="<?= BASE_URL ?>index.php"
                   class="inline-block bg-chien-primary text-white px-8 py-4 rounded-xl text-lg font-semibold hover:bg-chien-terracotta-600 transition-all duration-300 transform hover:scale-105 shadow-lg">
                    Retour à l'accueil
                </a>

                <?php if (isset($_SESSION['user'])): ?>
                    <div class="mt-4">
                        <a href="<?= URL_DASHBOARD ?>"
                           class="inline-block bg-chien-terracotta-500 text-white px-6 py-3 rounded-lg text-base hover:bg-chien-terracotta-600 transition-colors">
                            Mon dashboard
                        </a>
                    </div>
                <?php endif; ?>
            </div>

            <div class="mt-12 text-sm text-gray-900 opacity-75">
                <p>Besoin d'aide ? Contactez-nous à
                    <a href="mailto:support@chiengo.com"
                       class="text-chien-primary hover:underline font-medium">
                        support@chiengo.com
                    </a>
                </p>
            </div>
        </div>
    </main>

<?php include_once __DIR__ . '/../components/footer.php'; ?>