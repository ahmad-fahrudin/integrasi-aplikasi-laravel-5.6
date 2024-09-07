<?php

namespace App\Http\Controllers\Wms;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function allProduct(Request $request)
    {
        $client = new Client();

        // Request pertama untuk mendapatkan list produk
        $urlProduct = 'https://dev.ethix.id/index.php?r=Externalv2/Product/GetProduct';

        $headers = [
            'Secretcode' => 'Myro',
            'secretkey' => 'xmb8ktY132p5cg3h6KQ5WU',
            'Content-Type' => 'application/json',
        ];

        $bodyProduct = [
            'client_code' => 'CLN00494',
            'page' => 1,
            'per_page' => 5,
        ];
        $responseProduct = $client->request('POST', $urlProduct, [
            'headers' => $headers,
            'json' => $bodyProduct,
        ]);

        $contentProduct = $responseProduct->getBody()->getContents();
        $dataProduct = json_decode($contentProduct, true);
        $listProducts = $dataProduct['data']['list_products'] ?? [];

        // Request kedua untuk mendapatkan lokasi
        $urlLocation = 'https://dev.ethix.id/index.php?r=Externalv2/Authentication/GetLocation';

        $bodyLocation = [
            'client_code' => 'CLN0001',
        ];
        $responseLocation = $client->request('POST', $urlLocation, [
            'headers' => $headers,
            'json' => $bodyLocation,
        ]);

        $contentLocation = $responseLocation->getBody()->getContents();
        $dataLocation = json_decode($contentLocation, true);
        $listLocations = $dataLocation['data'] ?? [];

        return view('wms.product.all_product', compact('listProducts', 'listLocations'));
    }


    public function ProductDetail($product_code)
    {
        $client = new Client();
        $url = 'https://dev.ethix.id/index.php?r=Externalv2/Product/GetDetail';

        $headers = [
            'Secretcode' => 'Myro',
            'secretkey' => 'xmb8ktY132p5cg3h6KQ5WU',
            'Content-Type' => 'application/json',
        ];

        $body = [
            'client_code' => 'CLN00494',
            'product_code' => $product_code,
        ];

        $response = $client->request('POST', $url, [
            'headers' => $headers,
            'json' => $body,
        ]);

        $statusCode = $response->getStatusCode();
        $content = $response->getBody()->getContents();

        $productDetail = json_decode($content, true);
        // dd($productDetail);

        return view('wms.product.product_detail', compact('productDetail'));
    }
    public function productStock(Request $request)
    {
        $client = new Client();
        $url = 'https://dev.ethix.id/index.php?r=Externalv2/Product/GetStock';

        $headers = [
            'Secretcode' => 'Myro',
            'secretkey' => 'xmb8ktY132p5cg3h6KQ5WU',
            'Content-Type' => 'application/json',
        ];

        $body = [
            'product_code' => $request->input('product_code'),
            'client_code' => 'CLN00494', // Sesuaikan dengan client_code
            'location_code' => $request->input('location_code'),
        ];

        // Kirim request ke API menggunakan Guzzle
        $response = $client->request('POST', $url, [
            'headers' => $headers,
            'json' => $body,
        ]);

        $content = $response->getBody()->getContents();

        $data = json_decode($content, true);

        // Ambil informasi dari data yang dikembalikan
        $location_name = $data['data']['location_name'] ?? 'Unknown';
        $product_name = $data['data']['product_name'] ?? 'Unknown';
        $stock_available = $data['data']['stock_available'] ?? 0;

        return response()->json([
            'location_name' => $location_name,
            'product_name' => $product_name,
            'stock_available' => $stock_available,
        ]);
    }
}
