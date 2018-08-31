<?php
//データベースへの接続 3-1
$dsn = 'データベース名';
$user = 'ユーザー名';
$password = 'パスワード';
$pdo = new PDO($dsn,$user,$password);

//一度成功したらここからここまではコメントアウトする

/*
//テーブルの削除
$sql="DROP TABLE board";
$stmt = $pdo->query($sql);
*/

//テーブルの作成3-2
$sql="CREATE TABLE keijiban(id int primary key auto_increment, name text,comment text, pass text)";
$stmt = $pdo->query($sql);


	$name=$_POST['name'];
	$comment=$_POST['comment'];
	$pass = $_POST['pass'];
	$target_number=$_POST['target_number'];

//新規投稿の処理
if(isset($_POST['new']) && ($pass!="")){
	echo "送信ボタンが押されました";

		//編集による書き換えの処理
				if($target_number!=""){
				echo "flag1";
			    $sql = "update keijiban set name = '$name',comment = '$comment' where id = $target_number";
			    }else{
			
			echo "flag2";
			//新規書き込みの処理
			 $sql = "INSERT INTO keijiban (name, comment) VALUES (:name, :comment)";
		}
			//insertを行ってデータを入力する3-5
			$stmt = $pdo -> prepare($sql);
			$stmt->bindParam(':name', $name, PDO::PARAM_STR);
			$stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
			$stmt->execute();
	}


//編集ボタンを押した時の処理　
$edit_id = $_POST['edit_id'];
$edit_pass = $_POST['edit_pass'];
	if(isset($_POST['edit'])){
		echo "編集ボタンが押されました".$edit_id;
		if($pass = $edit_pass){
		
			//編集ボタンを押した時にフォームに内容を入力させる処理
			if(isset($_POST['edit_id'])){
			//入力したデータをselectによって表示する3-6
				$sql="SELECT * FROM keijiban where id = $edit_id";
				$results = $pdo -> query($sql);
				foreach ($results as $row){
				$edit_name = $row['name'];
				$edit_comment = $row['comment'];
				$edit_pass = $row['pass'];
					echo $edit_name;
					echo $edit_comment;
			}
		}
	}else{
			echo "パスワードが一致しませんでした";
	}
}



//削除ボタンを押した時の処理
$delete_id = $_POST['delete_id'];
$delete_pass = $_POST['delete_pass'];
	if(isset($_POST['delete'])){
		echo "削除ボタンが押されました".$delete_id;
		
			if($pass = $delete_pass){
			$sql = "delete from keijiban  where id = $delete_id";
			$result = $pdo->query($sql);
	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<!-- CSS -->
	<style type="text/css">
		#board_title{text-align: center;}
	</style>
</head>
<script>
</script>
<body>
	<div id = "board_title">掲示板</div>
	<form action = "http://tt-179.99sv-coco.com/mission_4.php" method = "post">
		<!-- 新規投稿 -->
		<input type = "text" name = "name" placeholder = "名前"  value="<?php print ($edit_name) ?>" /><br>
		<input type = "text" name = "comment" placeholder = "コメント"  value="<?php print ($edit_comment) ?>" /><br>
		<input type = "text" name = "pass" placeholder = "パスワード" />
		<input type = "hidden" name = "target_number"  value="<?php print ($edit_id) ?>" />
		<input type = "submit" name = "new" value = "送信" /><br><br>
	</form>
	<form action = "http://tt-179.99sv-coco.com/mission_4.php" method = "post">
		<!- 削除 -->
		<input type = "text" name = "delete_id" placeholder = "削除対象番号" /><br>
		<input type = "text" name = "delete_pass" placeholder = "パスワード" />
	　<input type = "submit" name = "delete" value = "削除" /><br><br>
	</form>
	<form action = "http://tt-179.99sv-coco.com/mission_4.php" method = "post">
		<!- 編集 -->
		<input type = "text" name = "edit_id" placeholder = "編集対象番号" /><br>
		<input type = "text" name = "edit_pass" placeholder = "パスワード" />
	　<input type = "submit" name = "edit" value = "編集" /><br>
	</form>
</body>
</html>

<?php
//入力したデータをselectによって表示する3-6
	$sql='SELECT * FROM keijiban ORDER BY id ASC';
	$results = $pdo -> query($sql);
	foreach ($results as $row){
	echo $row['id'].',';
	echo $row['name'].',';
	echo $row['comment'].',';
	echo $row['pass'].'<br>';
	}
?>
