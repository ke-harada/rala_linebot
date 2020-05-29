<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

use App\QuetionTemplateMast;

class QuestionTemplateMastRestController extends Controller
{
    public function index()
    {
        $templates = QuetionTemplateMast::all();
        return json_encode($templates, JSON_UNESCAPED_UNICODE);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        \Log::debug('QuetionTemplateMastRest show');
        $template = QuetionTemplateMast::find($id);
        return json_encode($template, JSON_UNESCAPED_UNICODE);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}