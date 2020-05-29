<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

use App\KyotenMast;
use App\ChikenMast;

class ChikenRegisterController extends Controller
{
    public function index() {
        $init_data = [
            'kyotens' => KyotenMast::all(),
            'id' => '',
            'kyoten_id' => '',
            'chiken_name' => '',
            'naiyo' => '',
            'jisshi_dt' => date('Y-m-d')
        ];
        return view('chiken-register', $init_data);
    }
    
    public function edit($encrypt_id) {
        $chiken_id = Crypt::decrypt($encrypt_id);
        
        $chiken = DB::table('chiken_mast')->where([array('chiken_mast.id', '=', $chiken_id)])->first();
        $init_data = [
            'kyotens' => KyotenMast::all(),
            'id' => $chiken->id,
            'kyoten_id' => $chiken->kyoten_id,
            'chiken_name' => $chiken->chiken_name,
            'naiyo' => $chiken->naiyo,
            'jisshi_dt' => $chiken->jisshi_dt
        ];
        return view('chiken-register', $init_data);
    }
    
    public function post(Request $request) {
        if ($request->id == "") {
            $ChikenMast = new ChikenMast;
            $chiken_id = DB::table('chiken_mast')->max('chiken_id');
            $ChikenMast->chiken_id = $chiken_id + 1;
        } else {
            $ChikenMast = ChikenMast::find($request->id);
        }
        $ChikenMast->chiken_name = $request->chiken_name;
        $ChikenMast->kyoten_id = $request->kyoten_id;
        $ChikenMast->naiyo = $request->naiyo;
        $ChikenMast->jisshi_dt = $request->jisshi_dt;
        $ChikenMast->save();
        
        return redirect('/');
    }
}
