<?php

require_once "./sign.php";

// PDF file path
$pdfFilePath = "PATH_TO_YOUR_PDF.pdf";

// Path to your Certificate
$certificatePath = "PATH_TO_YOUR_CERTIFICATE.crt";

// Path to your private key
$privateKeyPath = "PATH_TO_YOUR_PRIVATE_KEY.pem";

// Password for private key
$passwordForPrivateKey = "password";

// Output PDF file path
$outputPdfFilePath = "output.pdf";

// Add a SINGLE signature to a PDF
singleSign($pdfFilePath, $certificatePath, $privateKeyPath, $passwordForPrivateKey, [
    'Name' => 'LUUVEN',
    'Location' => 'Freelancer',
    'Reason' => 'Project Request',
    'ContactInfo' => 'https://www.freelancer.com/u/jordanmcastro',
], $outputPdfFilePath);

// Verify the PDF was signed.
$res = verifySignedPDF($outputPdfFilePath);

if ($res) {
    echo "\nPDF was signed!";
} else {
    echo "\nPDF was not signed!";
}