<?php
function slugify($string)
{
  // Convert the string to lowercase
  $string = strtolower($string);

  // Replace spaces and special characters with dashes
  $string = preg_replace('/[^a-z0-9]+/', '_', $string);

  // Remove leading and trailing dashes
  $string = trim($string, '_');

  return $string;
}

function pr($data)
{
  echo '<style>
  #debug_wrapper {
    position: fixed;
    top: 0px;
    left: 0px;
    z-index: 999;
    background: #fff;
    color: #000;
    overflow: auto;
    width: 100%;
    height: 100%;
  }</style>';
  echo '<div id="debug_wrapper"><pre>';

  print_r($data); // or var_dump($data);
  echo "</pre></div>";
  die;
}

function convertCurrencyNumber($number = false)
{
  $str = '';
  $number  = trim($number);

  $arr = str_split($number);
  $count = count($arr);

  $fomatNumber = number_format($number);
  if ($count < 3) {
    $str = $number;
  } else {
    $r = explode(',', $fomatNumber);
    switch (count($r)) {
      case 4:
        $str = $r[0] . ' tỉ';
        if ((int) $r[1]) {
          $str .= ' ' . $r[1] . ' Tr';
        }
        break;
      case 3:
        $str = $r[0] . ' Triệu';
        if ((int) $r[1]) {
          $str .= ' ' . $r[1] . 'K';
        }
        break;
      default:
        $str = $r[0] . ' Nghìn';
        if ((int) $r[1]) {
          $str .= ' ' . $r[1] . 'K';
        }
    }
  }
  return ($str);
}

function roundNumber($number)
{
  $numberCharactor = (string)$number;
  return round($number, - (strlen($numberCharactor) - 1));
}
