<?php

use Mpdf\Mpdf;

$mpdf = new Mpdf();
$mpdf->WriteHTML('<h1>Hello, world!</h1>');
$mpdf->Output();

