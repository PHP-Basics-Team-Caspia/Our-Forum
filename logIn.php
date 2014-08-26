<?php
mb_internal_encoding('UTF-8');
$pageTitle = 'Вход';
include 'includes/header.php';
echo '<header><a href="index.php" align="center">Към форума</a></header>';
if($_POST)
	{
        $username=trim($_POST['username']);
        $username=mysqli_real_escape_string($connection,$username);
	    $pass=trim($_POST['pass']);
        $pass=mysqli_real_escape_string($connection,$pass);
    
                $select=mysqli_query($connection,'SELECT * FROM users Where `user_login` = "'.$username.'" AND `user_password`="'.$pass.'"');
                
                $row=$select->fetch_assoc();
                logIn($select, $row['user_rank'],$row['user_email'], $username, $pass,$row['user_id']);
                }
        
?>
<?php
function logIn($select, $user_rank,$user_email, $username, $pass,$user_id){
    if($select->num_rows>0){
                        header('Location:index.php');
                        $_SESSION['rank']=$user_rank;
                        $_SESSION['user_name']=$username;
                        $_SESSION['user_pass']=$pass;
                        $_SESSION['user_id']=$user_id;
                        $_SESSION['user_email']=$user_email;
                        
                        header('Location:index.php');
                    }
    else {
        echo '<p class="RegIn">Неправилно име или парола!</p>';
    }
}?>
<form method="POST" class="RegIn">
  <div>
    Име:<input type="text" id="username" name="username" />
  </div>
  <div>
    Парола:<input type="password" id="pass" name="pass" />
  </div>
  <div>
      <input type="submit" id="logIn" value="Влезте" /><input type="checkbox" name="mycheckbox">Влез като администратор</input><a href="register.php">Регистрация</a>
  </div>
</form>

<?php
include 'includes/footer.php';
?>