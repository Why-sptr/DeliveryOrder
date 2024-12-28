# Instalasi Website

1. Clone repository ini menggunakan perintah `git clone https://github.com/Why-sptr/DeliveryOrder.git`
2. Masuk ke dalam direktori project yang baru di clone menggunakan perintah `cd your-repo-name`
3. Install dependencies menggunakan perintah `composer install`
4. Salin file `.env.example` menjadi `.env` menggunakan perintah `cp .env.example .env`
5. Ubah konfigurasi database pada file `.env` sesuai dengan kebutuhan anda
6. Jalankan perintah `php artisan key:generate` untuk mengenerate key aplikasi
7. Jalankan perintah `php artisan migrate` untuk membuat tabel database
8. Jalankan perintah `php artisan db:seed` untuk mengisi data awal
9. Jalankan perintah `npm install` untuk menginstall dependensi npm
10. Jalankan perintah `npm run dev` untuk mengcompile asset

# Menjalankan Aplikasi

1. Jalankan perintah `php artisan serve` untuk menjalankan aplikasi
2. Buka browser dan akses ke `http://localhost:8000` untuk melihat aplikasi

# Konfigurasi

1. Ubah konfigurasi database pada file `.env`

# Instalasi Composer

1. Download dan install composer dari https://getcomposer.org/download/
2. Buka command prompt atau terminal
3. Masuk ke direktori folder composer yang baru di download
4. Jalankan perintah `php composer-setup.php`
5. Jalankan perintah `php composer.phar install`
6. Tambahkan path composer ke environment variable

# Instalasi PHP

1. Download dan install php dari https://www.php.net/downloads
2. Buka command prompt atau terminal
3. Masuk ke direktori folder php yang baru di download
4. Jalankan perintah `php -v` untuk memastikan php sudah terinstall

# Instalasi XAMPP

1. Download dan install xampp dari https://www.apachefriends.org/download.html
2. Buka command prompt atau terminal
3. Masuk ke direktori folder xampp yang baru di download
4. Jalankan perintah `cd c:\xampp\php` (untuk windows)
5. Jalankan perintah `php -v` untuk memastikan php sudah terinstall
6. Jalankan perintah `mysql -u root -p` untuk memastikan mysql sudah terinstall
