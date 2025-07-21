<?php include_once __DIR__ . '/../components/header.php'; ?>

<?php
// verify - code php débug var$client
if (!isset($client)) {
    header('Location: index.php?page=clients&action=list');
    exit;
}
?>

    <main class="min-h-screen bg-chien-beige-50">
        <div class="container mx-auto px-4 py-8">
            <div class="max-w-2xl mx-auto">
                <!-- en-tête -->
                <div class="flex items-center mb-8">
                    <a href="<?= URL_CLIENTS_VIEW . $client['id'] ?? ($_GET['id'] ?? '') ?>"
                       class="text-chien-primary hover:text-chien-primary-dark mr-4">
                        ← Retour
                    </a>
                    <h1 class="text-3xl font-bold text-chien-terracotta-800">
                        Supprimer le client
                    </h1>
                </div>

                <!-- avertissement -->
                <div class="bg-red-50 border-2 border-red-200 rounded-xl p-8 mb-6">
                    <div class="flex items-center mb-4">
                        <div class="text-4xl mr-4">
                            ⚠️
                        </div>
                        <h2 class="text-xl font-bold text-red-800">
                            Attention: Action irréversible
                        </h2>
                    </div>

                    <p class="text-red-700 mb-4">
                        Vous êtes sur le point de supprimer le client :
                    </p>

                    <div class="bg-white rounded-lg p-4 mb-4">
                        <p class="font-bold text-chien-terracotta-800 text-lg">
                            <?= htmlspecialchars($client['prenom'] . ' ' . $client['nom']) ?>
                        </p>
                        <?php if (!empty($client['email'])): ?>
                            <p class="text-chien-neutral">
                                <?= htmlspecialchars($client['email']) ?>
                            </p>
                        <?php endif; ?>
                    </div>

                    <?php if (!empty($chiens)): ?>
                        <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                            <p class="text-yellow-800 font-medium mb-2">
                                ⚠️ Ce client a <?= count($chiens) ?> chien(s) enregistré(s) :
                            </p>
                            <ul class="list-disc list-inside text-yellow-700">
                                <?php foreach ($chiens as $chien): ?>
                                    <li><?= htmlspecialchars($chien['nom']) ?></li>
                                <?php endforeach; ?>
                            </ul>
                            <p class="text-yellow-800 mt-2 font-medium">
                                Vous devez d'abord supprimer ou réassigner ces chiens.
                            </p>
                        </div>
                    <?php endif; ?>

                    <p class="text-red-700 mt-4">
                        Cette action supprimera définitivement toutes les données du client.
                    </p>
                </div>

                <!-- boutons d'action -->
                <div class="flex justify-between">
                    <a href="<?= URL_CLIENTS_VIEW . $client['id'] ?>"
                       class="bg-gray-500 text-white px-6 py-3 rounded-lg hover:bg-gray-600 transition-colors">
                        Annuler
                    </a>

                    <?php if (empty($chiens)): ?>
                        <button type="button"
                                onclick="openModal()"
                                class="bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition-colors font-medium">
                            Supprimer définitivement
                        </button>
                    <?php else: ?>
                        <button type="button"
                                disabled
                                class="bg-gray-300 text-gray-500 px-6 py-3 rounded-lg cursor-not-allowed">
                            Suppression impossible
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>
    <div id="deleteModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-sm w-full">
            <h2 class="text-lg font-bold mb-4">
                Confirmation
            </h2>
            <p class="mb-4">
                Êtes-vous vraiment sûr de vouloir supprimer ce client ?
            </p>
            <div class="flex justify-end space-x-2">
                <button type="button"
                        onclick="closeModal()"
                        class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400">
                    Annuler
                </button>
                <form method="POST">
                    <button type="submit"
                            class="px-4 py-2 rounded bg-red-600 text-white hover:bg-red-700">
                        Supprimer
                    </button>
                </form>
            </div>
        </div>
    </div>


    <script>
        function openModal() {
            document.getElementById('deleteModal').classList.remove('hidden');
        }
        function closeModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }
    </script>

<?php include_once __DIR__ . '/../components/footer.php'; ?>