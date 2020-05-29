<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\KyotenMast;
use App\ChikenMast;

class ChikenListController extends Controller
{
    public function index() {
        $init_data = [
            'search_kyoten_id' => '',
            'search_chiken_name' => '',
            'search_naiyo' => '',
            'search_jisshi_start' => '',
            'search_jisshi_end' => '',
            'kyotens' => KyotenMast::all(),
            'chikens' => $this->getChikenListData('')
        ];
        return view('chiken-list', $init_data);
    }
    
    public function search(Request $request) {
        $where = array();
        
        if ($request->search_kyoten_id != "") $where += array('chiken_mast.kyoten_id', '=', $request->search_kyoten_id);
        if ($request->search_chiken_name != "") $where += array('chiken_mast.chiken_name', 'like', '%'.$request->search_chiken_name.'%');
        if ($request->search_naiyo != "") $where += array('chiken_mast.naiyo', 'like', '%'.$request->search_naiyo.'%');
        if ($request->search_jisshi_start != "") $where += array('chiken_mast.jisshi_dt', '>=', $request->search_jisshi_start);
        if ($request->search_jisshi_end != "") $where += array('chiken_mast.jisshi_dt', '<=', $request->search_jisshi_end);
        
        $init_data = [
            'search_kyoten_id' => $request->search_kyoten_id,
            'search_chiken_name' => $request->search_chiken_name,
            'search_naiyo' => $request->search_naiyo,
            'search_jisshi_start' => $request->search_jisshi_start,
            'search_jisshi_end' => $request->search_jisshi_end,
            'kyotens' => KyotenMast::all(),
            'chikens' => $this->getChikenListData($where)
        ];
        return view('chiken-list', $init_data);
    }
    
    private function getChikenListData($where) {
        if ($where == '' || count($where) == 0) {
          return DB::table('chiken_mast')->leftJoin('kyoten_mast', 'chiken_mast.kyoten_id', '=', 'kyoten_mast.kyoten_id')->orderBy('chiken_mast.id')->paginate(5);
        } else {
          return DB::table('chiken_mast')->where([$where])->leftJoin('kyoten_mast', 'chiken_mast.kyoten_id', '=', 'kyoten_mast.kyoten_id')->orderBy('chiken_mast.id')->paginate(5);
        }
    }
}
