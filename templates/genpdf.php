<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use Dompdf\Dompdf;
use Dompdf\Options;

 require_once 'dompdf/autoload.inc.php';

 ob_start();
 require_once 'postCertificat.php';
 $html = ob_get_contents();
 ob_end_clean();

 $options = new Options();
 $options->set('defaultFont','courier');

 $dompdf = new Dompdf();

 $dompdf->loadHtml($html);
 $dompdf->setPaper('A4','portrait');
 $dompdf->render();
 $dompdf->stream();

?>