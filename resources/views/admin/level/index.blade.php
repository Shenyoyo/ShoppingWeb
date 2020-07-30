@extends('layouts.admin')

@section('title')
{{__('shop.Level Management')}}
@endsection

@section('styles')
<link rel="stylesheet" href="/css/level.css">
@endsection
@section('content')
<h1>{{__('shop.Level Management')}}</h1>
<div class="row">
    <div class="col-md-6">
        <a href="{{route('level.new')}}"><button class="btn btn-success">{{__('shop.Add Level')}}</button></a>
    </div>
</div>
<div style="margin-top:10px;">
    <form action="{{route('level.search')}}" method="GET" class="search-form">
        <input type="text" name="query" id="query" value="{{ request()->input('query') }}" class="search-box"
            placeholder="{{__('shop.Level Name')}}">
        <button type="submit" class="fa fa-search search-icon btn btn-primary btn-sm"></button>
    </form>
</div>
<div class="row" style="margin-top:10px;">
    <div class="col-md-12 text-center">
        <table class="table table-striped ">
            <thead class="bg-info ">
                <tr class="">
                    <th colspan="1" rowspan="2">
                        <div class="text-center cell">{{__('shop.ID')}}<div>
                    </th>
                    <th colspan="1" rowspan="2">
                        <div class="text-center cell">{{__('shop.Level Name')}}<div>
                    </th>
                    <th colspan="1" rowspan="2">
                        <div class="text-center cell">{{__('shop.Level Description')}}<div>
                    </th>
                    <th colspan="1" rowspan="1" style="border-bottom-width: 0px;">
                        <div class="text-center ">{{__('shop.Upgrate Condition')}}<div>
                    </th>
                    <th colspan="1" rowspan="2">
                        <div class="text-center cell">{{__('shop.Membership')}}<div>
                    </th>
                    <th colspan="1" rowspan="2">
                        <div class="text-center cell">{{__('shop.operate')}}<div>
                    </th>
                </tr>
                <th colspan="1" rowspan="1" style="border-top-width: 0px;">
                    <div class="text-center ">{{__('shop.totalcost')}}<div>
                </th>
                <tr>
                </tr>
            </thead>
            <tbody>
                @foreach ($levels as $level )
                <tr>
                    <td>{{$level->id}}</td>
                    <td>{{$level->name}}</td>
                    <td>{{$level->description}}</td>
                    <td>{{presentPrice($level->upgrade)}}</td>
                    <td>{{count($level->user)}}</td>
                    <td>
                        {{-- 預設0級不能修改 --}}
                        @if ($level->level != 0)
                        <a href="{{route('level.edit',['id' => $level->level ])}}"><button
                                class="btn btn-primary btn-sm">{{__('shop.Edit')}}</button></a>
                        @endif
                        {{-- 只能從最高等級開始刪，預設0級不能刪 --}}
                        @if ($highestLevel->level == $level->level && $highestLevel->level != 0 && count($level->user) < 1 )
                        <a href="{{route('level.destroy',['id' => $level->level ])}}"
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
    {{ $levels->links() }}
</div>
@endsection
@section('scripts')
<script src="{{ asset('js/level.js') }}"></script>
@endsection