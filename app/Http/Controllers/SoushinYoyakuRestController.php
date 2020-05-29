<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

use App\SoushinYoyaku;

class SoushinYoyakuRestController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        \Log::debug('SoushinYoyakuRest store start');
        $yoyaku = SoushinYoyaku::where('id', $request->id)->first();
        $yoyaku->question_url = $request->question_url;
        $yoyaku->question_result_url = $request->question_result_url;
        $yoyaku->save();
        
        \Log::debug('SoushinYoyakuRest store end');
        return response('', 200)->header('Content-Type', 'text/plain');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update($request)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}