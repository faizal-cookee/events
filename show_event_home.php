<?php 
session_start();
require "connection.php";
?>
<?php

$sql = "";
$color="";

$filter=$_GET['filter'];

switch($filter){

    case 'expired':{$sql="SELECT * FROM new_event WHERE (status='Expired!' AND approve=1 AND active=1) ORDER BY id DESC";break;}  
    case 'upcoming':{$sql="SELECT * FROM new_event WHERE (status='Upcoming!' AND approve=1 AND active=1) ORDER BY id DESC";break;}
    case 'pri-high':{$sql="SELECT * FROM new_event WHERE (priority='High' AND approve=1 AND active=1) ORDER BY id DESC";break;}
    case 'pri-med':{$sql="SELECT * FROM new_event WHERE (priority='Medium' AND approve=1 AND active=1) ORDER BY id DESC";break;}
    case 'pri-low':{$sql="SELECT * FROM new_event WHERE (priority='Low' AND approve=1 AND active=1) ORDER BY id DESC";break;}
    case 'all':{$sql="SELECT * FROM new_event WHERE approve=1 AND active=1 ORDER BY id DESC"; break;}
    default:{$sql="SELECT * FROM new_event WHERE approve=1 AND active=1 ORDER BY id DESC"; break;}

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
        $path="";
        if($row['thumbnail_img']){
            $path="uploads/thumbnails/";
            $path= $path.$row['thumbnail_img'];
        }
        else{
            $path="images/default_img.png";
        }
        ?>

        <div class="card px-0 m-5" style="width: 18rem;">
            <img class="card-img-top" src="<?= $path ?>">
            <div class="card-body">
                <div class="row">
                        <div class="col-8">
                        <h1 class="card-title"><?= $row['title']?></h1>
                        </div>
                        <div class="col-4 <?= $color ?> px-0 fw-bold">
                        <p><?= $row['status'] ?></p>
                        </div>
                </div>
                <h6 class="card-subtitle text-muted mt-3">Priority: <span><?= $row['priority'] ?></span></h6>
                <p class="card-text mt-3">Event Date: <span><?= $row['date'] ?></span></p>
                <p class="card-text">Event Time: <span><?= $row['time'] ?></span></p>
                <p class="card-text">Author: <span><?= $row['author_name'] ?></span></p>
                <div class="row">
                        <div class="col-8">
                        <a href="detailed_view.php?id=<?= $row['id'] ?>" class="btn btn-primary">View</a>
                        </div>
                        <div class="col-4 ">
                            
                        <a href="new_event.php?id=<?= $row['id'] ?>" class="btn btn-success">Edit</a>
                        
                        </div>
                </div>
                
            </div>
        </div>
        
        <?php 
        
    }
}

else{
    echo "<h2>Nothing to show</h2>";
}

?>