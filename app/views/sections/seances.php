<?php
include_once __DIR__ . '/../components/header.php';
?>

    <main class="min-h-screen relative">

        <div class="absolute inset-0 z-0">
            <div class="w-full h-full bg-cover bg-center" style="background-image: url('<?= ASSETS_IMG ?>seances/seances_back.webp');"></div>
            <div class="absolute inset-0 bg-gradient-to-b from-black/40 via-black/20 to-black/50"></div>
        </div>


        <section class="relative z-10 py-16">
            <div class="container mx-auto px-4">
                <div class="text-center mb-12">
                    <h1 class="text-4xl font-bold text-white mb-4 drop-shadow-lg">
                        Séances canines avec éducateur diplômé
                    </h1>
                    <p class="font-pogonia font-bold text-white/90 max-w-2xl mx-auto drop-shadow-md">
                        Formateur agréé et diplômé, Léo, fondateur de ChienGo, vous propose un accompagnement personnalisé : séances individuelles, en groupe ou à domicile, avec bilan comportemental inclus.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

                    <div class="font-pogonia bg-white/90 backdrop-blur-md rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 border border-chien-peach-100 overflow-hidden">
                        <div class="relative h-96 bg-cover bg-center" style="background-image: url('<?= ASSETS_IMG ?>seances/seance_individuelle.webp');">
                            <div class="absolute inset-0 bg-black/50"></div>
                            <div class="absolute inset-0 flex flex-col items-center justify-center p-6">
                                <div class="bg-white/20 backdrop-blur-sm rounded-xl p-6 text-center w-full">
                                    <h3 class="text-xl font-bold text-white drop-shadow-lg mb-3">
                                        Séance Individuelle
                                    </h3>
                                    <p class="text-white/90 text-sm mb-4 leading-relaxed">
                                        Un cours 100% personnalisé en fonction de la problématique rencontrée (rappel, marche en laisse, anxiété, cours chiot, etc.). Chaque séance comprend un suivi écrit avec la possibilité d'un accompagnement sur la durée.
                                    </p>
                                    <div class="flex justify-between items-center">
                                        <span class="text-2xl font-bold text-white drop-shadow-lg">
                                            120CHF
                                        </span>
                                        <button class="bg-chien-primary text-white px-4 py-2 rounded-lg hover:bg-chien-primary-dark transition-colors shadow-lg">
                                            Réserver
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="font-pogonia bg-white/90 backdrop-blur-md rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 border border-chien-peach-100 overflow-hidden">
                        <div class="relative h-96 bg-cover bg-center" style="background-image: url('<?= ASSETS_IMG ?>seances/seance_groupe.webp');">
                            <div class="absolute inset-0 bg-black/50"></div>
                            <div class="absolute inset-0 flex flex-col items-center justify-center p-6">
                                <div class="bg-white/20 backdrop-blur-sm rounded-xl p-6 text-center w-full">
                                    <h3 class="text-xl font-bold text-white drop-shadow-lg mb-3">
                                        Séance de Groupe
                                    </h3>
                                    <p class="text-white/90 text-sm mb-4 leading-relaxed">
                                        Travaillez l'obéissance et la socialisation avec d'autres chiens en toute sécurité (max. 6 chiens). Cette option sera intégrée dans le groupe via l'application calendrier, avec la possibilité de regrouper d'autres éducateurs canins pour des séances collaboratives.
                                    </p>
                                    <div class="flex justify-between items-center">
                                        <span class="text-2xl font-bold text-white drop-shadow-lg">
                                            45CHF
                                        </span>
                                        <button class="bg-chien-primary text-white px-4 py-2 rounded-lg hover:bg-chien-primary-dark transition-colors shadow-lg">
                                            Réserver
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="font-pogonia bg-white/90 backdrop-blur-md rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 border border-chien-peach-100 overflow-hidden">
                        <div class="relative h-96 bg-cover bg-center" style="background-image: url('<?= ASSETS_IMG ?>seances/seance_domicile.webp');">
                            <div class="absolute inset-0 bg-black/50"></div>
                            <div class="absolute inset-0 flex flex-col items-center justify-center p-6">
                                <div class="bg-white/20 backdrop-blur-sm rounded-xl p-6 text-center w-full">
                                    <h3 class="text-xl font-bold text-white drop-shadow-lg mb-3">
                                        Séance à Domicile
                                    </h3>
                                    <p class="text-white/90 text-sm mb-4 leading-relaxed">
                                        Idéal pour les chiens souffrant d'anxiété de séparation, de troubles du comportement (destruction, aboiements, etc.) ou de problématiques à domicile (territorialité, crainte, etc.). En cas de travail autour de la dangerosité, un court appel est prévu en amont.
                                    </p>
                                    <div class="flex justify-between items-center">
                                        <span class="text-2xl font-bold text-white drop-shadow-lg">
                                            150CHF
                                        </span>
                                        <button class="bg-chien-primary text-white px-4 py-2 rounded-lg hover:bg-chien-primary-dark transition-colors shadow-lg">
                                            Réserver
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="font-pogonia mt-16 text-center max-w-2xl mx-auto text-white">
                    <p class="text-lg drop-shadow-md">
                        Une question ? Je propose également des <strong>cours de perfectionnement</strong> pour éducateurs,
                        ainsi que des <strong>forfaits multi-séances</strong> à tarif avantageux.
                    </p>
                    <p class="mt-4 italic text-sm text-white/80">
                        Interventions possibles dans toute la Suisse et en zone frontalière en France. Devis sur demande pour les situations spécifiques.
                    </p>
                </div>
            </div>
        </section>
    </main>

<?php include_once __DIR__ . '/../components/footer.php'; ?>