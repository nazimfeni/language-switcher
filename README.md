## Language switcher setup in Laravel
### Install laravel 10
```
composer create-project "laravel/laravel:^10.0" example-app
```
### setup db and configure in .env file 
### run migration
```
php artisan migrate
```
## Now follow the below step 
### Step 1: Configure Localization
Laravel supports localization out of the box.
1. Open config/app.php
2. Set default locale:
```
'locale' => 'en',
'fallback_locale' => 'en',
```
3. Create language files:
    - resources/lang/en/messages.php
    ```
    <?php
    return [
    'welcome' => 'Welcome',
    ];
    ```
    - resources/lang/bn/messages.php
    ```
    <?php
    return [
    'welcome' => 'স্বাগতম',
    ];
    ```
## Step 2: Create a Language Controller
```
php artisan make:controller LanguageController
```
Then in LanguageController.php:
```
<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class LanguageController extends Controller
{
    public function switchLang($lang)
    {
        if (in_array($lang, ['en', 'bn'])) {
            Session::put('locale', $lang);
        }
        return Redirect::back();
    }
}
```
## Step 3: Middleware to Apply Language
```
php artisan make:middleware LanguageMiddleware
```
Then in app/Http/Middleware/LanguageMiddleware.php:
```
<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageMiddleware
{
    public function handle($request, Closure $next)
    {
        $locale = Session::get('locale', config('app.locale'));
        App::setLocale($locale);

        return $next($request);
    }
}
```
Register this middleware in app/Http/Kernel.php, under web middleware group:
```
protected $middlewareGroups = [
    'web' => [
        // ...
        \App\Http\Middleware\LanguageMiddleware::class,
    ],
];
```
## Step 4: Add Route for Switching
In routes/web.php:
```
use App\Http\Controllers\LanguageController;

Route::get('lang/{lang}', [LanguageController::class, 'switchLang'])->name('lang.switch');
```
### Step 5: Add Language Switcher to View
In your Blade file (resources/views/layouts/app.blade.php or wherever):
```
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'My App')</title>
</head>
<body>

    <nav>
        <!-- Navigation bar -->
        <a href="{{ route('lang.switch', 'en') }}">English</a> |
        <a href="{{ route('lang.switch', 'bn') }}">বাংলা</a>
    </nav>

    <div class="container">
        @yield('content')
    </div>

    <footer>
        <!-- Footer -->
    </footer>

</body>
</html>

```
in welcome.blade.php file replace by the below code
```
@extends('layouts.app')

@section('title', __('messages.welcome'))

@section('content')
    <h1>{{ __('messages.welcome')}}</h1>
   
@endsection

```


