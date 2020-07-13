@extends('layouts.master')
@section('title')
    聯絡我們
@endsection
@section('content')
@if (count($errors) > 0)
<div class="alert alert-danger">
    @foreach ($errors->all() as $errors)
        <p>{{ $errors }}</p>    
    @endforeach
</div>
@endif
@if (session()->has('success_message'))
  <div class="alert alert-success">
      {{ session()->get('success_message') }}
  </div>
@endif
<div class="row">
    <div class="col-md-12">
      <div class="well well-sm">
        <form class="form-horizontal" action="{{route('contact.sendMessage')}}" method="post">
            {{csrf_field()}}
        <fieldset>
          <legend class="text-center">{{__('shop.contact')}}</legend>
  
          <!-- Name input-->
          <div class="form-group">
            <label class="col-md-3 control-label" for="name">{{__('shop.name')}}</label>
            <div class="col-md-7">
              <input id="name" name="name" type="text" placeholder="{{__('shop.howcallyou')}}" class="form-control" value="{{$user->name ?? old('name')}}" required>
            </div>
          </div>
  
          <!-- Email input-->
          <div class="form-group">
            <label class="col-md-3 control-label" for="email">{{__('shop.emailaddress')}}</label>
            <div class="col-md-7">
              <input id="email" name="email" type="text" placeholder="{{__('shop.emailaddress')}}" class="form-control" value="{{$user->email ?? old('email')}}" required>
            </div>
          </div>
          <!-- phone input-->
          <div class="form-group">
            <label class="col-md-3 control-label" for="email">{{__('shop.contactnumber')}}</label>
            <div class="col-md-7">
              <input id="phone" name="phone" type="text" placeholder="{{__('shop.contactnumber')}}" class="form-control" value="{{$user->phone ?? old('phone')}}" required>
            </div>
          </div>

           <!-- Subject input-->
           <div class="form-group">
            <label class="col-md-3 control-label" for="subject">{{__('shop.subject')}}</label>
            <div class="col-md-7">
              <input id="subject" name="subject" type="text" class="form-control" value="{{old('subject')}}" required>
            </div>
          </div>

          <!-- Message body -->
          <div class="form-group">
            <label class="col-md-3 control-label" for="message">{{__('shop.message')}}</label>
            <div class="col-md-7">
              <textarea class="form-control" id="message" name="message" placeholder="{{__('shop.requests')}}" rows="5" required>{{old('message')}}</textarea>
            </div>
          </div>
  
          <!-- Form actions -->
          <div class="form-group">
            <div class="col-md-10 text-right">
              <button type="submit" class="btn btn-primary btn-lg">{{__('shop.submit')}}</button>
            </div>
          </div>
        </fieldset>
        </form>
      </div>
    </div>
  </div>
@endsection