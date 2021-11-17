<?php
namespace App\Helpers;

use Exception;
use Iterator;
use League\Csv\Reader;

class CSV
{
    /**
     * @const string STORAGE_PATH
     */
    const STORAGE_PATH = __DIR__ . '../../../data/storage/';
    const DEFAULT_FILENAME = 'employeeList.csv';

    /**
     * @param string $csvFilename
     * @return Iterator
     * @throws Exception
     */
    public static function getRecords(string $csvFilename): Iterator
    {
        $args = [self::STORAGE_PATH . $csvFilename, 'r'];
        $resource = @fopen(...$args);
        if (!is_resource($resource)) {
            throw new Exception('This file does not exists.', 404);
        }
        //load the CSV document from a file path
        $csv = Reader::createFromPath( self::STORAGE_PATH . $csvFilename, 'r');
        $csv->setHeaderOffset(0);
        if ($csv->count() === 0) {
            throw new Exception('CSV file is empty.', 404);
        }
        return $csv->getRecords();
    }
}