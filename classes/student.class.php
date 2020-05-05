<?php
include_once 'user.class.php'; //import /classes/user.class.php
include_once 'db_config.php';
class Student extends User
{ //create Student class

    //display a list of all Posts
    public function displayAllPosts($id)
    {
        $sql="SELECT content, upvote, date, time, status FROM POST WHERE users_id != $id";
        $result=mysqli_query($this->db, $sql);
    
             
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $content = $row["content"];
                $upvote = $row["upvote"];
                $date = $row["date"];
                $time = $row["time"];
                $status = $row["status"];
     
                echo '<tr> 
                      <td>'.$content.'</td> 
                      <td>'.$upvote.'</td> 
                      <td>'.$date.'</td> 
                      <td>'.$time.'</td>
                      <td>'.$status.'</td>
                      <td><a type="submit" class="btn btn-success" style="width:7em;">View Post</a></td>
                  </tr>';
            }
            //$result->free();
        }
        //mark post as open
        //public function markPostOpen() {
    }

    //display list of Posts by Student
    public function displayPosts($id)
    {
        $sql="SELECT id, content, upvote, date, time, status FROM POST WHERE users_id = $id";
        $result=mysqli_query($this->db, $sql);

         
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $post_id = $row["id"];
                $content = $row["content"];
                $upvote = $row["upvote"];
                $date = $row["date"];
                $time = $row["time"];
                $status = $row["status"];
 
                echo '<tr> 
                  <td>'.$content.'</td> 
                  <td>'.$upvote.'</td> 
                  <td>'.$date.'</td> 
                  <td>'.$time.'</td>
                  <td>'.$status.'</td>
                  <td><a onclick="closePost();" class="btn btn-danger" style="width:10em;">Mark as Closed</a></td>
                  <td><a type="submit" class="btn btn-success" style="width:7em;">View Post</a></td>
              </tr>';
            }
            //$result->free();
        }
        //mark post as open
    //public function markPostOpen() {
    }
    //mark post as closed
    public function markPostClose($post_id)
    {
        $sql="UPDATE POST SET status= 0  WHERE id= '$post_id'";
        //echo $sql;
        $result=mysqli_query($this->db, $sql);
        if ($result === true) {
            $message = "Post closed successfully!";
            echo "<script type='text/javascript'>alert('$message');</script>"; //do javascript alert upon successful suspension
            echo "<script>window.open('student.php', '_self');</script>"; //redirect back to student.php
        } else {
            echo "Error updating record: " . $this->db->error;
        }
    }
}
