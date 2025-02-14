<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CodexVeritas</title>
    <link href="<?php echo base_url(); ?>assets/img/codex.png" rel="icon">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css">
    <link href="<?php echo base_url(); ?>/assets/css/login_codex.css" rel="stylesheet">
    <!-- Bootstrap CSS -->
    
</head>
<body>

    <form action="<?php echo base_url(); ?>" method="POST" class="form bg-glass">
        <div class="profile">
            <img src="<?php echo base_url(); ?>assets/img/codex.png" alt="Logo UNE" style="width: 200px; height: 200px; margin-top: -50px;">
        </div>
        <div class="input-container">
            <input type="text" name="username" class="input bg-glass" placeholder="Nombre de usuario" required>
            <i class="fas fa-user icon"></i>
        </div>

        <div class="input-container">
            <input type="password" name="contraseña" class="input bg-glass" placeholder="Contraseña" required>
            <i class="fas fa-lock icon"></i>
        </div>

        <section id="header-container">
            <select id="unidadDropdown" name="unidad_academica" class="unidadDropdown" required>
                <option disabled selected>Seleccione una unidad académica</option>
                <?php if (!empty($unidades)) : ?>
                    <?php foreach ($unidades as $unidad) : ?>
                        <option value="<?php echo $unidad->id_unidad; ?>"><?php echo utf8_encode($unidad->unidad); ?></option>
                    <?php endforeach; ?>
                <?php else : ?>
                    <option disabled>No hay unidades académicas disponibles</option>
                <?php endif; ?>
            </select>
        </section>

        <div class="row">
            <div class="col-8">
                <?php if ($this->session->userdata('error')) { ?>
                    <p class="text-danger"><?= $this->session->userdata('error') ?></p>
                <?php } ?>
                <p class="text-danger"><?php echo validation_errors(); ?></p>
            </div>
        </div>

        <button type="submit" class="button bg-glass">Iniciar Sesión</button>
    </form>

 
</body>
</html>
