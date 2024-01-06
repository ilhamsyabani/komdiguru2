<div>
    @include('livewire.utilities.alerts')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Test</div>

                <div class="card-body">
                    
                    <form wire:submit.prevent="addResult">
                        <div class="card-body">
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
                                        @foreach ($category->questions as $question)
                                            <div class="card @if (!$loop->last) mb-3 @endif">
                                                <div class="card-header">{{ $question->question_text }}</div>
                                                <div class="card-body">
                                                    <input type="hidden" wire:model="questions.{{ $question->id }}">
                                                    @foreach ($question->options as $option)
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                name="questions.{{ $question->id }}"
                                                                wire:model="questions.{{ $question->id }}"
                                                                id="option-{{ $option->id }}"
                                                                value="{{ $option->id }}">
                                                            <label class="form-check-label"
                                                                for="option-{{ $option->id }}">
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
                                    <button type="submit" class="btn btn-primary" name="aksi" value="simpan">
                                        Simpan
                                    </button>
                                </div>
                                <div class="col-md-6">
                                </div>
                            </div>
                        </div>
                    </form>                    
                </div>
            </div>
        </div>
    </div>
</div>
