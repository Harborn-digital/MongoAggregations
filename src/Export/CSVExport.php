<?php
namespace ConnectHolland\MongoAggregations\Export;

use League\Csv\Writer;
use SplTempFileObject;

/**
 * Exporter to CSV
 *
 * @author Ron Rademaker
 */
class CSVExport implements ExportInterface
{
    /**
     * Exports $result to $file
     */
    public function exportToFile(array $result, $file)
    {
        $writer = Writer::createFromFileObject(new SplTempFileObject());
        foreach ($result['result'] as $row) {
            unset($row['_id']);
            $writer->insertOne($row);
        }

        file_put_contents($file, $writer->__toString());
    }
}
