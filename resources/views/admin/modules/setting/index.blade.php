@extends('admin.layouts.default')

@section('title', 'Settings')

@section('content')
<div class="container-fluid">
    <div class="row py-3">
        <div class="col-md-12">
            <div class="card-style d-flex flex-wrap align-items-center justify-content-between">
                <div class="title">
                    <h2>Settings</h2>
                    <div class="breadcrumb-wrapper">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active">Settings</li>
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
                <table class="table striped-table table-fixed">
                    <thead>
                        <tr>
                            <th scope="col" style="width: 10%;">ID</th>
                            <th scope="col" style="width: 30%;">Key</th>
                            <th scope="col">Value</th>
                            <th scope="col" style="width: 12%;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($settings as $setting)
                        <tr>
                            <th scope="row">{{ $setting->id }}</th>
                            <td><code>{{ $setting->param_key }}</code></td>
                            <td>{{ $setting->param_value }}</td>
                            <td>
                                <div class="action">
                                    <a href="{{ route('admin.settings.edit', $setting) }}" class="text-dark me-3" aria-label="Edit {{ $setting->param_key }}">
                                        <i class="fa fa-pen"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">No settings found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                {{ $settings->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
