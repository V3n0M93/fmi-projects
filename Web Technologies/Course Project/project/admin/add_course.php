<?php
	include 'header.php';
	include 'admin_functionality.php';
	if($_SESSION['security_lvl'] != -1)
	{
		echo '<META HTTP-EQUIV="refresh" content="0;URL=' . "index.php" . '">';
	}
	if (isset($_POST['name']) && isset($_POST['id']) && isset($_POST['name_prof']) && isset($_POST['year'])
		&& isset($_POST['credits']) && isset($_POST['p_id']) && isset($_POST['spec']) && isset($_POST['semester'])
		&& isset($_POST['course'])) 
	{	
    	$result = admin_f::add_course($_POST['name'], $_POST['id'], $_POST['name_prof'], $_POST['year'],
    	$_POST['credits'], $_POST['p_id'], $_POST['spec'], $_POST['semester'], $_POST['course']);
	}
?>

<div style="text-align:center">
    <div><form action="" method="post">
    <p>Име на предмета : </p><input type="text" name="name" />
    <p>Вътрешен номер: </p><input type="text" name="id" />
    <p>Име на преподавател: </p><input type="text" name="name_prof" />
    <p>Година: </p><input type="text" name="year" />
    <p>Кредити: </p><input type="text" name="credits" />
    <p>ФН на преподавател: </p><input type="text" name="p_id" />
    <p>Специалност: </p><input type="text" name="spec" />
    <p>Семестър: </p><input type="text" name="semester" />
    <p>Курс: </p><input type="text" name="course" />
    <p><input type="submit"/></p>
    </form>
    </div>
<div>

<?php
    include 'footer.php';
?>