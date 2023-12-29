<?php

namespace RNEClient;

use PhpOffice\PhpSpreadsheet\IOFactory;

/**
 * Class CategoryCodes
 *
 * @package RNEClient
 */
class CategoryCodes
{
    /**
     * Process the category codes xlsx file to associative array
     *
     * @return array
     */
    public function processXlsxDataToJson(): array
    {
        // Path to the file to read (data/INPI  RNE  Table des categories activites.xlsx)
        $inputFileName = __DIR__ . '/../data/INPI  RNE  Table des categories activites.xlsx';

        /** Load $inputFileName to a Spreadsheet Object  **/
        $spreadsheet = IOFactory::load($inputFileName);

        $data = [];

        // Extract data from the spreadsheet from second row to the end
        // second row is the header (keys)
        $firstColumnLetter = 'A';
        $firstRowNumber = 2;

        $lastColumnLetter = $spreadsheet->getActiveSheet()->getHighestColumn($firstRowNumber);
        $lastRowNumber = $spreadsheet->getActiveSheet()->getHighestRow();

        $keys = $spreadsheet->getActiveSheet()->rangeToArray(
            "{$firstColumnLetter}{$firstRowNumber}:{$lastColumnLetter}{$firstRowNumber}",
            null,
            true,
            true,
            true
        )[2];
        // clean the keys by removing description in parenthesis
        foreach ($keys as $key => $value) {
            $keys[$key] = preg_replace('/\s\(.*\)/', '', $value);
        }

        $firstValueRowNumber = $firstRowNumber + 1;

        $values = $spreadsheet->getActiveSheet()->rangeToArray(
            "{$firstColumnLetter}{$firstValueRowNumber}:{$lastColumnLetter}{$lastRowNumber}",
            null,
            true,
            false,
            true
        );

        foreach ($values as $row) {
            $data[] = array_combine($keys, $row);
        }

        return $data;
    }

    public function saveJsonData(array $data): void
    {
        $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        file_put_contents(__DIR__ . '/../data/categoryCodes.json', $json);

        echo 'Data saved to data/categoryCodes.json' . PHP_EOL;
    }

    public static function getCategoryCodes(): array
    {
        $json = file_get_contents(__DIR__ . '/../data/categoryCodes.json');
        $data = json_decode($json, true);
        // return array of category codes (last column)
        return array_column($data, 'Code final');
    }
}
