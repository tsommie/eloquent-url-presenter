# Laravel Url Presenter
This is a simple presenter much like the [Laracast](https://github.com/laracasts) [Presenter](https://github.com/laracasts/Presenter) but specifically tailored for presenting urls in Laravel as suggested by a post on [laravel-news.com](https://laravel-news.com/leverage-eloquent-to-prepare-your-urls) writen by [Jordan Dalton](https://laravel-news.com/@jordandalton).

<!-- TOC -->

- [Laravel Url Presenter](#laravel-url-presenter)
    - [1.1. Setting up](#11-setting-up)
        - [1.1.1. Installation on Lumen 5.x and Laravel 5.x.](#111-installation-on-lumen-5x-and-laravel-5x)
        - [1.1.2. Installation on Lumen and Laravel 5.4 and below.](#112-installation-on-lumen-and-laravel-54-and-below)
            - [1.1.2.1. Service Provider](#1121-service-provider)
        - [1.1.3. Publishing config file.](#113-publishing-config-file)
        - [1.1.4. Configure paths for generated processes](#114-configure-paths-for-generated-processes)
    - [1.2. Usage](#12-usage)
        - [1.2.1. Creating a url presenter](#121-creating-a-url-presenter)
        - [1.2.1. Preparing model to use Url Presenter](#121-preparing-model-to-use-url-presenter)
        - [1.3. Laravel url presenter command](#13-laravel-url-presenter-command)
    - [1.3. Security Vulnerabilities](#13-security-vulnerabilities)
    - [1.4. License](#14-license)

<!-- /TOC -->

## 1.1. Setting up
### 1.1.1. Installation on Lumen 5.x and Laravel 5.x.
Add the Laravel Form Processor package to your `composer.json` file.

```
composer require ac-developers/eloquent-url-presenter
```

> **Auto-discovery:** Is supported in Laravel Form Processor [auto-discovery](https://medium.com/@taylorotwell/package-auto-discovery-in-laravel-5-5-ea9e3ab20518) for Laravel 5.5 and greater.

### 1.1.2. Installation on Lumen and Laravel 5.4 and below.
#### 1.1.2.1. Service Provider

In your app config, add the `EloquentUrlPresenterServiceProvider` to the providers array.

```php
'providers' => [
    AcDevelopers\EloquentUrlPresenter\EloquentUrlPresenterServiceProvider::class,
    ];
```

For **Lumen**, add the provider to your `bootstrap/app.php` file.

```php
$app->register(AcDevelopers\EloquentUrlPresenter\EloquentUrlPresenterServiceProvider::class);
```
### 1.1.3. Publishing config file.
To publish the config file to `config/eloquent-url-presenter.php` run:

```
php artisan vendor:publish --provider="AcDevelopers\EloquentUrlPresenter\EloquentUrlPresenterServiceProvider"
```

### 1.1.4. Configure paths for generated processes
To change the paths of saving the generated url presenters, you need to configure their namespaces in a configuration file `config/ac-developers/eloquent-url-presenter.php`.

```

return [
    /*
    |--------------------------------------------------------------------------
    | Default namespaces for the classes
    |--------------------------------------------------------------------------
    */
    'namespaces' => [
        'presenter'   => 'App\Presenters\Url',
        'model'        => 'App\\',
    ],
];
```


After this your good to go.

## 1.2. Usage

### 1.2.1. Creating a url presenter 
Creating a url presenter class is as easy as creating any other php class with just a few steps required to make it url presentable. In our case we will create a UserUrlPresenter class.

first it extends our EloquentUrlPresenterClass. Next you pass in the eloquent model that would be making use of the newly created url presenter in to it's constructor like this:
```
/**
 * UserUrlPresenter constructor.
 *
 * @param \App\User $user
 */
public function __construct(User $user)
{
    parent::__construct($user);

    //
}
```
Then create the method that would return the desired url.
```

/**
 * Get the show url for this user
 *
 * @return string
 */
public function show()
{
    return url('show/{user}', ['slug' => $this->entity])
}
```
If your on Laravel or Lumen and you want to make this presenter resoucesful without manually adding the methods one by one you just have to add the `HasResource` trait to the UrlPresenter and implement the `route` method which should return a string similar to that passed in as first argument in the `Route::resouce` method and the `parameter` method which does exactly what you would expect.

So if in your route method looks like `Route::resource('users', 'UserController')` then the `route` method implemented in the UserUrlPresenter should return `users` else laravel will throw an exception.

And the next is to prepare our model to use our url presenter.

### 1.2.1. Preparing model to use Url Presenter
Preparing the model that would use the url presenter is simple,  Just use the EloquentUrlPresentableTrait and then implementing the urlPresenter methord which will return our UserUrlPresenter class

```
/**
 * Prepare a new or cached url presenter instance
 *
 * @return mixed
*/
public function urlPresenter()
{
    return UserUrlPresenter::class;
}
```
Next we will add "url" to our appends property array like this:

```
/**
 * The accessors to append to the model's array form.
 *
 * @var array
 */
protected $appends = ['url'];
```

Next you add `url` as an array value in our model's `appends` property and then your done.

Now in our code we can link to our user model show page like this:

```
$user->url->show
```
Lets say your using the `HasResource` trait you'll automatically have access to all resourcful route methods and these includes `index`, `create`, `show`, `edit`, `store`, `update` and `destroy`

### 1.3. Laravel url presenter command

> **Note: This is to be used only in Laravel and Lumen applications

Ofcause the following steps narrated previously was to show you how to do it yourself. You can skip this and just run the `php artisan generate:urlPresenter` command. For example to create our `UserUrlPresenter` we would do like this: 

```
php artisan generate:urlPresenter UserUrlPresenter --model=User
```

To make a resourceful url presenter all you have to do is pass the `resouces` option while generating the url presenter without a value like so:

```
php artisan generate:urlPresenter UserUrlPresenter --model=User --resource
```

## 1.3. Security Vulnerabilities
If you discover a security vulnerability within Laravel Form Processor, please send an e-mail to Anitche Chisom via anitchec.dev@gmail.com. All security vulnerabilities will be promptly addressed.

## 1.4. License
The Eloquent Url Presenter is open-sourced software licensed under the [MIT](LICENSE) license.