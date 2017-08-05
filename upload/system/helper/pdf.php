<?php
require_once(DIR_SYSTEM . 'vendor/dompdf/src/Dompdf.php');

function pdf($data, $type, $number) {
	$doc_type = str_replace(" ", "", $type);

    $title = $doc_type . '-' . $number;

	$pdf = new Dompdf\Dompdf();

	$pdf->loadHtml($data);

	$pdf->setPaper('A4', 'portrait');

	$pdf->render();

	$pdf->stream($title . '.pdf');
}
