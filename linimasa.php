<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Lini Masa</title>

  <!-- Tailwind CDN -->
  <script src="https://cdn.tailwindcss.com"></script>

  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: '#7a00ff',
          },
          borderRadius: {
            xl: '14px',
          }
        }
      }
    }
  </script>
</head>
<body class="bg-white p-4 font-sans">

  <!-- Container -->
  <div class="max-w-[900px] mx-auto">

    <!-- Header -->
    <div class="bg-primary text-white text-center py-3 rounded-xl font-semibold text-base mb-4">
      Lini Masa
    </div>

    <!-- Content -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

      <!-- Panel Tugas -->
      <div class="border-2 border-primary rounded-xl overflow-hidden flex flex-col min-h-[240px]">
        <div class="bg-primary text-white text-center py-2 font-semibold text-sm">
          Tugas
        </div>
        <div class="p-3 flex-1">
          <div class="text-gray-400 text-center mt-8 text-sm">
            No tasks available
          </div>
        </div>
      </div>

      <!-- Panel Absensi -->
      <div class="border-2 border-primary rounded-xl overflow-hidden flex flex-col min-h-[240px]">
        <div class="bg-primary text-white text-center py-2 font-semibold text-sm">
          Absensi
        </div>
        <div class="p-3 flex-1">
          <div class="text-gray-400 text-center mt-8 text-sm">
            No attendance records
          </div>
        </div>
      </div>

    </div>
  </div>

</body>
</html>
