<?php
    echo "<head>";
    echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"res/css/bootstrap.css\" />";
    echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"res/css/callout.css\" />";
    echo "<script src=\"res/js/bootstrap.js\"></script>";
    echo "</head>";

    session_start();

    //check if current user has loged in
    if(!isset($_SESSION['userid'])){
        header("Location:login.html");
        exit();
    }

    include('config.php');

    $username = $_GET['u'];

    //list user info
    $sql = "SELECT uid,username,email,regdate FROM user WHERE username = '$username'";
    $result = $mysqli->query($sql);
    $row = $result->fetch_assoc();
    $uid = $row['uid'];

    //list user info
    $query2 = "select roleID from userrole where userID='$uid'";
    $result2 = $mysqli->query($query2);
    $row2 = $result2->fetch_array(MYSQLI_NUM);
    $roleID = $row2[0];
    $query3 = "select roleName from role where roleID='$roleID'";
    $result3 = $mysqli->query($query3);
    $row3 = $result3->fetch_assoc();
    $role = $row3['roleName'];

    //output selected user info
    echo '<div class="container"><br><p>用户信息：</p>';
    echo '用户ID：',$row['uid'],'<br>';
    echo '用户名：',$row['username'],'<br>';
    echo '邮箱：',$row['email'],'<br>';
    echo '用户组：',$role,'<br>';
    echo '注册日期：',date( "Y-m-d", $row['regdate'] ),'<br><br>';
    echo '<a href="javascript:history.back(-1);" class="btn btn-default" role="button">返回</a></div>'

?>
