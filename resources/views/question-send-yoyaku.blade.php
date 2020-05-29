@extends('layouts.base')

@section('title', 'アンケート送信予約')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/question-send-yoyaku.css') }}">
@endsection

@section('content')
    <?php $encid = Crypt::encrypt($chiken->chiken_id); ?>

    <div class="col-md-12 text-right">
      <a class="btn btn-outline-primary" href="/ChikenDetail/{{$encid}}" role="button" style="width:100px">戻る</a>
    </div>

    <form class="needs-validation" method="post" action="/QuestionSendYoyaku" novalidate>
      {{ csrf_field() }}
      <input type="hidden" name="chiken_id" value="{{$chiken->chiken_id}}">
      <input type="hidden" name="yoyaku_id" value="{{$yoyaku_id}}">
      <input type="hidden" name="template_id" value="{{$template_id}}">
      <div class="detail">
        <div class="row mb-1">
          <label class="col-md-2">治験情報</label>
          <span>{{$chiken->chiken_name}}</span>
        </div>
        <div class="row mb-1">
          <label class="col-md-2">実施日</label>
          <span>{{$chiken->jisshi_dt}}</span>
        </div>
      </div>

      <div class="col-md-12 text-right">
        <button type="submit" class="btn btn-primary" style="width:100px" id="btn_save">保存</button>
      </div>

      <div class="question-send col-md-10">
        <div class="row">
          <table class="table">
            <thead class="thead-light">
              <tr>
                <th>No</th>
                <th>送信日時</th>
                <th>テンプレート</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>
                  <span>1</span>
                </td>
                <td>
                  <div class="form-inline">
                    <input class="form-control col-md-6" type="date" name="soushin_yoyaku_dt" value="{{$yoyaku_dt}}" required>
                    <select class="form-control col-md-2" name="soushin_yoyaku_h" required>
                      <option value=""></option>
                    @for ($i=0; $i < 24; $i++)
                      <option value="{{str_pad($i, 2, 0 ,STR_PAD_LEFT)}}"
                      @if ($i == $yoyaku_time_h)
                        selected
                      @endif
                      >{{str_pad($i, 2, 0 ,STR_PAD_LEFT)}}</option>
                    @endfor
                    </select>
                    <select class="form-control col-md-2" name="soushin_yoyaku_m" required>
                      <option value=""></option>
                    @for ($i=0; $i < 60; $i++)
                      <option value="{{str_pad($i, 2, 0 ,STR_PAD_LEFT)}}"
                      @if ($i == $yoyaku_time_m)
                        selected
                      @endif
                      >{{str_pad($i, 2, 0 ,STR_PAD_LEFT)}}</option>
                    @endfor
                    </select>
                  </div>
                </td>
                <td class="">
                @if ($template_id == "")
                  <select class="col form-control" name="question_template">
                  @foreach ($templates as $template)
                    <option value="{{$template->id}}">{{$template->koumoku_name}}</option>
                  @endforeach
                  </select>
                @else
                  {{$template_name}}
                @endif
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </form>
@endsection

@section('script')
  <script>
    (function() {
    $('#btn_save').click(function(){
        $(".processing").fadeIn(300);
    }); 
    })();
  </script>
@endsection
