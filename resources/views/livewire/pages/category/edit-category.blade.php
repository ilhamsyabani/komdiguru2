<div>
    @include('livewire.utilities.alerts')
    <x-slot name="header">
        <div class="section-header">
            <h1>User Management</h1>
        </div>
    </x-slot>

    <div class="card">
        <div class="card-header">
            <h4>Edit User Data</h4>
        </div>
        <div class="card-body">
            <!-- Name -->
            <x-auth-validation-errors class="mb-4" :errors="$errors" />

            <div class="form-group">
                <x-label for="name" :value="__('Nama Kategori')" />
                <x-input id="name" type="text" name="name" :value="old('name')" wire:model='name' />
            </div>
            <hr>
            <p>Rentang Nilai</p>
            @for ($i = 0; $i < 4; $i++)
            <div class="row">
                <div class="form-group col-2">
                    <x-label for="score{{ $i }}">{{ __('Kategori Nilai') }}</x-label>
                    <x-input type="text" class="form-control" id="score{{ $i }}" placeholder="{{ __('A') }}" name="score[]" value="{{ old('score.' . $i) }}" wire:model="score.{{ $i }}" />
                </div>
                <div class="form-group col-2">
                    <x-label for="min{{ $i }}">{{ __('Nilai Minimal') }}</x-label>
                    <x-input type="number" class="form-control" id="min{{ $i }}" placeholder="{{ __('0') }}" name="min[]" value="{{ old('min.' . $i) }}" wire:model="min.{{ $i }}" />
                </div>
                <div class="form-group col-2">
                    <x-label for="max{{ $i }}">{{ __('Nilai Maksimal') }}</x-label>
                    <x-input type="number" class="form-control" id="max{{ $i }}" placeholder="{{ __('0') }}" name="max[]" value="{{ old('max.' . $i) }}" wire:model="max.{{ $i }}" />
                </div>
                <div class="form-group col-6">
                    <x-label for="feedback{{ $i }}">{{ __('Feedback') }}</x-label>
                    <x-input type="text" class="form-control" id="feedback{{ $i }}" placeholder="{{ __('Masukkan Feedback Nilai') }}" name="feedback[]" value="{{ old('feedback.' . $i) }}"  wire:model="feedback.{{ $i }}"/>
                </div>
            </div>
            @endfor

            <x-button type='submit' wire:click='editCategory'>
                {{ __('Update') }}
            </x-button>
        </div>
    </div>
</div>
