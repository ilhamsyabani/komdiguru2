<x-app-layout>
    <!-- Main Content -->
    <section class="section">
        <div class="section-header flex content-between justify-between">
            <div class="mr-4">
                <h4>Test</h4>
            </div>
            <div>
                <h4 id="timer">00:00:00</h4>
            </div>
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
                                        {{-- Mengacak opsi --}}
                                        @php
                                            $options = $question->options->shuffle();
                                        @endphp
                                        @foreach ($options as $option)
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio"
                                                    name="questions[{{ $question->id }}]"
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
                            Kirim Semua Hasil
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <script>
        function startTimer(display) {
            var timer = 0, hours, minutes, seconds;
            setInterval(function () {
                hours = parseInt(timer / 3600, 10);
                minutes = parseInt((timer % 3600) / 60, 10);
                seconds = parseInt(timer % 60, 10);
    
                hours = hours < 10 ? "0" + hours : hours;
                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;
    
                display.textContent = hours + ":" + minutes + ":" + seconds;
    
                timer++;
            }, 1000);
        }
    
        window.onload = function () {
            var display = document.querySelector('#timer');
            startTimer(display);
        };
    </script>
    
</x-app-layout>
