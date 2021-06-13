<?php

if ( ! function_exists('version'))
{
	function version($file){
		if(file_exists(realpath($file))){
			return base_url($file."?ver=".filectime(realpath($file)));
		}else{
			return $file;
		}
	}
}


/**
    回傳處理
**/
if ( ! function_exists('ReturnHandle'))
{
	function ReturnHandle($status,$msg='',$redirect=''){
        $ReturnHandle   =   ['status'   =>  $status,    'msg'   =>  $msg];
        if($redirect){
            $ReturnHandle['redirect']   =   $redirect;
        }
        return $ReturnHandle;
    }
}

    