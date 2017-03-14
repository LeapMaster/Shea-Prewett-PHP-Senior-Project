<?php

session_start();


  require_once('connectvars.php');
  define('CAPTCHA_NUMCHARS', 6);
  define('CAPTCHA_WIDTH', 100);
  define('CAPTCHA_HEIGHT', 25);
  
  // Generate the random pass-phrase
  $pass_phrase = "";
  for ($index = 0; $index < CAPTCHA_NUMCHARS; $index++) 
  {
    $pass_phrase .= chr(rand(97, 122));
  }
  
  // Store the encripted pass in a session variable
  $_SESSION['pass_phrase'] = sha1($pass_phrase);
  
  // Create the image
  $img = imagecreatetruecolor(CAPTCHA_WIDTH, CAPTCHA_HEIGHT);
  
  // Set a white background with black text and gray graphics
  $bg_color = imagecolorallocate($img, 255, 255, 255);
  $text_color = imagecolorallocate($img, 0, 0, 0);
  $graphic_color = imagecolorallocate($img, 64, 64, 64);
  
  // Fill the background
  imagefilledrectangle($img, 0, 0, CAPTCHA_WIDTH, CAPTCHA_HEIGHT, $bg_color);
  
  // Draw some random lines
  for ($index = 0; $index < 5; $index++) 
  {
    imageline($img, 0, rand() % CAPTCHA_HEIGHT, CAPTCHA_WIDTH,
      rand() % CAPTCHA_HEIGHT, $graphic_color);
    
  }
    // Sprinkle in some random dots
    for ($index = 0; $index < 50; $index++) 
    {
      imagesetpixel($img, rand() % CAPTCHA_WIDTH,
      rand() % CAPTCHA_HEIGHT, $graphic_color);
    }
    
    $fontpath = realpath('.'); //replace . with a different directory if needed
    putenv('GDFONTPATH='.$fontpath);

  // Draw the pass-phrase string
  imagettftext($img, 18, 0, 5, CAPTCHA_HEIGHT - 5, $text_color,
  "Courier New Bold.ttf", $pass_phrase);
  
  // Output the image as a PNG using a header
  header("Content-type: image/png");
  imagepng($img);
    
  // Clean up
  imageDestroy($img);

?>