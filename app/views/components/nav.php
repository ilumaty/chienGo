<?php
$isLogged = isset($_SESSION['user']); ?>

    <header class="bg-chien-surface shadow-lg sticky top-0 z-50 border-b border-chien-beige-200">
        <nav class="container mx-auto px-4 py-4 flex justify-between items-center">
            <a href="<?= URL_HOME ?>" class="flex items-center space-x-2 text-2xl font-bold text-chien-terracotta-800 hover:text-chien-primary transition-colors">
                <img src="<?= ASSETS_LOGO ?>CG_O_B.svg"
                     alt="ChienGo Logo"
                     class="h-13 w-16"
                     onload="this.nextElementSibling.style.display='none'"
                     style="display: block;">
                <div class="w-8 h-8" style="display:none;">
                    <?php include __DIR__ . '/../../../public/assets/icons/paw.svg'; ?>
                </div>
            </a>

            <div class="font-pogonia hidden md:flex items-center space-x-6">
                <a href="<?= URL_HOME ?>" class="text-chien-neutral hover:text-chien-primary font-medium transition-colors">
                    Accueil
                </a>
                <!-- page public (tarifs) -->
                <a href="<?= URL_SEANCES ?>" class="text-chien-neutral hover:text-chien-primary font-medium transition-colors">
                    Nos Séances
                </a>
                <!-- espace educ -->
                <?php if ($isLogged): ?>
                    <a href="<?= URL_DASHBOARD ?>" class="text-chien-neutral hover:text-chien-primary font-medium transition-colors">
                        Espace Éduc
                    </a>
                <?php else: ?>
                    <a href="<?= URL_LOGIN ?>" class="text-chien-neutral hover:text-chien-primary font-medium transition-colors">
                        Espace Éduc
                    </a>
                <?php endif; ?>
            </div>

            <!-- boutons d'authentification -->
            <div class="flex items-center space-x-3">
                <?php if ($isLogged): ?>
                    <!-- menu user connecté -->
                    <div class="relative group">
                        <button class="flex items-center space-x-2 text-chien-neutral hover:text-chien-primary font-medium">
                            <span>
                                👤
                            </span>
                            <span><?= $_SESSION['user']['nom'] ?? 'Utilisateur' ?></span>
                            <span class="text-sm">▼</span>
                        </button>

                        <div class="absolute right-0 mt-2 w-48 bg-chien-surface rounded-lg shadow-lg border border-chien-beige-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                            <a href="<?= URL_DASHBOARD ?>" class="block px-4 py-2 text-chien-neutral hover:bg-chien-peach-50 hover:text-chien-primary rounded-t-lg">
                                Dashboard
                            </a>
                            <a href="<?= URL_SEANCES_PRIVATE ?>" class="block px-4 py-2 text-chien-neutral hover:bg-chien-peach-50 hover:text-chien-primary">
                                Mes Séances
                            </a>
                            <a href="<?= URL_CLIENTS ?>" class="block px-4 py-2 text-chien-neutral hover:bg-chien-peach-50 hover:text-chien-primary">
                                Mes Clients
                            </a>

                            <?php if (isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin'): ?>
                                <hr class="my-1 border-chien-beige-200">
                                <a href="<?= URL_ADMIN_DASHBOARD ?>"
                                   class="block px-4 py-2 text-chien-neutral hover:bg-chien-peach-50 hover:text-chien-primary">
                                    Administration
                                </a>
                            <?php endif; ?>

                            <hr class="my-1 border-chien-beige-200">
                            <form action="<?= URL_LOGOUT ?>" method="get" class="block">
                                <input type="hidden" name="page" value="logout">
                                <button type="submit" class="w-full text-left px-4 py-2 text-chien-terracotta-700 hover:bg-chien-terracotta-50 rounded-b-lg">
                                    Déconnexion
                                </button>
                            </form>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="<?= URL_LOGIN ?>" class="font-pogonia text-chien-neutral hover:text-chien-primary font-medium transition-colors">
                        Connexion
                    </a>
                    <a href="<?= URL_REGISTER ?>" class="font-pogonia bg-chien-primary text-white px-4 py-2 rounded-lg hover:bg-chien-primary-dark transition-colors font-medium shadow-md">
                        S'inscrire
                    </a>
                <?php endif; ?>
            </div>

            <!-- menu mobile -->
            <div class="md:hidden">
                <button id="mobile-menu-btn" class="text-chien-neutral hover:text-chien-primary">
                    <svg class="w-6 h-6" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </nav>

        <!-- menu mobile -->
        <div id="mobile-menu" class="md:hidden hidden bg-chien-surface border-t border-chien-beige-200">
            <div class="px-4 py-2 space-y-2">
                <a href="<?= URL_HOME ?>" class="block py-2 text-chien-neutral hover:text-chien-primary">
                    <div class="flex items-center gap-2 justify-center">
                        <div class="w-5 h-5">
                            <?php include __DIR__ . '/../../../public/assets/icons/home.svg'; ?>
                        </div>
                        <span>
                            Accueil
                        </span>
                    </div>
                </a>
                <a href="<?= URL_SEANCES ?>" class="block py-2 text-chien-neutral hover:text-chien-primary">
                    <div class="flex items-center gap-2 justify-center">
                        <div class="w-5 h-5">
                            <?php include __DIR__ . '/../../../public/assets/icons/dog.svg'; ?>
                        </div>
                        <span>
                            Nos Séances
                        </span>
                    </div>
                </a>
                <?php if ($isLogged): ?>
                    <a href="<?= URL_DASHBOARD ?>" class="block py-2 text-chien-neutral hover:text-chien-primary">
                        <div class="flex items-center gap-2 justify-center">
                            <div class="w-5 h-5">
                                <?php include __DIR__ . '/../../../public/assets/icons/user.svg'; ?>
                            </div>
                            <span>
                                Espace Éduc
                            </span>
                        </div>
                    </a>
                    <a href="<?= URL_SEANCES_PRIVATE ?>" class="block py-2 text-chien-neutral hover:text-chien-primary">
                        <div class="flex items-center gap-2 justify-center">
                            <div class="w-5 h-5">
                                <?php include __DIR__ . '/../../../public/assets/icons/calendar.svg'; ?>
                            </div>
                            <span>
                                Mes Séances
                            </span>
                        </div>
                    </a>

                    <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                        <a href="<?= URL_ADMIN_DASHBOARD ?>" class="block py-2 text-red-600 hover:text-red-700">
                            <div class="flex items-center gap-2 justify-center">
                                <div class="w-5 h-5">
                                    <?php include __DIR__ . '/../../../public/assets/icons/admin.svg'; ?>
                                </div>
                                <span>
                                    Administration
                                </span>
                            </div>
                        </a>
                    <?php endif; ?>

                    <hr class="my-2 border-chien-beige-200">
                    <a href="<?= URL_LOGOUT ?>" class="block py-2 text-chien-terracotta-700 hover:text-chien-primary">
                        <div class="flex items-center gap-2 justify-center">
                           <span class="w-5 h-5">
                                <?php include __DIR__ . '/../../../public/assets/icons/exit.svg'; ?>
                           </span>
                            <span>
                                Déconnexion
                            </span>
                        </div>
                    </a>
                <?php else: ?>
                    <a href="<?= URL_LOGIN ?>" class="block py-2 text-chien-neutral hover:text-chien-primary">
                        <div class="flex items-center gap-2 justify-center">
                            <div class="w-5 h-5">
                                <?php include __DIR__ . '/../../../public/assets/icons/user.svg'; ?>
                            </div>
                            <span>
                                Mon Espace Éduc
                            </span>
                        </div>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </header>