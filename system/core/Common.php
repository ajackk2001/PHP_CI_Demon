<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2016, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2016, British Columbia Institute of Technology (http://bcit.ca/)
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	https://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Common Functions
 *
 * Loads the base classes and executes the request.
 *
 * @package		CodeIgniter
 * @subpackage	CodeIgniter
 * @category	Common Functions
 * @author		EllisLab Dev Team
 * @link		https://codeigniter.com/user_guide/
 */

// ------------------------------------------------------------------------

if ( ! function_exists('is_php'))
{
	/**
	 * Determines if the current version of PHP is equal to or greater than the supplied value
	 *
	 * @param	string
	 * @return	bool	TRUE if the current version is $version or higher
	 */
	function is_php($version)
	{
		static $_is_php;
		$version = (string) $version;

		if ( ! isset($_is_php[$version]))
		{
			$_is_php[$version] = version_compare(PHP_VERSION, $version, '>=');
		}

		return $_is_php[$version];
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('is_really_writable'))
{
	/**
	 * Tests for file writability
	 *
	 * is_writable() returns TRUE on Windows servers when you really can't write to
	 * the file, based on the read-only attribute. is_writable() is also unreliable
	 * on Unix servers if safe_mode is on.
	 *
	 * @link	https://bugs.php.net/bug.php?id=54709
	 * @param	string
	 * @return	bool
	 */
	function is_really_writable($file)
	{
		// If we're on a Unix server with safe_mode off we call is_writable
		if (DIRECTORY_SEPARATOR === '/' && (is_php('5.4') OR ! ini_get('safe_mode')))
		{
			return is_writable($file);
		}

		/* For Windows servers and safe_mode "on" installations we'll actually
		 * write a file then read it. Bah...
		 */
		if (is_dir($file))
		{
			$file = rtrim($file, '/').'/'.md5(mt_rand());
			if (($fp = @fopen($file, 'ab')) === FALSE)
			{
				return FALSE;
			}

			fclose($fp);
			@chmod($file, 0777);
			@unlink($file);
			return TRUE;
		}
		elseif ( ! is_file($file) OR ($fp = @fopen($file, 'ab')) === FALSE)
		{
			return FALSE;
		}

		fclose($fp);
		return TRUE;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('load_class'))
{
	/**
	 * Class registry
	 *
	 * This function acts as a singleton. If the requested class does not
	 * exist it is instantiated and set to a static variable. If it has
	 * previously been instantiated the variable is returned.
	 *
	 * @param	string	the class name being requested
	 * @param	string	the directory where the class should be found
	 * @param	string	an optional argument to pass to the class constructor
	 * @return	object
	 */
	function &load_class($class, $directory = 'libraries', $param = NULL)
	{
		static $_classes = array();

		// Does the class exist? If so, we're done...
		if (isset($_classes[$class]))
		{
			return $_classes[$class];
		}

		$name = FALSE;

		// Look for the class first in the local application/libraries folder
		// then in the native system/libraries folder
		foreach (array(APPPATH, BASEPATH) as $path)
		{
			if (file_exists($path.$directory.'/'.$class.'.php'))
			{
				$name = 'CI_'.$class;

				if (class_exists($name, FALSE) === FALSE)
				{
					require_once($path.$directory.'/'.$class.'.php');
				}

				break;
			}
		}

		// Is the request a class extension? If so we load it too
		if (file_exists(APPPATH.$directory.'/'.config_item('subclass_prefix').$class.'.php'))
		{
			$name = config_item('subclass_prefix').$class;

			if (class_exists($name, FALSE) === FALSE)
			{
				require_once(APPPATH.$directory.'/'.$name.'.php');
			}
		}

		// Did we find the class?
		if ($name === FALSE)
		{
			// Note: We use exit() rather than show_error() in order to avoid a
			// self-referencing loop with the Exceptions class
			set_status_header(503);
			echo 'Unable to locate the specified class: '.$class.'.php';
			exit(5); // EXIT_UNK_CLASS
		}

		// Keep track of what we just loaded
		is_loaded($class);

		$_classes[$class] = isset($param)
			? new $name($param)
			: new $name();
		return $_classes[$class];
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('is_loaded'))
{
	/**
	 * Keeps track of which libraries have been loaded. This function is
	 * called by the load_class() function above
	 *
	 * @param	string
	 * @return	array
	 */
	function &is_loaded($class = '')
	{
		static $_is_loaded = array();

		if ($class !== '')
		{
			$_is_loaded[strtolower($class)] = $class;
		}

		return $_is_loaded;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('get_config'))
{
	/**
	 * Loads the main config.php file
	 *
	 * This function lets us grab the config file even if the Config class
	 * hasn't been instantiated yet
	 *
	 * @param	array
	 * @return	array
	 */
	function &get_config(Array $replace = array())
	{
		static $config;

		if (empty($config))
		{
			$file_path = APPPATH.'config/config.php';
			$found = FALSE;
			if (file_exists($file_path))
			{
				$found = TRUE;
				require($file_path);
			}

			// Is the config file in the environment folder?
			if (file_exists($file_path = APPPATH.'config/'.ENVIRONMENT.'/config.php'))
			{
				require($file_path);
			}
			elseif ( ! $found)
			{
				set_status_header(503);
				echo 'The configuration file does not exist.';
				exit(3); // EXIT_CONFIG
			}

			// Does the $config array exist in the file?
			if ( ! isset($config) OR ! is_array($config))
			{
				set_status_header(503);
				echo 'Your config file does not appear to be formatted correctly.';
				exit(3); // EXIT_CONFIG
			}
		}

		// Are any values being dynamically added or replaced?
		foreach ($replace as $key => $val)
		{
			$config[$key] = $val;
		}

		return $config;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('config_item'))
{
	/**
	 * Returns the specified config item
	 *
	 * @param	string
	 * @return	mixed
	 */
	function config_item($item)
	{
		static $_config;

		if (empty($_config))
		{
			// references cannot be directly assigned to static variables, so we use an array
			$_config[0] =& get_config();
		}

		return isset($_config[0][$item]) ? $_config[0][$item] : NULL;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('get_mimes'))
{
	/**
	 * Returns the MIME types array from config/mimes.php
	 *
	 * @return	array
	 */
	function &get_mimes()
	{
		static $_mimes;

		if (empty($_mimes))
		{
			if (file_exists(APPPATH.'config/'.ENVIRONMENT.'/mimes.php'))
			{
				$_mimes = include(APPPATH.'config/'.ENVIRONMENT.'/mimes.php');
			}
			elseif (file_exists(APPPATH.'config/mimes.php'))
			{
				$_mimes = include(APPPATH.'config/mimes.php');
			}
			else
			{
				$_mimes = array();
			}
		}

		return $_mimes;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('is_https'))
{
	/**
	 * Is HTTPS?
	 *
	 * Determines if the application is accessed via an encrypted
	 * (HTTPS) connection.
	 *
	 * @return	bool
	 */
	function is_https()
	{
		if ( ! empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off')
		{
			return TRUE;
		}
		elseif (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && strtolower($_SERVER['HTTP_X_FORWARDED_PROTO']) === 'https')
		{
			return TRUE;
		}
		elseif ( ! empty($_SERVER['HTTP_FRONT_END_HTTPS']) && strtolower($_SERVER['HTTP_FRONT_END_HTTPS']) !== 'off')
		{
			return TRUE;
		}

		return FALSE;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('is_cli'))
{

	/**
	 * Is CLI?
	 *
	 * Test to see if a request was made from the command line.
	 *
	 * @return 	bool
	 */
	function is_cli()
	{
		return (PHP_SAPI === 'cli' OR defined('STDIN'));
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('show_error'))
{
	/**
	 * Error Handler
	 *
	 * This function lets us invoke the exception class and
	 * display errors using the standard error template located
	 * in application/views/errors/error_general.php
	 * This function will send the error page directly to the
	 * browser and exit.
	 *
	 * @param	string
	 * @param	int
	 * @param	string
	 * @return	void
	 */
	function show_error($message, $status_code = 500, $heading = 'An Error Was Encountered')
	{
		$status_code = abs($status_code);
		if ($status_code < 100)
		{
			$exit_status = $status_code + 9; // 9 is EXIT__AUTO_MIN
			if ($exit_status > 125) // 125 is EXIT__AUTO_MAX
			{
				$exit_status = 1; // EXIT_ERROR
			}

			$status_code = 500;
		}
		else
		{
			$exit_status = 1; // EXIT_ERROR
		}

		$_error =& load_class('Exceptions', 'core');
		echo $_error->show_error($heading, $message, 'error_general', $status_code);
		exit($exit_status);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('show_404'))
{
	/**
	 * 404 Page Handler
	 *
	 * This function is similar to the show_error() function above
	 * However, instead of the standard error template it displays
	 * 404 errors.
	 *
	 * @param	string
	 * @param	bool
	 * @return	void
	 */
	function show_404($page = '', $log_error = TRUE)
	{
		$_error =& load_class('Exceptions', 'core');
		$_error->show_404($page, $log_error);
		exit(4); // EXIT_UNKNOWN_FILE
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('log_message'))
{
	/**
	 * Error Logging Interface
	 *
	 * We use this as a simple mechanism to access the logging
	 * class and send messages to be logged.
	 *
	 * @param	string	the error level: 'error', 'debug' or 'info'
	 * @param	string	the error message
	 * @return	void
	 */
	function log_message($level, $message)
	{
		static $_log;

		if ($_log === NULL)
		{
			// references cannot be directly assigned to static variables, so we use an array
			$_log[0] =& load_class('Log', 'core');
		}

		$_log[0]->write_log($level, $message);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('set_status_header'))
{
	/**
	 * Set HTTP Status Header
	 *
	 * @param	int	the status code
	 * @param	string
	 * @return	void
	 */
	function set_status_header($code = 200, $text = '')
	{
		if (is_cli())
		{
			return;
		}

		if (empty($code) OR ! is_numeric($code))
		{
			show_error('Status codes must be numeric', 500);
		}

		if (empty($text))
		{
			is_int($code) OR $code = (int) $code;
			$stati = array(
				100	=> 'Continue',
				101	=> 'Switching Protocols',

				200	=> 'OK',
				201	=> 'Created',
				202	=> 'Accepted',
				203	=> 'Non-Authoritative Information',
				204	=> 'No Content',
				205	=> 'Reset Content',
				206	=> 'Partial Content',

				300	=> 'Multiple Choices',
				301	=> 'Moved Permanently',
				302	=> 'Found',
				303	=> 'See Other',
				304	=> 'Not Modified',
				305	=> 'Use Proxy',
				307	=> 'Temporary Redirect',

				400	=> 'Bad Request',
				401	=> 'Unauthorized',
				402	=> 'Payment Required',
				403	=> 'Forbidden',
				404	=> 'Not Found',
				405	=> 'Method Not Allowed',
				406	=> 'Not Acceptable',
				407	=> 'Proxy Authentication Required',
				408	=> 'Request Timeout',
				409	=> 'Conflict',
				410	=> 'Gone',
				411	=> 'Length Required',
				412	=> 'Precondition Failed',
				413	=> 'Request Entity Too Large',
				414	=> 'Request-URI Too Long',
				415	=> 'Unsupported Media Type',
				416	=> 'Requested Range Not Satisfiable',
				417	=> 'Expectation Failed',
				422	=> 'Unprocessable Entity',
				426	=> 'Upgrade Required',
				428	=> 'Precondition Required',
				429	=> 'Too Many Requests',
				431	=> 'Request Header Fields Too Large',

				500	=> 'Internal Server Error',
				501	=> 'Not Implemented',
				502	=> 'Bad Gateway',
				503	=> 'Service Unavailable',
				504	=> 'Gateway Timeout',
				505	=> 'HTTP Version Not Supported',
				511	=> 'Network Authentication Required',
			);

			if (isset($stati[$code]))
			{
				$text = $stati[$code];
			}
			else
			{
				show_error('No status text available. Please check your status code number or supply your own message text.', 500);
			}
		}

		if (strpos(PHP_SAPI, 'cgi') === 0)
		{
			header('Status: '.$code.' '.$text, TRUE);
		}
		else
		{
			$server_protocol = isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.1';
			header($server_protocol.' '.$code.' '.$text, TRUE, $code);
		}
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('_error_handler'))
{
	/**
	 * Error Handler
	 *
	 * This is the custom error handler that is declared at the (relative)
	 * top of CodeIgniter.php. The main reason we use this is to permit
	 * PHP errors to be logged in our own log files since the user may
	 * not have access to server logs. Since this function effectively
	 * intercepts PHP errors, however, we also need to display errors
	 * based on the current error_reporting level.
	 * We do that with the use of a PHP error template.
	 *
	 * @param	int	$severity
	 * @param	string	$message
	 * @param	string	$filepath
	 * @param	int	$line
	 * @return	void
	 */
	function _error_handler($severity, $message, $filepath, $line)
	{
		$is_error = (((E_ERROR | E_PARSE | E_COMPILE_ERROR | E_CORE_ERROR | E_USER_ERROR) & $severity) === $severity);

		// When an error occurred, set the status header to '500 Internal Server Error'
		// to indicate to the client something went wrong.
		// This can't be done within the $_error->show_php_error method because
		// it is only called when the display_errors flag is set (which isn't usually
		// the case in a production environment) or when errors are ignored because
		// they are above the error_reporting threshold.
		if ($is_error)
		{
			set_status_header(500);
		}

		// Should we ignore the error? We'll get the current error_reporting
		// level and add its bits with the severity bits to find out.
		if (($severity & error_reporting()) !== $severity)
		{
			return;
		}

		$_error =& load_class('Exceptions', 'core');
		$_error->log_exception($severity, $message, $filepath, $line);

		// Should we display the error?
		if (str_ireplace(array('off', 'none', 'no', 'false', 'null'), '', ini_get('display_errors')))
		{
			$_error->show_php_error($severity, $message, $filepath, $line);
		}

		// If the error is fatal, the execution of the script should be stopped because
		// errors can't be recovered from. Halting the script conforms with PHP's
		// default error handling. See http://www.php.net/manual/en/errorfunc.constants.php
		if ($is_error)
		{
			exit(1); // EXIT_ERROR
		}
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('_exception_handler'))
{
	/**
	 * Exception Handler
	 *
	 * Sends uncaught exceptions to the logger and displays them
	 * only if display_errors is On so that they don't show up in
	 * production environments.
	 *
	 * @param	Exception	$exception
	 * @return	void
	 */
	function _exception_handler($exception)
	{
		$_error =& load_class('Exceptions', 'core');
		$_error->log_exception('error', 'Exception: '.$exception->getMessage(), $exception->getFile(), $exception->getLine());

		is_cli() OR set_status_header(500);
		// Should we display the error?
		if (str_ireplace(array('off', 'none', 'no', 'false', 'null'), '', ini_get('display_errors')))
		{
			$_error->show_exception($exception);
		}

		exit(1); // EXIT_ERROR
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('_shutdown_handler'))
{
	/**
	 * Shutdown Handler
	 *
	 * This is the shutdown handler that is declared at the top
	 * of CodeIgniter.php. The main reason we use this is to simulate
	 * a complete custom exception handler.
	 *
	 * E_STRICT is purposively neglected because such events may have
	 * been caught. Duplication or none? None is preferred for now.
	 *
	 * @link	http://insomanic.me.uk/post/229851073/php-trick-catching-fatal-errors-e-error-with-a
	 * @return	void
	 */
	function _shutdown_handler()
	{
		$last_error = error_get_last();
		if (isset($last_error) &&
			($last_error['type'] & (E_ERROR | E_PARSE | E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_COMPILE_WARNING)))
		{
			_error_handler($last_error['type'], $last_error['message'], $last_error['file'], $last_error['line']);
		}
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('remove_invisible_characters'))
{
	/**
	 * Remove Invisible Characters
	 *
	 * This prevents sandwiching null characters
	 * between ascii characters, like Java\0script.
	 *
	 * @param	string
	 * @param	bool
	 * @return	string
	 */
	function remove_invisible_characters($str, $url_encoded = TRUE)
	{
		$non_displayables = array();

		// every control character except newline (dec 10),
		// carriage return (dec 13) and horizontal tab (dec 09)
		if ($url_encoded)
		{
			$non_displayables[] = '/%0[0-8bcef]/i';	// url encoded 00-08, 11, 12, 14, 15
			$non_displayables[] = '/%1[0-9a-f]/i';	// url encoded 16-31
		}

		$non_displayables[] = '/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]+/S';	// 00-08, 11, 12, 14-31, 127

		do
		{
			$str = preg_replace($non_displayables, '', $str, -1, $count);
		}
		while ($count);

		return $str;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('html_escape'))
{
	/**
	 * Returns HTML escaped variable.
	 *
	 * @param	mixed	$var		The input string or array of strings to be escaped.
	 * @param	bool	$double_encode	$double_encode set to FALSE prevents escaping twice.
	 * @return	mixed			The escaped string or array of strings as a result.
	 */
	function html_escape($var, $double_encode = TRUE)
	{
		if (empty($var))
		{
			return $var;
		}

		if (is_array($var))
		{
			foreach (array_keys($var) as $key)
			{
				$var[$key] = html_escape($var[$key], $double_encode);
			}

			return $var;
		}

		return htmlspecialchars($var, ENT_QUOTES, config_item('charset'), $double_encode);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('_stringify_attributes'))
{
	/**
	 * Stringify attributes for use in HTML tags.
	 *
	 * Helper function used to convert a string, array, or object
	 * of attributes to a string.
	 *
	 * @param	mixed	string, array, object
	 * @param	bool
	 * @return	string
	 */
	function _stringify_attributes($attributes, $js = FALSE)
	{
		$atts = NULL;

		if (empty($attributes))
		{
			return $atts;
		}

		if (is_string($attributes))
		{
			return ' '.$attributes;
		}

		$attributes = (array) $attributes;

		foreach ($attributes as $key => $val)
		{
			$atts .= ($js) ? $key.'='.$val.',' : ' '.$key.'="'.$val.'"';
		}

		return rtrim($atts, ',');
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('function_usable'))
{
	/**
	 * Function usable
	 *
	 * Executes a function_exists() check, and if the Suhosin PHP
	 * extension is loaded - checks whether the function that is
	 * checked might be disabled in there as well.
	 *
	 * This is useful as function_exists() will return FALSE for
	 * functions disabled via the *disable_functions* php.ini
	 * setting, but not for *suhosin.executor.func.blacklist* and
	 * *suhosin.executor.disable_eval*. These settings will just
	 * terminate script execution if a disabled function is executed.
	 *
	 * The above described behavior turned out to be a bug in Suhosin,
	 * but even though a fix was commited for 0.9.34 on 2012-02-12,
	 * that version is yet to be released. This function will therefore
	 * be just temporary, but would probably be kept for a few years.
	 *
	 * @link	http://www.hardened-php.net/suhosin/
	 * @param	string	$function_name	Function to check for
	 * @return	bool	TRUE if the function exists and is safe to call,
	 *			FALSE otherwise.
	 */
	function function_usable($function_name)
	{
		static $_suhosin_func_blacklist;

		if (function_exists($function_name))
		{
			if ( ! isset($_suhosin_func_blacklist))
			{
				$_suhosin_func_blacklist = extension_loaded('suhosin')
					? explode(',', trim(ini_get('suhosin.executor.func.blacklist')))
					: array();
			}

			return ! in_array($function_name, $_suhosin_func_blacklist, TRUE);
		}

		return FALSE;
	}
}


/**
--------------------------------------------------------------------------
 * 自訂義函數區
--------------------------------------------------------------------------
 */

/**
 * [格式印出陣列資訊]
 * @param  [type] $arr [陣列]
 */
function p($arr)
{
	echo "<pre>";
	print_r($arr);
	echo "</pre>";
}

//=================================================== 
//========    成功跳頁    ============================
//=================================================//

function redirect_url($url){
	echo "<script>";
	echo "window.parent.frames.location.replace('".$url."');";
	echo "</script>";
}

//=================================================== 
//========    圖片檔名縮圖    =========================
//=================================================//
/**
 * @param  [type] 上傳類型 [1]兩張圖 [2]三張圖  [description]
 */
function img_name_explode($img)
{
	if(!empty($img)){
		$img = explode('.', $img);
		$img_ch[0] = $img[0].'_thumb_s.'.$img[1];	//S圖
		$img_ch[1] = $img[0].'_thumb_m.'.$img[1];	//M圖
	}else{
		$img_ch[0] = '';
		$img_ch[1] = '';

	}
	return $img_ch; 
}

//=================================================== 
//========    判断是否Ajax请求    =====================
//=================================================//
function is_ajax_request(){
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
    {
        return true;
    }
    else
    {
        return false;
    }
}
//=================================================== 
//========    網址判斷是否加http    ====================
//=================================================//
function Webhttp($URL)
{
	$exStr=explode("//",$URL);
	if ( isset( $_SERVER["HTTPS"] ) && strtolower( $_SERVER["HTTPS"] ) == "on" ) {
		//若沒輸入https://
		if(empty($exStr[1])){
			 $URL = "https://".$exStr[0];
		}
	}else{
		//若沒輸入http://
		if(empty($exStr[1])){
			 $URL = "http://".$exStr[0];
		}
	}
			
	return $URL;
}
//=================================================== 
//========    截取文字[utf8專用]    ===================
//=================================================//

function cutstr($cut_str,$cut_len,$delhtml){
	
	//去掉html
	if(!empty($delhtml)){
		$cut_str = strip_tags($cut_str);	
	}
	
	//移除前後空白字
	$cut_str = trim($cut_str);
		
	//移除重覆的空白
	$cut_str = preg_replace('/\s(?=\s)/', '', $cut_str);
	
	//移除非空白的間距變成一般的空白
	$cut_str = preg_replace('/[\n\r\t]/', ' ', $cut_str); 
	
	//截取文字
    $lenx=0;
    $strx="";
    for($i=0;$i < mb_strlen($cut_str,"utf-8");$i++){
        if(mb_strlen(mb_substr($cut_str,$i,1,"utf-8"),"utf-8") == strlen(mb_substr($cut_str,$i,1,"utf-8"))){
            $lenx += 0.5;
        }else{
            $lenx += 1;
        }
        if($lenx < $cut_len){
            $strx .= mb_substr($cut_str,$i,1,"utf-8");
        }
    }
    if($lenx > $cut_len){
        $strx .= "...";
    }
    return $strx;
}

//=================================================== 
//========    ip顯示    ==============================
//=================================================//
function ip_show($ip_add)
{
	if($ip_add == '::1'){
		$ip = '127.0.0.1';
	}else{
		$ip = $ip_add;
	}

	return $ip;
}

//=================================================== 
//========    為空處理    ============================
//=================================================//
function emptydata($str)
{
	if(empty($str)){
		$str_ch = '---';
	}else{
		$str_ch = $str;
	}
	return $str_ch;
}

//=================================================== 
//========    會員類型秀出    =========================
//=================================================//
/**
 * 會員類型秀出
 * @param  $member_type_id [類型id]
 * @param  $show_type      [秀出類型ex圖示or文字]
 */
function member_type($member_type_id,$show_type) {
    if($show_type == 'image'){
        switch ($member_type_id){
        //一般會員
        case 1:  
            echo '<i class="icon-user"></i>';
            break;
        //facebook 會員
        case 2:
            echo '<i class="zmdi zmdi-facebook"></i>';
            break;
        //google 會員
        case 3:
            echo '<i class="zmdi zmdi-google-glass"></i>';
            break;
        default:
        	echo '';
        break;
        }
    }
}
//=================================================== 
//========    產品價格顯示    =========================
//=================================================//
/**
 * 產品價格顯示
 * @param [type] $web_price [網路價]
 * @param [type] $new_price [優惠價]
 * @param [type] $type      [秀出類型] [1]後台產品清單 [2]訂單內頁購買清單 [3]只秀金額計算用 [4]前台商品清單頁 [5]前台商品內頁
 */
function product_price_show($price_web,$price_discount,$type)
{

    if($type == 1){
        if(!empty(number_format($price_discount))){
            $price_show = $price_discount.'元 <span class="text-pink">[優惠價]</span>';
        }else{
            $price_show = $price_web.'元 <span class="text-custom">[網路價]</span>';
        }
    }else
    if($type == 2){
        if(!empty(number_format($price_discount))){
            $price_show = number_format($price_discount).'元 <span class="text-pink">[優惠價]</span>';
        }else{
            $price_show = number_format($price_web).'元 <span class="text-custom">[網路價]</span>';
        }
    }else
    if($type == 3){	//只秀金額
        if(!empty(number_format($price_discount))){
            $price_show = number_format($price_discount);
        }else{
            $price_show = number_format($price_web);
        }    	
    }else
    if($type == 4){	//首頁,產品頁
        if(!empty(number_format($price_discount))){
            $price_show = '<span class="indexProductPriceLine">NT '.$price_web.'</span><span class="indexProductPriceSale fontColorR">NT '.$price_discount.'</span>';
        }else{
            $price_show = 'NT '.$price_web;
        }       	
    }else 
    if($type == 5){	//商品內頁
        if(!empty(number_format($price_discount))){
        	$price_show = '<div class="productDetailPriceOri">網路價 NT.'.number_format($price_web).'</div>';
        	$price_show .='<div class="productDetailPrice">優惠價<span>NT.'.number_format($price_discount).'</span></div>';
        }else{
            $price_show = '<div class="productDetailPrice">網路價<span>NT.'.number_format($price_web).'</span></div>';
        }
    }else
    if($type == 6){
    	if(!empty(number_format($price_discount))){
    		$price_show = '<span class="productTopPriceLine">NT '.$price_web.'</span><br>';
    		$price_show.= '<span class="productTopPriceSale fontColorR">NT '.$price_discount.'</span>';
    	}else{
    		$price_show = 'NT '.$price_web;
    	}
    }


    return $price_show;
}

//=================================================== 
//========    產品價格類型（購物車清單）    ==============
//=================================================//
function price_type($price_web,$price_discount)
{
	//優惠價
	if(!empty($price_discount)){
		$price_type_ch = 1;
	}
	//網路價	
	else{
		$price_type_ch = 0;
	}

	return $price_type_ch;
}



//=================================================== 
//========    訂單狀態顏色顯示    ======================
//=================================================//

function orders_status_label($orders_status)
{

	switch ($orders_status) {
		case '訂單成立':
		case '進行退貨':
		case '進行換貨':
			return 'label label-warning';
			break;
		case '付款完成':
			return 'label label-danger';
			break;
		case '完成出貨':
		case '退貨完成':
		case '換貨完成':
			return 'label label-info';
			break;
		case '訂單完成':
			return 'label label-success';
			break;
		case '付款期限已過':
			return 'label label-default';
			break;	
		default:
			return 'label label-warning';
			break;	
	}
}

//=================================================== 
//========    訂單狀態變更按紐    ======================
//=================================================//
/**
 * @param  [type] $orders_status [訂單狀態]
 * @param  [type] $payment       [付款方式]
 * @param  [type] $shipment      [配送方式]
 */
function orders_status_btn($orders_status,$payment_id,$shipment_id,$orders_id='')
{
	$btn_show ='';	
	
	//訂單狀態[1]等待付款
	if($orders_status == 1){
		//付款方式[5]貨到付款
		if($payment_id == 5){
			$btn_show = ' <a class="btn_ship" href="javascript:;"><span class="label label-info">進行出貨</span></a> ';
		}
	}else 
	//訂單狀態[2]付款成功
	if($orders_status == 2){
		//配送方式[4]現場取貨
		if($shipment_id == 4){
			$btn_show = ' <a class="btn_get_finish" href="javascript:;"><span class="label label-success">完成取貨</span></a> ';
		}else{
			$btn_show = '<a class="btn_ship" href="javascript:;"><span class="label label-info">進行出貨</span></a>';
		}
	}else
	//訂單狀態[3]完成出貨
	if($orders_status == 3){
		//付款方式[5]貨到付款
		if($payment_id == 5){
			$btn_show = ' <a class="btn_pback_finish" href="javascript:;"><span class="label label-success">確認回款</span></a> ';
		}else{
			$url_return = site_url('admin/orders/return_page?id='.$orders_id.'&type=return');
			$url_change = site_url('admin/orders/return_page?id='.$orders_id.'&type=change');
			$btn_show .= ' <a href="javascript:;" onclick="new_windows(\''.$url_return.'\',\'1200\',\'700\');"><span class="label label-info">進行退貨</span></a> ';
			$btn_show .= ' <a href="javascript:;" onclick="new_windows(\''.$url_change.'\',\'1200\',\'700\');"><span class="label label-info">進行換貨</span></a> ';
			$btn_show .= ' <a class="btn_finish" href="javascript:;"><span class="label label-success">訂單結單</span></a> ';
			$btn_show .= ' <a data-toggle="tooltip" data-placement="left" title="若確認此訂單鑑賞期已過，即可進行訂單完成" href="javascript:;" ><i class="ion-information-circled"></i>';
		}
	}else
	//訂單狀態[6]進行退貨
	if($orders_status == 6){
		$btn_show = ' <a class="btn_return_finish" href="javascript:;"><span class="label label-success">退貨退款完成</span></a>';
	}else
	//訂單狀態[8]進行換貨
	if($orders_status == 8){
		$btn_show = ' <a class="btn_change_finish" href="javascript:;"><span class="label label-success">換貨完成</span></a>';
	}else
	//訂單狀態 [5]退款完成 [7]退貨退款完成 [9]換貨完成 [10]回款完成 [11]完成取貨
	if(in_array($orders_status,array('5','7','10','11'),true)){
		$btn_show .= '<a class="btn_finish" href="javascript:;"><span class="label label-success">訂單結單</span></a>';
		$btn_show .= ' <a data-toggle="tooltip" data-placement="left" title="若確認此訂單鑑賞期已過，即可進行訂單完成" href="javascript:;" ><i class="ion-information-circled"></i>';
	}

	
	return $btn_show;

}

//=================================================== 
//========    網站關鍵字優化    ========================
//=================================================//

function website_seo($title,$keywords_text="",$description_text="",$image="",$webname_add="")
{	
	//實例化Codeigniter資源
	$CI = & get_instance();
	//載入網站資訊
	$CI->load->model('website_model','website');
	$website    	= $CI->website->get_web_info();	//網站基本資訊

	$website_url 		= "http://".$_SERVER['HTTP_HOST'];
	$website_keyword 	= $website['keyword'];										//關鍵字
	$website_description= $website['description'];								//關鍵字描述
	$website_title_chen = $website['title_ch']." ".$website['title_en'];		//網站中英文名稱
		
	//網頁抬頭
	if(empty($title)){
		$webname_all    = $website_title_chen;
	}else{
		$webname_all    = $title."-".$website_title_chen;
	}
	
	//關鍵字
	if(empty($keywords_text)){
		if(empty($title)){
			$keywords_ch    = $website_keyword;
		}else{
			$keywords_ch    = $title.",".$website_keyword;
		}
	}else{
		if(empty($title)){
			$keywords_ch    = $keywords_text;
		}else{
			$keywords_ch    = $title.",".$keywords_text;
		}
	}
	
	//網站描述
	if(empty($description_text)){
		if(empty($title)){
			$description_ch    = $website_description;
		}else{
			$description_ch    = $title.",".$website_description;
		}
	}else{
		if(empty($title)){
			$description_ch    = $description_text;
		}else{
			$description_ch    = $title.",".$description_text;
		}
	}

	//圖片
	if(empty($image))
	{
		$image_ch = $website_url."/style/images/apple_touch_icon.png";
	}else
	{
		$image_ch = $website_url."/uploads/".$image;
	}
	
	//完整網址
	if(empty($webname_add)){
		$webname_addch = $website_url;
	}else{
		$webname_addch = $website_url.$webname_add;
	}

	//-----------------     秀出資料處理     -----------------//
	
	$show_seo ="<title>".$webname_all."</title>\n";
	$show_seo.="<meta name='keywords' content='".$keywords_ch."'>\n";
	$show_seo.="<meta name='description' content='".$description_ch."' >\n";
	$show_seo.="<meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no'>\n";
	$show_seo.="<meta property='og:title' content='".$webname_all."'>\n";
	$show_seo.="<meta property='og:url' content='".$webname_addch."'>\n";
	$show_seo.="<meta property='og:image' content='".$image_ch."'>\n";
	$show_seo.="<meta property='og:site_name' content='".$webname_all."'/>\n";
	$show_seo.="<meta property='og:description' content='".$description_ch."'>\n";
	$show_seo.="<link type='image/x-icon' rel='shortcut icon'  href='".$website_url."/style/favicon.ico'>\n";
	$show_seo.="<link rel='apple-touch-icon' href='".$website_url."/style/front/images/apple_touch_icon.png'>\n";
	return $show_seo;
	
}

//=================================================== 
//========    手機號碼確認    ========================
//=================================================//

//驗證號碼是否正確的Function(傳入手機號碼，回傳true/false)
function CheckCellPhone($CellPhoneNumber)
{
	//錯誤旗標
	$errorCounter=0;

	//過濾空白
	$CellPhoneNumber = str_replace(" ","",$CellPhoneNumber);

	//是否空白(沒有號碼)
	if( empty($CellPhoneNumber) )$errorCounter++;

	//過濾 - 
	$CellPhoneNumber = str_replace("-","",$CellPhoneNumber);

	//驗證是否全是半形數字
	if( !CheckIsNumber($CellPhoneNumber) )$errorCounter++;

	//驗證是否10碼
	if( strlen($CellPhoneNumber) != 10 )$errorCounter++;

	//驗證前兩碼是否為09
	if( substr($CellPhoneNumber,0,2) != "09" )$errorCounter++;

	if( $errorCounter == 0 )
	{
		return true;
	}
	else
	{
		return false;
	}
}
//驗證是否為數值
function CheckIsNumber($number)
{
	//錯誤旗標
	$errorCounter=0;

	//數值陣列
	$NumberArray=array ("0","1","2","3","4","5","6","7","8","9");

	for( $i=0 ; $i<strlen($number) ; $i++ )
	{
		$aa = substr($number,$i,1);

		if( !in_array( $aa , $NumberArray))$errorCounter++;
	}

	//回傳結果
	if( $errorCounter==0 )return true;
	else return false;
}

//=================================================== 
//========    產生亂數    =============================
//=================================================//

function random_numbers($limit)
{
    $password_len = $limit;
    $password = '';
    $word = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $len = strlen($word);
    for ($i = 0; $i < $password_len; $i++) {
        $password .= $word[rand() % $len];
    }
    return $password;
}

//=================================================== 
//========    檔案修改時間    =========================
//=================================================//

function modified($real_file_path){
	
    if (is_file($real_file_path)){
        $link = '?v='.filemtime($real_file_path);
	}
    return $link;
	
}

