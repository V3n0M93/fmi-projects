<?php

class www_library
{
  //Information for the student by ID (input INT)(return array)
  public static function student_info($id)
  {
    $con=mysqli_connect("localhost","root","","studentrank");
    mysqli_query($con, "SET CHARACTER SET utf8");
    mysqli_query($con, "SET NAMES utf8");
    $table ="students";
    $sql="select * from $table where id = $id";
    $result = mysqli_query($con,$sql);
    if(!$result)
    { echo "Table not found ";}
    $post = array();
    while($row = $result->fetch_assoc())
    {
      $post[] = $row;
    }
    mysqli_close($con);
    return $post;
  }


  //Information for the professor by ID (input INT)(return array)
  public static function professor_info($id)
  {
    $con=mysqli_connect("localhost","root","","studentrank");
    mysqli_query($con, "SET CHARACTER SET utf8");
    mysqli_query($con, "SET NAMES utf8");
    $table ="professors";
    $sql="select * from $table where id = $id";
    $result = mysqli_query($con,$sql);
    if(!$result)
    { echo "Table not found ";}
    $post = array();
    while($row = $result->fetch_assoc())
    {
      $post[] = $row;
    }
    mysqli_close($con);
    return $post;
  }


  //The points of all the students in all courses combined (return array)
  public static function points_all()
  {
    $con=mysqli_connect("localhost","root","","studentrank");
    mysqli_query($con, "SET CHARACTER SET utf8");
    mysqli_query($con, "SET NAMES utf8");
    $table ="students";
    $sql="select * from $table";
    $result = mysqli_query($con,$sql);
    if(!$result)
    { echo "Table not found ";}
    $names = array();
    while($row = $result->fetch_assoc())
    {
      $temp = $row['id'];
      if (!isset($names[$temp])) 
      {
        $names[$temp] = null;
      }
      $names[$temp] = $row['name'];
    }

    $table ="evaluation";
    $sql="select * from $table";
    $result = mysqli_query($con,$sql);
    if(!$result)
    { echo "Table not found ";}
    $post = array();
    while($row = $result->fetch_assoc())
    {
      $temp = $row['s_id'];
      if (!isset($post[$temp])) 
      {
        $post[$temp] = null;
      }
      $post[$temp] = array($post[$temp][0] + $row['points'], $names[$temp]) ;
    }
    mysqli_close($con);
    arsort($post);
    return $post;
  }


  //Information for the courses (return array)
  public static function courses()
  {
    $con=mysqli_connect("localhost","root","","studentrank");
    mysqli_query($con, "SET CHARACTER SET utf8");
    mysqli_query($con, "SET NAMES utf8");
    $table ="course";
    $sql="select * from $table";
    $result = mysqli_query($con,$sql);
    if(!$result)
    { echo "Table not found ";}
    $post = array();
    while($row = $result->fetch_assoc())
    {
      $post[] = $row;
    }
    mysqli_close($con);
    usort($post, function($a, $b) {
    return $b['year'] - $a['year'];
    });
    return $post;
  }
  

  //The points of all the students in all courses combined for the selected year (input INT) (return array)
  function points_by_year($year)
  {
    $con=mysqli_connect("localhost","root","","studentrank");
    mysqli_query($con, "SET CHARACTER SET utf8");
    mysqli_query($con, "SET NAMES utf8");
    $table ="students";
    $sql="select * from $table";
    $result = mysqli_query($con,$sql);
    if(!$result)
    { echo "Table not found ";}
    $names = array();
    while($row = $result->fetch_assoc())
    {
      $temp = $row['id'];
      if (!isset($names[$temp])) 
      {
        $names[$temp] = null;
      }
      $names[$temp] = $row['name'];
    }

    $table ="evaluation";
    $sql="select * from $table where comp_id in (select ID from components where c_id in 
      (select id from course where $year in (select YEAR (date) from course)))";
    $result = mysqli_query($con,$sql);
    if(!$result)
    { echo "Table not found ";}
    $post = array();
    while($row = $result->fetch_assoc())
    {
      $temp = $row['s_id'];
      if (!isset($post[$temp])) 
      {
        $post[$temp] = null;
      }
      $post[$temp] = array($post[$temp][0] + $row['points'], $names[$temp]) ;
    }
    mysqli_close($con);
    arsort($post);
    return $post;
  }
  

  //Function to add new component (input INT, INT, STR, DATE) (return array)
  public static function add_component($c_id,$name,$date)
  {
    $con=mysqli_connect("localhost","root","","studentrank");
    mysqli_query($con, "SET CHARACTER SET utf8");
    mysqli_query($con, "SET NAMES utf8");
    $table ="components";
    $sql="insert into $table (name, c_id, date) VALUES ('$name', $c_id, '$date')";
    $id = NULL;
    if (mysqli_query($con, $sql)) {
    
      $id = mysqli_insert_id($con);
    }
    else {
    echo "Error: " . $sql . "<br>" . mysqli_error($con);
    }
    mysqli_close($con);
    return $id;
  }
  

  //Function to add points to a component (input INT, INT, INT) (return array)
  public static function add_points($s_id, $comp_id, $points)
  {
    $con=mysqli_connect("localhost","root","","studentrank");
    mysqli_query($con, "SET CHARACTER SET utf8");
    mysqli_query($con, "SET NAMES utf8");
    $table ="evaluation";
    $sql="insert into $table VALUES ($s_id, $comp_id, $points)";
    if (!mysqli_query($con, $sql)) {
    echo "Error: " . $sql . "<br>" . mysqli_error($con);

    }
    mysqli_close($con);
  }
  

  //Function to change points to a component (input INT, INT, INT) (return array)
  public static function change_points($s_id, $comp_id, $points)
  {
    $con=mysqli_connect("localhost","root","","studentrank");
    mysqli_query($con, "SET CHARACTER SET utf8");
    mysqli_query($con, "SET NAMES utf8");
    $table ="evaluation";
    $sql="update $table set points = $points where s_id = $s_id and comp_id = $comp_id";
    if (!mysqli_query($con, $sql)) {
    echo "Error: " . $sql . "<br>" . mysqli_error($con);
    }
    mysqli_close($con);
  }


  //Function to add points to a component (input INT, INT, INT) (return array)
  public static function students_by_course($c_id)
  {
    $con=mysqli_connect("localhost","root","","studentrank");
    mysqli_query($con, "SET CHARACTER SET utf8");
    mysqli_query($con, "SET NAMES utf8");
    $table_1 = "enrolment";
    $table_2 = "students";
    $sql="select students.name, students.id, students.group_, students.flow from $table_2
          inner join $table_1 on enrolment.s_id = students.id
          where enrolment.c_id = $c_id";
    $result = mysqli_query($con,$sql);
    if(!$result)
    { echo "Table not found ";}
    $post = array();
    while($row = $result->fetch_assoc())
    {
      $post[] = $row;
    }
    mysqli_close($con);
    return $post;
  }


  //All the courses attended by a student (input INT) (return array)
  public static function courses_by_student($s_id)
  {
    $con=mysqli_connect("localhost","root","","studentrank");
    mysqli_query($con, "SET CHARACTER SET utf8");
    mysqli_query($con, "SET NAMES utf8");
    $table_1 = "enrolment";
    $table_2 = "course";
    $sql="select enrolment.c_id as ID, course.name, course.year from $table_2
          inner join $table_1 on enrolment.c_id = course.ID
          where enrolment.s_id = $s_id";
    $result = mysqli_query($con,$sql);
    if(!$result)
    { echo "Table not found ";}
    $post = array();
    while($row = $result->fetch_assoc())
    {
      $post[] = $row;
    }
    usort($post, function($a, $b) {
    return $b['year'] - $a['year'];
    });
    mysqli_close($con);
    return $post;
  }


  //All the points assigned in a course (input INT) (return array)
  public static function points_by_course_id($id)
  {
    $con=mysqli_connect("localhost","root","","studentrank");
    mysqli_query($con, "SET CHARACTER SET utf8");
    mysqli_query($con, "SET NAMES utf8");
    $table ="students";
    $sql="select * from $table";
    $result = mysqli_query($con,$sql);
    if(!$result)
    { echo "Table not found ";}
    $names = array();
    while($row = $result->fetch_assoc())
    {
      $temp = $row['id'];
      if (!isset($names[$temp])) 
      {
        $names[$temp] = null;
      }
      $names[$temp] = $row['name'];
    }
    $table ="evaluation";
    $sql="select * from $table where comp_id in (select ID from components where c_id in 
      (select id from course where id=$id))";
    $result = mysqli_query($con,$sql);
    if(!$result)
    { echo "Table not found ";}
    $post = array();
    while($row = $result->fetch_assoc())
    {
      $temp = $row['s_id'];
      if (!isset($post[$temp])) 
      {
        $post[$temp] = null;
      }
      $post[$temp] = array($post[$temp][0] + $row['points'], $names[$temp]) ;
    }
    mysqli_close($con);
    return $post;
  }


  //The points of all the students in all courses combined for the selected month (input INT) (return array)
  public static function points_by_month($month)
  {
    $con=mysqli_connect("localhost","root","","studentrank");
    mysqli_query($con, "SET CHARACTER SET utf8");
    mysqli_query($con, "SET NAMES utf8");
    $table ="students";
    $sql="select * from $table";
    $result = mysqli_query($con,$sql);
    if(!$result)
    { echo "Table not found ";}
    $names = array();
    while($row = $result->fetch_assoc())
    {
      $temp = $row['id'];
      if (!isset($names[$temp])) 
      {
        $names[$temp] = null;
      }
      $names[$temp] = $row['name'];
    }

    $table ="evaluation";
    $sql="select * from $table where comp_id in (select ID from components where c_id in 
      (select id from course where $month in (select MONTH (date) from course)))";
    $result = mysqli_query($con,$sql);
    if(!$result)
    { echo "Table not found ";}
    $post = array();
    while($row = $result->fetch_assoc())
    {
      $temp = $row['s_id'];
      if (!isset($post[$temp])) 
      {
        $post[$temp] = null;
      }
      $post[$temp] = array($post[$temp][0] + $row['points'], $names[$temp]) ;
    }
    mysqli_close($con);
    arsort($post);
    return $post;
  }


  //The points of all the students a course (input STR) (return array)
  public static function points_by_course_name($name)
  {
    $con=mysqli_connect("localhost","root","","studentrank");
    mysqli_query($con, "SET CHARACTER SET utf8");
    mysqli_query($con, "SET NAMES utf8");
    $table ="students";
    $sql="select * from $table";
    $result = mysqli_query($con,$sql);
    if(!$result)
    { echo "Table not found ";}
    $names = array();
    while($row = $result->fetch_assoc())
    {
      $temp = $row['id'];
      if (!isset($names[$temp])) 
      {
        $names[$temp] = null;
      }
      $names[$temp] = $row['name'];
    }
    $table ="evaluation";
    $sql="select * from $table where comp_id in (select ID from components where c_id in 
      (select id from course where name = '$name'))";
    $result = mysqli_query($con,$sql);
    if(!$result)
    { echo "Table not found ";}
    $post = array();
    while($row = $result->fetch_assoc())
    {
      $temp = $row['s_id'];
      if (!isset($post[$temp])) 
      {
        $post[$temp] = null;
      }
      $post[$temp] = array($post[$temp][0] + $row['points'], $names[$temp]) ;
    }
    mysqli_close($con);
    return $post;
  }


  //The points of all the students in all courses combined for the selected day (input INT) (return array)
  public static function points_by_day($day)
  {
    $con=mysqli_connect("localhost","root","","studentrank");
    mysqli_query($con, "SET CHARACTER SET utf8");
    mysqli_query($con, "SET NAMES utf8");
    $table ="students";
    $sql="select * from $table";
    $result = mysqli_query($con,$sql);
    if(!$result)
    { echo "Table not found ";}
    $names = array();
    while($row = $result->fetch_assoc())
    {
      $temp = $row['id'];
      if (!isset($names[$temp])) 
      {
        $names[$temp] = null;
      }
      $names[$temp] = $row['name'];
    }

    $table ="evaluation";
    $sql="select * from $table where comp_id in (select ID from components where c_id in 
      (select id from course where $day in (select DAY (date) from course)))";
    $result = mysqli_query($con,$sql);
    if(!$result)
    { echo "Table not found ";}
    $post = array();
    while($row = $result->fetch_assoc())
    {
      $temp = $row['s_id'];
      if (!isset($post[$temp])) 
      {
        $post[$temp] = null;
      }
      $post[$temp] = array($post[$temp][0] + $row['points'], $names[$temp]) ;
    }
    mysqli_close($con);
    arsort($post);
    return $post;
  }


  //Function to return the course id by name (input STR) (return array)
  function course_id_by_name($name)
  {
    $con=mysqli_connect("localhost","root","","studentrank");
    mysqli_query($con, "SET CHARACTER SET utf8");
    mysqli_query($con, "SET NAMES utf8");
    $table = "course";
    $sql="select course.id, YEAR(course.year) as year from course where course.name = '$name'";
    $result = mysqli_query($con,$sql);
    if(!$result)
    { echo "Table not found ";}
    $post = array();
    while($row = $result->fetch_assoc())
    {
      $post[] = $row;
    }
    mysqli_close($con);
    return $post;
  }


  //Courses led by selected professor (input INT) (return array)
  public static function courses_by_professor($p_id)
  {
    $con=mysqli_connect("localhost","root","","studentrank");
    mysqli_query($con, "SET CHARACTER SET utf8");
    mysqli_query($con, "SET NAMES utf8");
    $table_1 = "professors";
    $table_2 = "course";
    $sql="select course.ID, course.name, course.year from $table_2
          inner join $table_1 on professors.id = course.p_id
          where professors.id = $p_id";
    $result = mysqli_query($con,$sql);
    if(!$result)
    { echo "Table not found ";}
    $post = array();
    while($row = $result->fetch_assoc())
    {
      $post[] = $row;
    }
    usort($post, function($a, $b) {
    return $b['year'] - $a['year'];
    });
    mysqli_close($con);
    return $post;
  }


  //The points of all the students in a course by group for the last x days(input INT, INT, INT) (return array)
  public static function points_by_group($course_id, $group = NULL, $date = NULL)
  {
    $con=mysqli_connect("localhost","root","","studentrank");
    mysqli_query($con, "SET CHARACTER SET utf8");
    mysqli_query($con, "SET NAMES utf8");
    $table_1 = "enrolment";
    $table_2 = "students";
    $table_3 = "course";
    $table_4 = "components";
    $table_5 = "evaluation";
    if($group != NULL)
    {
      if($date == NULL)
      {
        $sql="select evaluation.points, students.name, students.id, students.group_, students.flow from $table_2
        inner join $table_1 on enrolment.s_id = students.id
        inner join $table_3 on course.id = enrolment.c_id
        inner join $table_4 on components.c_id = course.ID
        inner join $table_5 on evaluation.comp_id = components.ID and evaluation.s_id = students.id
        where students.group_ = $group and course.ID = $course_id";
      }
      else
      {
        $sql="select evaluation.points, students.name, students.id, students.group_, students.flow from $table_2
        inner join $table_1 on enrolment.s_id = students.id
        inner join $table_3 on course.id = enrolment.c_id
        inner join $table_4 on components.c_id = course.ID
        inner join $table_5 on evaluation.comp_id = components.ID and evaluation.s_id = students.id
        where students.group_ = $group and course.ID = $course_id and components.date >= date_sub(now(), interval $date day)";
      }
    }
    else
    {
      if($date == NULL)
      {
        $sql="select evaluation.points, students.name, students.id, students.group_, students.flow from $table_2
        inner join $table_1 on enrolment.s_id = students.id
        inner join $table_3 on course.id = enrolment.c_id
        inner join $table_4 on components.c_id = course.ID
        inner join $table_5 on evaluation.comp_id = components.ID and evaluation.s_id = students.id
        where course.ID = $course_id";
      }
      else
      {
        $sql="select evaluation.points, students.name, students.id, students.group_, students.flow from $table_2
        inner join $table_1 on enrolment.s_id = students.id
        inner join $table_3 on course.id = enrolment.c_id
        inner join $table_4 on components.c_id = course.ID
        inner join $table_5 on evaluation.comp_id = components.ID and evaluation.s_id = students.id
        where course.ID = $course_id and components.date >= date_sub(now(), interval $date day)";
      }
    }
    $result = mysqli_query($con,$sql);
    if(!$result)
    { echo "Table not found ";}
    $post = array();
    while($row = $result->fetch_assoc())
    {
      $temp = $row['id'];
      if (!isset($post[$temp])) 
      {
        $post[$temp] = null;
      }
      $post[$temp] = array($post[$row['id']][0] + $row['points'], $row['name'], $row['id'], $row['group_']) ;
    }
    mysqli_close($con);
    usort($post, function($a, $b) {
    return $b[0] - $a[0];});
    return $post;
  }


  //All the components by course id (input INT) (return array)
  public static function components_by_course_id($course_id)
  {
    $con=mysqli_connect("localhost","root","","studentrank");
    mysqli_query($con, "SET CHARACTER SET utf8");
    mysqli_query($con, "SET NAMES utf8");
    $table = "components";
    $sql="select * from $table
        where $course_id = components.c_id";

    $result = mysqli_query($con,$sql);
    if(!$result)
    { echo "Table not found ";}
    $post = array();
    while($row = $result->fetch_assoc())
    {
      $post[] = $row;
    }
    mysqli_close($con);
    return $post;
  }


  //Evaluation of a component by id (input INT) (return array)
  public static function evaluation_by_component_id($component_id)
  {
    $con=mysqli_connect("localhost","root","","studentrank");
    mysqli_query($con, "SET CHARACTER SET utf8");
    mysqli_query($con, "SET NAMES utf8");
    $table = "evaluation";
    $sql="select * from $table
        where $component_id = evaluation.comp_id";

    $result = mysqli_query($con,$sql);
    if(!$result)
    { echo "Table not found ";}
    $post = array();
    while($row = $result->fetch_assoc())
    {
      $post[] = $row;
    }
    mysqli_close($con);
    return $post;
  }


  //Delete component by id (input IND)
  public static function delete_component_by_id($c_id)
  {
    $con=mysqli_connect("localhost","root","","studentrank");
    mysqli_query($con, "SET CHARACTER SET utf8");
    mysqli_query($con, "SET NAMES utf8");
    $table_1 = "components";
    $table_2 = "evaluation";
    $sql="delete from $table_1   
    where components.ID = $c_id";
    $result = mysqli_query($con,$sql);
    $sql="delete from $table_2   
    where evaluation.comp_id = $c_id";
    $result = mysqli_query($con,$sql);
    mysqli_close($con);
  }



  //Get all groups in course by id (input INT) (return array)
  public static function get_groups($c_id)
  {
    $con=mysqli_connect("localhost","root","","studentrank");
    mysqli_query($con, "SET CHARACTER SET utf8");
    mysqli_query($con, "SET NAMES utf8");
    $table_1 = "enrolment";
    $table_2 = "students";
    $sql="select distinct students.group_ from $table_2
        inner join $table_1 on enrolment.s_id = students.id
        where enrolment.c_id = $c_id";
    $result = mysqli_query($con,$sql);
    if(!$result)
    { echo "Table not found ";}
    $post = array();
    while($row = $result->fetch_assoc())
    {
      $post[] = $row;
    } 
    mysqli_close($con);
    return $post;
  }
}

?>


