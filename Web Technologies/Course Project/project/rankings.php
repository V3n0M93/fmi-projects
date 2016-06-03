<?php
	include "header.php";
?>

<h1>Класация на всички студенти</h1>
<p>Това е класация на всичките студенти учили във ФМИ. Ако се интересувате от класации по индивидуални предмети,
 можете да ги видите на страницата на съответния курс.</p>

<?php


	include 'library.php';
	$points = www_library::points_all();
		$rankings_table = "<div id='rank'><table><thead><tr><td>№</td><td></td><td>ФН</td><td>Име</td><td>Точки</td></tr></thead><tbody>";
        $place = 0;
        $counter = 0;
        $last_points = -1;
		foreach ($points as $key => $data) {
            $counter++;
            if ($data['0'] != $last_points){
                $place++;
                $last_points = $data['0'];

            }

			$rankings_table .= "<tr>
								<td>$place</td>
								<td><img src='data/avatars/$key.jpg' 
								onerror=\"this.src='data/avatars/default.jpg'\" 
								width='40px' height='40px'/></td>
								<td>$key</td>
								<td class='name'><a href='profile.php?id=$key'>{$data[1]}</a></td>
								<td>{$data[0]}</td></tr>";
		}
		$rankings_table .= "</tbody></table></div>";
		echo $rankings_table;






	include 'footer.php';

?>