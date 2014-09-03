<?php

if (!isset($templ_page_valid)) {
  header('Location: /');
  exit();
}

// pass a number to this, for correct grammar
// it will return '' (empty string) if the number = 1
// it will return 's' for all other numbers
function plural($no) {
  return ($no == 1) ? '' : 's';
}

$strfunc_number_to_words =
  array(0 => 'no', 1 => 'one', 2 => 'two', 3 => 'three', 4 => 'four',
        5 => 'five', 6 => 'six', 7 => 'seven', 8 => 'eight', 9 => 'nine',
        10 => 'ten', 11 => 'eleven', 12 => 'twelve', 13 => 'thirteen',
        14 => 'fourteen', 15 => 'fifteen', 16 => 'sixteen', 17 => 'seventeen',
        18 => 'eighteen', 19 => 'nineteen', 20 => 'twenty');
// pass a number from 0 to 20 and get its full written out version
function number_to_words($no, $caps = 0) {
  global $strfunc_number_to_words;
  $as_words = $strfunc_number_to_words[$no];
  if ($as_words == '') {
    $as_words = 'no';
  }
  if ($caps) {
    $as_words = strtoupper(substr($as_words, 0, 1)).substr($as_words, 1);
  }
  return $as_words;
}
?>