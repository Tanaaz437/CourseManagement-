<?php
require '../vendor/autoload.php'; // Go up one directory to access the vendor folder // This should point to your vendor/autoload.php file

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', 'Hello World!');

$writer = new Xlsx($spreadsheet);
$writer->save('hello_world.xlsx');
