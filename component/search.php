<?php
$err=false;
$show=false;
if($_SERVER["REQUEST_METHOD"]=="POST")
{
  require '../db_connect.php';
  $UName=$_POST["LName"];
  $pass=$_POST["Lpass"];
  // $uid=$_POST["uid"];

    // $sql="select *from usersdata where username='$UName' AND password='$pass'";
    $sql="select *from user_data where u_name='$UName'";
    $res=mysqli_query($conn,$sql);
    $num=mysqli_num_rows($res);
    if($num==1)
    {
      while($row=mysqli_fetch_assoc($res)){
        if(password_verify($pass,$row['u_password'])){
          $err=true;
          session_start();
          $_SESSION['log']=true;
          $_SESSION['uid']=$row['u_id'];
          $_SESSION['u_name']=$UName;
          header("location: ../index.php");
        } else
        {
          $show=true;
        }
      }
    }
  else
  {
    $show=true;
  }
}

?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <style>
    #q{
        min-height:600px;
    }
    </style>
    <title>Hello, world!</title>
</head>

<body>
<?php
    include '../db_connect.php';
    include 'nav.php';
    $data=$_GET['Query'];
    $sql="SELECT thread_title,thread_desc,thread_id FROM `thread_q` WHERE MATCH (thread_title,thread_desc) against('$data')";
    $res=mysqli_query($conn,$sql);
    $qus=true;
    echo '<div class="container"> ';
    while($row=mysqli_fetch_assoc($res))
    {
      $qus=false;
      $ttitle=$row['thread_title'];   
      $tdesc=$row['thread_desc'];   
      $tid=$row['thread_id'];   

    echo '
    <div class="card my-3">
              <div class="card-header">
              Serch Results for - "'.$_GET["Query"].'
              </div>
              <div class="card-body">
                <h5 class="card-title"><a href="/rushi/ForumWeb/threadQA.php?tid='.$tid.'" class=" text-decoration-none text-dark"><p class="my-2">'.ucfirst($ttitle).'</p></h5></a>
                <p class="card-text">'.ucfirst($tdesc).'</p>
                <a href="/rushi/ForumWeb/threadQA.php?tid='.$tid.'" class="btn btn-primary">Explore Answer</a>
              </div>
            </div>';

    }
    echo '<div class="container" id="q">';
    if($qus)
    {
      echo' <div class="jumbotron jumbotron-fluid bg-warning my-4">
        <p class="display-4">No Searches Found</p>
        <p class="lead">Suggestions:
        <ul>
        <li>Make sure that all words are spelled correctly.</li>
        <li>Try different keywords.</li>
        <li>Try more general keywords.</li>
        <li>Try fewer keywords.</li>
        </ul>
        </p>
      </div>
      ';
    }
    echo '</div>';
    
    include 'footer.php';
    ?>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
    -->
</body>

</html>