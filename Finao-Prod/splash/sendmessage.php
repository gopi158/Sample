<?php 

    mysql_connect("10.209.172.2","finao_admin","U29yJF5C7noJjKL6");
    mysql_select_db("finaonation")or die( "<p><span style=\"color: red;\">Unable to select database</span></p>");
    $post_email = $_POST['txtEmail'];
    $post_ph = $_POST['txtPhone'];
    $ip = $_SERVER['REMOTE_ADDR'];
    $date=date("Y-m-d H:i:s");
    $result=MYSQL_QUERY("INSERT INTO splash_details (email,phone_num,ip,date) VALUES ('$post_email', '$post_ph', '$ip','$date')")or die( "<p><span style=\"color: red;\">Unable to select table</span></p>");
    mysql_close();
?>