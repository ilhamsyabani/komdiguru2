<!-- resources/views/livewire/instansion-management.blade.php -->

<div>
    @include('livewire.utilities.alerts')
    <x-slot name="header">
        <div class="section-header">
            <h1>Hasil Survei</h1>
        </div>
    </x-slot>

    <div class="card">
        <div class="card-header">
            <h4>Survei Data</h4>
        </div>
        <div class="card-body">
            <p class="">Total points: {{ $result->total_points }} points</p>
            <div class="table-responsive">
                @foreach ($result->categoryResults as $category)
                    <h6>Kategori Soal: {{ $category->category->name }}</h6>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Pertanyaan</th>
                                <th scope="col">Point</th>
                                <th scope="col" class="text-center">Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $rowCount = count($category->questionResult);
                            @endphp

                            @foreach ($category->questionResult as $question)
                                <tr>
                                    <td>{{ $question->question->question_text }}</td>
                                    <td>{{ $question->points }}</td>
                                    @if ($loop->first)
                                        <td rowspan="{{ $rowCount + 1 }}" class="text-center">
                                            <h3>{{ $category->range->score }}</h3>
                                            <br />
                                            <p>{{ $category->range->feedback }}</p>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <hr class="m-4">
                @endforeach
            </div>
            <button wire:click="printData" class="btn btn-primary">Print Data</button>
        </div>
    </div>
</div>


<script>
    document.addEventListener('livewire:load', function() {
        Livewire.on('printData', function() {
            // Add your logic for printing here
            window.print();
        });
    });
</script>
