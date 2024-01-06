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
            <!-- Name -->
            <x-auth-validation-errors class="mb-4" :errors="$errors" />

            <div class="row">
                <div class="form-group col-span-6 m-4">
                    <x-label for="filling_limit" :value="__('Batas Pengisian')" />
                    <x-input id="filling_limit" type="text" name="filling_limit" :value="old('filling_limit')" wire:model='filling_limit' />
                </div>
            
                <div class="form-group col-span-6 m-4">
                    <x-label for="alowed_time" :value="__('Rentang Waktu Pengisian')" />
                    <x-input id="alowed_time" type="text" name="alowed_time" :value="old('alowed_time')" wire:model='alowed_time' />
                </div>
            </div>
            
            <x-input id="status" type="hidden" name="status" :value="old('status') ? true : old('status')" wire:model='status' />

            <x-button type='submit' wire:click='editRule'>
                {{ __('Perbarui') }}
            </x-button>
        </div>
    </div>
</div>
