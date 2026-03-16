<h4 class="mt-2">SEO Settings</h4>

<div class="form-group row mb-3">
    <label class="col-lg-4 col-form-label">Meta Title <span class="text-danger">*</span></label>
    <div class="col-lg-7">
        <input type="text" class="form-control" id="page_meta_title" name="page_meta_title" placeholder="Enter page meta title.." value="@if($entity){{ $entity?->page_meta_title }}@endif">
    </div>
</div>
<div class="form-group row mb-3">
    <label class="col-lg-4 col-form-label">Meta Description <span class="text-danger">*</span></label>
    <div class="col-lg-7">
        <input type="text" class="form-control" id="page_meta_tag" name="page_meta_tag" placeholder="Enter page meta tag.." value="@if($entity){{ $entity?->page_meta_tag }}@endif">
    </div>
</div>
<div class="form-group row mb-3">
    <label class="col-lg-4 col-form-label">Slug <span class="text-danger">*</span></label>
    <div class="col-lg-7">
        <input type="text" class="form-control" id="slug" name="slug" placeholder="Enter slug.." value="@if($entity){{ $entity?->slug }}@endif">
    </div>
</div>
<div class="form-group row mb-3">
    <label class="col-lg-4 col-form-label">Image Alt <span class="text-danger">*</span></label>
    <div class="col-lg-7">
        <input type="text" class="form-control" id="image_alt" name="image_alt" placeholder="Enter image alt.." value="@if($entity){{ $entity?->image_alt }}@endif">
    </div>
</div>
<div class="form-group row mb-3">
    <label class="col-lg-4 col-form-label">Image Title <span class="text-danger">*</span></label>
    <div class="col-lg-7">
        <input type="text" class="form-control" id="image_title" name="image_title" placeholder="Enter image title.." value="@if($entity){{ $entity?->image_title }}@endif">
    </div>
</div>
<div class="form-group row mb-3">
    <label class="col-lg-4 col-form-label">Extra Meta Tags<span class="text-danger">*</span></label>
    <div class="col-lg-7">
        <textarea class="form-control" id="extra_meta_tags" name="extra_meta_tags" placeholder="Enter Extra Meta Tags..">{{ $entity?->extra_meta_tags ?? '' }}</textarea>
    </div>
</div>
<div class="form-group row mb-3">
    <label class="col-lg-4 col-form-label">Show Progress Bar <span class="text-danger">*</span></label>
    <div class="col-lg-7">
        <label class="radio-inline mr-3">
            <input type="radio" name="show_progress_bar" id="show_progress_bar_yes" value="1" @if($entity && $entity?->show_progress_bar) checked @endif> Yes</label>
        <label class="radio-inline mr-3">
            <input type="radio" name="show_progress_bar" id="show_progress_bar_no" value="0" @if($entity && !$entity?->show_progress_bar) checked @endif> No</label>
    </div>
</div>