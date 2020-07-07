@extends('layouts.admin')

@section('title')
問題回覆管理
@endsection
@section('content')
@if (session()->has('success_message'))
<div class="alert alert-success">
    {{ session()->get('success_message') }}
</div>
@endif
<h1>問題回覆管理</h1>
<div   style="margin-top:20px;">
    <form  style="display: inline-block"  action="{{route('adminContact.search')}}"" method="GET" class="search-form">
        <input type="text" name="query" id="query" value="{{ request()->input('query') }}" class="search-box"
            placeholder="ID"">
        <button type="submit" class="fa fa-search search-icon btn btn-primary btn-sm"></button>
    </form>

    <form class="pull-right" action="{{route('adminContact.orderby')}}" method="POST" class="search-form">
        {!! csrf_field() !!}
        <select class="form-control" name="oderbyStatus" id="oderbyStatus" onchange="this.form.submit()" >
            <option value="0">全部</option>
            @for ($i = 1; $i <= 3 ; $i++)
                <option {{($oderbyStatus ?? '') == $i ? 'selected' : ''}} value="{{$i}}">{{contactStatus($i)}}</option>
            @endfor
        </select>
    </form>
</div>

<div style="margin-top:10px;" class="row"">
    <div class=" col-md-12 text-center">
    <table class="table table-striped ">
        <thead class="bg-info">
            <td>ID</td>
            <td>用戶名</td>
            <td>信箱</td>
            <td>手機</td>
            <td>主旨</td>
            <td>狀態</td>
            <td>日期</td>
            <td>操作</td>
        </thead>
        <tbody>
            @foreach ($contacts as $contact)
            <tr>
                <td>{{$contact->id}}</td>
                <td>{{$contact->name}}</td>
                <td>{{$contact->email}}</td>
                <td>{{$contact->phone}}</td>
                <td>{{$contact->subject}}</td>
                <td>{{ContactStatus($contact->status)}}</td>
                <td>{{ $contact->updated_at->format('Y/m/d H:i:s') }}</td>
                <td>
                    <a href="{{route('adminContact.show',['id' => $contact->id ])}}"><button class="btn btn-primary btn-sm">明細</button></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
     
</div>
</div>
<div class="text-center">
    {{ $contacts->links() }}
</div>

@endsection