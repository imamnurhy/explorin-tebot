# Telegram Bot (Tebot)

Tebot adalah sebuah package Laravel yang berfungsi untuk mengirim notifikasi log dengan mudah

## Instalasi

Untuk menginstal package ini, Anda dapat mengikuti langkah-langkah berikut:

1. Buka terminal atau command prompt dan arahkan ke direktori proyek Laravel Anda.
2. Jalankan perintah berikut untuk menginstal package melalui Composer:

```bash
composer require explorin/tebot
```

3. Setelah package terinstal, tambahkan service provider ke dalam file `config/app.php`. Buka file tersebut dan tambahkan baris berikut di dalam array `providers`:

```php
Explorin\Tebot\TebotServiceProvider::class,
```

4. (Laravel) Tambahkan konfigurasi pada aliases di dalam file `config/app.php`. Buka file tersebut dan tambahkan baris berikut di dalam array `aliases`:

```php
'Tebot' => \Explorin\Tebot\Facades\TebotFacade::class,
```

5. (Laravel) Publish file konfigurasi dengan menjalankan perintah:
```bash
php artisan vendor:publish --provider="Explorin\Tebot\TebotServiceProvider::class" --tag=config
```

## Penggunaan

Setelah package terinstal dan konfigurasi (jika ada) diatur, Anda dapat mulai menggunakan fitur-fitur package ini dengan mudah di dalam aplikasi Laravel Anda.

Contoh penggunaan:

```php
    Tebot::alert('hai')
```

## Kontribusi

Jika Anda menemukan masalah atau ingin berkontribusi pada pengembangan package ini, Anda dapat membuka _issue_ atau mengirim _pull request_ melalui GitHub repository kami.

## Lisensi

Tebot ini bersifat open-source dengan lisensi [MIT License](https://opensource.org/licenses/MIT). Anda bebas menggunakan, mengubah, dan mendistribusikan package ini sesuai dengan ketentuan lisensi.