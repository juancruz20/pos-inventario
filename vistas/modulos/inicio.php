<div class="content-wrapper">

  <section class="content-header">

    <h1>

      Tablero

      <small>Panel de Control</small>

    </h1>

    <ol class="breadcrumb">

      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>

      <li class="active">Tablero</li>

    </ol>

  </section>

  <section class="content">

    <div class="row">

    <?php

    if($_SESSION["perfil"] =="Administrador" || $_SESSION["perfil"] =="Vendedor"){

      include "inicio/cajas-superiores.php";

    }

    ?>

    </div>

     <div class="row">

        <div class="col-lg-12 col-xs-12">

          <?php

          if($_SESSION["perfil"] =="Administrador"){

           include "reportes/grafico-ventas.php";

          }

          ?>

        </div>

        <div class="col-lg-12 col-xs-12">

          <?php

          if($_SESSION["perfil"] =="Administrador" || $_SESSION["perfil"] =="Vendedor"){

            include "inicio/productos-stock-bajo.php";

          }

          ?>

        </div>

        <div class="col-lg-6 col-xs-12 col-sm-6">

          <?php

          if($_SESSION["perfil"] =="Administrador"){

           include "reportes/productos-mas-vendidos.php";

         }

          ?>

        </div>

         <div class="col-lg-6 col-xs-12 col-sm-6">

          <?php

          if($_SESSION["perfil"] =="Administrador"){

           include "inicio/productos-recientes.php";

         }

          ?>

        </div>



     </div>

  </section>

</div>
