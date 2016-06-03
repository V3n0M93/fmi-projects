<div class="menu">

	<?php
		session_start();
		if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]) {
			$menu = "<ul>
						<li>Моите курсове</li>
						<li>Всички курсове</li>
						<li>Моят профил</li>
						<li>Изход</li>
					</ul>";
			
		}
		else {
			$menu = "<ul>
						<li>Вход</li>
					</ul>";
		}
		echo $menu;
	?>
</div>

<div class="data">