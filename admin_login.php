<?php 
session_start();
require 'connection.php';
?>
<?php
$flag=true;
if(isset($_POST['login'])){

    $email = $_POST['user_email'];
    $pass = $_POST['user_pass'];

    $sql="SELECT * FROM admin WHERE(email='$email' AND password='$pass')";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    if($result->num_rows > 0){
        $_SESSION['admin_id']=$row['id'];
        $_SESSION['admin_name'] = $row['name'];

        if(isset($_SESSION['admin_id'])){
            header("Location:admin_page.php");
        }
        
    }
    else{
        $flag=false;

    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin-Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>        
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

</head>
<body>
    <div class=" container py-5 px-auto">
            <div class="row px-auto ">
                <div class="col-md-6 col-sm-12 col-lg-4 bg-dark mx-auto rounded">
                    <div class="container-fluid">

                        <form method="post" >
                        <p class=" mt-5 mb-0 text-center text-danger" id="invalid" style="display:none ;">
                            Invalid credentials
                        </p>
                            <h1 class="text-center text-primary mt-5 mb-3">Admin Log-in</h1>


                            <div class="form-floating  mt-5">
                                <input type="email" class="form-control" name="user_email" id="user_email" required>
                                <label for="user_email ">Email</label>
                                <p class="text-danger" id="email_error"></p>
                            </div>
                            <div class="form-floating  mt-5">
                                <input type="password" class="form-control" name="user_pass" id="user_pass" required >
                                <label for="user_pass ">Password</label>
                                <p class="text-danger" id="pass_error"></p>
                            </div>
                            <div class="mt-5 d-flex justify-content-center mb-5">
                                <input type="submit" class="btn btn-primary btn-lg px-5 " name="login" value="Log-in" id="login_btn">
                            </div>
                        </form>
                    </div>
                </div>
                
            </div>


    </div>
    
    <script>
        $(document).ready(function(){
            let error= true;

            let pwdUpper = /[A-Z]+/;
            let pwdLower = /[a-z]+/;
            let pwdNumber = /[0-9]+/;
            let pwdSpecial = /[!@#$%^&()'[\]"?+-/*={}.,;:_]+/;
            let pwdLength = /^.{8,16}$/;

            submit_check(error);

            $("#user_email").blur(function(){
                error = empty_check("#user_email","#email_error");
                submit_check(error);
            })

            $("#user_pass").blur(function(){
                error = passLen("#user_pass","#pass_error");
                submit_check(error);
            })
            $("#user_pass").keyup(function(){
                error = passLen("#user_pass","#pass_error");
                submit_check(error);
            })

            

            function passLen(id, error_id){
                let pass=$(id).val();
                let error=true;

                if(pwdLength.test(pass)){
                    $(error_id).text("");
                    return false;
                }
                else{
                    $(error_id).text("password length must be 8-16 chars");
                    return true;
                }
            }
            
            function empty_check(id, error_id){
                let error=true;
                let field=$(id).val();
                if(field.length<=0){
                    $(error_id).text("This field is required");
                    return true;
                }
                else{
                    $(error_id).text("");
                    return false;
                }
            }

            function submit_check(error){
                if (error){
                    $("#login_btn").attr('disabled', 'disabled');
                }
                else{
                    $("#login_btn").removeAttr('disabled');
                }
            }

            
        })
    </script>
</body>
</html>

<?php
if(!$flag){
    echo "<script>document.getElementById('invalid').style.display='block';</script>";
}

?>
