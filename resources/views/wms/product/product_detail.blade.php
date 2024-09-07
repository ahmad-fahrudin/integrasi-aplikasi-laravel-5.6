@extends('template/nav')
@section('content')
    <div class="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb ">
                                        <li class="breadcrumb-item text-muted" aria-current="page">Warehouse Manage >
                                            Master > Product >
                                            <a href="#" target="_blank">Product Information</a>
                                        </li>
                                    </ol>
                                </nav>
                            </h4>
                            <style>
                                .product-info {
                                    background-color: #757575;
                                    padding: 1px;
                                    border-radius: 1px;
                                }

                                .info-header {
                                    background-color: #757575;
                                    color: white;
                                    padding: 10px;
                                    font-weight: bold;
                                    text-align: left;
                                    margin-bottom: 20px;
                                }

                                .table th,
                                .table td {
                                    vertical-align: middle;
                                    text-align: left;
                                }

                                .table th {
                                    width: 20%;
                                }

                                .table-bordered tr:nth-child(odd) {
                                    background-color: #f2f2f2;
                                }

                                .table-bordered tr:nth-child(even) {
                                    background-color: #ffffff;
                                }

                                .badge-success {
                                    background-color: #28a745;
                                    padding: 5px 10px;
                                    border-radius: 5px;
                                    color: white;
                                }
                            </style>

                            <div class="product-info">
                                <h1 class="info-header">PRODUCT INFORMATION</h1>
                                <table class="table table-bordered">
                                    <tr>
                                        <th>TYPE</th>
                                        <td>{{ $productDetail['data']['product_type'] }}</td>
                                    </tr>
                                    <tr>
                                        <th>MANAGED</th>
                                        <td>{{ $productDetail['data']['product_managed'] }}</td>
                                    </tr>
                                    <tr>
                                        <th>STATUS</th>
                                        <td>
                                            <span class="badge badge-success">
                                                {{ $productDetail['data']['is_active'] == 1 ? 'ACTIVE' : 'INACTIVE' }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>CODE</th>
                                        <td>{{ $productDetail['data']['product_code'] }}</td>
                                    </tr>
                                    <tr>
                                        <th>NAME</th>
                                        <td>{{ $productDetail['data']['product_name'] }}</td>
                                    </tr>
                                    <tr>
                                        <th>BARCODE</th>
                                        <td>{{ $productDetail['data']['barcode'] }}</td>
                                    </tr>
                                    <tr>
                                        <th>OUTER BARCODE</th>
                                        <td>{{ $productDetail['data']['barcode'] }}</td>
                                    </tr>
                                    <tr>
                                        <th>CONVERSION UNIT</th>
                                        <td>{{ $productDetail['data']['conversion_unit'] }}</td>
                                    </tr>
                                    <tr>
                                        <th>BRAND</th>
                                        <td>{{ $productDetail['data']['brand'] }}</td>
                                    </tr>
                                    <tr>
                                        <th>CATEGORY</th>
                                        <td>{{ $productDetail['data']['category'] }}</td>
                                    </tr>
                                    {{-- <tr>
                                        <th>MINIMUM STOCK</th>
                                        <td>{{ $productDetail['data']['min_stock'] }}</td>
                                    </tr> --}}
                                    <tr>
                                        <th>EXPIRED INBOUND</th>
                                        <td>{{ $productDetail['data']['expired_inbound'] }} days</td>
                                    </tr>
                                    <tr>
                                        <th>EXPIRED OUTBOUND</th>
                                        <td>{{ $productDetail['data']['expired_outbound'] }} days</td>
                                    </tr>
                                    <tr>
                                        <th>WEIGHT</th>
                                        <td>{{ $productDetail['data']['weight'] }} kg</td>
                                    </tr>
                                    <tr>
                                        <th>LENGTH</th>
                                        <td>{{ $productDetail['data']['length'] }} cm</td>
                                    </tr>
                                    <tr>
                                        <th>WIDTH</th>
                                        <td>{{ $productDetail['data']['width'] }} cm</td>
                                    </tr>
                                    <tr>
                                        <th>HEIGHT</th>
                                        <td>{{ $productDetail['data']['height'] }} cm</td>
                                    </tr>
                                    <tr>
                                        <th>CREATED DATE</th>
                                        <td>{{ $productDetail['data']['created_date'] }}</td>
                                    </tr>
                                    <tr>
                                        <th>CREATED BY</th>
                                        <td>{{ $productDetail['data']['created_by'] }}</td>
                                    </tr>
                                    <tr>
                                        <th><a href="{{ route('all.product') }}" class="btn btn-primary mt-3">Back to
                                                Products</a>
                                        </th>
                                        <td></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
