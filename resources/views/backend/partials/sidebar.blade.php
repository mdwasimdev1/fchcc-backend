  <!-- Start - Sidebar Navigation -->
  <div class="icnav">
      <div class="icnav-scroll">
          <ul class="metismenu" id="menu">
              <li class="menu-title" data-i18n="YOUR COMPANY">YOUR COMPANY</li>
              <li>
                  <a href="{{ route('dashboard') }}" aria-expanded="false">
                      <div class="menu-icon">
                          <i class="fi fi-rr-home"></i>
                      </div>
                      <span class="nav-text" data-i18n="Dashboard">Dashboard</span>
                  </a>

              </li>
              <li>
                  <a href="{{ route('category.index') }}" aria-expanded="false">
                      <div class="menu-icon">
                          <i class="fi fi-rs-employees"></i>
                      </div>
                      <span class="nav-text" data-i18n="Category">Category</span>
                  </a>
              </li>
              <li>
                  <a href="{{ route('SubCategory.index') }}" aria-expanded="false">
                      <div class="menu-icon">
                          <i class="fi fi-rs-employees"></i>
                      </div>
                      <span class="nav-text" data-i18n="Category">Sub Category</span>
                  </a>
              </li>
              <li>
                  <a href="{{ route('product.index') }}" aria-expanded="false">
                      <div class="menu-icon">
                          <i class="fi fi-rr-workflow-alt"></i>
                      </div>
                      <span class="nav-text" data-i18n="Product">Product</span>
                  </a>
              </li>
              <li>
                  <a href="{{ route('faq.index') }}" aria-expanded="false">
                      <div class="menu-icon">
                          <i class="fa-regular fa-circle-question"></i>
                      </div>
                      <span class="nav-text" data-i18n="Product">FAQ</span>
                  </a>
              </li>
              <li>
                  <a href="{{ route('dynamicpages.index') }}" aria-expanded="false">
                      <div class="menu-icon">
                          <i class="fa-regular fa-circle-question"></i>
                      </div>
                      <span class="nav-text" data-i18n="Product">Dynamic Pages</span>
                  </a>
              </li>

              <li class="menu-title" data-i18n="OUR FEATURES">SETTINGS</li>
              <li>
                  <a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
                      <div class="menu-icon">
                          <i class="fi fi-rs-comment-user"></i>
                      </div>
                      <span class="nav-text" data-i18n="System Settings">System Settings</span>
                  </a>
                  <ul aria-expanded="false">
                      <li><a href="{{ route('profile') }}" data-i18n="Profile Settings">Profile Settings</a></li>
                      <li><a href="{{ route('system.setting') }}" data-i18n="System Setting">System Setting</a></li>
                      <li><a href="{{ route('admin.setting') }}" data-i18n="Admin Setting">Admin Setting</a></li>
                      <li><a href="{{ route('admin.setting.mail') }}" data-i18n="Mail Setting">Mail Setting</a></li>
                      <li><a href="{{ route('stripe') }}" data-i18n="Stripe Setting">stripe Setting</a></li>
                  </ul>
              </li>
              @role('Super Admin')
                  <li>
                      <a class="has-arrow" href="javascript:void(0);" aria-expanded="false">
                          <div class="menu-icon">
                              <i class="fa-solid fa-shield"></i>
                          </div>
                          <span class="nav-text" data-i18n="Role Permission">Role & Permission</span>
                      </a>
                      <ul aria-expanded="false">
                          <li><a href="{{ route('role.index') }}" data-i18n="Role List">Role List</a></li>
                          <li><a href="{{ route('role.permission.index') }}" data-i18n="Role Permission">Role
                                  Permission</a></li>
                      </ul>
                  </li>
              @endrole

              <li>
                  <a href="{{ route('users.index') }}" aria-expanded="false">
                      <div class="menu-icon">
                          <i class="fa-solid fa-users"></i>
                      </div>
                      <span class="nav-text" data-i18n="User">User</span>
                  </a>
              </li>
          </ul>
      </div>

  </div>
  <!-- End - Sidebar Navigation -->
