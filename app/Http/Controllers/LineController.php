<?php

namespace App\Http\Controllers;

use LINE\LINEBot;
use LINE\LINEBot\Constant\HTTPHeader;
use LINE\LINEBot\SignatureValidator;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

use App\KyotenMast;
use App\ChikenMast;
use App\SoushinYoyaku;
use App\ChikenSanka;

class LineController extends Controller
{
    //============================================
    // webhook
    //============================================
    public function webhook(Request $request) {
        $lineAccessToken = "ed6055150c1d827e041fe16a240f1b62";
        $lineChannelSecret = "1oYkdWCpl2XRDUmqWPSffbRjr1RaEt6BKpl7jXgI2kMO0sCdFx+PC/8vU4cjGASJa4MVWHOKuYY0mJtC42CO99NqaAuGQtKkSGKwXLcKUD36wTrFcoNNZYVRrJ5/BYXJ5jy6uuuFQIInkBwUlKSM9QdB04t89/1O/w1cDnyilFU=";
        
        $signature = $request->headers->get(HTTPHeader::LINE_SIGNATURE);
        if (!SignatureValidator::validateSignature($request->getContent(), $lineChannelSecret, $signature)) {
           
            return;
        }
        
        $httpClient = new CurlHTTPClient ($lineAccessToken);
        $lineBot = new LINEBot($httpClient, ['channelSecret' => $lineChannelSecret]);
        
        try {
            $events = $lineBot->parseEventRequest($request->getContent(), $signature);
            
            foreach ($events as $event) {
                
                $replyToken = $event->getReplyToken();
                $text = $event->getText();
                $lineBot->replyText($replyToken, $text);
                //$textMessage = new TextMessageBuilder("yahoo!");
                //$lineBot->replyMessage($replyToken, $textMessage);
            }
        } catch (Exception $e) {
            return;
        }

        return;
    }
}
