<aside class="main-sidebar sidebar-dark-primary elevation-4" style="height: 100vh">

    <!-- System title and logo -->
    <a href="{{ route('dashboard') }}" class="brand-link">
        <img src="{{ asset('public/images/pricon_logo2.png') }}" alt="OITL" class="brand-image img-circle elevation-3"
            style="opacity: .8">

        <span class="brand-text font-weight-light font-size">
            <h5>OHS Work Permit</h5>
        </span>
    </a> <!-- System title and logo -->

    <!-- Sidebar -->
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <li class="nav-item has-treeview">
                    <a href="{{ url('../RapidX') }}" class="nav-link">
                        <i class="nav-icon fas fa-arrow-left"></i>
                        <p>Return to RapidX</p>
                    </a>
                </li>

                <li class="nav-item has-treeview">
                    <a href="{{ route('dashboard') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-header font-weight-bold">Management</li>
                <li class="nav-item has-treeview">
                    <a href="{{ route('contractors_management') }}" class="nav-link">
                        {{-- <i class="nav-icon fas fa-user-cog"></i> --}}
                        {{-- <i class="nav-icon fas fa-id-card-alt"></i> --}}
                        <i class="nav-icon fas fa-hard-hat"></i>
                        <p>Contractors Management</p>
                    </a>
                </li>

                <li class="nav-item has-treeview">
                    <a href="{{ route('work_permit_management') }}" class="nav-link">
                        {{-- <i class="nav-icon fas fa-tasks"></i> --}}
                        {{-- <i class="nav-icon far fa-calendar-check"></i> --}}
                        <i class="nav-icon fas fa-clipboard-list"></i>
                        <p>Work Permit</p>
                    </a>
                </li>


                <li class="nav-item has-treeview">
                    <a href="{{ route('user_approver_management') }}" class="nav-link">
                        {{-- <i class="nav-icon fas fa-tasks"></i> --}}
                        {{-- <i class="nav-icon far fa-calendar-check"></i> --}}
                        <i class="nav-icon fas fa-clipboard-list"></i>
                        <p>User Approver Management</p>
                    </a>
                </li>
                <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

            </ul>
        </nav>
    </div><!-- Sidebar -->
</aside>
