<?php

namespace Pagon\Event;

require __DIR__ . '/../lib/Pagon/EventEmitter/Event.php';
require __DIR__ . '/../lib/Pagon/EventEmitter/EventEmitter.php';

use Pagon\EventEmitter\Event;

Event::on('save', function ($arg) {
    echo '1 saved: ' . $arg . PHP_EOL;
});

Event::on('save', function ($arg) {
    echo '2 saved: ' . $arg . PHP_EOL;
});

Event::emit('save', 'test');