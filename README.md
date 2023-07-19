# Test assignment
Generate statistics for the following cases:
* List of 5 hotels with the smallest number of weekend stays (weekend nights are Friday and Saturday nights) -> list hotel + number of stays for each of them;
* List hotels and dates where we had to reject customers (= where there were more customers wanting to stay then the capacity of the hotel);
* Show the day when we lost the most due to rejection (= did not have the highest possible income because of the lack of capacity on this day).

## Clarification
Some bookings are reject, because customers want to book hotels in dates, which we don't have in "capacity" table.

For example: Arrival date - 2021-05-18, nights - 5, but last available date in Capacity table - 2021-05-19.

Because we don't have information about capacity for 2021-05-20 and later - capacities on those dates are marked as 0.

## Requirements
* Docker & docker-compose the latest versions should be installed
* PHP >= 8.1.x
* Composer >= 2.x

## How to install application
Clone repository from [GitHub](url)

Create `.env` file from `.env.example` file.
```shell
cp .env.example .env
```

Run next command to install dependencies.
```shell
composer install
```

If you face any issues here, try:
```shell
composer install --ignore-platform-reqs
```

### How to start application
Sail uses docker-compose to run application.

#### For local environment
```shell
./vendor/bin/sail up -d
```

Install dependencies.
```shell
./vendor/bin/sail composer install
```

Run next command to generate APP_KEY in .env file. You should do it only once.
```shell
./vendor/bin/sail artisan key:generate
```

To run database migrations use:
```shell
./vendor/bin/sail artisan migrate
```

To set up data in the MySQL database run next command. You should do it only once, when your database is empty.
```shell
./vendor/bin/sail artisan db:seed
```

To set up statuses for bookings use:
```shell
./vendor/bin/sail artisan booking:set-statuses
```

## Now you can get to work!
Follow the link: http://localhost/
