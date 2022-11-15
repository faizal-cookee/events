<?php 
session_start();
require 'connection.php';
?>

<?php

$event_id=@$_GET['id'];

$event_title="";
$event_date="";
$event_time="";
$event_priority="";
$event_description="";
$event_thumb="";
$id_exist=false;

if($event_id){
    $sql="SELECT * FROM new_event WHERE id=$event_id";
    $result = $conn->query($sql);

    if($result->num_rows > 0){
        $row = $result->fetch_assoc();

        $id_exist=true;
        $event_title=$row['title'];
        $event_date=$row['date'];
        $event_time=$row['time'];
        $event_priority=$row['priority'];
        $event_description=$row['description'];;

        if($row['thumbnail_img']){
            $event_thumb="uploads/thumbnails/";
            $event_thumb= $event_thumb . $row['thumbnail_img'];
        }
        else{
            $event_thumb="";
        }
    }
}


if($_POST){

    $valid_extensions= array('jpeg', 'jpg', 'png');
    $error="";
    
    
    $title=$_POST['title'];
    $date=$_POST['date'];
    $time=$_POST['time'];
    $priority=$_POST['priority'];
    $description=$_POST['description'];

    $author_name=$_SESSION['username'];

    $status="";
    $current_date = date("Y-m-d") ;
    if($date > $current_date){
        $status='Upcoming!';
    }
    else{
        $status= 'Expired!';
    }


    if($_FILES['thumb_upload']){
        $path="uploads/thumbnails/";

        $img=$_FILES['thumb_upload']['name'];
        $temp=$_FILES['thumb_upload']['tmp_name'];

        $ext=strtolower(pathinfo($img, PATHINFO_EXTENSION));

        $final_img=rand(1000,10000).$img;
        

        if(in_array($ext, $valid_extensions)){
            $path=$path.strtolower($final_img);
            

            if(!move_uploaded_file($temp, $path)){
                echo "img upload failed";
                $final_img="";
                
            }
            
        }
        else{
            $final_img="";
        }
        
        
    }
    else{
        echo "no images uploaded";
    }
    
    if(!$final_img){
        $final_img=$row['thumbnail_img'];
    }
    
    if($id_exist){
        
        $sql = "UPDATE new_event SET title='$title', date='$date', time='$time', status='$status', priority='$priority', thumbnail_img='$final_img' WHERE id=$event_id";
    }
    else{
        $sql="INSERT INTO new_event VALUES(NULL, '$title', '$date', '$time','$status', '$priority', '$description','$author_name', '$final_img','')";
    }   

    $last_id="";
    if($conn->query($sql)){
        $last_id = $conn->insert_id;
        echo "<script>alert('successfully added new event')</script>"; 
        $error="";   
    }
    else{
        echo "<script>alert('failed to add new event'); window.location.href='index.php';</script>";
    }

    $multi_image_path="";
    if(!$id_exist){
    if($_FILES['image_upload']){
        
        
        $img_names= array_filter($_FILES['image_upload']['name']);
        if(!empty($img_names)){
            foreach($_FILES['image_upload']['name'] as $key=>$value){
                $img_path="uploads/event_images/";
                $img_name=basename($_FILES['image_upload']['name'][$key]);
                
                $img_name=rand(1000,10000).$img_name;
                $img_path= $img_path. $img_name;

                $ext = strtolower(pathinfo($img_name, PATHINFO_EXTENSION));

                if(in_array($ext, $valid_extensions)){
                    if(move_uploaded_file($_FILES['image_upload']['tmp_name'][$key], $img_path)){
                        $sql = "INSERT INTO images_url VALUES(NULL, '$img_name',$last_id)";
                        if(!$conn->query($sql)){
                            $error="image upload failed";
                        }
                    }
                    else{
                        $error="image upload failed";
                    }
                }
                else{
                    $error="invalid extensions";
                }
                
                
            }
        }
    }
    }

    if($error == ""){
        echo "<script> window.location.href='index.php' </script>";
    }
    else{
        echo "$error";
    }

    
    

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
    
    <title>New Event</title>
</head>
<body>
    <div class=" container py-5 px-auto">
        <div class="row px-auto ">
            <div class="col-md-8 col-sm-12 col-lg-6 bg-light mx-auto rounded p-3">

                <form method="post" action="" enctype="multipart/form-data">

                <h1 class="text-center mt-5 bg-success text-light py-2 mb-5">New Event</h1>
                
                <div class="form-floating mt-5">
                    <input type="text" class="form-control" name="title" id="title" placeholder="Title" value="<?= $event_title ?>" required>
                    <label for="title">Title</label>
                </div>

                <div class=" mb-3 mt-5">
                    <label for="event_date" class="form-label">Date of Event : </label>
                    <input type="date" id="event_date" name="date" required  value="<?= $event_date ?>">
                </div>

                <div class=" mb-3 mt-5">
                    <label for="event_time" class="form-label">Time of Event : </label>
                    <input type="time" id="event_time" name="time" value="<?= $event_time ?>">
                </div>

                <div class="mb-3 mt-5 d-flex justify-content-between">
                    <label  class="form-label">Priority : </label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="priority" id="priority_top"
                        <?php if (isset($event_priority) && $event_priority=="High") echo "checked";?> value="High" required>
                        <label class="form-check-label" for="inlineRadio1">High</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="priority" id="priority_medium"
                        <?php if (isset($event_priority) && $event_priority=="Medium") echo "checked";?> value="Medium" required>
                        <label class="form-check-label" for="inlineRadio1">Medium</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="priority" id="priority_low"
                        <?php if (isset($event_priority) && $event_priority=="Low") echo "checked";?> value="Low" required>
                        <label class="form-check-label" for="inlineRadio1">Low</label>
                    </div>
                </div>

                <div class="form-floating mt-5">
                    <textarea class="form-control" placeholder="Leave a comment here" name="description" id="description" style="height: 100px"><?= $event_description ?></textarea>
                    <label for="floatingTextarea2">Description</label>
                </div>

                <div class="mb-5 mt-5">
                    <label for="thumb_upload" class="form-label border border-primary p-3 rounded bg-primary text-light">
                        Upload Thumbnail&nbsp;<i class="bi bi-upload"></i>
                     </label>
                    <input class="form-control upload_btn" type="file" accept=".jpg, .png, .jpeg" name="thumb_upload" id="thumb_upload">
                </div>

                <div class=" mt-5 f-flex justify-content-center">
                    <img src="<?= $event_thumb ?>" id="preview_img" style="width:50% ; height:auto;">
                </div>
                <div class="">
                    <p id="err"></p>
                </div>

                <div class=" mt-5">
                    <label for="image_upload" class="form-label border border-primary p-3 rounded bg-primary text-light">
                        Upload Event images&nbsp;<i class="bi bi-upload"></i>
                     </label>
                    <input class="form-control upload_btn" type="file" accept=".jpg, .png, .jpeg" name="image_upload[]" id="image_upload" multiple>
                </div>
                <div class="mt-3" id="image_names">
                    
                </div>

                <div class="mb-5 mt-5 d-flex justify-content-around">
                    
                    <a href="index.php" id="discard" class="btn btn-danger btn-lg" >Discard</a>
                    <input class="btn btn-success btn-lg px-4" name="create" type="submit" value="Create" >
                </div>
                

            </form>
            </div>
        </div>
    </div>
    <style>
        .upload_btn{
            display:none;
        }
    </style>

    <script>
        $(document).ready(function(){

            $("#thumb_upload").change(function(){
                let file= $("#thumb_upload").get(0).files[0];

                if(file){
                    let reader= new FileReader();
                    reader.onload=function(){
                        $("#preview_img").attr("src", reader.result);
                    
                    }
                    reader.readAsDataURL(file);
                }

            })  

            $("#image_upload").change(function() {
                var files = $(this)[0].files;
                for (var i = 0; i < files.length; i++) {
                    $("#image_names").append("<p>"+(i+1)+".  "+files[i].name+"</p>");
                }
            });
            
            $("#discard").click(function(){
                $("#title").val()="";
                $("#date").val()="";
                $("#time").val()="";
                $("#description").val()="";
                alert('last activity was discarded');

            })
        })

       
    </script>
</body>
</html>

