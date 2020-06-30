@extends('layouts.admin')
@section('title')
    訂單明細
@endsection
@section('content')
<div class="box box-info">
  <div class="box-header with-border">
    <h1 class="box-title">訂單號碼：{{ $order->id }}</h1>
    <div class="box-tools">
      <div class="btn-group pull-right" style="margin-bottom: 10px">
        <a href="{{route('order.index')}}" class="btn btn-sm btn-default"><i class="fa fa-list"></i> 返回列表</a>
      </div>
    </div>
  </div>
  <br>
  <div class="box-body">
    <table class="table table-bordered ">
      <tbody>
      <tr>
        <td>買家：</td>
        <td>{{ $order->user->name }}({{$user->level->name}})</td>
        <td>購買時間：</td>
        <td>{{ $order->created_at }}</td>
      </tr>
      <tr>
        <td>支付方式：</td>
        <td colspan="3">貨到付款</td>
      </tr>
      <tr>
        <td>收貨地址：</td>
        <td colspan="3">{{ $order->receiver_address }}</td>
      </tr>

      <tr>
        <td rowspan="{{ $order->orderDetail->count() + 1 }}">商品列表：</td>
        <td>商品名稱</td>
        <td>單價</td>
        <td>數量</td>
      </tr>
      @foreach($order->orderDetail as $item)
      <tr>
        <td>
          <div>{{ $item->product->name }}</div>
        </td>
        <td>${{ presentPrice($item->price) }}</td>
        <td>{{ $item->quantity }}</td>
      </tr>
      @endforeach

      <tr>
        <td>訂單金額：</td>
        <td>${{ presentPrice($order->total) }}</td>
        <td>訂單狀態：</td>
        <td>{{  orderStatus($order->status) }}</td>
      </tr>

      <tr>
      @if ($order->status == '1' )
          @if(!empty($user->level->offer->cashback_yn))
              @if ($user->level->offer->cashback_yn == 'Y')
              <td>{{$user->level->name}}滿額{{$user->level->offer->cashback->above}}以上<br>
                虛擬幣回饋{{$user->level->offer->cashback->percent *100}}%
              </td>
                  @if ($order->total > $user->level->offer->cashback->above)
                  <td style="padding-top: 18px;" colspan="3" >${{ presentPrice(round($order->total * $user->level->offer->cashback->percent)) }}</td>   
                  @else
                  <td style="padding-top: 18px;" colspan="3" >${{ $order->total * 0 }}</td>     
                  @endif
              @endif
          @endif
      <tr>
        <td colspan="4">
          <a class="pull-right" href="{{route('order.sand',['id' => $order->id ])}}"><button class="btn btn-success">送貨</button></a> 
        </td>
      </tr>
      @else
          @if ($order->pre_cashback_yn == 'Y')
          <td>{{$order->pre_levelname}}滿額{{$order->pre_above}}以上<br>
            虛擬幣回饋{{$order->pre_percent *100}}%
          </td>
              <td style="padding-top: 18px;" colspan="3" >${{ presentPrice(round($order->pre_dollor)) }}</td>   
          @endif
      @endif  
      </tr>

      {{-- @if($order->refund_status !== \App\Models\Order::REFUND_STATUS_PENDING)
        <tr>
          <td>退款狀態：</td>
          <td colspan="2">{{ __("order.refund.{$order->refund_status}") }}，理由：{{ $order->extra['refund_reason'] }}</td>
          <td>
            @if($order->refund_status === \App\Models\Order::REFUND_STATUS_APPLIED)
            <button class="btn btn-sm btn-success" id="btn-refund-agree">同意</button>
            <button class="btn btn-sm btn-danger" id="btn-refund-disagree">不同意</button>
            @endif
          </td>
        </tr>
      @endif --}}
      </tbody>
    </table>
  </div>
</div>
@endsection


{{-- <script>
$(function() {
  $('#btn-refund-agree').click(function () {
    swal({
      title: '確定要將款項退還給用戶?',
      type: 'warning',
      showCancelButton: true,
      confirmButtonText: '確定',
      cancelButtonText: '取消',
      showLoaderOnConfirm: true,
      preConfirm: function () {
        return $.ajax({
          url: '{{ route('admin.orders.handle_refund', $order) }}',
          type: 'POST',
          data: JSON.stringify({
            agree: true,
            _token: LA.token
          }),
          contentType: 'application/json'
        });
      }
    }).then(function (ret) {
      if (ret.dismiss === 'cancel') {
        return;
      }
      swal({
        title: '操作成功',
        type: 'success'
      }).then(function () {
        location.reload();
      });
    });
  })

  $('#btn-refund-disagree').click(function () {
    swal({
      title: '輸入拒絕退款裡由',
      input: 'text',
      showCancelButton: true,
      confirmButtonText: '確定',
      cancelButtonText: '取消',
      showLoaderOnConfirm: true,
      preConfirm: function (input) {
        if (!input) {
          swal('理由不能為空', '', 'error')
          return false;
        }

        return $.ajax({
          url: '{{ route('admin.orders.handle_refund', $order) }}',
          type: 'POST',
          data: JSON.stringify({
            agree: false,
            reason: inputValue,
            _token: LA.token
          }),
          contentType: 'application/json'
        });
      },
      allowOutsideClick: function () {
        return !swal.isLoading();
      }
    }).then(function (ret) {
      if (ret.dismiss === 'cancel') {
        return;
      }
      swal({
        title: '操作成功',
        type: 'success'
      }).then(function () {
        location.reload();
      });
    });
  })
})
</script> --}}
