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

            <div class="form-group">
                <x-label for="name" :value="__('Nama Isntansi')" />

                <x-input id="name" type="text" name="name" :value="old('name')" wire:model='name' />
            </div>
            
            <div class="form-group">
                <x-label for="alamat" :value="__('Alamat')" />

                <x-input id="address" type="text" name="address" :value="old('address')" wire:model='address' />
            </div>

            <x-input id="status" type="hidden" name="status" :value="old('status')" wire:model="status" value="Active" />
            <x-button type='submit' wire:click='addInstansion'>
                {{ __('Tambah') }}
            </x-button>
        </div>
    </div>
</div>

