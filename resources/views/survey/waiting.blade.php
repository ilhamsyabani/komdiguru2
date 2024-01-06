<x-guest-layout>
    <div class="main-wrapper container">
        <div class="navbar-bg"></div>
        <nav class="navbar navbar-expand-lg main-navbar">
            <a href="{{ route('welcome') }}" class="navbar-brand sidebar-gone-hide">{{ config('app.name') }}</a>
            <ul class="navbar-nav sidebar-gone-hide">
                <li class="nav-item active"><a href="https://docs.getstisla.com/#/en/2.2.0/overview" class="nav-link"
                        target="_blank">Documentation</a></li>
            </ul>
            @if (session('status'))
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    </div>
                </div>
            @endif
        </nav>

        <div class="main-content">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Hasil Anda telah dikirim</div>

                        <div class="card-body">
                            <p class="mt-5">Terima kasih telah mengirim hasil isian Anda. Kami akan segera
                                memprosesnya. Mohon tunggu informasi lebih lanjut.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
