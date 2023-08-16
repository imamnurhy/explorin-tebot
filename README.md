# Telegram Bot (Tebot)

Tebot adalah sebuah package Laravel yang berfungsi untuk mengirim notifikasi log dengan mudah

## Instalasi Laravel

Untuk menginstal package ini, Anda dapat mengikuti langkah-langkah berikut:

1.Buka terminal atau command prompt dan arahkan ke direktori proyek Laravel Anda.
2.Jalankan perintah berikut untuk menginstal package melalui Composer:

```bash
composer require explorin/tebot
```

3.Setelah package terinstal, tambahkan service provider ke dalam file `config/app.php`. Buka file tersebut dan tambahkan baris berikut di dalam array `providers`:

```php
Explorin\Tebot\TebotServiceProvider::class,
```

4.Tambahkan konfigurasi pada aliases di dalam file `config/app.php`. Buka file tersebut dan tambahkan baris berikut di dalam array `aliases`:

```php
'Tebot' => \Explorin\Tebot\Facades\TebotFacade::class,
```

5.Publish file konfigurasi dengan menjalankan perintah:
```bash
php artisan vendor:publish 
```
Setelah itu akan muncul pilihan vendor lalu pilih `Explorin\Tebot\TebotServiceProvider`

6.Perbaharui environment
   
```env
TEBOT_NAME="Nama Aplikasi"
TEBOT_URL=
TEBOT_KEY=
```


## Instalasi Lumen

Untuk menginstal package ini di lumen, Anda dapat mengikuti langkah-langkah berikut:

1.Buka terminal atau command prompt dan arahkan ke direktori proyek Laravel Anda.
2.Jalankan perintah berikut untuk menginstal package melalui Composer:

```bash
composer require explorin/tebot
```

3.Buat buat file config/tebot.php di root project anda
```php
return [
    'default' => [
        'name' => env('TEBOT_NAME', 'TEBOT'),
        'url' => env('TEBOT_URL', 'localhost'),
        'key' => env('TEBOT_KEY', null),
    ]
];
```

4.Perbaharui environment 
```env
TEBOT_NAME="Nama Aplikasi"
TEBOT_URL=
TEBOT_KEY=
```

5.Kemudian registrasikan file konfigurasi tadi ke bootstrap/app.php

```php
$app->configure('tebot');
``` 

6.Lalu di bootstrap/app.php, daftarkan paket ini:

```php
$app->register(Explorin\Tebot\TebotServiceProvider::class);
```

## Penggunaan

Setelah package terinstal dan konfigurasi (jika ada) diatur, Anda dapat mulai menggunakan fitur-fitur package ini dengan mudah di dalam aplikasi Laravel Anda.

Import package
```php
    use Explorin\Tebot\Services\Tebot; 
```

Contoh penggunaan:
```php
    // Default
    Tebot::alert('Hai, ini adalah pesan alert dari Tebot!');

    // Menggunakan channel
    Tebot::alert('Hai')->channel('nama_channel');
```

Untuk menggunakan lebih dari satu channel tambahkan configurasi pada tebot.php seperti berikut
```php
return [
    'default' => [
        'name' => env('TEBOT_NAME', 'TEBOT'),
        'url' => env('TEBOT_URL', 'localhost'),
        'key' => env('TEBOT_KEY', null),
    ],
    'example' => [
         'name' => env('TEBOT_NAME2', 'TEBOT'),
        'url' => env('TEBOT_URL2', 'localhost'),
        'key' => env('TEBOT_KEY2', null),
    ]
];
```

Dan untuk cara penggunaan nya lihat contoh berikut
```php
    // Contoh menggunakan channel default
    Tebot::alert('Hai, ini adalah pesan alert dari Tebot!');

    // Contoh penggunaan channel example
    Tebot::alert('Hai')->channel('example');
```

Dengan catatan `TEBOT_KEY` nya harus berbeda

## Kontribusi

Jika Anda menemukan masalah atau ingin berkontribusi pada pengembangan package ini, Anda dapat membuka _issue_ atau mengirim _pull request_ melalui GitHub repository kami.

## Lisensi

Tebot ini bersifat open-source dengan lisensi [MIT License](https://opensource.org/licenses/MIT). Anda bebas menggunakan, mengubah, dan mendistribusikan package ini sesuai dengan ketentuan lisensi.