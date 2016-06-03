<?php 
	include 'header.php';
?>

<?php
	
	include 'library.php';
	$courses = www_library::courses();
	$html = "Няма намерени курсове";
	if (!empty($courses)){
		$year = substr($courses[0]["year"], 0, 4);
		$html = "<div id='courses'><table>
                    <tr class='year'><td>$year</td></tr>";
		foreach ($courses as $key => $course) {
			$course_year = substr($course["year"], 0, 4);
			if ($year != $course_year){
				$year = $course_year;
				$html .= "<tr class='year'><td>$year</td></tr>";
			}
			$html .= "<tr class='subject'><td><a href='view_course.php?id={$course['ID']}'>{$course['name']}</a></td></tr>";
		}
		$html .= "</table></div>";
	}
	echo $html;


?>


<?php
	include 'footer.php';
?>