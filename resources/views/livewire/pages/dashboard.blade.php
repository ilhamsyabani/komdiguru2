<div>
    <x-slot name="header">
        <div class="section-header">
            <h1>Dashboard</h1>
            {{-- <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Layout</a></div>
                <div class="breadcrumb-item">Default Layout</div>
            </div> --}}
        </div>
    </x-slot>

    {{-- <h2 class="section-title">This is Example Page</h2>
    <p class="section-lead">This page is just an example for you to create your own page.</p> --}}
    <div class="card">
        <div class="card-header">
            <h4>{{$content->title}}</h4>
        </div>
        <div class="card-body">
            <p>{{$content->content}}</p>
            This user have role
            {{ auth()->user()->hasRole('admin') == true
                ? 'Admin'
                : 'User' }}
        </div>
        <div class="card-footer">
            This is card footer
        </div>
    </div>
</div>
