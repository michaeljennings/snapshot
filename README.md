# Snapshot [![Latest Stable Version](https://poser.pugx.org/michaeljennings/snapshot/v/stable)](https://packagist.org/packages/michaeljennings/snapshot) [![Latest Unstable Version](https://poser.pugx.org/michaeljennings/snapshot/v/unstable)](https://packagist.org/packages/michaeljennings/snapshot) [![License](https://poser.pugx.org/michaeljennings/snapshot/license)](https://packagist.org/packages/michaeljennings/snapshot)
A PHP package that stores a snapshot of your application and allows you to retrieve it later to help with debugging.

## Planned Features

- Native PHP renderer
- PDO Store
- File Store
- More views to choose from

## Installation
This package requires PHP 5.4+ and includes laravel 5 support.

To install through composer you can either use `composer require michaeljennings/snapshot` or include the package in your `composer.json`.

```php
"michaeljennings/snapshot": "~0.1"
```

Then run either `composer install` or `composer update` to download the package.

## Laravel Integration

To use the package with Laravel 5 add the snapshot service provider to the list of service providers in `app/config/app.php`.

```php
'providers' => array(

  'Michaeljennings\Snapshot\SnapshotServiceProvider'
  
);
```

Then add the `Snapshot` facade to the aliases array.

```php
'aliases' => array(

  'Snapshot' => 'Michaeljennings\Snapshot\Facades\Snapshot',

);
```

Then use `php artisan vendor:publish` to publish the config and database migrations. 

The package comes with database migrations if you want to use a database store. To run the migrations use `php artisan migrate` to set up the snapshot database tables.

To use the package you can either use the `Snapshot` facade or if you prefer using dependency injection snapshot is bound to the IOC container by its interface.

```php
Snapshot::capture();

public function __construct(Michaeljennings\Snapshot\Contracts\Snapshot $snapshot)
{
    $this->snapshot = $snapshot;
}
```

## Usage

### Taking a Snapshot
To take a snapshot of your application use the `capture` method.

```php
$snapshot = new Snapshot($store, $renderer, $config);

$snapshot->capture();
```

This will store all of the debug stack trace and any server, post, get, file, cookie, session and environment variables.

If you want to store any additional data, i.e. the current user, you can pass an array of data to the `capture` method.

```php
$snapshot->capture(['user_id' => 1]);
```

### Rendering a Snapshot
To render a snapshot use the `render` method, this takes one parameter which is the id of the snapshot.

```php
$snapshot->render(1);
```

### Finding a Snapshot

Alternatively if you want to choose how to render the snapshot yourself you can get the snapshot by its id using the `find` method.

```php
$snapshot->find(1);
```