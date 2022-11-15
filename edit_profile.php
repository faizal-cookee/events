<?php
session_start();
require "connection.php";

$user_id=$_SESSION['user_id'];
$sql = "SELECT * FROM user WHERE id=$user_id";
$result = $conn->query($sql);

if($result->num_rows > 0){
    $row=$result->fetch_assoc();
    if($row['profile_img']){
        $profile_img = $row['profile_img'];
    }
    else{
        $profile_img = "images/user_img.png";
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>        
    <!-- bootstrap icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" />
            

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <style>
        .img_upload{
            display: none;
        }
        
    </style>
    
</head>
<body>
    <div class=" container py-5 px-auto">
            <div class="row px-auto ">
                <div class="col-sm-12 col-md-8 col-lg-8  bg-light mx-auto rounded ">

                    <form method="post" action="" enctype="multipart/form-data">
                        
                    <h1 class="text-center mt-5 bg-success text-light py-2 mb-5">Edit profile</h1>

                    <div class="d-flex justify-content-center align-items-end  mt-5">
                        <img src="<?= $profile_img ?>" class="rounded-circle" style="width:10vw;height:auto;" name="user_img" id="user_img">

                        <label for="profile_upload" id="profile_label" class="bg-primary rounded py-2 px-3 text-white">
                            <input class="img_upload" type="file" accept=".jpg, .png, .jpeg" name="profile_upload" id="profile_upload">
                            <i class="bi bi-camera-fill"></i>
                          </label>
                    </div>
                        

                    <div class="form-floating  mt-5">
                        <input type="text" class="form-control" value="<?= $row['full_name'] ?>" id="user_fname" name="user_fname" style="width:30vw;">
                        <label for="user_fname ">Full Name</label>
                    </div>

                    <div class="form-floating  mt-5">
                        <input type="text" class="form-control" value="<?= $row['email'] ?>" id="user_email" name="user_email" style="width:30vw;">
                        <label for="user_email ">Email</label>
                    </div>

                    <div class="form-floating  mt-5 mb-5">
                        <input type="text" class="form-control" id="user_phno" value="<?= $row['phno'] ?>" name="user_phno" style="width:30vw;">
                        <label for="user_email ">Phone number</label>
                    
                    </div>

                    
                    <div class="mb-5 mt-5 d-flex justify-content-around">
                    
                        <a href="index.php" id="discard" class="btn btn-danger btn-lg" >Discard</a>
                        <input class="btn btn-success btn-lg px-4" name="edit" type="submit" value="Edit" >

                    </div>
                   
                    


                </form>
                </div>
            </div>
    </div>

    <script>
        $(document).ready(function(){
            $("#profile_upload").change(function(){
                let file= $("#profile_upload").get(0).files[0];

                if(file){
                    let reader= new FileReader();
                    reader.onload=function(){
                        $("#user_img").attr("src", reader.result);
                    
                    }
                    reader.readAsDataURL(file);
                }

            }) 
        })
    </script>
</body>
</html>

<?php
}

if(isset($_POST['edit'])){
    $name= $_POST['user_fname'];
    $email= $_POST['user_email'];
    $phno= $_POST['user_phno'];

    $final_img="";
    if($_FILES['profile_upload']){
        $valid_extensions= array('jpeg', 'jpg', 'png');
        $path="profiles/";

        $img=$_FILES['profile_upload']['name'];
        $temp=$_FILES['profile_upload']['tmp_name'];

        $ext=strtolower(pathinfo($img, PATHINFO_EXTENSION));

        $final_img=rand(1000,10000).$img;
        

        if(in_array($ext, $valid_extensions)){
            $path=$path.strtolower($final_img);
            

            if(!move_uploaded_file($temp, $path)){
                echo "img upload failed";
                $final_img="";
            }
            
        }
        else{$final_img="";}
        
    }

    $sql= "UPDATE user SET full_name = '$name', email = '$email', phno=$phno, profile_img='$final_img' WHERE id=$user_id";
    if($conn->query($sql)){
        echo "<script>alert('profile updated successfully')</script>";
        echo "<script> window.location.href='index.php'</script>";

    }
}


?>
