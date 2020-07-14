@extends('layouts.master')

@section('title')
   問題回覆
@endsection

@section('styles')
<link rel="stylesheet" href="/css/messageShow.css">
@endsection
@section('content')
@if (session()->has('success_message'))
  <div class="alert alert-success">
      {{ session()->get('success_message') }}
  </div>
@endif
@if (count($errors) > 0)
    <div class="alert alert-danger">
        @foreach ($errors->all() as $errors)
            <p>{{ $errors }}</p>    
        @endforeach
    </div>
@endif 
<div class="panel panel-default widget">
    <div class="panel-heading">
        <h3 class="panel-title"><span class=" glyphicon glyphicon-comment"></span>
            {{__('shop.subject')}}:{{$contact->subject}}
            <span style="margin-bottom: 10px" class="pull-right">{{ $contact->updated_at->format('Y/m/d H:i:s') }}
            </span>
        </h3>
    </div>
    <div class="col">
        
        <div class="panel-body">
            <div class="col-md-12" >
                <div class=" btn-group pull-right" style="margin-bottom: 10px">
                    <a href="{{route('user.message')}}" class="btn btn-sm btn-default"><i class="fa fa-list"></i> {{__('shop.Back to list')}}</a>
                </div>
            </div>
            @foreach ($contactDetails as $contactDetail)
            <section class="comment-list">
            @if ($contactDetail->role == "1" )
            <article class="row">
                <div class="col-md-2 col-sm-2 hidden-xs">
                    <figure class="thumbnail">
                      <img class="img-responsive" src="https://icons.iconarchive.com/icons/icons8/windows-8/64/Users-Name-icon.png" />
                      <figcaption class="text-center">User</figcaption>
                    </figure>
                  </div>
                <div class="col-md-10 col-sm-10">
                  <div class="panel panel-default arrow left">
                    <div class="panel-body">
                      <header class="text-left">
                        <div class="comment-user"><i class="fa fa-user"></i> {{$contactDetail->name}}</div>
                        <time class="comment-date" ><i class="fa fa-clock-o"></i> {{$contactDetail->created_at}} </time>
                      </header>
                      <div class="comment-post">
                        <p>
                            {{$contactDetail->message}}
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
            </article>   
            @else
            <article class="row">
                <div class="col-md-10 col-sm-10">
                  <div class="panel panel-default arrow right">
                    <div class="panel-body">
                      <header class="text-right">
                        <div class="comment-user"><i class="fa fa-user"></i> {{$contactDetail->name}}</div>
                        <time class="comment-date" ><i class="fa fa-clock-o"></i> {{$contactDetail->created_at}} </time>
                      </header>
                      <div class="comment-post">
                        <p>
                            {{$contactDetail->message}}
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-2 col-sm-2 hidden-xs">
                    <figure class="thumbnail">
                      <img class="img-responsive" src="https://icons.iconarchive.com/icons/icons8/windows-8/64/Users-Administrator-icon.png" />
                      <figcaption class="text-center">Admin</figcaption>
                    </figure>
                  </div>
            </article>        
            @endif
            </section> 
            @endforeach
            <div class="text-center">
                {{ $contactDetails->links() }}
            </div>
        </div>
    </div>
</div>
    @if ($contact->status != '3')
    <form role="form" action="{{route('user.messageReply')}}" method="POST">
        {!! csrf_field() !!}
        <input type="hidden" name="id" value="{{$contact->id}}">
        <fieldset>
            <label  control-label" for="name">{{__('shop.message')}}:</label>
            <div class="form-group">
                <textarea class="form-control" name="message" rows="3" autofocus="" required></textarea>
            </div>
            <button  type="submit" class=" btn btn-success pull-right" >{{__('shop.Reply')}}</button>
        </fieldset>
    </form>
    @endif
</div>
@endsection