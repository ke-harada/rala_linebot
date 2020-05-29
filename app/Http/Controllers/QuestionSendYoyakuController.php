<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

use App\KyotenMast;
use App\ChikenMast;
use App\QuetionTemplateMast;
use App\SoushinYoyaku;

class QuestionSendYoyakuController extends Controller
{
    public function index($enc_chiken_id) {
        $chiken_id = Crypt::decrypt($enc_chiken_id);
        
        $init_data = [
            'chiken' => ChikenMast::where('chiken_mast.id', $chiken_id)->first(),
            'yoyaku_id' => '',
            'yoyaku_dt' => date('Y-m-d'),
            'yoyaku_time_h' => '',
            'yoyaku_time_m' => '',
            'template_id' => '',
            'templates' => QuetionTemplateMast::all(),
        ];
        return view('question-send-yoyaku', $init_data);
    }

    public function edit($enc_chiken_id, $enc_yoyaku_id) {
        $chiken_id = Crypt::decrypt($enc_chiken_id);
        $yoyaku_id = Crypt::decrypt($enc_yoyaku_id);
        
        $yoyaku = SoushinYoyaku::where('id', $yoyaku_id)->first();
        $template = QuetionTemplateMast::where('id', $yoyaku->question_template_id)->first();

        $init_data = [
            'chiken' => ChikenMast::where('chiken_mast.id', $chiken_id)->first(),
            'yoyaku_id' => $yoyaku->id,
            'yoyaku_dt' => date('Y-m-d', strtotime($yoyaku->soushin_yoyaku_dtt)),
            'yoyaku_time_h' => date('H', strtotime($yoyaku->soushin_yoyaku_dtt)),
            'yoyaku_time_m' => date('i', strtotime($yoyaku->soushin_yoyaku_dtt)),
            'template_id' => $yoyaku->question_template_id,
            'template_name' => $template->koumoku_name,
        ];
        return view('question-send-yoyaku', $init_data);
    }

    public function post(Request $request) {
        \Log::debug('QuesionSendYoyakuController post');
        $soushin_yoyaku_dtt = $request->soushin_yoyaku_dt.' '.$request->soushin_yoyaku_h.':'.$request->soushin_yoyaku_m;
        
        if ($request->template_id == "") {
            // 新規登録
            $SoushinYoyaku = new SoushinYoyaku;
            $SoushinYoyaku->chiken_id = $request->chiken_id;
            $SoushinYoyaku->question_template_id = $request->question_template;
            $SoushinYoyaku->soushin_yoyaku_dtt = $soushin_yoyaku_dtt;
            $SoushinYoyaku->save();
            
            $id = $SoushinYoyaku->id;
            
            //$url = "https://script.google.com/macros/s/AKfycbxmW5PAJZkZEbnkZMYimQkOqrKL-mYe2IUN2fbvWrfhx04AwC7X/exec";
            $url = "https://script.google.com/macros/s/AKfycbxuC-Igtn81nlFA6IEQ4AX8Y5BSlePk-Euqjz9o/exec";
            $url .= "?tempid=".$request->question_template;
            $url .= "&yoyakuid=".$id;
            
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_TIMEOUT, 5);
            
            \Log::debug('curl_exec start');
            $result = curl_exec($curl);
            \Log::debug('curl_exec end');
            
            curl_close($curl);
            \Log::debug('curl_close');
        } else {
            // 更新
            $SoushinYoyaku = SoushinYoyaku::find($request->yoyaku_id);
            $SoushinYoyaku->soushin_yoyaku_dtt = $soushin_yoyaku_dtt;
            $SoushinYoyaku->save();

//\Log::debug('curl start');
//
//$url = "https://qiita.com/api/v2/items";
//
//$ch = curl_init();
//
//curl_setopt($ch, CURLOPT_URL, $url); // 取得するURLを指定
//curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // 実行結果を文字列で返す
//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // サーバー証明書の検証を行わない
//
//$response =  curl_exec($ch);
//
//$result = json_decode($response, true);
//
//curl_close($ch);
//
//\Log::debug('curl end');
//\Log::debug("response:".$response);
        }
        
        $en_chiken_id = Crypt::encrypt($request->chiken_id);
        
        return redirect('/ChikenDetail/'.$en_chiken_id);
    }
}
