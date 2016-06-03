<?php
	include 'header.php';
	include 'admin_functionality.php';
	if($_SESSION['security_lvl'] != -1)
	{
		echo '<META HTTP-EQUIV="refresh" content="0;URL=' . "index.php" . '">';
	}
	if (isset($_POST['name']) && isset($_POST['id']) && isset($_POST['title']) && isset($_POST['department'])
		&& isset($_POST['cabinet']) && isset($_POST['uname']) && isset($_POST['password'])) 
	{	
    	$result = admin_f::add_professor($_POST['name'], $_POST['id'], $_POST['title'], $_POST['department']
    		, $_POST['cabinet'], $_POST['uname'], $_POST['password']);
	}

?>
<div style="text-align:center">
    <div><form action="" method="post">
    <p>Име на преподавателя :</p> <input type="text" name="name" />
    <p>Факултетен номер:</p> <input type="text" name="id" />
    <p>Титла:</p> <input type="text" name="title" />
    <p>Департамент: </p><input type="text" name="department" />
    <p>Кабинет:</p> <input type="text" name="cabinet" />
    <p>Акаунт: </p><input type="text" name="uname" />
    <p>Парола: </p><input type="text" name="password" />
    <p><input type="submit"/></p>
    </form>
    </div>
<div>

<?php
    include 'footer.php';
?>