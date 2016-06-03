<!doctype html>
<html>
<head>
	<link rel="stylesheet" href="css/main.css">
     <meta charset="utf-8">
	<title>Система за класация на студенти</title>
</head>
<body>
	<div class="header">
		<img src="data/img/header.gif" width="28%" />
		<div id="rectangle"></div>
		<div id="shape"></div>
	</div>

	<div class="menu">

	<?php
		session_start();
		if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]) {
			$profile_id = $_SESSION["id"];
			$menu = "<ul>
						<li><a href='my_courses.php'>Моите курсове</a></li>
						<li><a href='courses.php'>Всички курсове</a></li>
						<li><a href='rankings.php'>Класация</a></li>
						<li><a href='profile.php?id={$profile_id}'>Моят профил</a></li>
						<li><a href='logout.php'>Изход</a></li>
					</ul>";
			
		}
		else {
			$menu = "<ul>
						<li><a href='login.php'>Вход</a></li>

						<li><a href='rankings.php'>Класация</a></li>
						<li><a href='courses.php'>Всички курсове</a></li>
					</ul>";
		}
		
		echo $menu;
	?>
	</div>

	<div class="data">