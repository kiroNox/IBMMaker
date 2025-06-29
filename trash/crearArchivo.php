<?php

use PhpOffice\PhpWord\Shared\Converter;
use PhpOffice\PhpWord\Style\TablePosition;
use PhpOffice\PhpWord\Settings;
require_once("vendor/autoload.php");



// Creating the new document...
$phpWord = new \PhpOffice\PhpWord\PhpWord();

// Adding a new section to the document...
$section = $phpWord->addSection([
    "marginLeft" => Converter::cmToTwip(2),
    "marginRight" => Converter::cmToTwip(2),
]);

// Adding a header...
$header = ['bold' => true, 'size' => 16, 'name' => 'Arial'];

/*
 *  4. colspan (gridSpan) and rowspan (vMerge)
 *  ---------------------
 *  |     |   B    |  1 |
 *  |  A  |        |----|
 *  |     |        |  2 |
 *  |     |---|----|----|
 *  |     | C |  D |  3 |
 *  ---------------------
 * @see https://github.com/PHPOffice/PHPWord/issues/806
 */


$section->addText('IMB caso de uso tabla', $header);

$anchoTablaCm = 17.26;
$anchoTabla = Converter::cmToTwip($anchoTablaCm);

$styleTable = [
    'borderSize' => 6, 
    'borderColor' => '000000', 
    'width' => $anchoTabla,
    'cellMargin' => 0
];
$phpWord->addTableStyle('Colspan Rowspan', $styleTable);
$table = $section->addTable('Colspan Rowspan');
$headerFontStyle = ['bold' => true, 'color' => 'FFFFFF', 'size' => 12, 'name' => 'Arial'];
$headerCellStyle = ["bgColor" => "003366"];
$headerCellStyleBottom = ["bgColor" => "003366", "valign" => "bottom"];

function celdaHeader(&$row, $text = "N/A",$width, $cellStyle = [], $textStyle = []) {
    $parrafoStyle = [];
    if(isset($textStyle['align'])) {
        $parrafoStyle["align"] = $textStyle['align'];  
        unset($textStyle['align']);
    }
    $cellStyle = array_merge(["bgColor" => "003366"], $cellStyle);
    $textStyle = array_merge(['bold' => true, 'size' => 12,'color' => 'FFFFFF', 'name' => 'Arial'], $textStyle);
    $row->addCell(Converter::cmToTwip($width), $cellStyle)->addText($text, $textStyle);
}
function celda (&$row, $text = "N/A",$width, $cellStyle = [], $textStyle = []) {
    // pondremos el estilo por defecto de las celdas y el texto de la celda
    $parrafoStyle = [];
    if(isset($textStyle['align'])) {
        $parrafoStyle["align"] = $textStyle['align'];  
        unset($textStyle['align']);
    }
    $cellStyle = array_merge(["bgColor" => "FFFFFF"], $cellStyle);
    $textStyle = array_merge(['size' => 12, 'name' => 'Times New Roman'], $textStyle);
    
    $row->addCell(Converter::cmToTwip($width), $cellStyle)->addText($text, $textStyle,$parrafoStyle);
}




$row = $table->addRow();

$Caso_de_uso = [
    "nombre" => "Solicitar Producto",
    "id" => "1",
    "actor" => "Director",
    "descripcion" => "Gestionar la solicitud y aprobación de la compra de productos requeridos por un departamento.",
    "casosRelacionados" => "1, 2, 3",
    "entradas" => "palabra clave",
    "salidas" => "",
];

$cols = [
    4.86, // 1
    3.96, // 2
    1.94, // 3
    1.45, // 4
    0.64, // 5
    4.74 // 6
];

celda($row, "1", $cols[0]);
celda($row, "2", $cols[1]);
celda($row, "3", $cols[2]);
celda($row, "4", $cols[3]);
celda($row, "5", $cols[4]);
celda($row, "6", $cols[5]);





$row = $table->addRow( Converter::cmToTwip(0.98));

celdaHeader($row, "Nombre de caso:", $cols[0], ["valign" => "bottom"] );
celda($row, $Caso_de_uso["nombre"], $cols[1], ["valign" => "top"]);
$width = $cols[2] + $cols[3];
celdaHeader($row, "Id Caso de Uso:", $width, ["gridSpan" => 2, "valign" => "center"], ["align" => "center"]);
$width = $cols[4] + $cols[5];
celda($row, $Caso_de_uso["id"], $width,["gridSpan" => 2,"valign" => "center"], ["align" => "center"]);

unset($resto);

$row = $table->addRow();
celdaHeader($row, "Actor:", $cols[0]);
$width = $cols[1] + $cols[2] + $cols[3] + $cols[4] + $cols[5];
celda($row, $Caso_de_uso["actor"], $width, ["gridSpan" => 5]);

$row = $table->addRow(Converter::cmToTwip(3));
celdaHeader($row, "Descripción:", $cols[0], ["valign" => "top"]);
celda($row, $Caso_de_uso["descripcion"], $width,[ "gridSpan" => 5], ["align" => "top"]);

$row = $table->addRow();
celdaHeader($row, "Casos de Uso Relacionados:", $cols[0]);
celda($row, $Caso_de_uso["casosRelacionados"], $width, ["gridSpan" => 5]);
unset($resto);



$row = $table->addRow();



celdaHeader($row, "Entradas:", $cols[0], ["gridSpan" => 1]);
$width = $cols[1] + $cols[2];
celda($row, $Caso_de_uso["entradas"], $width, ["gridSpan" => 2]);
$width = $cols[3] + $cols[4];
celdaHeader($row, "Salidas:", $width, ["gridSpan" => 2]);
$width = $cols[5];
celda($row, $Caso_de_uso["salidas"], $width);

unset($resto);






$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'HTML');
$objWriter->save('view/index.html');

Settings::setZipClass(Settings::PCLZIP);
// // Saving the document as OOXML file...
$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
$objWriter->save('helloWorld.docx');
echo "archivo generado";