<?php 
	include 'header.php';
?>

<?php
	$picture = "'data/avatars/80796.jpg'";
	$name = "Цветан Генов Коев";
	$fn = 80796;
	$bachelor = "Компютърни науки";
	$course = 4;
?>


    

	<?php
		include 'library.php';
		$profile_data = Null;
		$html = "Не беше намерен такъв профил.";

		$profile_id = $_GET["id"];
		
		//Check if there is a student with that ID and generate the info HTML
		$profile_data = www_library::student_info($profile_id);
		if (!empty($profile_data)){
			$profile_data = $profile_data[0];
			$html = "<div id='avatar'>
					<img src='data/avatars/{$profile_data["id"]}.jpg' onerror=\"this.src='data/avatars/default.jpg'\" />
					</div>";

			$html .= "<i>Име:</i> {$profile_data["name"]}<br>
		    		<i>Факултетен номер:</i> {$profile_data["id"]}<br>
		    		<i>Специалност:</i> {$profile_data['subject']}<br>
		    		<i>Група:</i> {$profile_data['group_']}<br>
		    		<i>Поток:</i> {$profile_data['flow']}<br>
		    		<i>Семестър:</i> {$profile_data['semester']}<br>";
		}
		//Check if there is a teacher with that ID and generate the info HTML
		$profile_data = www_library::professor_info($profile_id);
		if (!empty($profile_data)){
				$profile_data = $profile_data[0];
				$html = "<div id='avatar'>
					<img src='data/avatars/{$profile_data["id"]}.jpg' onerror=\"this.src='data/avatars/default.jpg'\" />
					</div>";

				$html .= "<i>Име:</i> {$profile_data["name"]}<br>
		    	<i>Научна степен:</i> {$profile_data["title"]}<br>
		    	<i>Катедра:</i> {$profile_data['department']}<br>
		    	<i>Кабинет:</i> {$profile_data['cabinet']}<br>";
		    }
		

		

		if (isset($_SESSION["id"]) && $profile_id == $_SESSION["id"]) {
		$html .= "<div class='edit_profile_button'>
					<form action='edit_profile.php' method='post' enctype='multipart/form-data'>
						<input type='hidden' name='id' value='{$profile_id}'>
						<button>Редактиране на профила</button>
					</form>
				</div>";
		
	}
	echo $html;
	?>


<?php
	include 'footer.php';
?>