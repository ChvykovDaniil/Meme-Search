<?php
$con = mysqli_connect("localhost","root","","social_network") or die("Соединение не было установлено");

if(isset($_GET['post_id'])){
    $post_id = $_GET['post_id'];
    $delete_post = "delete from posts where post_id = '$post_id'";

    $run_delete = mysqli_query($con, $delete_post);

    if($run_delete){
        echo "<script>alert('Ваша публикация была удалена!')</script>";
        echo "<script>window.open('../home.php', '_self')</script>";
    }
}
?>
