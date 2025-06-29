<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="./public/lib/bootstrap/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="./public/lib/bootstrap/css/bootstrap.min.css">
    <script src="./public/lib/jquery-3.7.1.min.js" ></script>
    <title>IBM Maker</title>
    <style>
        .respuesta:not(:empty){
            font-size: 20px;
            text-align: center;
            border: 1px solid black;
            padding: 10px;
            max-width: 900px;
            margin: 10px auto;
        }
        .card{
            --bs-card-bg:rgb(233, 245, 255);
        }
        .label-hide{
            opacity: 0;
            pointer-events: none;
        }
        .cursoAtipicoContainer{
            border: 1px solid black;
            border-radius: 3px;
            margin: 0 -10px;
            padding: 0 10px;
            margin-bottom: 10px;
            padding-bottom: 10px;
        }
    </style>
</head>
<body>

    <h1>IBM Maker</h1>

    <div class="respuesta"><?= $resp ?></div>
    
    
    <form action="" method="post" id="form">
        <div class="container" style="max-width: 800px;">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Caso de uso</h5>
                </div>
                <div class="card-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-4">
                                <label for="titulo" class="form-label">Titulo</label>
                                <input type="text" class="form-control" id="titulo" name="casoTitulo" data-formText="form-text-titulo">
                                <div id="form-text-titulo" class="form-text invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="row">
            
                    
                            <div class="col-9">
                                <label for="nombre" class="form-label">Nombre del caso de uso</label>
                                <input required type="text" class="form-control" id="nombre" name="caso_nombre" data-formText="form-text-nombre">
                                <div id="form-text-nombre" class="form-text invalid-feedback"></div>
                            </div>
                            <div class="col-3">
                                <label for="caso_id" class="form-label">ID del caso</label>
                                <input type="text" class="form-control" id="caso_id" name="caso_id" data-formText="form-text-caso_id">
                                <div id="form-text-caso_id" class="form-text invalid-feedback"></div>
                            </div>
                            <div class="col-12">
                                <label for="actores" class="form-label">Actores</label>
                                <input type="text" class="form-control" id="actores" name="actores" data-formText="form-text-actores">
                                <div id="form-text-actores" class="form-text invalid-feedback"></div>
                            </div>
                            <div class="col-12">
                                <label for="descripcion" class="form-label">Descripción</label>
                                <textarea name="descripcion" id="descripcion" class="form-control" row="3"  data-formText="form-text-descripcion"></textarea>
                                <div id="form-text-descripcion" class="form-text invalid-feedback"></div>
                            </div>
                            <div class="col-12">
                                <label for="casos_rel" class="form-label">Casos relacionados</label>
                                <input type="text" class="form-control" id="casos_rel" name="casos_rel" data-formText="form-text-casos_rel">
                                <div id="form-text-casos_rel" class="form-text invalid-feedback"></div>
                            </div>
                            <div class="col-6">
                                <label for="entradas" class="form-label">Entradas</label>
                                <input type="text" class="form-control" id="entradas" name="entradas" data-formText="form-text-entradas">
                                <div id="form-text-entradas" class="form-text invalid-feedback"></div>
                            </div>
                            <div class="col-6">
                                <label for="salidas" class="form-label">Salidas</label>
                                <input type="text" class="form-control" id="salidas" name="salidas" data-formText="form-text-salidas">
                                <div id="form-text-salidas" class="form-text invalid-feedback"></div>
                            </div>
                            <div class="col-6">
                                <label for="actor_1" class="form-label">Actor 1</label>
                                <input value="Actor" type="text" class="form-control" id="actor_1" name="actor_1" data-formText="form-text-actor_1">
                                <div id="form-text-actor_1" class="form-text invalid-feedback"></div>
                            </div>
                            <div class="col-6">
                                <label for="actor_2" class="form-label">Actor 2</label>
                                <input value="Sistema" type="text" class="form-control" id="actor_2" name="actor_2" data-formText="form-text-actor_2">
                                <div id="form-text-actor_2" class="form-text invalid-feedback"></div>
                            </div>
                            <div class="col-12">
                                <label for="precondicion" class="form-label">Precondición</label>
                                <input type="text" class="form-control" id="precondicion" name="precondicion" data-formText="form-text-precondicion">
                                <div id="form-text-precondicion" class="form-text invalid-feedback"></div>
                            </div>
                            <div class="col-12">
                                <label for="poscondicion" class="form-label">Pos-condición</label>
                                <input type="text" class="form-control" id="poscondicion" name="poscondicion" data-formText="form-text-poscondicion">
                                <div id="form-text-poscondicion" class="form-text invalid-feedback"></div>
                            </div>
                            
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <p class="h2">Curso Típico</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div id="cursoTipico">
                                    <div class="row">
                                        <div class="col">
        
                                            <label for="tipicoPasoActor1Row1" class="form-label label-actor1">Actor</label>
                                            <input type="text" class="form-control" id="tipicoPasoActor1Row1" name="pasoTipicoActor1" data-formText="form-text-tipicoPasoActor1Row1">
                                            <div id="form-text-tipicoPasoActor1Row1" class="form-text invalid-feedback"></div>
                                            
                                        </div>
                                        <div class="col">
                                            <label for="tipicoPasoActor2Row1" class="form-label label-actor2">Sistema</label>
                                            <input type="text" class="form-control" id="tipicoPasoActor2Row1" name="pasoTipicoActor2" data-formText="form-text-tipicoPasoActor2Row1">
                                            <div id="form-text-tipicoPasoActor2Row1" class="form-text invalid-feedback"></div>
                                        </div>
                                        <div class="col-auto">
                                            <div>
                                                <label class="label-hide form-label">l</label>
                                            </div>
                                            <div class="d-flex">
                                                <button type="button" class="btn btn-primary me-1 add_cursoTipico" title="Agregar paso">+</button>
                                                <button type="button" class="btn btn-primary ms-1 remove_cursoTipico" title="Eliminar paso">-</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <hr>
                            </div>
                        </div>
                        <div class="row justify-content-between">
                            <div class="col-auto">
                                <p class="h2">Cursos Atípicos</p>
                            </div>
                            <div class="col-auto">
                                <div class="d-flex">
                                    <button type="button" class="btn btn-primary me-1 add_cursoAtipico" title="Agregar Curso Atipico">+</button>
                                    <button type="button" class="btn btn-primary ms-1 remove_cursoAtipico" title="Eliminar Curso Atipico">-</button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <hr>
                            </div>
                        </div>
                        <!-- cursos atipicos -->
                         <div class="row">
                            <div class="col-12">
                                <div id="cursoAtipico">
                                </div>
                            </div>
                         </div>

                    </div>
                    <div>
                        <label for="saveLocalStorage">Guardar en local storage?</label>
                        <input type="checkbox" id="saveLocalStorage" checked>
                    </div>
                    <div class="contaner text-center">
                        <button type="submit" class="btn btn-primary">Crear</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div id="listaStorage" class="container" style="max-width: 800px;">
        <div>
            <p class="h2">lista de casos en local storage</p>
        </div>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>id</th>
                    <th>Nombre</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="tbodyStorage">

            </tbody>
        </table>
    </div>

    <div class="container pb-5 mb-4" style="max-width: 800px;">
        <div>
            <p class="h2">Lector Json</p>
        </div>
        <div>
<textarea name="json" id="json" class="form-control" rows="40">
{
    "casoTitulo": "string",
    "caso_nombre": "string",
    "caso_id": "string",
    "actores": "string, string (separados por coma si hay más de uno)",
    "descripcion": "string",
    "casos_rel": "string (o N/A si no aplica)",
    "entradas": "string (separados por coma si hay más de uno)",
    "salidas": "string (o N/A si no aplica)",
    "actor_1": "string (nombre del primer actor)",
    "actor_2": "string (nombre del segundo actor)",
    "precondicion": "string",
    "poscondicion": "string",
    "cursoTipico": [
        {
            "actor1": "string (acción del actor 1, dejar vacío si el actor 2 es el que actúa)",
            "actor2": "string (acción del actor 2, dejar vacío si el actor 1 es el que actúa)"
        }
        // ... más pasos
    ],
    "cursosAtipicos": [
        // si no aplica solo un arreglo vacio
        {
            "head": "string (descripción del escenario atípico o similar a un titulo)",
            "pasos": [
                {
                    "actor1": "string (acción del actor 1, dejar vacío si el actor 2 es el que actúa)",
                    "actor2": "string (acción del actor 2, dejar vacío si el actor 1 es el que actúa)"
                }
                // ... más pasos atípicos
            ]
        }
        // ... más escenarios atípicos
    ]
}
</textarea>
        </div>
        <div class="contaner text-center">
            <button type="button" class="btn btn-primary" id="loadJson">Cargar</button>
        </div>
    </div>

    <script>
        function CargarJson() {
            let json = document.getElementById('json').value;
            try {
                let caso = JSON.parse(json);
                verCaso(caso);
            } catch (error) {
                console.log(error);
                alert('El json no es valido');
                
            }
        }

        document.getElementById('loadJson').addEventListener('click', CargarJson);
    </script>


    <script src="./public/js/ibmMaker.js"></script>

    <script>
        /**
        * @typedef {{
        *   actor_1: string,
        *   actor_2: string,
        *   actores: string,
        *   casoTitulo: string,
        *   caso_id: string,
        *   caso_nombre: string,
        *   descripcion: string,
        *   entradas: string,
        *   salidas: string,
        *   casos_rel: string,
        *   precondicion: string,
        *   poscondicion: string,
        *   cursoTipico: array,
        *   cursosAtipicos: array
        * }} casoJson
        * 
        */
        loadFromStorage();
        function loadFromStorage (){
            let casosDeUso = localStorage.getItem('casosDeUso');
            if(casosDeUso != null){
                let casosDeUsoArray = JSON.parse(casosDeUso);
                
                /**
                 * @typedef {Object} CasoDeUso
                 * @property {string} id
                 * @property {string} nombre
                 * @property {casoJson} json
                 */

                 
                 
                casosDeUsoArray.forEach(/** @param {CasoDeUso} caso */ caso => {
                    
                    
                    let tr = document.createElement('tr');
                    let tdNombre = document.createElement('td');
                    let tdId = document.createElement('td');
                    let tdAcciones = document.createElement('td');
                    tdNombre.textContent = caso.nombre;
                    tdId.textContent = caso.id;
                    
                    let buttonVer = crearElemento('button', {
                        "type": "button",
                        "class": "btn btn-primary",
                        "textContent": "Ver",
                    });

                    buttonVer.onclick = (event) => {
                        verCaso(caso.json);
                    }

                    let buttonBorrar = crearElemento('button', {
                        "type": "button",
                        "class": "btn btn-danger ms-2",
                        "textContent": "Borrar",
                        "onclick": `borrarCaso('${caso.nombre}')`
                    })

                    tdAcciones.appendChild(buttonVer);
                    tdAcciones.appendChild(buttonBorrar);



                    tr.appendChild(tdId);
                    tr.appendChild(tdNombre);
                    tr.appendChild(tdAcciones);
                    tbodyStorage.appendChild(tr);
                });

            }
        }

        /**
         * 
         * @param {casoJson} json
         */
        function verCaso(json){
            document.getElementById("titulo").value = json.casoTitulo;
            document.getElementById("nombre").value = json.caso_nombre;
            document.getElementById("caso_id").value = json.caso_id;
            document.getElementById("descripcion").value = json.descripcion;
            document.getElementById("actores").value = json.actores;
            document.getElementById("entradas").value = json.entradas;
            document.getElementById("salidas").value = json.salidas;
            document.getElementById("precondicion").value = json.precondicion;
            document.getElementById("poscondicion").value = json.poscondicion;
            document.getElementById("actor_1").value = json.actor_1;
            document.getElementById("actor_2").value = json.actor_2;
            document.getElementById("casos_rel").value = json.casos_rel;

            document.getElementById("actor_1").dispatchEvent(new Event('input'));
            document.getElementById("actor_2").dispatchEvent(new Event('input'));

            let cursoTipico = document.getElementById("cursoTipico");
            cursoTipico.innerHTML = '';

            json.cursoTipico.forEach((paso) => {
                AgregarPasoTipico(null,[paso.actor1,paso.actor2]);
            })

            /**
             * @typedef {{
             * head:string,
             * pasos: [{actor1:string,actor2:string}]
             }} CursoAtipico
             
             */

            json.cursosAtipicos.forEach(/** @param {CursoAtipico} curso */(curso) => {
                agregarCursoAtipico(curso.head,curso.pasos);
            })

            //AgregarPasoTipico(null,[json.])



        }
        function borrarCaso(caso){

            let casosDeUso = localStorage.getItem('casosDeUso');

            if(casosDeUso != null){
                let casosDeUsoArray = JSON.parse(casosDeUso);
                casosDeUsoArray = casosDeUsoArray.filter(casoDeUso => casoDeUso.nombre != caso);
                localStorage.setItem('casosDeUso',JSON.stringify(casosDeUsoArray));
                location.reload();
            }
            
            

            
        }

        


    </script>
    
</body>
</html>