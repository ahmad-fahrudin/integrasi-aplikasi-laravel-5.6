<?php

namespace App\Http\Controllers\Wms;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PurcahseController extends Controller
{
    public function allPurchase(Request $request)
    {
        $client = new Client();
        $url = 'https://dev.ethix.id/index.php?r=Externalv2/Purchase/GetPurchases';

        $headers = [
            'Secretcode' => 'Myro',
            'secretkey' => 'xmb8ktY132p5cg3h6KQ5WU',
            'Content-Type' => 'application/json',
        ];

        $body = [
            'client_code' => 'CLN00494',
            'page' => 1,
            'per_page' => 10,
            // 'purchase_date' => '2023-01-01'
        ];

        // Kirim request ke API menggunakan Guzzle
        $response = $client->request('POST', $url, [
            'headers' => $headers,
            'json' => $body,
        ]);

        $content = $response->getBody()->getContents();

        // Decode JSON response menjadi array asosiatif
        $data = json_decode($content, true);
        dd($data);
        $listProducts = $data['data']['list_products'];
        // dd($listProducts);

        return view('wms.purchase.all_purchase');
    }
}
