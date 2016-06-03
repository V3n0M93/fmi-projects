<!doctype html>
<html>
<head>
	<link rel="stylesheet" href="../css/main.css">
     <meta charset="utf-8">
	<title>Система за класация на студенти</title>
</head>
<body>
	<div class="header">
		<img src="../data/img/header.gif" width="28%" />
		<div id="rectangle"></div>
		<div id="shape"></div>
	</div>

	<div class="menu">

	<?php
		session_start();
		if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]) {
			$menu = "<ul>
						<li><a href='add_student.php'>Добавяне на студенти</a></li>
						<li><a href='add_professor.php'>Добавяне на преподаватели</a></li>
						<li><a href='add_course.php'>Добавяне на курсове</a></li>
						<li><a href='enroll.php'>Записване на студенти</a></li>
						<li><a href='admin_logout.php'>Изход</a></li>
					</ul>";
			
		}
		else {
			$menu = "<ul>
						<li><a href='admin_login.php'>Вход</a></li>
					</ul>";
		}
		
		echo $menu;
	?>
	</div>

	<div class="data">