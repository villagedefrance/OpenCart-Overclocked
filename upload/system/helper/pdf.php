<?php
function pdf($data, $type, $number) {
    $title = $type . ' ' . $number;

    $pdf = new DOMPDF;

    $pdf->load_html($data);

    $pdf->render();

    $pdf->stream($title . '.pdf');
}

?>