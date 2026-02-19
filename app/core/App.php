<?php
// ...existing code...
class App {
    protected $controller = 'Home';
    protected $method = 'index';
    protected $params = [];

    public function __construct()
    {
        $url = $this->parseUrl() ?? [];
        $segments = $url;

        // Cek khusus untuk route download file tugas
        if (!empty($segments[0]) && $segments[0] == 'pengumpulan' && 
            !empty($segments[1]) && $segments[1] == 'download' && 
            !empty($segments[2])) {
            
            // Validasi filename untuk mencegah path traversal
            $filename = basename($segments[2]);
            if (preg_match('/^[a-zA-Z0-9._-]+$/', $filename)) {
                // Load controller Pengumpulan
                $controllersDir = __DIR__ . '/../controllers/';
                $controllerFile = $controllersDir . 'Pengumpulan.php';
                
                if (file_exists($controllerFile)) {
                    require_once $controllerFile;
                    if (class_exists('Pengumpulan')) {
                        $controller = new Pengumpulan();
                        if (method_exists($controller, 'download')) {
                            // Panggil method download dengan parameter filename
                            $controller->download($filename);
                            return; // Hentikan eksekusi lebih lanjut
                        }
                    }
                }
            }
            
            // Jika ada masalah dengan route, tampilkan error
            http_response_code(400);
            echo "Permintaan tidak valid";
            return;
        }

        // Proses routing normal untuk route lainnya
        $controllersDir = __DIR__ . '/../controllers/';

        // jika ada segmen pertama, coba temukan file controller yang cocok
        if (!empty($segments[0])) {
            $raw = $segments[0];

            // coba beberapa kemungkinan nama file/class
            $candidates = [
                $raw,
                ucfirst($raw),
                str_replace(' ', '', ucwords(str_replace(['-', '_'], ' ', $raw))) // mapel_guru -> MapelGuru atau Mapel_guru style
            ];

            $found = false;
            foreach ($candidates as $cand) {
                $file = $controllersDir . $cand . '.php';
                if (file_exists($file)) {
                    require_once $file;
                    // jika class ada, gunakan
                    if (class_exists($cand)) {
                        $this->controller = $cand;
                        array_shift($segments);
                        $found = true;
                        break;
                    }
                    // juga cek alternative with underscore (Mapel_guru)
                    $alt = preg_replace('/([a-z])([A-Z])/', '$1_$2', $cand);
                    if (class_exists($alt)) {
                        $this->controller = $alt;
                        array_shift($segments);
                        $found = true;
                        break;
                    }
                }
            }

            // fallback: jika tidak ditemukan, tetap load Home
            if (!$found) {
                require_once $controllersDir . 'Home.php';
                $this->controller = 'Home';
            }
        } else {
            require_once $controllersDir . 'Home.php';
            $this->controller = 'Home';
        }

        if (!class_exists($this->controller)) {
            http_response_code(500);
            echo "Controller class '" . htmlspecialchars($this->controller) . "' tidak ditemukan.";
            exit;
        }

        $this->controller = new $this->controller;

        if (!empty($segments[0]) && method_exists($this->controller, $segments[0])) {
            $this->method = $segments[0];
            array_shift($segments);
        }

        $this->params = !empty($segments) ? array_values($segments) : [];

        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    public function parseUrl()
    {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            return explode('/', $url);
        }
        return [];
    }
}
// ...existing code...