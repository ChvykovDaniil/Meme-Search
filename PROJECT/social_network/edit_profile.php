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
    <title>Настройки аккаунта</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="style/home_style2.css">
</head>
<body>
<div class="row">
    <div class="col-sm-2">
    </div>
    <div class="col-sm-8">
        <form action="" method="post" enctype="multipart/form-data">
            <table class="table table-bordered table-hover">
                <tr align="center">
                    <td colspan="6" class="active"><h2>Измени свой профиль</h2></td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Поменяй свое имя</td>
                    <td>
                        <input class="form-control" type="text" name="f_name" required value="<?php echo $first_name; ?>">
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Поменяй свою фамилию</td>
                    <td>
                        <input class="form-control" type="text" name="l_name" required value="<?php echo $last_name; ?>">
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Поменяй свой Юзернейм</td>
                    <td>
                        <input class="form-control" type="text" name="u_name" required value="<?php echo $user_name; ?>">
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Описание</td>
                    <td>
                        <input class="form-control" type="text" name="describe_user" required value="<?php echo $describe_user; ?>">
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Семейное положение</td>
                    <td>
                        <select class="form-control" name="Relationship">
                            <option><?php echo $Relationship_status?></option>
                            <option>Не женат</option>
                            <option>Встречаюсь</option>
                            <option>Влюблён</option>
                            <option>Все сложно</option>
                            <option>Женат</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Пароль</td>
                    <td>
                        <input class="form-control" type="password" name="u_pass" id="mypass" required value="<?php echo $user_pass; ?>">
                        <input type="checkbox" onclick="show_password()"><strong>Показать пароль</strong>
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Email</td>
                    <td>
                        <input class="form-control" type="email" name="u_email" required value="<?php echo $user_email; ?>">
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Страна</td>
                    <td>
                        <select class="form-control" name="u_country">
                            <option><?php echo $user_country;?></option>
                            <option>Российская Федерация</option>
                            <option>Республика Беларусь</option>
                            <option>Украина</option>
                            <option>Казахстан</option>
                            <option>Дагестан</option>
                            <option>Абхазия</option>
                            <option>Таджикистан</option>
                            <option>Узбекистан</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Пол</td>
                    <td>
                        <select class="form-control" name="u_gender">
                            <option><?php echo $user_gender;?></option>
                            <option>Мужчина</option>
                            <option>Женщина</option>
                            <option>Другой</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">День рождения</td>
                    <td>
                        <input class="form-control input-md" type="date" name="u_birthday" required value="<?php echo $user_birthday; ?>">
                    </td>
                </tr>

                <!-- Восстановление пароля -->
                <tr>
                    <td style="font-weight: bold;">Забытый пароль</td>
                    <td>
                        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal">Нажми</button>

                        <div id="myModal" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title"></h4>
                                    </div>
                                    <div class="modal-body">
                                        <form action="recovery.php?id=<?php echo $user_id;?>" method="post" id="f">
                                            <strong>Назовите имя вашего лучшего друга</strong>
                                            <textarea class="form-control" cols="83" rows="4" name="content" placeholder="Кто же он?"></textarea><br>
                                            <input class="btn btn-default" type="submit" name="sub" value="Подтвердить" style="width: 100px"><br><br>
                                            <pre>Ответ на этот вопрос мы будем использовать для восстановления вашего <br>пароля.</pre>
                                            <br><br>
                                        </form>
                                        <?php
                                            if(isset($_POST['sub'])){
                                                $bfn = htmlentities($_POST['content']);

                                                if($bfn ==''){
                                                    echo"<script> alert('Введите что-нибудь')</script>";
                                                    echo"<script>window.open('edit_profile.php?u_id$user_id', '_self')</script>";

                                                    exit();
                                                }
                                                else{
                                                    $update = "update users set recovery_account='$bfn' where user_id='$user_id'";
                                                    $run = mysqli_query($con, $update);
                                                    if($run){
                                                        echo"<script>alert('Выполняется...')</script>";
                                                        echo"<script>window.open('edit_profile.php?u_id$user_id', '_self')</script>";
                                                    }else{
                                                        echo"<script>alert('Ошибка во время обновления информации')</script>";
                                                        echo"<script>window.open('edit_profile.php?u_id$user_id', '_self')</script>";
                                                    }
                                                }
                                            }
                                        ?>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr align="center">
                    <td colspan="6">
                    <input type="submit" class="btn btn-info" name="update" style="width: 250px;" value="Изменить">
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <div class="col=sm-2">
    </div>
</div>
</body>
</html>
<?php
    if(isset($_POST['update'])){
        $f_name = htmlentities($_POST['f_name']);
        $l_name = htmlentities($_POST['l_name']);
        $u_name = htmlentities($_POST['u_name']);
        $describe_user = htmlentities($_POST['describe_user']);
        $Relationship_status = htmlentities($_POST['Relationship']);
        $u_pass = htmlentities($_POST['u_pass']);
        $u_email = htmlentities($_POST['u_email']);
        $u_country = htmlentities($_POST['u_country']);
        $u_gender = htmlentities($_POST['u_gender']);
        $u_birthday = htmlentities($_POST['u_birthday']);

        $update = "update users set f_name='$f_name', l_name='$l_name', user_name='$u_name', describe_user='$describe_user', Relationship='$Relationship_status', user_pass='$u_pass', 
        user_email='$u_email', user_country='$u_country', user_gender='$u_gender', user_birthday='$u_birthday ' where user_id='$user_id'";
        $run = mysqli_query($con, $update);
        if($run){
            echo"<script>alert('Ваш профиль обновлен')</script>";
            echo"<script>window.open('edit_profile.php?u_id$user_id', '_self')</script>";
        }
    }
?>