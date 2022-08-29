@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Product Page</h2>
            </div>

        </div>
    </div>

    <table class="table table-bordered table-responsive-lg">
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Qty</th>
            <th></th>
        </tr>
        <tr>
            <td>{{ $products['name'] }}</td>
            <td>{{ $products['description'] }}</td>
            <td>{{ $products['price'] }}</td>
            <td>
                <input type="text" class="productqty">
                <input type="hidden" class="productid" value="{{$products['id']}}"></td>

            <td><button class="btnaddtocart">Add to cart</button></td>
        </tr>
    </table>

    <script type="text/javascript">
        $(document).ready(function(){
            $('.btnaddtocart').click(function(e){
                $.ajax({
                    url: "{{ url('addToCart') }}",
                    type: "POST",
                    data: { "_token": "{{ csrf_token() }}",qty : $('.productqty').val(), productid : $('.productid').val() },
                    success: function(data){

                        if(!data.error){
                            alert('Product added to cart');
//                            window.location.href="/product_list";
                        } else {
                            alert(data.msg);
                        }
                    }
                });

            })
        })
    </script>


@endsection
