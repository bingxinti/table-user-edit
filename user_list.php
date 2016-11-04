<?php

/*

连接数据库，
列表：查询表数据进行循环展示
删除：接受删除的id 直接执行删除，然后下面继续查询列表展示
修改：接受修改数据的id先进行查询，然后输出到input里面进行编辑提交更改Update
添加：跳转到详情页面，填写数据之后，直接进行insert 插入数据

修改和添加发送完SQL语句之后，要得到受影响的函数来判断是否操作成功

源码联系：508037051@qq.com

*/


// 打印变量  调试
function D() {echo '<pre>'; print_r( func_get_args() ); echo '</pre>'; echo "<hr />"; }

// 连接数据库
$connect = mysqli_connect( 'localhost', 'root', '', 'demo', '3306' );

// 如果点击了删除，就删除整条数据
if(!empty($_GET['delID']))
{
	$delSql = "DELETE FROM `demo`.`user` WHERE `id`='{$_GET['delID']}';";
	$result = mysqli_query($connect, $delSql);
}

// D($connect);

// 默认查询列表
$querySql = 'SELECT * FROM demo.user order by id desc ;';
$result = mysqli_query($connect, $querySql);

$listInfo = array();
while($rows = mysqli_fetch_assoc($result))
{
	$listInfo[] = $rows;
}
// D($listInfo);

?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
		tr,td,th
		{
		    border: 1px solid green;
		    padding: 10px;
		}
	</style>
</head>
<body>
	<table  align="center" >
		<thead>
			<tr>
				<th>ID</th>
				<th>姓名</th>
				<th>年龄</th>
				<th>操作</th>
			</tr>
		</thead>
		<tbody>
			<!-- 列表循环展示 -->
			<?php foreach ($listInfo as $key => $value): ?>
			<tr>
				<td> <?php  echo $value['id'];?> </td>
				<td> <?php  echo $value['name'];?> </td>
				<td> <?php  echo $value['age'];?> </td>
				<td>
					<a href="user_detail.php?id=<?php echo $value['id']; ?>">修改</a>
					<a href="?delID=<?php echo $value['id']; ?>">删除</a>
				</td>
			</tr>
			<?php endforeach ?>
			<tr>
				<td>
					<a href="user_detail.php">添加</a>
				</td>
			</tr>
		</tbody>
	</table>
</body>
</html>