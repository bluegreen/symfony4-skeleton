# symfony4-skeleton

## Installation

[Install Composer](https://getcomposer.org/download/), which is used to install PHP packages.

```
git clone https://github.com/bluegreen/symfony4-skeleton.git project_name
cd project_name
composer install
``` 

## Configuring a Web Server

Configure virtual host so that document root directs to your project directory. This directory is /var/www/project/public/.
For more information, please visit the [Configuring a Web Server](https://symfony.com/doc/4.4/setup/web_server_configuration.html) page.

## User interface

User interface is using [Bootstrap 4.4.1](https://getbootstrap.com/)
To run the application, go to the application's home page in your browser.

## Tests

To run all tests use Composer `tests` script:

```
composer tests
```