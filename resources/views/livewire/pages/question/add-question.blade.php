<div>
    @include('livewire.utilities.alerts')
    <x-slot name="header">
        <div class="section-header">
            <h1>Question Management</h1>
        </div>
    </x-slot>

    <div class="card">
        <div class="card-header">
            <h4>Add Question Data</h4>
        </div>
        <div class="card-body">
            <x-auth-validation-errors class="mb-4" :errors="$errors" />
            <div class="form-group">
                <x-label for="category_id" :value="__('Kategori Pertanyaan')" />
                <select wire:model="category_id" id="category_id" class="form-control selectric">
                    <option>Silahkan Pilih Kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <x-label for="question_text" :value="__('Pertanyaan')" />
                <x-input id="question_text" type="text" name="question_text" :value="old('question_text')"
                    wire:model='question_text' />
            </div>

            <hr>
            @for ($i = 0; $i < 5; $i++)
                <div class="form-group">
                    <x-label :for="'option_text_' . $i" :value="__('Jawaban dengan nilai ' . ($i + 1))" />
                    <x-input :id="'option_text_' . $i" type="text" :name="'option_text[' . $i . ']'" :value="old('option_text.' . $i)"
                        wire:model="option_text.{{ $i }}" />
                </div>
            @endfor
            <x-button type='submit' wire:click='addQuestion'>
                {{ __('Tambah') }}
            </x-button>
        </div>
    </div>
</div>
