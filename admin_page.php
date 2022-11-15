<?php
session_start();
require "connection.php"
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" />
            
    <!-- jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Data tables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>

    <script>
      $(document).ready(function() {
        $(".dropdown-toggle").dropdown();

        $('#table1').DataTable({
          order: [[0, 'desc']],
        });
      });

      
      

    </script>

    <style>
      .dropdown-toggle::after {
          content: none;
      }  
    </style>


    <title>Admin_page</title>
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
          if(isset($_SESSION['admin_id'])){
            $admin_name=$_SESSION['admin_name'];
          
          ?>
          <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink" style="width:30vw;">
            <div class="dropdown-header">
              <div class="d-flex flex-column justify-content-center ">
                <img src="images/user_img1.jpg" alt="User" class="rounded-circle mx-auto" style="width:50px;height:50px;">
                <h1 class="text-center"><?= $admin_name ?></h1>
              </div>
            </div>
            <div class="dropdown-divider"></div>

            <a class="dropdown-item btn btn-outline-success my-1" href="#">
              <i class="bi bi-pencil-square"></i>&nbsp;Edit profile
            </a>
            <div class="dropdown-divider"></div>
            
            <a class="btn btn-outline-dark dropdown-item my-1 all" type="button" href="admin1.php?filter=all">Home</a>
            <a class="btn btn-outline-success dropdown-item my-1 upcoming" href="admin1.php?filter=upcoming">Up-coming events</a>
            <a class="btn btn-outline-danger dropdown-item my-1 expired" href="admin1.php?filter=expired">Expired events</a>

            <div class="dropdown-item dropdown">
              <button class="p-0 btn dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Priority
              </button>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item pri-high" href="admin_page.php?filter=high">High</a>
                <a class="dropdown-item pri-med" href="admin_page.php?filter=medium">Medium</a>
                <a class="dropdown-item pri-low" href="admin_page.php?filter=low">Low</a>
              </div>
            </div>
            
            <div class="dropdown-divider"></div>
            <a class="dropdown-item btn btn-outline-danger my-1" href="admin_logout.php">
              <i class="bi bi-box-arrow-right"></i>&nbsp;Log out
            </a>
          </div>
          <?php
          }
          else{
            ?>
            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink" style="width:30vw;">
            

            <a class="dropdown-item btn btn-outline-primary my-1" href="admin_login.php">Log in Admin</a>
            
            
          </div>
            <?php
          }
          ?>
        </div>
        
 <!-- ##################################################################################### -->
        
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item mx-2">
              <a class="btn btn-outline-dark all" href="admin_page.php?filter=all" role="button">Home</a>
            </li>
            <li class="nav-item mx-2">
              <a  href="admin_page.php?filter=upcoming" class="btn btn-outline-success upcoming" >Up coming Events</a>
            </li>
            <li class="nav-item mx-2" >
              <a href="admin_page.php?filter=expired" class="btn btn-outline-danger expired" >Expired Events</a>
            </li>
            <li class="nav-item dropdown mx-2">
              <a class="btn btn-outline-dark dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Priority
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item pri-high" href="admin_page.php?filter=high">High</a>
                <a class="dropdown-item pri-med" href="admin_page.php?filter=medium">Medium</a>
                <a class="dropdown-item pri-low" href="admin_page.php?filter=low">Low</a>
              </div>
            </li>
            <li class="nav-item mx-2" >
              <a href="admin_page.php?filter=approved" class="btn btn-success expired" >Approved</a>
            </li>
            <li class="nav-item mx-2" >
              <a href="admin_page.php?filter=not_approve" class="btn btn-danger expired" >Not approved</a>
            </li>
            <li class="nav-item mx-2" >
              <a href="customers_list.php" class="btn btn-outline-dark expired" >Customers</a>
            </li>
          </ul> 
 <!-- ##################################################################################### -->

          <?php
          if(isset($_SESSION['admin_id'])){
            $admin_name=$_SESSION['admin_name'];
          
          ?>
          <div class="dropdown show ms-auto me-3">
            <a class=" dropdown-toggle " href="#" role="button" id="dropdownUser" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <img src="images/user_img1.jpg" alt="User" class="rounded-circle" style="width:75px;height:75px;">
            </a>
          
            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownUser" style="width:20vw;">
              <div class="dropdown-header">
                <div class="d-flex flex-column justify-content-center mb-3">
                  <img src="images/user_img1.jpg" alt="User" class="rounded-circle mx-auto" style="width:75px;height:75px;">
                  <h1 class="text-center"><?= $admin_name ?></h1>
                </div>
              </div>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item btn btn-outline-success my-3" href="#">
                <i class="bi bi-pencil-square"></i>&nbsp;Edit profile
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item btn btn-outline-danger my-3" href="admin_logout.php">
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
              <a class="dropdown-item btn btn-outline-success my-3" href="admin_login.php">Admin Login</a>
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

    <div class="table-responsive" id="event_table">
        <table class="table table-hover" id="table1">
            <thead>
                <tr>
                    <th>id</th>
                    <th>Title</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Status</th>
                    <th>Priority</th>
                    <th>Author</th>
                    <th>View</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                
            
        <?php

        $filter=@$_GET['filter'];
        $sql="";

        switch($filter){

            case 'expired':{$sql="SELECT * FROM new_event WHERE (status='Expired!') ORDER BY id DESC";break;}  
            case 'upcoming':{$sql="SELECT * FROM new_event WHERE (status='Upcoming!') ORDER BY id DESC";break;}
            case 'high':{$sql="SELECT * FROM new_event WHERE (priority='High') ORDER BY id DESC";break;}
            case 'medium':{$sql="SELECT * FROM new_event WHERE (priority='Medium') ORDER BY id DESC";break;}
            case 'low':{$sql="SELECT * FROM new_event WHERE (priority='Low') ORDER BY id DESC";break;}
            case 'all':{$sql="SELECT * FROM new_event ORDER BY id DESC" ; break;}
            case 'not_approve':{$sql="SELECT * FROM new_event WHERE (approve=0) ORDER BY id DESC"; break;}
            case 'approved':{$sql="SELECT * FROM new_event WHERE (approve=1) ORDER BY id DESC"; break;}
            default:{$sql="SELECT * FROM new_event ORDER BY id DESC"; break;}
        
        }
        $result=$conn->query($sql);

        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                if($row['status'] == 'Upcoming!'){
                    $color="text-success";
                }
                else{
                    $color="text-danger";
                }
        ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['title'] ?></td>
                <td><?= $row['date'] ?></td>
                <td><?= $row['time'] ?></td>
                <td class="fw-bold <?=$color?>"><?= $row['status'] ?></td>
                <td><?= $row['priority'] ?></td>
                <td><?= $row['author_name'] ?></td>
                <td><a href="detailed_view.php?id=<?= $row['id'] ?>" class="btn btn-primary">View</a></td>
                <?php if($row['approve'] == 0){
                  ?>
                    <td><a href="admin_page.php?approve=1&approve_id=<?= $row['id'] ?>" class="btn btn-success">Approve</a></td>
                <?php     
                }
                else{
                  ?>
                  <td><a href="admin_page.php?remove=1&remove_id=<?= $row['id'] ?>" class="btn btn-danger">Remove</a></td>
                  <?php
                }
               ?> 
                </tr>
        
        <?php 
        
    }
}
else{
    echo "<h2>Nothing to show</h2>";
}

$approve_state=@$_GET['approve'];
$approve_id=@$_GET['approve_id'];
if($approve_state){
    $sql="UPDATE new_event SET approve=1 WHERE id=$approve_id";
    if($conn->query($sql)){
      echo "<script>alert('event approved'); window.location.href='admin_page.php';</script>";
    }
}

$remove_status=@$_GET['remove'];
$remove_id=@$_GET['remove_id'];
if($remove_id){
  $sql="DELETE FROM new_event WHERE id=$remove_id";
  if($conn->query($sql)){
    echo "<script>alert('event removed'); window.location.href='admin_page.php';</script>";
  }
}



?>  
            </tbody>
        </table>
    </div>

  </div> 
  
</body>
</html>