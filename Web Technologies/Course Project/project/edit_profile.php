<?php 
	include 'header.php';
?>

<?php
  if ($_SESSION['logged_in']){
	$profile_id = $_SESSION["id"];
	echo "<p>Може да качите профилна снимка.</p>";

  //handle image conversion
	$path = "data/avatars/";
	if(isset($_FILES['image'])){
      $img =$_FILES['image']['tmp_name'];

      $image_correct = true;
      if (($img_info = getimagesize($img)) === FALSE){
        $image_correct = false;
      }
      else {
        $img_ext = $img_info[2];
        switch ($img_ext) {
  		    case IMAGETYPE_GIF  : $src = imagecreatefromgif($img);  break;
		      case IMAGETYPE_JPEG : $src = imagecreatefromjpeg($img); break;
		      case IMAGETYPE_PNG  : $src = imagecreatefrompng($img);  break;
		      default : $image_correct = false;
		    }
      }
      if ($image_correct){
      	$dest = $path . $profile_id . ".jpg";
      	imagejpeg ($src, $dest);
        echo '<META HTTP-EQUIV="refresh" content="0;URL=' . "profile.php?id=$profile_id" . '">';

      }
      else {
        echo "File format not supported;";
      }
  }
  

}
?>

	<form action="" method="POST" enctype="multipart/form-data">
         <input type="file" name="image" />
         <input type="submit"/>
      </form>

<?php
	include 'footer.php';
?>