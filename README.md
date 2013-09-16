Other Languages：[English](./README_en.md)

# 介绍 [![Build Status](https://travis-ci.org/hfcorriez/php-eventemitter.png)](https://travis-ci.org/hfcorriez/php-eventemitter)

简单的事件管理器

# 安装

添加 `"pagon/eventemitter": "*"` 到 `composer.json`

```
composer.phar install
```

# 使用方式

## 触发和绑定

### 简单方式

很简单的使用方式

```php
$event = new EventEmitter();

// 绑定事件
$event->on('new', function () {
    echo 'A new client is coming' . PHP_EOL;
});

// 触发
$event->emit('new');
```

### 单次绑定

绑定的事件只会被触发一次，适合第一次做一些事情的时候去使用

```php
$event = new EventEmitter();

// 绑定单次事件
$event->once('new', function () {
    echo 'A new client is coming' . PHP_EOL;
});

// 触发
$event->emit('new');

// 不触发
$event->emit('new');
```

### 多次绑定

绑定的事件被触发N次，适合一些有固定用途的事件

```php
$event = new EventEmitter();

// 绑定2次事件
$event->many('new', 2, function () {
    echo 'A new client is coming' . PHP_EOL;
});

$event->emit('new'); // 触发
$event->emit('new'); // 触发
$event->emit('new'); // 不触发
```

### 模糊绑定

绑定一个模糊的事件名称，可以匹配上的事件都会被触发

```php
$event = new EventEmitter();

// 绑定模糊事件
$event->on('news.*', function($id){
    echo $id . ' is comming..., ID is ';
});

$event->emit('news.1');
$event->emit('news.2');
$event->emit('news.3');
```

## 删除

### 注销事件

当事件不用的时候可以注销掉

```php
$event = new EventEmitter();

// 闭包回调
$operator = function () {
    echo 'A new client is coming' . PHP_EOL;
};

$event->on('new', $operator);

$event->emit('new');           // 触发

$event->off('new', $operator); // 解除绑定
$event->emit('new');           // 不触发
```

### 删除事件

删除指定类型的所有事件

```php
$event = new EventEmitter();

$event->on('new', function () {
    echo 'A new client is coming' . PHP_EOL;
});

$event->removeAllListeners('new');
```

### 删除所有事件

清空事件

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

### 继承事件功能

适用于为自己的对象增加事件功能

```php
class MyClass extends EventEmitter {
}

$my = new MyClass;
$my->on('create', function($data){
    $db->save($data);
});
```

## 全局管理器

### 全局事件

可以作为默认是件管理器使用

```php
// 注册事件
Event::on('save', function ($arg) {
    echo '1 saved: ' . $arg . PHP_EOL;
});

// 触发事件
Event::emit('save', 'test');
```

### 更换全局事件管理器

```php
$emitter = new EventEmitter();
// 更换触发器
Event::emitter($emitter);

// 绑定事件
$event->on('save', function ($arg) {
    echo '1 saved: ' . $arg . PHP_EOL;
});

// 触发save
$event->emit('save', 'test');

// 效果同上
$emitter->emit('save', 'test');
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