@extends('admin.layouts.default')

@section('content')

<div class="container-fluid">

    <div class="row py-4">
        <div class="col-md-12">
            <div class="d-flex flex-wrap align-items-center justify-content-between">
                <div class="title">
                    <h2>Districts</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-md-12">

            @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <div class="card-style mb-30">
                <table class="table striped-table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Postcode</th>
                            <th scope="col">District</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($districts as $district)
                        <tr>
                            <th scope="row">{{ $district->id }}</th>
                            <td>{{ $district->postcode_area }}</td>
                            <td>{{ $district->district_name }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-md-12">
            {{ $districts->onEachSide(3)->links() }}
        </div>

    </div>

</div>
@endsection