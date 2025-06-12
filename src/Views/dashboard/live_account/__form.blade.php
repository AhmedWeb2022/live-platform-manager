<form action="{{ $route }}" method="{{ $method }}">
  @csrf
  @method($method)

  <div class="row">

    {{-- Integration Type --}}
    <div class="col-lg-8 col-md-12 col-12">
      <label for="Type-donation">Integration Type</label>
      <div class="select">
        <select id="Type-donation" name="integeration_type" class="form-select" aria-label="Select Integration Type"
          onchange="changeIntegrationType()">
          <option selected disabled>Select Integration Type</option>
          @foreach (ahmedWeb\LivePlatformManager\Enums\PlatformTypeEnum::cases() as $type)
            <option value="{{ $type->value }}"
              {{ isset($live_account) && $live_account->integeration_type == $type->value ? 'selected' : '' }}>
              {{ $type->lable() }}
            </option>
          @endforeach
        </select>
      </div>
      @error('integeration_type')
        <span class="text-danger">{{ $message }}</span>
      @enderror
    </div>
    <div id="integration-fields"></div>



    {{-- Form Actions --}}
    <div class="col-lg-8 col-md-12 col-12 mt-4">
      <button type="submit" class="add-newproject">
        {{ isset($live_account) ? 'Update Live Account' : 'Add Live Account' }}
      </button>
      <a href="{{ $back }}">
        <button type="button" class="add-newproject">
          Cancel & Back
        </button>
      </a>
    </div>

  </div>
  <script>
    function changeIntegrationType() {
      const type = document.getElementById('Type-donation').value;
      const container = document.getElementById('integration-fields');
      if (!type) {
        container.innerHTML = '';
        return;
      }
      fetch(`/load-integration-form/${type}`)
        .then(response => {
          if (!response.ok) throw new Error('Network response was not ok');
          return response.text();
        })
        .then(html => {
          container.innerHTML = html;
        })
        .catch(error => {
          console.error('Error loading integration form:', error);
          container.innerHTML = '<p class="text-danger">Failed to load form.</p>';
        });
    }
  </script>

</form>

{{-- JavaScript to Handle Field Visibility --}}
