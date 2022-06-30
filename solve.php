<?php

var_dump(numToEng(133));

function numToEng($n) {
  $num = $n;
  $ones = array(
      0 =>"ZERO",
      1 => "ONE",
      2 => "TWO",
      3 => "THREE",
      4 => "FOUR",
      5 => "FIVE",
      6 => "SIX",
      7 => "SEVEN",
      8 => "EIGHT",
      9 => "NINE",
      10 => "TEN",
      11 => "ELEVEN",
      12 => "TWELVE",
      13 => "THIRTEEN",
      14 => "FOURTEEN",
      15 => "FIFTEEN",
      16 => "SIXTEEN",
      17 => "SEVENTEEN",
      18 => "EIGHTEEN",
      19 => "NINETEEN",
      20 => "twenty"
  );
  $tens = array( 
      0 => "ZERO",
      1 => "TEN",
      2 => "TWENTY",
      3 => "THIRTY", 
      4 => "FORTY", 
      5 => "FIFTY", 
      6 => "SIXTY", 
      7 => "SEVENTY", 
      8 => "EIGHTY", 
      9 => "NINETY" 
  ); 
  $hundreds = array( 
      "HUNDRED", 
      "THOUSAND", 
      "MILLION", 
      "BILLION", 
      "TRILLION", 
      "QUARDRILLION" 
  );

  $len = strlen((string)$num);
  $arr = str_split($num);
  $result = "";

  // ones:
  if ($len == 1) {
    $result = $ones[$num];
  }

  // Tens
  elseif ($len == 2) {
    if ($arr[1] == 0) {
      $result = $tens[$arr[0]];
    }
    elseif ($arr[0] == 1 && $arr[1] > 0) {
      $result = $ones[$num];
    }
    elseif ($arr[1] > 0) {
      $result = $tens[$arr[0]] . " " . $ones[$arr[1]];
    }
  }

  // hundreds
  elseif ($len == 3) {
    // 100 .. 900
    if ($arr[1] == 0 && $arr[2] == 0) {
      $result = $ones[$arr[0]] . " " . $hundreds[0];
    }

    // 101 .. 109
    elseif ($arr[1] == 0 && $arr[2] > 0) {
      $result = $ones[$arr[0]] . " " . $hundreds[0] . " " . $ones[$arr[2]];
    }

    // 110 .. 190
    elseif ($arr[1] > 0 && $arr[2] == 0) {
      $result = $ones[$arr[0]] . " " . $hundreds[0] . " " . $tens[$arr[1]];
    }

    // 111 .. 999
    elseif ($arr[1] > 0 && $arr[2] > 0) {
      
      if ($arr[1] == 1) {
        // one hundred eleven ... one hundred nineteen
        // examples: 111, 112, 113, 114, ...
        $_get_ones = (int)('1' . (string)$arr[2]);
        $result = $ones[$arr[0]] . " " . $hundreds[0] . " " . $ones[$_get_ones];
      } else {
        // 121 ...
        $result = $ones[$arr[0]] . " " . $hundreds[0] . " " . $tens[$arr[1]] . " " . $ones[$arr[2]];
      }
    }
  }

  // format to ninety-nine, thirty-three ....
  $final = strtolower($result);
  for ($i = 2; $i <= 9; $i++) {
    $_tens = strtolower($tens[$i]);
    $_ones = strtolower($ones[$i]);
    $isMatched = preg_match("/(". $_tens .") (". $_ones .")/", $final, $matches);
    if ($isMatched) {
      $final = str_ireplace($matches[0], $matches[1] . "-" . $matches[2], $final);
      break;
    }
  }

  
  return $final;
}

