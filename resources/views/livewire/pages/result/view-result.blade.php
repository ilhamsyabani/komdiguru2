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
                            <th scope="col">Pengisi survei</th>
                            <th scope="col">Total Point</th>
                            <th scope="col">Status</th>
                            <th scope="col">Tanggal Pengisian</th>
                            <th scope="col" width="5%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($results as $result)
                            <tr>
                                <th>{{ ($results->currentPage() - 1) * $results->perPage() + $loop->index + 1 }}</th>
                                <td>{{ $result->user->name }}</td>
                                <td>{{ $result->total_points }}</td>
                                <td>{{ $result->status }}</td>
                                <td>{{ $result->updated_at }}</td>
                                <td>
                                    <div class="d-flex">
                                        <button class="btn btn-sm btn-link" data-toggle="tooltip" data-placement="top"
                                        title="View" wire:click='viewResult({{ $result->id }})'>
                                        <i class="far fa-file-alt"></i>
                                        <button class="btn btn-sm btn-link" data-toggle="tooltip" data-placement="top"
                                            title="Delete" wire:click='deleteResult({{ $result->id }})'>
                                            <i class="fas fa-trash text-danger"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $results->links() }}
            </div>
        </div>
    </div>
</div>

<script>
    $().tooltip();
</script>
