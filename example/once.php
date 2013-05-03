<?php

namespace Pagon\Event;

require dirname(__DIR__) . '/vendor/autoload.php';

use Pagon\Event;
use Pagon\EventEmitter;

Event::once('new', function () {
    echo 'A new client is coming' . PHP_EOL;
});

// Emit
Event::emit('new');

// Can not emit
Event::emit('new');

$event = new EventEmitter();