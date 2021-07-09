<?php
//This function prints a text array as an html list.
function alist ($array) {  
  $alist = "<ul>";
  for ($i = 0; $i < sizeof($array); $i++) {
    $alist .= "<li>$array[$i]";
  }
  $alist .= "</ul>";
  return $alist;
}
//Try to get ImageMagick "convert" program version number.
//exec("convert -version", $out, $rcode);
//Print the return code: 0 if OK, nonzero if error. 
//echo "Version return code is $rcode <br>"; 
//Print the output of "convert -version"    
//echo alist($out); 
?>

<?php

$file ="images/machado_de_assis_dominio-publico-84kb.jpg";
$im = new imagick(realpath($file).'[0]');
 
$opacityColor = new \ImagickPixel("rgba(255, 0, 0, 0.5)");
$im->colorizeImage('rgb(204, 153, 201)', $opacityColor, true);

$im->setImageFormat("jpg");
$im->resizeImage(200,200,1,0);
// start buffering
ob_start();
$thumbnail = $im->getImageBlob();
$contents =  ob_get_contents();
ob_end_clean();
echo "<img src='data:image/jpg;base64,".base64_encode($thumbnail)."' />";



?>
