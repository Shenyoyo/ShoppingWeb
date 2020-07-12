@extends('layouts.master')

@section('title')
    購物車
@endsection


@section('content')
    <p><a href="{{ url('shop') }}">{{__('shop.home')}}</a> / {{__('shop.ShoppingCart')}}</p>
    <h1>{{__('shop.ShoppingCart')}}</h1>
    
    <hr>
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
    @if (sizeof(Cart::content()) > 0)

            <table class="table">
                <thead>
                    <tr>
                        <th class="table-image"></th>
                        <th>{{__('shop.product')}}</th>
                        <th>{{__('shop.quantity')}}</th>
                        <th>{{__('shop.price')}}</th>
                        <th class="column-spacer"></th>
                        <th>{{__('shop.operate')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (Cart::content() as $item)
                    <tr>
                        <td class="table-image"><a href="{{ url('shop', [$item->model->id]) }}"><img src="{{asset(getImageInCart($item->model->file_id))}}" alt="product" class="img-responsive cart-image"></a></td>
                        <td><a href="{{ url('shop', [$item->model->id]) }}">{{ $item->name }}</a></td>
                        <td>
                            <select class="quantity" onfocus="selectFocus(this)" data-id="{{ $item->rowId }}" >
                                @for ($i = 1; $i <= $item->model->amount ; $i++)
                                <option onclick="selectClick(this)" {{ $item->qty == $i ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                        </td>
                        <td>${{ presentPrice($item->subtotal) }}</td>
                        <td class=""></td>
                        <td>
                            <form action="{{ url('cart', [$item->rowId]) }}" method="POST" class="side-by-side">
                                {!! csrf_field() !!}
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="submit" class="btn btn-danger btn-sm" value="{{__('shop.remove')}}"">
                            </form>
                        </td>
                    </tr>

                    @endforeach
                    <tr>
                        <td class="table-image"></td>
                        <td></td>
                        <td class="small-caps table-bg" style="text-align: right">{{__('shop.subtotal')}}</td>
                        <td>${{ presentPrice($newSubtotal) }}</td>
                        <td></td>
                        <td></td>
                    </tr>
                    @if (!empty(Auth::user()->level->offer->discount_yn))
                        @if (Auth::user()->level->offer->discount_yn == 'Y')
                        <tr>
                            <td class="table-image"></td>
                            <td></td>
                            <td class="small-caps table-bg" style="text-align: right">
                                {{Auth::user()->level->name}}消費滿{{$above}}以上享{{showDiscount($percent*100) }}折
                            </td>
                            <td>-${{ presentPrice($discountMoney) }}</td>
                            <td></td>
                            <td></td>
                        </tr>
                        @endif
                    @endif
                   
                    @if ($dollor->dollor != 0)
                    <tr>
                        <td class="table-image"></td>
                        <td></td>
                        <td class="small-caps table-bg" style="text-align: right">
                            <form action="{{ route('cart.dollor') }}" method="POST" class="side-by-side">
                                {!! csrf_field() !!}
                                @if ($dollor_yn == 'Y')
                                <p><input type="checkbox" name="dollor_yn" value="Y" onchange="this.form.submit()" checked>{{__('shop.doyouuse')}}<p>    
                                @else
                                <p><input type="checkbox" name="dollor_yn" value="Y" onchange="this.form.submit()">{{__('shop.doyouuse')}}<p>
                                @endif
                                
                            </form>
                        </td>
                        <td>${{ presentPrice($dollor->dollor) }}</td>
                        <td></td>
                        <td></td>
                    </tr>
                    @endif
                    
                    <tr class="border-bottom">
                        <td class="table-image"></td>
                        <td style="padding: 40px;"></td>
                        <td class="small-caps table-bg" style="text-align: right">{{__('shop.total')}}</td>
                        <td class="table-bg">${{ presentPrice($newTotal) }}</td>
                        <td class="column-spacer"></td>
                        <td></td>
                    </tr>

                </tbody>
            </table>
            <div style="float:left">
            <a href="{{ url('/shop') }}" class="btn btn-primary btn-lg">{{__('shop.continue')}}</a> &nbsp;
            </div>
            <div style="float:left">
            <form action="{{route('cart.checkout')}}" method="POST">
                {!! csrf_field() !!}
                <input type="hidden" name="dollor_yn" value="{{ $dollor_yn}}">
                <input type="hidden" name="dollor" value="{{ $dollor->dollor }}">
                <input type="hidden" name="recordReturnTotal" value="{{ $recordReturnTotal }}">
                <input type="hidden" name="newTotal" value="{{ $newTotal }}">
                <input type="submit" class="btn btn-success btn-lg" value="{{__('shop.checkout')}}">
            </form>
            </div>

            <div style="float:right">
                <form action="{{ url('/emptyCart') }}" method="POST">
                    {!! csrf_field() !!}
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="submit" class="btn btn-danger btn-lg" value="{{__('shop.emptycart')}}">
                </form>
            </div>

        @else

            <h3>{{__('shop.noitems')}}</h3>
            <br>
            <a href="{{ url('/shop') }}" class="btn btn-primary btn-lg">{{__('shop.goshopping')}}</a>

        @endif

        <div class="spacer"></div>
@endsection

@section('scripts')
<script src="{{ asset('js/app.js') }}"></script>
<script  src="{{ asset('js/productshow.js') }}"></script>
    <script>
        (function(){
            const classname = document.querySelectorAll('.quantity')

            Array.from(classname).forEach(function(element) {
                element.addEventListener('change', function() {
                    const id = element.getAttribute('data-id')
                    const productQuantity = element.getAttribute('data-productQuantity')

                    axios.patch(`/cart/${id}`, {
                        quantity: this.value,
                    })
                    .then(function (response) {
                        //  console.log(response);
                        window.location.href = '{{ route('cart.index') }}'
                    })
                    .catch(function (error) {
                        //  console.log(error);
                        window.location.href = '{{ route('cart.index') }}'
                    });
                })
            })
        })();
    </script>
    
@endsection