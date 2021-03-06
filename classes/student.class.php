<?php
include_once 'user.class.php'; //import /classes/user.class.php
include_once 'db_config.php';
include_once 'db_connection.php';

class Student extends User
{ //create Student class
    public $post_id;

    //create post
    public function createPost($id, $question, $postDate, $postTime)
    {
        $sql="INSERT INTO post(users_id,content,upvote,date,time,status) 
                                    VALUES('$id','$question',0,'$postDate','$postTime',1)";

        $result=mysqli_query($this->db, $sql);
        if ($result) {
            echo "<script type='text/javascript'>alert('Question has been posted successfully and you have earned 1 participation point!');</script>;";
            $updatesql="UPDATE USERS SET participation = participation + 1 WHERE id='$id'";
            $resultupdate=mysqli_query($this->db, $updatesql);
        }
    }
    //display all posts not relevant to current user (public)
    public function displayAllPosts($id)
    {
        $sql="SELECT id, content, upvote, date, time, status FROM POST WHERE users_id != $id";
        $result=mysqli_query($this->db, $sql);
    
             
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $post_id=$row['id'];
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
                      <td><a href="upvotePost.php?post_id='.$post_id.'" class="btn btn-danger"">Upvote</a></td>
                      <td><a href="detailPublicPost.php?post_id='.$post_id.'" class="btn btn-success" style="width:7em;">View Post</a></td>
                  </tr>';
            }
            //$result->free()
        }
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
                  <!--<td><a href="closePost.php?post_id='.$post_id.'" class="btn btn-danger"">Close</a></td>-->
                  <td><a href="detailPost.php?post_id='.$post_id.'" class="btn btn-primary" style="width:7em;">View Post</a></td>
              </tr>';
            }
        }
    }
    public function markPostClose($post_id)
    {
        $post_id = $post_id;
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
    public function getQuestionContent($id)
    {
        $postid = $_GET['post_id'];
        $sql="SELECT content FROM POST WHERE id='$postid'";
        $result = mysqli_query($this->db, $sql);
        $user_data = mysqli_fetch_array($result);
        echo $user_data['content'];
    }
    public function getAnswerContent($id)
    {
        $ansid = $_GET['ans_id'];
        $sql="SELECT content FROM ANSWERS WHERE id='$ansid'";
        $result = mysqli_query($this->db, $sql);
        $user_data = mysqli_fetch_array($result);
        echo $user_data['content'];
    }
    /*display a table of ans related by post_id */
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
                  <td><a href="commentPost.php?ans_id='.$id.'&post_id='.$post_id.'" class="btn btn-success" style="width:7em;">Comment</a></td>
                  <td><a href="upvoteAns.php?post_id='.$post_id.'&ans_id='.$id.'" class="btn btn-danger" style="width:5em;">Upvote</a></td>
                  </tr>';
            }
        }
    }

    public function getPublicAnswer()
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
                  <td><a href="commentPublicPost.php?ans_id='.$id.'&post_id='.$post_id.'" class="btn btn-success" style="width:7em;">Comment</a></td>
                  <td><a href="upvoteAns.php?post_id='.$post_id.'&ans_id='.$id.'" class="btn btn-danger" style="width:5em;">Upvote</a></td>
                  </tr>';
            }
        }
    }

    public function updatePost($id, $newcontent, $postDate, $postTime)
    {
        $post_id = $_GET['post_id'];
        $newsql= "UPDATE POST SET content='$newcontent', date='$postDate', time='$postTime' WHERE users_id='$id' AND id='$post_id'";
        $result=mysqli_query($this->db, $newsql);
        if ($result === true) {
            $message = "Updated successfully!";
            echo "<script type='text/javascript'>alert('$message');</script>";
        } else {
            $message = "Nothing Happened";
            echo "<script type='text/javascript'>alert('$message');</script>";
        }
    }
    public function updateAns($newanscontent, $postDate, $postTime)
    {
        $ans_id = $_GET['ans_id'];
        $post_id = $_GET['post_id'];
        $newsql= "UPDATE ANSWERS SET content='$newanscontent', date='$postDate', time='$postTime' WHERE id='$ans_id' AND post_id='$post_id'";
        $result=mysqli_query($this->db, $newsql);
        if ($result === true) {
            $message = "Updated successfully!";
            echo "<script type='text/javascript'>alert('$message');</script>";
        } else {
            $message = "Nothing Happened";
            echo "<script type='text/javascript'>alert('$message');</script>";
        }
    }
    public function ansPost($id, $answer, $postDate, $postTime)
    {
        $post_id = $_GET['post_id'];
        $sql="INSERT INTO ANSWERS(post_id,content,upvote,date,time) 
            VALUES('$post_id','$answer',0,'$postDate','$postTime')";

        $result=mysqli_query($this->db, $sql);
        if ($result) {
            echo "<script type='text/javascript'>alert('Answer has been posted successfully and you have earned 1 participation point!');</script>;";
            $updatesql="UPDATE USERS SET participation = participation + 1 WHERE id='$id'";
            $resultupdate=mysqli_query($this->db, $updatesql);
        }
    }
    /* post a comment on Post */
    public function commPost($id, $comment, $postDate, $postTime)
    {
        $post_id = $_GET['post_id'];
        $sql="INSERT INTO COMMENTPOST(post_id,comment,date,time) VALUES('$post_id','$comment','$postDate','$postTime')";
        $result= mysqli_query($this->db, $sql);
        /*                 echo $sql;
                        echo $result; */
        if ($result === true) {
            $message = "Your comment for post=$post_id has been posted succesfully and you have earned 1 participation point!";
            echo "<script type='text/javascript'>alert('$message');</script>";
            $updatesql="UPDATE USERS SET participation = participation + 1 WHERE id='$id'";
            $resultupdate=mysqli_query($this->db, $updatesql);
        } else {
            $message = "Unable to post your comment!";
            echo "<script type='text/javascript'>alert('$message');</script>";
        }
    }

    public function getQComment()
    {
        $postid = $_GET['post_id'];
        $sql="SELECT post_id, comment, date, time FROM COMMENTPOST WHERE post_id='$postid'";
        $result = mysqli_query($this->db, $sql);
        $row=$result->num_rows;
        /*         echo $sql;
                echo '<br>';
                echo $row; */
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $post_id = $row["post_id"];
                $comment = $row["comment"];
                $date = $row["date"];
                $time = $row["time"];

                echo '<tr> 
                  <td>'.$comment.'</td>
                  <td>'.$date.'</td>
                  <td>'.$time.'</td>
              </tr>';
            }
        }
    }


    /* post a comment on Answer */
    public function commAns($id, $comment, $postDate, $postTime)
    {
        $post_id = $_GET['post_id'];
        $ans_id = $_GET['ans_id'];
        $sql="INSERT INTO COMMENTANS(ans_id,comment,date,time) VALUES('$ans_id','$comment','$postDate','$postTime')";
        $id = $_SESSION['id']; //get session id which is user id
        $result= mysqli_query($this->db, $sql);
        /*          echo $sql;
                 echo $result; */
        if ($result === true) {
            $updatesql="UPDATE USERS SET participation = participation + 1 WHERE id='$id'";
            $resultupdate=mysqli_query($this->db, $updatesql);
            $message = "Your comment for answer=$ans_id has been posted succesfully and you have earned 1 participation point!";
            echo "<script type='text/javascript'>alert('$message');</script>";
            $updatesql="UPDATE USERS SET participation = participation + 1 WHERE id='$id'";
            $resultupdate=mysqli_query($this->db, $updatesql);
        } else {
            $message = "Unable to post your comment!";
            echo "<script type='text/javascript'>alert('$message');</script>";
        }
    }

    public function getAnsComment()
    {
        $ans_id = $_GET['ans_id'];
        $sql="SELECT ans_id, comment, date, time FROM COMMENTANS WHERE ans_id='$ans_id'";
        $result = mysqli_query($this->db, $sql);
        $row=$result->num_rows;
        /*         echo $sql;
                echo '<br>';
                echo $row; */
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $ans_id = $row["ans_id"];
                $comment = $row["comment"];
                $date = $row["date"];
                $time = $row["time"];

                echo '<tr>
                  <td>'.$ans_id.'</td>
                  <td>'.$comment.'</td>
                  <td>'.$date.'</td>
                  <td>'.$time.'</td>
              </tr>';
            }
        }
    }

    public function getAnsContent()
    {
        $ansid = $_GET['ans_id'];
        $sql="SELECT content FROM ANSWERS WHERE id='$ansid'";
        $result = mysqli_query($this->db, $sql);
        $user_data = mysqli_fetch_array($result);
        echo $user_data['content'];
    }
    public function getQContent()
    {
        $postid = $_GET['post_id'];
        $sql="SELECT content FROM POST WHERE id='$postid'";
        $result = mysqli_query($this->db, $sql);
        $user_data = mysqli_fetch_array($result);
        echo $user_data['content'];
    }

    public function upvotePost($id, $postid)
    {
        $sql="UPDATE POST SET upvote = upvote + 1 WHERE id='$postid'";
        $result=mysqli_query($this->db, $sql);
        echo $sql;
        echo $result;
        if ($result === true) {
            $updatesql="UPDATE USERS SET participation = participation + 1 WHERE id='$id'";
            $resultupdate=mysqli_query($this->db, $updatesql);
            //echo $updatesql;
            //echo $resultupdate;
            $message = "Upvoted successfully and you have earned 1 participation point!";
            echo "<script type='text/javascript'>alert('$message');</script>"; //do javascript alert upon successful suspension
            echo "<script>window.open('student.php#nav-managepost', '_self');</script>";
        } else {
            echo "Error updating record: " . $this->db->error;
        }
    }

    public function upvoteAns($id, $ansid, $postid)
    {
        $sql="UPDATE ANSWERS SET upvote = upvote + 1 WHERE id='$ansid'";
        $result=mysqli_query($this->db, $sql);
        if ($result === true) {
            $updatesql="UPDATE USERS SET participation = participation + 1 WHERE id='$id'";
            $resultupdate=mysqli_query($this->db, $updatesql);
            //echo $updatesql;
            //echo $resultupdate;
            $message = "Upvoted successfully and you have earned 1 participation point!";
            echo "<script type='text/javascript'>alert('$message');</script>"; //do javascript alert upon successful suspension
            echo "<script>window.open('detailPost.php?post_id=".$postid."', '_self');</script>";
        } else {
            echo "Error updating record: " . $this->db->error;
        }
    }
}
