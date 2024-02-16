<?php

class GenerarGuiaModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }

    public function generar($guia)
    {
        $origen_identificacion = $guia["origen"]["identificacionO"];
        $origen_ciudad = $guia["origen"]["ciudadO"];
        $origen_nombre = $guia["origen"]["nombreO"];
        $origen_direccion = $guia["origen"]["direccion"];
        $origen_referencia = $guia["origen"]["referencia"];
        $origen_numeroCasa = $guia["origen"]["numeroCasa"];
        $origen_telefono = $guia["origen"]["telefono"];
        $origen_celular = $guia["origen"]["celular"];

        $destino_identificacion = $guia["destino"]["identificacionD"];
        $destino_ciudad = $guia["destino"]["ciudadD"];
        $destino_nombre = $guia["destino"]["nombreD"];
        $destino_direccion = $guia["destino"]["direccion"];
        $destino_referencia = $guia["destino"]["referencia"];
        $destino_numeroCasa = $guia["destino"]["numeroCasa"];
        $destino_telefono = $guia["destino"]["telefono"];
        $destino_celular = $guia["destino"]["celular"];

        $numeroGuia = $guia["numeroGuia"];
        $tipoServicio = $guia["tipoServicio"];
        $noPiezas = $guia["noPiezas"];
        $peso = $guia["peso"];
        $valorDeclarado = $guia["valorDeclarado"];
        $contiene = $guia["contiene"];
        $tamanio = $guia["tamanio"];
        $cod = $guia["cod"];
        $costoflete = $guia["costoflete"];
        $costoproducto = $guia["costoproducto"];
        $tipocobro = $guia["tipocobro"];
        $comentario = $guia["comentario"];
        $fechaPedido = $guia["fechaPedido"];
        $extras = $guia["extras"];

        $sql = "INSERT INTO guias (origen_identificacion, origen_ciudad, origen_nombre, origen_direccion, origen_referencia, origen_numeroCasa, origen_telefono, origen_celular, destino_identificacion, destino_ciudad, destino_nombre, destino_direccion, destino_referencia, destino_numeroCasa, destino_telefono, destino_celular, numeroGuia, tipoServicio, noPiezas, peso, valorDeclarado, contiene, tamanio, cod, costoflete, costoproducto, tipocobro, comentario, fechaPedido, extras, estado) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $data = array($origen_identificacion, $origen_ciudad, $origen_nombre, $origen_direccion, $origen_referencia, $origen_numeroCasa, $origen_telefono, $origen_celular, $destino_identificacion, $destino_ciudad, $destino_nombre, $destino_direccion, $destino_referencia, $destino_numeroCasa, $destino_telefono, $destino_celular, $numeroGuia, $tipoServicio, $noPiezas, $peso, $valorDeclarado, $contiene, $tamanio, $cod, $costoflete, $costoproducto, $tipocobro, $comentario, $fechaPedido, $extras, 1);
        $result = $this->insert($sql, $data);
        if ($result == 1) {
            echo json_encode(array("status" => "success", "message" => "Guia generada correctamente"));
        } else if ($result == "d") {
            echo json_encode(array("status" => "error", "message" => "Guia ya existe"));
        } else {
            echo json_encode(array("status" => "error", "message" => "Error al generar guia"));
        }
    }

    public function eliminar($id)
    {
        $sql = "UPDATE guias SET estado = 0 WHERE numero_guia = ?";
        $data = array($id);
        $result = $this->update($sql, $data);
        if ($result == 1) {
            echo json_encode(array("status" => "success", "message" => "Guia eliminada correctamente"));
        } else {
            echo json_encode(array("status" => "error", "message" => "Error al eliminar guia"));
        }
    }
}
