<?php 
// crear documento de word con plantilla
require_once 'vendor/autoload.php';

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Shared\Converter;
use PhpOffice\PhpWord\Settings;
use PhpOffice\PhpWord\TemplateProcessor;

try {
    
    $phpWord = new PhpWord();
    $plantillaDir = __DIR__.'/plantilla';
    $plantillaDir = realpath($plantillaDir);
    $plantillaDir = $plantillaDir.'\IMB - Plantilla.docx';
    if(!file_exists($plantillaDir)){
        throw new Exception('Plantilla no encontrada');
    }
    $templateProcessor = new TemplateProcessor($plantillaDir);
    
    $templateProcessor->setValues([
        "casoTitulo" => "xavier"
    ]);

    $templateProcessor->cloneRow("paso_tipico_1", 2);
    $templateProcessor->setValue("paso_tipico_1#1", "xavier");
    $templateProcessor->setValue("paso_tipico_1#2", "luis");

    $templateProcessor->saveAs('document.docx');
    echo "Documento creado con exito";
} catch (Exception $e) {
    echo $e;
}
?>