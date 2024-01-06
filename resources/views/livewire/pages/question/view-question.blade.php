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
                            <th scope="col">Kategori</th>
                            <th scope="col">Pertanyaan</th>
                            <th scope="col" width="5%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($questions as $question)
                            <tr>
                                <th>{{ ($questions->currentPage() - 1) * $questions->perPage() + $loop->index + 1 }}</th>
                                <td>{{ $question->category->name }}</td>
                                <td>{{ $question->question_text }}</td>
                                <td>
                                    <div class="d-flex">
                                        <button class="btn btn-sm btn-link" data-toggle="tooltip" data-placement="top"
                                        title="Edit" wire:click='editQuestion({{ $question->id }})'>
                                        <i class="fas fa-edit text-danger"></i>
                                        <button class="btn btn-sm btn-link" data-toggle="tooltip" data-placement="top"
                                            title="Delete" wire:click='deletequestion({{ $question->id }})'>
                                            <i class="fas fa-trash text-danger"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $questions->links() }}
            </div>
        </div>
    </div>
</div>

<script>
    $().tooltip();
</script>
