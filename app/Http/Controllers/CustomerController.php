<?php

namespace App\Http\Controllers;

use App\Http\Requests\Customer\CustomerStoreRequest;
use App\Http\Requests\Customer\CustomerUpdateRequest;
use App\Mail\NotificationStatusMail;
use App\Models\Customer;
use App\Services\TelegramService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Telegram\Bot\Api;
use Yajra\DataTables\Facades\DataTables;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $customers = Customer::orderBy('user_id', 'asc')->get();
            return DataTables::of($customers)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    return '
                        <a class="btn btn-sm btn-primary me-1" href="' . route('customer.edit', $data->id) . '">
                           <span class="mdi mdi-pencil"></span> Edit
                        </a>
                        <button class="btn btn-sm btn-danger" id="btnDelete" data-id="' . $data->id . '">
                            <span class="mdi mdi-trash-can"></span> Hapus
                        </button>
                    ';
                })
                ->addColumn('status', function ($data) {
                    $badge = $data->status == 'LOYAL CUSTOMER'
                        ? '<span class="badge bg-success">LOYAL CUSTOMER</span>'
                        : '<span class="badge bg-primary">NEW CUSTOMER</span>';
                    return $badge;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        return view('backend.customer.index');
    }

    public function create()
    {
        $last = Customer::orderBy('user_id', 'desc')->value('user_id');

        $today = now()->format('dmY');
        if ($last && substr($last, 0, 8) === $today) {
            $increment = intval(substr($last, -3)) + 1;
        } else {
            $increment = 1;
        }
        $newUserId = $today . str_pad($increment, 3, '0', STR_PAD_LEFT);
        return view('backend.customer.create', compact('newUserId'));
    }

    public function store(CustomerStoreRequest $request)
    {
        try {
            $last = Customer::orderBy('user_id', 'desc')->value('user_id');

            $today = now()->format('dmY');
            if ($last && substr($last, 0, 8) === $today) {
                $increment = intval(substr($last, -3)) + 1;
            } else {
                $increment = 1;
            }
            $newUserId = $today . str_pad($increment, 3, '0', STR_PAD_LEFT);

            $customer = new Customer();
            $customer->user_id = $newUserId;
            $customer->name = $request->name;
            $customer->email = $request->email;
            $customer->phone = $request->phone;
            $customer->save();

            $details = [
                'title' => 'Halo, ' . $request->name,
                'message' => 'Selamat datang di toko kami. Temukan berbagai penawaran menarik dengan dengan banyak potongan harga
                    Husus buat kamu gunakan kode promo "UNTUNGTERUS" untuk mendapatkan potongan 10%.'
            ];
            $subjectText = 'Halo, Selamat datang di toko kami';

            Mail::to($request->email)->queue(new NotificationStatusMail($details, $subjectText));

            $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));

            $telegram->sendMessage([
                'chat_id' => env('TELEGRAM_CHAT_ID'),

                'text'    => "📋 Pendaftaran Pelanggan Baru\n\n"
                    . "🆔 ID: {$customer->user_id}\n"
                    . "👤 Nama: {$customer->name}\n"
                    . "📧 Email: {$customer->email}\n"
                    . "🎖️ Status: NEW CUSTOMER\n\n"
            ]);

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
                    'target' => $request->phone,
                    'message' => "Selamat datang di toko kami, {$request->name}.\n\n"
                        . "Temukan berbagai penawaran menarik dengan dengan banyak potongan harga.\n"
                        . "Husus buat kamu gunakan kode promo \"UNTUNGTERUS\" untuk mendapatkan potongan 10%.\n\n"
                        . "Terima kasih telah mendaftar! 🎉",
                ),
                CURLOPT_HTTPHEADER => array(
                    'Authorization: ' . $token
                ),
            ));

            curl_exec($curl);

            curl_close($curl);

            return response()->json([
                'status'  => 'success',
                'message' => 'Data berhasil disimpan.',
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error occurred, please try againrred',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function edit($id)
    {
        $customer = Customer::find($id);

        return view('backend.customer.edit', compact('customer'));
    }

    public function update(CustomerUpdateRequest $request, $id)
    {
        try {
            $customer = Customer::findOrFail($id);
            $oldStatus = $customer->status;

            $customer->name  = $request->name;
            $customer->email = $request->email;
            $customer->phone = $request->phone;
            $customer->status = $request->status;
            $customer->save();

            if ($oldStatus !== 'LOYAL CUSTOMER' && $request->status === 'LOYAL CUSTOMER') {
                $details = [
                    'title' => 'Halo, ' . $request->name,
                    'message' => 'Sahabat setia toko kami. Rasakan terus manfaat dan potongan harga saat berbelanja di toko kami. Husus buat kamu gunakan kode promo "MAKINUNTUNG" untuk mendapatkan diskon 20%.'
                ];
                $subjectText = 'Selamat! Anda sekarang Loyal Customer';

                Mail::to($request->email)->queue(new NotificationStatusMail($details, $subjectText));

                $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));

                $telegram->sendMessage([
                    'chat_id' => env('TELEGRAM_CHAT_ID'),
                    'text'    => "🔄 Status Pelanggan Diperbarui!\n\n"
                        . "🆔 ID: {$customer->user_id}\n"
                        . "👤 Nama: {$customer->name}\n"
                        . "📧 Email: {$customer->email}\n"
                        . "🎖️ Status: LOYAL CUSTOMER\n\n"
                ]);

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
                        'target' => $request->phone,
                        'message' => "Selamat! Anda sekarang Loyal Customer di toko kami, {$request->name}.\n\n"
                            . "Rasakan terus manfaat dan potongan harga saat berbelanja di toko kami. Husus buat kamu gunakan kode promo \"MAKINUNTUNG\" untuk mendapatkan diskon 20%.\n\n"
                            . "Terima kasih atas loyalitas Anda! 🎉",
                    ),
                    CURLOPT_HTTPHEADER => array(
                        'Authorization: ' . $token
                    ),
                ));

                curl_exec($curl);
                curl_close($curl);
            }

            return response()->json([
                'status'  => 'success',
                'message' => 'Data berhasil disimpan.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error occurred, please try againrred',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $customer = Customer::find($request->id);

            if ($customer) {
                $customer->delete();

                return response()->json([
                    'status' => 'success',
                    'message' => 'Data berhasil dihapus.',
                ], 201);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error occurred, please try againrred',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
