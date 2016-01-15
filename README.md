# Snapshot [![Latest Stable Version](https://poser.pugx.org/michaeljennings/snapshot/v/stable)](https://packagist.org/packages/michaeljennings/snapshot) [![License](https://poser.pugx.org/michaeljennings/snapshot/license)](https://packagist.org/packages/michaeljennings/snapshot)
A PHP package that stores a [whoops-like](https://github.com/filp/whoops) snapshot of your application and allows you to retrieve it later to help with debugging.

The package also comes with Slack integration so you can receive notifications whenever a snapshot is captured.

- [Planned Features](#planned-features)
- [Installation](#installation)
- [Laravel Integration](#laravel-integration)
- [Usage](#usage)
    - [Taking a Snapshot](#taking-a-snapshot)
    - [Rendering a Snapshot](#rendering-a-snapshot)
    - [Finding a Snapshot](#finding-a-snapshot)
- [Slack Integration](#slack-integration)
    - [Customising the Message](#customising-the-message)
- [Adding Event Listeners](#adding-event-listeners)

## Planned Features

- File Store
- More views to choose from

## Installation
This package requires PHP 5.4+ and includes laravel 5+ support.

To install through composer you can either use `composer require michaeljennings/snapshot` or include the package in your `composer.json`.

```php
"michaeljennings/snapshot": "0.2.*"
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
To get started we first need to instantiate the snapshot class. If you are using the laravel integration this is done for you when you register the service provider.

```php
// Require the composer autoload
require "vendor/autoload.php";

// Get the package config
$config = require "path/to/config/snapshot.php";

// Instantiate the dependencies 
$store = new $config['store']['class']($config);
$renderer = new $config['renderer'];
$dispatcher = new \Michaeljennings\Snapshot\Dispatcher(new \League\Event\Emitter());

// Create the snapshot class
$snapshot = new Snapshot($store, $renderer, $dispatcher, $config);
```

### Taking a Snapshot
To take a snapshot of your application use the `capture` method.

```php
$snapshot = new Snapshot($store, $renderer, $dispatcher, $config);

$snapshot->capture();
```

This will store all of the debug stack trace and any server, post, get, file, cookie, session and environment variables.

If you want to store any additional data, i.e. the current user, you can pass an array of data to the `capture` method.

```php
$snapshot->capture(['user_id' => 1]);
```

If you are specifically capturing an exception you can use the `captureException` method. The benefit of this method is you can override the exception message and code by passing them in. You can still store any additional data by passing it as the 4th parameter.

```php 
$snapshot->captureException($exception);

$snapshot->captureException($exception, 500, 'Internal Server Error', ['user_id' => 1]);
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

## Slack Integration

Snapshot also comes with Slack support through the excellent [mankz/slack](https://github.com/maknz/slack/) package.

In your config file just enable slack integration, and then add in your [incoming webhook endpoint](https://my.slack.com/services/new/incoming-webhook), channel, and username and you shall start receiving slack messages whenever a snapshot is captured.
 
This is very useful for catching errors before they are reported.

### Customising the Message

By default the message will be `#{snapshot-id} A new snapshot has been captured`. 

If you want to customise this message then you can extend the `Michaeljennings\Snapshot\Listeners\SendToSlack.php` event listener and override the `getMessage` method. 

Then you simply need to update the listener subscribed in the snapshot config to the `Michaeljennings\Snapshot\Events\SnapshotCaptured` event to your new listener.

## Adding Event Listeners

It is possible that you want something to happen every time a snapshot is captured. An example of this is how we send a message to slack whenever a snapshot is captured.
  
To do this we add in event listeners. There are two ways we can go about this, either you can subscribe you listeners in the `listeners` array in the config, or you can call the `addListener` method on the slack class.

To add one into the config set the key as the event you are subscribing to, and the value as an array of listeners.

```php
'listeners' => [

    'Michaeljennings\Snapshot\Events\SnapshotCaptured' => [
        'Michaeljennings\Snapshot\Listeners\SendToSlack',
        'MyCustomListener'
    ]

]
```

To subscribe a listener using the `addListener` method pass the event name you are subscribing to as the first parameter, and then either a class name or a closure to use as a listener.

```php
$snapshot->addListener('Michaeljennings\Snapshot\Events\SnapshotCaptured', 'Michaeljennings\Snapshot\Listeners\SendToSlack');

$snapshot->addListener('Michaeljennings\Snapshot\Events\SnapshotCaptured', function($event) {
    // Handle event
});
```