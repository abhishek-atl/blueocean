@extends('admin.layouts.default')

@section('title', 'Gift Certificates')

@section('content')

<div class="container-fluid">

    <div class="row py-3">
        <div class="col-md-12">
            <div class="card-style d-flex flex-wrap align-items-center justify-content-between">
                <div class="title">
                    <h2>Gift Certificates</h2>
                    <div class="breadcrumb-wrapper">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('admin.dashboard')}}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active">Gift Certificates</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="right-content">
                    <form class="row row-cols-lg-auto g-3 align-items-center" method="get" action="{{ url()->current() }}">
                        <div class="col-12">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Search..." value="{{ Request::get('search') }}">
                                @if(!Request::get('search'))
                                <button class="btn btn-secondary" type="submit"><i class="fa fa-search"></i></button>
                                @else
                                <a href="{{ url()->current() }}" class="btn btn-secondary" type="button">Clear</a>
                                @endif
                            </div>
                        </div>
                        <div class="col-12">
                            <a href="{{ route('admin.gift_certificates.create')}}" class="btn btn-primary">Create Certificate</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-md-12">

            <div class="card-style mb-30">
                <table class="table striped-table table-fixed">
                    <thead>
                        <tr>
                            <th scope="col" style="width: 8%;">
                                <a href="{{ route('admin.gift_certificates.index', array_merge(request()->query(), ['sort_by' => 'id', 'sort_order' => request('sort_order') === 'asc' ? 'desc' : 'asc'])) }}">
                                    ID @if($sort_by == 'id') @if($sort_order == 'asc') <i class="fa fa-chevron-down"></i> @else <i class="fa fa-chevron-up"></i> @endif @endif
                                </a>
                            </th>
                            <th scope="col" style="width: 12%;">
                                Gift Code
                            </th>
                            <th scope="col" style="width: 12%;">
                                Recipient
                            </th>
                            <th scope="col" style="width: 10%;">
                                Amount
                            </th>
                            <th scope="col" style="width: 10%;">
                                Payment Status
                            </th>
                            <th scope="col" style="width: 10%;">
                                Remaining
                            </th>
                            <th scope="col" style="width: 12%;">
                                Expires
                            </th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($giftCertificates as $cert)
                        <tr>
                            <th scope="row">{{ $cert->id }}</th>
                            <td><code>{{ $cert->gift_code }}</code></td>
                            <td>{{ $cert->recipient_name }}</td>
                            <td>${{ number_format($cert->gift_amount, 2) }}</td>
                            <td>
                                <span class="badge
                                    @if($cert->payment_status == 'paid') bg-success
                                    @elseif($cert->payment_status == 'in_progress') bg-info
                                    @else bg-danger @endif">
                                    {{ ucfirst(str_replace('_', ' ', $cert->payment_status)) }}
                                </span>
                            </td>
                            <td>${{ number_format($cert->remaining_amount, 2) }}</td>
                            <td>{{ $cert->expire_at }}</td>
                            <td>
                                <div class="action">
                                    <a href="{{ route('admin.gift_certificates.edit', ['id' => $cert->id]) }}" class="text-dark me-3">
                                        <i class="fa fa-pen"></i>
                                    </a>
                                    <a href="{{ route('admin.gift_certificates.destroy', ['id' => $cert->id]) }}" class="text-danger" onclick="return confirm('Are you sure you want to delete this certificate?');">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">No gift certificates found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
