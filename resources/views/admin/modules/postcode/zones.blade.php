@extends('admin.layouts.default')

@section('content')

<div class="container-fluid">

    <div class="row py-4">
        <div class="col-md-12">
            <div class="d-flex flex-wrap align-items-center justify-content-between">
                <div class="title">
                    <h2>Postcoder Zones</h2>
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
                            <th scope="col">Postcode Zone Name</th>
                            <th scope="col">Active</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($zones as $zone)
                        <tr>
                            <th scope="row">{{ $zone->id }}</th>
                            <td>{{ $zone->name }}</td>
                            <td>{{ $zone->active ? 'Yes' : 'No' }}</td>
                            <td>
                                <div class="action">
                                    <a href="{{ route('admin.postcodes.zones.edit', ['id' => $zone->id]) }}" class="text-dark me-3">
                                        <i class="fa fa-pen"></i>
                                    </a>
                                    <a href="{{ route('admin.roles.destroy', ['id' => $zone->id]) }}" class="text-danger" onclick="return confirm('Are you sure you want to delete this role?');">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-md-12">
            {{ $zones->onEachSide(3)->links() }}
        </div>

    </div>

</div>
@endsection