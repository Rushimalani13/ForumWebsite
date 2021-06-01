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
    // session_start();
    include 'db_connect.php';
    include 'component/nav.php';
       
    $id=$_GET['catid'];
    $sql="SELECT * FROM `catogery` WHERE cat_id=$id";
    $res=mysqli_query($conn,$sql);
    while($row=mysqli_fetch_assoc($res))
    {
        $catname=$row['Cat_name'];
        $catdesc=$row['cat_desc'];
        echo'<div class="container my-4"><div class="jumbotron">
        <h1 class="display-4">Welcome to '.$catname.' Forum</h1>
        <p class="lead">'.$catdesc.'</p>
        <hr class="my-4">
        <p><b>1.</b>No Spam / Advertising / Self-promote in the forums.
        <b>2.</b>Do not post copyright-infringing material.<br/>
        <b>3.</b>Do not post “offensive” posts, links or images in Forum section.
        <b>4.</b>Do not cross post questions in Forum.
        </p>
        </div>
        </div>';
    }

    if(isset($_SESSION['log']) && $_SESSION['log']=true){
      echo'<div class="container">
      <h1 class="pb-4"><b>Star Discussion</b>-Ask Query Freely</h1>
      <form action="'.$_SERVER["REQUEST_URI"].'" method="post">
      <div class="form-group">
      <label for="exampleInputEmail1">Ask Your Query Here</label>
      <input type="text" class="form-control" id="title" name="ttitle" aria-describedby="emailHelp">
      </div>
      <div class="form-group">
      <label for="exampleFormControlTextarea1">Describe Your Query</label>
      <textarea class="form-control" id="desc" name="tdesc" rows="3"></textarea>
      </div>
      <input type="hidden" name="suid" value="'.$_SESSION['uid'].'">
      <button type="submit" class="btn btn-primary">Post Query</button>
      <a href="'.$_SERVER["REQUEST_URI"].'" class="btn btn-primary">Show Question</a>
      </form>
      
        </div>';
    }
    else{
      echo'    <div class="container">
      <h1 class="pb-4"><b>Star Discussion</b>-Ask Query Freely</h1>
      <div class="form-group">
      <label for="exampleInputEmail1">Ask Your Query Here</label>
      <input type="text" class="form-control" aria-describedby="emailHelp">
      </div>
      <div class="form-group">
      <label for="exampleFormControlTextarea1">Describe Your Query</label>
      <textarea class="form-control" rows="3"></textarea>
      </div>
      <a href="component/login.php"><button type="submit" class="btn btn-primary">Post Query</button></a>
      </div>';

    }
  
?>
    <?php
    $id=$_GET['catid'];
    $sql="SELECT * FROM `thread_q` WHERE thread_cat=$id";
    $res=mysqli_query($conn,$sql);
    $qus=true;
    echo '<div class="container" id="q"> ';
    while($row=mysqli_fetch_assoc($res))
    {
      $qus=false;
      $tid=$row['thread_id'];
      $ttitle=$row['thread_title'];   
      $tdesc=$row['thread_desc'];   
      $tdate=$row['thread_date'];  
      $tuser=$row['thread_user'];  
      
      $sql2="SELECT `u_name` FROM `user_data` WHERE u_id=$tuser";
      $res2=mysqli_query($conn,$sql2);
      $row2=mysqli_fetch_assoc($res2);
      $username=$row2["u_name"];
      // $mydate=getdate($tdate);
      $mydate=date_create($tdate);
      echo '<div class="card my-3">
              <div class="card-header">
                Quetions & Answers
              </div>
              <div class="card-body">
                <h5 class="card-title"><a href="/rushi/ForumWeb/threadQA.php?tid='.$tid.'" class=" text-decoration-none text-dark">Posted By: <b>'.ucfirst($username).'</b></a> | '.date_format($mydate,"d-F-y").'<p class="my-2">'.ucfirst($ttitle).'</p></h5>
                <p class="card-text">'.ucfirst($tdesc).'</p>
                <a href="/rushi/ForumWeb/threadQA.php?tid='.$tid.'" class="btn btn-primary">Explore Answer</a>
              </div>
            </div>';
  }?>
    <?php
    // $method=$_SERVER['REQUEST_METHOD'];
    if($_SERVER["REQUEST_METHOD"]=="POST")
    {
      $th_title=$_POST["ttitle"];
      $th_desc=$_POST["tdesc"];
      $th_uid=$_POST["suid"];

      $th_title = str_replace("<", "&lt", $th_title);
      $th_title = str_replace(">", "&gt", $th_title);

      $th_desc = str_replace("<", "&lt", $th_desc);
      $th_desc = str_replace(">", "&gt", $th_desc);

      $sql="INSERT INTO `thread_q` (`thread_title`, `thread_desc`, `thread_cat`, `thread_user`, `thread_date`) VALUES ('$th_title', '$th_desc', '$id', '$th_uid', current_timestamp())";
      $res=mysqli_query($conn,$sql); 
  
      
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