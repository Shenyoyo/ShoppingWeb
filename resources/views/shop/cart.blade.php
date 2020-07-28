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

    @if (session()->has('error_message'))
            <div class="alert alert-danger">
                {{ session()->get('error_message') }}
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
                            <div style="position:relative;">
                                <span style="margin-left:100px;width:18px;">
                                <select class="quantity" data-id="{{ $item->rowId }}" product-id="{{$item->model->id}}" id='quantity{{$item->model->id}}' style="width:80px;margin-left:-100px;height:26px" onfocus="selectFocus(this,{{$item->model->id}})"  onchange="this.parentNode.nextSibling.value=this.value">
                                    @for ($i = 1; $i <= (($item->model->amount >= 100) ? 100 : $item->model->amount ); $i++)
                                    <option onclick="selectClick(this,{{$item->model->id}})"  value="{{$i}}">{{$i}}</option>    
                                    @endfor    
                                </select>
                                </span>
                                <input class="quantity" data-id="{{ $item->rowId }}" id='quantityinput{{$item->model->id}}'
                                name="quantity" value="{{$item->qty}}" style="z-index:1;width:60px;position:absolute;left:0px;"
                                 oninput = "value=value.replace(/[^\d]/g,'')">
                            </div>
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
                        @if (Auth::user()->level->offer->discount_yn == 'Y' && $optimunDiscountFlag)
                        <tr>
                            <td class="table-image"></td>
                            <td></td>
                            <td class="small-caps table-bg" style="text-align: right">
                                @if (Session::has('locale') && in_array(Session::get('locale'), ['en']))
                                {{__('shop.abovediscount',[
                                    'level' => Auth::user()->level->name,
                                    'above'=>$above ,
                                    'percent'=>(100-$percent*100)
                                    ])
                                }}
                                @else
                                {{__('shop.abovediscount',[
                                    'level' => Auth::user()->level->name,
                                    'above'=>$above ,
                                    'percent'=>showDiscount($percent*100)
                                    ])
                                }}
                                @endif
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
                <input type="hidden" name="original_total" value="{{ $original_total }}">
                <input type="submit" class="btn btn-success btn-lg" value="{{__('shop.checkout')}}">
            </form>
            </div>

            <div style="float:right">
                <form action="{{ url('/emptyCart') }}" method="POST">
                    {!! csrf_field() !!}
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="submit" class="btn btn-danger btn-lg" value="{{__('shop.emptycartbtn')}}">
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
<script  src="{{ asset('js/cart.js') }}"></script>
    <script>
        (function(){
            const classname = document.querySelectorAll('.quantity')

            Array.from(classname).forEach(function(element) {
                element.addEventListener('change', function() {
                    const id = element.getAttribute('data-id')
                    const productId =element.getAttribute('product-id')
                    const productQuantity = element.getAttribute('data-productQuantity')

                    axios.patch(`/cart/${id}`, {
                        quantity: this.value,
                        productId: productId
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