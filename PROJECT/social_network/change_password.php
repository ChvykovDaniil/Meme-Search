<!DOCTYPE html>
<?php
session_start();
include("includes/connection.php");

if(!isset($_SESSION['user_email'])){
    header("location: index.php");
}
?>
<html>
<head>
    <title>Забытый пароль</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<style>
    body{
        overflow-x: hidden;
    }
    .main-content{
        width: 50%;
        height: 40%;
        margin: 10px auto;
        background-color: #fff;
        border: 2px solid #e6e6e6;
        padding: 40px 50px;
    }
    .header{
        border: 0px solid #000;
        margin-bottom: 5px;
    }
    .well{
        background-color: #187FAB;
    }
    #signup{
        width: 60%;
        border-radius: 30px;
    }
</style>
<body>
<div class="row">
    <div class="cpl-sm-12">
        <div class="well">
            <center><h1 style="color: white;"><strong>Meme-Search</strong></h1></center>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="main-content">
            <div class="header">
                <h3 style="text-align: center;"><strong>Изменить пароль</strong></h3><hr>
            </div>
            <div class="l_pass">
                <form action="" method="post">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input id="password" type="password" class="form-control" name="pass" placeholder="Новый пароль" required>
                    </div><br>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input id="password" type="password" class="form-control" placeholder="Повторите ваш пароль" name="pass1" required>
                    </div><br>
                    <center><button id="signup" class="btn btn-info btn-lg" name="change">Изменить пароль</button></center>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
<?php
    if(isset($_POST['change'])){

        $user = $_SESSION['user_email'];
        $get_user = "select * from users where user_email='$user'";
        $run_user = mysqli_query($con, $get_user);
        $row = mysqli_fetch_array($run_user);

        $user_id = $row['user_id'];

        $pass = htmlentities(mysqli_real_escape_string($con, $_POST['pass']));
        $pass1 = htmlentities(mysqli_real_escape_string($con, $_POST['pass1']));

        if($pass == $pass1){
            if(strlen($pass) >= 6 && strlen($pass) <= 60){
                $update = "update users set user_pass='$pass' where user_id='$user_id'";

                $run = mysqli_query($con, $update);
                echo"<script>alert('Ваш пароль был только что изменен')</script>";
                echo"<script>window.open('home.php', '_self')</script>";
            }
            else{
                echo"<script>alert('Ващ пароль должен состоять из более чем 6 символов')</script>";
            }
        }
        else{
            echo"<script>alert('Ваши пароли не cовпадают')</script>";
            echo"<script>window.open('change_password.php', '_self')</script>";
        }
    }
?>

