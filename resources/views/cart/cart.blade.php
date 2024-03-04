@extends('layout.app')

@section('content')
<section class="breadcrumb-section section-b-space" style="padding-top:20px;padding-bottom:20px;">
    <ul class="circles">
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
    </ul>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h3>Cart</h3>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{route('app.index')}}">
                                <i class="fas fa-home"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Cart</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Cart Section Start -->
<section class="cart-section section-b-space">
    <div class="container">
        @if($cartItems->Count() > 0)
        <div class="row">
            <div class="col-md-12 text-center">
                <table class="table cart-table">
                    <thead>
                        <tr class="table-head">
                            <th scope="col">image</th>
                            <th scope="col">product name</th>
                            <th scope="col">price</th>
                            <th scope="col">quantity</th>
                            <th scope="col">total</th>
                            <th scope="col">action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cartItems as $item)
                        <tr>
                            <td>
                                <a href="{{route('shop.product.details',['slug'=>$item->model->slug])}}">
                                    <img src="{{asset('assets/images/fashion/product/front')}}/{{$item->model->image}}" class="blur-up lazyloaded" alt="{{$item->model->name}}">
                                </a>
                            </td>
                            <td>
                                <a href="{{route('shop.product.details',['slug'=>$item->model->slug])}}">{{$item->model->name}}</a>
                                <div class="mobile-cart-content row">
                                    <div class="col">
                                        <div class="qty-box">
                                            <div class="input-group">
                                            <form id="updateForm">
                                                    @csrf  
                                                    @method('put')
                                                    <input type="number" min="1" id="valeurMobile" class="form-control input-number" data-rowid="{{$item->rowId}}" name="quantity" value="{{$item->qty}}" min="0" max="100">
                                                  
                                                    <input type="hidden" id="rowId" name="rowId" value="{{$item->rowId}}" />
                                                </form>
                                               
                                                                                    
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <h2>${{$item->price}}</h2>
                                    </div>
                                    <div class="col">
                                        <h2 class="td-color">
                                            <a href="javascript:void(0)">
                                                <i class="fas fa-times"></i>
                                            </a>
                                        </h2>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <h2>${{$item->price}}</h2>
                            </td>
                            <td>
                                <div class="qty-box">
                                    <div class="input-group">
                                        <input id="valeur{{$item->rowId}}" type="number" min="1" name="quantity" onchange="updateQuantity('{{$item->rowId}}' ,{{$item->price}})"  data-rowid="{{$item->rowId}}" class="form-control input-number" value="{{$item->qty}}">
                                        <!-- <form id="updateForm">
                                                    @csrf  
                                                    @method('put')
                                                    <input type="number" id="valeur" class="form-control input-number" data-rowid="{{$item->rowId}}" name="quantity" value="{{$item->qty}}" min="0" max="100">
                                                  
                                                    <input type="hidden" id="rowId" name="rowId" value="{{$item->rowId}}" />
                                                </form> -->
                                    </div>
                                </div>
                            </td>
                            <td>
                                <h2 id="subTotal{{$item->rowId}}" class="td-color">${{$item->subtotal()}} </h2>
                            </td>
                            <td>
                                <a href="javascript:void(0)" onclick="removeItemFromCart('{{$item->rowId}}')">
                                    <i class="fas fa-times"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-12 mt-md-5 mt-4">
                <div class="row">
                    <div class="col-sm-7 col-5 order-1">
                        <div class="left-side-button text-end d-flex d-block justify-content-end">
                            <a href="javascript:void(0)" onclick="clearCart()" class="text-decoration-underline theme-color d-block text-capitalize">clear
                                all items</a>
                        </div>
                    </div>
                    <div class="col-sm-5 col-7">
                        <div class="left-side-button float-start">
                            <a href="{{route('shop.index')}}" class="btn btn-solid-default btn fw-bold mb-0 ms-0">
                                <i class="fas fa-arrow-left"></i> Continue Shopping</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="cart-checkout-section">
                <div class="row g-4">
                    <div class="col-lg-4 col-sm-3">
                        <div class="promo-section">
                            <div id="couponForm" class="row g-3">
                                <div class="col-7">
                                    <input type="text" class="form-control" id="couponCode" placeholder="Coupon Code">
                                </div>
                                <div class="col-5">
                                    <button onclick="applyCoupon()" class="btn btn-solid-default rounded btn">Apply Coupon</button>
                                </div>
</div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-sm-6 ">
                        <div class="checkout-button">
                            <a href="javascript:void(0)" onclick="checkout()"  class="btn btn-solid-default btn fw-bold">
                                Check Out 1 <i class="fas fa-arrow-right ms-1"></i></a>
                        </div>
    
                    </div>
                    <div class="col-lg-6 col-sm-4 ">
                   <!-- start form -->
   

                    <!-- end form  -->
                    </div>
                    <div class="col-lg-6">
                        <div class="cart-box">
                            <div class="cart-box-details">
                                <div class="total-details">
                                    <div class="top-details">
                                        <h3>Cart Totals</h3>
                                        <h6>Sub Total <span id="subTotal4">${{Cart::instance('cart')->subtotal() }}</span></h6>
                                        <h6>Tax <span  id="tax">${{Cart::instance('cart')->tax()}}</span></h6>
                                        <h6 id="discountpercentageTitle" style="display: none;">Percentage Discount <span  id="percentage"></span></h6>
                                        <h6 id="totalCart">Total <span id="total">${{Cart::instance('cart')->total()}}</span></h6>
                                    </div>
                                    <div class="bottom-details">
                                        <a href="{{route('shop.checkout')}}">Process Checkout</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="row">
            <div class="col-md-12 text-center">
                <h2>Your cart is empty !</h2>
                <h5 class="mt-3">Add Items to it now.</h5>
                <a href="{{route('shop.index')}}" class="btn btn-warning mt-5">Shop Now</a>
            </div>
        </div>
        @endif
    </div>
</section>
<form id="updateCartQty">
    <!-- @csrf
    @method('put') -->
    <input type="hidden" id="rowId" name="rowId" />
    <input type="hidden" id="quantity" name="quantity" />
</form>
<form id="deleteFromCart" action="{{route('cart.remove')}}" method="post">
    @csrf
    @method('delete')
    <input type="hidden" id="rowId_D" name="rowId" />
</form>
<form id="clearCart" action="{{route('cart.clear')}}" method="POST">
    @csrf
    @method('delete')
</form>
<form id="checkoutForm" action="{{route('shop.checkout')}}" method="POST">
    @csrf
    @method('POST')
<input type="hidden" id="codecpn" name="total" value="" />
    
</form>
@endsection
@push('scripts')
<script>
    // $(document).ready(function() {
    //   $('#valeur').on('input', function() {
    //     var valeur = parseInt($(this).val());
    //     updateQuantity(valeur);
    //   });
    //   $('#valeurMobile').on('input', function() {
    //     var valeur = parseInt($(this).val());
    //     updateQuantity(valeur);
    //   });
function updateQuantity(rowid , price) {

    var quantity = $('#valeur' + rowid).val();

        console.log(rowid ,quantity );
        $('#subTotal'+rowid).html('$'+($('#valeur' + rowid).val()) * (price)  +'.00');
        $.ajax({
   
   url: "{{route('cart.update')}}",
   header:{
      'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
    },
   method: "PUT",
   dataType: 'json',
   data: {
         "_token": "{{ csrf_token() }}",
         contentType:'application/json',
         rowid: rowid,
         quantity: quantity
        
                     },
   success: function(response) {
     getCartTotal();
     console.log(response);
    

     
   },
   error:function(err){
    console.log(err)
   }
 });

    }
      function submitQuantity(rowid,quantity) {
        $.ajax({
   
          url: "{{route('cart.update')}}",
          method: "POST",
          dataType: 'json',
          data: {
                "_token": "{{ csrf_token() }}",
                rowid: rowid,
                quantity: quantity
               
                            },
          success: function(response) {
            console.log("quantity",response);
            getCartTotal();
            console.log(response);
            
          }
        });
      }
    // });

    function clearCart() {
        $("#clearCart").submit();
    
    }


    function checkout() {
  
        var couponCode = $('#couponCode').val();
        // $("#checkoutForm").submit();    
        var input = $("<input>")
            .attr("type", "hidden")
            .attr("name", "totadl")
            .val(couponCode);

        // Append the input field to the form
        $("#checkoutForm").append(input);

        // Submit the form
        $("#checkoutForm").submit();
//         $.ajax({
   
//         url: "{{route('shop.checkout')}}",
//         method: "POST",
//         dataType: 'json',
//         data: {
//          "_token": "{{ csrf_token() }}",
//          couponCode: couponCode,
        
//                      },
//    success: function(response) {
     
//      console.log(response);
     
//         }
//     });
    }

  

    function getCartTotal() {
                        $.ajax({
                            type: 'GET',
                            url: "{{route('shop.cart.total')}}",
                            success: function(data) {
                                console.log("my data",data);
                                if (data.status == 200) {
                                    $("#total").html(data.total);
                                    $("#tax").html(data.tax);
                                    $("#subTotal").html(data.subTotal);
                                    $("#subTotal4").html(data.subTotal);
                                }
                            }
                        });
                    }
  
    
    function removeItemFromCart(rowId)
        {
            $('#rowId_D').val(rowId);
            $('#deleteFromCart').submit();
        }  

        function applyCoupon() {
    var couponCode = $('#couponCode').val();

    $.ajax({
        url: "{{ route('apply.coupon') }}",
        type: "POST",
        data: {
            '_token': '{{ csrf_token() }}',
            'couponCode': couponCode
        },
        success: function(response) {
            // prc =  response[0].price
            // console.log(response.status);
            
            if(response.status == 200){
                var couponValue = response[0].coupon.value;
                var originalPrice =  response[0].originalPrice;
                var total = (originalPrice - couponValue).toFixed(2);
                if(total<=0 ){
                    $.notify({
                icon: "fa fa-check",
                title: "info",
                message: "please chose more than one article !",
               
            });

            $("#percentage").html("0%");
            $("#total").html(response[0].originalPrice);
            
            $("h6#discountpercentageTitle").hide();
                }else{
                localStorage.setItem('couponValue', response[0].coupon.code);
                $("#total").html(total);
                $("#percentage").html(response[0].percentageDiscount + "%");
                $("h6#discountpercentageTitle").show();
                }
            // $("#percentage").html(response[0].coupon.value);
            
        }else if(response.status == 400){
          
        //   console.log(prc);
            $.notify({
                icon: "fa fa-check",
                title: "error",
                message: "this coupon is incorrect !"
            });

            $("#percentage").html("0");
            $("#total").html(response.price);
            
            $("h6#discountpercentageTitle").hide();
        }
          
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
}
            
</script>
@endpush