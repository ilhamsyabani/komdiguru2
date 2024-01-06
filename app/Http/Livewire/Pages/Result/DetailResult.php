<?php

namespace App\Http\Livewire\Pages\Result;

use App\Models\Result;
use Livewire\Component;
use Barryvdh\Snappy\Facades\SnappyPdf;

class DetailResult extends Component
{
    public $result;

    public function mount($result)
    {
        $this->result = Result::find($result);
    }

    public function render()
    {
        return view('livewire.pages.result.detail-result', ['result' => $this->result]);
    }

    public function printData()
    {
        $pdf = SnappyPdf::loadView('livewire.pages.result.detail-result', ['result' => $this->result]);
        $pdf->setPaper('A4');

        // Simpan atau tampilkan file PDF
        $pdf->save('path/to/your-file.pdf'); // Simpan PDF ke server
        // atau
        return $pdf->stream('your-file.pdf'); // Tampilkan PDF di browser
    }
}

