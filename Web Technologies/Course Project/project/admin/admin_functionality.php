<?php
class admin_f
{
  //Function to add new student
  public static function add_student($name,$id,$group_,$flow,$subject,$semester,$uname,$password)
  {
    $con=mysqli_connect("localhost","root","","studentrank");
    mysqli_query($con, "SET CHARACTER SET utf8");
    mysqli_query($con, "SET NAMES utf8");
    $table_1 = "users";
    $table_2 = "students";
    $sql="insert into $table_1 (uname, password, security_lvl, id) VALUES ('$uname', '$password', 1, $id)";
    mysqli_query($con, $sql);
    $sql="insert into $table_2 (name, id, group_, flow, subject, semester) VALUES ('$name', $id, $group_, $flow, '$subject', $semester)";
    mysqli_query($con, $sql);
    mysqli_close($con);
  }


  //Function to add new professor
  public static function add_professor($name,$id,$title,$department,$cabinet,$uname,$password)
  {
    $con=mysqli_connect("localhost","root","","studentrank");
    mysqli_query($con, "SET CHARACTER SET utf8");
    mysqli_query($con, "SET NAMES utf8");
    $table_1 = "users";
    $table_2 = "professors";
    $sql="insert into $table_1 (uname, password, security_lvl, id) VALUES ('$uname', '$password', 2, $id)";
    mysqli_query($con, $sql);
    $sql="insert into $table_2 (name, id, title, department, cabinet) VALUES ('$name', $id, '$title', '$department', '$cabinet')";
    mysqli_query($con, $sql);
    mysqli_close($con);
  }


  //Function to add new course
  public static function add_course($name,$ID,$name_prof,$year,$credits,$p_id,$spec,$semester,$course)
  {
    $con=mysqli_connect("localhost","root","","studentrank");
    mysqli_query($con, "SET CHARACTER SET utf8");
    mysqli_query($con, "SET NAMES utf8");
    $table = "course";
    $sql="insert into $table (name, ID, name_prof, year, credits, p_id, spec, semester, course) 
          VALUES ('$name', $ID, '$name_prof', '$year', $credits, $p_id, '$spec', $semester, $course)";
    mysqli_query($con, $sql);
    mysqli_close($con);
  }


  //Function to enroll students into courses
  public static function enroll($s_id,$c_id)
  {
    $con=mysqli_connect("localhost","root","","studentrank");
    mysqli_query($con, "SET CHARACTER SET utf8");
    mysqli_query($con, "SET NAMES utf8");
    $table = "enrolment";
    $sql="insert into $table (s_id, c_id) 
          VALUES ($s_id,$c_id)";
    mysqli_query($con, $sql);
    mysqli_close($con);
  }
}

?>