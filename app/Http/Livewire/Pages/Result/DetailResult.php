<?php

namespace App\Http\Livewire\Pages\Result;

use App\Models\Result;
use Livewire\Component;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Barryvdh\DomPDF\Facade\Pdf;

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
        //$pdf->save('path/to/your-file.pdf'); // Simpan PDF ke server
        // atau
        return $pdf->stream('your-file.pdf'); // Tampilkan PDF di browser
    }

    // Generate PDF
    public function createPDF($id) {
        // retreive all records from db
        $data = Result::find($id);
        // share data to view
        view()->share('result',$data);
        $pdf = pdf::loadView('pdf_view', $data);
        // download PDF file with download method
        return $pdf->download('pdf_file.pdf');
      }
}

