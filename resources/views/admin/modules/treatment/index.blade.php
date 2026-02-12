@extends('admin.layouts.default')

@section('content')

<div class="container-fluid">

    <div class="row py-4">
        <div class="col-md-12">
            <div class="d-flex flex-wrap align-items-center justify-content-between">
                <div class="title">
                    <h2>Treatments</h2>
                </div>
                <div class="right-content">
                    <a href="{{ route('admin.treatments.create')}}" class="btn btn-primary">Create Treatment</a>
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
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Title</th>
                            <th scope="col">Image</th>
                            <th scope="col">Active</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($treatments as $treatment)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $treatment->name }}</td>
                            <td>{{ $treatment->title }}</td>
                            <td>{{ $treatment->image }}</td>
                            <td><span class="status-btn {{ $treatment->is_active ? 'active-btn' : 'inactive-btn' }}">{{ $treatment->is_active ? 'Active' : 'Inactive' }}</span></td>
                            <td>
                                <div class="action">

                                    <div class="action">
                                        <a href="{{ route('admin.treatments.edit', ['id' => $treatment->id]) }}" class="text-dark me-3">
                                            <i class="fa fa-pen"></i>
                                        </a>
                                        <a href="{{ route('admin.treatments.destroy', ['id' => $treatment->id]) }}" class="text-danger" onclick="return confirm('Are you sure you want to delete this treatment?');">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
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