<?php
/**
 * @author Oleg Stepura <github@oleg.stepura.com>
 * @copyright Oleg Stepura <github@oleg.stepura.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * @version $Id$
 */

namespace Tests\Ost\Chain;
use Ost\Chain\Chain;

/**
 * ChainTest class.
 * @author Oleg Stepura <github@oleg.stepura.com>
 */
class ChainTest extends \PHPUnit_Framework_TestCase
{
    public function testApi()
    {
        $chain = new Chain('test');
        $this->assertEquals(1, $chain->getLength());
        $chain->add('test1')->add('test2')->add('test3');
        $this->assertEquals(4, $chain->getLength());
        $this->assertSame('test2', $chain->get(2));
        $this->assertSame('test', $chain->get(0));
        $this->assertSame('test3', $chain->get(3));
        $this->assertSame('test', $chain->first());
        $this->assertSame('test3', $chain->last());

        $i = 0;
        $expect = array('test', 'test1', 'test2', 'test3');
        foreach ($chain as $elem) {
            $this->assertEquals($expect[$i], $elem);
            $i++;
        }
        $this->assertEquals(4, $i);

        $chain->add('test4')->add('test5')->add('test6');
        $chain->rewind()->next()->next();
        $this->assertSame('test3', $chain->get(3));
        $this->assertSame('test4', $chain->get(4));
        $this->assertSame('test5', $chain->get(5));
        $this->assertSame('test6', $chain->get(6));
        $chain->next()->next();
        $this->assertSame('test3', $chain->get(3));
    }

    /**
     * @outputBuffering disabled
     */
    public function testSpeed()
    {
        $measure = false;
//        $measure = true;

        if (!$measure) {
            return;
        }
        $this->expectOutputString('');

        $iterations = 100;
        $arraySize = 1000;
        var_dump('Iterating, raw PHP array:');
        $time = microtime(true);
        for ($i = 0; $i < $iterations; $i++) {
            $a = array();
            for ($j = 0; $j < $arraySize; $j ++) {
                $a[] = str_repeat($j, 10);
            }
            foreach ($a as $el) {
                $el += '123';
            }
        }
        var_dump(microtime(true) - $time);

        var_dump('Iterating, Chain:');
        $time = microtime(true);
        for ($i = 0; $i < $iterations; $i++) {
            $a = new Chain();
            for ($j = 0; $j < $arraySize; $j++) {
                $a->add(str_repeat($j, 10));
            }
            foreach ($a as $el) {
                $el += '123';
            }
        }
        var_dump(microtime(true) - $time);

        $a = array();
        for ($j = 0; $j < $arraySize; $j++) {
            $a[] = str_repeat($j, 10);
        }
        var_dump('Random access, raw PHP array:');
        $time = microtime(true);
        for ($i = 0; $i < $iterations; $i++) {
            $test = $a[rand(0, $arraySize - 1)];
        }
        var_dump(microtime(true) - $time);

        $a = new Chain();
        for ($j = 0; $j < $arraySize; $j++) {
            $a->add(str_repeat($j, 10));
        }
        var_dump('Random access, Chain:');
        $time = microtime(true);
        for ($i = 0; $i < $iterations; $i++) {
            $test = $a->get(rand(0, $arraySize - 1));
        }
        var_dump(microtime(true) - $time);
    }
}
