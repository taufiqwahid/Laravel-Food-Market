<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Notification;

class MidtransController extends Controller
{

    public function callback(Request $request)
    {
        // Set konfigurasi midtrans
        Config::$serverKey = config('service.midtrans.serverKey');
        Config::$isProduction = config('service.midtrans.isProduction');
        Config::$isSanitized = config('service.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');

        // buat instance midtrans notification
        $notification = new Notification();

        // assign ke variable untuk memudahkan coding
        $status = $notification->transaction_status;
        $type = $notification->payment_type;
        $fraud = $notification->fraud_status;
        $order_id = $notification->order_id;

        // cari transaksi berdasarkan ID
        $transaction = Transaction::findOrFail($order_id);

        // handle notifikasi stataus midtrans
        if ($status == 'capture') {
            if ($type == 'credit_card') {
                if ($fraud == 'challenge') {
                    $transaction->status = 'PENDING';
                } else {
                    $transaction->status = 'SUCCESS';
                }
            }
        } elseif ($status == 'setlement') {
            $transaction->status = 'SUCCESS';
        } elseif ($status == 'pending') {
            $transaction->status = 'PENDING';
        } elseif ($status == 'deny') {
            $transaction->status = 'CANCELLED';
        } elseif ($status == 'expire') {
            $transaction->status = 'CANCELLED';
        } elseif ($status == 'cancel') {
            $transaction->status = 'CANCELLED';
        }

        // simpan transaksi
        $transaction->save();
    }
}
