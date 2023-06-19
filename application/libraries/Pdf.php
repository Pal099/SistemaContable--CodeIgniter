<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once dirname(__FILE__).'/tcpdf/tcpdf.php';

class Pdf  extends TCPDF{
// por defecto, usaremos papel A4 en vertical, salvo que digamos otra cosa al momento de generar un PDF
 function  __construct() {
    parent::__construct();
    
  }
}
?>
