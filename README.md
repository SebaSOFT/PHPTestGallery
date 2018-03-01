# PHPTestGallery
Another Test that features a custom router and an AJAX (jQuery/Bootstrap) image upload galery

## Requisites
In order to execute the project you need to have installed:

- [PHP 7.x](http://php.net/downloads.php) with: 
  - Enabled modules: mb_string, pdo_sqlite, sqlite3
  - php.ini: upload_max_filesize should be at lease 2M 
- [Composer](https://getcomposer.org/download/)
- PHP CLI and Composer should be in $PATH 

## Generate Autoloads

After downloading the project execute:

```
composer install
```

To generate the needed autoload script

## Running with PHP CLI Server
```
composer run serve --timeout=0
```