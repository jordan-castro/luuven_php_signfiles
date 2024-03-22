<?php

require_once __DIR__ . "/FPDI-2.6.0/src/autoload.php";

use setasign\Fpdi\Tcpdf\Fpdi;

/**
 * Single sign OpenSSL PDF files.
 * 
 * @param string $file This is the path to the PDF file.
 * @param string $certification This is the path to the public Key or certificiation.
 * @param string $private_key This is the path to the private key.
 * @param string $password Password for private key.
 * @param array $info The necessary singing info for PDFs.
 * @param ?string $signedFile The ouptut signed file path. If empty will replace $file.
 * 
 * @author Jordan Castro
 */
function singleSign($file, $certification, $private_key, $password, $info, $signedFile="")
{
    $pdf = new Fpdi(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $pageCount = $pdf->setSourceFile($file);

    for ($x = 1; $x <= $pageCount; $x++) {
        $tplIdx = $pdf->importPage($x);

        // Add a page
        $pdf->AddPage();
        $pdf->useTemplate($tplIdx, null, null, null, null, true);
    }

    $pdf->setSignature($certification, $private_key, $password, '', 2, $info);

    $bytes = $pdf->Output($file, "S");

    if ($signedFile == "") {
        $signedFile = $file;
    }

    file_put_contents($signedFile, $bytes);
}

/**
 * Verifies signed PDF.
 * 
 * @param string $file Path to PDF file which needs to be verified.
 * 
 * @author Jordan Castro
 */
function verifySignedPDF($file) {
    $handle = fopen($file, 'r');
    $valid = false;
    $methods = [
        "adbe.pkcs7.detached",
        "ETSI.CAdES.detached"
    ];
    
    $keepGoing = true;
    while ((($buffer = fgets($handle)) != null) and $keepGoing) {
        foreach ($methods as $method) {
            if (strpos($buffer, $method)) {
                $valid = true;
                $keepGoing = false;
                break;
            }
        }
    }
    fclose($handle);

    return $valid;
}
