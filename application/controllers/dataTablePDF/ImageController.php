<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ImageController extends CI_Controller {

    public function getImageDataUrl() {
        $imagePath = FCPATH . 'assets/img/logoUNE.png'; // Ruta completa a la imagen
        $imageData = file_get_contents($imagePath);
        $base64Image = base64_encode($imageData);
        echo 'data:image/png;base64,' . $base64Image;
    }

}
?>