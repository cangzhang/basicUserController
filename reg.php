<?php
	echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"res/css/bootstrap.css\" />";
	echo "<script src=\"res/js/bootstrap.js\"></script>";

    //forbid direct visit
	if( !isset($_POST['submit']) ) {
		echo '<a href="reg.html">点击注册</a>';
		exit();
	}

	$username = $_POST['username'];
	$password = $_POST['password'];
	$email = $_POST['email'];
	$role = $_POST['role'];

	//check if reg items are legal
	if(!preg_match('/^[\w\x80-\xff]{3,15}$/', $username)) {
		exit('错误：用户名不符合规定。<a href="javascript:history.back(-1);">返回</a>');
		}
	if(strlen($password) < 6) {
		exit('错误：密码长度不符合规定。<a href="javascript:history.back(-1);">返回</a>');
		}
	if(!preg_match('/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/', $email)) {
		exit('错误：电子邮箱格式错误。<a href="javascript:history.back(-1);">返回</a>');
		}

	include('config.php');

	//check if username or email is used
	$check_username = mysqli_query($mysqli,"select uid from user where username='$username' limit 1");
	$check_email = mysqli_query($mysqli,"select uid from user where email='$email' limit 1");
	if($check_username->num_rows ) {
		echo '错误：用户名 ',$username,' 已被注册。<a href="javascript:history.back(-1);">返回</a>';
        $url = "reg.html";
        echo "<script language='javascript' type='text/javascript'>";
        echo "window.location.href='$url'";
        echo "</script>";
		exit;
	}
	if($check_email->num_rows){
		echo '错误：',$email,'已被注册。<a href="javascript:history.back(-1);">返回</a>';
        $url = "reg.html";
        echo "<script language='javascript' type='text/javascript'>";
        echo "window.location.href='$url'";
        echo "</script>";
        exit;
	}

	//reg process
	$password = MD5($password);
	$regdate = time();

	$sql = "INSERT INTO user(username,password,email,regdate) VALUES('$username','$password','$email',$regdate)";

	if( mysqli_query($mysqli,$sql) ) {
		$query = "select uid from user where username='$username' and password='$password' limit 1";
		$result = $mysqli->query($query);
		$row = $result->fetch_assoc();
		$uid = $row['uid'];

		$sql2 = "INSERT INTO userrole(userID,roleID) VALUES('$uid','$role')";
		$result2 = mysqli_query($mysqli,$sql2);

        $url = "login.html";
        echo "<script language='javascript' type='text/javascript'>";
        echo "window.location.href='$url'";
        echo "</script>";
		echo '用户注册成功！点击此处 <a href="login.html">登录</a>';
		exit();

		} else {
			echo '抱歉！添加数据失败：', $mysqli->error,'<br />';
			echo '<a href="javascript:history.back(-1);">返回</a> 重试';
		}
?>
