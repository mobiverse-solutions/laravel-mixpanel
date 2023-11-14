# <div align="center">Laravel MixPanel</div>
<div align="center">

[![Status](https://img.shields.io/badge/status-active-success.svg)]()
[![GitHub Issues](https://img.shields.io/github/issues/mobiverse-solutions/The-Documentation-Compendium.svg)](https://github.com/mobiverse-solutions/laravel-mixpanel/issues)
[![GitHub Pull Requests](https://img.shields.io/github/issues-pr/mobiverse-solutions/The-Documentation-Compendium.svg)](https://github.com/mobiverse-solutions/laravel-mixpanel/pulls)
[![License](https://img.shields.io/badge/license-MIT-blue.svg)](/LICENSE)

</div>

---

<p align="center"> Laravel Mixpanel Package
    <br> 
</p>

## 📝 Table of Contents

- [About](#about)
- [Getting Started](#getting_started)
- [Components](#components)
- [Usage](#usage)
- [Built Using](#built_using)
- [Authors](#authors)

## 🧐 About <a name = "about"></a>
Laravel Mixpanel is a Laravel package which makes Mixpanel integration into your app a breeze.

## Features
- Asynchronous data transmission to Mixpanel's services. This prevents any delays to your application if Mixpanel is down, or slow to respond.
- Drop-in installation and configuration into your Laravel app.

## 🏁 Getting Started <a name = "getting_started"></a>

### Prerequisites
Before setting up this project on your local machine, you need to meet the following requirements:

1. PHP v8.0
2. Composer v2.3.2

NB: versions may vary

## 🎈 Usage <a name="usage"></a>
This package is not available on Packagist. Hence, to use this package in your laravel project:
1. Add the following sections to your project's `composer.json` file:

    ```json
    {
      "require": {
        "mobiverse-solutions/laravel-mixpanel": "dev-master"
      }
    }
    ```
    ```json
    {
      "repositories": [
        {
          "type": "git",
          "url": "https://github.com/mobiverse-solutions/laravel-mixpanel.git"
        }
      ]
    }
    ```

2. The above section points to  a private repository, hence you would need to provide composer with a personal access
   token from GitHub to successfully pull the contents of the repo.
   For local development, it is recommended that you create
   a gitignored `auth.json` file with the following content, in the root of your project:

    ```json
    {
      "github-oauth": {
        "github.com": "token"
      }
    }
    ```

3. Then, proceed to run the following command to resolve the dependency:
    ```bash
    composer update
    ```

4. For remote access, you can set up an environment secret with name `COMPOSER_AUTH`, which will contain the JSON formatted
   content of the `auth.json` file:
    ```bash
    COMPOSER_AUTH='{"github-oauth":{"github.com":"token"}}'
    ```

5. After successfully adding this package to your project, you will need to publish the config file where you can
   set up your credentials for Asterisk ARI access. The following command will allow you to do that:
    ```bash
    php artisan vendor:publish --tag laravel-mixpanel-config
    ```

6. The config file `laravel-mixpanel.php`, will be published to your config directory `./config`. Customize
   it to suit your needs.

7. Add your Mixpanel API Token to your .env file:
   ```bash
   MIXPANEL_TOKEN=xxxxxxxxxxxxxxxxxxxxxx
   ```

8. For how to use, see an example below:
   ```php
    use Mobiverse\LaravelMixpanel\LaravelMixpanel;

   class MyClass
   {
       protected $mixPanel;
   
       public function __construct(LaravelMixPanel $mixPanel)
       {
           $this->mixPanel = $mixPanel;
       }
   }
    ```

   After that you can make the usual calls such as the following and more:
   ```php

   $mixPanel->identify($user->id);
   
   $mixPanel->track('User just paid!');
   
   $mixPanel->people->trackCharge($user->id, '9.99');
   
   $mixPanel->people->set($user->id, [$data]);
   ```


## ⛏️ Built Using <a name = "built_using"></a>
- [PHP](https://www.php.net/) - Language

## ✍️ Authors <a name = "authors"></a>
- [@gashey](https://github.com/gashey) - Initial work

## Attribution
This is built from a fork of Mike Bronners work here:
https://github.com/mikebronner/laravel-mixpanel