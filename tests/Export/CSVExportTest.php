<?php

namespace ConnectHolland\MongoAggregations\Export\Test;

use ConnectHolland\MongoAggregations\Export\CSVExport;
use MongoId;
use PHPUnit_Framework_TestCase;

/**
 * Unit test for the CSV export.
 *
 * @author Ron Rademaker
 */
class CSVExportTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test the export.
     */
    public function testExport()
    {
        $exporter = new CSVExport();

        $exporter->exportToFile(
            ['result' => [
                    ['_id' => new MongoId(), 'foo' => 'foo', 'bar' => true, 'foobar' => 5],
                    ['_id' => new MongoId(), 'foo' => 'foobar', 'bar' => false, 'foobar' => 15],
                    ['_id' => new MongoId(), 'foo' => 'bar', 'bar' => true, 'foobar' => 0],
                    ['_id' => new MongoId(), 'foo' => 'baz', 'bar' => false, 'foobar' => -1],
                ],
            ],
            'export-test'
        );

        $result = file_get_contents('export-test');

        $this->assertEquals(
            "foo,1,5\nfoobar,,15\nbar,1,0\nbaz,,-1\n",
            $result
        );

        unlink('export-test');
    }
}
