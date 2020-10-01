<?php

if (!isset($templ_page_valid)) {
  header('Location: /');
  exit();
}
// STML = Simple Template-based Markup Language

function stml_parse_multiline($fulltext) {
  $stml = $fulltext;
  
  $stml_p = explode("\r\n", $stml);
  
  $i = 0;
  foreach ($stml_p as $p) {
    if (strlen($stml_p) > 0) {
      $html .= '<p>'.stml_parse($stml_p[$i]).'</p>';
    }
    $i++;
  }
  
  return $html;
}

function stml_parse($stml_p) {
  return $stml_p;
  global $DBCONN;
  $pos = 0;
  
  $stml_p = htmlentities($stml_p);
  
  $stml_p = str_replace('  ', '&nbsp; ', $stml_p);
  
  do {
    $pos = strrpos($stml_p, '{', 0);
    if ($pos === false)
      break;
    
    $pos++;
    
    $e = strpos($stml_p, '}', $pos);
    if ($e === false)
      break;
    
    $lastarg = false;
    $a = 0;
    $argv = array();
    $argvpos = $pos;
    $lastargvpos = $argvpos;
    do {
      $argvpos = strpos($stml_p, '|', $argvpos);
      if ($argvpos === false || $argvpos >= $e) {
        $lastarg = true;
        $argvpos = $e;
      }
      
      $argv[$a] = substr($stml_p, $lastargvpos, $argvpos - $lastargvpos);
      
      $argvpos++;
      $lastargvpos = $argvpos;
      $a++;
    } while ($lastarg == false);
    
    $title = $argv[0];
    
    $template = api_get_stml_template($DBCONN, $title);
    
    if (strlen($template['name'])) {
      $result = $template['result'];
      for ($argn = 0; $argn <= $template['args']; $argn++) {
        $result = str_replace('{#'.$argn.'}', $argv[$argn], $result);
      }
    } else {
      $result = '{curly-open}'.substr($stml_p, $pos, $e - $pos).'{curly-close}';
    }
    
    if ($template['type'] == 'ECHO') {
      $stml_p = substr($stml_p, 0, $pos - 1).
                $result.
                substr($stml_p, $e + 1);
    } elseif ($template['type'] == 'EVAL') {
      $stml_p = substr($stml_p, 0, $pos - 1).
                eval($result).
                substr($stml_p, $e + 1);
    }
  } while ($pos !== false);
  
  return $stml_p;
}

function stml_encode($fulltext) {
  return $fulltext;
}
