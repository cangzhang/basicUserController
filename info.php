<?php
    echo "<head>";
    echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"res/css/bootstrap.css\" />";
    echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"res/css/callout.css\" />";
    echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"res/css/dialog.css\" />";
    echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"res/css/icon.css\" />";
    echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"res/css/easyui.css\" />";
    echo "<script src=\"res/js/bootstrap.js\"></script>";
    echo "<script src=\"res/js/jquery-ui.min.js\"></script>";
    echo "<script src=\"res/js/jquery-2.0.3.min.js\"></script>";
    echo "<script src=\"res/js/jquery.easyui.min.js\"></script>";
    echo "<title>INFO</title>";
    echo "</head>";

    session_start();

	//check if current user has loged in
	if(!isset($_SESSION['userid'])){
		header("Location:login.html");
		exit();
	}

    include('config.php');

    $userid = $_SESSION['userid'];
    $username = $_SESSION['username'];

    //get user ID
    $user_query = "select * from user where uid=$userid limit 1";
    $result = $mysqli->query($user_query);
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

    echo "<body>";
    echo '<div class="container">';
    echo '<div class="bs-callout bs-callout-info" id="callout-helper-context-color-specificity">';
    echo '<p>当前用户ID：',$userid,'<br>';
    echo '用户名：',$username,'<br>';
    echo '邮箱：',$row['email'],'<br>';
    echo '用户组：',$role,'<br>';
    echo '注册日期：',date( "Y-m-d", $row['regdate'] ),'</p>';
    echo '</div>';

    //display all lower privilege users
    $sql = "SELECT user.uid, user.username, user.email, user.regdate FROM user LEFT JOIN userrole ON user.uid=userrole.userID WHERE
userrole.roleID >= '$roleID' ";
    $result = $mysqli->query($sql);

    if ( $result->num_rows > 0 ){
        echo "<div class=\"table-responsive\">";
        echo "<table class=\"table table-hover\" id=\"sort\">";
        echo '<caption>同等级及较低等级用户有：</caption>';
        echo "<thead>";
        echo "<tr><th class=\"index\">ID</th><th>Username</th><th>Email</th><th>Reg Date</th><th>Detail info</th></tr>";
        echo "</thead>";
        echo "<tbody>";

        while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td class=\"index\" style=\"display: table-row;\">".$row['uid']."</td>";
                echo "<td><a href=\"view.php?u=".$row['username']."\">".$row['username']."</a></td>";
                echo "<td>".$row['email']." </td>";
                echo "<td>".date("Y-m-d", $row['regdate'])."</td>";
                //popup dialog for detail
                echo "<td><a href=\"javascript:void(0)\" class=\"btn btn-info\" role=\"button\" onclick=\"$('#dlg".$row['username']."').dialog('open')\"> Detail </a></td>";
                echo "<div id=\"dlg".$row['username']."\" class=\"easyui-dialog\" border=\"false\" closed=\"true\" title=\"INFO\" data-options=\"iconCls:'icon-save'\" style=\"width:350px;height:230px;padding:10px;top:100px; left:200px;\">
                    <iframe frameborder=\"no\" scrolling=\"no\" src=\"view.php?u=".$row['username']."\"></iframe></div>";
                echo "</tr>";
            }
    } else {
        echo "0 results";
    }
    echo "</tbody>";
    echo "</table>";
    echo "</div>";

    echo '<div class="container">';
    echo '<span><a href="logout.php" class="btn btn-warning" role="button">注销</a></span>';
    echo '</div>';
    echo "</body>";

?>