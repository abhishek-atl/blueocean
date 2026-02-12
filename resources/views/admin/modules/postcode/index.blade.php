@extends('admin.layouts.default')

@section('content')

<div class="container-fluid">

    <div class="row py-4">
        <div class="col-md-12">
            <div class="d-flex flex-wrap align-items-center justify-content-between">
                <div class="title">
                    <h2>Postcodes</h2>
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
                            <th scope="col">Travel Supplement</th>
                            <th scope="col">Active</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($postcodes as $postcode)
                        <tr>
                            <th scope="row">{{ $postcode->id }}</th>
                            <td>{{ $postcode->postcode }}</td>
                            <td>{{ $postcode->district->district_name }}</td>
                            <td>{{ $postcode->travel_supp ?? 'Free'}}</td>
                            <td>{{ $postcode->active ? 'Yes' : 'No' }}</td>
                            <td>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-md-12">
            {{ $postcodes->onEachSide(3)->links() }}
        </div>

    </div>

</div>
@endsection