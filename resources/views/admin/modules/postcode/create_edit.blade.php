@extends('admin.layouts.default')

@if(isset($postcode))
@section('title', 'Edit Postcode')
@else
@section('title', 'Create Postcode')
@endif

@section('content')

<div class="container-fluid">
    <div class="row py-4">
        <div class="col-md-12">
            <div class="card-style d-flex flex-wrap align-items-center justify-content-between">
                <div class="title">
                    @if(isset($postcode))
                    <h2>Edit Postcode</h2>
                    @else
                    <h2>Create Postcode</h2>
                    @endif
                </div>
            </div>
        </div>
    </div>


    <form action="{{ route('admin.postcodes.store') }}" method="post">

        @csrf

        @isset($postcode)
        <input type="hidden" name="id" value="{{ $postcode->id }}" />
        @endisset

        <div class="row">

            <div class="col-lg-12">
                <div class="card-style mb-30">

                    <div class="mb-3">
                        <label class="form-label required" for="postcode">Postcode</label>
                        <input type="text" name="postcode" id="postcode" class="form-control" placeholder="Postcode" value="{{ old('postcode', $postcode->postcode ?? '') }}" />
                        @error('postcode')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label required" for="district_id">District</label>
                        <select name="district_id" class="form-control">
                            @foreach($districts as $district)
                            <option value="{{ $district->id }}" @if($postcode && $district->id == $postcode->district_id) selected="selected" @endif>{{ $district->district_name }} - {{ $district->postcode_area }}</option>
                            @endforeach
                        </select>
                        @error('district_id')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label required" for="travel_supp">Travel Supplement</label>
                        <input type="text" name="travel_supp" id="travel_supp" class="form-control" placeholder="Travel Supplement" value="{{ old('travel_supp', $postcode->travel_supp ?? '') }}" />
                        @error('travel_supp')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-3">
                        <label class="form-label col-4 required">Active</label>
                        <div class="form-check form-check-inline radio-style mb-20">
                            <input type="radio" name="active" id="active_y" value="1" @if($postcode && $postcode->active) checked @endif>
                            <label class="form-check-label" for="active_y">Yes</label>
                        </div>
                        <div class="form-check form-check-inline radio-style mb-20">
                            <input type="radio" name="active" id="active_n" value="0" @if($postcode && !$postcode->active) checked @endif>
                            <label class="form-check-label" for="active_n">No</label>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-lg-12">
                <div class="card-style mb-30">
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a href="{{ route('admin.postcodes.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </form>

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