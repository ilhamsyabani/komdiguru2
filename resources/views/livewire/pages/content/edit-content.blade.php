<div>
    @include('livewire.utilities.alerts')
    <x-slot name="header">
        <div class="section-header">
            <h1>Content Management</h1>
        </div>
    </x-slot>

    <div class="card">
        <div class="card-header">
            <h4>Edit Content</h4>
        </div>
        <div class="card-body">
            <!-- Title -->
            <x-auth-validation-errors class="mb-4" :errors="$errors" />

            <div class="form-group">
                <x-label for="title" :value="__('Judul Konten')" />
                <x-input id="title" type="text" name="title" :value="old('title')" wire:model='title' />
            </div>
            <div class="mb-4">
                <x-label for="content" :value="__('Isi Konten')" />
                <textarea id="content" name="content" class="form-control" wire:model="content">{{ old('content') }}</textarea>
            </div>
            
            <x-button type='button' wire:click='updateContent'>
                {{ __('Perbarui') }}
            </x-button>
        </div>
    </div>
</div>
