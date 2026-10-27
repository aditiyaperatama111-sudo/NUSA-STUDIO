# Nusa Studio dengan PHP dan MySQL

Website company profile satu halaman dengan tampilan biru putih. Website membaca proyek dari database. Halaman admin menyediakan login, tambah, ubah, hapus, dan unggah gambar proyek.

Proyek ini memakai HTML, CSS, JavaScript, dan PHP biasa tanpa framework atau Composer. MySQL atau MariaDB menyimpan data. Kamu menggunakan phpMyAdmin untuk mengimpor dan memeriksa database.

## Mulai di Windows dengan XAMPP

1. Ekstrak ZIP. Pindahkan folder **nusa-studio** ke `C:\xampp\htdocs\nusa-studio`. Pastikan berkas `index.php` langsung berada di dalam folder tersebut, bukan di folder nusa-studio kedua.
2. Buka VS Code. Pilih **File > Open Folder**, kemudian pilih `C:\xampp\htdocs\nusa-studio`.
3. Buka XAMPP Control Panel. Tekan **Start** pada **Apache** dan **MySQL**.
4. Buka `http://localhost/phpmyadmin`. Pilih menu **Import**, pilih `database/nusa_studio.sql` dari folder proyek, lalu jalankan impor. Skrip membuat database `nusa_studio`, dua tabel, dan tiga contoh proyek.
5. Periksa `config/database.php`. Pengaturan awal memakai host `127.0.0.1`, port `3306`, database `nusa_studio`, username `root`, dan password kosong. Ganti sesuai pengaturan XAMPP kamu jika berbeda.
6. Buka `http://localhost/nusa-studio/` untuk melihat website. Buka `http://localhost/nusa-studio/admin/setup.php` untuk membuat akun admin pertama. Gunakan username sendiri dan password minimal 10 karakter. Selanjutnya login melalui `http://localhost/nusa-studio/admin/login.php`.

Jika Apache memakai port lain, tambahkan port tersebut pada alamat. Contoh untuk port 8080: `http://localhost:8080/nusa-studio/`.

**VS Code merupakan editor.** PHP tetap memerlukan server. Buka alamat localhost melalui Apache, bukan melalui tombol Live Server atau dengan mengeklik langsung berkas index.php.

Halaman `MULAI_DI_SINI.html` juga memuat panduan singkat. Kamu boleh membukanya langsung melalui browser sebelum menjalankan server.

## Urutan belajar kode

| Berkas atau folder | Fungsi |
| --- | --- |
| `index.php` | Halaman perusahaan dan perulangan untuk menampilkan proyek dari database |
| `config/database.php` | Pengaturan koneksi MySQL atau MariaDB |
| `database/nusa_studio.sql` | Struktur tabel dan tiga data proyek contoh |
| `includes/functions.php` | Koneksi PDO, sesi, validasi formulir, dan pengelolaan unggahan |
| `admin/setup.php` | Pembuatan satu akun admin pertama melalui localhost |
| `admin/login.php` dan `admin/logout.php` | Proses masuk dan keluar |
| `admin/index.php` | Daftar proyek beserta tombol pengelolaan |
| `admin/tambah.php` | Menambahkan proyek menggunakan INSERT |
| `admin/edit.php` | Mengubah proyek menggunakan UPDATE |
| `admin/hapus.php` | Konfirmasi dan penghapusan proyek menggunakan DELETE |
| `includes/project-form.php` | Formulir bersama untuk tambah dan ubah proyek |
| `assets/css/style.css` | Tampilan halaman perusahaan dan aturan ukuran layar |
| `assets/css/admin.css` | Tampilan login, tabel admin, dan formulir |
| `assets/js/script.js` | Menu ponsel dan navigasi halaman utama |
| `assets/images` | Gambar bawaan dan gambar pengganti ketika proyek belum memiliki foto |
| `uploads/proyek` | Gambar yang admin unggah melalui formulir |

Mulai dengan `database/nusa_studio.sql`, lalu baca pengaturan koneksi, bagian awal `index.php`, dan halaman tambah proyek. Urutan ini memperlihatkan hubungan database, PHP, dan tampilan HTML.

## Struktur database

Tabel **proyek** memuat `id`, `judul`, `kategori`, `deskripsi`, `gambar`, `created_at`, dan `updated_at`. Kolom gambar menyimpan lokasi berkas. Berkas gambar berada di folder assets atau uploads.

Tabel **admins** memuat `id`, `username`, `password_hash`, dan `created_at`. Tidak ada akun atau password bawaan. Halaman setup menyimpan hasil `password_hash()`, bukan password asli. Halaman login memeriksa password melalui `password_verify()`.

Impor awal menambahkan Kopi Ruang, Tanam Lokal, dan Kelas Kreatif. Skrip tidak menjalankan DROP atau menimpa data dengan ID yang sudah tersedia. Mengimpor ulang skrip dapat menambahkan kembali contoh proyek yang sebelumnya kamu hapus.

## Mengelola proyek

Setelah login, pilih **Tambah proyek**, isi judul, kategori, dan deskripsi, lalu tekan **Simpan proyek**. Unggahan gambar bersifat opsional. Tanpa gambar, website menampilkan gambar pengganti.

Untuk mengganti data, pilih **Ubah**. Jika kamu tidak memilih gambar baru, aplikasi mempertahankan gambar lama. Pilih **Hapus** untuk membuka halaman konfirmasi. Aplikasi baru menghapus data setelah kamu menekan **Ya, hapus proyek**.

Gambar unggahan boleh memakai JPG, PNG, atau WebP, maksimal 2 MB dan 24 megapiksel. Aplikasi membuat nama berkas acak. Aplikasi hanya menghapus gambar unggahan milik proyek tersebut. Gambar contoh bawaan tetap tersedia.

## Membuka dari HP

Komputer harus menjalankan Apache dan MySQL. Sambungkan HP dan komputer ke jaringan Wi-Fi yang sama. Jalankan `ipconfig` pada Windows dan cari alamat IPv4 komputer.

Pada browser HP, buka `http://ALAMAT-IP-KOMPUTER/nusa-studio/`. Misalnya, jika IPv4 komputer benar-benar `192.168.1.10`, buka `http://192.168.1.10/nusa-studio/`. Ganti contoh tersebut sesuai alamat komputer kamu. Tambahkan port Apache jika berbeda dari 80.

Alamat localhost pada HP menunjuk ke HP itu sendiri. Gunakan IPv4 komputer untuk mengakses XAMPP dari HP. Bila Windows meminta izin jaringan untuk Apache, gunakan jaringan pribadi yang kamu percayai. Jangan menonaktifkan firewall atau membuka akses database ke internet.

Buat akun admin pertama melalui localhost pada komputer. Halaman setup menolak pembuatan akun melalui perangkat lain. Setelah akun tersedia, menu login tetap bekerja melalui browser.

## Mengubah profil dan kontak

Ubah nama perusahaan, deskripsi, dan isi layanan langsung melalui `index.php`. Versi ini menghubungkan bagian proyek dengan database; bagian profil dan layanan tetap berada di HTML agar kode mudah dipelajari.

Bagian kontak menampilkan **Kontak segera tersedia**. Setelah kamu memiliki kontak yang benar, ganti isi bagian `id="kontak"` dengan email atau tautan WhatsApp. Jangan memakai kontak milik orang lain sebagai contoh.

## Jika ada kendala

| Gejala | Pemeriksaan |
| --- | --- |
| Browser menampilkan kode PHP atau meminta unduh index.php | Gunakan alamat localhost dari Apache. Jangan buka melalui file atau Live Server. |
| Database belum siap | Jalankan MySQL, impor SQL, lalu periksa nama database, host, port, username, dan password. |
| Access denied pada koneksi database | Sesuaikan username dan password pada config/database.php. |
| Halaman 404 | Periksa nama dan letak folder. Hindari folder nusa-studio yang bersarang dua kali. |
| Apache tidak dapat berjalan | Periksa port Apache di XAMPP. Gunakan port yang sesuai pada URL. |
| Unggah gambar gagal | Periksa ukuran dan jenis gambar, batas upload pada PHP, serta izin tulis folder uploads/proyek. |
| HP tidak dapat membuka website | Periksa jaringan Wi-Fi, IPv4 komputer, port Apache, dan izin Apache pada jaringan pribadi Windows. |
| Lupa password admin saat latihan | Password asli tidak tersimpan. Cadangkan database. Untuk mengulang setup lokal, kosongkan tabel admins melalui phpMyAdmin, lalu buat akun baru melalui localhost. Ini menghapus seluruh akun admin lama. |

## Kebutuhan dan batas penggunaan

Gunakan PHP 8.1 atau lebih baru dengan ekstensi PDO MySQL. XAMPP Windows yang menyediakan PHP versi tersebut dapat menjalankan proyek ini. XAMPP memakai label tombol MySQL meskipun paketnya dapat menyediakan MariaDB.

Paket ini untuk latihan lokal. Sebelum hosting produksi, sesuaikan akun database dengan hak terbatas, konfigurasi server, HTTPS, pencadangan, dan pembatasan percobaan login pada tingkat server. Tidak ada pengaturan koneksi ke komputer pengguna yang otomatis berjalan saat membuka folder di VS Code.

Semua gambar bawaan merupakan ilustrasi buatan AI. Nusa Studio dan ketiga proyek merupakan contoh fiktif. Tidak ada klaim pekerjaan klien nyata.

## Dokumentasi acuan

- PHP PDO dan prepared statements: https://www.php.net/manual/en/pdo.prepared-statements.php
- PHP password hashing: https://www.php.net/manual/en/function.password-hash.php
- PHP unggahan berkas: https://www.php.net/manual/en/features.file-upload.php
- XAMPP Windows: https://www.apachefriends.org/faq_windows.html

