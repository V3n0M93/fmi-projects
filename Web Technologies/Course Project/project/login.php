<?php 
	include 'header.php';
?>

<div class="form">
	<h1>Вход</h1>
	<form method="post" enctype="multipart/form-data">
		<input type="uname" name="uname" placeholder="User Name">
		<input type="password" name="password" placeholder="Парола">
		<button>Вход</button>
	</form>
</div>

<!-- Add login handling -->
<?php 
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
      if(!isset($_SESSION)) 
      { 
          session_start(); 
      } 
   
      //$uname = 'miro';
      //$password = '123456';
      $uname=$_POST['uname'];
      $password=$_POST['password'];
      $con=mysqli_connect("localhost","root","","studentrank");

      // Check connection
      if (mysqli_connect_errno())
      {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
      }

      $sql="select * from users where uname='$uname' and password='$password'";
      $result = mysqli_query($con,$sql);
      // Mysql_num_row counts table row
      $count=mysqli_num_rows($result);
      if($count==1)
      {
        $_SESSION['uname']=$uname;
        $_SESSION['password']=$password;
        $row=$result->fetch_assoc();
        $_SESSION['id'] = $row['id'];
        $_SESSION['security_lvl'] = $row['security_lvl'];
        $_SESSION['logged_in'] = true;

      echo '<META HTTP-EQUIV="refresh" content="0;URL=' . "index.php" . '">';
      }
      
      else
      {
        print "<p>Invalid ID or Password</p>";
      }
    }
?>

<?php
	include 'footer.php';
?>