<?php
function reg($select,$textForMistace,$username,$pass,$email,$connection){
    $count=0;
    if($select->num_rows>0){
            echo $textForMistace;
            return false;
    }
        else{
            echo 'Успешна регистрация<a href="login.php">Влезте в профила си</a><br/>';
           
            $ins='INSERT INTO `users`(`user_login`, `user_password`,`user_email`)
                    VALUES ("'.$username.'","'.$pass.'","'.$email.'")';
            $q=mysqli_query($connection,$ins);
            return true;
        } 
}
?>