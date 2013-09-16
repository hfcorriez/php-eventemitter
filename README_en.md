# Intro [![Build Status](https://travis-ci.org/hfcorriez/php-eventemitter.png)](https://travis-ci.org/hfcorriez/php-eventemitter)

A simple EventEmitter

# Install

Add `"pagon/eventemitter": "*"` to `composer.json`

```
composer.phar install
```

# Usage

## Bind and Emit

### Simple

```php
$event = new EventEmitter();

// Bind event
$event->on('new', function () {
    echo 'A new client is coming' . PHP_EOL;
});

// Trigger
$event->emit('new');
```

### Bind once

```php
$event = new EventEmitter();

// Bind event once
$event->once('new', function () {
    echo 'A new client is coming' . PHP_EOL;
});

// Trigger
$event->emit('new');

// Not trigger
$event->emit('new');
```

### Bind many times

```php
$event = new EventEmitter();

// Bind event twice
$event->many('new', 2, function () {
    echo 'A new client is coming' . PHP_EOL;
});

$event->emit('new'); // Trigger
$event->emit('new'); // Trigger
$event->emit('new'); // No trigger
```

### Bind fuzzy

```php
$event = new EventEmitter();

// Bind fuzzy event
$event->on('news.*', function($id){
    echo $id . ' is comming..., ID is ';
});

$event->emit('news.1');
$event->emit('news.2');
$event->emit('news.3');
```

## Remove

### Unbind Event

```php
$event = new EventEmitter();

// Closure
$operator = function () {
    echo 'A new client is coming' . PHP_EOL;
};

$event->on('new', $operator);

$event->emit('new');    // Trigger

$event->off('new', $operator); // Unbind
$event->emit('new');    // No Trigger
```

### Remove Events

```php
$event = new EventEmitter();

$event->on('new', function () {
    echo 'A new client is coming' . PHP_EOL;
});

$event->removeAllListeners('new');
```

### Remove all events

```php
$event = new EventEmitter();

$event->on('new', function () {
    echo 'A new client is coming' . PHP_EOL;
});

$event->on('close', function () {
    echo 'The client has closed' . PHP_EOL;
});

$event->removeAllListeners();
```

### Extends class

Add event feature for your class

```php
class MyClass extends EventEmitter {
}

$my = new MyClass;
$my->on('create', function($data){
    $db->save($data);
});
```

## Global Events

### Global

Use as default event manager

```php
// Register event listener
Event::on('save', function ($arg) {
    echo '1 saved: ' . $arg . PHP_EOL;
});

// Emit the event
Event::emit('save', 'test');
```

### Change default event manager

```php
$emitter = new EventEmitter();
// Change default event manager
Event::emitter($emitter);

$event->on('save', function ($arg) {
    echo '1 saved: ' . $arg . PHP_EOL;
});

// Emit the save
$event->emit('save', 'test');

// This is same as above
$emitter->emit('save');
```

License
=============

(The MIT License)

Copyright (c) 2012 hfcorriez &lt;hfcorriez@gmail.com&gt;

Permission is hereby granted, free of charge, to any person obtaining
a copy of this software and associated documentation files (the
'Software'), to deal in the Software without restriction, including
without limitation the rights to use, copy, modify, merge, publish,
distribute, sublicense, and/or sell copies of the Software, and to
permit persons to whom the Software is furnished to do so, subject to
the following conditions:

The above copyright notice and this permission notice shall be
included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED 'AS IS', WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY
CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT,
TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE
SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.