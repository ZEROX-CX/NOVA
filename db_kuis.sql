-- --------------------------------------------------------
-- Struktur Database untuk Sistem Kuis Otomatis
-- --------------------------------------------------------

CREATE DATABASE IF NOT EXISTS db_kuis;
USE db_kuis;

-- --------------------------------------------------------
-- Tabel: soal
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS soal (
  id INT AUTO_INCREMENT PRIMARY KEY,
  pertanyaan TEXT NOT NULL,
  opsi_a VARCHAR(255) NOT NULL,
  opsi_b VARCHAR(255) NOT NULL,
  opsi_c VARCHAR(255) NOT NULL,
  opsi_d VARCHAR(255) NOT NULL,
  jawaban_benar CHAR(1) NOT NULL
);

-- Contoh data awal
INSERT INTO soal (pertanyaan, opsi_a, opsi_b, opsi_c, opsi_d, jawaban_benar) VALUES
('Ibukota Indonesia adalah?', 'Surabaya', 'Jakarta', 'Bandung', 'Medan', 'B'),
('Hasil dari 2 + 2 adalah?', '3', '4', '5', '6', 'B'),
('Hewan yang dapat terbang adalah?', 'Ikan', 'Ayam', 'Kucing', 'Ular', 'B'),
('Lambang negara Indonesia adalah?', 'Harimau', 'Burung Garuda', 'Singa', 'Elang', 'B'),
('Planet terdekat dari matahari?', 'Mars', 'Venus', 'Merkurius', 'Bumi', 'C');
