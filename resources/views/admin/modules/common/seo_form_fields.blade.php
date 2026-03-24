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
    <label class="col-lg-4 col-form-label">Extra Meta Tags<span class="text-danger">*</span></label>
    <div class="col-lg-7">
        <textarea class="form-control" id="extra_meta_tags" name="extra_meta_tags" placeholder="Enter Extra Meta Tags..">{{ $entity?->extra_meta_tags ?? '' }}</textarea>
    </div>
</div>
