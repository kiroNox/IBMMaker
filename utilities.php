<?php

function cargarPost(): void
{
    $__TEMP_POST = json_decode(file_get_contents("php://input"), true);
    // si la encuentra la pone en $_POST
    if (is_array($__TEMP_POST)) {
        $_POST = $__TEMP_POST;
    }
}


function debug(mixed $var, bool $endProgram = true): void
{
    echo "<pre>";
    print_r($var);
    echo "</pre>";
    if ($endProgram)
        exit;
}


function borrarCursosAtipicos($cursosAtipicos, &$templateProcessorFunc, $maxCursosAtipicos = 5)
{

    $numCursosAtipicos = count($cursosAtipicos);
    if ($numCursosAtipicos > $maxCursosAtipicos) {
        throw new Exception("No se pueden crear mas de $maxCursosAtipicos cursos atipicos");
    }
    // maxCursosAtipicos = 5
    for ($i = $maxCursosAtipicos; $i > $numCursosAtipicos; $i--) {
        if ($i < 1)
            break;
        $templateProcessorFunc->deleteRow('paso_atipico' . $i);
        $templateProcessorFunc->deleteRow('actorAtipico' . $i);
        $templateProcessorFunc->deleteRow("atipico" . $i . "_head");
    }

}

function crearCursosAtipicos($cursosAtipicos, &$templateProcessorFunc, $maxCursosAtipicos = 5)
{
    $steps = 1;
    foreach ($cursosAtipicos as $cursoAtipico) {



        $totalPasos = count($cursoAtipico['pasos']);

        $templateProcessorFunc->cloneRow("paso_atipico$steps", $totalPasos);
        $numSteps = 1;
        for ($a = 1; $a <= $totalPasos; $a++) {
            $izq= $cursoAtipico['pasos'][$a - 1]['actor1'];
            $der = $cursoAtipico['pasos'][$a - 1]['actor2'];
            if($izq != "") $izq = ($numSteps++).". $izq";
            if($der != "") $der = ($numSteps++).". $der";
            $templateProcessorFunc->setValue("paso_atipico$steps#$a", $izq);
            $templateProcessorFunc->setValue("paso2_atipico$steps#$a", $der);
            // $templateProcessorFunc->setValue("paso_atipico$steps#$a", $cursoAtipico['pasos'][$a - 1]['actor1']);
            // $templateProcessorFunc->setValue("paso2_atipico$steps#$a", $cursoAtipico['pasos'][$a - 1]['actor2']);
        }
        $templateProcessorFunc->setValue("atipico" . $steps . "_head", $cursoAtipico['head']);
        $templateProcessorFunc->setValue("actorAtipico$steps", "");
        $steps++;
    }
}


function crearCursosTipicos($cursoTipico, &$templateProcessorFunc)
{


    $totalPasos = count($cursoTipico);

    $templateProcessorFunc->cloneRow("paso_tipico", $totalPasos);
    $steps = 1;
    for ($a = 1; $a <= $totalPasos; $a++) {

        $izq= $cursoTipico[$a - 1]['actor1'];
        $der = $cursoTipico[$a - 1]['actor2'];
        if($izq != "") $izq = ($steps++).". $izq";
        if($der != "") $der = ($steps++).". $der";
        $templateProcessorFunc->setValue("paso_tipico#$a", $izq);
        $templateProcessorFunc->setValue("paso2_tipico#$a", $der);
    }

}



?>