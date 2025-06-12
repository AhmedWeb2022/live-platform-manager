<div class="col-lg-8 col-md-12 col-12">
  <div class="form-add">
    <label for="join_url">Join URL</label>
    <input type="url" name="join_url" id="join_url"
           value="{{ isset($live_account) ? $live_account->join_url : old('join_url') }}"
           placeholder="Enter Join URL" />
  </div>
  @error('join_url')
    <span class="text-danger">{{ $message }}</span>
  @enderror
</div>
