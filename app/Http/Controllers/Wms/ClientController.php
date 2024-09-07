<?php

namespace App\Http\Controllers\Wms;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClientController extends Controller
{
    public function client(Request $request)
    {
        $client = new Client();
        $url = 'https://dev.ethix.id/index.php?r=Externalv2/Authentication/GetClient';

        $headers = [
            'Secretcode' => 'Myro',
            'secretkey' => 'xmb8ktY132p5cg3h6KQ5WU',
            'Content-Type' => 'application/json',
        ];

        $body = [];

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

        return view('wms.product.all_product', compact('listProducts'));
    }
    public function location(Request $request)
    {
        $client = new Client();
        $url = 'https://dev.ethix.id/index.php?r=Externalv2/Authentication/GetLocation';

        $headers = [
            'Secretcode' => 'Myro',
            'secretkey' => 'xmb8ktY132p5cg3h6KQ5WU',
            'Content-Type' => 'application/json',
        ];

        $body = [
            'client_code' => 'CLN0001',
        ];

        // Kirim request ke API menggunakan Guzzle
        $response = $client->request('POST', $url, [
            'headers' => $headers,
            'json' => $body,
        ]);

        $content = $response->getBody()->getContents();

        // Decode JSON response menjadi array asosiatif
        $data = json_decode($content, true);
        // dd($data);
        $listLocations = $data['data'] ?? [];

        return view('wms.location.all_location', compact('listLocations'));
    }
    public function courier(Request $request)
    {
        $client = new Client();
        $url = 'https://dev.ethix.id/index.php?r=Externalv2/Courier/GetCourierDetail';

        $headers = [
            'Secretcode' => 'Myro',
            'secretkey' => 'xmb8ktY132p5cg3h6KQ5WU',
            'Content-Type' => 'application/json',
        ];

        $body = [
            'keyword' => 'JNE',
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

        return view('wms.location.all_location', compact('listlocations'));
    }
}
