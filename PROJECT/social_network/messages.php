<!DOCTYPE html>
<?php
session_start();
include("includes/header.php");

if(!isset($_SESSION['user_email'])){
    header("location: index.php");
}
?>
<html>
<head>
    <title>Сообщения</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="style/home_style2.css">
</head>
<style>
    #scroll_messages{
        max-height: 500px;
        overflow: scroll
    }
    #btn-msg{
        width: 20%;
        height: 28px;
        border-radius: 5px;
        margin: 5px;
        border: none;
        color: #fff;
        float: right;
        background-color: #2ecc71;
    }
    #select_user{
        max-height: 500px;
        overflow: scroll
    }
    #green{
        background-color: #2ecc71;
        border-color: #27ae60;
        width: 45%;
        padding: 2.5px;
        font-size: 16px;
        border-radius: 3px;
        float: left;
        margin-bottom: 5px;
    }
    #blue{
        background-color: #3498db;
        border-color: #2980b9;
        width: 45%;
        padding: 2.5px;
        font-size: 16px;
        border-radius: 3px;
        float: right;
        margin-bottom: 5px;
    }

</style>
<body>
<div class="row">
    <?php
        if(isset($_GET['u_id'])){
            global $con;

            $get_id = $_GET['u_id'];
            $get_user = "select * from users where user_id='$get_id'";

            $run_user = mysqli_query($con, $get_user);
            $row_user = mysqli_fetch_array($run_user);

            $user_to_msg = $row_user['user_id'] ?? null;
            $user_to_name = $row_user['user_name'] ?? null;


        }
        $user = $_SESSION['user_email'];
        $get_user = "select * from users where user_email='$user'";
        $run_user = mysqli_query($con, $get_user);
        $row = mysqli_fetch_array($run_user);

        $user_from_msg = $row['user_id'];
        $user_from_name = $row['user_name'];
    ?>
    <div class="col-sm-3" id="select_user">
        <?php
            $user = "select * from users";
            $run_user = mysqli_query($con, $user);
            while($row_user = mysqli_fetch_array($run_user)){

                $user_id = $row_user['user_id'];
                $user_name = $row_user['user_name'];
                $first_name = $row_user['f_name'];
                $last_name = $row_user['l_name'];
                $user_image = $row_user['user_image'];

                echo "
                    <div class='container-fluid'>
                        <a style='text-decoration: none; cursor: pointer; color: #3897f0;' href='messages.php?u_id=$user_id'>
                        <img class='img-circle' src='users/$user_image' width='90px' height='80px' title='$user_name'><strong>&nbsp $first_name $last_name</strong><br><br>
                        </a>
                    </div>
                ";
            }
        ?>
    </div>
    <div class="col-sm-6">
        <div class="load-msg" id="scroll_messages">
            <?php
                $sel_msg = "select * from user_messages where (user_to='$user_to_msg' AND user_from='$user_from_msg') OR (user_from='$user_to_msg' AND user_to='$user_from_msg') ORDER by 1 ASC";
                $run_msg = mysqli_query($con, $sel_msg);
                while($row_msg = mysqli_fetch_array($run_msg)){

                    $user_to = $row_msg['user_to'];
                    $user_from = $row_msg['user_from'];
                    $msg_body = $row_msg['msg_body'];
                    $msg_date = $row_msg['date'];
                    ?>

                    <div id="loaded_msg">
                        <p><?php if($user_to ==$user_to_msg AND $user_from == $user_from_msg){echo "<div class='message' id='blue' data-toggle='tooltip' title='$msg_date'>$msg_body</div><br><br><br>";}
                            else if ($user_from == $user_to_msg AND $user_to == $user_from_msg){echo "<div class='message' id='green' data-toggle='tooltip' title='$msg_date'>$msg_body</div><br><br><br>";}?></p>
                    </div>
                    <?php
                }
            ?>

        </div>
        <?php
            if(isset($_GET['u_id'])){
                $u_id = $_GET['u_id'];
                if($u_id == "new"){
                    echo '
                        <form>
                            <center><h3>Выберите кого-нибудь, чтобы начать разговор</h3></center>
                            <textarea disabled class="form-control" placeholder="Отправить ваше сообщение"></textarea>
                            <input type="submit" class="btn btn-default" disabled value="Отправить">
                        </form><br<br>
                    ';
                }
                else{
                    echo '
                        <form action="" method="POST">
                            <textarea class="form-control" placeholder="Отправить ваше сообщение" name="msg_box" id="message_textarea"></textarea>
                            <input type="submit" name="send_msg" id="btn_msg" value="Отправить">
                        </form><br<br>
                    ';
                }
            }
        ?>

        <?php
            if(isset($_POST['send_msg'])){
                $msg = htmlentities($_POST['msg_box']);

                if($msg == ""){
                    echo "<h4 style='color: red; text-align: center;'>Сообщение не удалось отправить!</h4>";
                }else if(strlen($msg) > 37) {
                    echo "<h4 style='color: red; text-align: center;'>Сообщение слишком длинное! Используйте только 37 символов</h4>";
                }else{
                    $insert = "insert into user_messages(user_to, user_from, msg_body, date, msg_seen) values('$user_to_msg', '$user_from_msg', '$msg', NOW(), 'no')";

                    $run_insert = mysqli_query($con, $insert);
                }
            }
        ?>
    </div>
    <div class="col-sm-3">
        <?php
            if(isset($_GET['u_id'])){
                global $con;

                $get_id = $_GET['u_id'];
                $get_user = "select * from users where user_id='$get_id'";
                $run_user = mysqli_query($con, $get_user);
                $row = mysqli_fetch_array($run_user);

                $user_id = $row['user_id'] ?? null;
                $user_image = $row['user_image'] ?? null;
                $user_name = $row['user_name'] ?? null;
                $f_name = $row['f_name'] ?? null;
                $l_name = $row['l_name'] ?? null;
                $describe_user = $row['describe_user'] ?? null;
                $country = $row['user_country'] ?? null;
                $gender = $row['user_gender'] ?? null;
                $register_date = $row['user_reg_date'] ?? null;
            }
            if($get_id =="new"){

            }else{
                echo"
                    <div class='row'>
                        <div class='col-sm-2'>
                        </div>
                        <center>
                            <div style='background-color: #e6e6e6;' class='col-sm-9'>
                                <h2>Информация</h2>
                                <img class='img-circle' src='users/$user_image' width='150' height='150'>
                                <br><br>
                                <ul class='list-group'>
                                    <li class='list-group-item' title='Имя пользователя'><strong>$f_name $l_name</strong></li>
                                    <li class='list-group-item' title='Статус пользователя'><strong style='color: grey;'>$describe_user</strong></li>
                                    <li class='list-group-item' title='Пол'>$gender</li>
                                    <li class='list-group-item' title='Страна'>$country</li>
                                    <li class='list-group-item' title='Дата регистрации'>$register_date</li>
                                </ul>
                            </div>
                        <div class='col-sm-1'>
                        </div>
                    </div>
                ";
            }
        ?>    
    </div>
</div>
<script>
    var div = document.getElementById("scroll_messages");
    div.scrollTop = div.scrollHeight;
</script>
</body>
</html>
