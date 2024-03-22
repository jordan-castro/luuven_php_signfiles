<?php

require_once "./sign.php";

// PDF file path
$pdfFilePath = "PDF_PATH.pdf";

// Path to your Certificate
$certificatePath = "CERTIFICATE.crt";

// Path to your private key
$privateKeyPath = "PRIVATE_KEY.pem";

// Password for private key
$passwordForPrivateKey = "password";

// Output PDF file path
$outputPdfFilePath = "output.pdf";

// Add a SINGLE signature to a PDF
singleSign($pdfFilePath, $certificatePath, $privateKeyPath, $passwordForPrivateKey, $outputPdfFilePath);

// Verify the PDF was signed.
$res = verifySignedPDF($outputPdfFilePath);

if ($res) {
    echo "\nPDF was signed!";
} else {
    echo "\nPDF was not signed!";
}