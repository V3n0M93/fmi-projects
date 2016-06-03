<?php 
	include 'header.php';
?>


<!--  Display all components of the grade    -->
<?php
	include "library.php";
	$course_id = $_GET['course'];
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
		$students = www_library::students_by_course($course_id);
		$html = "<p>Попълнете формуляра за да добавите компонента.</p>
				 <form action='save_grades.php' method='post'>
				 Име: <input type='text' name='component_name'> </br>";
		foreach ($students as $key => $student) {
			$html .= "{$student['id']} <input type='number' name='grades[{$student['id']}]'> </br>";
			# code...
		}
		$html .= "<input type='hidden' name='type' value='add'>
				  <input type='hidden' name='course' value='$course_id'>
				  <button>Submit</button>
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