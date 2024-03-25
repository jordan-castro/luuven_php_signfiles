<?php

require_once "./multisign.php";
require_once "./sign.php";

// PDF file path
$pdfFilePath = "filegoc.pdf";

// Path to your Certificate
$certificatePath = ["ven.crt", "ven.crt"];

// Path to your private key
$privateKeyPath = ["", ""];

// Password for private key
$passwordForPrivateKey = ["", ""];

// Output PDF file path
$outputPdfFilePath = "output.pdf";

// Add a SINGLE signature to a PDF
multiSign($pdfFilePath, $certificatePath, $privateKeyPath, $passwordForPrivateKey, $outputPdfFilePath);

// Verify the PDF was signed.
$res = verifySignedPDF($outputPdfFilePath);

if ($res) {
    echo "\nPDF was signed!";
} else {
    echo "\nPDF was not signed!";
}