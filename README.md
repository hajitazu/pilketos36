# Sistem Pemilihan Ketua OSIS (CodeIgniter 4)

Deskripsi:
Sistem voting Ketua OSIS berbasis CodeIgniter 4. Voting menggunakan token (format: <Kelas><NomorAbsen>, contoh: 9A001). Admin dapat mengatur kandidat, kustomisasi tampilan, dan menutup pemungutan suara.

Fitur utama:
- Halaman voting: /voting
- Halaman admin: /admin
- Voting hanya melalui token yang hanya bisa dipakai sekali
- Admin: login, kelola kandidat (CRUD), kustomisasi tampilan, lihat hasil, akhiri pemungutan suara

Persyaratan (VPS Ubuntu 22):
- Ubuntu 22.04
- PHP 8.0+ dengan ekstensi: php-mysqli, php-xml, php-mbstring, php-zip, php-curl, php-gd
- Composer
- MySQL / MariaDB
- Nginx atau Apache (direkomendasikan Nginx)
- PHP-FPM

Struktur penting:
- app/Controllers, Models, Views (CodeIgniter 4)
- public/ (document root)
- public/uploads/ (untuk logo/banner/fav/kandidat)
- database/schema.sql (schema DB)

Langkah instalasi singkat (dilakukan di mesin lokal atau VPS):

A. Siapkan repository / file
1. Clone repo (jika belum):
   git clone https://github.com/hajitazu/pilketos36.git
   cd pilketos36

2. Install dependensi (opsional di lokal atau di VPS setelah upload):
   composer install

B. Konfigurasi environment
1. Salin file env:
   cp env .env
   atau jika ada `.env.example`:
   cp .env.example .env

2. Edit `.env` dan sesuaikan:
   - app.baseURL = 'http://your-domain-or-ip/'
   - database.default.hostname = localhost
   - database.default.database = voting_osis
   - database.default.username = dbuser
   - database.default.password = dbpass
   - database.default.DBDriver = MySQLi
   (Sesuaikan username/password DB)

C. Buat database dan import schema
1. Buat database:
   sudo mysql -u root -p
   CREATE DATABASE voting_osis CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
   EXIT;

2. Import schema:
   mysql -u dbuser -p voting_osis < database/schema.sql

D. Buat akun admin
1. Buat hash password (lokal atau di VPS):
   php -r "echo password_hash('admin123', PASSWORD_DEFAULT) . PHP_EOL;"

2. Masukkan record admin ke DB (ganti <HASH> hasil di atas):
   INSERT INTO admins (username, password, created_at) VALUES ('admin', '<HASH>', NOW());

E. Permission & upload folder
1. Pastikan folder writable:
   mkdir -p public/uploads
   sudo chown -R www-data:www-data writable public/uploads
   sudo chmod -R 775 writable public/uploads

F. Jalankan (development)
1. Untuk testing cepat:
   php spark serve --host=0.0.0.0 --port=8080
   Akses http://server-ip:8080/voting dan http://server-ip:8080/admin

G. Deploy ke Nginx (ringkasan)
1. Install PHP-FPM, Nginx, composer:
   sudo apt update
   sudo apt install nginx php-fpm php-mysql php-xml php-mbstring php-zip php-curl php-gd unzip -y
   sudo apt install composer -y

2. Upload/clone project ke server, taruh di /var/www/pilketos36
   cd /var/www
   sudo git clone https://github.com/hajitazu/pilketos36.git
   cd pilketos36
   composer install --no-dev --optimize-autoloader

3. Set permission:
   sudo chown -R www-data:www-data /var/www/pilketos36
   sudo chmod -R 775 /var/www/pilketos36/writable /var/www/pilketos36/public/uploads

4. Contoh konfigurasi Nginx (file: /etc/nginx/sites-available/pilketos36):
   server {
       listen 80;
       server_name your-domain-or-ip;

       root /var/www/pilketos36/public;
       index index.php index.html;

       location / {
           try_files $uri $uri/ /index.php?$query_string;
       }

       location ~ \.php$ {
           include snippets/fastcgi-php.conf;
           fastcgi_pass unix:/run/php/php8.1-fpm.sock; # sesuaikan versi PHP-FPM
           fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
           include fastcgi_params;
       }

       location ~* \.(js|css|png|jpg|jpeg|gif|ico|svg)$ {
           try_files $uri =404;
           access_log off;
           expires max;
       }
   }

   Setelah membuat file:
   sudo ln -s /etc/nginx/sites-available/pilketos36 /etc/nginx/sites-enabled/
   sudo nginx -t && sudo systemctl reload nginx

H. Import token massal (opsional)
- Token disimpan di tabel `tokens` (kolom token). Anda bisa import CSV:
  token,class,number
  9A001,9A,001
  9A002,9A,002
  ...
- Import dengan LOAD DATA INFILE atau convert ke SQL INSERT.

I. Backup / Restore
- Backup DB: mysqldump -u dbuser -p voting_osis > voting_osis_backup.sql

Membuat file ZIP seluruh proyek (di mesin Anda)
- Jika ingin membuat ZIP yang menyertakan vendor (sudah composer install):
  cd /path/to/pilketos36-parent
  zip -r pilketos36.zip pilketos36 -x "pilketos36/.git/*" "pilketos36/node_modules/*"
- Jika ingin mengecualikan vendor (supaya upload lebih ringan) dan install vendor di VPS:
  cd /path/to/pilketos36
  zip -r ../pilketos36-no-vendor.zip . -x ".git/*" "vendor/*" "node_modules/*"

Catatan:
- Sertakan `database/schema.sql` dalam zip supaya mudah import di VPS.
- Jika sertakan vendor di zip, pastikan ukuran tidak terlalu besar.
- Pastikan `public/uploads` dan `writable` mengikuti permission produksi (www-data).

Tambahan & Rekomendasi
- Saya dapat membuat migration & seeder CI4 agar lebih mudah setup (seeder untuk admin default & beberapa token sampel).
- Saya bisa tambahkan fitur import token CSV di admin.
- Jangan lupa menggunakan HTTPS (Let's Encrypt) untuk domain produksi.
