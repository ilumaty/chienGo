<?php
/* @var bool $isLogged, dans header.php */
/* structure HTML:
<html lang="">; <body>; ouverts dans header.php */
?>

<footer class="bg-chien-terracotta-800 text-chien-beige-50">
    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="col-span-1 md:col-span-2">
                <h3 class="text-2xl font-bold mb-4 flex items-center">
                    <span class="text-chien-secondary mr-2">
                        🐾
                    </span>
                    <span class="font-wash text-chien-beige-50">
                        ChienGo
                    </span>
                </h3>
                <p class="text-chien-beige-200 mb-4 leading-relaxed">
                    Votre plateforme dédiée aux éducateurs canins pour organiser,<br>
                    suivre et gérer vos séances de dressage en toute simplicité.
                </p>
            </div>

            <div>
                <h4 class="text-lg font-semibold mb-4 text-chien-beige-100">
                    Liens rapides
                </h4>

                <ul class="space-y-2">
                    <li>
                        <a href="<?= BASE_URL ?>index.php" class="text-chien-beige-200 hover:text-chien-secondary transition-colors">
                            Accueil
                        </a>
                    </li>
                    <li>
                        <a href="<?= URL_SEANCES ?>" class="text-chien-beige-200 hover:text-chien-secondary transition-colors">
                            Nos Séances
                        </a>
                    </li>
                    <li>
                        <!-- en dev --><a href="<?= BASE_URL ?>index.php?page=about" class="text-chien-beige-200 hover:text-chien-secondary transition-colors">
                            À propos
                        </a>
                    </li>
                    <li>
                        <!-- en dev --><a href="<?= BASE_URL ?>index.php?page=contact" class="text-chien-beige-200 hover:text-chien-secondary transition-colors">
                            Contact
                        </a>
                    </li>
                </ul>
            </div>

            <div>
                <h4 class="text-lg font-semibold mb-4 text-chien-beige-100">
                    Contact
                </h4>
                <ul class="space-y-3 text-chien-beige-200">
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mr-3 text-chien-secondary" viewBox="0 0 20 20">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                        </svg>
                        <a href="mailto:team@dog-logic.ch" class="hover:text-chien-secondary transition-colors">
                            team@dog-logic.ch
                        </a>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mr-3 text-chien-secondary" viewBox="0 0 20 20">
                            <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                        </svg>
                        <a href="tel:+41799611980" class="hover:text-chien-secondary transition-colors">
                            +41 79 961 19 80
                        </a>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-4 h-4 mr-3 mt-1 text-chien-secondary" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                        </svg>
                        <span>
                            Suisse, Vaud
                        </span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="border-t border-chien-terracotta-700 mt-8 pt-6 text-center">
            <p class="text-chien-beige-300">
                &copy; <?= date('Y') ?>
                <span class="font-wash text-chien-secondary font-semibold text-2xl">
                    ChienGo
                </span>
                Tous droits réservés.
            </p>
        </div>
    </div>
    <script
            src="<?= ASSETS_JS ?>nav.js">
    </script>
    <script
            src="<?= ASSETS_JS ?>slider.js">
    </script>
    </footer>
    </body>
</html>