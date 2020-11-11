<?php
$dsn = "mysql:host=localhost;dbname=restaurantdb;charset=utf8";
$user = "restaurantdb_admin";
$password = "admin123";
isset($_GET["area"]) ? $area = $_GET["area"] : $area = ""; 
try {
	$pdo = new PDO($dsn, $user, $password);
	$sql = "select * from restaurants where area = ?";
	$pstmt = $pdo->prepare($sql);
	$pstmt->bindValue(1, $area);
	$pstmt->execute();
	echo "データベースに接続しました。";
	$records = [];
	$records = $pstmt->fetchAll(PDO::FETCH_ASSOC);
	unset($pstmt);
	unset($pdo);
} catch (PAGESException $e) {
	echo $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8" />
	<title>レストランレビュサイト - 小テスト</title>
	<link rel="stylesheet" href="../assets/css/style.css" />
	<link rel="stylesheet" href="../assets/css/list.css" />
</head>
<body id="list">
	<header>
		<h1>レストラン レビュ サイト</h1>
	</header>
	<main>
		<article>
			<div class="clearfix">
			<h2>レストラン一覧</h2>
			<section class="entry">
				<form action="list.php" method="get">
					<select name="area">
						<option value="">-- 地域を選んでください --</option>
						<option value="福岡">福岡</option>
						<option value="神戸">神戸</option>
						<option value="伊豆">伊豆</option>
					</select>
					<input type="submit" value="検索" />
				</form>
				<br>
			    <p> 選択結果 : 
                <?php
	                if (isset($_GET["area"])) {
	                   $_areas = $_GET["area"];
	                   echo $_areas;
	                }
	            ?>
	            </p>
	            <p>データタイプ :
	            <?php
	                $data = $_areas;
	                var_dump($data);
	            ?>
	            </p>
			</section>
			</div>
			<?php if(count($records) >0): ?>
			<section class="result">
				
				<table class="list">
				    <?php foreach ($records as $record): ?>
					<tr>
						<td class="photo"><img name="image" alt="「Wine Bar ENOTECA」の写真" src="../pages/img/<?= $record["image"] ?>"/></td>
						<td class="info">
							<dl>
								<dt name="name"><?= $record["name"] ?></dt>
								<dd name="description"><?= $record["description"] ?></dd>
							</dl>
						</td>
						<td class="link"><a href="detail.php?id=1">詳細</a></td>
					</tr>
					<?php endforeach;?>
			
				</table>
				<?php endif;?>
			</section>
		</article>
	</main>
	<footer>
		<div class="copyright">&copy; 2020 the applied course of web system development</div>
	</footer>
</body>
</html>