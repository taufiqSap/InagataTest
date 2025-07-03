## Link Video

## Cara Menjalankan Aplikasi

1. **Clone project:**
Clone project git clone https://github.com/taufiqSap/InagataTest.git cd InagataTest

2. **Install Dependencies:**
    composer install

3. **Set Environment:**
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=inagata
   DB_USERNAME=root
   DB_PASSWORD=

4. **Generate App Key:**
    php artisan key:generate

5. **Migrate Database:**
    php artisan migrate

6. **Jalankan Server:**
    php artisan serve
