@extends('layouts.base')

@section('title', '治験情報詳細')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/chiken-detail.css') }}">
@endsection

@section('content')
    <?php $encid = Crypt::encrypt($chiken->chiken_id); ?>

    <div class="col-md-12 text-right">
      <a class="btn btn-outline-primary" href="/" role="button" style="width:100px">戻る</a>
    </div>

    <div class="detail col-md-10">
      <div class="row mb-1">
        <label class="col-md-2">治験管理番号</label>
        <span class="col-md-3 text-left">{{$chiken->chiken_id}}</span>
        <div class="col text-right">
          <a class="btn btn-Success" href="../ChikenRegister/{{$encid}}" role="button" style="width:80px">編集</a>
        </div>
      </div>
      <div class="row mb-1">
        <label class="col-md-2">実施日</label>
        <span>{{$chiken->jisshi_dt}}</span>
      </div>
      <div class="row mb-1">
        <label class="col-md-2">拠点</label>
        <span>{{$chiken->kyoten_name}}</spanp>
      </div>
      <div class="row mb-1">
        <label class="col-md-2">名称</label>
        <span>{{$chiken->chiken_name}}</span>
      </div>
      <div class="row mb-1">
        <label class="col-md-2">内容</label>
        <span>{{$chiken->naiyo}}</span>
      </div>
    </div>

    <div class="question-send col-md-12">
      <div class="row mb-1">
        <label class="col-md-4">アンケート送信スケジュール</label>
        <div class="col text-right">
          <a class="btn btn-primary" href="../QuestionSendYoyaku/{{$encid}}" role="button" style="width:80px">追加</a>
        </div>
      </div>

      <div class="row">
        <table class="table">
          <thead class="thead-light">
            <tr>
              <th style="width:200px">送信日時</th>
              <th style="width:300px">アンケートURL</th>
              <th style="width:300px">回答結果URL</th>
              <th style="width:60px">修正</th>
              <th style="width:60px">削除</th>
            </tr>
          </thead>
          <tbody>
          @foreach ($yoyakus as $yoyaku)
            <?php $enc_yoyaku_id = Crypt::encrypt($yoyaku->id); ?>
            <tr>
              <td>{{date('Y-m-d H:i', strtotime($yoyaku->soushin_yoyaku_dtt))}}</td>
              <td style="word-break:break-all;">{{$yoyaku->question_url}}</td>
              <td style="word-break:break-all;">{{$yoyaku->question_result_url}}</td>
              <td style="text-align:center">
              @if ($yoyaku->soushin_dtt === NULL)
                <a href="../QuestionSendYoyaku/{{$encid}}/{{$enc_yoyaku_id}}"><i class="fa fa-pencil-square-o" aria-hidden="true" style="font-size:130%; color:gray;"></i></a>
              @endif
              </td>
              <td style="text-align:center">
              @if ($yoyaku->soushin_dtt === NULL)
                <a href="#" data-soushin_dt="{{date('Y-m-d H:i', strtotime($yoyaku->soushin_yoyaku_dtt))}}" data-yoyaku_id="{{$yoyaku->id}}" data-toggle="modal" data-target="#deleteDialogModal"><i class="fa fa-trash-o fa-lg" aria-hidden="true" style="font-size:130%; color:gray;"></i></a>
              @endif
              </td>
            </tr>
          @endforeach
          </tbody>
        </table>
      </div>
    </div>

    <div class="question-send-target col-md-12">
      <div class="row mb-1">
        <label class="col-md-2">送信対象者</label>
        <div class="col text-right">
          <a class="btn btn-primary" href="../QuestionSendTarget/{{$encid}}" role="button">対象者選択</a>
        </div>
      </div>

      <div class="row">
        <table class="table">
          <thead class="thead-light">
            <tr>
              <th>被験者ID</th>
              <th>LINEID</th>
              <th>カルテ番号</th>
            </tr>
          </thead>
          <tbody>
          @foreach ($sankas as $sanka)
            <tr>
              <td>{{$sanka->hikensha_id}}</td>
              <td>{{$sanka->line_id}}</td>
              <td>{{$sanka->karute_no}}</td>
            </tr>
          @endforeach
          </tbody>
        </table>
      </div>
    </div>

<div class="modal fade" id="deleteDialogModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <form method="post" action="/ChikenDetail/yoyaku/">
        {{ csrf_field() }}
        <input type="hidden" name="_method" value="delete">
        <input type="hidden" name="chiken_id" value="{{$chiken->chiken_id}}">
        <input type="hidden" name="soushin_yoyaku_id" id="soushin_yoyaku_id" value="">
        <div class="modal-header">
          <h5 class="modal-title" id="myModalLabel">確認</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="閉じる"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <span class="dialog-message"></span>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
          <button type="submit" class="btn btn-danger">削除する</button>
        </div>
      </form>
    </div>
  </div>
</div>

@section('script')
<script>
$('#deleteDialogModal').on('show.bs.modal', function (event) {
    var target = $(event.relatedTarget);
    var yoyaku_id = target.data('yoyaku_id');
    var soushin_dt = target.data('soushin_dt');
    
    var modal = $(this);
    modal.find('.modal-content #soushin_yoyaku_id').val(yoyaku_id);
    modal.find('.dialog-message').text(soushin_dt+'のデータを削除しますがよろしいですか？');
})
</script>
@endsection

@endsection
