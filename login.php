<?php
	session_start();

    echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"res/css/bootstrap.css\" />";
    echo "<script src=\"res/js/bootstrap.js\"></script>";

	//forbid direct visit
	if(!isset($_POST['submit'])){
        echo '<a href="login.html">点击登录</a>';
		exit();
    }
	$username = htmlspecialchars($_POST['username']);
	$password = MD5($_POST['password']);

	include('config.php');

	//query user and password
	$query = "select uid from user where username='$username' and password='$password'";
	$result = $mysqli->query($query);
	$row = $result->fetch_assoc();
	$uid = $row['uid'];

    $query2 = "select roleID from userrole where userID='$uid'";
    $result2 = $mysqli->query($query2);
    $row2 = $result2->fetch_assoc();
    $roleID = $row2['roleID'];

    $query3 = "select roleName from role where roleID='$roleID'";
    $result3 = $mysqli->query($query3);
    $row3 = $result3->fetch_assoc();
    $role = $row3['roleName'];

	//validate login
	if( mysqli_query($mysqli,$query) ) {
		$_SESSION['username'] = $username;
		$_SESSION['userid'] = $uid;

        $url = "info.php";
		echo '<div class="container"><br>用户 ',$username,' 登录成功！ID为: ',$uid,',用户组为：',$role,'<br/>';
		echo '<a href="info.php" class="btn btn-success" role="button">进入用户中心</a>';
		echo "    ";
		echo '<a href="logout.php" class="btn btn-default" role="button">注销登录</a><br/>';
        echo "<script language='javascript' type='text/javascript'>";
        echo "window.location.href='$url'";
        echo "</script>";
        exit;
		} else {
		exit('登录失败！ <a href="javascript:history.back(-1);" class="btn btn-danger" role="button">返回重试</a></div>');
	}

?>