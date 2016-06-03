<?php 
	include 'header.php';
?>

<!-- content goes here -->
<!-- show course information -->
<?php
	$course_id = $_GET["id"];
    $group = NULL;
    $days = NULL;

	include 'library.php';
	$courses = www_library::courses();
	$course_data = NULL;
	$html = "Не е намерен такъв курс.";
	foreach ($courses as $key => $course) {
		if ($course["ID"] == $course_id){
			$course_data = $course;
		}
	}
	#do all the following things if the course has been found in the database
	if (!is_null($course_data)){
		$teacher_id = $course_data['p_id'];
		$teacher_data = www_library::professor_info(intval($teacher_id));
		$year = substr($course_data["year"], 0, 4);
		$html = "<div class='course-info'>
					<h1>{$course_data['name']}</h1>
    				<a href='profile.php?id={$course_data['p_id']}'><h2> {$teacher_data[0]['title']} {$course_data['name_prof']}</h2><a>
   					 <i>Кредити:</i> {$course_data['credits']}<br>
   					 <i>Специалност:</i> {$course_data['spec']}<br>
   					 <i>Курс:</i> {$course_data['course']}<br>
    				<i>Семестър:</i> {$course_data['semester']}<br>
    				<i>Година:</i> $year<br>
				</div>";
	

		echo $html;

		$course_name = $course_data["name"];


		#show button for editing the grades
        if (isset($_SESSION['id'])){
		$user_id = $_SESSION['id'];
    

		if ($teacher_id == $user_id) {
			$html = "<div class='edit_profile_button'>
					<a href='edit_course_grades.php?id=$course_id'>
					<button>Добави компонент</button>
					</a></div>";
			echo $html;
			
		}

}
		#show past years -->
		$all_courses = www_library::course_id_by_name($course_name);
		$html = "";
		foreach ($all_courses as $key => $course) {
			#add css style
            if ($year != $course['year']){
			$html .= "<a href='view_course.php?id={$course['id']}'>{$course['year']}</a> ";}
		}
        if ($html != ""){
            $html = "Курсове от други години: " .$html;
        }
		echo $html;


        echo "<div class='rankings'><h1>Класация на студентите от курса.</h1>";


		#show filter
		$groups = www_library::get_groups($course_id);
		//$groups["group_"]
		$html = "<form method='post' action='view_course.php?id=$course_id'>
				Филтър на резултатите <select name = 'group'>
				    <option value='0'>Всички</option>";

        foreach ($groups as $key => $group_id) {
            $html .= "<option value='{$group_id['group_']}'>{$group_id['group_']}</option>";
        }
        $html .= "</select>
                  За последние <input type='number' min='0' name = 'days'> дена.
                  <input type='submit' value='Филтрирай' />
                    </form>";
		#generate post form
        echo $html;

		#show rankings

		if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if ($_POST["group"] > 0){
                $group = $_POST["group"];
            }
            if (isset($_POST["days"]) && $_POST["days"] > 0) {
                $days = $_POST["days"];

            }
			
		}


		$points = www_library::points_by_group($course_id,$group,$days);
		$rankings_table = "<div id='rank'><table><thead><tr><td>№</td><td></td><td>ФН</td><td>Име</td><td>Група</td><td>Точки</td></tr></thead><tbody>";
        $place = 1;
        $counter = 0;
        $last_points = -1;
		foreach ($points as $key => $data) {
            $counter++;
            if ($data['0'] != $last_points){
                $place = $counter;
                $last_points = $data['0'];

            }
			$rankings_table .= "<tr>
                                <td>$place</td>
                                <td><img src='data/avatars/$key.jpg' 
								onerror=\"this.src='data/avatars/default.jpg'\" 
								width='40px' height='40px'/></td>
								<td>{$data[2]}</td>
								<td class='name'><a href='profile.php?id={$data[2]}'>{$data[1]}</a></td>
								<td>{$data[3]}</td>
								<td>{$data[0]}</td></tr>";
		}
		$rankings_table .= "</tbody></table></div>";
		echo $rankings_table;

}
	
?>
<?php
	include 'footer.php';
?>