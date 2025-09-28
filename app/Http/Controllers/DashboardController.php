<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use Telegram\Bot\Api;

class DashboardController extends Controller
{
    public function index()
    {
        $countUser = User::count();
        $countCustomer = Customer::count();
        $countLoyalCustomer = Customer::where('status', 'LOYAL CUSTOMER')->count();
        $countNewCustomer = Customer::where('status', 'NEW CUSTOMER')->count();

        return view('backend.dashboard.index', compact('countUser', 'countCustomer', 'countLoyalCustomer', 'countNewCustomer'));
    }

    public function sendMessage()
    {
        $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));

        $updates = $telegram->getUpdates();

        foreach ($updates as $update) {
            if (isset($update['message'])) {
                $chatId = $update['message']['chat']['id'];
                $text   = $update['message']['text'];

                if ($text === '/start') {
                    $telegram->sendMessage([
                        'chat_id' => $chatId,
                        'text'    => "🎉 Selamat datang di Coffee Shop Mene Ngopi!\n\n"
                            . "☕ Promo Spesial: Beli 1 Gratis 1 semua kopi!\n"
                            . "📅 Berlaku hanya hari ini.\n\n"
                            . "Ketik nomor HP kamu untuk menghubungkan akun. 😉"
                    ]);
                }
            }
        }

        return response()->json($updates);
    }

    public function sendWhatsapp()
    {
        $token = env('WHATSAPP_TOKEN');
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'target' => '62895617545305',
                'message' => 'Halo, ini adalah pesan test dari aplikasi kami',
            ),
            CURLOPT_HTTPHEADER => array(
                'Authorization: ' . $token
            ),
        ));

        curl_exec($curl);

        curl_close($curl);
    }
}
