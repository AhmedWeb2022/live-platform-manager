<div class="col-lg-8 col-md-12 col-12">
  <div class="form-add">
    <label for="name">Live Account Name</label>
    <input type="text" name="name" id="name"
      value="{{ isset($live_account) ? $live_account->name : old('name') }}"
      placeholder="Enter the name of the live account" />
  </div>
  @error('name')
    <span class="text-danger">{{ $message }}</span>
  @enderror
</div>

<div class="col-lg-8 col-md-12 col-12">
  <div class="form-add">
    <label for="client_id">Client ID</label>
    <input type="text" name="client_id" id="client_id"
      value="{{ isset($live_account) ? $live_account->client_id : old('client_id') }}" placeholder="Enter Client ID" />
  </div>
  @error('client_id')
    <span class="text-danger">{{ $message }}</span>
  @enderror
</div>

<div class="col-lg-8 col-md-12 col-12">
  <div class="form-add">
    <label for="client_secret">Client Secret</label>
    <input type="text" name="client_secret" id="client_secret"
      value="{{ isset($live_account) ? $live_account->client_secret : old('client_secret') }}"
      placeholder="Enter Client Secret" />
  </div>
  @error('client_secret')
    <span class="text-danger">{{ $message }}</span>
  @enderror
</div>
<div class="col-lg-8 col-md-12 col-12">
  <div class="form-add">
    <label for="join_url">Join URL</label>
    <input type="url" name="join_url" id="join_url"
      value="{{ isset($live_account) ? $live_account->join_url : old('join_url') }}" placeholder="Enter Join URL" />
  </div>
  @error('join_url')
    <span class="text-danger">{{ $message }}</span>
  @enderror
</div>
