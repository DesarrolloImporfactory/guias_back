<?php

use Dompdf\Dompdf;
use Dompdf\Options;

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
        date_default_timezone_set("America/Guayaquil");
        // Convertir la fecha a formato Y-m-d para mantener la fecha
        $fechaPedidoFormatted = date("Y-m-d", strtotime($fechaPedido));
        // Obtener la hora actual en formato H:i:s
        $currentTime = date("H:i:s");
        // Combinar la fecha con la hora actual
        $fechaPedidoWithCurrentTime = $fechaPedidoFormatted . ' ' . $currentTime;

        $fechaPedido = $fechaPedidoWithCurrentTime;
        $guia["fechaPedido"] = $fechaPedido;
        $extras = $guia["extras"];

        $sql = "INSERT INTO guias (origen_identificacion, origen_ciudad, origen_nombre, origen_direccion, origen_referencia, origen_numeroCasa, origen_telefono, origen_celular, destino_identificacion, destino_ciudad, destino_nombre, destino_direccion, destino_referencia, destino_numeroCasa, destino_telefono, destino_celular, numeroGuia, tipoServicio, noPiezas, peso, valorDeclarado, contiene, tamanio, cod, costoflete, costoproducto, tipocobro, comentario, fechaPedido, extras, estado) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $data = array($origen_identificacion, $origen_ciudad, $origen_nombre, $origen_direccion, $origen_referencia, $origen_numeroCasa, $origen_telefono, $origen_celular, $destino_identificacion, $destino_ciudad, $destino_nombre, $destino_direccion, $destino_referencia, $destino_numeroCasa, $destino_telefono, $destino_celular, $numeroGuia, $tipoServicio, $noPiezas, $peso, $valorDeclarado, $contiene, $tamanio, $cod, $costoflete, $costoproducto, $tipocobro, $comentario, $fechaPedido, $extras, 1);
        $result = $this->insert($sql, $data);
        if ($result == 1) {
            echo json_encode(array("status" => "success", "message" => "Guia generada correctamente"));
            $this->generar_guia($guia);
        } else if ($result == "d") {
            echo json_encode(array("status" => "error", "message" => "Guia ya existe"));
        } else {
            echo json_encode(array("status" => "error", "message" => $result));
        }
    }

    public function anular($id)
    {
        $this->cancelar_guia($this->obtener_guias($id));
        /* $sql = "UPDATE guias SET estado = 0 WHERE numeroGuia = ?";
        $data = array($id);
        $result = $this->update($sql, $data);
        if ($result == 1) {
        } else {
            echo $result;
            echo json_encode(array("status" => "error", "message" => "Error al eliminar guia de la base de datos"));
        } */
    }

    public function visor($id)
    {
        $sql = "SELECT * FROM guias WHERE numeroGuia = ?";
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

        $imagen = "https://marketplace.imporsuit.com/sysadmin/img/speed.jpg";
        $imagen_url = file_get_contents($imagen);
        //verifica si la hora es AM o PM
        $fechaPedido = $guia["fechaPedido"];

        $am_or_pm = date('A', strtotime($fechaPedido));
        $ciudad = $guia["destino"]["ciudadD"];
        $ciudadNombre = "";
        switch ($ciudad) {
            case 1:
            case 599:
                $ciudadNombre = "Quito";
                break;
            case 2:
            case 616:
                $ciudadNombre = "Valle de los Chillos";
                break;
            case 3:
            case 562:
                $ciudadNombre = "Valle de Cumbaya";
                break;
            case 4:
            case 613:
                $ciudadNombre = "Valle de Tumbaco";
                break;
            case 5:
            case 590:
                $ciudadNombre = "PIFO";
                break;
            case 6:
            case 608:
                $ciudadNombre = "SANGOLQUI";
                break;
            case 7:
            case 607:
                $ciudadNombre = "SAN RAFAEL";
                break;
            case 8:
            case 560:
                $ciudadNombre = "CONOCOTO";
                break;
        }
        if ($guia["cod"] == 0) {
            $guia["costoproducto"] = "SIN RECAUDO";
        }

        $html = '
        <!DOCTYPE html>
        <html lang="es">

        <head>
            <meta charset="UTF-8">
            <title>Ticket de Envío</title>
            <style>
        
            @page {
                size: 100mm 100mm;
                margin: 0;
            }
    
            body,
            .ticket-container {
                width: 255.464pt;
                /* 100mm in points */
                height: 263.464pt;
                /* 100mm in points */
                margin: 0;
                padding: 5pt;
                /* Ajusta el padding para ahorrar espacio */
                overflow: hidden;
                font-family: Arial, sans-serif;
                font-size: 8pt;
    
    
                /* Ajusta el tamaño de la fuente para que el texto encaje */
            }
    
           
    
            .ticket-header,
            .ticket-section {
                text-align: center;
                margin: 0pt 0;
                /* Reduce los márgenes */
            }
    
            .ticket-info,
            .ticket-section {
                clear: both;
                padding-top: 2pt;
                /* Reduce el padding */
            }
    
            .ticket-section {
                border-top: 1px solid #000;
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
    
            img {
                max-width: 80%;
                /* Reduce el tamaño de las imágenes */
                height: auto;
                display: block;
                margin: auto;
                /* Centra la imagen */
            }
    
            table {
                width: 100%;
            }
    
            /* Ajustes adicionales para el texto y los elementos */
            span,
            td {
                line-height: 1.1;
                /* Ajusta el interlineado */
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

                                <img src="https://marketplace.imporsuit.com/sysadmin/img/speed.jpg" width="100" alt="logo">
                            </td>

                        </tr>
                        <tr style="width: 25%;" class="text-right">
                            <td class="bold" style="font-size: 1.25em;">
                                ' . $guia["numeroGuia"] . '
                            </td>
                        </tr>
                    </table>

                </div>

                <div class="ticket-info">
                    <table style="width: 100%;">
                        <tr>
                            <td style="width: 50%;">
                                <span class=" bold">REMITENTE: ' . $guia["origen"]["nombreO"] . '</span>
                                <span>' . $guia["origen"]["direccion"] . " " . $guia["origen"]["numeroCasa"] . " " . $guia["referencia"] . '</span>
                            </td>
                            <td style="width: 50%;" class="text-right">
                                <span class="bold">QUITO </span> <br>
                                <span>TEL: ' . $guia["origen"]["telefono"] . '</span> <br>
                                <span>' . $guia["origen"]["celular"] . '</span>
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="ticket-section">
                  <span class="bold">DESTINO: ' . $guia["destino"]["nombreD"] . '</span> <br> 
                    <span> ' . $guia["destino"]["direccion"] . $guia["destino"]["numeroCasa"] . $guia["destino"]["referencia"] . '</span><br>
                    <span class="bold">TEL: ' . $guia["destino"]["celular"] . '</span>
                  
                </div>

                <div class="ticket-section">
                    <span>' . $guia["comentario"] . '  </span> <br>
                    <span style="font-size: 2em;" class="bold">' . $ciudadNombre . ' </span> <br>
                    <span class="bold"> QUITO </span>
                    
                </div>

                <div class="ticket-section">
                    <span> Peso: ' . $guia["peso"] . ' KG<br></span>
                    <span class="bold">Contenido: </span><br>  <span style="font-size: 0.75rem; max-width: 60px;">' . $guia["contiene"] . '</span><br>
                    <span>Valor asegurado: $0.00</span>
                   
                </div>

                <div class="ticket-section text-center">
                    <br> <span class="bold">VALOR A COBRAR $' . $guia["costoproducto"] . '</span><br>        
                </div>

            </div>
        </body>

        </html>
        ';

        $sql = "INSERT INTO visor_guia (numero_guia, html) VALUES (?,?)";
        $data = array($guia["numeroGuia"], $html);
        $result = $this->insert($sql, $data);
        if ($result == 1) {
            echo json_encode(array("status" => "success", "message" => "Guia generada correctamente"));
        } else {
            echo json_encode(array("status" => "error", "message" => "Error al generar guia"));
        }
    }

    public function revisar($data)
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

    public function descargar($guia)
    {
        $sql = "SELECT * FROM visor_guia WHERE numero_guia = '" . $guia . "'";

        $result = $this->select($sql);
        if ($result) {
            $html = $result[0]["html"];
            $options    = new Options();
            $options->set(array('isRemoteEnabled' => true));
            // Set to enable remote images to be used in PDF
            define("DOMPDF_ENABLE_REMOTE", true);

            // instantiate and use the dompdf class
            $dompdf = new Dompdf(array('enable_remote' => true));
            $dompdf->set_option('isHtml5ParserEnabled', true);
            $dompdf->set_option('isPhpEnabled', true);
            $dompdf->set_option('enable_remote', TRUE);
            $dompdf->loadHtml($html);

            // (Optional) Setup the paper size and orientation
            $dompdf->setPaper(array(0, 0, 4.937 * 72, 4.937 * 72), 'portrait');

            // Render the HTML as PDF
            $dompdf->render();

            // Output the generated PDF to Browser
            $dompdf->stream($guia . ".pdf", array("Attachment" => 1));
        } else {
            echo json_encode(array("status" => "error", "message" => "Error al obtener guia"));
        }
    }

    public function obtener_conexion($tienda)
    {
        $archivo_tienda =  $tienda . '/sysadmin/vistas/db1.php';
        $archivo_destino_tienda = "./Config/Destino.php";
        $contenido_tienda = file_get_contents($archivo_tienda);
        $get_data = json_decode($contenido_tienda, true);
        if (file_put_contents($archivo_destino_tienda, $contenido_tienda) !== false) {
            $host_d = $get_data['DB_HOST'];
            $user_d = $get_data['DB_USER'];
            $pass_d = $get_data['DB_PASS'];
            $base_d = $get_data['DB_NAME'];
            // Conexión a la base de datos de la tienda, establece la hora -5 GTM
            date_default_timezone_set('America/Guayaquil');
            $conexion = mysqli_connect($host_d, $user_d, $pass_d, $base_d);
            if (!$conexion) {
                die("Connection failed: " . mysqli_connect_error());
            }
            return $conexion;
        } else {
            echo "Error al copiar el archivo";
        }
    }

    public function obtener_guias($guia)
    {
        $marketplace = $this->obtener_conexion("https://marketplace.imporsuit.com");
        $sql = "SELECT * FROM `guia_laar` where guia_laar = '" . $guia . "'";
        $result = mysqli_query($marketplace, $sql);
        print_r($marketplace);
        $row = mysqli_fetch_assoc($result);
        print_r($row);
        return json_encode($row);
    }

    public function cancelar_guia($row)
    {
        $row = json_decode($row, true);

        //se recibe el row del query
        $tienda_venta = $row['tienda_venta'];
        $guia_laar = $row['guia_laar'];
        $tienda_proveedor = $row['tienda_proveedor'];

        $tienda_venta_conexion = $this->obtener_conexion($tienda_venta);
        $tienda_proveedor_conexion = $this->obtener_conexion($tienda_proveedor);
        $marketplace = $this->obtener_conexion("https://marketplace.imporsuit.com");

        $sql = "UPDATE guia_laar SET estado_guia = 4 WHERE guia_laar = '" . $guia_laar . "'";
        $result = mysqli_query($tienda_venta_conexion, $sql);
        if ($result) {
            $result2 = mysqli_query($tienda_proveedor_conexion, $sql);
            if ($result2) {
                $result3 = mysqli_query($marketplace, $sql);
                if ($result3) {
                    return json_encode(array("status" => "success", "message" => "Guia cancelada correctamente"));
                } else {
                    return json_encode(array("status" => "error", "message" => "Error al cancelar guiass"));
                }
            } else {
                return json_encode(array("status" => "error", "message" => "Error al cancelar guiass"));
            }
        } else {
            return json_encode(array("status" => "error", "message" => "Error al cancelar guia"));
        }

        mysqli_close($tienda_venta_conexion);
        mysqli_close($tienda_proveedor_conexion);
    }
}
