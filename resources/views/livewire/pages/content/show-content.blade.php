<div>
    @include('livewire.utilities.alerts')
    <x-slot name="header">
        <div class="section-header">
            <h1>Content Management</h1>
        </div>
    </x-slot>

    <div class="card">
        <div class="card-header">
            <h4>Content Data</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col" width="5%">#</th>
                            <th scope="col">Judul</th>
                            <th scope="col">Isi</th>
                            <th scope="col">Jenis</th>
                            <th scope="col" width="5%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($contents as $content)
                            <tr>
                                <td></td>
                                <td>{{ $content->title }}</td>
                                <td>{{ $content->content }}</td>
                                <td>{{ $content->as }}</td>
                                <td>
                                    <div class="d-flex">
                                        <button class="btn btn-sm btn-link" data-toggle="tooltip" data-placement="top"
                                            title="Edit" wire:click='editContent({{ $content->id }})'>
                                            <i class="fas fa-edit"></i>
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
