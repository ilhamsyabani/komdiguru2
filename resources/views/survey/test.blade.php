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

        <!-- Main Content -->
        <div class="main-content">
            <section class="section">
                <div class="section-header">
                    <h1>Pengisian Data</h1>
                </div>

                <div class="section-body">
                    <form method="POST" action="{{ route('client.test.store') }}">
                        @csrf
                        <ul class="nav nav-pills" id="myTab" role="tablist">
                            @foreach ($categories as $category)
                                <li class="nav-item ml-2">
                                    <a class="nav-link @if ($loop->first) active show @endif"
                                        id="{{ Str::slug($category->name) }}-tab" data-toggle="tab"
                                        href="#{{ Str::slug($category->name) }}" role="tab"
                                        aria-controls="{{ Str::slug($category->name) }}"
                                        aria-selected="{{ $loop->first ? 'true' : 'false' }}">{{ $category->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            @foreach ($categories as $category)
                                <div class="tab-pane fade @if ($loop->first) active show @endif"
                                    id="{{ Str::slug($category->name) }}" role="tabpanel"
                                    aria-labelledby="{{ Str::slug($category->name) }}-tab">
                                    <input type="hidden" name="category_id[]" value="{{ $category->id }}">
                                    @foreach ($category->questions as $question)
                                        <div class="card @if (!$loop->last) mb-3 @endif">
                                            <div class="card-header">{{ $question->question_text }}</div>
                                            <div class="card-body">
                                                <input type="hidden" name="questions[{{ $question->id }}]" value="">
                                                @foreach ($question->options as $option)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="questions[{{ $question->id }}]"
                                                        id="option-{{ $option->id }}"
                                                        value="{{ $option->id }}"@if (old("questions.$question->id") == $option->id) checked @endif>
                                                    <label class="form-check-label" for="option-{{ $option->id }}">
                                                        {{ $option->option_text }}
                                                    </label>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                        <div class="form-group row mb-0 mt-3">
                            <div class="col-md-6">
                                {{-- <button type="submit" class="btn btn-primary" name="aksi" value="simpan">
                                    Simpan
                                </button> --}}
                                <button type="submit" class="btn btn-primary" name="aksi" value="kirim">
                                    Kirim Hasil
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
        <footer class="main-footer">
            <div class="footer-left">
                <small class="text-muted">Laravel Breeze + Stisla by Fahmi Jabbar ©2022</small>
            </div>
        </footer>
    </div>
</x-guest-layout>
