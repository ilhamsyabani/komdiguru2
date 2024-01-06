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
            <section class="section">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">Results of your test</div>

                            <div class="card-body">
                                <p class="">Total points: {{ $result->total_points }} points</p>
                                @foreach ($result->categoryResults as $category)
                                    <h4>Kategori Soal: {{ $category->category->name }}</h4>
                                    <table class="table table-bordered mb-4 mt-4">
                                        <thead>
                                            <tr>
                                                <th>Question Text</th>
                                                <th>Points</th>
                                                <th style="text-align: center">Nilai</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $rowCount = count($category->questionResult);
                                            @endphp

                                            @foreach ($category->questionResult as $question)
                                                <tr>
                                                    <td>{{ $question->question->question_text }}</td>
                                                    <td>{{ $question->points }}</td>
                                                    @if ($loop->first)
                                                        <td rowspan="{{ $rowCount + 1 }}" style="text-align: center;">
                                                            <p style="font-size:100px">{{ $category->range->score }}</p>
                                                            <p>{{ $category->range->feedback }}</p>
                                                        </td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td>Jumlah</td>
                                                <td>{{ $category->total_points }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <hr>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-guest-layout>
