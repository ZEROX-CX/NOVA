<?php
$siswa = $data['siswa'];
$siswa_tersedia = $data['siswa_tersedia'];
$kelas_selected = $data['kelas'] ?? '';
$status_selected = $data['status'] ?? '';
$search_query = $data['search'] ?? '';
$id_mapel = $data['id_mapel'] ?? '';
$mapel = $data['mapel'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mapel - <?= $mapel['nama_mapel'] ?></title>
  <script src="https://cdn.tailwindcss.com"></script>

  <style>
    @media (max-width: 768px) {
      .sidebar {
        position: fixed;
        left: -100%;
        top: 0;
        height: 100vh;
        width: 260px;
        z-index: 50;
        transition: left .3s ease-in-out;
      }
      .sidebar.active {
        left: 0;
      }
      .overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,.5);
        z-index: 40;
      }
      .overlay.active {
        display: block;
      }
    }
  </style>
</head>

<body class="bg-gray-100 font-sans">

<!-- Overlay -->
<div id="overlay" class="overlay" onclick="toggleSidebar()"></div>

<!-- Hamburger -->
<button onclick="toggleSidebar()"
  class="fixed top-4 left-4 z-50 md:hidden bg-indigo-600 text-white p-3 rounded-lg shadow">
  ☰
</button>

<div class="flex">

<!-- SIDEBAR -->
<aside class="sidebar bg-white shadow-lg p-4 md:w-64 md:static">
  <div class="flex justify-between items-center mb-4 md:hidden">
    <span class="font-bold">Menu</span>
    <button onclick="toggleSidebar()">✕</button>
  </div>

  <nav class="space-y-3">
    <a href="<?= BASEURL ?>/dashboard/index"
      class="block px-3 py-2 rounded hover:bg-indigo-100 font-medium">
      Siswa
    </a>

    <a href="#"
      class="block px-3 py-2 rounded bg-indigo-100 text-indigo-700 font-medium">
      Mapel
    </a>

    <a href="<?= BASEURL ?>/dashboard/pertemuan/<?= $id_mapel ?>"
      class="block px-3 py-2 rounded hover:bg-indigo-100 font-medium">
      Pertemuan
    </a>
  </nav>
</aside>

<!-- CONTENT -->
<main class="flex-1 w-full md:max-w-6xl md:mx-auto mt-4 md:mt-10 p-4 md:p-6 bg-white rounded-lg shadow">

<h1 class="text-xl md:text-2xl font-bold mb-6 mt-14 md:mt-0">
  Daftar Siswa - <?= $mapel['nama_mapel'] ?>
</h1>

<!-- FORM FILTER -->
<form method="get" class="space-y-4 mb-6">

  <div>
    <label class="text-sm font-medium">Cari Siswa</label>
    <input type="text" name="cari"
      value="<?= htmlspecialchars($search_query) ?>"
      class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500">
  </div>

  <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
    <select name="kelas" class="border rounded-lg px-3 py-2">
      <option value="">Semua Kelas</option>
      <option value="9A" <?= $kelas_selected=='9A'?'selected':'' ?>>9A</option>
      <option value="9B" <?= $kelas_selected=='9B'?'selected':'' ?>>9B</option>
      <option value="9C" <?= $kelas_selected=='9C'?'selected':'' ?>>9C</option>
    </select>

    <select name="status" class="border rounded-lg px-3 py-2">
      <option value="">Semua Status</option>
      <option value="Hadir" <?= $status_selected=='Hadir'?'selected':'' ?>>Hadir</option>
      <option value="Sakit" <?= $status_selected=='Sakit'?'selected':'' ?>>Sakit</option>
      <option value="Izin" <?= $status_selected=='Izin'?'selected':'' ?>>Izin</option>
    </select>

    <div class="flex gap-2">
      <button class="flex-1 bg-green-500 text-white rounded-lg py-2">Cari</button>
      <a href="<?= BASEURL ?>/dashboard/mapel/<?= $id_mapel ?>"
        class="flex-1 bg-gray-500 text-white rounded-lg py-2 text-center">Reset</a>
    </div>
  </div>
</form>

<?php if (!empty($siswa_tersedia)): ?>
<button id="openModalBtn"
  class="mb-4 bg-blue-500 text-white px-4 py-2 rounded-lg">
  + Masukkan Siswa
</button>
<?php endif; ?>

<!-- TABLE -->
<div class="overflow-x-auto rounded-lg border">
<table class="min-w-full">
<thead class="bg-purple-600 text-white">
<tr>
  <th class="px-4 py-3 text-left">Nama</th>
  <th class="px-4 py-3 text-left">Usia</th>
  <th class="px-4 py-3 text-left">Kelas</th>
  <th class="px-4 py-3 text-left">Nilai</th>
  <th class="px-4 py-3 text-left">Status</th>
</tr>
</thead>

<tbody class="divide-y">
<?php foreach ($siswa as $row): ?>
<tr class="hover:bg-gray-50">
  <td class="px-4 py-2"><?= htmlspecialchars($row['nama_siswa']) ?></td>
  <td class="px-4 py-2"><?= $row['usia'] ?></td>
  <td class="px-4 py-2"><?= $row['kelas'] ?></td>
  <td class="px-4 py-2">85</td>
  <td class="px-4 py-2"><?= $row['status'] ?></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>

</main>
</div>

<!-- MODAL (RESPONSIVE) -->
<div id="studentModal"
 class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
<div class="bg-white w-full max-w-md rounded-lg p-5">

<h3 class="font-bold text-lg mb-4">Tambah Siswa</h3>

<form action="<?= BASEURL ?>/dashboard/tambah" method="post" class="space-y-4">
<input type="hidden" name="id_mapel" value="<?= $id_mapel ?>">
<input type="hidden" id="selectedSiswaId" name="id_siswa">

<input id="siswaSearch" type="text"
 placeholder="Cari siswa..."
 class="w-full border rounded-lg px-3 py-2">

<div id="searchResults"
 class="border rounded mt-1 hidden max-h-48 overflow-y-auto"></div>

<div class="flex justify-end gap-2 pt-4">
<button type="button" onclick="closeModal()"
 class="px-4 py-2 bg-gray-300 rounded">Batal</button>
<button id="submitBtn" disabled
 class="px-4 py-2 bg-blue-500 text-white rounded">Simpan</button>
</div>
</form>
</div>
</div>

<script>
function toggleSidebar(){
  document.querySelector('.sidebar').classList.toggle('active');
  document.getElementById('overlay').classList.toggle('active');
}

const modal = document.getElementById('studentModal');
document.getElementById('openModalBtn')?.addEventListener('click',()=>modal.classList.remove('hidden'));
function closeModal(){ modal.classList.add('hidden'); }
</script>

</body>
</html>