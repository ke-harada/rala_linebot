<?php
// HTTP�w�b�_��ݒ�
$channelToken = '1oYkdWCpl2XRDUmqWPSffbRjr1RaEt6BKpl7jXgI2kMO0sCdFx+PC/8vU4cjGASJa4MVWHOKuYY0mJtC42CO99NqaAuGQtKkSGKwXLcKUD36wTrFcoNNZYVRrJ5/BYXJ5jy6uuuFQIInkBwUlKSM9QdB04t89/1O/w1cDnyilFU=';
$headers = [
    'Authorization: Bearer ' . $channelToken,
    'Content-Type: application/json; charset=utf-8',
];

// POST�f�[�^��ݒ肵��JSON�ɃG���R�[�h
$post = [
    'to' => 'U0117a01eb4d2257cbb9e0b028ac194ae',
    'messages' => [
        [
            'type' => 'text',
            'text' => 'hello world',
        ],
    ],
];
$post = json_encode($post);

// HTTP���N�G�X�g��ݒ�
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

// ���s
$result = curl_exec($ch);

// �G���[�`�F�b�N
$errno = curl_errno($ch);
if ($errno) {
    return;
}

// HTTP�X�e�[�^�X���擾
$info = curl_getinfo($ch);
$httpStatus = $info['http_code'];

$responseHeaderSize = $info['header_size'];
$body = substr($result, $responseHeaderSize);

// 200 �������� OK
echo $httpStatus . ' ' . $body;
