@extends('admin.layouts.default')

@section('content')

<div class="container-fluid">

    <div class="row py-4">
        <div class="col-md-12">
            <div class="card-style d-flex flex-wrap align-items-center justify-content-between">
                <div class="title">
                    <h2>Postcode Zones</h2>
                    <div class="breadcrumb-wrapper">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('admin.dashboard')}}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active">Postcode Zones</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-md-12">

            <div class="card-style mb-30">
                <table class="table striped-table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
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
                                    <a href="{{ route('admin.postcode_zones.edit', ['id' => $zone->id]) }}" class="text-dark me-3">
                                        <i class="fa fa-pen"></i>
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

@push('pageScripts')

<script>
    $(document).ready(function () {
        @if (Session:: has('status'))
    toastr.success("{{ Session::get('status') }}")
    @endif
    });
</script>

@endpush