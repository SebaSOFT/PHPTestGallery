# PHPTestGallery
Another Test that features a custom router and an AJAX (jQuery/Bootstrap) image upload galery

## The Premise

### Simple image gallery
 A single page application with list of images and upload image form.
 There must be a list of images with ability to delete an image.
 Images list could be loaded via ajax request in json.
 Upload form with uploading via ajax request(Uploaded files has to be not more than 2Mb and only .jpg/jpeg or .png).
 Uploaded form also has to have description field with text limitation 300 symbols.
 Images data should be store in db (filename, size, description)

### Limitations
 You can use JQuery, Bootstrap css on frontend and have to use raw php on backend.

## The Solution

### Requisites
In order to execute the project you need to have installed:

- [PHP 7.x](http://php.net/downloads.php) with: 
  - Enabled modules: mb_string, pdo_sqlite, sqlite3
  - php.ini: upload_max_filesize should be at lease 2M 
- [Composer](https://getcomposer.org/download/)
- PHP CLI and Composer should be in $PATH 

### Generate Autoloads

After downloading the project execute:

```
composer install
```

To generate the needed autoload script

### Running with PHP CLI Server
```
composer run serve --timeout=0
```

## The Evidence

### Home page

![Imgur](https://i.imgur.com/hajk9YN.jpg?1)

### Home page (mobile)

![Imgur](https://i.imgur.com/U25p1Lq.png)

### Lightbox

![Imgur](https://i.imgur.com/TIJaUM6.jpg?1)

### Upload errors

![Imgur](https://i.imgur.com/2LzQphY.png?1)

Gallery: https://imgur.com/a/hodHH