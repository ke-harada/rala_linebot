<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

use App\KyotenMast;
use App\ChikenMast;
use App\SoushinYoyaku;
use App\ChikenSanka;

class ChikenDetailController extends Controller
{
    //============================================
    // index
    //============================================
    public function index($encrypt_id) {
        \Log::debug('ChikenDetailController index');
        $chiken_id = Crypt::decrypt($encrypt_id);
        
        $init_data = [
          'chiken' => ChikenMast::where('chiken_id', $chiken_id)->join('kyoten_mast', 'chiken_mast.kyoten_id', '=', 'kyoten_mast.kyoten_id')->first(),
          'yoyakus' => SoushinYoyaku::where('chiken_id', $chiken_id)->orderBy('id')->get(),
          'sankas' => ChikenSanka::where('chiken_id', $chiken_id)->join('hikensha_mast', 'chiken_sanka.hikensha_id', '=', 'hikensha_mast.hikensha_id')->orderBy('chiken_sanka.id')->get()
        ];
        return view('chiken-detail', $init_data);
    }
    
    //============================================
    // yoyaku_delete
    //============================================
    public function yoyaku_delete(Request $request) {
        $yoyaku = SoushinYoyaku::where('id', $request->soushin_yoyaku_id)->first();
        $yoyaku->delete();
        
        $en_chiken_id = Crypt::encrypt($request->chiken_id);
        
        return redirect('/ChikenDetail/'.$en_chiken_id);
    }
}
