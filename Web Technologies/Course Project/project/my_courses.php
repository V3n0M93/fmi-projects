<?php 
    include 'header.php';
?>

<?php
    
    include 'library.php';
    $html = "Няма намерени курсове";
    
        $courses_data = Null;

        $profile_id = $_SESSION["id"];
        $lvl =  $_SESSION["security_lvl"];
        if ($lvl == 1){
            $courses_data = www_library::courses_by_student($profile_id);
        }
        if ($lvl == 2) {
            $courses_data = www_library::courses_by_professor($profile_id);
        }

        

    if (!empty($courses_data)){
        $year = substr($courses_data[0]["year"], 0, 4);
        $html = "<div id='courses'><table>
                    <tr class='year'><td>$year</td></tr>";
        foreach ($courses_data as $key => $course) {
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