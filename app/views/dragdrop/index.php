<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Drag & Drop Game</title>
</head>

<body class="bg-gray-100 min-h-screen py-6 px-3">

<main class="max-w-4xl mx-auto bg-white p-5 md:p-8 rounded-xl shadow-lg">

    <!-- HEADER -->
    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-6">
        <h1 class="text-2xl font-bold text-[#00007F]">
            Drag & Drop Game
        </h1>

        <div class="flex gap-3">
            <a href="<?= BASEURL ?>/Dragdrop/admin"
               class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition text-sm">
                Admin
            </a>
            <a href="<?= BASEURL ?>/Dragdrop/leaderboard"
               class="px-4 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 transition text-sm">
                Leaderboard
            </a>
        </div>
    </div>

    <!-- SELECT GAME -->
    <div class="mb-6">
        <label class="block mb-2 font-semibold text-gray-700">Pilih Game</label>
        <select id="gameSelect" 
            class="w-full border border-gray-300 rounded-lg p-3 bg-gray-50 focus:ring-2 focus:ring-blue-400">
            <option value="">-- Pilih Game --</option>
            <?php foreach ($games as $g): ?>
                <option value="<?= $g['id_game'] ?>"><?= $g['judul'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- GAME CANVAS -->
    <div id="gameContainer" class="mt-6 space-y-6"></div>

</main>

<!-- MODAL -->
<div id="globalModal" class="fixed inset-0 bg-black/40 backdrop-blur-sm 
    flex items-center justify-center z-[999] hidden">
    <div class="bg-white w-11/12 max-w-md p-6 rounded-xl shadow-xl 
        animate-[fadeIn_0.25s_ease-out]">
        
        <h2 id="modalTitle" class="text-xl font-semibold text-indigo-700 mb-3"></h2>
        <p id="modalMessage" class="text-gray-700 mb-6"></p>
        <div id="modalButtons" class="flex justify-end gap-3"></div>
    </div>
</div>

<style>
@keyframes fadeIn {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
}
</style>

<script>
const BASE = "<?= BASEURL ?>";
let dragged = null;