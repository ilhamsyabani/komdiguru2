@php
$links = [
    [
        'href' => 'dashboard',
        'text' => 'Dashboard',
        'is_multi' => false,
        'roles' => 'all',
    ],
    [ 
        'text' => 'Admin Panel',
        'is_multi' => true,
        'roles' => 'admin',
        'href' => [
            [
                'section_text' => 'User',
                'section_list' => [['href' => 'view-user', 'text' => 'Data User'], ['href' => 'add-user', 'text' => 'Buat User']],
            ],
            [
                'section_text' => 'Instansi',
                'section_list' => [['href' => 'view-instansion', 'text' => 'Data Instansi'], ['href' => 'add-instansion', 'text' => 'Buat Instansi']],
            ],
        ],
    ],
    [ 
        'text' => 'Survei Panel',
        'is_multi' => true,
        'roles' => 'admin',
        'href' => [
            [
                'section_text' => 'Aturan',
                'section_list' => [['href' => 'view-rule', 'text' => 'Aturan pengisian']],   
            ],
            [
                'section_text' => 'Konten',
                'section_list' => [['href' => 'content', 'text' => 'Konten Aplikasi']],   
            ],
            [
                'section_text' => 'Kategori',
                'section_list' => [['href' => 'view-category', 'text' => 'Data  Kategori'], ['href' => 'add-category', 'text' => 'Buat Kategori']],
            ],
            [
                'section_text' => 'Pertanyaan',
                'section_list' => [['href' => 'view-question', 'text' => 'Data  Pertanyaan'], ['href' => 'add-question', 'text' => 'Buat Pertanyaan']],
            ],
            [
                'section_text' => 'Hasil',
                'section_list' => [['href' => 'result', 'text' => 'Hasil']],
            ],
        ],
    ],
    [ 
        'text' => 'Tes Panel',
        'is_multi' => true,
        'roles' => 'user',
        'href' => [
            [
                'section_text' => 'Test',
                'section_list' => [['href' => 'guides', 'text' => 'Test']],
            ],
        ],
    ],
];
$navigation_links = json_decode(json_encode($links), false);
@endphp

<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('dashboard') }}">{{ config('app.name', 'Laravel') }}</a>
        </div>
        @foreach ($navigation_links as $link)
            @if ($link->roles == 'admin' &&
    auth()->user()->hasRole('admin'))
                <ul class="sidebar-menu">
                    @if (!$link->is_multi)
                        <li class="{{ Request::routeIs($link->href) ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route($link->href) }}"><i
                                    class="fas fa-fire"></i><span>{{ $link->text }}</span></a>
                        </li>
                    @else
                        <li class="menu-header">{{ $link->text }}</li>
                        @foreach ($link->href as $section)
                            @php
                                $routes = collect($section->section_list)
                                    ->map(function ($child) {
                                        return Request::routeIs($child->href);
                                    })
                                    ->toArray();
                                $is_active = in_array(true, $routes);
                            @endphp

                            <li class="dropdown {{ $is_active ? 'active' : '' }}">
                                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                                        class="fas fa-chart-bar"></i> <span>{{ $section->section_text }}</span></a>
                                <ul class="dropdown-menu">
                                    @foreach ($section->section_list as $child)
                                        <li class="{{ Request::routeIs($child->href) ? 'active' : '' }}"><a
                                                class="nav-link"
                                                href="{{ route($child->href) }}">{{ $child->text }}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                        @endforeach
                    @endif
                </ul>
            @elseif ($link->roles == 'all' || $link->roles == 'user')
                <ul class="sidebar-menu">
                    @if (!$link->is_multi)
                        <li class="{{ Request::routeIs($link->href) ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route($link->href) }}"><i
                                    class="fas fa-fire"></i><span>{{ $link->text }}</span></a>
                        </li>
                    @else
                        <li class="menu-header">{{ $link->text }}</li>
                        @foreach ($link->href as $section)
                            @php
                                $routes = collect($section->section_list)
                                    ->map(function ($child) {
                                        return Request::routeIs($child->href);
                                    })
                                    ->toArray();
                                $is_active = in_array(true, $routes);
                            @endphp

                            <li class="dropdown {{ $is_active ? 'active' : '' }}">
                                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                                        class="fas fa-chart-bar"></i> <span>{{ $section->section_text }}</span></a>
                                <ul class="dropdown-menu">
                                    @foreach ($section->section_list as $child)
                                        <li class="{{ Request::routeIs($child->href) ? 'active' : '' }}"><a
                                                class="nav-link"
                                                href="{{ route($child->href) }}">{{ $child->text }}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                        @endforeach
                    @endif
                </ul>
            @endif
        @endforeach
    </aside>
</div>
