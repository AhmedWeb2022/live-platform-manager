<form action="{{ $route }}" method="{{ $method }}">
  @csrf
  @method($method)
  <div class="row">
    <div class="col-lg-8 col-md-12 col-12">
      <div class="form-add">
        <label for="name">Platform Name</label>
        <input type="text" name="name" id="name" value="{{ isset($platform) ? $platform->name : old('name') }}"
          placeholder="platform name" />
      </div>
      @error('name')
        <span class="text-danger">{{ $message }}</span>
      @enderror
    </div>
    <div class="col-lg-8 col-md-12 col-12">
      <div class="form-add">
        <label for="name">Platform URL</label>
        <input type="url" name="url" id="url" value="{{ isset($platform) ? $platform->url : old('url') }}"
          placeholder="Platform URL" />
      </div>
      @error('url')
        <span class="text-danger">{{ $message }}</span>
      @enderror
    </div>
    <div class="col-lg-8 col-md-12 col-12">
      <div class="form-add">
        <label for="name">Platform Code</label>
        <input type="text" name="code" id="code"
          value="{{ isset($platform) ? $platform->code : old('code') }}" placeholder="Platform Code" />
      </div>
      @error('code')
        <span class="text-danger">{{ $message }}</span>
      @enderror
    </div>
    <div class="col-lg-8 col-md-12 col-12">
      <button type="submit" class="add-newproject">
        Add Platform
      </button>
      <a href="{{ $back }}">
        <button type="button" class="add-newproject">
          Back
        </button>
      </a>

      <script>
        function addratesAndRedirect() {
          Swal.fire({
            html: ' <br> <img class="img-pop" src="photo/finger.png" alt="">' +
              "<br>" +
              "<br>  <h4 class='done' >تم اضافة المشروع لديك بنجاح </h4>" +
              "<br>" +
              "<br>  <p class='done' >يمكنك بكل سهولة الاطلاع علي تفاصيل المشروع و متابعة اخر تطورات المشروع و عدد لمتبرعين و المبلغ المتبقي للمشروع </p>" +
              "<br>" +
              ' <a href="project_detalies.html"><button type="button" class="add-newproject">عرض تفاصيل المشروع</button></a>',
          }).then((result) => {
            if (result.isConfirmed) {
              // Redirect to another page
              window.location.href = "index.html";
            }
          });
        }
      </script>
    </div>
  </div>
</form>
