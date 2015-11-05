<?php
namespace ConnectHolland\MongoAggregations\Builder\Test;

use ConnectHolland\MongoAggregations\Builder\UnwindBuilder;
use ConnectHolland\MongoAggregations\Test\AbstractTestCase;

/**
 * Unit test for the unwind builder
 *
 * @author Ron Rademaker
 */
class UnwindBuilderTest extends AbstractTestCase
{
    /**
     * Tests if a regular unwind works
     */
    public function testRegularUnwind()
    {
        $testData = [
            ['foo' => ['foo']],
            ['foo' => ['foo', 'bar']],
            ['foo' => ['foobar']]
        ];
        $builder = new UnwindBuilder('foo');

        $this->performTest($testData, $builder);
    }

    /**
     * Tests unwinding strings
     */
    public function testStringUnwind()
    {
        $testData = [
            ['foo' => 'foo'],
            ['foo' => 'foo'],
            ['foo' => 'bar'],
            ['foo' => 'foobar']
        ];
        $builder = new UnwindBuilder('foo');

        $this->performTest($testData, $builder);
    }


    /**
     * Tests if an unwind on a mixed database works
     */
    public function testUnwindMixedDatabase()
    {
        $testData = [
            ['foo' => 'foo'],
            ['foo' => ['foo', 'bar']],
            ['foo' => ['foobar']]
        ];

        $builder = new UnwindBuilder('foo');

        $this->performTest($testData, $builder);
    }

    /**
     * Tests $testdata on $builder
     *
     * Always expect 4 results, 2 foo, 1 bar and 1 foobar
     */
    private function performTest($testData, $builder)
    {
        foreach ($testData as $test) {
            $this->collection->save($test);
        }

        $pipeline = $builder->build();

        $result = $this->collection->aggregate($pipeline);

        $foos = 0;
        $bars = 0;
        $foobars = 0;

        $this->assertEquals(4, count($result['result']));

        foreach ($result['result'] as $res) {
            switch ($res['foo']) {
                case 'foo':
                    $foos++;
                    break;
                case 'foobar':
                    $foobars++;
                    break;
                case 'bar':
                    $bars++;
                    break;
            }
        }

        $this->assertEquals(2, $foos);
        $this->assertEquals(1, $bars);
        $this->assertEquals(1, $foobars);
    }
}
