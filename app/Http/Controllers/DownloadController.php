<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Download;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    public function download(Order $order)
    {
        // Pastikan order milik user ini
        abort_if($order->buyer_id !== auth()->id(), 403);

        // Pastikan sudah lunas
        abort_if($order->status !== 'lunas', 403, 'Pembayaran belum dikonfirmasi.');

        // Catat log download
        Download::create([
            'order_id'      => $order->id,
            'buyer_id'      => auth()->id(),
            'ebook_id'      => $order->ebook_id,
            'downloaded_at' => now(),
        ]);

        // Download file dari private storage
        $filePath = $order->ebook->file;

        abort_if(!Storage::disk('private')->exists($filePath), 404, 'File tidak ditemukan.');

        return Storage::disk('private')->download(
            $filePath,
            $order->ebook->title . '.pdf'
        );
    }
}