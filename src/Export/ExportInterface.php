<?php
namespace ConnectHolland\MongoAggregations\Export;

/**
 * Interface defining how to export aggregation results
 *
 * @author Ron Rademaker
 */
interface ExportInterface
{
    /**
     * Save $result to $file
     *
     * @param array $result
     * @param string $file
     */
    public function exportToFile(array $result, $file);
}
