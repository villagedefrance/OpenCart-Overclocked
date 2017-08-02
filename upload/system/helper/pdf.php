<?php
require_once(DIR_SYSTEM . 'vendor/dompdf/src/Dompdf.php');

use Dompdf\Dompdf;

function pdf($data, $type, $number) {
	$doc_type = str_replace(" ", "", $type);

    $title = $doc_type . '-' . $number;

	$dompdf = new Dompdf();

	$dompdf->loadHtml($data);

	$dompdf->setPaper('A4', 'portrait');

	$dompdf->render();

	$dompdf->stream($title . '.pdf');
}
