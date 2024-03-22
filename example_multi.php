<?php

require_once "./multisign.php";
require_once "./sign.php";

// PDF file path
$pdfFilePath = "INPUT.pdf";

// Path to your Certificate
$certificatePath = ["CERTIFICATE_1.crt", "CERTIFICATE_2.crt"];

// Path to your private key
$privateKeyPath = ["PRIVATE_KEY_1.pem", "PRIVATE_KEY_2.pem"];

// Password for private key
$passwordForPrivateKey = ["password", "password"];

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