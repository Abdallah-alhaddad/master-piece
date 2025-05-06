<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <script src="/assets/js/plugin/webfont/webfont.min.js"></script>
        <script>
          WebFont.load({
            google: { families: ["Public Sans:300,400,500,600,700"] },
            custom: {
              families: [
                "Font Awesome 5 Solid",
                "Font Awesome 5 Regular",
                "Font Awesome 5 Brands",
                "simple-line-icons",
              ],
              urls: ["/assets/css/fonts.min.css"],
            },
            active: function () {
              sessionStorage.fonts = true;
            },
          });
        </script>

        <!-- CSS Files -->
        <link rel="stylesheet" href="/assets/css/bootstrap.min.css" />
        <link rel="stylesheet" href="/assets/css/plugins.min.css" />
        <link rel="stylesheet" href="/assets/css/kaiadmin.min.css" />
        <link rel="stylesheet" href="/assets/css/dashboard.css" />

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />


    </head>

    <body>
        <div class="wrapper">
          <!-- Sidebar -->
          <div class="sidebar" data-background-color="dark">
            <div class="sidebar-logo">
              <!-- Logo Header -->
              <div class="logo-header" data-background-color="light">
                <a href="" class="logo">
                  <img
                    src="/images/admin.png"
                    alt="navbar brand"
                    class="navbar-brand"
                    width="100"
                  />
                </a>
                <div class="nav-toggle">
                  <button class="btn btn-toggle toggle-sidebar">
                    <i class="gg-menu-right"></i>
                  </button>
                </div>
              </div>
              <!-- End Logo Header -->
            </div>
            <div class="sidebar-wrapper scrollbar scrollbar-inner">
              <div class="sidebar-content">
                <ul class="nav nav-secondary">
                  <li class="nav-item">
                    <a href="{{ route('admin.chart') }}">
                      <i class="fa-solid fa-chart-simple"></i>
                      <p>Dashboard</p>
                    </a>
                  </li>
                  
                    @if(Auth::guard('admin')->user()->role === 'super_admin')
                    <li class="nav-item">
                      <a href="{{ route('admins.index') }}">
                      <i class="fa-solid fa-user-tie"></i>
                      <p>Admins</p>
                      </a>
                    </li>
                    @endif
                  <li class="nav-item">
                    <a href="{{ route('users.index') }}">
                      <i class="fa-solid fa-user"></i>
                      <p>Users</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('doctors.index') }}">
                      <i class="fa-solid fa-user-doctor"></i>
                      <p>Doctors</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('specializations.index') }}">
                      <i class="fa-solid fa-stethoscope"></i>
                      <p>Specializations</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('subscriptions.index') }}">
                      <i class="fa-solid fa-dollar-sign"></i>
                      <p>Subscriptions</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('appointments.index') }}">
                      <i class="fa-solid fa-calendar-check"></i>
                      <p>Appointment</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('patients.index') }}">
                      <i class="fa-solid fa-hospital-user"></i>
                      <p>Patient</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('admin.logout') }}">
                      <i class="fa-solid fa-right-from-bracket"></i>
                      <p>Logout</p>
                    </a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <!-- End Sidebar -->

          <div class="main-panel">
            <!-- Dark Top Bar -->
            <nav class="navbar navbar-header navbar-expand-lg p-10 shadow " data-background-color="light" style="height: 60px">
              <div class="container-fluid">
                <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                  <li class="nav-item dropdown hidden-caret">
                    <a class="nav-link dropdown-toggle" href="#" id="messageDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      <i class="fa fa-envelope"></i>
                      <span class="notification">3</span>
                    </a>
                  </li>
                  <li class="nav-item dropdown hidden-caret">
                    <a class="nav-link dropdown-toggle" href="#" id="notifDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      <i class="fa fa-bell"></i>
                      <span class="notification">4</span>
                    </a>
                  </li>
                  <li class="nav-item dropdown hidden-caret">
                    <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#" aria-expanded="false">
                      <div class="avatar-sm">
                        <img src="/assets/img/profile.jpg" alt="..." class="avatar-img rounded-circle">
                      </div>
                    </a>
                    <ul class="dropdown-menu dropdown-user animated fadeIn">
                      <li>
                        <div class="user-box">
                          <div class="avatar-lg">
                            <img src="/assets/img/profile.jpg" alt="image profile" class="avatar-img rounded">
                          </div>
                          <div class="u-text">
                            <h4>John Doe</h4>
                            <p class="text-muted">john@example.com</p>
                          </div>
                        </div>
                      </li>
                      <li>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">My Profile</a>
                        <a class="dropdown-item" href="#">Account Settings</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Logout</a>
                      </li>
                    </ul>
                  </li>
                </ul>
              </div>
            </nav>
            <!-- End Dark Top Bar -->

            <div class="container mt-0">
              <div class="page-inner">
                <div class="page-header">
                  <h1 class="page-title">@yield('header')</h1>
                </div>
                <div class="content">
                    @yield('content')
                </div>
              </div>
            </div>


          </div>
        </div>

        <!-- Core JS Files -->
        <script src="/assets/js/core/jquery-3.7.1.min.js"></script>
        <script src="/assets/js/core/popper.min.js"></script>
        <script src="/assets/js/core/bootstrap.min.js"></script>
        <script src="/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
        <script src="/assets/js/kaiadmin.min.js"></script>
    </body>
</html>
