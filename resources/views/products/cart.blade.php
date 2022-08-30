@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Cart Page</h2>
            </div>
            <div class="pull-right">
                <button class="btnPlaceOrder">Place order</button>
            </div>
        </div>
    </div>

    <table class="table table-bordered table-responsive-lg">
        <tr>
            <th>Name</th>
            <th>Qty</th>
            <th>Price</th>
        </tr>
        @foreach ($products as $project)
            <tr>
                <td>{{ $project->name }}</td>
                <td>{{ $project->qty }}</td>
                <td>{{ $project->price }}</td>

            </tr>
        @endforeach
    </table>

    <script type="text/javascript">
        $(document).ready(function(){
            $('.btnPlaceOrder').click(function(e){
                $.ajax({
                    url: "{{ url('placeOrder') }}",
                    type: "POST",
                    data: { "_token": "{{ csrf_token() }}",qty : $('.productqty').val(), productid : $('.productid').val() },
                    success: function(data){

                        if(!data.error){
                            alert('Order Placed successfully');
                            window.location.href="product_list";
                        }
                    },
                    statusCode: {
                        401: function() {
                            alert('Please login to proceed further')
                        },
                        500: function(xhr) {
                            alert('some error occured');
                        }
                    }
                });

            })
        })
    </script>


@endsection
