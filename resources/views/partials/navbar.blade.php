<nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="/">
      {{ $title === "Home" ? "Homepage" : "Back to Home" }}
    </a>
    </button>

    <div class="navbar-nav ml-auto">
      @if (Auth::check())
          <a href="{{ route('profile') }}"
             onclick="event.preventDefault();
                      document.getElementById('profile-form').submit();"
             class="nav-link">Profile</a>
          <form id="profile-form" action="{{ route('profile') }}" method="GET" style="display: none;">
              @csrf
          </form>
          <a href="{{ route('logout') }}"
             onclick="event.preventDefault();
                      document.getElementById('logout-form').submit();"
             class="nav-link">Logout</a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
          </form>
      @endif
  </div>
  </div>
</nav>