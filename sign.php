<?php

require_once __DIR__ . "/command.php";

/**
 * Single sign OpenSSL PDF files.
 * 
 * @param string $file This is the path to the PDF file.
 * @param string $certification This is the path to the public Key or certificiation.
 * @param string $private_key This is the path to the private key.
 * @param string $password Password for private key.
 * @param ?string $signedFile The ouptut signed file path. If empty will replace $file.
 * 
 * @author Jordan Castro | https://www.freelancer.com/u/jordanmcastro
 */
function singleSign($file, $certification, $private_key, $password, $signedFile = "")
{
    echo "\nStarting PHP Hanko";
    if ($signedFile == "") {
        $signedFile = $file;
        echo "\nNo Sign File Passed - Using ORIGIN";
    }

    // Call PYHANKO
    $command = configurePyHankoCommand(
        $file,
        $signedFile,
        $certification,
        $private_key,
        "1/0,0,100,100/Sig1",
        $password
    );
    // $command = "pyhanko sign addsig --no-strict-syntax --field Sig1 pemder --key $private_key --cert $certification $file $signedFile --no-pass\n";
    echo "\nCALLING: $command";

    $output = [];
    $return_var = 0;
    exec($command, $output, $return_var);

    echo "\nOUTPUT: " . json_encode($output);
    echo "\nRESULT: " . $return_var;
}

/**
 * Verifies signed PDF.
 * 
 * @param string $file Path to PDF file which needs to be verified.
 * 
 * @author Jordan Castro
 */
function verifySignedPDF($file)
{
    $handle = fopen($file, 'r');
    if ($handle === false) {
        return false;
    }
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
