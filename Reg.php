<?php
$pageTitle="Регистрация";
include 'includes/header.php';
include 'includes/registrationFun.php';
echo '<header><a href="index.php" align="center">Към Форум</a></header>';
?>
<form method="POST" enctype="multipart/form-data" class="RegIn">
  <div>
    Име:<input type="text" name="username" />
  </div>
  <div>
    Парола:<input type="password" name="pass" />
  </div>
    <div>
    e-mail:<input type="email" name="email" />
  </div>
    <div>
        Снимка:<input type="file" name="picture" />
    </div>
      <div>
    <input type="submit" value="Регистрация" />
  </div>
<?php
            
if($_POST)
	{
            $username=trim($_POST['username']);
            $username=mysqli_real_escape_string($connection,$username);// make data save before send query to MySQL
            $pass=trim($_POST['pass']);
            $pass=mysqli_real_escape_string($connection,$pass);
            $email=trim($_POST['email']);
            $email=mysqli_real_escape_string($connection,$email);
            $userOrAdmin='user';
            $select=mysqli_query($connection,'SELECT * FROM users Where `user_login` = "'.$username.'"');
            $textForMistace='Заето потребителско име!';
            
            
           $reg=reg($select,$textForMistace,$username,$pass,$email,$connection);
            if ($reg&&count($_FILES) > 0) {
                $file=$_FILES['picture'];
                $file_name=$file['name'];
                $file_type=$file['type'];
                $file_size=$file['size'];
                $file_path=$file['tmp_name'];
                $select = mysqli_query($connection, 'SELECT * FROM users WHERE user_login="' . $username . '" '
                . 'AND user_password="' . $pass . '"');
                $row = $select->fetch_assoc();
                $picName = $row['user_id'] . ".jpg";
              if($file_name!=""&&($file_type=="image/jpeg"||$file_type=="image/png"||$file_type=="image/gif")&& $file_size<1048576&&
                   move_uploaded_file($file_path, 'pictures' . DIRECTORY_SEPARATOR . $picName)) {     
            } 
            else {
                echo '<p class="RegIn">Грешка</p>';
                }
            }
    }
?>
</form>

<?php   
include 'includes/footer.php';
?>