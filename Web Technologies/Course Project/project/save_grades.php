<?php 
	include 'header.php';
?>


<!--  Display all components of the grade    -->
<?php
	include "library.php";
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		#handle the addition of new grades
		if ($_POST['type'] == "add"){

			$grades = $_POST["grades"];
			$course = $_POST["course"];
			$name = $_POST["component_name"];
			
        	$date = date("Y-m-d");

			$component = www_library::add_component($course,$name,$date);

			foreach ($grades as $fn => $grade) {
				www_library::add_points($fn, $component, $grade);
			}
			

			echo "Оценките бяха добавени успешно.</br>";
			echo "<a href='view_course.php?id=$course'>Върни се обратно към курса.</a>";

		}





		#handle the edition of existing grades
		if ($_POST["type"] == "edit"){
			$grades = $_POST["grades"];
			$component = $_POST["component"];
			$course = $_POST["course"];
			foreach ($grades as $fn => $grade) {
				www_library::change_points($fn, $component, $grade);
			}
			echo "Оценките бяха променени успешно.</br>";
			echo "<a href='view_course.php?id=$course'>Върни се обратно към курса.</a>";
		}

			if ($_POST["type"] == "remove"){
			$component = $_POST["component"];
			$course = $_POST["course"];
			www_library::delete_component_by_id($component);
			echo "Оценките бяха променени успешно.</br>";
			echo "<a href='view_course.php?id=$course'>Върни се обратно към курса.</a>";
		}





	}
	else {
		echo "Нямате достъп до тази страница.";
	}

?>





<?php
	include 'footer.php';
?>