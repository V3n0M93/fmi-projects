<?php
	include 'header.php';
	include 'admin_functionality.php';
	if($_SESSION['security_lvl'] != -1)
	{
		echo '<META HTTP-EQUIV="refresh" content="0;URL=' . "index.php" . '">';
	}
	if (isset($_POST['s_id']) && isset($_POST['c_id'])) 
	{	
    	$result = admin_f::enroll($_POST['s_id'], $_POST['c_id']);
	}
?>

<div style="text-align:center">
    <div><form action="" method="post">
    <p>Номер на студент: </p><input type="text" name="s_id" />
    <p>Номер на предмет: </p><input type="text" name="c_id" />
    <p><input type="submit"/></p>
    </form>
    </div>
</div>



<?php
    include 'footer.php';
?>