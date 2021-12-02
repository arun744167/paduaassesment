# Running Application with laravel

php artisan serve --port=8082

# Code implementation path:

## app/Http/Controllers/HomeController.php : 
Index page where upload template is sub template included in home template which is index page.
Also CSV convert table is rendered.

## app/Http/Controllers/UploadController.php : 
Controller which handles uploading csv and saved in storage/app/banktxndata. 
Then read each row from csv and create bank transaction objects.

## resources/views/home.blade.php:
Index page template which has upload template included.

## resources/views/upload.blade.php:
Template renders upload view.

## BankTransaction Object:
app/Models/BankTransaction.php

