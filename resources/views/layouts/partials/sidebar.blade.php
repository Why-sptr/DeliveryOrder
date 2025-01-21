<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
      
      <!-- Dashboard Link -->
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->

      @if(auth()->user()->hasRole('user'))
      <!-- Reservasi Section -->
      <li class="nav-item">
        <a class="nav-link collapsed {{ request()->routeIs('reservation.index', 'reservation-history.index') ? 'active' : '' }}" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-menu-button-wide"></i><span>Reservation</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-nav" class="nav-content collapse {{ request()->routeIs('reservation.index', 'reservation-history.index') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{ route('reservation.index') }}" class="{{ request()->routeIs('reservation.index') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Reservation</span>
            </a>
          </li>
          <li>
            <a href="{{ route('reservation-history.index') }}" class="{{ request()->routeIs('reservation-history.index') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>History Reservation</span>
            </a>
          </li>
        </ul>
      </li><!-- End Reservasi Nav -->
      
      <!-- Export Section -->
      <li class="nav-item">
        <a class="nav-link collapsed {{ request()->routeIs('reservation.export.all', 'reservation.export.user') ? 'active' : '' }}" data-bs-target="#exports-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-file-earmark-break"></i><span>Export</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="exports-nav" class="nav-content collapse {{ request()->routeIs('reservation.export.all', 'reservation.export.user') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
          <li>
              <a href="#" id="exportAllBtn">
                  <i class="bi bi-circle"></i><span>Export All Reservation</span>
              </a>
          </li>
          <li>
              <a href="#" id="exportUserBtn">
                  <i class="bi bi-circle"></i><span>Export My Reservation</span>
              </a>
          </li>
        </ul>
      </li><!-- End Export Nav -->
      @endif

      @if(auth()->user()->hasRole('admin'))
      <!-- Admin Section -->
      <li class="nav-item">
        <a class="nav-link collapsed {{ request()->routeIs('admin.index', 'user.index', 'id-badges.index') ? 'active' : '' }}" data-bs-target="#admins-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-journal-text"></i><span>Admin</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="admins-nav" class="nav-content collapse {{ request()->routeIs('admin.index', 'user.index', 'id-badges.index') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{ route('user.index') }}" class="{{ request()->routeIs('user.index') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>List User</span>
            </a>
          </li>
          <li>
            <a href="{{ route('admin.index') }}" class="{{ request()->routeIs('admin.index') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>List Admin</span>
            </a>
          </li>
          <li>
            <a href="{{ route('id-badges.index') }}" class="{{ request()->routeIs('id-badges.index') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>ID Badge</span>
            </a>
          </li>
        </ul>
      </li><!-- End Admin Nav -->
      @endif
    </ul>
</aside><!-- End Sidebar -->