 <!-- Start - Nav Header -->
 <div class="nav-header">
     <a href="{{ route('dashboard') }}" class="brand-logo" aria-label="Brand Logo">
         <div class="d-flex">
             <img width="26" height="28"src="{{ asset('uploads/setting/admin/' . $setting->admin_logo) }}"
                 alt="">
             <p class="brand-title main-title">Super Admin</p>
         </div>

     </a>
     <div class="nav-control">
         <div class="hamburger">
             <span class="line"></span>
             <span class="line"></span>
         </div>
     </div>
 </div>
 <!-- End - Nav Header -->

 <!-- Start - Header -->
 <div class="header">
     <div class="header-content">
         <nav class="navbar navbar-expand">
             <div class="collapse navbar-collapse justify-content-between">
                 <div class="header-left">
                     <h1 class="main-title">Admin Dashboard</h1>
                 </div>
                 <ul class="navbar-nav header-right">
                     <li>
                         <button id="themeToggle"
                             class="btn btn-sm 
                                    {{ session('theme') === 'dark' ? 'btn-dark text-white' : 'btn-light text-dark' }}">

                             {{ session('theme') === 'dark' ? '☀️ Light' : '🌙 Dark' }}
                         </button>
                     </li>

                     <li class="nav-item dropdown header-profile-dropdown">
                         <a class="nav-link" href="javascript:void(0);" role="button" data-bs-toggle="dropdown"
                             aria-expanded="false">
                             <div class="profile-head">
                                 <div class="profile-media">
                                     <img src="{{ Auth::user()->image ? asset('uploads/profile/' . Auth::user()->image) : asset('backend/app-assets/images/default-user.png') }}"
                                         class="img-fluid  rounded-circle border border-4 border-white"
                                         alt="Profile Image">
                                 </div>
                             </div>
                         </a>
                         <ul class="dropdown-menu dropdown-menu-end">
                             <li>
                                 <div class="py-2 d-flex px-3">
                                     <img src="{{ Auth::user()->image ? asset('uploads/profile/' . Auth::user()->image) : asset('backend/app-assets/images/default-user.png') }}"
                                         class="avatar avatar-sm rounded-circle" alt="Profile Image">
                                     <div class="ms-2">
                                         <h6 class="mb-0">{{ Auth::user()->name }}</h6>
                                         <small>{{ Auth::user()->username }}</small>
                                     </div>
                                 </div>
                             </li>
                             <li>
                                 <hr class="dropdown-divider">
                             </li>
                             <li>
                                 <a class="dropdown-item" href="{{ route('profile') }}">
                                     <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                         <path fill-rule="evenodd" clip-rule="evenodd"
                                             d="M11.9848 15.3462C8.11714 15.3462 4.81429 15.931 4.81429 18.2729C4.81429 20.6148 8.09619 21.2205 11.9848 21.2205C15.8524 21.2205 19.1543 20.6348 19.1543 18.2938C19.1543 15.9529 15.8733 15.3462 11.9848 15.3462Z"
                                             stroke="var(--bs-primary)" stroke-width="1.5" stroke-linecap="round"
                                             stroke-linejoin="round" />
                                         <path fill-rule="evenodd" clip-rule="evenodd"
                                             d="M11.9848 12.0059C14.5229 12.0059 16.58 9.94779 16.58 7.40969C16.58 4.8716 14.5229 2.81445 11.9848 2.81445C9.44667 2.81445 7.38857 4.8716 7.38857 7.40969C7.38 9.93922 9.42381 11.9973 11.9524 12.0059H11.9848Z"
                                             stroke="var(--bs-primary)" stroke-width="1.42857" stroke-linecap="round"
                                             stroke-linejoin="round" />
                                     </svg>
                                     <span class="ms-2">Profile</span>
                                 </a>
                             </li>

                             <li>
                                 <hr class="dropdown-divider">
                             </li>
                             <li>
                                 <form method="POST" action="{{ route('logout') }}">
                                     @csrf
                                     <button type="submit" class="dropdown-item">

                                         <!-- Logout icon -->
                                         <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                             viewBox="0 0 24 24" fill="none" stroke="var(--bs-danger)"
                                             stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                             <path stroke="var(--bs-danger)"
                                                 d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                             <polyline stroke="var(--bs-danger)" points="16 17 21 12 16 7"></polyline>
                                             <line x1="21" y1="12" x2="9" y2="12">
                                             </line>
                                         </svg>

                                         <!-- Logout text -->
                                         <span class="ms-2 text-danger">Logout</span>
                                     </button>
                                 </form>
                             </li>

                         </ul>
                     </li>
                 </ul>
             </div>
         </nav>
     </div>
 </div>
 <!-- End - Header -->
