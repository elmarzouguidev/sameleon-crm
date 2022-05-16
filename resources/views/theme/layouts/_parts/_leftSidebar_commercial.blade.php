<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" key="t-menu">Menu</li>

                <li>
                    <a href="{{ route('admin:home') }}" class="waves-effect">
                        <i class="bx bx-home-circle"></i>{{-- <span class="badge rounded-pill bg-info float-end">04</span> --}}
                        <span key="t-dashboards">{{ __('navbar.dashboard') }}</span>
                    </a>
                </li>

                @if(auth()->user()->hasAnyRole('Admin','SuperAdmin'))
                    <li class="menu-title" key="t-apps">{{ __('navbar.commercial') }}</li>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bx-grid-alt"></i>
                            <span key="t-factures">{{ __('navbar.commercial') }}</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li>
                                <a href="{{ route('commercial:companies.index') }}" key="t-companies-list">
                                    <i class="bx bx-building"></i>
                                    {{ __('navbar.companies') }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('commercial:estimates.index') }}" key="t-factures-devis">
                                    <i class="bx bx-file-blank"></i><span
                                        class="badge rounded-pill bg-warning float-end">{{$estimates_not_send}}</span>

                                    {{ __('navbar.estimates') }}
                                </a>
                            </li>
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="bx bx-food-menu"></i>
                                    <span key="t-factures">{{ __('navbar.invoices') }}</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li>
                                        <a href="{{ route('commercial:invoices.index') }}" key="t-invoices-list">
                                            <i class="bx bx-play"></i>
                                            {{ __('navbar.invoices') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('commercial:invoices.index.avoir') }}"
                                           key="t-invoices-avoir-list">
                                            <i class="bx bx-play"></i>
                                            Avoirs
                                        </a>
                                    </li>

                                </ul>
                            </li>
                            <li>
                                <a href="{{ route('commercial:bills.index') }}" key="t-factures-list">
                                    <i class="bx bx-money"></i>
                                    Règlements
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('commercial:bcommandes.index') }}" key="t-bc-list">
                                    <i class="bx bx-file"></i>
                                    {{ __('navbar.bc') }}
                                </a>
                            </li>
                            {{-- <li>
                                <a href="{{ route('commercial:documents.bl') }}"
                                    key="t-bl-list">{{ __('navbar.bl') }}
                                </a>
                            </li> --}}
                            <li>
                                <a href="{{ route('commercial:providers.index') }}" key="t-factures-devis">
                                    <i class="bx bx-user"></i>
                                    Fournisseurs
                                </a>
                            </li>

                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="bx bxs-user-detail"></i>
                                    <span key="t-clients">{{ __('navbar.clients') }}</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="{{ route('admin:clients.index') }}"
                                           key="t-clients-list">{{ __('navbar.clients') }}</a></li>
                                    <li><a href="{{ route('admin:clients.create') }}"
                                           key="t-create-clients">{{ __('navbar.clients_add') }}</a>
                                    </li>

                                </ul>
                            </li>
                        </ul>
                    </li>
                @endif

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-file"></i>
                        <span key="t-clients">{{ __('navbar.categories') }}</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('admin:categories.index') }}"
                               key="t-categories-list">{{ __('navbar.categories') }}</a>
                        </li>
                    </ul>
                </li>

                <li class="menu-title" key="t-pages">{{ __('navbar.authentification') }}</li>

                <li>
                    <a href="javascript: void(0);" class="waves-effect">
                        {{-- <span class="badge rounded-pill bg-success float-end" key="t-new">New</span> --}}
                        <i class="bx bx-user-circle"></i>
                        <span key="t-authentication">{{ __('navbar.authentification') }}</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('admin:admins') }}" key="t-login">{{ __('navbar.admins') }}</a></li>
                    </ul>
                </li>

                <li class="menu-title" key="t-components">{{ __('navbar.advanced') }}</li>
                <li>
                    <a href="javascript: void(0);" class="waves-effect">
                        {{-- <span class="badge rounded-pill bg-success float-end" key="t-new">New</span> --}}

                        <span key="t-authentication">{{ __('navbar.roles_permissions') }}</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('admin:permissions-roles.index') }}"
                               key="t-login">{{ __('navbar.roles') }}</a></li>
                        <li><a href="{{ route('admin:permissions-roles.permissions') }}"
                               key="t-login">{{ __('navbar.permissions') }}</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
