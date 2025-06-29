        var actor_1 ="Actor";
        var actor_2 ="Sistema";
        const actor_1_input = document.getElementById('actor_1');
        const actor_2_input = document.getElementById('actor_2');
        actor_1_input.addEventListener('input', (event) => {
            actor_1 = event.target.value || "Actor";
            updateActor();
        })
        actor_2_input.addEventListener('input', (event) => {
            actor_2 = event.target.value || "Actor";
            updateActor();
        })

        const form = document.getElementById('form');
        const saveLocalStorage = document.getElementById('saveLocalStorage');

        

        form.addEventListener('submit', (event) => {
            event.preventDefault();
            // si esta checked entonces se guarda un json del formulario con un id identificado
            // para mostrar una lista de los guardados que despues se pueden recuperar o eliminar
            let json = getJsonObject();

            console.log(json);

            if(saveLocalStorage.checked){

                // guadar en el item casosDeUso con multiple casos de uso con un identificador unico del nombre
                let casosDeUso = localStorage.getItem('casosDeUso');
                let casosDeUsoArray = [];
                if(casosDeUso != null){
                    casosDeUsoArray = JSON.parse(casosDeUso);
                    if(casosDeUsoArray.find(caso => caso.nombre  == json.caso_nombre)){
                        let index = casosDeUsoArray.findIndex(caso => caso.nombre  == json.caso_nombre);
                        casosDeUsoArray[index] = {
                            "nombre": json.caso_nombre,
                            "id": json.caso_id,
                            "json": json
                        };
                    }else{
                        casosDeUsoArray.push({
                            "nombre": json.caso_nombre,
                            "id": json.caso_id,
                            "json": json
                        });
                    }
                    
                    
                }else{
                    casosDeUsoArray.push({
                        "nombre": json.caso_nombre,
                        "id": json.caso_id,
                        "json": json
                    });
                }
                localStorage.setItem('casosDeUso', JSON.stringify(casosDeUsoArray));
                
            }

            fetch("",{
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(json)
            }).then(response => {
                if (response.ok) {
                    // muestra mensaje enviado del servidor con el response.text()
                    response.text().then(text => {
                        alert(text);
                    }).catch(error => {
                        alert('Error al crear el caso de uso');
                        console.error('Error al crear el caso de uso', error);
                    });

                } else {
                    console.error('Error al crear el caso de uso');
                }
            }).catch(error => {
                alert('Error al crear el caso de uso');
                console.error('Error al crear el caso de uso', error);
            })


        });

        

        function getJsonObject(){
            let obj = {
                "casoTitulo": document.getElementById('titulo').value.trim(),
                "caso_nombre": document.getElementById('nombre').value.trim(),
                "caso_id": document.getElementById('caso_id').value.trim(),
                "actores": document.getElementById('actores').value.trim(),
                "descripcion": document.getElementById('descripcion').value.trim(),
                "casos_rel": document.getElementById('casos_rel').value.trim(),
                "entradas": document.getElementById('entradas').value.trim(),
                "salidas": document.getElementById('salidas').value.trim(),
                "actor_1": document.getElementById('actor_1').value.trim(),
                "actor_2": document.getElementById('actor_2').value.trim(),
                "precondicion": document.getElementById('precondicion').value.trim(),
                "poscondicion": document.getElementById('poscondicion').value.trim(),
            };

            let arregloPasosTipicos = [];

            pasosTipicosRows = document.querySelectorAll("#cursoTipico>div.row");
            // si alguna fila esta vacia se saltara esa fila
            pasosTipicosRows.forEach((row) => {
                let actor_1Value = row.querySelector('input[name="pasoTipicoActor1"]').value.trim();
                let actor_2Value = row.querySelector('input[name="pasoTipicoActor2"]').value.trim();
                if(actor_1Value === "" && actor_2Value === "") return;
                let paso = {
                    "actor1": actor_1Value,
                    "actor2": actor_2Value,
                }
                arregloPasosTipicos.push(paso);
            });

            if(arregloPasosTipicos.length === 0){
                alert("No se puede crear un caso sin pasos en el curso tipico");
                return;
            }

            obj.cursoTipico = arregloPasosTipicos;

            let arregloCursosAtipicos = [];

            cursosAtipicosContainers = document.querySelectorAll("#cursoAtipico>div.cursoAtipicoContainer");
            let controlError = false;
            cursosAtipicosContainers.forEach((container) => {
                if(controlError) return;
                let cursoAtipico = getCursoAtipico(container);
                if(cursoAtipico === null){
                    controlError = true;
                    return;
                }
                arregloCursosAtipicos.push(cursoAtipico);
            });

            if(controlError) return null;

            obj.cursosAtipicos = arregloCursosAtipicos;

            

            return obj;
        }

        function getCursoAtipico(container){
            let titulo = container.querySelector('input[name="cursoAtipicoTitulo"]').value.trim();
            let filas = container.querySelectorAll(".cursoAtipicoPasosContainer>div.row");
            let pasos = [];

            filas.forEach((fila) => {
                let actor_1Value = fila.querySelector('input[name="pasoAtipicoActor1"]').value.trim();
                let actor_2Value = fila.querySelector('input[name="pasoAtipicoActor2"]').value.trim();
                if(actor_1Value === "" && actor_2Value === "") return;
                let paso = {
                    "actor1": actor_1Value,
                    "actor2": actor_2Value,
                }
                pasos.push(paso);
            });


            if(pasos.length === 0){
                let cursoAtipicoNum = container.dataset.idnum;
                alert(`No se puede crear un curso atipico sin pasos (curso Atipico ${cursoAtipicoNum})`);
                return null;
            }





            
            return {
                "head": titulo,
                "pasos": pasos
            };

        }


        document.querySelector('.add_cursoTipico').addEventListener('click', (event) => {
            AgregarPasoTipico(event.target);
        })

        document.querySelector('.remove_cursoTipico').addEventListener('click', (event) => {
            eliminarPasoTipico(event.target);
        })

        document.querySelector('.add_cursoAtipico').addEventListener('click', (event) => {
            agregarCursoAtipico();
        })

        var totalCursosAtipicos = 0;
        function agregarCursoAtipico(titulo = "", pasos = []){
            totalCursosAtipicos++;
            if(totalCursosAtipicos > 5){
                alert("No se pueden crear mas de 5 cursos atipicos");
                return;
            }

            let auxiliarHeader = function (num) {
                let row = crearElemento('div', {
                    class: 'row'
                });

                let col = crearElemento('div', {
                    class: 'col'
                });
                let p = crearElemento('p', {
                    class: 'h2',
                    textContent: `Curso Atípico #${num}`
                });
                col.appendChild(p);
                row.appendChild(col);
                return row;
            }

            let auxiliarTitulo = function (num) {
                let row = crearElemento('div', {
                    class: 'row'
                });

                let col = crearElemento('div', {
                    class: 'col'
                });

                let [label, input, div] = crearInputTextFields(`atipico${num}Title`, `Titulo #${num}`, {value: titulo, name : "cursoAtipicoTitulo"});

                col.appendChild(label);
                col.appendChild(input);
                col.appendChild(div);

                row.appendChild(col);
                return row;
            }

            
            

            let contenedor = crearElemento('div', {
                class: 'cursoAtipicoContainer',
                id: `cursoAtipicoList${totalCursosAtipicos}`,
                "data-idNum" : totalCursosAtipicos
            });
            // agrego el header
            contenedor.appendChild(auxiliarHeader(totalCursosAtipicos));
            // agrego el titulo
            contenedor.appendChild(auxiliarTitulo(totalCursosAtipicos));

            let contenedorPasos = crearElemento('div', {
                class: 'cursoAtipicoPasosContainer'
            });
            contenedor.appendChild(contenedorPasos);

            // agrego los pasos
            if(pasos.length > 0){

                pasos.forEach((paso) => {
                    agregaPasosAtipicos(contenedorPasos, totalCursosAtipicos, [paso.actor1, paso.actor2]);
                })

            }
            else{
                agregaPasosAtipicos(contenedorPasos,totalCursosAtipicos);
            }

            let container = document.querySelector('#cursoAtipico');
            container.appendChild(contenedor);

        }


        function agregaPasosAtipicos(cursoAtipicoPasosContainer,cursoAtipicoNum , values = [], rowCaller = false){
            // auxiliares inicio
            let auxiliarCrearColBtn = function (col) {
                let label = crearElemento('label', {
                    class: 'label-hide form-label',
                    textContent: 'l',
                });
                let div = crearElemento('div', {
                    class: 'd-flex',
                })
                let button1 = crearElemento('button', {
                    class: 'btn btn-primary me-1 add_paso_atipico',
                    title: 'Agregar paso',
                    type: 'button',
                    textContent: '+',
                });
                
                let button2 = crearElemento('button', {
                    class: 'btn btn-primary ms-1 remove_paso_atipico',
                    title: 'Eliminar paso',
                    type: 'button',
                    textContent: '-',
                });

                button1.onclick = (event) => {
                    let container = event.target.closest('div.cursoAtipicoPasosContainer');
                    let rowCaller = event.target.closest('div.row');
                    agregaPasosAtipicos(container, cursoAtipicoNum, [], rowCaller);
                }

                div.appendChild(button1);
                div.appendChild(button2);
                col.appendChild(label);
                col.appendChild(div);
            }



            let auxiliarPasos = function (num, values = []) {
                
                let row = crearElemento('div', {
                    class: 'row'
                });
                // actor 1
                let col1 = crearElemento('div', {
                    class: 'col'
                });
                // actor 2
                let col2 = crearElemento('div', {
                    class: 'col'
                });
                // botones
                let col3 = crearElemento('div', {
                    class: 'col-auto'
                });
                /*
                <label for="cursoAtipico1Actor1paso1" class="form-label">Actor</label>
                <input type="text" class="form-control" id="cursoAtipico1Actor1paso1" name="cursoAtipico1Actor1paso1" data-formText="form-text-cursoAtipico1Actor1paso1">
                <div id="form-text-cursoAtipico1Actor1paso1" class="form-text invalid-feedback"></div>
                */

                let numRow = document.querySelectorAll('.cursoAtipicoPasosContainer>div.row').length+1;


                let [label1, input1, div1] = crearInputTextFields(`cursoAtipico${num}Actor1Row${numRow}`, actor_1, {value: (values[0] || ''), name: "pasoAtipicoActor1"}, {class: 'form-label label-actor1'});
                let [label2, input2, div2] = crearInputTextFields(`cursoAtipico${num}Actor2Row${numRow}`, actor_2, {value: (values[1] || ''), name: "pasoAtipicoActor2"}, {class: 'form-label label-actor2'});

                col1.appendChild(label1);
                col1.appendChild(input1);
                col1.appendChild(div1);

                col2.appendChild(label2);
                col2.appendChild(input2);
                col2.appendChild(div2);

                auxiliarCrearColBtn(col3);

                row.appendChild(col1);
                row.appendChild(col2);
                row.appendChild(col3);
                return row;
            }

            
            // auxiliares fin

            let row = auxiliarPasos(cursoAtipicoNum, values);
            if(rowCaller===false){
                cursoAtipicoPasosContainer.appendChild(row);
            }
            else {
                rowCaller.parentNode.insertBefore(row, rowCaller.nextSibling);
            }


        }




        /**
         * Crea una nueva fila de campos justo despues del boton que lo llama
         * @param {HTMLElement} btnCaller
         * @param {number} [num=1] El numero de pasos a agregar
         * @param {Array} [listaPasoTipico=[]] valores a agregar
         */
        var numPasoTipico = 1;
        function AgregarPasoTipico(btnCaller, values = []){
            numPasoTipico++;
            

            let auxiliarCrearCol = function (col,num, actor, numActor=1, valor='') {

                let [label, input, div] = crearInputTextFields(`tipicoPasoActor${numActor}Row${num}`, actor, {name: "pasoTipicoActor"+numActor,value: valor}, {class: 'form-label label-actor'+numActor});

                col.appendChild(label);
                col.appendChild(input);
                col.appendChild(div);
            }

            let auxiliarCrearColBtn = function (col) {
                let label = crearElemento('label', {
                    class: 'label-hide form-label',
                    textContent: 'l',
                });
                let div = crearElemento('div', {
                    class: 'd-flex',
                })
                let button1 = crearElemento('button', {
                    class: 'btn btn-primary me-1 add_cursoTipico',
                    title: 'Agregar paso',
                    type: 'button',
                    textContent: '+',
                });
                button1.onclick = (event) => {
                    AgregarPasoTipico(event.target, 1);
                }
                let button2 = crearElemento('button', {
                    class: 'btn btn-primary ms-1 remove_cursoTipico',
                    title: 'Eliminar paso',
                    type: 'button',
                    textContent: '-',
                });
                button2.onclick = (event) => {
                    eliminarPasoTipico(event.target);
                }
                div.appendChild(button1);
                div.appendChild(button2);
                col.appendChild(label);
                col.appendChild(div);

                
            }


            let row = crearElemento('div', {
                class: 'row',
            });
            let col1 = crearElemento('div', {
                class: 'col',
            });
            
            let col2 = crearElemento('div', {
                class: 'col',
            });
            
            let col3 = crearElemento('div', {
                class: 'col-auto',
            });

            auxiliarCrearCol(col1, numPasoTipico, actor_1, 1, values[0] || '');
            
            auxiliarCrearCol(col2, numPasoTipico, actor_2, 2, values[1] || '');

            auxiliarCrearColBtn(col3);

            row.appendChild(col1);
            row.appendChild(col2);
            row.appendChild(col3);


            
            if(btnCaller != null ){
                let rowCaller = btnCaller.parentNode.parentNode.parentNode;
                rowCaller.parentNode.insertBefore(row, rowCaller.nextSibling);


            }
            else{
                document.getElementById("cursoTipico").appendChild(row);
            }

        }

        /**
         * Elimina el paso tipico de la fila que la invoca
         * si es el unico que queda no se elimina y vacia los input de la fila
         * @param {HTMLElement} btnCaller
         */
        function eliminarPasoTipico(btnCaller){
            let rows = document.getElementById("cursoTipico").children;
            if(rows.length > 1){
                btnCaller.parentNode.parentNode.parentNode.remove();
            }
            else{
                let row = btnCaller.parentNode.parentNode.parentNode;
                row.querySelectorAll('input').forEach(input => {
                    input.value = '';
                });
            }
        }

        /**
         * Crea un array con 3 elementos, el primero es el label, el segundo el input y el tercero el div con el feedback
         * @param {string} idInput id del input
         * @param {string} idLabel textual del label
         * @param {object} [inputAttrs={}] atributos del input
         * @param {object} [labelAttrs={}] atributos del label
         * @returns {Array} [label, input, div]
         */
        function crearInputTextFields(idInput, idLabel, inputAttrs = {}, labelAttrs = {}){
                let defaultInputAttrs = {
                type: 'text',
                class: 'form-control',
                id: idInput,
                'data-formText': `form-text-${idInput}`,
            }
            let activeInputAttrs = Object.assign(defaultInputAttrs, inputAttrs);

            let defaultLabelAttrs = {
                for: idInput,
                class: 'form-label',
                textContent: idLabel,
            }
            let activeLabelAttrs = Object.assign(defaultLabelAttrs, labelAttrs);


            let label = crearElemento('label', activeLabelAttrs);
            let input = crearElemento('input', activeInputAttrs);
            let div = crearElemento('div', {
                id: `form-text-${idInput}`,
                class: 'form-text invalid-feedback',
            });
            return [label, input, div];
        }

        function updateActor(){
            let labelsActor1 = document.getElementsByClassName('label-actor1');
            let labelsActor2 = document.getElementsByClassName('label-actor2');
            for (let i = 0; i < labelsActor1.length; i++) {
                labelsActor1[i].textContent = actor_1;
            }
            for (let i = 0; i < labelsActor2.length; i++) {
                labelsActor2[i].textContent = actor_2;
            }

        }

        
    /**
     * Crea un elemento HTML y lo configura con los atributos dados.
     * @param {string} elemento - El nombre del elemento HTML a crear.
     * @param {object} [atributos] - Los atributos del elemento. Si no se pasan, se crea el elemento sin atributos.
     * @returns {HTMLElement} El elemento creado.
     */
    function crearElemento(elemento, atributos) {
        let el = document.createElement(elemento);
        if(typeof(atributos) !== "object") return el;
        for (let i in atributos) {
            if(i == "textContent" && typeof(atributos[i]) == "string") el.textContent = atributos[i];
            else if(i == "innerHTML" && typeof(atributos[i]) == "string") el.innerHTML = atributos[i];
            else if(i == "content" && typeof(atributos[i]) == "HTMLElement") el.appendChild(atributos[i]);
            else el.setAttribute(i, atributos[i]);
        }
        return el;
    }