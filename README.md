<p align="center"><a href="javascript:void(0);" target="_blank"><img src="https://recruitment-pas.web.app/assets/logo-pas-with-text.a23ed92b.png" width="400" alt="Laravel Logo"></a></p>

# Panduan Instalasi Project Laravel

## Persyaratan Sistem

Sebelum memulai, pastikan sistem Anda memenuhi persyaratan berikut:

-   PHP >= 8.2
-   Composer (versi terbaru)
-   Node.js & NPM
-   Git
-   XAMPP/Laragon/Server lokal lainnya
-   Text editor (VS Code/Sublime Text/dll)
-   MySQL/MariaDB

## Langkah-langkah Instalasi dan Pengaturan

### 1. Clone Repository

1. Buka terminal/command prompt
2. Arahkan ke direktori web server Anda:
    ```bash
    cd c:/xampp/htdocs    # untuk XAMPP
    cd c:/laragon/www     # untuk Laragon
    ```
3. Clone repository:
    ```bash
    git clone https://github.com/reishantridyarafly/test-pt-pas.git
    ```
4. Masuk ke direktori project:
    ```bash
    cd test-pt-pas
    ```

### 2. Konfigurasi Project

1. Copy file `.env.example` menjadi `.env`:
    ```bash
    cp .env.example .env
    ```
2. Generate application key:
    ```bash
    php artisan key:generate
    ```
3. Sesuaikan konfigurasi database di file `.env`:

    ```
    APP_NAME="PT. PAS"
    
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=test_pt_pas
    DB_USERNAME=root
    DB_PASSWORD=

    MAIL_MAILER=smtp
    MAIL_HOST=smtp.gmail.com
    MAIL_PORT=587
    MAIL_USERNAME=<your-gmail-address>
    MAIL_PASSWORD=<your-gmail-app-password>
    MAIL_ENCRYPTION=tls
    MAIL_FROM_ADDRESS="<your-gmail-address>"
    MAIL_FROM_NAME="${APP_NAME}"

    WHATSAPP_TOKEN="<your-whatsapp-api-token>"

    TELEGRAM_BOT_TOKEN="<your-telegram-bot-token>"
    TELEGRAM_CHAT_ID="<your-telegram-chat-id>"
    ```

### 3. Install Dependencies

1. Install dependencies PHP:
    ```bash
    composer install
    ```
2. Install dependencies Node.js:
    ```bash
    npm install
    npm run build
    ```

### 4. Setup Database dan Migrasi

1. Buat database baru dengan nama `test_pt_pas`
2. Jalankan migrasi database:
    ```bash
    php artisan migrate --seed
    ```

### 5. Menjalankan Project

1. Jalankan server Laravel:

    ```bash
    php artisan serve

    php artisan queue:work

    php artisan schedule:work
    ```

2. Buka browser dan akses:
    ```
    http://localhost:8000
    ```
