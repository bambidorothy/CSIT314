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
                      <td>'.$questionId.'</td>
                      <td>'.$question.'</td>  
                      <td>'.$upvote.'</td> 
                      <td>'.$userId.'</td> 
                      
                      
                  </tr>';
            }
        }
    }

    public function generateTopWkQns()
    {
        $sql="SELECT * FROM post GROUP BY week(date) ORDER BY week(date) ASC,upvote DESC LIMIT 10";
        $result=mysqli_query($this->db, $sql);
        $row=$result->num_rows;
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $id=$row['id'];
                $content=$row["content"];
                $upvote=$row["upvote"];
                $date=$row["date"];
                $time=$row["time"];

                echo '<tr>
                      <td>'.$id.'</td>  
                      <td>'.$content.'</td> 
                      <td>'.$upvote.'</td> 
                      <td>'.$date.'</td> 
                      <td>'.$time.'</td> 
                  </tr>';
            }
        }
        
    }
    public function generateTopWkQnsFile()
    {
        $sql= "SELECT * FROM post GROUP BY week(date) ORDER BY week(date) ASC,upvote DESC LIMIT 10 into outfile 'C:/xampp/htdocs/CSIT314/topweeklyquestions.txt'";
        $result=mysqli_query($this->db, $sql);
    }

    public function generateTopMthQns()
    {
        $sql="SELECT * FROM post GROUP BY month(date) ORDER BY month(date) ASC, upvote DESC LIMIT 10";
        $result=mysqli_query($this->db, $sql);
        $row=$result->num_rows;
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $id=$row['id'];
                $content=$row["content"];
                $upvote=$row["upvote"];
                $date=$row["date"];
                $time=$row["time"];

                echo '<tr>
                      <td>'.$id.'</td>  
                      <td>'.$content.'</td> 
                      <td>'.$upvote.'</td> 
                      <td>'.$date.'</td> 
                      <td>'.$time.'</td> 
                  </tr>';
            }
        }
    }
    public function generateTopMthQnsFile()
    {
        $sql= "SELECT * FROM post GROUP BY month(date) ORDER BY month(date) ASC, upvote DESC LIMIT 10 into outfile 'C:/xampp/htdocs/CSIT314/topmonthlyquestions.txt'";
        $result=mysqli_query($this->db, $sql);
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
