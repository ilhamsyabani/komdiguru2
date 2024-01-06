<div>
    @include('livewire.utilities.alerts')
    <x-slot name="header">
        <div class="section-header">
            <h1>Category Management</h1>
        </div>
    </x-slot>

    <div class="card">
        <div class="card-header">
            <h4>Category Data</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col" width="5%">#</th>
                            <th scope="col">Nama Kategori</th>
                            <th scope="col" width="5%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <th>{{ ($categories->currentpage() - 1) * $categories->perpage() + $loop->index + 1 }}</th>
                                <td>{{ $category->name }}</td>
                                <td>
                                    <div class="d-flex">
                                        <button class="btn btn-sm btn-link" data-toggle="tooltip" data-placement="top"
                                            title="Delete" wire:click='deleteCategory({{ $category->id }})'>
                                            <i class="fas fa-trash text-danger"></i>
                                        </button>
                                        <button class="btn btn-sm btn-link" data-toggle="tooltip" data-placement="top"
                                        title="Edit" wire:click='editCategory({{ $category->id }})'>
                                        <i class="fas fa-edit text-danger"></i>
                                    </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $categories->links() }}
            </div>
        </div>
    </div>
</div>

<script>
    $().tooltip();
</script>
