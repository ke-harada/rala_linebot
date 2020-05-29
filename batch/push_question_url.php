<?php
syslog(LOG_INFO, 'push_question_url start ========');

$channelToken = '1oYkdWCpl2XRDUmqWPSffbRjr1RaEt6BKpl7jXgI2kMO0sCdFx+PC/8vU4cjGASJa4MVWHOKuYY0mJtC42CO99NqaAuGQtKkSGKwXLcKUD36wTrFcoNNZYVRrJ5/BYXJ5jy6uuuFQIInkBwUlKSM9QdB04t89/1O/w1cDnyilFU=';
$headers = [
    'Authorization: Bearer ' . $channelToken,
    'Content-Type: application/json; charset=utf-8',
];

// DB接続
$link = mysqli_connect('souseitest-mysql.cbunwfchmecl.ap-northeast-1.rds.amazonaws.com', 'admin', 'admin1234', 'test');
if (mysqli_connect_errno()) {
    die("データベースに接続できません:" . mysqli_connect_error() . "\n");
}

$date = date('Y-m-d H:i:s');

$soushin_upd = "UPDATE soushin_yoyaku SET soushin_dtt = CAST('".$date."' AS DATETIME) WHERE soushin_yoyaku_dtt <= CAST('".$date."' AS DATETIME) AND soushin_dtt IS NULL;";
$res = mysqli_query($link, $soushin_upd);

$soushin_sql = "SELECT * FROM soushin_yoyaku WHERE soushin_dtt = CAST('".$date."' AS DATETIME);";
$soushin_rs = mysqli_query($link, $soushin_sql);

foreach ($soushin_rs as $soushin) {
    $hikensha_sql = "SELECT * FROM chiken_sanka
                     LEFT JOIN hikensha_mast ON (hikensha_mast.hikensha_id=chiken_sanka.hikensha_id)
                     WHERE chiken_id=".$soushin['chiken_id'].";";
    $hikensha_rs = mysqli_query($link, $hikensha_sql);

    foreach ($hikensha_rs as $hikensha) {
        $post = [
            'to' => $hikensha['line_id'],
            'messages' => [
                [
                    'type' => 'text',
                    'text' => $soushin['question_url'],
                ],
            ],
        ];
        $post = json_encode($post);

        $ch = curl_init('https://api.line.me/v2/bot/message/push');
        $options = [
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_BINARYTRANSFER => true,
            CURLOPT_HEADER => true,
            CURLOPT_POSTFIELDS => $post,
        ];
        curl_setopt_array($ch, $options);

        $result = curl_exec($ch);
        $errno = curl_errno($ch);
        if ($errno) {
            return;
        }
    }
}

mysqli_close($link);

syslog(LOG_INFO, 'push_question_url end ==========');
