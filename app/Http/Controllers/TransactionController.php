<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Http\JsonResponse;
use App\Enums\TransactionStatus;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::orderBy('created_at', 'desc')->get();
        return view('dashboard.transactions.index', compact('transactions'));
    }

    public function show(Transaction $transaction)
    {
        return view('dashboard.transactions.show', compact('transaction'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        // Validasi input
        $validated = $request->validate([
            'status' => ['required', 'string', function ($attribute, $value, $fail) {
                if (!TransactionStatus::tryFrom($value)) {
                    $fail('Status yang dipilih tidak valid.');
                }
            }],
        ]);

        try {
            // Gunakan DB transaction untuk memastikan konsistensi data
            DB::transaction(function () use ($transaction, $validated) {
                $transaction->status = TransactionStatus::from($validated['status']);
                $transaction->save();
            });

            // Redirect ke named route setelah update
            return redirect()->route('transactions.index')
                ->with('success', 'Status transaksi berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors('Gagal memperbarui status transaksi: ' . $e->getMessage());
        }
    }




    public function generateReport()
    {
        $transactions = Transaction::orderBy('created_at', 'desc')->get();

        $data = [
            'title' => 'Laporan Transaksi',
            'transactions' => $transactions,
        ];

        $pdf = PDF::loadView('dashboard.transactions.report', $data);
        return $pdf->download('laporan_transaksi.pdf');
    }

    public function count(): JsonResponse
    {
        try {
            $count = DB::table('transactions')->count();
            return response()->json([
                'code' => 200,
                'status' => 'success',
                'data' => $count,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }
}
