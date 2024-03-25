<?php

/**
 * Handles Creating the internal PYHANKO command.
 *
 * @param string $input Input file path. 
 * @param string $output Output file path.
 * @param string $crt CRT file path.
 * @param string $pem PEM file path.
 * @param string $stamp Where to go, and size of stamp.
 * @param ?string $key file path to secret password for pem.
 * 
 * @return string
 * 
 * @author Jordan Castro | https://www.freelancer.com/u/jordanmcastro
 */
function configurePyHankoCommand($input, $output, $crt, $pem, $stamp, $key) {
    // pyhanko sign addsig --no-strict-syntax --field 1/0,0,300,200/Sig1 pemder --key ven.crt --cert ven.crt filegoc.pdf output.pdf --no-pass
    $command = "pyhanko sign addsig --no-strict-syntax --field";

    $command .= " " . $stamp;
    
    $command .= " pemder --key ";
    if (strlen($pem) > 0) {
        $command .= $pem;
    } else {
        $command .= $crt;
    }

    if (strlen($key) > 0) {
        $command .= " --passfile $key";
    }

    $command .= " --cert $crt $input $output";
    
    if (strlen($key) == 0) {
        $command .= " --no-pass";
    }

    return $command;
}