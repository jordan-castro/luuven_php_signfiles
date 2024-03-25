<?php

/*
NOTES:
 - To create self-signed signature: openssl req -x509 -nodes -days 365000 -newkey rsa:1024 -keyout tcpdf.crt -out tcpdf.crt
 - To export crt to p12: openssl pkcs12 -export -in tcpdf.crt -out tcpdf.p12
 - To convert pfx certificate to pem: openssl pkcs12 -in tcpdf.pfx -out tcpdf.crt -nodes
*/

require_once __DIR__ . "/sign.php";

// PDF file path
$pdfFilePath = "filegoc.pdf";

// Path to your Certificate
$certificatePath = "ven.crt";

// Path to your private key
$privateKeyPath = "ven.crt";

// File that contains password for private key
$passwordForPrivateKey = "";

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

