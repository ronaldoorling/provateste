<?php
/*
* 1. Escreva um programa que imprima números de 1 a 100. Mas, para múltiplos de 3 imprima
* “Fizz” em vez do número e para múltiplos de 5 imprima “Buzz”. Para números múltiplos
* de ambos (3 e 5), imprima “FizzBuzz”.
*/

namespace ProvaTeste;

Class Numeros
{
	public static function printNumeros() {
	
		for($i = 1; $i <= 100; $i++) {
			if ($i % 3 == 0 && $i % 5 == 0) { 
				echo $i.' FizzBuzz <br />'; 
			} else if ($i % 3 == 0) { 
				echo $i.' Fizz <br />'; 
			} else if ($i % 5 == 0) { 
				echo $i.' Buzz <br />'; 
			} else {
				echo $i.'<br />';
			}
		}
	}
}

Numeros::printNumeros();