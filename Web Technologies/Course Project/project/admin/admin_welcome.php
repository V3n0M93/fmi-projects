<?php
	include 'header.php';
	if($_SESSION['security_lvl'] != -1)
	{
		echo '<META HTTP-EQUIV="refresh" content="0;URL=' . "index.php" . '">';
	}
	include 'footer.php';
?>