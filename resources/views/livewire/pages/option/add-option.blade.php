<div>
    @include('livewire.utilities.alerts')
    <x-slot name="header">
        <div class="section-header">
            <h1>User Management</h1>
        </div>
    </x-slot>

    <div class="card">
        <div class="card-header">
            <h4>Add User Data</h4>
        </div>
        <div class="card-body">
            <x-auth-validation-errors class="mb-4" :errors="$errors" />
            <div class="form-group">
                <x-label for="question_id" :value="__('Kategori Pertanyaan')" />
                <select wire:model="question_id" id="question_id" class="form-control selectric">
                    <option>Silahkan Pilih Kategori</option>
                    @foreach($questions as $question)
                        <option value="{{ $question->id }}" {{ old('question_id') == $question->id ? 'selected' : '' }}>
                            {{ $question->question_text }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <x-label for="option_text" :value="__('Pilihan jawaban')" />
                <x-input id="option_text" type="text" name="option_text" :value="old('option_text')" wire:model='option_text' />
            </div>

            <x-button type='submit' wire:click='addOption'>
                {{ __('Tambah') }}
            </x-button>
        </div>
    </div>
</div>

<script>
    $().tooltip();
</script>
