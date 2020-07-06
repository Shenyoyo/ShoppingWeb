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
          <legend class="text-center">聯絡我們</legend>
  
          <!-- Name input-->
          <div class="form-group">
            <label class="col-md-3 control-label" for="name">姓名</label>
            <div class="col-md-7">
              <input id="name" name="name" type="text" placeholder="怎麼稱呼您?" class="form-control" value="{{$user->name ?? old('name')}}" required>
            </div>
          </div>
  
          <!-- Email input-->
          <div class="form-group">
            <label class="col-md-3 control-label" for="email">電子郵件信箱</label>
            <div class="col-md-7">
              <input id="email" name="email" type="text" placeholder="電子郵件信箱" class="form-control" value="{{$user->email ?? old('email')}}" required>
            </div>
          </div>
          <!-- Email input-->
          <div class="form-group">
            <label class="col-md-3 control-label" for="email">聯絡電話</label>
            <div class="col-md-7">
              <input id="phone" name="phone" type="text" placeholder="聯絡電話" class="form-control" value="{{$user->phone ?? old('phone')}}" required>
            </div>
          </div>

           <!-- Subject input-->
           <div class="form-group">
            <label class="col-md-3 control-label" for="subject">主旨</label>
            <div class="col-md-7">
              <input id="subject" name="subject" type="text" class="form-control" value="{{old('subject')}}" required>
            </div>
          </div>

          <!-- Message body -->
          <div class="form-group">
            <label class="col-md-3 control-label" for="message">訊息</label>
            <div class="col-md-7">
              <textarea class="form-control" id="message" name="message" placeholder="您的意見或疑問..." rows="5" required>{{old('message')}}</textarea>
            </div>
          </div>
  
          <!-- Form actions -->
          <div class="form-group">
            <div class="col-md-10 text-right">
              <button type="submit" class="btn btn-primary btn-lg">送出</button>
            </div>
          </div>
        </fieldset>
        </form>
      </div>
    </div>
  </div>
@endsection