<?php

class Revista{

  public $titulo;
  public $contenido;
  public $foto;
  public $url;
  public $categoria;
  public $dirigido;

  public function __construct($args = []) {
    $this->titulo = $args['titulo'];
    $this->contenido = $args['contenido'];
    $this->categoria = $args['nombre'];
    $this->foto = "https://".$_SERVER['HTTP_HOST']."/".$args['foto'];
    $this->url = $args['url'];
    $this->dirigido = $args['dirigido'];
  }

}

?>
