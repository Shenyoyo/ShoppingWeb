@extends('layouts.admin')

@section('title')
{{__('shop.Reply Management')}}

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
            {{__('shop.Reply Status')}} ：{{ContactStatus($contact->status)}}
          
            <span style="margin-bottom: 10px" class="pull-right">
              
              {{ $contact->updated_at->format('Y/m/d H:i:s') }}
                @if ($contact->status != '3')
                <a  href="{{route('adminContact.lock',['id' => $contact->id ])}}" class="btn btn-sm btn-danger">
                <i class="fa fa-lock" aria-hidden="true"></i> {{__('shop.Lock')}}</a>
                @else
                <a href="{{route('adminContact.unlock',['id' => $contact->id ])}}" class="btn btn-sm btn-success">
                <i class="fa fa-unlock" aria-hidden="true"></i> {{__('shop.Unlock')}}</a>    
                @endif
                
            </span>
        </h3>
    </div>
    <div class="panel-body">
        <ul class="list-group">
            <li class="list-group-item">
                <div class="row">
                    <div class="col-xs-12">
                        <div>
                            <div>{{__('shop.name')}}：{{$contact->name}}</div> 
                            <div>{{__('shop.email')}}：{{$contact->email}}</div> 
                            <div>{{__('shop.phone')}}：{{$contact->phone}}</div> 
                            <div>{{__('shop.subject')}}：{{$contact->subject}}</div> 
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
    <div class="col">
        <div class="panel-body">
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
    <form role="form" action="{{route('adminContact.reply')}}" method="POST">
        {!! csrf_field() !!}
        <input type="hidden" name="id" value="{{$contact->id}}">
        <div  class="form-group">
            <label  control-label" for="name">{{__('shop.Replyer')}}:</label>
            <input style="width: 10%" id="name" name="name" type="text"  class="form-control" value="{{old('name') ?? Auth::user()->name  }}" required>
        </div>
        <fieldset>
            <div class="form-group">
                <textarea class="form-control" name="message" rows="3" autofocus="" required></textarea>
            </div>
            <button  type="submit" class=" btn btn-success pull-right" >{{__('shop.Reply')}}</button>
        </fieldset>
    </form>
    @endif
</div>
@endsection