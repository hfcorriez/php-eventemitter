<?php

namespace Pagon\Event;

require __DIR__ . '/../lib/Pagon/Event.php';
require __DIR__ . '/../lib/Pagon/EventEmitter.php';

use Pagon\Event;

Event::once('new', function () {
    echo 'A new client is coming' . PHP_EOL;
});

// Emit
Event::emit('new');

// Can not emit
Event::emit('new');