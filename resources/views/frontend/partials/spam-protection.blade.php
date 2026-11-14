@error('application')
<div class="alert alert-danger" role="alert">{{ $message }}</div>
@enderror

<div style="display: none;" aria-hidden="true">
    <label for="form-website">Website</label>
    <input type="text" id="form-website" name="website" value="" tabindex="-1" autocomplete="off">
</div>
