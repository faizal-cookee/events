<?php 
session_start();
require 'connection.php';
?>
<?php
$signup_fail=false;
$email_exist=false;
if (isset($_POST['signup'])){

    $fname=$_POST['user_fname'];
    $email=$_POST['user_email'];
    $pass=$_POST['user_pass'];
    $phno=$_POST['phno'];
    $phno=(int)$phno;

    $sql="SELECT * FROM user WHERE(email='$email')";
    $result=$conn->query($sql);

    if(!$result->num_rows > 0){
        $sql = "INSERT INTO user VALUES (NULL, '$fname', '$email', '$pass', $phno,'')";

        if ($conn->query($sql) === TRUE) {
            header('Location: user_login.php ');
            
        } else {
            $signup_fail=true;
        }
    }
    else{
        $email_exist=true;
    }
    $email="";
    $fname="";
    $phno="";
    $pass="";

    $_POST['user_fname']="";
    $_POST['user_email']="";
    $_POST['user_pass']="";
    $_POST['phno']="";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User-signup</title>

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


                        <form method="post" action="" name="sign_up" id="signup_form">

                            <p class=" mt-5 mb-0 text-center text-danger" id="email_exist" style="display:none;">email already exist</p>
                            <p class=" mt-5 mb-0 text-center text-danger" id="failed" style="display:none;">sign-up failed</p>

                            
                            <h1 class="text-center text-primary mt-5 mb-3">Sign-up</h1>


                            <div class="form-floating  mt-5">
                                <input type="text" class="form-control" id="user_fname" name="user_fname" required>
                                <label for="user_fname ">Full Name</label>
                                <p class="text-danger" id="fname_error"></p>
                            </div>
                            <div class="form-floating  mt-5">
                                <input type="email" class="form-control" id="user_email" name="user_email" required>
                                <label for="user_email ">Email</label>
                                <p class="text-danger" id="email_error"></p>
                            </div>
                            <div class="form-floating  mt-5">
                                <input type="password" class="form-control" id="user_pass" name="user_pass" required >
                                <label for="user_pass ">Password</label>
                                <p class="text-danger" id="pass_error"></p>
                            </div>
                            <div class="form-floating  mt-5">
                                <input type="password" class="form-control" id="user_cpass" required>
                                <label for="user_cpass ">Confirm Password</label>
                                <p class="text-danger" id="cpass_error"></p>
                            </div>
                            <div class="form-floating  mt-5">
                                <input type="text" class="form-control" id="phno" name="phno" required>
                                <label for="phno ">Phone Number</label>
                                <p class="text-danger" id="phno_error"></p>
                            </div>
                            
                            <div class=" mt-5 ">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="TC" value="conditionOK" required>
                                    <label class="form-check-label text-light" for="T&C">I Accept all the 
                                        <a href="#">Terms & Conditions</a>
                                    </label>
                                  </div>
                            </div>
                            
                            <div class="mt-5 d-flex justify-content-center mb-5">
                                <input type="submit" class="btn btn-primary btn-lg px-5 " value="Sign-up" name="signup" id="btn1">
                            </div>

                            <p class="text-light text-center mt-5" id="return_login">
                                <a href="user_login.php">Click here</a> &nbsp; to return Login page
                            </p>
                            
                            </div>
                        </form>
                    </div>
                </div>
                
            </div>


    </div>

    <script>
        $(function(){
            let error=true;
            let pwdUpper = /[A-Z]+/;
            let pwdLower = /[a-z]+/;
            let pwdNumber = /[0-9]+/;
            let pwdSpecial = /[!@#$%^&()'[\]"?+-/*={}.,;:_]+/;
            let pwdLength = /^.{8,16}$/;

            //////#########################################################################///////
            
            submit_check(error);

            $("#user_pass").blur(function(){
                error = passVal("#user_pass", "#pass_error");
                submit_check(error);
                error = passLen("#user_pass", "#pass_error");
                submit_check(error);
                
                
            })
            $("#user_fname").blur(function(){
                let name=$("#user_fname").val();

                error = empty_check("#user_fname", "#fname_error");

                if(pwdSpecial.test(name) || pwdNumber.test(name)){
                    $("#fname_error").text("name must not contain special chars or numbers");
                    error=true;
                    
                }
                else{
                    $("#fname_error").text("");
                    error=false;
                }
                submit_check(error);
            })
            $("#user_email").blur(function(){
                error = empty_check("#user_email", "#email_error");
                submit_check(error);
            })
            $("#phno").blur(function(){
                let phno= $("#phno").val();
                if(phno.length != 10){
                    $("#phno_error").text("phone number must be 10 digits");
                    error=true;
                    submit_check(error);
                }
                else{
                    $("#phno_error").text("");
                    error=false;
                    submit_check(error);
                }
            })
            
            //////#############################################################/////

            
            $("#user_pass").keyup(function(){
                error = passVal("#user_pass", "#pass_error");
                submit_check(error);
            })
            $("#user_cpass").blur(function(){
                error = cpass_Check("#user_pass","#user_cpass", "#cpass_error");
                submit_check(error);
            })
            $("#user_cpass").keyup(function(){
                error = cpass_Check("#user_pass","#user_cpass", "#cpass_error");
                submit_check(error);
            })

            $("#user_fname").keyup(function(){
                let name=$("#user_fname").val();

                if(pwdSpecial.test(name) || pwdNumber.test(name)){
                    $("#fname_error").text("name must not contain special chars or numbers");
                    error=true;
                    submit_check(error);
                }
                else{
                    $("#fname_error").text("");
                    error=false;
                    submit_check(error);
                }
            })


            $("#phno").keyup(function(){
                let phno=$("#phno").val();

                if(!pwdNumber.test(phno)){
                    

                    $("#phno_error").text("phone number conatin numbers only  ");
                    error=true;
                    submit_check(error);
                }
                else{
                    $("#phno_error").text("");
                    error=false;
                    submit_check(error);
                }
                
            })

            

            //////########################################################################///////////

            function submit_check(error){
                if (error){
                    $('#btn1').attr('disabled', 'disabled');
                }
                else{
                    $('#btn1').removeAttr('disabled');
                }
            }
            
            
            function cpass_Check(pass_id, cpass_id, error_id){
                let pass=$(pass_id).val();
                let cpass=$(cpass_id).val();
                let error=true;

                if( cpass != pass){
                    $(error_id).text("passwords must be same");
                    return true;
                }
                else{
                    $(error_id).text("");
                    return false;
                }
            }
            

            
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

            function passVal(id, error_id){
                let error=true;
                let pass=$(id).val();
    
                if(pwdUpper.test(pass) && pwdLower.test(pass) && pwdNumber.test(pass) && pwdSpecial.test(pass)){
                    $(error_id).text("");
                    return false;
                }
                else{
                    $(error_id).text("password must contain Uppercase, Lowercase, Number, Special chars");
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
        })
    </script>
    
    
</body>
</html>
<?php
if($email_exist){
    echo "email exist";
    echo "<script>document.getElementById('email_exist').style.display='block';</script>";
}
if($signup_fail){
    echo "<script>document.getElementById('email_exist').style.display='block';</script>";
}
?>


