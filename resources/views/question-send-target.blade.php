@extends('layouts.base')

@section('title', 'アンケート送信予約')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/question-send-target.css') }}">
@endsection

@section('content')
    <?php $encid = Crypt::encrypt($chiken->chiken_id); ?>

    <div class="col-md-12 text-right">
      <a class="btn btn-outline-primary" href="/ChikenDetail/{{$encid}}" role="button" style="width:100px">戻る</a>
    </div>
    
    <form class="needs-validation" method="post" action="/QuestionSendTarget" novalidate>
      {{ csrf_field() }}
      <div class="detail">
        <div class="row mb-1">
          <label class="col-md-2">治験情報</label>
          <span>{{$chiken->chiken_name}}</span>
          <input type="hidden" name="chiken_id" value="{{$chiken->chiken_id}}">
        </div>
        <div class="row mb-1">
          <label class="col-md-2">実施日</label>
          <span>{{$chiken->jisshi_dt}}</span>
        </div>
      </div>

      <div class="col-md-12 text-right">
        <button type="submit" class="btn btn-primary" style="width:100px">保存</button>
      </div>

      <div class="question-target col-md-10">
        <div class="row">
          <table class="table">
            <thead class="thead-light">
              <tr>
                <th style="width:80px">対象</th>
                <th style="width:150px">被験者ID</th>
                <th>LINEID</th>
                <th style="width:200px">カルテ番号</th>
              </tr>
            </thead>
            <tbody>
            <?php $idx = 0; ?>
            @foreach ($hikenshas as $hikensha)
              <?php $idx += 1; ?>
              <tr>
                <td>
                  <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" name="tar_id[]" id="checkbox-{{$idx}}" value="{{$hikensha->hikensha_id}}"
                    @if ($hikensha->sanka != "")
                      checked
                    @endif
                    >
                    <label class="custom-control-label" for="checkbox-{{$idx}}">  </label>
                  </div>
                </td>
                <td class="">
                  <span>{{$hikensha->hikensha_id}}</span>
                </td>
                <td class="">
                  <span></span>
                </td>
                <td class="">
                  <span>{{$hikensha->karute_no}}</span>
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </form>
@endsection
