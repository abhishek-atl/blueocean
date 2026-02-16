@extends('admin.layouts.default')

@section('content')

<div class="container-fluid">

    <div class="row py-4">
        <div class="col-md-12">
            <div class="d-flex flex-wrap align-items-center justify-content-between">
                <div class="title">
                    <h2>Therapists</h2>
                </div>
                <div class="right-content">
                    <a href="{{ route('admin.therapists.create')}}" class="btn btn-primary">Create Therapist</a>
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
                            <th scope="col">First Name</th>
                            <th scope="col">Last Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Mobile</th>
                            <th scope="col">Active</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($therapists as $therapist)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $therapist->first_name }}</td>
                            <td>{{ $therapist->last_name }}</td>
                            <td>{{ $therapist->email }}</td>
                            <td>{{ $therapist->user_profile->mobile ?? 'N/A' }}</td>
                            <td>{{ $therapist->active ? 'Active' : 'Inactive' }}</td>
                            <td>
                                <div class="action">

                                    <div class="action">
                                        <a href="{{ route('admin.therapists.edit', ['id' => $therapist->id]) }}" class="text-dark me-3">
                                            <i class="fa fa-pen"></i>
                                        </a>
                                        <a href="{{ route('admin.therapists.destroy', ['id' => $therapist->id]) }}" class="text-danger" onclick="return confirm('Are you sure you want to delete this therapist?');">
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

        <div class="col-md-12">
            {{ $therapists->onEachSide(3)->links() }}
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