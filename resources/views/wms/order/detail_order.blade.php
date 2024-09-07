@extends('template/nav')
@section('content')
    <style>
        table {
            margin: auto;
            width: calc(100% - 40px);
        }
    </style>
    <div class="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb ">
                                        <li class="breadcrumb-item text-muted" aria-current="page">Where House Manage >
                                            Outbound > Order >
                                            <a href="#" target="_blank">Nama Order</a>
                                        </li>
                                    </ol>
                                </nav>
                            </h4>
                            <hr>
                            <div id='printMe'>
                                <div class="col-md-12">
                                    <p><b>
                                            <h3>Detail Order</h3>
                                        </b></p>
                                    <table>
                                        <tr>
                                            <td>Order Type</td>
                                            <td>hehe</td>
                                        </tr>
                                        <tr>
                                            <td>Order Code</td>
                                            <td>hehe</td>
                                        </tr>
                                        <tr>
                                            <td>Tracking Number</td>
                                            <td class="text-danger">hehe</td>
                                        </tr>
                                        <tr>
                                            <td>Recipient Name</td>
                                            <td>haha</td>
                                        </tr>

                                        <tr>
                                            <td>Created By</td>
                                            <td>huhuhu</td>
                                        </tr>
                                        <tr>
                                            <td>Created Date</td>
                                            <td>whehehe</td>
                                        </tr>
                                        <tr>
                                            <td>Status</td>
                                            <td>whehehe</td>
                                        </tr>
                                    </table>
                                </div>
                                <br>
                                <p><b>
                                        <h3>Order Product</h3>
                                    </b></p>
                                <div class="col-md-12">
                                    <table border="1">
                                        <tr>
                                            <td style="width: 50px;">
                                                <center><b>No.</b></center>
                                            </td>
                                            <td>
                                                <center><b>Name</b></center>
                                            </td>
                                            <td>
                                                <center><b>Barcode</b></center>
                                            </td>
                                            <td>
                                                <center><b>Code</b></center>
                                            </td>
                                            <td>
                                                <center><b>Price</b></center>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center">1</td>
                                            <td align="center">Jajan</td>
                                            <td align="center">432423</td>
                                            <td align="center">4343</td>
                                            <td align="center">RP.50.000</td>
                                            {{-- <td align="center"></td> --}}
                                        </tr>
                                    </table>
                                    <br>
                                    {{-- <table>
                                        <td><b>&emsp;&emsp;&emsp;Petugas QC</b>
                                            <br><br><br>
                                            (&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;)
                                        </td>
                                    </table> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
