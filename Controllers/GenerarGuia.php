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
    public function eliminar($id)
    {
        $this->model->eliminar($id);
    }
}
