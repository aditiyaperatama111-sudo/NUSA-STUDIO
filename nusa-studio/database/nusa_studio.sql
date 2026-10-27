-- Impor berkas ini melalui menu Import di phpMyAdmin.
-- Skrip tidak menghapus database atau menimpa baris yang sudah ada.
CREATE DATABASE IF NOT EXISTS nusa_studio
    CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE nusa_studio;

CREATE TABLE IF NOT EXISTS admins (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(40) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS proyek (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(120) NOT NULL,
    kategori VARCHAR(60) NOT NULL,
    deskripsi TEXT NOT NULL,
    gambar VARCHAR(255) NOT NULL DEFAULT 'assets/images/placeholder.svg',
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO proyek (id, judul, kategori, deskripsi, gambar)
SELECT 1, 'Kopi Ruang', 'Identitas Brand',
    'Konsep identitas visual untuk usaha kedai kopi.',
    'assets/images/project-kopi.webp'
WHERE NOT EXISTS (SELECT 1 FROM proyek WHERE id = 1);

INSERT INTO proyek (id, judul, kategori, deskripsi, gambar)
SELECT 2, 'Tanam Lokal', 'Desain Website',
    'Konsep website untuk usaha tanaman dan perlengkapan berkebun.',
    'assets/images/project-tanam.webp'
WHERE NOT EXISTS (SELECT 1 FROM proyek WHERE id = 2);

INSERT INTO proyek (id, judul, kategori, deskripsi, gambar)
SELECT 3, 'Kelas Kreatif', 'Konten Digital',
    'Konsep materi promosi untuk kegiatan pelatihan kreatif.',
    'assets/images/project-kelas.webp'
WHERE NOT EXISTS (SELECT 1 FROM proyek WHERE id = 3);

-- Tabel admins sengaja kosong. Buat akun sendiri di admin/setup.php.
