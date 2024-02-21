<div>
    @include('livewire.utilities.alerts')
    <x-slot name="header">
        <div class="section-header">
            <h1>Rule Management</h1>
        </div>
    </x-slot>

    <div class="card">
        <div class="card-header">
            <h4>Rule Data</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col" width="5%">#</th>
                            <th scope="col">Batas Pengisian</th>
                            <th scope="col">Jeda Waktu Pengisian</th>
                            <th scope="col">Status</th>
                            <th scope="col" width="5%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rules as $rule)
                            <tr>
                                <th>1</th>
                                <td>{{ $rule->filling_limit }} Kali</td>
                                <td>{{ $rule->alowed_time }} Hari</td>
                                <td><x-button wire:click="changeStatus({{ $rule->id }})">{{ $rule->status ? 'active' : 'nonactive' }}</x-button></td>
                                <td>
                                    <div class="d-flex">
                                        <button class="btn btn-sm btn-link" data-toggle="tooltip" data-placement="top"
                                            title="Edit" wire:click='editRule({{ $rule->id }})'>
                                            <i class="fas fa-edit text-danger"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<script>
    $().tooltip();
</script>

