<div>
    @include('livewire.utilities.alerts')
    <x-slot name="header">
        <div class="section-header">
            <h1>Instansion Management</h1>
        </div>
    </x-slot>

    <div class="card">
        <div class="card-header">
            <h4>Instansion Data</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col" width="5%">#</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Alamat</th>
                            <th scope="col">isActive</th>
                            <th scope="col" width="5%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($instansions as $instansion)
                            <tr>
                                <th>{{ ($instansions->currentPage() - 1) * $instansions->perPage() + $loop->index + 1 }}
                                </th>
                                <td>{{ $instansion->name }}</td>
                                <td>{{ $instansion->address }}</td>
                                <td>
                                    <div class="form-group">
                                        <div class="control-label">Active</div>
                                        <label class="custom-switch mt-2">
                                            <input type="checkbox" wire:click='toggleActive({{ $instansion->id }})'
                                                {{ $instansion->isActive ? 'checked' : '' }} class="custom-switch-input">
                                            <span class="custom-switch-indicator"></span>
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <button class="btn btn-sm btn-link" data-toggle="tooltip" data-placement="top"
                                            title="Delete" wire:click='deleteInstansion({{ $instansion->id }})'>
                                            <i class="fas fa-trash text-danger"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $instansions->links() }}
            </div>
        </div>
    </div>
</div>

<script>
    $().tooltip();
</script>
