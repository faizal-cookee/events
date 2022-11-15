<?php
session_start();
require "connection.php";

$id=$_GET['id'];

$sql="SELECT * FROM new_event WHERE id=$id";
$result = $conn->query($sql);
$color="";

if($result->num_rows > 0){
    $row = $result->fetch_assoc();
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


    


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detailed page</title>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" />

</head>
<body>
    
    <div class=" container py-5 px-auto">
        <div class="row px-auto ">
            <div class="col-md-8 col-sm-12 col-lg-6 bg-light mx-auto rounded p-3">
                <h4 class="text-end <?= $color ?> fs-bold"><?= $row['status'] ?></h4>
                <div class="d-flex justify-content-center mt-2">
                    <img src="<?= $path ?>" style="width:50%;height:auto;">
                </div>
                <h1 class="text-center mt-5"><?= $row['title'] ?></h1>
                <div class="container">
                    <h4 class="mt-3">Priority : <?= $row['priority'] ?></h4>
                    <h4 class="mt-3">Event Date : <?= $row['date'] ?></h4>
                    <h4 class="mt-3">Event Time : <?= $row['time'] ?></h4>
                    <h4>Description: </h4>
                    <p class="fs-5">&emsp;<?= $row['description'] ?></p>
                    
                
                <h4>Images : </h4>
                <div class="row">
            <?php
                $row_id = $row['id'];
                $sql1="SELECT * FROM images_url WHERE event_id = $row_id ";

                $image_loc="uploads/event_images/";
                $result1= $conn->query($sql1);
                if($result1->num_rows > 0){
                    while($img = $result1->fetch_assoc()){
                        $img_path = $image_loc . $img['img_url'];
                        ?>
                        <img src="<?= $img_path ?>" class=" mt-3" style="width:45%;height:auto;">
                        <?php
                    }
                }
            ?>
                </div>

                </div>


                
            </div>
        </div>
    </div>
</body>
</html>

<?php
}
?>