@extends('admin.layouts.default')

@if(isset($blacklist))
@section('title', 'Edit Blacklist Entry')
@else
@section('title', 'Add to Blacklist')
@endif

@section('content')

<div class="container-fluid">
    <div class="row py-4">
        <div class="col-md-12">
            <div class="card-style d-flex flex-wrap align-items-center justify-content-between">
                <div class="title">
                    @if(isset($blacklist))
                    <h2>Edit Blacklist Entry</h2>
                    @else
                    <h2>Add to Blacklist</h2>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.blacklists.store') }}" method="post">

        @csrf

        @isset($blacklist)
        <input type="hidden" name="id" value="{{ $blacklist->id }}" />
        @endisset

        <div class="row">

            <div class="col-lg-12">
                <div class="card-style mb-30">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="mobile">Mobile Number</label>
                                <input type="text" name="mobile" id="mobile" class="form-control" placeholder="Mobile Number" value="{{ old('mobile', $blacklist->mobile ?? '') }}" />
                                @error('mobile')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="ip_address">IP Address</label>
                                <input type="text" name="ip_address" id="ip_address" class="form-control" placeholder="IP Address" value="{{ old('ip_address', $blacklist->ip_address ?? '') }}" />
                                @error('ip_address')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="type">Type</label>
                                <select name="type" id="type" class="form-control">
                                    <option value="">-- Select Type --</option>
                                    <option value="mobile" @if(isset($blacklist) && $blacklist->type == 'mobile') selected @endif>Mobile</option>
                                    <option value="ip" @if(isset($blacklist) && $blacklist->type == 'ip') selected @endif>IP Address</option>
                                </select>
                                @error('type')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="requested_by">Requested By (User ID)</label>
                                <input type="number" name="requested_by" id="requested_by" class="form-control" placeholder="User ID" value="{{ old('requested_by', $blacklist->requested_by ?? '') }}" />
                                @error('requested_by')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="reason">Reason</label>
                        <textarea name="reason" id="reason" class="form-control" rows="4" placeholder="Reason for blacklisting">{{ old('reason', $blacklist->reason ?? '') }}</textarea>
                        @error('reason')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label col-4 required">Approved</label>
                        <div class="form-check form-check-inline radio-style mb-20">
                            <input type="radio" name="active" id="active_yes" value="1" @if($blacklist->approved_at) checked @endif>
                            <label class="form-check-label" for="active_yes">Yes</label>
                        </div>
                        <div class="form-check form-check-inline radio-style mb-20">
                            <input type="radio" name="active" id="active_no" value="0" @if(!$blacklist->approved_at) checked @endif>
                            <label class="form-check-label" for="active_no">No</label>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-lg-12">
                <div class="card-style mb-30">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="{{ route('admin.blacklists.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </div>
        </div>
    </form>

</div>
@endsection