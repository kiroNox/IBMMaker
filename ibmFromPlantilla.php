<?php
require_once 'vendor/autoload.php';
cargarPost();
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Shared\Converter;
use PhpOffice\PhpWord\Settings;
use PhpOffice\PhpWord\TemplateProcessor;
$resp = "";

if(!empty($_POST)){
    
    
    
    

    $ibmObject = new Ibm(
        $_POST['casoTitulo'],
        $_POST['caso_nombre'],
        $_POST['caso_id'],
        $_POST['actores'],
        $_POST['descripcion'],
        $_POST['casos_rel'],
        $_POST['entradas'],
        $_POST['salidas'],
        $_POST['actor_1'],
        $_POST['actor_2'],
        $_POST['precondicion'],
        $_POST['poscondicion']
    );


    $ibmObject->setCursoTipico($_POST['cursoTipico'] ?? []);
    $ibmObject->setCursosAtipico($_POST['cursosAtipicos'] ?? []);

    $nombreArchivo = "IBM - ".$_POST['caso_nombre'].'.docx';
    
    

    
    try {

        if($ibmObject->caso_nombre == ""){
            throw new Exception('Nombre de caso no puede estar vacio es utilizado para el nombre del archivo', 1001);
        }
    
        $phpWord = new PhpWord();
        $plantillaDir = __DIR__.'/plantilla';
        $plantillaDir = realpath($plantillaDir);
        $plantillaDir = $plantillaDir.'\IMB - Plantilla.docx';
        if(!file_exists($plantillaDir)){
            throw new Exception('Plantilla no encontrada');
        }
        $templateProcessor = new TemplateProcessor($plantillaDir);

        $templateProcessor->setValues([
            "casoTitulo" => $ibmObject->casoTitulo,
            "caso_nombre" => $ibmObject->caso_nombre,
            "caso_id" => $ibmObject->caso_id,
            "actores" => $ibmObject->actores,
            "descripcion" => $ibmObject->descripcion,
            "casos_rel" => $ibmObject->casos_rel,
            "entradas" => $ibmObject->entradas,
            "salidas" => $ibmObject->salidas,
            "actor_1" => $ibmObject->actor_1,
            "actor_2" => $ibmObject->actor_2,
            "precondicion" => $ibmObject->precondicion,
            "poscondicion" => $ibmObject->poscondicion
        ]);

        

        

        // borramos las filas de los cursos atipicos que no se necesiten
        // solo hay un maximo de 5 cursos atipicos
        
        $cursosAtipicos = $ibmObject->cursosAtipicos;
        $maxCursosAtipicos = 5;
        borrarCursosAtipicos($cursosAtipicos,$templateProcessor, $maxCursosAtipicos);

       

       

        /*
        solo hay dos actores
        $cursoAtipico = [
                [ 
                    "head" => "Paso atipico 1",
                    "pasos" => [
                        ["actor1" = "paso numero 1", "actor2" = "paso numero 2"],
                        ["actor1" = "paso numero 3", "actor2" = "paso numero 4"]
                    ]
                ]
            ]
        */ 

        $cursosAtipicos = $ibmObject->cursosAtipicos;
        crearCursosAtipicos($cursosAtipicos,$templateProcessor);







        /* el curso tipico siempre debe estar y debe tener al menos un paso

            $cursoTipico = [
                ["actor1" = "paso numero 1", "actor2" = "paso numero 2"],
                ["actor1" = "paso numero 3", "actor2" = "paso numero 4"]
            ]

        */

        

        

        $cursoTipico = $ibmObject->cursoTipico;
        crearCursosTipicos($cursoTipico,$templateProcessor);


        
        

        


        

        if(file_exists("./resultados/".$nombreArchivo)){
            if(!@unlink("./resultados/".$nombreArchivo)){
                throw new Exception("El archivo $nombreArchivo no pudo ser remplazado probablemente este siendo utilizado por otro proceso", 1001);
            }
        }
        
        $templateProcessor->saveAs("./resultados/".$nombreArchivo);
        $resp = "Documento creado con exito (archivo: $nombreArchivo)";
    } catch (throwable $e) {
        $resp = $e->getMessage()." Linea: ".$e->getLine();
        $resp .= "<pre>".print_r($e->getTraceAsString(), true)."</pre>";

        if($e->getCode() == 1001){
            $resp = $e->getMessage();
        }
    }
    echo $resp;
    die;
}

require_once 'view/ibmMaker.php';
?>