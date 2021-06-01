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
    include "../db_connect.php";
    require 'nav.php';
    if($err)
{
  echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Succesfully!</strong> You are Login Succesfully.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';
}
if($show){
  echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Error!</strong> Check Username and Password wrong.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';
}
    echo '<div class="container my-4 ms-150" id="q">
    <form action="login.php" class="needs-validation" method="POST">
      <h1>Login</h1>
      <div class="mb-3 col-8">
        <label for="exampleInputEName" class="form-label">Username</label>
        <input type="name" name="LName" class="form-control" id="LName" aria-describedby="emailHelp" placeholder="Enter a Name" required >
      </div>
      <div class="mb-3 col-8">
      <label for="exampleInputEmail1" class="form-label">Password</label>
      <input type="password" name="Lpass" class="form-control" id="Lpass" aria-describedby="emailHelp" placeholder="Enter a password" required>
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    
    </form>
    </div>';
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