<x-app-layout>
    <section class="section">
        <div class="section-header">
            <h1>Pengisian Data</h1>
        </div>

        <div class="section-body">
            <form method="POST" action="{{ route('test.update', $result) }}">
                @method('PUT')
                @csrf
                <ul class="nav nav-pills" id="myTab" role="tablist">
                    @foreach ($categories as $category)
                        <li class="nav-item ml-2">
                            <a class="nav-link{{ $loop->first ? ' active show' : '' }}"
                                id="{{ Str::slug($category->name) }}-tab" data-toggle="tab"
                                href="#{{ Str::slug($category->name) }}" role="tab"
                                aria-controls="{{ Str::slug($category->name) }}"
                                aria-selected="{{ $loop->first ? 'true' : 'false' }}">{{ $category->name }}</a>
                        </li>
                    @endforeach
                </ul>
                <div class="tab-content" id="myTabContent">
                    @foreach ($categories as $category)
                        <div class="tab-pane fade{{ $loop->first ? ' active show' : '' }}"
                            id="{{ Str::slug($category->name) }}" role="tabpanel"
                            aria-labelledby="{{ Str::slug($category->name) }}-tab">
                            <input type="hidden" name="category_id[]" value="{{ $category->id }}">
                            @foreach ($category->questions as $question)
                                <div class="card{{ !$loop->last ? ' mb-3' : '' }}">
                                    <div class="card-header">{{ $question->question_text }}</div>
                                    <div class="card-body">
                                        <input type="hidden" name="questions[{{ $question->id }}]" value="">
                                        @php
                                            $options = $question->options->shuffle();
                                        @endphp
                                        @foreach ($question->options as $option)
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio"
                                                    name="questions[{{ $question->id }}]"
                                                    id="option-{{ $option->id }}" value="{{ $option->id }}"
                                                    {{ in_array($option->id, $resultquestion->pluck('option_id')->toArray()) ? 'checked' : '' }}>
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
                        <button type="submit" class="btn btn-secondary" name="aksi" value="simpan">
                            Simpan
                        </button>
                        <button type="submit" class="btn btn-primary" name="aksi" value="kirim">
                            Kirim Hasil
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </section>
</x-app-layout>
