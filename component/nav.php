<?php  
// include 'db_connect.php';
session_start();
echo '<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<div class="container-fluid">
  <a class="navbar-brand" href="#">🅰🆂🅺 🅼🅴</a>
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="/rushi/ForumWeb/">Home</a>
      </li>
      
      <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="/rushi/ForumWeb/contact.php">Contact</a>
      </li>  

      <li class="nav-item dropdown">
        <a class="nav-link active dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
         Top Catogery
        </a>';
        echo '<ul class="dropdown-menu" aria-labelledby="navbarDropdown">';

        $sql="SELECT cat_id, Cat_name FROM `catogery` limit 5";
        $res=mysqli_query($conn,$sql);
        while($row=mysqli_fetch_assoc($res))
        {
          $catid=$row['cat_id'];
          $cat=$row['Cat_name'];
            echo '<li><a class="dropdown-item" href="http://localhost:8080/rushi/ForumWeb/thread.php?catid='.$catid.'">'.strtoupper($cat).'</a></li>';
          }
          echo'</ul>
              </li>';


      echo '<li class="nav-item">
        <a class="nav-link active" aria-current="page" href="#">About</a>
      </li>
      </ul>';
      echo '<form class="d-flex" action="http://localhost:8080/rushi/ForumWeb/component/search.php?Query=Query" method="get" >
      <input class="form-control me-2" name="Query" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-primary" type="submit">Search</button>
      </form>';
if(isset($_SESSION['log']) && $_SESSION['log']=true){
  echo '<p class="text-success my-0 mx-3">Welcome-'.$_SESSION['u_name'].'</p>
  <a href="/rushi/ForumWeb/component/logout.php" class=" text-decoration-none"><button class="btn btn-outline-success mx-1" type="submit">Logout</button></a>';

}
else{
  echo'<a href="/rushi/ForumWeb/component/login.php" class="text-decoration-none"><button class="btn btn-outline-success mx-2" type="submit">Login</button></a>
  <a href="/rushi/ForumWeb/component/signup.php" class="text-decoration-none"><button class="btn btn-outline-success">Sign Up</button></a>';
}
   
      echo '</div>
        </div>
        </nav>';
?>