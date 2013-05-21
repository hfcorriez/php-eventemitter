EventEmitter [![Build Status](https://travis-ci.org/hfcorriez/php-eventemitter.png)](https://travis-ci.org/hfcorriez/php-eventemitter)
=========

Simple Event Emitter for PHP

Install
==============

Add `pagon/eventemitter` to `composer.json` then install with `composer.phar install`

Namespace
==============

All the classes under `Pagon\EventEmitter` namespace

- Event
- EventEmitter

Usage
==============

### Simple usage

```php
// Register event listener
Event::on('save', function ($arg) {
    echo '1 saved: ' . $arg . PHP_EOL;
});

// Emit the event
Event::emit('save', 'test');
```

### Once emit usage

```php
Event::once('new', function () {
    echo 'A new client is coming' . PHP_EOL;
});

// Emit
Event::emit('new');

// Can not emit
Event::emit('new');
```

### Many emit usage

```php
Event::many('new', 2, function () {
    echo 'A new client is coming' . PHP_EOL;
});

Event::emit('new'); // Trigged
Event::emit('new'); // Trigged
Event::emit('new'); // Can not Trigged
```

### Pattern Register

```php
Event::on('news.*', function($event){
    echo $event . ' is comming...';
});

Event::emit('news.1');
Event::emit('news.2');
Event::emit('news.3');
```

### Use your event emitter

```php
// Set emitter
$emitter = new EventEmitter();
Event::emitter($emitter);

Event::on('save', function ($arg) {
    echo '1 saved: ' . $arg . PHP_EOL;
});

// Emit the save
Event::emit('save', 'test');

// This is same as above
$emitter->emit('save');
```


### Extend your class

```php
class Model extent EventEmitter {
    public function load() {
        $this->emit('load');
    }
}

$model = new Model();
$model->on('load', function($model) {
    // Something to do
});
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