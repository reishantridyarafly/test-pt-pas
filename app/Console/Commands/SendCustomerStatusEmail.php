<?php

namespace App\Console\Commands;

use App\Mail\NotificationStatusMail;
use App\Models\Customer;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendCustomerStatusEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:customer-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mengirim email status customer setiap 1 jam';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $customers = Customer::all();

        foreach ($customers as $customer) {
            if ($customer->status == 'LOYAL CUSTOMER') {
                $details = [
                    'title' => 'Halo, ' . $customer->name,
                    'message' => 'Sahabat setia toko kami.' . PHP_EOL .
                        'Rasakan terus manfaat dan potongan harga saat berbelanja di toko kami.' . PHP_EOL .
                        'Husus buat kamu gunakan kode promo "MAKINUNTUNG" untuk mendapatkan diskon 20%.'
                ];
                $subjectText = 'Selamat! Anda sekarang Loyal Customer';
            } else {
                $details = [
                    'title' => 'Halo, ' . $customer->name,
                    'message' => 'Selamat datang di toko kami.' . PHP_EOL .
                        'Temukan berbagai penawaran menarik dengan dengan banyak potongan harga.' . PHP_EOL .
                        'Husus buat kamu gunakan kode promo "UNTUNGTERUS" untuk mendapatkan potongan 10%.'
                ];
                $subjectText = 'Halo, Selamat datang di toko kami';
            }

            Mail::to($customer->email)->send(new NotificationStatusMail($details, $subjectText));
        }

        $this->info('Email status berhasil dikirim ke semua customer.');
    }
}
