<?php require_once('excelreader.php');
$data = new Spreadsheet_Excel_Reader("test.xls");
$data->dump($row_numbers=false,$col_letters=false,$sheet=0,$table_class='excel');
echo $data;




?>