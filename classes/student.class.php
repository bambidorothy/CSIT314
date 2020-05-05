<?php
include_once 'user.class.php'; //import /classes/user.class.php
include_once 'db_config.php';
include_once 'db_connection.php';

class Student extends User
{ //create Student class
    public $post_id;

    //display a list of all Posts
    public function createPost($id,$question,$postDate,$postTime)
    {
        $sql="INSERT INTO post(users_id,content,upvote,date,time) 
                                    VALUES('$id','$question',0,'$postDate','$postTime')";

        mysqli_query($this->db, $sql);

        echo "<script type='text/javascript'>alert('Question has been posted successfully');</script>;";

    }
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

<<<<<<< HEAD
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
<<<<<<< HEAD
                  <td><a onclick="closePost();" class="btn btn-danger" style="width:10em;">Mark as Closed</a></td>
                  <td><a type="submit" class="btn btn-success" style="width:7em;">View Post</a></td>
                  <td><a onclick="popUp();" class="btn btn-danger" style="width:7em;">Edit</a></td>
=======
                  <td><a href="closePost.php?post_id=<?php echo $row["id"];?>" class="btn btn-danger" style="width:10em;">Mark as Closed</a></td>
                  <td><a href="detailPost.php" class="btn btn-success" style="width:7em;">View Post</a></td>
>>>>>>> d5e0cbd92bf1a037cc612b1479a945a1cd04d881
              </tr>';
            }
            //$result->free();
        }
        //mark post as open
    //public function markPostOpen() {
    }
    //mark post as closed
=======
>>>>>>> 75c5bcdda873fb3883a453a79d5c1cf134c9efa1
    public function markPostClose($post_id)
    {   $post_id = $post_id;
        $sql="UPDATE POST SET status= 0  WHERE id= '$post_id'";
        echo $sql;
        $result=mysqli_query($this->db, $sql);
/*         if ($result === true) {
            $message = "Post closed successfully!";
            echo "<script type='text/javascript'>alert('$message');</script>"; //do javascript alert upon successful suspension
            echo "<script>window.open('student.php', '_self');</script>"; //redirect back to student.php
        } else {
            echo "Error updating record: " . $this->db->error;
        } */
    }
<<<<<<< HEAD
    public function popUp()
    {
        
    }
=======

>>>>>>> 75c5bcdda873fb3883a453a79d5c1cf134c9efa1
}
