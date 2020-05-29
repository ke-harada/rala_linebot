<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

use App\ChikenMast;
use App\HikenshaMast;
use App\ChikenSanka;

class QuestionSendTargetController extends Controller
{
    public function index($encrypt_id) {
        $chiken_id = Crypt::decrypt($encrypt_id);

        $init_data = [
            'chiken' => ChikenMast::where('chiken_id', $chiken_id)->orderBy('id', 'asc')->first(),
            'hikenshas' => DB::select(DB::raw('SELECT chiken_sanka.hikensha_id as sanka, hikensha_mast.hikensha_id, karute_no FROM hikensha_mast LEFT JOIN (select * from chiken_sanka where chiken_id='.$chiken_id.') chiken_sanka ON (chiken_sanka.hikensha_id=hikensha_mast.hikensha_id)'))
        ];
        return view('question-send-target', $init_data);
    }

    public function post(Request $request) {
        // Šù‘¶ƒf[ƒ^‚Ìíœ
        $sankas = ChikenSanka::where('chiken_id', $request->chiken_id)->get();
        foreach ($sankas as $sanka) {
            $sanka->delete();
        }
        
        // ‘ÎÛÒ‚Ì“o˜^
        if (isset($request->tar_id)) {
          foreach ($request->tar_id as $id) {
              $ChikenSanka = new ChikenSanka;
              $ChikenSanka->hikensha_id = $id;
              $ChikenSanka->chiken_id = $request->chiken_id;
              $ChikenSanka->save();
          }
        }
        
        $encid = Crypt::encrypt($request->chiken_id);
        return redirect('/ChikenDetail/'.$encid);
    }
}
