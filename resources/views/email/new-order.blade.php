
<!-- <table>
    <tr>
        <th>Image</th>
        <th>Title</th>
        <th>Price</th>
        <th>Quantity</th>
    </tr>
    @foreach($order->items as $item)
        <tr>
            <td>
                <img src="{{$item->product->image}}" style="width: 100px">
            </td>
            <td>{{$item->product->title}}</td>
            <td>${{$item->unit_price * $item->quantity}}</td>
            <td>{{$item->quantity}}</td>
        </tr>
    @endforeach
</table> -->

<div class="container">
    <h1 class="mt-5">New order has been created</h1>

    <table class="table mt-4">
        <tbody>
            <tr>
                <th>Order ID</th>
                <td>
                    <a href="#">{{$order->id}}</a>
                </td>
            </tr>
            <tr>
                <th>Order Status</th>
                <td>{{ $order->status }}</td>
            </tr>
            <tr>
                <th>Order Price</th>
                <td>${{ $order->total }}</td>
            </tr>
            <tr>
                <th>Order Date</th>
                <td>{{ $order->created_at }}</td>
            </tr>
        </tbody>
    </table>

    <table class="table cart-table table-borderless">
        <tbody>
            @foreach ($items as $item)
            <tr class="table-order">
                <td>
                    <a href="{{ route('shop.product.details',['slug'=>$item->product->slug]) }}">
                        <img src="{{ asset('assets/images/fashion/product/front') }}/{{$item->product->image}}" class="img-fluid blur-up lazyload" alt="Product Image" style="width: 100px;">
                    </a>
                </td>
                <td>
                    <p class="font-light">Product Name</p>
                    <h5>{{$item->product->name}}</h5>
                </td>
                <td>
                    <p class="font-light">Quantity</p>
                    <h5>{{$item->quantity}}</h5>
                </td>
                <td>
                    <p class="font-light">Price</p>
                    <h5>${{$item->price}}</h5>
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="table-order">
                <td colspan="3">
                    <h5 class="font-light">Subtotal :</h5>
                </td>
                <td>
                    <h4>${{ $order->subtotal }}</h4>
                </td>
            </tr>
            @if($order->discount > 0)
            <tr class="table-order">
                <td colspan="3">
                    <h5 class="font-light">Discount :</h5>
                </td>
                <td>
                    <h4>${{ $order->discount }}</h4>
                </td>
            </tr>
            @endif
            <tr class="table-order">
                <td colspan="3">
                    <h5 class="font-light">Tax(GST) :</h5>
                </td>
                <td>
                    <h4>${{ $order->tax }}</h4>
                </td>
            </tr>
            <tr class="table-order">
                <td colspan="3">
                    <h4 class="theme-color fw-bold">Total Price :</h4>
                </td>
                <td>
                    <h4 class="theme-color fw-bold">${{ $order->total }}</h4>
                </td>
            </tr>
        </tfoot>
    </table>
</div>

