<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- ? Main CSS -->
    <link rel="stylesheet" href="{{ route('liveplatform.assets', 'Dashboard/css/bootstrap.min.css') }}" />
    {{-- <link rel="stylesheet" href="{{ route('liveplatform.assets', 'Dashboard/css/fontawesome.min.css') }}" /> --}}

    <!-- ? Custom CSS -->
    {{-- <link rel="stylesheet" href="{{ route('liveplatform.assets', 'Dashboard/css/dataTables.bootstrap5.min.css') }}" /> --}}
    <link rel="stylesheet" href="{{ route('liveplatform.assets', 'Dashboard/css/sfwa.css') }}" />
    <link rel="stylesheet" href="{{ route('liveplatform.assets', 'Dashboard/css/swiper-bundle.min.css') }}" />
    <link rel="stylesheet" href="{{ route('liveplatform.assets', 'Dashboard/css/aos-anmite.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.22/sweetalert2.min.css"
      integrity="sha512-yX1R8uWi11xPfY7HDg7rkLL/9F1jq8Hyiz8qF4DV2nedX4IVl7ruR2+h3TFceHIcT5Oq7ooKi09UZbI39B7ylw=="
      crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- ? Main JavaScript -->
    <script src="{{ route('liveplatform.assets', 'Dashboard/js/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ route('liveplatform.assets', 'Dashboard/js/bootstrap.min.js') }}"></script>
    <script src="{{ route('liveplatform.assets', 'Dashboard/js/all.min.js') }}"></script>
    <script src="{{ route('liveplatform.assets', 'Dashboard/js/fontawesome.min.js') }}"></script>

    <!-- ? Custom JavaScript -->
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    <script src="{{ route('liveplatform.assets', 'Dashboard/js/charts.js') }}"></script>
    <script src="{{ route('liveplatform.assets', 'Dashboard/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ route('liveplatform.assets', 'Dashboard/js/dataTables.bootstrap5.min.js') }}"></script>

    <title>الرئيسيه</title>
  </head>

  <body>
    <div class="regaster-sfwa">
      <div class="step-one">
        @include('liveplatform::dashboard.component.__messages')
        <div class="adress">
          <img src="{{ route('liveplatform.assets', 'Dashboard/photo/logo.png') }}" alt="" />
        </div>
        <form id="loginForm" action="{{ route('login.store') }}" method="POST">
          @csrf
          @method('POST')

          <!-- Email input -->
          <div class="email">
            <label for="email">البريد الإلكتروني</label>
            <div class="input">
              <img src="{{ route('liveplatform.assets', 'Dashboard/photo/icon-email.svg') }}" alt="" />
              <input type="email" name="email" id="email" value="{{ old('email') }}"
                placeholder="أدخل البريد الإلكتروني" />
            </div>
            @error('email')
              <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>

          <!-- Password input -->
          <div class="password">
            <label for="password">كلمة المرور</label>
            <div class="input">
              <img src="{{ route('liveplatform.assets', 'Dashboard/photo/shield-security.svg') }}" alt="" />
              <input type="password" name="password" id="password" placeholder="أدخل كلمة المرور" />
              <i class="fa-solid fa-eye" onclick="myFunction()" id="togglePassword"></i>
            </div>
            @error('password')
              <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>

          <!-- Submit button -->
          <button id="loginButton" type="submit" class="next">
            تسجيل الدخول
          </button>
        </form>
      </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.22/sweetalert2.min.js"
      integrity="sha512-pQdCIGAWAwzEHgw7boqX3wRNUqyaj7ta8qHsZ2yZtJofKqwSsh98Q+NJn96MAYCMcMnoZhdUo771JzaJCbrJMg=="
      crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ route('liveplatform.assets', 'Dashboard/js/main.js') }}"></script>
  </body>

</html>
