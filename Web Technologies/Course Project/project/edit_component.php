<?php 
	include 'header.php';
?>


<!--  Display all components of the grade    -->
<?php
	include "library.php";
	$course_id = $_GET['course'];
	$component_id = $_GET['id'];
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
		$grades = www_library::evaluation_by_component_id($component_id);
		$html = "<p>Това е списък с оценките по избрания компонент. След промяна на стойностите натиснете бутона за да бъдат запазени новите оценки.</p>
				<form action='save_grades.php' method='post'>
				<input type='hidden' name='type' value='remove'>
				  <input type='hidden' name='component' value='$component_id'>
				  <input type='hidden' name='course' value='$course_id'>
				  <button>Изтрий компонента</button>

				</form>
		<form action='save_grades.php' method='post'>";
		foreach ($grades as $key => $grade) {
			$html .= "{$grade['s_id']} <input type='number' name='grades[{$grade['s_id']}]' value={$grade['points']}> </br>";
			}
		$html .= "<input type='hidden' name='type' value='edit'>
				  <input type='hidden' name='component' value='$component_id'>
				  <input type='hidden' name='course' value='$course_id'>
				  <button>Запази точките</button>
				  </form>";
		echo $html;	

	}
	else {
		echo "Нямате достъп до тази страница.";
	}


?>





<?php
	include 'footer.php';
?>