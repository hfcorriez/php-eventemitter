<?php

namespace CodeGun\Event;

require __DIR__ . '/../lib/CodeGun/EventEmitter/Event.php';
require __DIR__ . '/../lib/CodeGun/EventEmitter/EventEmitter.php';

use CodeGun\EventEmitter\Event;

Event::once('new', function () {
    echo 'A new client is coming' . PHP_EOL;
});

// Emit
Event::emit('new');

// Can not emit
Event::emit('new');