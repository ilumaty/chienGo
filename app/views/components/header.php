<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// relation file
require_once __DIR__ . '/../../config/config.php';

$isLogged = isset($_SESSION['user']);

?>

    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>
            <?= $pageTitle ?? 'ChienGo' ?>
        </title>

        <link rel="stylesheet" href="<?= ASSETS_CSS ?>fonts.css">

        <!-- Tailwind CSS via CDN -->
        <script
                src="https://cdn.tailwindcss.com">
        </script>

        <!-- config Tailwind -->
        <script>
            /* global tailwind */
            tailwind.config = {
                theme: {
                    extend: {
                        fontFamily: {
                            'wash': ['Wash Your Hand', 'cursive'],
                            'pogonia': ['Pogonia', 'sans-serif'],
                            'sans': ['Pogonia', 'ui-sans-serif', 'system-ui'],
                        },
                        colors: {
                            'chien-beige': {
                                50: '#fdfcfb', 100: '#faf8f5', 200: '#f5f1eb', 300: '#ede6db', 400: '#e3d4c5',
                                500: '#d4bfaa', 600: '#c9b89d', 700: '#b8a385', 800: '#9a8a6f', 900: '#7e715c',
                            },
                            'chien-peach': {
                                50: '#fefcfb', 100: '#fef7f4', 200: '#fdeee7', 300: '#fbe0d2', 400: '#f8cdb5',
                                500: '#f4b898', 600: '#eda882', 700: '#e49464', 800: '#d17d4a', 900: '#ac6639',
                            },
                            'chien-mauve': {
                                50: '#fdf9f9', 100: '#fcf2f2', 200: '#f8e6e6', 300: '#f2d1d1', 400: '#eab4b4',
                                500: '#e09696', 600: '#d18e8e', 700: '#c07373', 800: '#9f5d5d', 900: '#824d4d',
                            },
                            'chien-terracotta': {
                                50: '#fdf8f6', 100: '#fbf0ec', 200: '#f6ded5', 300: '#efc6b5', 400: '#e5a68d',
                                500: '#da866b', 600: '#ce7c5e', 700: '#b5674a', 800: '#95553f', 900: '#794737',
                            },
                            'chien': {
                                'primary': '#ce7c5e', 'primary-dark': '#b5674a', 'secondary': '#f4b898',
                                'accent': '#d18e8e', 'neutral': '#d4bfaa', 'surface': '#fdfcfb',
                            }
                        }
                    }
                }
            }
        </script>
    </head>
    <body class="m-0 p-0 bg-chien-surface">

<?php include_once __DIR__ . '/nav.php'; ?>