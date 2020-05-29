@extends('layouts.base')

@section('title', '治験情報登録')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/chiken-register.css') }}">
@endsection

@section('content')
    <div class="col-md-10 text-right">
      <a class="btn btn-outline-primary" href="/" role="button" style="width:100px">戻る</a>
    </div>

    <div class="main" >
      <form class="needs-validation" method="post" action="/ChikenRegister" novalidate>
        {{ csrf_field() }}
      @if ($id != "")
        <div class="row mb-2">
          <label class="col-md-2">治験管理番号</label>
          <span>{{$id}}</span>
          <input type="hidden" name="id" value="{{$id}}">
        </div>
      @endif
        <div class="row mb-2">
          <label class="col-md-2">拠点</label>
          <select class="col-md-3" name="kyoten_id">
          @foreach ($kyotens as $kyoten)
            <option value="{{$kyoten->kyoten_id}}"
            @if ($kyoten->kyoten_id == $kyoten_id)
            selected
            @endif
            >{{$kyoten->kyoten_name}}</option>
          @endforeach
          </select>
        </div>
        <div class="row mb-2">
          <label class="col-md-2 control-label">名称</label>
          <div class="col-md-6" style="padding-left:0px">
            <input class="form-control" type="text" name="chiken_name" value="{{$chiken_name}}" placeholder="サプリメントモニター" required>
            <div class="invalid-feedback">入力してください</div>
          </div>
        </div>
        <div class="row mb-2">
          <label class="col-md-2">内容</label>
          <textarea class="col-md-6 form-control" rows="5" name="naiyo" placeholder="内容を入力してください">{{$naiyo}}</textarea>
        </div>
        <div class="row mb-2">
          <label class="col-md-2">実施日</label>
          <input class="col-md-2" type="date" name="jisshi_dt" value="{{$jisshi_dt}}"></input>
        </div>
        <div class="row">
          <div class="col-md-7"></div>
          <div class="col-md-1">
            <button type="submit" class="btn btn-primary" style="width:100px">
            @if ($id == "")
            登録
            @else
            更新
            @endif
            </button>
          </div>
        </div>
      </form>
    </div>
@endsection
