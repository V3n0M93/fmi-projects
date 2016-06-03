<?php 
	include 'header.php';
?>


<!--  Display all components of the grade    -->
<?php
	include "library.php";
	$course_id = $_GET['id'];
	$user_id = $_SESSION['id'];

	#check if the course is taught by the logged in user.
	$correct_user = false;
	$courses_of_user = www_library::courses_by_professor($user_id);
	foreach ($courses_of_user as $key => $course) {
		if ($course['ID'] == $course_id){
			$correct_user = true;
		}
	}

	if ($correct_user){
		$components = www_library::components_by_course_id($course_id);

		$html = "<p>Това е списъка с компонентите на курса.</p>
				 <ul>";
		foreach ($components as $key => $component) {
			$html .= "<li><a href='edit_component.php?id={$component['ID']}&course=$course_id'>{$component['name']}</a></li>";
		}
		$html .= "</ul>
				  <p><a href='add_component.php?course=$course_id'>Добави нов компонент.</a></p>";
		echo $html;	

	}
	else {
		echo "Нямате достъп до тази страница.";
	}


?>





<?php
	include 'footer.php';
?>