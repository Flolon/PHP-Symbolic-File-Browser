<?php
//session_start();
//if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
//  header("location: /benworld/login");
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
	$filepath="../protected/".$filename;

	//if a file exists in url
	if(is_file($filepath)){
		//get mime type of file
		$filetype=get_mime_type($filepath);
		//send header and file content
		header('Content-type: ' . $filetype);
		header('Content-Disposition: filename="'.basename($filename).'');
		echo file_get_contents($filepath);

		//if dir exists show file maneger
		}elseif (is_dir($filepath)) {

		?>
		<!-- File Browser -->
		<a href="../">Back</a>
		<hr />
		<?php echo numfilesindir($filepath, $filename); ?>
		<hr />
		<address>OneServer at Bunnbuns.net</address>
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

//MIME type from file
function get_mime_type($filename) {
    $idx = explode( '.', $filename );
    $count_explode = count($idx);
    $idx = strtolower($idx[$count_explode-1]);

    $mimet = array( 
        'txt' => 'text/plain',
        'htm' => 'text/html',
        'html' => 'text/html',
        'php' => 'text/html',
        'css' => 'text/css',
        'js' => 'application/javascript',
        'json' => 'application/json',
        'xml' => 'application/xml',
        'swf' => 'application/x-shockwave-flash',
        'flv' => 'video/x-flv',

        // images
        'png' => 'image/png',
        'jpe' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'jpg' => 'image/jpeg',
        'gif' => 'image/gif',
        'bmp' => 'image/bmp',
        'ico' => 'image/vnd.microsoft.icon',
        'tiff' => 'image/tiff',
        'tif' => 'image/tiff',
        'svg' => 'image/svg+xml',
        'svgz' => 'image/svg+xml',

        // archives
        'zip' => 'application/zip',
        'rar' => 'application/x-rar-compressed',
        'exe' => 'application/x-msdownload',
        'msi' => 'application/x-msdownload',
        'cab' => 'application/vnd.ms-cab-compressed',
		'apk' => 'application/vnd.android.package-archive',

        // audio/video
		'mp3' => 'audio/mp3',
        'mp3' => 'audio/mpeg',
        'qt' => 'video/quicktime',
		'mov' => 'video/quicktime',
		'mp4' => 'video/mp4',
		'avi' => 'video/x-msvideo',
		'wav' => 'audio/x-wav',
		'mpeg' => 'video/mpeg',
    	'mpg' => 'video/mpeg',
    	'ogg' => 'application/ogg',
		'webm' => 'video/webm',
    	'wma' => 'audio/x-ms-wma',
		'wmv' => 'video/x-ms-wmv',

        // adobe
        'pdf' => 'application/pdf',
        'psd' => 'image/vnd.adobe.photoshop',
        'ai' => 'application/postscript',
        'eps' => 'application/postscript',
        'ps' => 'application/postscript',

        // ms office
        'doc' => 'application/msword',
        'rtf' => 'application/rtf',
        'xls' => 'application/vnd.ms-excel',
        'ppt' => 'application/vnd.ms-powerpoint',
        'docx' => 'application/msword',
        'xlsx' => 'application/vnd.ms-excel',
        'pptx' => 'application/vnd.ms-powerpoint',
		
        // open office
        'odt' => 'application/vnd.oasis.opendocument.text',
        'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
    );

    if (isset( $mimet[$idx] )) {
     return $mimet[$idx];
    } else {
     return 'application/octet-stream';
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
	<address>OneServer at '.$_SERVER['HTTP_HOST'].' Port '.$_SERVER["SERVER_PORT"].'</address>
	</body></html>
	';
}
?>
