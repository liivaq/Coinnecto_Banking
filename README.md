![coinnecto_logo](https://github.com/liivaq/Coinnecto_Banking/assets/123387229/0ec52848-589e-4641-8321-e44687a31582)

## Description

Coinneco Banking is an online banking application, created using Laravel framework.

It's included features are:

* user registration / login;
* ability to open multiple bank accounts in different currencies;
* make transactions between bank accounts with currency conversion;
* 2FA for safe transactions;
* transaction history;
* ability to open investment accounts;
* browse Crypto currency market;
* purchase or sell Crypto currency, using investment accounts;

## Requirements

* PHP 8.2;
* Laravel 9.52.9;
* MySQL 8.0.33;
* Node.js 18.16.1
* Composer

## How to Start

1. Clone this github repo, using the command `git clone https://github.com/liivaq/Coinnecto_Banking.git`
2. Open it in a code editor of your choice
3. Install the dependencies using commands `composer install` and `npm install`
4. Register in [Coin Market Cap API](https://coinmarketcap.com/api/) to get an API key (free)
5. Copy the `.env.example` file and name it `.env`
6. Edit the `.env` file:
   * add your Coin Market Cap API key here: `COIN_MARKET_CAP_KEY=`
   * add your database configuration here (create a new database, if you don't have one):
     - `DB_DATABASE=` name of the database you will be using
     - `DB_USERNAME=` database username
     - `DB_PASSWORD=` database password
7. Run command `php artisan key:generate`
8. Run command `php artisan migrate` - this will build up the database tables (if you want to fill the database with dummy data as well, run command `php artisan migrate --seed`)
9. Run command `npm run dev` - this will build up the frontend
10. In a separate terminal from previous command, run command `php artisan serve` - this will start a local server;
11. Open the link you see in the terminal in any browser.
12. Enjoy!


## Preview



