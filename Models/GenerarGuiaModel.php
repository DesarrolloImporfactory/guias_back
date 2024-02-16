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

    public function anular($id)
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

    public function visor($id)
    {
        $sql = "SELECT * FROM guias WHERE numero_guia = ?";
        $data = array($id);
        $result = $this->select($sql, $data);
        if ($result) {
            echo json_encode(array("status" => "success", "data" => $result));
        } else {
            echo json_encode(array("status" => "error", "message" => "Error al obtener guia"));
        }
    }

    public function generar_guia($guia)
    {
        $html = '
        <!DOCTYPE html>
        <html lang="es">

        <head>
            <meta charset="UTF-8">
            <title>Ticket de Envío</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    margin: 0;
                    padding: 0;
                }

                .ticket-container {
                    width: 400px;
                    padding: 10px;
                    border: 1px solid #000;
                    margin: auto;
                }

                .ticket-header {
                    text-align: center;
                }

                .ticket-info {
                    margin-bottom: 10px;
                }

                .ticket-info span {
                    display: block;
                }

                .ticket-section {
                    border-top: 1px solid #000;
                    padding-top: 5px;
                }

                .bold {
                    font-weight: bold;
                }

                .text-right {
                    text-align: right;
                }

                .text-center {
                    text-align: center;
                }
            </style>
        </head>

        <body>
            <div class="ticket-container">
                <div class="ticket-header">
                    <table style="width: 100%;">
                        <tr style="width: 25%;">
                            <td></td>
                        </tr>
                        <tr style="width: 50%;">
                            <td>

                                <img src="https://marketplace.imporsuit.com/sysadmin/img/speed.jpg" width="200" alt="logo">
                            </td>

                        </tr>
                        <tr style="width: 25%;" class="text-right">
                            <td class="bold" style="font-size: 1.5em;">
                                ' . $guia["numeroGuia"] . '
                            </td>
                        </tr>
                    </table>

                </div>

                <div class="ticket-info">
                    <table style="width: 100%;">
                        <tr>
                            <td style="width: 50%;">
                                <span class=" bold">REMITENTE: IMPORSUIT</span>
                                <span>QUITO - ECUADOR s2556 Av hernan Gmoiner y s1654</span>
                            </td>
                            <td style="width: 50%;" class="text-right">
                                <span class="bold">QUITO </span>
                                <span>TEL: ' . $guia["origen"]["telefono"] . '</span>
                                <span>' . $guia["origen"]["celular"] . '</span>
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="ticket-section">
                    <br><span class="bold">DESTINO: ' . $guia["destino"]["nombreD"] . '</span> <br> 
                    <span> ' . $guia["destino"]["direccion"] . $guia["destino"]["referencia"] . '</span><br>
                    <span class="bold">TEL: ' . $guia["destino"]["telefono"] . '</span>
                    <br><br>
                </div>

                <div class="ticket-section">
                    <span>' . $guia["comentario"] . '  </span> <br>
                    <span style="font-size: 2em;" class="bold">' . $guia["ciudadD"] . ' 
                    <span class="bold"> </span>
                    <br>
                    <br>
                </div>

                <div class="ticket-section">
                    <br>
                    <span>Peso: 2 KG <br></span>
                    <span class="bold">Contenido: </span> <span style="font-size: 2rem;">SADx1</span><br>
                    <span>Valor asegurado: $0.00</span>
                    <br>
                    <br>
                </div>

                <div class="ticket-section text-center">
                    <br> <span class="bold">VALOR A COBRAR $17.40</span><br>
                    <br>
                </div>

                <div class="ticket-section text-right">
                    <span>CARGA - 2/1/2024 4:19:43 PM</span>
                </div>
            </div>
        </body>

        </html>
        ';
    }

    public function cache($data)
    {
        $json_data = json_encode($data);
        $sql = "INSERT INTO cache (cache) VALUES (?)";
        $result = $this->insert($sql, array($json_data));
        if ($result == 1) {
            echo json_encode(array("status" => "success", "message" => "Cache generada correctamente"));
        } else {
            echo json_encode(array("status" => "error", "message" => "Error al generar cache"));
        }
    }
}
