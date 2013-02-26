<?php

namespace CodeGun\Event;

require __DIR__ . '/../lib/CodeGun/EventEmitter/Event.php';
require __DIR__ . '/../lib/CodeGun/EventEmitter/EventEmitter.php';

use CodeGun\EventEmitter\Event;

Event::on('save', function ($arg) {
    echo '1 saved: ' . $arg . PHP_EOL;
});

Event::on('save', function ($arg) {
    echo '2 saved: ' . $arg . PHP_EOL;
});

Event::emit('save', 'test');