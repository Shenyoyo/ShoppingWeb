@extends('layouts.admin')

@section('title')
問題回覆管理
@endsection
@section('content')
@section('content')
@if (session()->has('success_message'))
<div class="alert alert-success">
    {{ session()->get('success_message') }}
</div>
@endif
<div class="panel panel-default widget">
    <div class="panel-heading">
        
        <h3 class="panel-title"><span class=" glyphicon glyphicon-comment"></span>
            問題回復 ：{{ContactStatus($contact->status)}}
            <span class="pull-right">{{ $contact->updated_at->format('Y/m/d H:i:s') }}</span>
        </h3>
    </div>
    <div class="panel-body">
        <ul class="list-group">
            <li class="list-group-item">
                <div class="row">
                    <div class="col-xs-12">
                        <div>
                            <div>姓名：{{$contact->name}}</div> 
                            <div>電子郵件信箱：{{$contact->email}}</div> 
                            <div>聯絡電話：{{$contact->phone}}</div> 
                            <div>主旨：{{$contact->subject}}</div> 
                            <hr>
                            <div>{{$contact->message}}</div> 
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
    <div class="col">
        <div class="panel-body">
            <h4>處理方式：</h4>
            @if ($contact->status != '3')
            <form role="form" action="{{route('adminContact.reply')}}" method="POST">
                {!! csrf_field() !!}
                <input type="hidden" name="id" value="{{$contact->id}}">
                <fieldset>
                    <div class="form-group">
                        <textarea class="form-control" name="response" rows="3" autofocus=""></textarea>
                    </div>
                    <button  type="submit" class="[ btn btn-success ] pull-right" data-loading-text="Loading...">送出</button>
                </fieldset>
            </form>
            @else
            <ul class="list-group">
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-xs-12">
                            <div>
                                <div>{{$contact->response}}</div> 
                            </div>
                        </div>
                    </div>
                </li>
            </ul>    
            @endif
            
        </div>
    </div>
</div>
</div>
@endsection