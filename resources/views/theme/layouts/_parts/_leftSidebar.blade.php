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

                @if (auth()->user()->hasAnyRole('Admin', 'SuperAdmin'))
                    <li class="menu-title" key="t-apps">Sameleon COMMERCIAL</li>
                    {{-- <li>
                        <a href="{{ route('commercial:estimates.index') }}" class="waves-effect">
                            <i class="bx bx-file-blank"></i>
                            <span  key="t-estimates-devis" class="badge rounded-pill bg-warning float-end">{{ $estimates_not_send }}</span>
                                
                            {{ __('navbar.estimates') }}
                        </a>
                    </li> --}}
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bx-food-menu"></i>
                            <span key="t-catalog">{{ __('Catalog') }}</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li>
                                <a href="{{ route('commercial:catalog.categories') }}" key="t-categories-list">
                                    <i class="bx bx-play"></i>
                                    Catégories
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('commercial:catalog.brands') }}" key="t-brands-list">
                                    <i class="bx bx-play"></i>
                                    Marques
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('commercial:catalog.products') }}" key="t-products-list">
                                    <i class="bx bx-play"></i>
                                    Produits
                                </a>
                            </li>
                            {{--<li>
                                <a href="{{ route('commercial:catalog.services') }}" key="t-services-list">
                                    <i class="bx bx-play"></i>
                                    Services
                                </a>
                            </li>--}}

                        </ul>
                    </li>
                    <li>
                        <a href="{{ route('commercial:estimates.index') }}" class="waves-effect">

                            <i class="bx bx-file-blank"></i>
                            <span key="t-estimates">{{ __('navbar.estimates') }}</span>
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
                                <a href="{{ route('commercial:invoices.index.avoir') }}" key="t-invoices-avoir-list">
                                    <i class="bx bx-play"></i>
                                    Avoirs
                                </a>
                            </li>

                        </ul>
                    </li>

                    <li>
                        <a href="{{ route('commercial:bills.index') }}" class="waves-effect">

                            <i class="bx bx-money"></i>
                            <span key="t-payments">Règlements</span>
                        </a>

                    </li>

                    <li>
                        <a href="{{ route('commercial:bcommandes.index') }}" class="waves-effect">

                            <i class="bx bx-file"></i>
                            <span key="t-bc">{{ __('navbar.bc') }}</span>
                        </a>

                    </li>

                    <li>
                        <a href="{{ route('commercial:brouter.index') }}" class="waves-effect">

                            <i class="bx bx-file"></i>
                            <span key="t-bc">Bon de router</span>
                        </a>

                    </li>

                    <li>
                        <a href="{{ route('commercial:providers.index') }}" class="waves-effect">

                            <i class="bx bx-user"></i>
                            <span key="t-providers">Fournisseurs</span>
                        </a>

                    </li>
                    <li>
                        <a href="{{ route('commercial:clients.index') }}" class="waves-effect">

                            <i class="bx bxs-user-detail"></i>
                            <span key="t-clients">Clients</span>
                        </a>

                    </li>
                @endif

                <li class="menu-title" key="t-pages">Utilisateurs</li>

                <li>
                    <a href="{{ route('admin:admins') }}" class="waves-effect">

                        <i class="bx bx-user-circle"></i>
                        <span key="t-authentication">Utilisateurs</span>
                    </a>

                </li>

                <li class="menu-title" key="t-components">{{ __('navbar.advanced') }}</li>
                <li>
                    <a href="javascript: void(0);" class="waves-effect">
                        <i class="bx bx-check-shield"></i>
                        <span key="t-permissions">Permissions</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('admin:permissions-roles.index') }}"
                                key="t-login">{{ __('navbar.roles') }}</a></li>
                        <li><a href="{{ route('admin:permissions-roles.permissions') }}"
                                key="t-login">{{ __('navbar.permissions') }}</a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="{{ route('admin:admins') }}" class="waves-effect">
                        <i class="bx bx-cog"></i>
                        <span key="t-settings">Settings</span>
                    </a>

                </li>
            </ul>
        </div>
    </div>
</div>
