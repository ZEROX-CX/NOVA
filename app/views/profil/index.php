<?php

/* ================= LOGOUT ================= */
if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: " . BASEURL . "/login_guru");
    exit;
}

/* ================= TOAST ================= */
$toastType = '';
$toastMessage = '';

if (isset($_SESSION['toast'])) {
    $toastType = $_SESSION['toast']['type'];
    $toastMessage = $_SESSION['toast']['message'];
    unset($_SESSION['toast']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>

    <!-- TAILWIND CDN (WAJIB) -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#fffde8] min-h-screen font-sans text-gray-800 flex justify-center">

<div class="max-w-[1100px] w-full px-4 lg:px-0 mt-6 lg:mt-10 flex flex-col">

    <!-- ================= TOAST ================= -->
    <?php if (!empty($toastMessage)) : ?>
        <div id="toast"
             class="fixed top-5 right-5 px-4 py-3 rounded shadow text-white z-50
             <?= $toastType === 'success' ? 'bg-green-500' : 'bg-red-500' ?>
             transform translate-x-full opacity-0 transition-all duration-500">
            <?= $toastMessage ?>
        </div>

        <script>
            const toast = document.getElementById('toast');
            setTimeout(() => toast.classList.remove('translate-x-full', 'opacity-0'), 100);
            setTimeout(() => toast.classList.add('translate-x-full', 'opacity-0'), 3000);
            setTimeout(() => toast.remove(), 3500);
        </script>
    <?php endif; ?>

    <!-- ================= BAGIAN UTAMA ================= -->
    <div class="flex flex-col lg:flex-row lg:justify-between gap-6">

        <!-- ================= KIRI : PROFIL ================= -->
        <div class="w-full lg:w-[430px] bg-gray-100 rounded-lg p-6 shadow">

            <div class="flex items-center mb-6">

                <!-- FOTO PROFIL -->
                <div class="relative">
                    <div class="w-20 h-20 rounded-full overflow-hidden bg-gray-300 group cursor-pointer">
                        <img src="<?= BASEURL ?>/uploads/profil/<?= $_SESSION['foto'] ?? 'default.png' ?>"
                             class="w-full h-full object-cover">

                        <form id="formGantiProfil"
                              action="<?= BASEURL ?>/profil/gantiProfil"
                              method="post"
                              enctype="multipart/form-data">

                            <label for="gantiProfil"
                                   class="absolute inset-0 bg-black/40 text-white text-sm
                                          flex items-center justify-center
                                          opacity-0 group-hover:opacity-100 transition cursor-pointer">
                                Ganti Foto
                            </label>

                            <input type="file"
                                   id="gantiProfil"
                                   name="gantiProfil"
                                   hidden
                                   accept="image/*">
                        </form>
                    </div>
                </div>

                <!-- INFO -->
                <div class="ml-4">
                    <h2 class="text-xl font-semibold">
                        <?= $_SESSION['namaSiswa'] ?? $_SESSION['namaGuru'] ?? '-   '?>
                    </h2>

                    <p class="text-blue-700 font-medium">
                        Kelas: <?= $data['kelas']['kelas'] ?? '-' ?>
                    </p>

                    <p class="text-sm text-gray-600 mt-1">
                        Status:
                        <span class="font-semibold text-green-700">
                            <?= $_SESSION['role'] ?? '-' ?>
                        </span>
                    </p>

                    <p class="text-sm text-gray-600">
                        Jenis Kelamin:
                        <span class="font-semibold">
                            <?= $data['jenis_kelamin']['jeniskelamin'] ?? '-' ?>
                        </span>
                    </p>
                </div>
            </div>

            <!-- DETAIL -->
            <div class="text-sm">
                <p class="font-semibold mb-3">Detail Pengguna</p>

                <div class="flex justify-between">
                    <div>
                        <p class="font-semibold">Negara</p>
                        <p>Indonesia</p>
                    </div>
                    <div>
                        <p class="font-semibold">Zona waktu</p>
                        <p>Asia/Makassar</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- ================= KANAN : AKTIVITAS ================= -->
        <div class="w-full lg:w-[540px] bg-gray-100 rounded-lg p-6 shadow">

            <h3 class="text-lg font-semibold text-blue-800 mb-3">
                Aktivitas Terakhir
            </h3>

            <div class="bg-white rounded-md border border-gray-200 divide-y text-sm">

                <div class="px-4 py-3 flex justify-between">
                    <span>Akses pertama kali</span>

                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'siswa'): ?>
                        <span class="text-gray-600">
                            <?= isset($data['tanggal_daftar']['tanggal_daftar'])
                                ? date('d F Y', strtotime($data['tanggal_daftar']['tanggal_daftar']))
                                : 'Data tidak tersedia' ?>
                        </span>

                    <?php elseif (isset($_SESSION['role']) && $_SESSION['role'] === 'guru'): ?>
                        <span class="text-gray-600">
                            <?= isset($data['tanggal_daftar_guru']['tanggal_daftar'])
                                ? date('d F Y', strtotime($data['tanggal_daftar_guru']['tanggal_daftar']))
                                : 'Data tidak tersedia' ?>
                        </span>

                    <?php else: ?>
                        <span class="text-gray-600">Data tidak tersedia</span>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>

    <!-- ================= LOGOUT ================= -->
    <form action="" method="POST" class="text-right mt-6">
        <button name="logout" class="text-blue-700 font-medium hover:underline">
            Log out
        </button>
    </form>

    <div class="border-t border-gray-300 mt-3"></div>
</div>

<!-- AUTO SUBMIT FOTO -->
<script>
    document.getElementById('gantiProfil').addEventListener('change', () => {
        document.getElementById('formGantiProfil').submit();
    });
</script>

</body>
</html>