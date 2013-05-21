<?php
namespace Pagon;

class EventEmitterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var EventEmitter
     */
    protected $event;

    public function setUp()
    {
        $this->event = new EventEmitter();
    }

    public function testSimple()
    {
        $closure = function () {
        };

        $this->event->on('test', $closure);

        $this->assertEquals(array($closure), $this->event->listeners('test'));
    }

    public function testEmit()
    {
        $GLOBALS['emit_result'] = 0;
        $closure = function () {
            $GLOBALS['emit_result'] = 1;
        };

        $this->event->on('test', $closure);

        $this->assertEquals(0, $GLOBALS['emit_result']);
        $this->event->emit('test');
        $this->assertEquals(1, $GLOBALS['emit_result']);
    }

    public function testOnce()
    {
        $GLOBALS['emit_result'] = 0;
        $closure = function () {
            $GLOBALS['emit_result']++;
        };

        $this->event->once('test', $closure);

        $this->assertEquals(0, $GLOBALS['emit_result']);
        $this->event->emit('test');
        $this->assertEquals(1, $GLOBALS['emit_result']);
        $this->event->emit('test');
        $this->assertEquals(1, $GLOBALS['emit_result']);
    }

    public function testMany()
    {
        $GLOBALS['emit_result'] = 0;
        $closure = function () {
            $GLOBALS['emit_result']++;
        };

        $this->event->many('test', 2, $closure);

        $this->assertEquals(0, $GLOBALS['emit_result']);
        $this->event->emit('test');
        $this->assertEquals(1, $GLOBALS['emit_result']);
        $this->event->emit('test');
        $this->assertEquals(2, $GLOBALS['emit_result']);
        $this->event->emit('test');
        $this->assertEquals(2, $GLOBALS['emit_result']);
    }

    public function testPattern()
    {
        $GLOBALS['emit_result'] = '';
        $GLOBALS['emit_count'] = 0;
        $closure = function ($event) {
            $GLOBALS['emit_result'] = $event;
            $GLOBALS['emit_count']++;
        };

        $this->event->on('test.*', $closure);

        $this->assertEquals('', $GLOBALS['emit_result']);
        $this->assertEquals(0, $GLOBALS['emit_count']);
        $this->event->emit('test.1');
        $this->assertEquals('test.1', $GLOBALS['emit_result']);
        $this->assertEquals(1, $GLOBALS['emit_count']);
        $this->event->emit('test.2');
        $this->assertEquals('test.2', $GLOBALS['emit_result']);
        $this->assertEquals(2, $GLOBALS['emit_count']);
        $this->event->emit('test');
        $this->assertEquals('test.2', $GLOBALS['emit_result']);
        $this->assertEquals(2, $GLOBALS['emit_count']);
    }

    public function testMulti()
    {
        $GLOBALS['emit_result'] = 0;
        $closure = function () {
            $GLOBALS['emit_result']++;
        };

        $this->event->on(array('a', 'b', 'c'), $closure);

        $this->assertEquals(0, $GLOBALS['emit_result']);
        $this->event->emit('a');
        $this->assertEquals(1, $GLOBALS['emit_result']);
        $this->event->emit('c');
        $this->assertEquals(2, $GLOBALS['emit_result']);
        $this->event->emit('b');
        $this->assertEquals(3, $GLOBALS['emit_result']);
    }
}
