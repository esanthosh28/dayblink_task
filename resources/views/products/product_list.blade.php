@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Product list</h2>
            </div>
            <div class="pull-right">
                <a href="{{ url('cart') }}"
                   style="color: #393f81;">Click here for cart page</a>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered table-responsive-lg">
        <tr>
            <th>Name</th>
            <th>Price</th>
        </tr>
        @foreach ($products as $project)
            <tr>

                    <td><a href="product/{{$project->id}}">{{ $project->name }}</a></td>
                    <td>{{ $project->price }}</td>


            </tr>
        @endforeach
    </table>


@endsection
