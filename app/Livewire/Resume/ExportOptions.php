<?php

namespace App\Livewire\Resume;

use Livewire\Component;
use App\Models\Resume; // Pastikan untuk mengimpor model Resume

class ExportOptions extends Component
{
    public Resume $resume; // Properti untuk menerima model Resume

    // Metode mount akan dipanggil saat komponen diinisialisasi
    // Ini penting untuk menerima instance Resume dari parent component atau view
    public function mount(Resume $resume)
    {
        $this->resume = $resume;
    }

    // Metode render akan mengirimkan data yang dibutuhkan ke view
    public function render()
    {
        return view('livewire.resume.export-options', [
            // Anda bisa melewatkan data tambahan ke view jika diperlukan
            // 'someOtherData' => $this->someOtherData,
        ]);
    }

    // Anda bisa menambahkan metode lain di sini jika ingin
    // menambahkan fitur seperti:
    // public function exportJsonLivewire() { /* ... logika ... */ }
    // public function exportPdfLivewire() { /* ... logika ... */ }
    // Tetapi untuk tautan unduhan langsung, ini tidak diperlukan.
}