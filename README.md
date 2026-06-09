
## Panduan Instalasi & Setup (Bahasa Indonesia)

Panduan ini menjelaskan langkah demi langkah untuk menjalankan proyek ini secara lokal, termasuk konfigurasi Midtrans, pembuatan akun admin, build Tailwind, dan tips debugging.

1) Prasyarat
- PHP >= 8.1 terinstal dan tersedia di PATH
- Composer terinstal
- Node.js & npm (untuk build CSS/JS)
- Database (MySQL / SQLite) — sesuaikan `DB_CONNECTION` di `.env`

2) Clone & Install

```bash
git clone <repo> mbooking
cd mbooking
composer install
npm install
```

3) Salin file environment

```bash
cp .env.example .env
php artisan key:generate
```

Isi `.env` minimal (contoh):

```
APP_NAME="mBooking"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=sqlite
# atau konfigurasi MySQL
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=homestead
DB_USERNAME=homestead
DB_PASSWORD=secret

MIDTRANS_SERVER_KEY=YOUR_SANDBOX_SERVER_KEY
MIDTRANS_CLIENT_KEY=YOUR_SANDBOX_CLIENT_KEY
MIDTRANS_IS_PRODUCTION=false

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
```

Catatan: Jangan commit `.env` ke repository.

4) Migrasi dan seeder (buat tabel + data awal)

```bash
php artisan migrate
php artisan db:seed --class=KamarSeeder
php artisan db:seed
```

5) Buat akun admin

Opsi A — via seeder: sesuaikan `DatabaseSeeder` untuk membuat user admin dan jalankan seeder.

Opsi B — via Tinker (cepat):

```bash
php artisan tinker
>>> \App\Models\User::create([ 'name' => 'Admin', 'email' => 'admin@example.com', 'password' => bcrypt('ChangeMe123!'), 'role' => 'admin' ]);
```

Contoh kredensial (contoh — UBAH setelah login):
- Email: `admin@example.com`
- Password: `ChangeMe123!`

6) Storage & cache

```bash
php artisan storage:link
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

7) Build Tailwind / Frontend

Rekomendasi (Vite): jalankan build dev untuk development:

```bash
npm run dev
```

Untuk production build (minimal):

```bash
npm run build
```

Atau jika Anda ingin cepat tanpa Vite, gunakan Tailwind CLI:

```bash
npx tailwindcss -i ./resources/css/app.css -o ./public/css/tailwind.css --minify
```

Setelah build, pastikan layout Anda memuat file CSS yang dihasilkan (ganti CDN `dn.tailwindcss.com` dengan file lokal).

8) Menjalankan server lokal & HTTPS untuk Midtrans Snap

Midtrans Snap bekerja paling baik pada origin `localhost` atau HTTPS. Jika Anda mengakses via LAN IP (mis. `http://192.168.x.y`) Snap dapat menyebabkan postMessage origin error.

Saran cepat (ngrok):

```bash
php artisan serve --host=0.0.0.0 --port=8000
ngrok http 8000
```

Buka URL HTTPS dari ngrok untuk menguji Snap.

9) Pengaturan Midtrans (Sandbox)

- Dapatkan `server key` dan `client key` dari Midtrans Dashboard (sandbox)
- Masukkan ke `.env` (`MIDTRANS_SERVER_KEY`, `MIDTRANS_CLIENT_KEY`)
- Pastikan `MIDTRANS_IS_PRODUCTION=false` untuk sandbox
- Setelah konfigurasi, jalankan `php artisan config:clear`

10) Alur pembayaran dan debugging

- Halaman checkout sekarang membuka Midtrans Snap modal secara langsung (AJAX).
- Untuk pembayaran `bank_transfer` Midtrans biasanya mengembalikan `transaction_status: pending` dan `va_numbers` — skrip frontend akan menampilkan nomor VA di modal.
- Jika modal menampilkan JSON mentah, periksa Network tab pada DevTools untuk response endpoint `POST /payment/{id}/pay` dan pastekan di log bila perlu.
- Cek `storage/logs/laravel.log` untuk error server-side.

11) Notifikasi & IPN

- Endpoint Midtrans notification sudah tersedia (`PaymentController@notification`). Pastikan `MIDTRANS_SERVER_KEY` benar agar verifikasi berjalan.
- Untuk pengujian IPN, gunakan fitur Webhook/Notification simulator di Midtrans dashboard atau curl ke endpoint notification.

12) Menampilkan QR / Tiket

- Setelah pembayaran sukses, halaman `reservation.success` menampilkan QR code yang bisa dicetak oleh tamu.

13) Keamanan dan produksi

- Jangan gunakan kredensial contoh di produksi.
- Ganti `APP_KEY`, `MIDTRANS_*` production keys, dan aktifkan HTTPS.
- Lindungi kunci API dengan environment variables dan jangan commit kunci ke repo.

14) Perintah berguna

```bash
composer install
npm install
php artisan migrate --seed
php artisan serve
npm run dev
ngrok http 8000
tail -f storage/logs/laravel.log
```

15) Troubleshooting singkat

- Error Snap postMessage origin: gunakan `localhost` atau HTTPS via ngrok.
- Tailwind CDN warning: hapus `dn.tailwindcss.com` dan build Tailwind secara lokal.
- Midtrans error: cek `storage/logs/laravel.log` dan `MIDTRANS_SERVER_KEY`/`MIDTRANS_CLIENT_KEY`.

Jika Anda mau, saya bisa:
- Menambahkan skrip `npm` di `package.json` untuk build Tailwind cepat, dan
- Menambahkan paragraf singkat di dashboard Midtrans untuk set `finish_redirect_url` ke URL ngrok Anda.

--
Dokumentasi ini dibuat untuk memudahkan pengujian dan deployment lokal. Pastikan mengganti semua kredensial contoh sebelum deploy ke production.
