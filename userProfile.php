<?php 
$pageTitle='User Profile';
include 'includes/header.php'; 
//$select1=mysqli_query($connection,'SELECT * FROM answers INNER JOIN questions '
        //. 'ON answers.answer_creatorID=questions.question_creatorID WHERE questions.question_creatorID="'.$_SESSION['user_id'].'" ');
$selectQuestions=mysqli_query($connection,'SELECT * FROM questions WHERE questions.question_creatorID="'.$_SESSION['user_id'].'" ');
$selectAnswers=mysqli_query($connection,'SELECT * FROM answers WHERE answers.answer_creatorID="'.$_SESSION['user_id'].'" ');
?>
        <ul>
            <li><?=$_SESSION['user_name']?></li>
            <li><?=$_SESSION['user_email']?></li>
            <li><?=$_SESSION['rank']?></li>
            <li>
                <input type="button" value="Questions" />
                <input type="button" value="Answers" />
                <table border="1">
                    <thead>
                        <tr>
                            <th>Votes</th>
                            <th>Questions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        while ($row=$selectQuestions->fetch_assoc())
                        {
                        	echo "<tr class=\"questions\">
                            <td>".$row['question_votes']."</td>
                      
                            <td>".$row['question_content']."</td>
                        </tr>";
                        }
                        
                        while ($row=$selectAnswers->fetch_assoc())
                        {
                        	echo "<tr class=\"answers\">
                            <td>".$row['answer_votes']."</td>
                      
                            <td>".$row['answer_content']."</td>
                        </tr>";
                        }
                        ?>
                        
                    </tbody>
                </table>
            </li>
        </ul>
    </body>
</html>