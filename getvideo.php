<?php
//session_start();
//if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
//  header("location: /login");
//  exit;
//}
//* the code above can be used to restric access with php sessions

header('X-Frame-Options: SAMEORIGIN');
// for a little bit of security //

//check for cache params (optional)
if($_GET['cache']==false){
	header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
}else{ }


	//remove ../ from url to make more secure
	$filename=str_replace('../', '', $_GET['file']);

	//specify path from name (file path outside of public folder)
	$filepath="/video/".$filename;

	//if a file exists in url
	if(is_file($filepath)){
				
		$file = $filepath;
		$fp = @fopen($file, 'rb');
		$size = filesize($file); // File size
		$length = $size; // Content length
		$start = 0; // Start byte
		$end = $size - 1; // End byte
		header('Content-type: video/mp4');
		//header("Accept-Ranges: 0-$length");
		header("Accept-Ranges: bytes");
		if (isset($_SERVER['HTTP_RANGE'])) {
			$c_start = $start;
			$c_end = $end;
			list(, $range) = explode('=', $_SERVER['HTTP_RANGE'], 2);
			if (strpos($range, ',') !== false) {
				header('HTTP/1.1 416 Requested Range Not Satisfiable');
				header("Content-Range: bytes $start-$end/$size");
				exit;
			}
			
			if ($range == '-') {
				$c_start = $size - substr($range, 1);
			}else{
				$range = explode('-', $range);
				$c_start = $range[0];
				$c_end = (isset($range[1]) && is_numeric($range[1])) ? $range[1] : $size;
			}
			$c_end = ($c_end > $end) ? $end : $c_end;
			
			if ($c_start > $c_end || $c_start > $size - 1 || $c_end >= $size) {
				header('HTTP/1.1 416 Requested Range Not Satisfiable');
				header("Content-Range: bytes $start-$end/$size");
				exit;
			}
			$start = $c_start;
			$end = $c_end;
			$length = $end - $start + 1;
			fseek($fp, $start);
			header('HTTP/1.1 206 Partial Content');
		}
		header("Content-Range: bytes $start-$end/$size");
		header("Content-Length: ".$length);
		$buffer = 1024 * 8;
		while(!feof($fp) && ($p = ftell($fp)) <= $end) {
			if ($p + $buffer > $end) {
				$buffer = $end - $p + 1;
			}
			set_time_limit(0);
			echo fread($fp, $buffer);
			flush();
		}
		fclose($fp);
		exit();



		//if dir exists show file maneger
		}elseif (is_dir($filepath)) {

		?>
		<!-- File Browser -->
		<a href="../">Back</a>
		<hr />
		<?php echo numfilesindir($filepath, $filename); ?>
		<hr />
		<address>Server at Domain.com</address>
		<!-- File Browser end -->
		<?php
		}else{
			// -404- //
			show_404_page($filename);
			// -404- //
		}



//
// -- FUNCTIONS -- //
//

//file browser
function numfilesindir ($thedir, $path){
    if (is_dir($thedir)){
      $scanarray = scandir($thedir);
      for ($i = 0; $i < count($scanarray); $i++){
        if ($scanarray[$i] != "." && $scanarray[$i] != ".."){
					echo '<a href="'. '' .$scanarray[$i].'">'.$scanarray[$i].'</a><br />';
			}
      }
    } else {
      echo "Sorry, this directory does not exist.";
    }
}



//404 page
function show_404_page($path){
	header('HTTP/1.0 404 Not Found', true, 404);
	echo '
	<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
	<html><head>
	<title>404 Not Found</title>
	</head><body>
	<h1>Not Found</h1>
	<p>The requested File '.$path.' was not found on this server.</p>
	<hr>
	<address>Server at '.$_SERVER['HTTP_HOST'].' Port '.$_SERVER["SERVER_PORT"].'</address>
	</body></html>
	';
}
?>
