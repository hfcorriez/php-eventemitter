<?php

namespace Pagon\Event;

require __DIR__ . '/../lib/Pagon/EventEmitter/Event.php';
require __DIR__ . '/../lib/Pagon/EventEmitter/EventEmitter.php';

use Pagon\EventEmitter\Event;

Event::once('new', function () {
    echo 'A new client is coming' . PHP_EOL;
});

// Emit
Event::emit('new');

// Can not emit
Event::emit('new');