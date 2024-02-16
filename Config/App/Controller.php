<?php
class Controller
{
    protected $views, $model;
    public function __construct()
    {
        $this->views = new Views();
        $this->loadModel();
    }

    public function loadModel()
    {
        $model = get_class($this) . "Model";
        $rute = "Models/" . $model . ".php";
        if (file_exists($rute)) {
            require_once $rute;
            $this->model = new $model(); // Assign the new instance to the $model property
        }
    }
    public function detectar_token()
    {
        //detecta si se envio el token action-token-guia en el header del post
        if (getallheaders()['X-Token-Guia'] == 'Zc46Um3cI8Eh9vce6hn9') {
            return true;
        } else {
            return false;
        }
    }
}
