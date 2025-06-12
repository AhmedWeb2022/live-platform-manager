<section class="index_cards">
  <!-- ======= Start navbar ======= -->
  <nav class="navbar">
    <div class="logo-menu">
      <div class="menu">
        <i class="fa-solid fa-angles-right"></i>
      </div>
    </div>

    {{-- <div>
      <div class="dropdown d-flex align-items-center">
        <div class="changelocal d-inline-block">
          <div class="dropdown lang">
            <a class="btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink">
              <i class="fa-solid fa-magnifying-glass"></i>
            </a>
            <input type="search" class="search-field" placeholder="بحث ..." style="display: none" />
          </div>
        </div>
        <div class="changelocal d-inline-block">
          <div class="dropdown lang">
            <a class="btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown"
              aria-expanded="false">
              <!-- lang -->
              <i class="fa-regular fa-message"></i>
            </a>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
              <li>
                <a class="dropdown-item"> الاشعارات </a>
              </li>
            </ul>
          </div>
        </div>
        <div class="changelocal d-inline-block">
          <div class="dropdown lang">
            <a class="btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown"
              aria-expanded="false">
              <!-- lang -->
              <i class="fa-regular fa-bell"></i>
            </a>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
              <li>
                <a class="dropdown-item"> الاشعارات </a>
              </li>
            </ul>
          </div>
        </div>
        <button class="dropdown-toggle profile-btn" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown"
          aria-expanded="false">
          <div class="all-pro">
            <div class="profile">

              <img src="{{ route('liveplatform.assets', 'Dahboard/photo/Ellipse .png') }}" alt="" />
            </div>
            <div class="emmil">
              <h4>mohamed nasra</h4>
              <p>mohame@gmail.com</p>
            </div>
          </div>
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
          <li>
            <a class="dropdown-item" href="#">Reports</a>
          </li>
          <li>
            <a class="dropdown-item" href="#">Setting</a>
          </li>
          <li><a class="dropdown-item" href="#">Logout</a></li>
        </ul>
      </div>
    </div> --}}
  </nav>
  @include('liveplatform::dashboard.component.__messages')
