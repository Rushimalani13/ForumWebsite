<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
        integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <style>
    #q {
        min-height: 600px;
    }
    </style>
    <title>Ask Me Something</title>
</head>

<body>
    <?php
  include 'component/nav.php';
  require 'db_connect.php';
  $id = $_GET['tid'];
  $sql = "SELECT * FROM `thread_q` WHERE thread_id=$id";
  $res = mysqli_query($conn, $sql);

 

  while ($row = mysqli_fetch_assoc($res)) {
    $tname = $row['thread_title'];
    $tdesc = $row['thread_desc'];
    
    $ruser = $row['thread_user'];

    $sql2="SELECT `u_name` FROM `user_data` WHERE u_id=$ruser";
    $res2=mysqli_query($conn,$sql2);
    $row2=mysqli_fetch_assoc($res2);
    // $mydate=date_create($time);
    $showname2=$row2["u_name"];

    echo '<div class="container bg-success my-4">
        <div class="card text-center bg-primary">
        <div class="card-header">
          Quetions & Answers
        </div>
        <div class="card-body">
          <h5 class="card-title">' . ucfirst($tname) . '</h5>
          <p class="card-text">' . $tdesc . '</p>
        </div>
        <div class="card-footer text-light">
        Poseted By: <b class="text-dark">'.strtoupper($showname2).'</b>
        </div>
      </div>
      </div>';
  }
  
  $method=$_SERVER['REQUEST_METHOD'];
  if($_SERVER["REQUEST_METHOD"]=="POST")
  {

    $com=$_POST["comment"];
    $su=$_POST["suid"];
    // $th_desc=$_POST["thread_id"];

    $com = str_replace("<", "&lt", $com);
    $com = str_replace(">", "&gt", $com );

    $sql="INSERT INTO `reaply` (`r_comment`, `r_thread_id`, `r_user`, `r_time`) VALUES ('$com', '$id', '$su', current_timestamp())";
    $res=mysqli_query($conn,$sql); 
    $qus=false;
  }
 

  // $id=$_GET['catid'];
  // $sql="SELECT * FROM `thread_q` WHERE thread_id=$id";
  // $res=mysqli_query($conn,$sql);
if(isset($_SESSION['log']) && $_SESSION['log']=true)
{

  echo '<div class="container">
  <h1 class="pb-4">Post a Comment</h1>';
  echo '<form action="'.$_SERVER["REQUEST_URI"].'" method="post">
  <div class="mb-3">
  <label for="exampleFormControlTextarea1" class="form-label">Example textarea</label>
  <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
  </div>
  <input type="hidden" name="suid" value="'.$_SESSION['uid'].'">
  <button type="submit" class="btn btn-primary">Comment</button>
  </form>';
  echo '</div>';
} 
else{ 
  echo '<div class="container">
  <h1 class="pb-4">Post a Comment</h1>';
  echo '<div class="mb-3">
  <label for="exampleFormControlTextarea1" class="form-label">Example textarea</label>
  <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
  </div>
  <a href="component/login.php"><button type="submit" class="btn btn-primary">Comment</button></a>
  ';
  echo '</div>';
}


  $id=$_GET['tid'];

  $sql = "SELECT * FROM `reaply` WHERE r_thread_id=$id";
  $res = mysqli_query($conn, $sql);
  $qus = true;
  echo '<div class="container my-4" id="q"> ';
  echo "<h1>Solutions</h1>";
  while ($row = mysqli_fetch_assoc($res)) {
    $qus = false;
    $th_id = $row['r_thread_id'];
    $com = $row['r_comment'];
    $time = $row['r_time'];
    $ruser = $row['r_user'];
    // $tdesc=$row['thread_desc']; 
    
      $sql2="SELECT `u_name` FROM `user_data` WHERE u_id=$ruser";
      $res2=mysqli_query($conn,$sql2);
      $row2=mysqli_fetch_assoc($res2);
      $mydate=date_create($time);
      $showname=$row2["u_name"];

    echo ' 
            <div class="card my-3">
              <div class="card-header">
                Answers
              </div>
              <div class="card-body">
                <h5 class="card-title"><a href="/rushi/ForumWeb/threadQA.php?tid='.$id.'" class=" text-decoration-none text-dark">Posted By: <b>'.ucfirst($showname).'</b></a> | '.date_format($mydate,"d-F-y").'</h5>
                <p class="card-text">' . $com . '</p>
                <a href="/rushi/ForumWeb/threadQA.php?tid='.$id.'" class="btn btn-primary">Explore Answer</a>
              </div>
            </div>
    
    
    ';
  }
  if($qus)
  {
   echo' <div class="jumbotron jumbotron-fluid bg-warning my-4">
          <div class="container">
            <p class="display-4">No Quetions Found</p>
            <p class="lead">Be First Person to Ask Questions</p>
          </div>
        </div>';
  }
  echo '</div>';

  echo '</div>';
  include 'component/footer.php';
  ?>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous">
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous">
    </script>
    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
    -->
</body>

</html>