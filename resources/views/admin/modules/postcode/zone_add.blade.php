@extends('admin.layouts.default')

@section('content')

<div class="container-fluid">
    <div class="row py-4">
        <div class="col-md-12">
            <div class="d-flex flex-wrap align-items-center justify-content-between">
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


    <div class="row">
        <div class="col-lg-12">

            <div class="card-style mb-30">

                <form action="{{ route('admin.postcodes.zones.store') }}" method="post">
                    @csrf

                    @isset($postcode)
                    <input type="hidden" name="id" value="{{ $postcodeZone->id }}" />
                    @endisset

                    <div class="row mb-3">
                        <label class="col-2 col-form-label required" for="name">Name</label>
                        <div class="col-4">
                            <input type="text" name="name" id="name" class="form-control" placeholder="Role Name" value="{{ old('name', $postcodeZone->name ?? '') }}" />
                            @error('name')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-2 col-form-label">Active <span class="text-danger">*</span></label>
                        <div class="col-4">
                            <label class="radio-inline mr-3">
                                <input type="radio" name="active" id="enabled_yes" value="1" @if($isEdit && $postcodeZone->active) checked @endif> Yes</label>
                            <label class="radio-inline mr-3">
                                <input type="radio" name="active" id="enabled_no" value="0" @if($isEdit && !$postcodeZone->active) checked @endif> No</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="offset-2 col-4">
                            <button type="submit" class="btn btn-primary">Save</button>
                            <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </div>


                    <h5>Postcodes</h5>

                    @foreach($districts as $district)
                    <div class="form-group row border my-3 pb-3">
                        <div class="col-md-12 p-0">
                            <div class="bg-secondary p-2 text-white">{{ $district->postcode_area }} {{ $district->district }}</div>
                            <div class="form-check mx-3 my-3">
                                <input class="form-check-input checkAll" type="checkbox" name="checkAll{{ $district->id}}" value="" id="checkAll{{ $district->id}}">
                                <label class="form-check-label" for="checkAll{{ $district->id}}">
                                    Choose All {{ $district->postcode_area }} {{ $district->district }} Postcodes
                                </label>
                            </div>
                        </div>
                        @foreach($district->postcodes as $postcode)
                        <div class="col-md-2">
                            <div class="form-check my-2">
                                <input class="form-check-input" type="checkbox" name="postcode[]" value="{{$postcode->id}}" id="{{$postcode->id}}" @if($isEdit && $postcodeZone->postcodes && $postcodeZone->postcodes->contains('id',$postcode->id)) checked @endif>
                                <label class="form-check-label" for="{{$postcode->id}}">
                                    {{ $postcode->postcode }}
                                </label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endforeach

                </form>
            </div>

        </div>
    </div>
</div>
@endsection

@push('pageScripts')
<script>
    $(document).ready(function () {

        $('.checkAll').click(function (event) {
            let parentDiv = $(this).parents('.form-group');
            parentDiv.find('input:checkbox').prop('checked', this.checked);
        })


    });
</script>
@endpush