<?php

class Producto {
    protected $codigo;
    protected $nombre;
    protected $nombre_corto;
    protected $PVP;
    protected $descripcion;
    protected $familia;
    
    public function getCode() {return $this->codigo; }
    public function getName() {return $this->nombre; }
    public function getShortName() {return $this->nombre_corto; }
    public function getPVP() {return $this->PVP; }
    public function getDescription() {return $this->descripcion; }
    public function getFamily() {return $this->familia; }
    
    public function __construct($row) {
        $this->codigo = $row['cod'];
        $this->nombre = $row['nombre'];
        $this->nombre_corto = $row['nombre_corto'];
        $this->PVP = $row['PVP'];
        $this->descripcion = $row['descripcion'];
        $this->familia = $row['familia'];
    }
}

?>
