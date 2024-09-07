<?php

namespace App\Http\Controllers\Wms;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function allOrder(Request $request)
    {
        $client = new Client();
        $url = 'https://dev.ethix.id/index.php?r=Externav2l/Order/GetOrder ';

        $headers = [
            'Secretcode' => 'Myro',
            'secretkey' => 'xmb8ktY132p5cg3h6KQ5WU',
            'Content-Type' => 'application/json',
        ];

        $body = [
            'client_code' => 'CLN00494',
            'page' => 1,
            'per_page' => 1,
            'created_date' => "2022-09-23",
            'created_via' => "LATIHANAPI"
        ];

        // Kirim request ke API menggunakan Guzzle
        $response = $client->request('POST', $url, [
            'headers' => $headers,
            'json' => $body,
        ]);

        $content = $response->getBody()->getContents();

        // Decode JSON response menjadi array asosiatif
        $data = json_decode($content, true);
        return response()->json($data);
    }
}
