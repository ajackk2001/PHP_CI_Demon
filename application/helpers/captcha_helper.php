<?php

if ( ! function_exists('create_captcha'))
{
	function create_captcha($data = '', $font_path = ''){
		$defaults = array('word' => '', 'word_length' => 4, 'img_width' => '200', 'img_height' => '30', 'font_path' => $_SERVER['DOCUMENT_ROOT'].'/system/fonts/texb.ttf', 'expiration' => 7200);
		foreach ($defaults as $key => $val){
			if ( ! is_array($data)){
				if ( ! isset($$key) OR $$key == ''){
					$$key = $val;
				}
			}else{
				$$key = ( ! isset($data[$key])) ? $val : $data[$key];
			}
		}
		if ($word == ''){
			$pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
				$str = '';
				for ($i = 0; $i < $word_length; $i++){
					$str .= substr($pool, mt_rand(0, strlen($pool) -1), 1);
				}
			$word = $str;
		}
		// -----------------------------------
		// Determine angle and position
		// -----------------------------------
		$length 	= strlen($word);
		$angle		= ($length >= 6) ? rand(-($length-6), ($length-6)) : 0;
		$x_axis     = rand(6, (360/$length)-16);
		$y_axis = ($angle >= 0 ) ? rand($img_height, $img_width) : rand(6, $img_height);
        // -----------------------------------
        // Create image
        // -----------------------------------
        // PHP.net recommends imagecreatetruecolor(), but it isn't always available
        if (function_exists('imagecreatetruecolor')){
            $im = imagecreatetruecolor($img_width, $img_height);
        }else{
			$im = imagecreate($img_width, $img_height);
        }
        // -----------------------------------
        //  Assign colors 依據RBG色碼填入數字，提供常用顏色註解
        // -----------------------------------
        $bg_color            = imagecolorallocate ($im, 255, 255, 255); //背景顏色，目前為白色
        $border_color        = imagecolorallocate ($im, 23, 33, 101); 
        $text_color          = imagecolorallocate ($im, 0,0 ,0); //文字顏色，目前為黑色
        $grid_color          = imagecolorallocate ($im, 116, 142, 187); //背景線條的顏色
        $shadow_color        = imagecolorallocate ($im, 255, 240, 240);
        // -----------------------------------
        //  Create the rectangle
        // -----------------------------------
        ImageFilledRectangle($im, 0, 0, $img_width, $img_height, $bg_color);
        // -----------------------------------
        //  Create the spiral pattern 此地方的數字可自行修改，會改變線條的數量，註解處為原預設值
        // -----------------------------------
        $theta          = 1;
        // $theta          = 1;
        $thetac         = 2;
        // $thetac         = 8; 
        $radius         = 60;
        // $radius         = 30;
        $circles        = 10;
        // $circles        = 20;
        $points         = 20;
        // $points         = 32;
        for ($i = 0; $i < ($circles * $points) - 1; $i++){
            $theta = $theta + $thetac;
            $rad = $radius * ($i / $points );
            $x = ($rad * cos($theta)) + $x_axis;
            $y = ($rad * sin($theta)) + $y_axis;
            $theta = $theta + $thetac;
            $rad1 = $radius * (($i + 1) / $points);
            $x1 = ($rad1 * cos($theta)) + $x_axis;
            $y1 = ($rad1 * sin($theta )) + $y_axis;
            imageline($im, $x, $y, $x1, $y1, $grid_color);
            $theta = $theta - $thetac;
        }
        // -----------------------------------
        //  Write the text 修正文字大小地方
        // -----------------------------------
        $use_font = ($font_path != '' AND file_exists($font_path) AND function_exists('imagettftext')) ? TRUE : FALSE;
        if ($use_font == FALSE){
            $font_size = 5;
            $x=rand(0,20);//修改
            $y = 0;
        }else{
            $font_size = 20;
            // $font_size        = 16;
            $x=rand(0,5);//修改
            $y = $font_size+2;
        }
        for ($i = 0; $i < strlen($word); $i++){
            if ($use_font == FALSE){
                $y = rand(0 , $img_height/2);
                imagestring($im, $font_size, $x, $y, substr($word, $i, 1), $text_color);
                $x += ($font_size*2);
            }else{
                $y = rand($img_height/2, $img_height-3);
                imagettftext($im, $font_size, $angle, $x, $y, $text_color, $font_path, substr($word, $i, 1));
                $x += $font_size;
            }
        }
        imagerectangle($im, -1, -1, $img_width, $img_height, $border_color);
        header("Content-Type:image/jpeg");
        imagejpeg($im);
        ImageDestroy($im);
	}
}
