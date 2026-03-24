  <!-- Start - Sidebar Navigation -->
  <div class="icnav">
      <div class="icnav-scroll">
          <ul class="metismenu" id="menu">
              <li class="menu-title" data-i18n="{{ __('messages.company_name') }}">{{ __('messages.company_name') }}</li>
              <li>
                  <a href="{{ route('dashboard') }}" aria-expanded="false">
                      <div class="menu-icon">
                          <i class="fi fi-rr-home"></i>
                      </div>
                      <span class="nav-text"
                          data-i18n="{{ __('messages.dashboard') }}">{{ __('messages.dashboard') }}</span>
                  </a>

              </li>
              <li>
                  <a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
                      <div class="menu-icon">
                          <i class="fa-solid fa-sliders"></i>
                      </div>
                      <span class="nav-text"
                          data-i18n="{{ __('messages.banners') }}">{{ __('messages.banners') }}</span>
                  </a>
                  <ul aria-expanded="false">
                      <li><a href="{{ route('banner.home') }}"
                              >{{ __('messages.home-banners') }}</a>
                      </li>
                      <li><a href="{{ route('banner.event') }}"
                             >{{ __('messages.event-banners') }}</a>
                      </li>
                      <li><a href="#"
                              >{{ __('messages.community-banners') }}</a>
                      </li>
                      <li><a href="{{ route('admin.setting.mail') }}"
                              >{{ __('messages.scholarship-banners') }}</a></li>
                      <li><a href="{{ route('stripe') }}"
                              >{{ __('messages.partner-banners') }}</a>
                      </li>
                        <li><a href="{{ route('stripe') }}"
                                >{{ __('messages.member-banners') }}</a>
                        </li>
                        <li><a href="{{ route('stripe') }}"
                                >{{ __('messages.discount-banners') }}</a>
                        </li>
                  </ul>
              </li>
              <li>
                  <a href="{{ route('sponsor.index') }}" aria-expanded="false">
                      <div class="menu-icon">
                          <i class="fa-solid fa-hand-holding-dollar"></i>
                      </div>
                      <span class="nav-text">{{ __('messages.sponsor') }}</span>
                  </a>
              </li>
              <li>
                  <a href="{{ route('media.index') }}" aria-expanded="false">
                      <div class="menu-icon">
                          <i class="fa-solid fa-film"></i>
                      </div>
                      <span class="nav-text">{{ __('messages.media') }}</span>
                  </a>
              </li>
              <li>
                  <a href="{{ route('partner.index') }}" aria-expanded="false">
                      <div class="menu-icon">
                          <i class="fa-solid fa-handshake"></i>
                      </div>
                      <span class="nav-text">{{ __('messages.partner') }}</span>
                  </a>
              </li>
              <li>
                  <a href="{{ route('news.index') }}" aria-expanded="false">
                      <div class="menu-icon">
                          <i class="fa-solid fa-newspaper"></i>
                      </div>
                      <span class="nav-text">{{ __('messages.news') }}</span>
                  </a>
              </li>
              {{-- <li>
                  <a href="{{ route('SubCategory.index') }}" aria-expanded="false">
                      <div class="menu-icon">
                          <i class="fi fi-rs-employees"></i>
                      </div>
                      <span class="nav-text" >{{ __('messages.sub_category') }}</span>
                  </a>
              </li> --}}
              {{-- <li>
                  <a href="{{ route('product.index') }}" aria-expanded="false">
                      <div class="menu-icon">
                          <i class="fi fi-rr-workflow-alt"></i>
                      </div>
                      <span class="nav-text" data-i18n="{{ __('messages.products') }}">{{ __('messages.products') }}</span>
                  </a>
              </li> --}}
              <li>
                  <a href="{{ route('event.create') }}" aria-expanded="false">
                      <div class="menu-icon">
                          <i class="fa-solid fa-calendar"></i>
                      </div>
                      <span class="nav-text" data-i18n="{{ __('messages.event') }}">{{ __('messages.event') }}</span>
                  </a>
              </li>
              {{-- <li>
                  <a href="{{ route('faq.index') }}" aria-expanded="false">
                      <div class="menu-icon">
                          <i class="fa-regular fa-circle-question"></i>
                      </div>
                      <span class="nav-text" data-i18n="Product">FAQ</span>
                  </a>
              </li> --}}
              {{-- <li>
                  <a href="{{ route('dynamicpages.index') }}" aria-expanded="false">
                      <div class="menu-icon">
                          <i class="fa-regular fa-circle-question"></i>
                      </div>
                      <span class="nav-text" data-i18n="Product">Dynamic Pages</span>
                  </a>
              </li> --}}

              <li class="menu-title" data-i18n="OUR FEATURES">{{ __('messages.settings') }}</li>
              <li>
                  <a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
                      <div class="menu-icon">
                          <i class="fi fi-rs-comment-user"></i>
                      </div>
                      <span class="nav-text"
                          data-i18n="{{ __('messages.system_settings') }}">{{ __('messages.system_settings') }}</span>
                  </a>
                  <ul aria-expanded="false">
                      <li><a href="{{ route('profile') }}"
                              data-i18n="{{ __('messages.profile_settings') }}">{{ __('messages.profile_settings') }}</a>
                      </li>
                      <li><a href="{{ route('system.setting') }}"
                              data-i18n="{{ __('messages.system_settings') }}">{{ __('messages.system_settings') }}</a>
                      </li>
                      <li><a href="{{ route('admin.setting') }}"
                              data-i18n="{{ __('messages.admin_setting') }}">{{ __('messages.admin_setting') }}</a>
                      </li>
                      <li><a href="{{ route('admin.setting.mail') }}"
                              data-i18n="{{ __('messages.mail_setting') }}">{{ __('messages.mail_setting') }}</a></li>
                      <li><a href="{{ route('stripe') }}"
                              data-i18n="{{ __('messages.stripe_setting') }}">{{ __('messages.stripe_setting') }}</a>
                      </li>
                  </ul>
              </li>
              @role('Super Admin')
                  <li>
                      <a class="has-arrow" href="javascript:void(0);" aria-expanded="false">
                          <div class="menu-icon">
                              <i class="fa-solid fa-shield"></i>
                          </div>
                          <span class="nav-text"
                              data-i18n="{{ __('messages.role_permissions') }}">{{ __('messages.role_permissions') }}</span>
                      </a>
                      <ul aria-expanded="false">
                          <li><a href="{{ route('role.index') }}"
                                  data-i18n="{{ __('messages.role_list') }}">{{ __('messages.role_list') }}</a></li>
                          <li><a href="{{ route('role.permission.index') }}"
                                  data-i18n="{{ __('messages.role_permissions') }}">{{ __('messages.role_permissions') }}</a>
                          </li>
                      </ul>
                  </li>
              @endrole

              <li>
                  <a href="{{ route('users.index') }}" aria-expanded="false">
                      <div class="menu-icon">
                          <i class="fa-solid fa-users"></i>
                      </div>
                      <span class="nav-text" data-i18n="{{ __('messages.user') }}">{{ __('messages.user') }}</span>
                  </a>
              </li>
          </ul>
      </div>

  </div>
  <!-- End - Sidebar Navigation -->
