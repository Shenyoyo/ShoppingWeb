@extends('layouts.admin')

@section('title')
{{__('shop.Account Management')}}
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
<h1>{{__('shop.Account Management')}}</h1>
<div style="margin-top:10px;">
    <form action="{{route('adminUser.search')}}" method="GET" class="search-form">
        <input type="text" name="query" id="query" value="{{ request()->input('query') }}" class="search-box"
            placeholder="{{__('shop.Account Name')}}">
        <button type="submit" class="fa fa-search search-icon btn btn-primary btn-sm"></button>
    </form>
</div>
<div style="margin-top:10px;" class="row"">
    <div class="col-md-12 text-center" >
        <table class="table table-striped ">
            <thead class="bg-info">
                <td>{{__('shop.ID')}}</td>
                <td>{{__('shop.Account Name')}}</td>
                <td>{{__('shop.email')}}</td>
                <td>{{__('shop.phone')}}</td>
                <td>{{__('shop.address')}}</td>
                <td>{{__('shop.VirtualDollor')}}</td>
                <td>{{__('shop.totalcost')}}</td>
                <td>{{__('shop.level')}}</td>
                <td>{{__('shop.Suspension')}}</td>
                <td>{{__('shop.operate')}}</td>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{$user->id}}</td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->phone}}</td>
                    <td>{{$user->address}}</td>
                    <td>{{presentPrice($user->dollor->dollor ?? 0)}}</td>
                    <td>{{presentPrice($user->total_cost)}}</td>
                    <td>{{$user->level->name}}</td>
                    <td>{{userActive($user->active)}}</td>
                    <td>
                       <a href="{{route('adminUser.edit',['id' => $user->id ])}}"><button class="btn btn-primary btn-sm">{{__('shop.Edit')}}</button></a>
                       <a href="{{route('adminUser.resetPassword',['id' => $user->id ])}}"><button class="btn btn-success btn-sm">{{__('shop.ResetPassword')}}</button></a>
                    </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
    </div>
</div>
<div class="text-center">
    {{ $users->links() }}
</div>

@endsection