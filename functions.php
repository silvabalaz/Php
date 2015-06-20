<?php

  require_once('config.php');

function autoSuggest($query)
{	
	$connect = mysql_connect("localhost","silvahab","s1be3Rh6P2");
mysql_select_db("silvahab_weather123",$connect);
      

	$sql = 'SELECT grad FROM popisGradova WHERE grad LIKE "%'.$query.'%" ';

	$result = mysql_query($sql, $connect) or die(mysql_error());
	$totalRows = mysql_num_rows($result);

	if($totalRows > 0)
{
	$items = '<ul class="grad">';
	while ($row = mysql_fetch_assoc($result))
	{
		$items .='<li>'.$row['grad'].'</li>';

	}
	$items .= '</ul>';
}
else
{
	$items = 'Taj grad nije u bazi.';

}
	echo $items;
}

?>
