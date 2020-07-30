@extends('layouts.admin')

@section('title')
{{__('shop.Offer Management')}}
@endsection

@section('styles')
<link rel="stylesheet" href="/css/products.css">
@endsection
@section('content')
@if (count($errors) > 0)
    <div class="alert alert-danger">
        @foreach ($errors->all() as $errors)
            <p>{{ $errors }}</p>    
        @endforeach
    </div>
@endif 
<h1>{{__('shop.Offer Management')}}</h1>
<div class="row">
    <div class="col-md-6">
        <a href="{{route('offer.new')}}""><button class=" btn btn-success">{{__('shop.Add Offer')}}</button></a>
    </div>
</div>
<div style="margin-top:10px;">
    <form action="{{route('offer.search')}}" method="GET" class="search-form">
        <input type="text" name="query" id="query" value="{{ request()->input('query') }}" class="search-box"
            placeholder="{{__('shop.ID')}}">
        <button type="submit" class="fa fa-search search-icon btn btn-primary btn-sm"></button>
    </form>
</div>
<div style="margin-top:10px;" class="row">
    <div class="col-md-12 text-center">
        <table class="table table-striped ">
            <thead class="bg-info">
                <td>{{__('shop.ID')}}</td>
                <td>{{__('shop.Beneficiary Member')}}</td>
                <td>{{__('shop.Optimun_yn')}}</td>
                <td>{{__('shop.Discount_yn')}}</td>
                <td>{{__('shop.Cashback_yn')}}</td>
                <td>{{__('shop.Rebate_yn')}}</td>
                <td>{{__('shop.operate')}}</td>
            </thead>
            <tbody>
                @foreach ($offers as $offer)
                <tr>
                    <td>{{$offer->id}}</td>
                    <td>{{$offer->level->name}}</td>
                    <td>{{$offer->optimun_yn}}</td>
                    <td>{{$offer->discount_yn}}</td>
                    <td>{{$offer->cashback_yn}}</td>
                    <td>{{$offer->rebate_yn}}</td>
                    <td>
                        <a href="{{route('offer.edit',['id' => $offer->id ])}}"><button
                                class="btn btn-primary btn-sm">{{__('shop.Edit')}}</button></a>
                        {{-- VIP0優惠只能修改不能刪除 --}}
                        @if ($offer->level->name != 'VIP0')
                        <a href="{{route('offer.destroy',['id' => $offer->id ])}}"
                            onclick="javascript:return del()"><button class="btn btn-danger btn-sm">{{__('shop.Delete')}}</button></a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="text-center">
    {{ $offers->links() }}
</div>
@endsection
@section('scripts')
<script src="{{ asset('js/offer.js') }}"></script>
@endsection