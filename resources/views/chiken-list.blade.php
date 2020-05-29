@extends('layouts.base')

@section('title', '治験情報一覧')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/chiken-list.css') }}">
@endsection

@section('content')
    <div class="col-md-12 text-right mb-2">
      <a class="btn btn-danger" href="ChikenRegister" role="button">治験情報登録</a>
    </div>

    @if (Session::has('flash_message'))
    <div class="flash_message1 text-center py-1" style="background-color:lightgoldenrodyellow">
        {{ session('flash_message') }}
    </div>
    @endif
    
    <div class="search">
      <form class="" method="post" action="/">
        {{ csrf_field() }}
      <div class="row mb-2">
        <label class="col-md-1">拠点</label>
        <select class="col-md-3" name="search_kyoten_id">
          <option value=""></option>
        @foreach ($kyotens as $kyoten)
          <option value="{{$kyoten->kyoten_id}}"
          @if ($kyoten->kyoten_id == $search_kyoten_id)
            selected
          @endif
          >{{$kyoten->kyoten_name}}</option>
        @endforeach
        </select>
      </div>
      <div class="row mb-2">
        <label class="col-md-1">名称</label>
        <input class="col-md-5" type="text" name="search_chiken_name" placeholder="サプリメント" value="{{$search_chiken_name}}">
      </div>
      <div class="row mb-2">
        <label class="col-md-1">内容</label>
        <input class="col-md-6" type="text" name="search_naiyo" placeholder="生活習慣乱れがちな" value="{{$search_naiyo}}">
      </div>
      <div class="row mb-2">
        <label class="col-md-1">実施日</label>
        <input class="col-md-3" type="date" name="search_jisshi_start" value="{{$search_jisshi_start}}"></input>
        <span style="margin:5px">～</span>
        <input class="col-md-3" type="date" name="search_jisshi_end" value="{{$search_jisshi_end}}"></input>
        <div class="col text-right">
          <button type="submit" class="btn btn-primary" style="width:100px">検索</button>
        </div>
      </div>
      </form>
    </div>

    <div class="d-flex justify-content-center">
      {{ $chikens->appends(['sort' => 'chiken_mast.id'])->links() }}
    </div>

    <div>
      <table class="table">
        <thead class="thead-light">
          <tr>
            <th scope="col" style="width:150px">実施日</th>
            <th scope="col" style="width:100px">拠点</th>
            <th scope="col" style="width:200px">名称</th>
            <th scope="col">内容</th>
            <th scope="col" style="width:60px">詳細</th>
          </tr>
        </thead>
        <tbody>
        @foreach ($chikens as $chiken)
          <?php $encid = Crypt::encrypt($chiken->chiken_id); ?>
          <tr>
            <td>{{$chiken->jisshi_dt}}</td>
            <td>{{$chiken->kyoten_name}}</td>
            <td>{{$chiken->chiken_name}}</td>
            <td>{{$chiken->naiyo}}</td>
            <td><a href="ChikenDetail/{{$encid}}"><i class="fa fa-file-text-o" aria-hidden="true" style="font-size:130%; color:gray;"></i></a></td>
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>
@endsection
