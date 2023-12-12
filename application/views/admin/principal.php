<!-- =============================================== -->
<main id="main" class="main">


  <div class="pagetitle">
    <h1>Informe Gerencial</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>principal">Inicio</a></li>
      </ol>
    </nav>
  </div><!-- End Page Title -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-TY5PzaujIkqz2e3qtS6P5vZl+6ZQxHUnU8ToCTQDtvh9aIquVdkiM0e+nJSLZzUK" crossorigin="anonymous">

  <section class="section dashboard">
    <div class="row">

      <!-- Left side columns -->
      <div class="col-lg-12">
        <div class="row">
          <link href="<?php echo base_url(); ?>assets/css/principal.css" rel="stylesheet">



          <!--Comienzo de el mounstruo -->
          <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

          <div class="section_our_solution">
            <div class="row">

              <div class="card-body">

                <div class="our_solution_category">
                  <div class="solution_cards_box">
                    <div class="solution_card">
                      <div class="hover_color_bubble"></div>

                      <div class="solu_title">
                        <h5 class="card-title">Información del Usuario</h5>
                      </div>
                      <div class="solu_description">
                        <p>
                          <span class="card-title">Usuario:
                            <?php echo $this->session->userdata('Nombre_usuario'); ?>
                          </span>
                        </p>
                        <p>
                          <span class="card-title">Unidad Académica:
                            <?php echo $this->session->userdata('unidad'); ?>
                          </span>
                        </p>
                        <button type="button" class="read_more_btn">Read More</button>
                      </div>
                    </div>

                  </div>

                  <div class="our_solution_category">
                    <div class="solution_cards_box">
                      <div class="solution_card">
                        <div class="hover_color_bubble"></div>

                        <div class="solu_title">
                          <h5 class="card-title">Información de las Cuentas Contables</h5>
                        </div>
                        <div class="solu_description">
                        <?php
// Inicializa una variable para almacenar el presupuesto más alto y la cuenta correspondiente
$maxPresupuesto = 0;
$ccConMaxPresupuesto = null;

// Itera sobre las cuentas contables y busca la que tenga el presupuesto más alto

    // Busca el presupuesto correspondiente a la cuenta contable actual
    
    foreach ($presupuestos as $pre) {
        $presupuestoActual = 0;
        // Accede a la relación para obtener datos de la otra tabla
         // "otraTabla" es el nombre de la relación definida en el modelo Presupuesto
        
        $presupuestoActual = $pre->TotalPresupuestado;
          
        if ($presupuestoActual > $maxPresupuesto) {
          $maxPresupuesto = $presupuestoActual;
          // Asigna el valor de la otra tabla
          $ccConMaxPresupuesto = $this->Presupuesto_model->getCuentaContableData($pre->Idcuentacontable); // Ajusta "campoDeseado" según el nombre real en tu tabla
      }
    }

    // Verifica si el presupuesto actual es mayor que el máximo encontrado hasta ahora
    


// Muestra solo la cuenta contable con el presupuesto más alto
if ($ccConMaxPresupuesto !== null) {
    ?>
    <p>
        
        <span class="card-title">Cuenta Contable: <?php echo $ccConMaxPresupuesto; ?></span>
        
    </p>
    <p>
        <span class="card-title">Presupuesto Total: <?php echo $maxPresupuesto; ?></span>
    </p>
    <?php
}
?>
                         

                          <button type="button" class="read_more_btn">Read More</button>
                        </div>
                      </div>

                    </div>
                  </div>




                </div>

              </div>
            </div>

  </section>
</main>