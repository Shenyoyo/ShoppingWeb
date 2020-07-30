@extends('layouts.admin')

@section('title')
{{__('shop.Reply Management')}}
@endsection
@section('styles')
<link rel="stylesheet" href="/css/products.css">
@endsection
@section('content')
@if (session()->has('success_message'))
<div class="alert alert-success">
    {{ session()->get('success_message') }}
</div>
@endif
<h1>{{__('shop.Reply Management')}}</h1>
<div   style="margin-top:20px;">
    <form  style="display: inline-block"  action="{{route('adminContact.search')}}"" method="GET" class="search-form">
        <input type="text" name="query" id="query" value="{{ request()->input('query') }}" class="search-box"
            placeholder="ID"">
        <button type="submit" class="fa fa-search search-icon btn btn-primary btn-sm"></button>
    </form>

    <form class="pull-right" action="{{route('adminContact.orderby')}}" method="GET" class="search-form">
        <select class="form-control" name="oderbyStatus" id="oderbyStatus" onchange="this.form.submit()" >
            <option value="0">{{__('shop.alloffer')}}</option>
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
            <td>{{__('shop.ID')}}</td>
            <td>{{__('shop.Account Name')}}</td>
            <td>{{__('shop.email')}}</td>
            <td>{{__('shop.phone')}}</td>
            <td>{{__('shop.subject')}}</td>
            <td>{{__('shop.status')}}</td>
            <td>{{__('shop.time')}}</td>
            <td>{{__('shop.operate')}}</td>
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
                    <a href="{{route('adminContact.show',['id' => $contact->id ])}}"><button class="btn btn-primary btn-sm">{{__('shop.Detail')}}</button></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
     
</div>
</div>
<div class="text-center">
    @if (isset($oderbyStatus))
    {{ $contacts->appends(['oderbyStatus' => $oderbyStatus ])->links() }}
    @else
    {{ $contacts->links() }}
    @endif
    
</div>

@endsection