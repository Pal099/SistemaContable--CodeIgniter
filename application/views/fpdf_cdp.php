<!-- En la vista donde se realiza la redirección -->
<!DOCTYPE html>
<html>
<head>
  <?php
    // Obtener el número de asiento desde la URL actual
    $uri_segments = $this->uri->segment_array();
    $numero_asiento = end($uri_segments);
  ?>
  <meta http-equiv="refresh" content="0;url=<?php echo base_url();?>Certifi_disp_presu/pdfs/">
</head>
<body>
  <!-- Aquí puedes incluir cualquier contenido que desees mostrar antes de la redirección. -->
</body>
</html>
