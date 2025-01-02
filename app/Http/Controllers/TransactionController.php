<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\pdf as PDF;

class TransactionController extends Controller
{
    public function generateReport()
    {
        // Mengambil semua transaksi dari database
        $transactions = Transaction::all();
    
        // Data untuk view PDF
        $data = [
            'title' => 'Laporan Transaksi',
            'transactions' => $transactions,  // Mengirim data transaksi ke view
        ];
    
        // Generate PDF menggunakan view
        $pdf = PDF::loadView('transactions', $data);
    
        // Download PDF
        return $pdf->download('laporan_transaksi.pdf');
    }
    
}
