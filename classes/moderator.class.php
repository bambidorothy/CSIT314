<?php
include_once 'user.class.php'; //import /classes/user.class.php
include_once 'db_config.php';
include_once 'db_connection.php';

class Moderator extends User
{
    public function generateTopQns()
    {
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
}
