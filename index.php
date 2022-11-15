<?php
session_start();

include "connection.php";



if(isset($_GET['Message'])){
  $message=$_GET['Message'];
  echo "<script>alert('$message')</script>";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" />
            
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script>
      $(document).ready(function() {
        $(".dropdown-toggle").dropdown();
      });
    </script>

    <style>
      .dropdown-toggle::after {
          content: none;
      }  
    </style>


    <title>Home_page</title>
</head>
<body>
  
  
    <div class="container-fluid  bg-light mt-5">
      
      <nav class="navbar navbar-expand-lg navbar-light  mx-5">

        <a class="navbar-brand me-5" href="#">
          <img src="images/logo.svg" alt="logo" style="width:150px ;height:100px">
        </a>
        <!-- ####################################################################################### -->
        <div class="dropdown show d-lg-none me-3 " >
          <a class="btn dropdown-toggle " href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="navbar-toggler-icon"></span>
          </a>
          <?php 
                if(isset($_SESSION['user_id'])){
                  $user_id=$_SESSION['user_id'];
                  $sql="SELECT * FROM user WHERE id=$user_id";
                  $result=$conn->query($sql);
                  $row=$result->fetch_assoc();

                  if($row['profile_img']){
                    $profile_img="profiles/";
                    $profile_img= $profile_img.$row['profile_img'];
                  }
                  else{
                    $profile_img="images/user_img.png";
                  }
            ?>    
          <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink" style="width:30vw;">
            <div class="dropdown-header">
              <div class="d-flex flex-column justify-content-center ">
                <img src="<?= $profile_img ?>" alt="User" class="rounded-circle mx-auto" style="width:50px;height:50px;">
                
                <h1 class="text-center"><?= $row['full_name'] ?></h1>
              </div>
            </div>
            <div class="dropdown-divider"></div>

            <a class="dropdown-item btn btn-outline-success my-1" href="#">
              <i class="bi bi-pencil-square"></i>&nbsp;Edit profile
            </a>
            <div class="dropdown-divider"></div>
            
            <a class="btn btn-outline-dark dropdown-item my-1 all" type="button" href="#">Home</a>
            <a class="btn btn-outline-success dropdown-item my-1 upcoming" href="#">Up-coming events</a>
            <a class="btn btn-outline-danger dropdown-item my-1 expired" href="#">Expired events</a>

            <div class="dropdown-item dropdown">
              <button class="p-0 btn dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Priority
              </button>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item pri-high" href="#">High</a>
                <a class="dropdown-item pri-med" href="#">Medium</a>
                <a class="dropdown-item pri-low" href="#">Low</a>
              </div>
            </div>
            
            <a class="btn btn-outline-success dropdown-item my-1" href="new_event.php">New event</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item btn btn-outline-danger my-1" href="logout.php">
              <i class="bi bi-box-arrow-right"></i>&nbsp;Log out
            </a>
          </div>
          <?php
        }
        else{
          ?>
          <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink" style="width:30vw;">


            <a class="dropdown-item btn btn-outline-success my-1" href="user_login.php">Log in</a>
            <div class="dropdown-divider"></div>

            <a class="dropdown-item btn btn-outline-success my-1" href="user_signup.php">Sign in</a>
            
          </div>
          <?php
        }
        ?>

        </div>
        
 <!-- ##################################################################################### -->
        
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item mx-2">
              <a class="btn btn-outline-dark all" href="#" role="button">Home</a>
            </li>
            <li class="nav-item mx-2">
              <button class="btn btn-outline-success upcoming" type="button">Up coming Events</button>
            </li>
            <li class="nav-item mx-2" >
              <button class="btn btn-outline-danger expired" type="button">Expired Events</button>
            </li>
            <li class="nav-item dropdown mx-2">
              <a class="btn btn-outline-dark dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Priority
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item pri-high" href="#">High</a>
                <a class="dropdown-item pri-med" href="#">Medium</a>
                <a class="dropdown-item pri-low" href="#">Low</a>
              </div>
            </li>
            <li class="nav-item mx-2">
              <a href="new_event.php" class="btn btn-success" type="button">
                <i class="bi bi-plus-circle"></i>&nbsp;New Event</a>
            </li>
          </ul> 
 <!-- ##################################################################################### -->

          <?php if(isset($_SESSION['user_id'])){

          ?>
          <div class="dropdown show ms-auto me-3">
            <a class=" dropdown-toggle " href="#" role="button" id="dropdownUser" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <img src="<?= $profile_img ?> " alt="User" class="rounded-circle" style="width:75px;height:75px;">
            </a>
          
            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownUser" style="width:20vw;">
              <div class="dropdown-header">
                <div class="d-flex flex-column justify-content-center mb-3">
                  <img src="<?= $profile_img ?>" alt="User" class="rounded-circle mx-auto" style="width:75px;height:75px;">
                  <h1 class="text-center"><?= $row['full_name'] ?></h1>
                </div>
              </div>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item btn btn-outline-success my-3" href="edit_profile.php">
                <i class="bi bi-pencil-square"></i>&nbsp;Edit profile
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item btn btn-outline-danger my-3" href="logout.php">
                <i class="bi bi-box-arrow-right"></i>&nbsp;Log out
              </a>
            </div>
          </div> 
          <?php
          }
          else{
            ?>
            <div class="dropdown show ms-auto me-3">
            <a class=" dropdown-toggle " href="#" role="button" id="dropdownUser" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <img src="images/user_img.png" alt="User" class="rounded-circle" style="width:75px;height:75px;">
            </a>
          
            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownUser" style="width:20vw;">
    
              <a class="dropdown-item btn btn-outline-primary my-3" href="user_login.php">Log in</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item btn btn-outline-success my-3" href="user_signup.php">Sign up</a>
            </div>
          </div> 
            <?php
          }
          ?>

        </div>
    </nav>

  </div>
 <!-- ##################################################################################### -->
 <!-- ##################################################################################### -->
    
  <div class="container-fluid mt-5 px-5 bg-light"> 

    <div class="row" id="event_row">
    
    </div>

  </div> 


<script>
  $(document).ready(function(){

    filter_event(".all");

    $(".expired").click(function(){
      filter_event("expired");
    })

    $(".upcoming").click(function(){
      filter_event("upcoming");
    })

    $(".pri-high").click(function(){
      filter_event("pri-high");
    })

    $(".pri-med").click(function(){
      filter_event("pri-med");
    })

    $(".pri-low").click(function(){
      filter_event("pri-low");
    })

    $(".all").click(function(){
      filter_event("all");
    })
    
    function filter_event(filter_type){
    $.ajax({
      url:"show_event_home.php",
      type:"GET",
      data:{
        'filter':filter_type
      },
      cache:false,
      success:function(result){
        $("#event_row").html(result);
      }
    })
  }
  })
  
</script>  
  
</body>
</html>