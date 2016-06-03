<center>
<table  width="300" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#ADD8E6" >
<tr>
<form name="form1" method="post" action="admin_login.php">
<td>
<table  width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#ADD8E6">
<tr>
<td colspan="3"><strong><center><h2>Admin Login</h2></center></strong></td>
</tr>
<tr>
<td>AdminID:</td>
<td><input type="uname" name="uname" placeholder="User Name"></td>
</tr>
<tr>
<td>Password:</td>
<td><input type="password" name="password" placeholder="Парола"></td>
</tr>
<tr>
<td>&nbsp;</td>
<td><input type="submit" class="myButton" name="Submit" value="LOGIN"></td>
</form>
</tr>
</table>
</td>
</tr>
</table>
</center>
<html>
<head>
<?php
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
      if(!isset($_SESSION)) 
      { 
          session_start(); 
      } 
      $uname=$_POST['uname'];
      $password=$_POST['password'];
      $con=mysqli_connect("localhost","root","","studentrank");
      if (mysqli_connect_errno())
      {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
      }

      $sql="select * from users where uname='$uname' and password='$password'";
      $result = mysqli_query($con,$sql);
      $count=mysqli_num_rows($result);
      if($count==1)
      {
        $row=$result->fetch_assoc();
        $_SESSION['security_lvl'] = $row['security_lvl'];
        $_SESSION["logged_in"] = true;
		echo '<META HTTP-EQUIV="refresh" content="0;URL=' . "admin_welcome.php" . '">';
      }
      
      else
      {
        print "<p>Invalid ID or Password</p>";
      }
    }
?>
</head>
<body>
</body>
</html>	
