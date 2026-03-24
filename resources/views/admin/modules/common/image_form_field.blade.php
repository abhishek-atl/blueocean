<div class="mb-3">
    <label class="form-label" for="image">Featured Image</label>
    <input type="file" name="image" id="image" class="form-control" accept="image/*" />
    @error('image')
    <div class="text-danger">{{ $message }}</div>
    @enderror
    @if(isset($entity) && $entity->image)
    <div class="mt-2">
        <img src="{{ asset($entity->image) }}" alt="Post Image" style="max-width: 200px; max-height: 200px;">
    </div>
    @endif
</div>

<div class="mb-3">
    <label class="form-label" for="image_alt">Image Alt Text</label>
    <input type="text" name="image_alt" id="image_alt" class="form-control" placeholder="Image Alt Text" value="{{ old('image_alt', $entity->image_alt ?? '') }}" />
    @error('image_alt')
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label" for="image_title">Image Title</label>
    <input type="text" name="image_title" id="image_title" class="form-control" placeholder="Image Title" value="{{ old('image_title', $entity->image_title ?? '') }}" />
    @error('image_title')
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>