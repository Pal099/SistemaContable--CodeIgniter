<!DOCTYPE html>
<html>
<head>
<?php
   $uri_segments = $this->uri->segment_array();
   $numero_asiento = end($uri_segments);
?>
<meta http-equiv="refresh" content="0;url=<?php echo base_url();?>Pago_obligaciones/pdf_pago_obli_num_asi/">

</head>
<body>
  <!-- Aquí puedes incluir cualquier contenido que desees mostrar antes de la redirección. -->
</body>
</html>
