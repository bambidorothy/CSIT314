<?php
include_once 'user.class.php'; //import /classes/user.class.php
include_once 'db_config.php';
include_once 'db_connection.php';

class Moderator extends User
{
    public function generateTopQns()
    {
        $sql ="SELECT content,upvote,users_id,id FROM post WHERE status='1' ORDER BY upvote DESC LIMIT 10";
        $result = mysqli_query($this->db,$sql);
        $row=$result->num_rows;
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $question=$row['content'];
                $upvote = $row["upvote"];
                $userId = $row["users_id"];
                $questionId = $row["id"];
                
                

                echo '<tr>
                      <td>'.$question.'</td>  
                      <td>'.$upvote.'</td> 
                      <td>'.$userId.'</td> 
                      <td>'.$questionId.'</td> 
                      
                  </tr>';
            }
        }
    }

    public function generateTopWkQns()
    {
    }

    public function generateTopMthQns()
    {
    }

    public function generateTopStudents()
    {
        $sql= "SELECT fullname,participation,role FROM users WHERE role='student' ORDER BY participation DESC LIMIT 10";
        $result=mysqli_query($this->db, $sql);
        $row=$result->num_rows;
        //echo $sql;
        //echo $row;

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $fullname=$row['fullname'];
                $participation = $row["participation"];
                $role=$row["role"];

                echo '<tr>
                      <td>'.$fullname.'</td>  
                      <td>'.$participation.'</td> 
                      <td>'.$role.'</td> 
                  </tr>';
            }
        }
    }

    public function generateTopStudentsFile()
    {
        $sql= "SELECT fullname,participation,role FROM users WHERE role='student' ORDER BY participation DESC LIMIT 10 into outfile 'C:/xampp/htdocs/CSIT314/topstudents.txt'";
        $result=mysqli_query($this->db, $sql);
        //echo $sql;
        //echo $result;
    }
    public function generateTopQuestionsFile()
    {
        $sql= "SELECT content,upvote,users_id,id FROM post WHERE status='1' ORDER BY upvote DESC LIMIT 10 into outfile 'C:/xampp/htdocs/CSIT314/topQuestions.txt'";
        $result=mysqli_query($this->db, $sql);
        //echo $sql;
        //echo $result;
    }
}
