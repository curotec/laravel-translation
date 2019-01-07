## About Laravel Translations App

Laravel Translations converts the translation files of different language. For Laravel Language Localization [check here] (https://laravel.com/docs/5.7/localization)

This app converts single file and multiple files.

#### Single File Convert
Convert from Excel - Can convert from specific formatted xlsx and csv to translated php array file.
Convert to Excel - Can convert from php to xlsx file with specific formatting.

#### Multiple File Convert
Convert Excel to Zip - Can convert multiple sheets from specific formatted xlsx and csv to translated php array files and downloaded as zip.
Convert Zip to Excel - Zip containing all php files under a folder, which gets converted into xlsx with multiple sheets.

## Installation

> **Requires [PHP 7.2+](https://php.net/releases/)**

You can install Laravel Translation App in only 6 commands!

The first is to clone the projet :

```bash
git clone https://github.com/curotec/laravel-translator.git
```

Go to the root of the project and launch the second command to launch the projects files

```bash
composer dump-autoload
```

At the root of the project, lets copy the environment file.

For Linux and Mac

```bash
cp .env.example .env
```

For Windows

```bash
copy .env.example .env
```

Still at the root of the project, lets setup the Key.

```bash
php artisan key:generate
```

Still at the root of the project, launch the database. Edit the .env file and setup the DB credentials and then migrate DB.

```bash
php artisan migrate
```

Now still at the root of the project, launch the App

```bash
php artisan serve
```



## Format and Demo sheets

Can check and download the demo data from the dashboard of the App. You will find the link there.


## License
