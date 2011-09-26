<?php
function dbg($what)
{
	echo "<div style='clear:both;'></div><pre style='display:block; border:solid #000000 1px; background-color:#FFFFFF; color:#000000; font-size:12px;'>";
	var_dump($what);
	echo "</pre><div style='clear:both;'></div>";
}

function get_format( $file_name )
{
	return substr(strrchr($file_name,'.'),1);
}
?>