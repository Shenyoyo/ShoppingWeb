@extends('layouts.master')

@section('title')
   問題回覆
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
<h1>{{__('shop.Question Reply')}}</h1>
<div style="margin-top:10px;">
    
    <form action="#" method="GET" class="search-form">
        <input type="text" name="query" id="query" value="{{ request()->input('query') }}" class="search-box" placeholder="{{__('shop.subject')}}">
        <button type="submit" class="fa fa-search search-icon btn btn-primary btn-sm"></button>
    </form>
</div>
<div style="margin-top:10px;" class="row"">
    <div class="col-md-12 text-center" >
        <table class="table table-striped ">
            <thead style="background: #e9e9e9 ;" class="text-light">
                <td>{{__('shop.subject')}}</td>
                <td>{{__('shop.time')}}</td>
                <td>{{__('shop.status')}}</td>
                <td>{{__('shop.operate')}}</td>
            </thead>
            <tbody>
                @if(count($contacts) != 0)
                    @foreach ($contacts as $contact)
                    <tr>
                        <td>{{$contact->subject}}</td>
                        <td>{{$contact->created_at}}</td>
                        <td>{{ContactStatus($contact->status)}}</td>
                        <td>
                            <a href="{{route('user.messageShow',['id' => $contact->id ])}}"><button class="btn btn-primary btn-sm">{{__('shop.Detail')}}</button></a>
                        </td>
                    </tr>
                    @endforeach 
                @else
                    <tr>
                        <td  colspan="8">{{__('shop.data not found')}}</td>
                    </tr>
                @endif       
                </tbody>
            </table>
    </div>
</div>
<div class="text-center">
    {{ $contacts->links()  }}
</div>

@endsection