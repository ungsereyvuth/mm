<?php
// Set the content-type
header('Content-Type: image/png');

// Create the image
$im = imagecreatetruecolor(120, 30);
imagesavealpha($im, true);

// Create some colors
$trans_colour = imagecolorallocatealpha($im, 0, 0, 0, 127);
$white = imagecolorallocate($im, 255, 255, 255);
$grey = imagecolorallocate($im, 128, 128, 128);
$black = imagecolorallocate($im, 0, 0, 0);
//imagefilledrectangle($im, 0, 0, 119, 29, $white);
imagefill($im, 0, 0, $trans_colour);

// The text to draw
$text = rndStr(6);
// Replace path by your own font path
$font = $_SERVER['DOCUMENT_ROOT'].'/assets/fonts/COMIC_0.TTF';

// Add some shadow to the text
imagettftext($im, 14, 0, 11, 21, $grey, $font, $text);

// Add the text
imagettftext($im, 14, 0, 10, 20, $black, $font, $text);

// Using imagepng() results in clearer text compared with imagejpeg()
imagepng($im);
imagedestroy($im);

//set session
if (!is_session_started()) session_start();
$_SESSION['captcha'] = $text;
?>