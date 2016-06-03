<?php
	include 'header.php';
	include 'admin_functionality.php';
	if($_SESSION['security_lvl'] != -1)
	{
		echo '<META HTTP-EQUIV="refresh" content="0;URL=' . "index.php" . '">';
	}
	if (isset($_POST['name']) && isset($_POST['id']) && isset($_POST['group_']) && isset($_POST['flow'])
		&& isset($_POST['subject']) && isset($_POST['semester']) && isset($_POST['uname']) && isset($_POST['password'])) 
	{	
    	$result = admin_f::add_student($_POST['name'], $_POST['id'], $_POST['group_'], $_POST['flow'],
    	$_POST['subject'], $_POST['semester'], $_POST['uname'], $_POST['password']);
	}
?>

<div style="text-align:center">
    <div><form action="" method="post">
    <p>Име на студента : </p><input type="text" name="name" />
    <p>Факултетен номер: </p><input type="text" name="id" />
    <p>Група: </p><input type="text" name="group_" />
    <p>Поток: </p><input type="text" name="flow" />
    <p>Специалност: </p><input type="text" name="subject" />
    <p>Семестър: </p><input type="text" name="semester" />
    <p>Акаунт: </p><input type="text" name="uname" />
    <p>Парола: </p><input type="text" name="password" />
    <p><input type="submit"/></p>
    </form>
    </div>
<div>

<?php
    include 'footer.php';
?>