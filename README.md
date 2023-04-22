## Crypto Balance Monitor

Powered by Laravel 10 (PHP 8).

### Running the app

1) Copy and fill out local `.env` file
2) Set up you DB. </br>
   The simplest way is to use SQLite.
    1) Just create <path-to-your-project>/database/database.sqlite file and make sure
    2) Make sure your `.env` looks like this </br>
   ````ini
   DB_CONNECTION=sqlite
   DB_HOST=127.0.0.1
   DB_PORT=3306
   ````
3) Add blockchain APIs basic urls
    ````ini
    BLOCKCYPHER_URL=https://api.blockcypher.com/v1/
    ETHERSCAN_URL=https://api.etherscan.io/api/
    ````
4) Navigate to your project folder and run `php artisan migrate` to create all DB tables. </br> *Optional*: If u want to
   populate DB with fake data, run `php artisan db:seed`
5) Run `php artisan serve`
6) Run `php artisan schedule:work` to simulate crontab

### Tests

Run `php artisan test`

