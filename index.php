<?php
$allowed_formats = array_flip(array( "jpg", "jpeg", "png", "gif" ));
$dir = dirname(__FILE__);
$url = "http://". str_replace( array("//", "index.php"), array("/", ""), $_SERVER['HTTP_HOST']."/".$_SERVER['PHP_SELF']);
require_once $dir . DIRECTORY_SEPARATOR . "functions.php";
$folder = isset($_GET['folder'])?DIRECTORY_SEPARATOR.strip_tags($_GET['folder']):DIRECTORY_SEPARATOR;

$stack_folder = ( (substr($folder, 0, 1) == "/" )?substr($folder,1):$folder );
$folder_url = $url . $stack_folder;
$folder_thumb_url = $url . ( (substr($folder, 0, 1) == "/" )?substr($folder,1):$folder ) . "thumbs/";

$current_dir = $dir . $folder;
if( !is_dir( $current_dir ) )
{
	$current_dir = 	$dir . DIRECTORY_SEPARATOR;
}

//make thumb_dir
if( !is_dir($current_dir . "thumbs" ) )
{
	if( !mkdir($current_dir . "thumbs".DIRECTORY_SEPARATOR, 0755) )
	{
		
	}
}
$list = scandir($current_dir);
$exclude_from_list = array_flip(array(".", "..", "thumbs", "functions.php", "index.php", "_public"));


?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Gallery</title>

	<link rel="stylesheet" type="text/css" href="<?=$url?>_public/css/style.css" />    
    
    <!-- Arquivos utilizados pelo jQuery lightBox plugin -->
    <script type="text/javascript" src="<?=$url?>_public/js/jquery.js"></script>
    <script type="text/javascript" src="<?=$url?>_public/js/jquery.lightbox-0.5.js"></script>
    <link rel="stylesheet" type="text/css" href="<?=$url?>_public/css/jquery.lightbox-0.5.css" media="screen" />
    <!-- / fim dos arquivos utilizados pelo jQuery lightBox plugin -->
    
    <!-- Ativando o jQuery lightBox plugin -->
    <script type="text/javascript">
    $(function() {
        $('#gallery a.image').lightBox();
    });
    </script>
</head>

<body>
	<?php
	$folder_list = explode("/", $stack_folder);
	if( isset($folder_list[ count($folder_list)-3 ]) )
	{
		$tmp = ( (substr($stack_folder, -1) == "/" )?substr($stack_folder,0, -1):$stack_folder );
		?>
		<a class="back_dir" href="<?=$url."?folder=".substr($tmp, 0, strrpos(  $tmp , "/") ). "/"?>">BACK</a>
		<?php
	}
	else
	{
		?>
		<a class="back_dir" href="<?=$url?>">BACK</a>
		<?php
	}
	?>
<div id="gallery">
    <ul>
        
<?php
foreach($list as $cnt => $row)
{
	if(!isset($exclude_from_list[$row]))
	{
		if( is_dir($current_dir . $row) )
		{
			?>
			<li>
				<a href="<?=$url."?folder=".$stack_folder.$row."/"?>" class="dir">
					<?=$row?>
				</a>
			</li>
			<?php
		}
		else
		{
			$format = get_format( $row );
			if( isset($allowed_formats[strtolower($format)]) )
			{
				
				if( !file_exists( $current_dir . "thumbs" . DIRECTORY_SEPARATOR . $row ) )
				{
					$im = new imagick( $current_dir . $row );
					$im->cropThumbnailImage( 150, 150 );
					$im->writeImage(  $current_dir . "thumbs" . DIRECTORY_SEPARATOR . $row  );
				}
			?>
			<li>
				<a href="<?=$folder_url.$row?>" title="<?=$row?>" class="image">
					<img src="<?=$folder_thumb_url.$row?>" alt="" border="0" />
				</a>
			</li>
			<?php
			}
		}
		
		//echo $cnt . " $row <br />";	
	}
}
?>
	</ul>
</div>
</body>
</html>