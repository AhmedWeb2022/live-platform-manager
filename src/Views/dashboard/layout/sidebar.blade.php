<div class="d-flex sidemobile p-0">
  <!-- ======= Start Sidebar ======= -->
  <section class="sidebar open">
    <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
      <button id="closeSidebarBtn">
        <i class="fa-solid fa-xmark"></i>
      </button>
      <div class="img-log">

        <img src="{{ route('liveplatform.assets', 'Dashboard/photo/logosidbar.png') }}" alt="" />
      </div>
      <li class="nav-item">
        <a href="{{ route('admin.platform') }}" class="nav-link align-middle">
          <i class="fa-solid fa-laptop"></i>
          <span>Platforms</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('admin.live_account') }}" class="nav-link align-middle">
          <i class="fa-solid fa-users"></i>
          <span>Live Accounts</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('admin.session') }}" class="nav-link align-middle">
          <i class="fa-solid fa-circle-play"></i>
          <span>Sessions</span>
        </a>
      </li>

      <li class="nav-item">
        <a href="{{ route('admin.logout') }}" class="nav-link align-middle">
          <i class="fa-solid fa-right-from-bracket ico"></i>
          <span>Log out</span>
        </a>
      </li>
    </ul>
  </section>
