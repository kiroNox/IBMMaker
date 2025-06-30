<?php 

 class Ibm{
    private $casoTitulo;
    private $caso_nombre;
    private $caso_id;
    private $actores;
    private $descripcion;
    private $casos_rel;
    private $entradas;
    private $salidas;
    private $actor_1;
    private $actor_2;
    private array $cursoTipico;
    private array $cursosAtipicos;
    private $precondicion;
    private $poscondicion;

 	public function __construct(
        $casoTitulo = null,
        $caso_nombre = null,
        $caso_id = null,
        $actores = null,
        $descripcion = null,
        $casos_rel = null,
        $entradas = null,
        $salidas = null,
        $actor_1 = null,
        $actor_2 = null,
        $precondicion = null,
        $poscondicion = null

    ){

        $this->casoTitulo = $casoTitulo;
        $this->caso_nombre = $caso_nombre;
        $this->caso_id = $caso_id;
        $this->actores = $actores;
        $this->descripcion = $descripcion;
        $this->casos_rel = $casos_rel;
        $this->entradas = $entradas;
        $this->salidas = $salidas;
        $this->actor_1 = $actor_1;
        $this->actor_2 = $actor_2;
        $this->precondicion = $precondicion;
        $this->poscondicion = $poscondicion;
 		
 	}

    public function setCursoTipico($tipico){
        $this->cursoTipico = $tipico;
    }
    public function setCursosAtipico($atipico){
        $this->cursosAtipicos = $atipico;
    }

    public function __get($name){
        if(isset($this->$name)){
            // si la propiedad es un string y es igual a "N/A" vaciarla
            if(is_string($this->$name) && preg_match("/^(?:\s)*N\/A(?:\s)*$/i", $this->$name)){
                $this->$name = "";
            }
        
            return $this->$name;
        }
        else{
            throw new Exception('Propiedad ('.$name.') no encontrada');
        }
    }
 }


 /*
    propmt para ia que genere el casos de uso






  */

 ?>