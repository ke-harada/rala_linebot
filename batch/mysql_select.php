<?php
$link = mysqli_connect('souseitest-mysql.cbunwfchmecl.ap-northeast-1.rds.amazonaws.com', 'admin', 'admin1234', 'test');

// 接続状況をチェックします
if (mysqli_connect_errno()) {
    die("データベースに接続できません:" . mysqli_connect_error() . "\n");
}

echo "データベースの接続に成功しました。\n";

// 
$query = "SELECT hikensha_id, line_id FROM hikensha_mast;";
$result = mysqli_query($link, $query);

foreach ($result as $row) {
    echo $row['hikensha_id'];
}

mysqli_close($link);
