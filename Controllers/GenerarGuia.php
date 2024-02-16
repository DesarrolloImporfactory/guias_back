<?php

class GenerarGuia extends Controller
{
    public function index()
    {

        $this->views->render($this, "index");
    }
    public function nueva()
    {
        if ($this->detectar_token()) {
            $post = json_decode(file_get_contents('php://input'), true);
            $this->model->generar($post);
        } else {
            echo "No tiene permisos";
        }
    }
    public function anular($id)
    {
        if ($this->detectar_token()) {
            $this->model->anular($id);
        } else {
            echo "No tiene permisos";
        }
    }

    public function visor($id)
    {
        if ($this->detectar_token()) {
            $this->model->visor($id);
        } else {
            echo "No tiene permisos";
        }
    }

    public function ver($id)
    {
        $this->views->render($this, "ver", $id);
    }

    public function revis()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $this->model->revisar($data);
    }
}
