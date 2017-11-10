<?php

if ($argc > 1) {
	include 'src/Money.php';
	$lang = 'pl';
	if ($argc > 2 && in_array($argv[2], ['pl', 'en']))  {
	    $lang = $argv[2];
	}
	echo "\n".\JakubWrona\Money\Money::digitsToWords($argv[1], $lang);
	return 0;
}
return 1;
