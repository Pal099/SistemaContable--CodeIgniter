<style>
:root{
   font-family: "Raleway", sans-serif;
   font-size: 16px;
   font-weight: 400;
}

:focus{
   outline: none;
}

*{
   margin: 0;
   box-sizing: border-box;
}

body{
   position: relative;
   display: grid;
   justify-content: center;
   align-items: center;
   min-height: 100vh;
   background-image: linear-gradient(to bottom right, #051937, #004d7a, #008793);
   color: #d8e6f5;
}

body::before,
body::after{
   content: "";
   position: absolute;
   transform: translate(-50%, -50%);
   background-color: rgba(216, 230, 245, 0.1);
   border: 1px solid rgba(216, 230, 245, 0.2);
   border-radius: 1rem;
   backdrop-filter: blur(5px);
   box-shadow: 3px 3px 20px 0 rgba(0, 0, 0, 0.2);
}

body::before{
   top: 55%;
   left: 66%;
   width: 125px;
   height: 125px;
}

body::after{
   top: 22%;
   left: 35%;
   width: 75px;
   height: 75px;
}

.bg-glass{
   background-color: rgba(216, 230, 245, 0.1);
   border: 1px solid rgba(216, 230, 245, 0.2);
   border-radius: 1rem;
   backdrop-filter: blur(5px);
   box-shadow: 3px 3px 20px 0 rgba(0, 0, 0, 0.2);
}

.form{
   width: 400px;
   padding: 2.5rem 2.25rem;
   text-align: center;
}

.profile{
   display: grid;
   justify-content: center;
   align-items: center;
   width: 95px;
   height: 95px;
   margin: 0 auto 3rem;
   font-size: 2rem;
   border-radius: 50%;
}

.input{
   display: block;
   width: 100%;
   margin-top: 1.5rem;
   padding: .625rem 1.375rem;
   font-family: "Raleway", sans-serif;
   font-size: 1rem;
   color: #fff;
   border-radius: 9999px;
   transition: box-shadow .25s;
}

.input::placeholder{
   color: rgba(255, 255, 255, 0.5);
}


.input:focus{
   box-shadow: 3px 3px 20px 0 rgba(5, 25, 55, 0.2);
}

.button{
   display: block;
   margin: 4.8rem auto 0;
   padding: .95rem 3rem;
   font-family: "Raleway", sans-serif;
   font-size: .875rem;
   font-weight: 500;
   text-align: center;
   letter-spacing: .5px;
   background-color: #1e88e5;
   color: #fff;
   border-radius: 9999px;
   cursor: pointer;
   transition: background-color .25s;
}

.button:hover{
   background-color: rgba(255, 255, 255, 0.1);
   backdrop-filter: blur(5px);
}

.register{
   margin-top: 1.5rem;
   font-size: .875rem;
}

.register a {
   font-weight: 500;
   text-decoration: none;
   color: rgba(255, 255, 255, 0.75);
   transition: color .25s;
}

.register a:hover {
   text-decoration: underline;
   color: #fff;
}

</style>

<style>
        .custom-select {
            position: relative;
            width: 400px;
            max-width: 100%;
            font-size: 1.15rem;
            color: #000;
            margin-top: 3rem;
        }

        .select-button {
            width: 100%;
            font-size: 1.15rem;
            background-color: #fff;
            padding: 0.675em 1em;
            border: 1px solid #caced1;
            border-radius: 0.25rem;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .selected-value {
            text-align: left;
        }

        .arrow {
            border-left: 5px solid transparent;
            border-right: 5px solid transparent;
            border-top: 6px solid #000;
            transition: transform ease-in-out 0.3s;
        }

        .select-dropdown {
            position: absolute;
            list-style: none;
            width: 100%;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            background-color: #fff;
            border: 1px solid #caced1;
            border-radius: 4px;
            padding: 10px;
            margin-top: 10px;
            max-height: 200px;
            overflow-y: auto;
            transition: 0.5s ease;
            transform: scaleY(0);
            opacity: 0;
            visibility: hidden;
        }

        .select-dropdown:focus-within {
            box-shadow: 0 10px 25px rgba(94, 108, 233, 0.6);
        }

        .select-dropdown li {
            position: relative;
            cursor: pointer;
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .select-dropdown li label {
            width: 100%;
            padding: 8px 10px;
            cursor: pointer;
        }

        .select-dropdown::-webkit-scrollbar {
            width: 7px;
        }

        .select-dropdown::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 25px;
        }

        .select-dropdown::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 25px;
        }

        .select-dropdown li:hover,
        .select-dropdown input:checked ~ label {
            background-color: #f2f2f2;
        }

        .select-dropdown input:focus ~ label {
            background-color: #dfdfdf;
        }

        .select-dropdown input[type="radio"] {
            position: absolute;
            left: 0;
            opacity: 0;
        }

        .custom-select.active .arrow {
            transform: rotate(180deg);
        }

        .custom-select.active .select-dropdown {
            opacity: 1;
            visibility: visible;
            transform: scaleY(1);
        }
    </style>

<style>
    .input-container {
        position: relative;
    }

    .input {
        padding-right: 30px; /* Espacio para el icono */
    }

    .icon {
        position: absolute;
        top: 50%;
        right: 10px; /* Ajusta la posición del icono según tus necesidades */
        transform: translateY(-50%);
        color: #fff; /* Color del icono */
    }
</style>




<style>
@import url(https://fonts.googleapis.com/css?family=Raleway);

* {
  margin: 0;
  padding: 0;
  -webkit-transition: all .2s;
  -moz-transition: all .2s;
  -ms-transition: all .2s;
  -o-transition: all .2s;
  transition: all .2s;
}

#unidadDropdown {
  display: block;
  position: absolute;
  width: 300px;
  height: 30px;
  left: 55%;
  top: 55%;
  margin-left: -173px;
  margin-top: 80px;
}
/* Select style here */

select {
  margin: 20px;
  color: #102c54;
  width: 310px;
  padding: 15px;
  height: 25px;
  cursor: pointer;
    background: url(http://sharpik.com/wip/cuteselect/arrow.png) 295px 12px no-repeat white;

}

select:hover {
  background-color: transparent;
  color: #102c54;
  padding: 15px 5px 15px 25px;
}

select option {
  background-color: transparent;
  color: #102c54;
  width: 310px;
  padding: 10px 15px;
  height: 20px;
  cursor: pointer;
}

select option:hover {
  padding-left: 25px;
  width: 270px;
  color: black;
}




</style>

<?php
// Establecer la conexión a la base de datos
$conexion = new mysqli('localhost', 'root', '', 'contanuevo');

// Verificar la conexión
if ($conexion->connect_error) {
    die("La conexión a la base de datos falló: " . $conexion->connect_error);
}

// Consulta para obtener las opciones de la tabla unidad_academica
$consulta_unidad = "SELECT id_unidad, unidad FROM unidad_academica";
$resultado_unidad = $conexion->query($consulta_unidad);
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>CodexVeritas</title>
    <link href="<?php echo base_url();?>assets/img/codex.png" rel="icon">

   <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css">
   <link rel="stylesheet" href="./style.css">
   
</head>

<body>

<form action="<?php echo base_url();?>login/index" method="POST" class="form bg-glass">
      <div class="profile" >
      <img src="\assets\img\codex.png" alt="Logo UNE "style="width: 200px; height: 200px; margin-top: -50px;">
      </div>
      <div class="input-container">
    <input type="text" name="username" class="input bg-glass" placeholder="Nombre de usuario">
    <i class="fas fa-user icon"></i>
</div>

<div class="input-container">
    <input type="password" name="contraseña" class="input bg-glass" placeholder="Contraseña">
    <i class="fas fa-lock icon"></i>
</div>
      
<section id="header-container" >
    <select id="unidadDropdown" name="unidad_academica">
        <option disabled selected>Seleccione una unidad académica</option>
        <?php
        while ($dataSelect = mysqli_fetch_array($resultado_unidad)) {
            echo '<option value="' . $dataSelect["id_unidad"] . '">' . utf8_encode($dataSelect["unidad"]) . '</option>';
        }
        ?>
    </select>
    <div id="selectedOptionDisplay">Unidad Académica Seleccionada: </div>
</section>



<div class="row">
          <div class="col-8">
           
              <?php if($this->session->userdata('error')) { ?>
              	<p class="text-danger"><?=$this->session->userdata('error')?></p>
              	<?php } ?>
              	<p class="text-danger"><?php echo validation_errors(); ?></p>
           
          </div>
    </div>
  
      <button type="submit" class="button bg-glass">Iniciar Sesión</button>
   </form>

  
   <script>
    const unidadDropdown = document.getElementById("unidadDropdown");
    const selectedOptionDisplay = document.getElementById("selectedOptionDisplay");

    unidadDropdown.addEventListener("change", function () {
        const selectedIndex = this.selectedIndex;
        const selectedOptionText = this.options[selectedIndex].text;
        selectedOptionDisplay.textContent = "Unidad Académica Seleccionada: " + selectedOptionText;
    });
</script>
   

</body>

</html>

<?php
// Cierra la conexión a la base de datos al final del script
$conexion->close();
?>

