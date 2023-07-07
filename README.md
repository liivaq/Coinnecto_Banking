![coinnecto_logo](https://github.com/liivaq/Coinnecto_Banking/assets/123387229/25f23edf-fe5c-4908-87b9-3be9c1562680)

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

1. Register as a new user:
![register](https://github.com/liivaq/Coinnecto_Banking/assets/123387229/c190e336-dcea-4e5d-909a-306d896816df)

2. Acquire your secret key, for making safe transactions with an authenticator app:
![user_secret](https://github.com/liivaq/Coinnecto_Banking/assets/123387229/d7d5d3b8-280b-4520-a2d5-69ada6a0fec8)

3. Open accounts (checking or investment) in different currencies:
![open_account](https://github.com/liivaq/Coinnecto_Banking/assets/123387229/38c2f663-a68c-4cb4-89ab-7d22e6c318ed)

4. Make transactions:   
![transaction](https://github.com/liivaq/Coinnecto_Banking/assets/123387229/84daa540-05a8-4797-a218-6952b56f0b8e)

5. Explore crypto market:
![crypto_market](https://github.com/liivaq/Coinnecto_Banking/assets/123387229/4f3ed7e1-be33-423d-9ee0-35a8f3b26860)

6. Buy/sell cryptos:
![crypto_buy](https://github.com/liivaq/Coinnecto_Banking/assets/123387229/78754e1f-96cc-4622-bc6c-2e306688775a)
