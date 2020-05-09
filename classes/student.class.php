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
        $sql="INSERT INTO post(users_id,content,upvote,date,time,status) 
                                    VALUES('$id','$question',0,'$postDate','$postTime',1)";

        mysqli_query($this->db, $sql);

        echo "<script type='text/javascript'>alert('Question has been posted successfully');</script>;";

    }
    //display all posts not relevant to current user (public)
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
        $sql="SELECT id, users_id, content, upvote, date, time, status FROM POST WHERE users_id = $id";
        $result=mysqli_query($this->db, $sql);


        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $post_id = $row["id"];
                $user_id = $row["users_id"];
                $content = $row["content"];
                $upvote = $row["upvote"];
                $date = $row["date"];
                $time = $row["time"];
                $status = $row["status"];

                echo '<tr> 
                  <td>'.$post_id.'</td>
                  <td>'.$content.'</td> 
                  <td>'.$upvote.'</td> 
                  <td>'.$date.'</td> 
                  <td>'.$time.'</td>
                  <td>'.$status.'</td>
                  <td><a href="closePost.php?post_id='.$post_id.'" class="btn btn-danger" style="width:10em;">Mark as Closed</a></td>
                  <td><a href="detailPost.php?post_id='.$post_id.'" class="btn btn-success" style="width:7em;">View Post</a></td>
              </tr>';
            }
        }
    }
    public function markPostClose($post_id)
    {   $post_id = $post_id;
        $sql="UPDATE POST SET status= 0  WHERE id= '$post_id'";
        echo $sql;
        $result=mysqli_query($this->db, $sql);
        if ($result === true) {
            $message = "Post closed successfully!";
            echo "<script type='text/javascript'>alert('$message');</script>"; //do javascript alert upon successful suspension
            echo "<script>window.open('student.php', '_self');</script>"; //redirect back to student.php
        } else {
            echo "Error updating record: " . $this->db->error;
        }
    }
    public function getContent($id)
    {
        $postid = $_GET['post_id'];
        $sql="SELECT content FROM POST WHERE users_id = '$id' AND id='$postid'";
        $result = mysqli_query($this->db, $sql);
        $user_data = mysqli_fetch_array($result);
        echo $user_data['content'];
        
    }
    public function getAnswer()
    {
        $postid = $_GET['post_id'];
        $sql="SELECT id, post_id, content, upvote, date, time FROM ANSWERS WHERE post_id='$postid'";
        $result = mysqli_query($this->db, $sql);
        $row=$result->num_rows;
/*         echo $sql;
        echo '<br>';
        echo $row; */
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $id = $row["id"];
                $post_id = $row["post_id"];
                $content = $row["content"];
                $upvote = $row["upvote"];
                $date = $row["date"];
                $time = $row["time"];

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
    public function updatePost($id){
        if (isset($_POST['updatebtn'])) {
        $post_id = $_GET['post_id'];
        $newcontent = $_POST['update'];
        $newsql= "UPDATE POST SET content='$newcontent' WHERE users_id='$id' AND id='$post_id'";
        $result=mysqli_query($this->db, $newsql);
        if ($result === true) {
            $message = "Updated successfully!";
            echo "<script type='text/javascript'>alert('$message');</script>";
        } else {
            $message = "Nothing Happened";
            echo "<script type='text/javascript'>alert('$message');</script>";
        }
    }
    }
    public function ansPost($id,$question,$postDate,$postTime)
    {
        $sql="INSERT INTO post(users_id,content,upvote,date,time,status) 
                                    VALUES('$id','$question',0,'$postDate','$postTime',1)";

        mysqli_query($this->db, $sql);

        echo "<script type='text/javascript'>alert('Question has been posted successfully');</script>;";

    }
}
