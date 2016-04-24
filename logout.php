<?php
    session_start();

//    if( !isset($_POST['submit']) ) {
//        exit('非法访问!');
//    }

    //注销登录
    unset($_SESSION['userid']);
    unset($_SESSION['username']);
    $url = "login.html";
    echo '注销成功！ 正在转向登录页<a href="login.html">重新登录</a>';
    echo "<script language='javascript' type='text/javascript'>";
    echo "window.location.href='$url'";
    echo "</script>";
    exit;


?>