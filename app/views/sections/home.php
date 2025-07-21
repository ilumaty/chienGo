<?php
/* structure HTML:
<main>; ouverts dans header.php */
?>

<?php
include_once __DIR__ . '/../components/header.php';
?>

    <link rel="stylesheet" href="<?= ASSETS_CSS ?>slider.css">

        <section class="relative h-screen w-full bg-cover bg-center bg-no-repeat" style="background-image: url('<?= ASSETS_IMG ?>home_back.webp');">
            <div class="absolute inset-0 bg-black/50"></div>
            <div class="absolute inset-0 flex flex-col items-center justify-center text-white text-center px-4">
                <h1 class="font-wash text-4xl md:text-6xl font-bold mb-8 drop-shadow-lg">
                    Bienvenue sur
                    <span class="text-chien-primary">
                        ChienGo
                    </span>
                </h1>
                <p class="font-pogonia text-xl md:text-2xl mb-12 max-w-3xl drop-shadow-md leading-relaxed opacity-95">
                    Organisez, planifiez et gérez votre répertoire de séances canines en tant qu'éducateur professionnel
                </p>

                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="<?= URL_SEANCES ?>"
                       class="font-pogonia bg-chien-surface text-chien-primary-dark font-semibold py-4 px-8 rounded-xl text-lg shadow-lg hover:bg-chien-beige-100 transition-all transform hover:scale-105 hover:shadow-xl">
                        Voir nos séances
                    </a>
                    <a href="<?= URL_LOGIN ?>"
                       class="bg-chien-primary text-white font-semibold py-4 px-8 rounded-xl text-lg shadow-lg hover:bg-chien-primary-dark transition-all transform hover:scale-105 hover:shadow-xl">
                        Espace Éduc
                    </a>
                </div>
            </div>
        </section>

    <section class="py-20 bg-gradient-to-b from-chien-surface to-chien-beige-50">
        <div class="container mx-auto px-4">
            <h2 class="font-wash text-4xl font-bold text-center mb-4 text-chien-terracotta-800">
                La plateforme ChienGo
            </h2>
            <p class="font-pogonia text-center text-chien-neutral mb-16 text-lg max-w-2xl mx-auto">
                Conçue par un éducateur, pour des éducateurs
            </p>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">

                <div class="bg-white rounded-xl shadow-md border border-chien-peach-200 hover:shadow-lg transition-shadow overflow-hidden">

                    <div class="relative h-40 overflow-hidden bg-gray-50">
                        <img src="<?= ASSETS_IMG ?>ft_home/planning.webp"
                             class="w-full h-full object-cover object-center transform scale-90"
                             alt="Planning intelligent">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                                <svg class="w-5 h-5 text-white" viewBox="0 0 24 24">
                                    <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 text-center">
                        <h3 class="text-lg font-bold text-chien-terracotta-700 mb-3">
                            Planning intelligent
                        </h3>
                        <p class="text-chien-neutral text-sm">
                            Fini les oublis ! Organisez vos séances sans vous tromper
                        </p>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md border border-chien-peach-200 hover:shadow-lg transition-shadow overflow-hidden">

                    <div class="relative h-40 overflow-hidden bg-gray-50">
                        <img src="<?= ASSETS_IMG ?>ft_home/client&dog.webp"
                             class="w-full h-full object-contain"
                             alt="Clients et chiens">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                                <svg class="w-5 h-5 text-white" viewBox="0 0 24 24">
                                    <path d="M12 12C14.21 12 16 10.21 16 8S14.21 4 12 4 8 5.79 8 8 9.79 12 12 12ZM12 14C9.33 14 4 15.34 4 18V20H20V18C20 15.34 14.67 14 12 14Z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 text-center">
                        <h3 class="text-lg font-bold text-chien-terracotta-700 mb-3">
                            Clients & Chiens
                        </h3>
                        <p class="text-chien-neutral text-sm">
                            Carnet complet avec profils détaillés et historique comportemental
                        </p>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md border border-chien-peach-200 hover:shadow-lg transition-shadow overflow-hidden">

                    <div class="relative h-40 overflow-hidden bg-gray-50">
                        <img src="<?= ASSETS_IMG ?>ft_home/f_simple.webp"
                             class="w-full h-full object-contain"
                             alt="Simple et rapide">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                                <svg class="w-5 h-5 text-white" viewBox="0 0 24 24">
                                    <path d="M13,2.05V5.08C16.39,5.57 19,8.47 19,12C19,12.9 18.82,13.75 18.5,14.54L21.12,16.07C21.68,14.83 22,13.45 22,12C22,6.82 18.05,2.55 13,2.05M12,19A7,7 0 0,1 5,12C5,8.47 7.61,5.57 11,5.08V2.05C5.94,2.55 2,6.81 2,12A10,10 0 0,0 12,22C15.3,22 18.23,20.39 20.07,17.93L17.54,16.5C16.04,18.47 14.15,19 12,19Z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 text-center">
                        <h3 class="text-lg font-bold text-chien-terracotta-700 mb-3">
                            Simple & Rapide
                        </h3>
                        <p class="text-chien-neutral text-sm">
                            Interface intuitive : créez une séance en 30 secondes chrono
                        </p>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md border border-chien-peach-200 hover:shadow-lg transition-shadow overflow-hidden">
                    <div class="relative h-40 overflow-hidden bg-gray-50">
                        <img src="<?= ASSETS_IMG ?>ft_home/finances.webp"
                             class="w-full h-full object-contain"
                             alt="Suivi financier">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                                <svg class="w-5 h-5 text-white" viewBox="0 0 24 24">
                                    <path d="M11.8,10.9C9.53,10.31 8.8,9.7 8.8,8.75C8.8,7.66 9.81,6.9 11.5,6.9C13.28,6.9 13.94,7.75 14,9H16.21C16.14,7.28 15.09,5.7 13,5.19V3H10V5.16C8.06,5.58 6.5,6.84 6.5,8.77C6.5,11.08 8.41,12.23 11.2,12.9C13.7,13.5 14.2,14.38 14.2,15.31C14.2,16 13.71,17.1 11.5,17.1C9.44,17.1 8.63,16.18 8.5,15H6.32C6.44,17.19 8.08,18.42 10,18.83V21H13V18.85C14.95,18.5 16.5,17.35 16.5,15.3C16.5,12.46 14.07,11.5 11.8,10.9Z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 text-center">
                        <h3 class="text-lg font-bold text-chien-terracotta-700 mb-3">
                            Suivi financier
                        </h3>
                        <p class="text-chien-neutral text-sm">
                            Dashboard avec revenus, statistiques et analyse d'activité
                        </p>
                    </div>
                </div>
                </div>
            </div>
    </section>

        <section class="font-pogonia py-16 bg-chien-primary text-white relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-r from-chien-terracotta-600 to-chien-primary opacity-90"></div>
            <div class="container mx-auto px-4 text-center relative z-10">
                <h2 class="text-3xl font-bold mb-4">
                    Prêt à optimiser votre activité d'éducateur ?
                </h2>
                <p class="text-xl mb-8 opacity-95">
                    Rejoignez des éducateurs qui font déjà confiance à ChienGo
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="<?= URL_REGISTER ?>"
                       class="bg-chien-surface text-chien-primary font-bold py-3 px-8 rounded-xl text-lg hover:bg-chien-beige-100 transition-all transform hover:scale-105 shadow-lg">
                        Créer mon compte
                    </a>
                    <a href="<?= URL_SEANCES ?>"
                       class="border-2 border-chien-surface text-chien-surface font-bold py-3 px-8 rounded-xl text-lg hover:bg-chien-surface hover:text-chien-primary transition-all">
                        Découvrir nos séances
                    </a>
                </div>
            </div>
        </section>

        <section class="font-pogonia py-16 bg-chien-beige-50">
            <div class="container mx-auto px-4">
                <div class="text-center mb-12">
                    <h2 class="font-wash text-4xl font-bold text-chien-terracotta-800 mb-4">
                        Notre equipe en action
                    </h2>
                    <p class="text-chien-neutral text-lg max-w-2xl mx-auto">
                        Découvrez nos éducateurs passionnés et nos compagnons à quatre pattes
                    </p>
                </div>

                <div class="relative max-w-4xl mx-auto">
                    <div class="slider-container overflow-hidden rounded-2xl shadow-xl">
                        <div class="slider-wrapper flex transition-transform duration-500 ease-in-out" id="slider">

                            <div class="slide w-full flex-shrink-0 relative">
                                <img src="<?= ASSETS_IMG ?>slider/edPro_leo.webp"
                                     alt="Éducateur travaillant avec deux chiens"
                                     class="w-full h-96 md:h-[500px] object-cover">
                                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-6">
                                    <h3 class="text-white text-xl font-bold mb-2">
                                        Séance d'éducation
                                    </h3>
                                    <p class="text-white/90">
                                        Formation individualisée pour un apprentissage optimal
                                    </p>
                                </div>
                            </div>

                            <div class="slide w-full flex-shrink-0 relative">
                                <img src="<?= ASSETS_IMG ?>slider/ED_portrait.webp"
                                     alt="Portrait de l'éducateur Léo"
                                     class="w-full h-96 md:h-[500px] object-cover">
                                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-6">
                                    <h3 class="text-white text-xl font-bold mb-2">
                                        Léo, Éducateur diplômé
                                    </h3>
                                    <p class="text-white/90">
                                        Fondateur de ChienGo, passionné par la lecture canine
                                    </p>
                                </div>
                            </div>

                            <div class="slide w-full flex-shrink-0 relative">
                                <img src="<?= ASSETS_IMG ?>slider/dogs_group.webp"
                                     alt="Groupe de chiens en séance collective"
                                     class="w-full h-96 md:h-[500px] object-cover">
                                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-6">
                                    <h3 class="text-white text-xl font-bold mb-2">
                                        Séances collectives
                                    </h3>
                                    <p class="text-white/90">
                                        Socialisation et apprentissage en groupe
                                    </p>
                                </div>
                            </div>

                            <div class="slide w-full flex-shrink-0 relative">
                                <img src="<?= ASSETS_IMG ?>slider/at_home_train.webp"
                                     alt="Séance d'éducation à domicile"
                                     class="w-full h-96 md:h-[500px] object-cover">
                                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-6">
                                    <h3 class="text-white text-xl font-bold mb-2">
                                        À domicile
                                    </h3>
                                    <p class="text-white/90">
                                        Intervention personnalisée dans votre environnement
                                    </p>
                                </div>
                            </div>

                            <div class="slide w-full flex-shrink-0 relative">
                                <img src="<?= ASSETS_IMG ?>slider/dog_complice.webp"
                                     alt="Moment complice entre éducateur et chien"
                                     class="w-full h-96 md:h-[500px] object-cover">
                                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-6">
                                    <h3 class="text-white text-xl font-bold mb-2">
                                        Complicité
                                    </h3>
                                    <p class="text-white/90">
                                        Créer un lien de confiance durable
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-white/80 hover:bg-white text-chien-primary p-3 rounded-full shadow-lg transition-all duration-300 hover:scale-110"
                            onclick="previousSlide()">
                        <svg class="w-6 h-6" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>

                    <button class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-white/80 hover:bg-white text-chien-primary p-3 rounded-full shadow-lg transition-all duration-300 hover:scale-110"
                            onclick="nextSlide()">
                        <svg class="w-6 h-6" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>

                    <div class="flex justify-center mt-6 space-x-2">
                        <button class="dot w-3 h-3 rounded-full bg-chien-primary transition-all duration-300" onclick="currentSlide(1)"></button>
                        <button class="dot w-3 h-3 rounded-full bg-chien-neutral/40 hover:bg-chien-primary/60 transition-all duration-300" onclick="currentSlide(2)"></button>
                        <button class="dot w-3 h-3 rounded-full bg-chien-neutral/40 hover:bg-chien-primary/60 transition-all duration-300" onclick="currentSlide(3)"></button>
                        <button class="dot w-3 h-3 rounded-full bg-chien-neutral/40 hover:bg-chien-primary/60 transition-all duration-300" onclick="currentSlide(4)"></button>
                        <button class="dot w-3 h-3 rounded-full bg-chien-neutral/40 hover:bg-chien-primary/60 transition-all duration-300" onclick="currentSlide(5)"></button>
                    </div>
                </div>
            </div>
        </section>
    </main>


<?php
include_once __DIR__ . '/../components/footer.php';
?>