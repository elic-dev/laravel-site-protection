# Very simple site wide password protection for Laravel5

This will add a simple password form in front of your application to protected it
from any access. The password is specified using the `.env` file to protect DEV
or STAGE sites only.

You can use multiple passwords for different user groups. Once the password is
removed, the access is revoked.

This does not protect any assets files like css or images.

## Installation

```
composer require elic-dev/laravel-site-protection
```

### Laravel >= 5.2

This package requires at least the Laravel Framework of version **5.2**.

Add ServiceProvider to the providers array in `app/config/app.php`.

```
ElicDev\SiteProtection\SiteProtectionServiceProvider::class,
```

### Laravel >= 5.5

You don't need to add this package to your `app/config/app.php` since it supports auto discovery.

### Add Middleware

Add Middleware to `app/Http/Kernel.php` or specific routes you want to protect.

```
protected $middlewareGroups = [
    'web' => [
        ...
        \ElicDev\SiteProtection\Http\Middleware\SiteProtection::class,
    ],
    ...
];
```

### Configuration

Add your password to `.env`. You can use multiple passwords separated by comma.

```
SITE_PROTECTION_PASSWORDS=password1,password2
```

To revoke access to your site simply change the password. This requires every
user using the old password to re-enter a password.

### Customization

You can modify the view that handles password entry by publishing the views to your resource folder.

Run the following command:

```
php artisan vendor:publish --provider="ElicDev\SiteProtection\SiteProtectionServiceProvider" --tag=views
```

You can now make the changes in `resources/vendor/views/site-protection/site-protection-form.blade.php`.
