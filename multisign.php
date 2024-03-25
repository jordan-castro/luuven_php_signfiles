<?php

require_once "./sign.php";

/**
 * Single sign OpenSSL PDF files.
 * 
 * @param string $file This is the path to the PDF file.
 * @param array $certifications This is the path to the public Keys or certificiations.
 * @param array $private_keys This is the path to the private keys.
 * @param array $passwords Passwords for private keys.
 * @param ?string $signedFile The ouptut signed file path. If empty will replace $file.
 * 
 * @author Jordan Castro
 */
function multiSign($file, $certifications, $private_keys, $passwords, $signedFile="")
{
    echo "\nStarting PHP Hanko Multi Sign";

    if ($signedFile == "") {
        $signedFile = $file;
        echo "\nNo Sign File Passed - Using ORIGIN";
    }

    echo "\nSigning #1";
    $id = 1;
    $return_var = 0;

    do {
        $sig = "Sig" . strval($id); 
        $command = "pyhanko sign addsig --no-strict-syntax --field $sig pemder --key " . $private_keys[0] . " --cert " . $certifications[0] . " $file $signedFile --no-pass\n";
        $output = [];
        $return_var = 0;
        exec($command,$output, $return_var);
        $id++;
    } while ($return_var != 0);

    for ($i = 1; $i < count($certifications);$i++) {
        echo "\n Signing #" . ($i + 1);
        $sig = "Sig" . strval($id);
        $command = "pyhanko sign addsig --field $sig pemder --key " . $private_keys[$i] . " --cert " . $certifications[$i] . " $signedFile $signedFile --no-pass\n";
        echo "\nCALLING: $command";
        $output = [];
        $return_var = 0;
        exec($command,$output, $return_var);
        $id++;
    }
}