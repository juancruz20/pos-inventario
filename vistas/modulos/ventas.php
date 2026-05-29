<?php

if($_SESSION["perfil"] == "Especial"){

  echo '<script>

    window.location = "inicio";

  </script>';

  return;

}

$xml = ControladorVentas::ctrDescargarXML();

if($xml){

  rename($_GET["xml"].".xml", "xml/".$_GET["xml"].".xml");

  echo '<a class="btn btn-block btn-success abrirXML" archivo="xml/'.$_GET["xml"].'.xml" href="ventas">Se ha creado correctamente el archivo XML <span class="fa fa-times pull-right"></span></a>';

}

?>
<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      Administrar ventas
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Administrar ventas</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">
  
        <a href="crear-venta">

          <button class="btn btn-primary">
            
            Agregar venta

          </button>

        </a>

         <button type="button" class="btn btn-default pull-right" id="daterange-btn">
           
            <span>
              <i class="fa fa-calendar"></i> 

              <?php

                if(isset($_GET["fechaInicial"])){

                  echo htmlspecialchars($_GET["fechaInicial"], ENT_QUOTES, 'UTF-8')." - ".htmlspecialchars($_GET["fechaFinal"], ENT_QUOTES, 'UTF-8');
                
                }else{
                 
                  echo 'Rango de fecha';

                }

              ?>
            </span>

            <i class="fa fa-caret-down"></i>

         </button>

      </div>

      <div class="box-body">
        
       <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
         
        <thead>
         
         <tr>
           
            <th style="width:10px">#</th>
            <th>Código factura</th>
            <th>Cliente</th>
            <th>Vendedor</th>
            <th>Forma de pago</th>
            <th>Total</th> 
            <th>Fecha</th>
            <th>Detalle compra</th>
            <th>Acciones</th>

         </tr> 

        </thead>

        <tbody>

        <?php

          if(isset($_GET["fechaInicial"])){

            $fechaInicial = $_GET["fechaInicial"];
            $fechaFinal = $_GET["fechaFinal"];

          }else{

            $fechaInicial = null;
            $fechaFinal = null;

          }

          $respuesta = ControladorVentas::ctrRangoFechasVentas($fechaInicial, $fechaFinal);

          foreach ($respuesta as $key => $value) {
           
           echo '<tr>

                  <td>'.($key+1).'</td>

                  <td>'.htmlspecialchars($value["codigo"], ENT_QUOTES, 'UTF-8').'</td>';

                  $itemCliente = "id";
                  $valorCliente = $value["id_cliente"];

                  $respuestaCliente = ControladorClientes::ctrMostrarClientes($itemCliente, $valorCliente);

                  echo '<td>'.htmlspecialchars(($respuestaCliente ? $respuestaCliente["nombre"] : "Eliminado"), ENT_QUOTES, 'UTF-8').'</td>';

                  $itemUsuario = "id";
                  $valorUsuario = $value["id_vendedor"];

                  $respuestaUsuario = ControladorUsuarios::ctrMostrarUsuarios($itemUsuario, $valorUsuario);

                  echo '<td>'.htmlspecialchars(($respuestaUsuario ? $respuestaUsuario["nombre"] : "Eliminado"), ENT_QUOTES, 'UTF-8').'</td>

                  <td>'.htmlspecialchars($value["metodo_pago"], ENT_QUOTES, 'UTF-8').'</td>

                  <td>$ '.number_format($value["total"],2).'</td>

                  <td>'.htmlspecialchars($value["fecha"], ENT_QUOTES, 'UTF-8').'</td>

                  <td style="font-size:12px;">';

                    $productosVenta = json_decode($value["productos"], true);

                    if(is_array($productosVenta)){
                      foreach ($productosVenta as $p) {
                        echo htmlspecialchars($p["descripcion"], ENT_QUOTES, 'UTF-8')." (x".htmlspecialchars($p["cantidad"], ENT_QUOTES, 'UTF-8').")<br>";
                      }
                    }

                  echo '</td>

                  <td>

                    <div class="btn-group">

                      <a class="btn btn-success" href="vistas/modulos/descargar-reporte.php?reporte=ventas">
                        <i class="fa fa-file-excel-o"></i>
                      </a>
                        
                      <button class="btn btn-info btnImprimirFactura" codigoVenta="'.$value["codigo"].'">

                        <i class="fa fa-print"></i>

                      </button>';

                      if($_SESSION["perfil"] == "Administrador"){

                      echo '<button class="btn btn-warning btnEditarVenta" idVenta="'.$value["id"].'"><i class="fa fa-pencil"></i></button>

                      <button class="btn btn-danger btnEliminarVenta" idVenta="'.$value["id"].'"><i class="fa fa-times"></i></button>';

                    }

                    echo '</div>  

                  </td>

                </tr>';
            }

        ?>
               
        </tbody>

       </table>

       <?php

      $eliminarVenta = new ControladorVentas();
      $eliminarVenta -> ctrEliminarVenta();

      ?>
       

      </div>

    </div>

  </section>

</div>




