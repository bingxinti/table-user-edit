<?php

// 打印变量  调试
function D() {echo '<pre>'; print_r( func_get_args() ); echo '</pre>'; echo "<hr />"; }

// 连接数据库
$connect  = mysqli_connect( 'localhost', 'root', '', 'demo', '3306' );

// 如果是提交表单过来的数据，就进行修改后者添加
if(!empty($_POST))
{
	// 如果ID为空 就执行添加逻辑
	if(empty($_POST['id']))
	{
		$sqlupdate = " INSERT INTO `demo`.`user` (`name`, `age`) VALUES ('{$_POST['name']}', '{$_POST['age']}'); ";
	}
	// 否则ID存在了，就修改这个ID的数据
	else
	{
		$sqlupdate = " UPDATE `demo`.`user` SET `name`='{$_POST['name']}', `age`='{$_POST['age']}' WHERE `id`='{$_POST['id']}'  ";
	}

	// 执行修改或者添加
	$result = mysqli_query($connect, $sqlupdate);
	// 返回受影响的函数
	$rows   = mysqli_affected_rows($connect);

	$info = "受影响行数{$rows}";

	// D("SQL:{$sqlupdate} {$info}");

	// 保证操作成功了，就跳转
	if($rows > 0 )
	{
		$info .= '操作成功';
		echo "<script type='text/javascript'> alert('{$info}');  window.location.href='user_list.php' </script>";
	}
	else
	{
		$info .= ' 操作失败';
		echo "<script type='text/javascript'> alert('{$info}');  window.location.href='user_list.php' </script>";
	}
}
// 如果GET方式（列表页面点击进来的）带过来ID，就查询ID对应的数据，下面进行展示
else  if(!empty($_GET['id']))
{
	$querySql = 'SELECT * FROM demo.user where  id =  '.  $_REQUEST['id'];
	$result   = mysqli_query($connect, $querySql);
	$detail     = mysqli_fetch_assoc($result);
}
?>

<!DOCTYPE html>
<html>
<head> <title></title> </head>
<style type="text/css">
	input
	{
		line-height: 30px;
		margin:10px;
	}
</style>
<body>
	<form  action="<?php echo $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data" method="post">
		<input type="hidden" name="id" value="<?php echo @$detail['id'] ?>">
		<table  align="center" >
			<tr>
				<td>姓名</td>
				<td>
					<input type="text" name="name" value="<?php echo @$detail['name'] ?>" >
				</td>
			</tr>
			<tr>
				<td>年龄</td>
				<td>
					<input type="text" name="age" value="<?php echo @$detail['age'] ?>" >
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<button>提交</button>
					<a href="user_list.php">返回列表</a>
				</td>
			</tr>
		</table>
	</form>
</body>
</html>