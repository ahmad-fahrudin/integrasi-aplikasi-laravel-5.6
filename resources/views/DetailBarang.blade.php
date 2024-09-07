@extends('template/master')
@section('main-content')
    <style>
        table {
            margin: auto;
            width: calc(100% - 40px);
        }
    </style>
    <div class="container" style="background-color:white;">
        <div id='printMe'>
            <div class="col-md-12">
                <p><b>
                        <h3>Surat Order</h3>
                    </b></p>
                <table>
                    <tr>
                        <td>No. SO</td>
                        <td>{{ $header[0]->no_transfer }}</td>
                    </tr>
                    <tr>
                        <td>Tanggal Order</td>
                        <td>{{ tanggal($header[0]->tanggal_order) }}</td>
                    </tr>
                    <?php if (isset($header[0]->nama_pemilik)): ?>
                    <tr>
                        <td>Nama</td>
                        <td>{{ $header[0]->nama_pemilik }}</td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td><?php echo $header[0]->alamat; ?></td>
                    </tr>
                    <?php endif; ?>
                    <?php if (isset($header[0]->nama_gudang)): ?>
                    <tr>
                        <td>Nama</td>
                        <td>{{ $header[0]->nama_gudang }}</td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td><?php echo $header[0]->alamat; ?></td>
                    </tr>
                    <?php endif; ?>
                </table>
            </div>
            <br>
            <div class="col-md-12">
                <table border="1">
                    <tr>
                        <td>
                            <center><b>No</b></center>
                        </td>
                        <td>
                            <center><b>No SKU</b></center>
                        </td>
                        <td>
                            <center><b>Nama Barang</b></center>
                        </td>
                        <td>
                            <center><b>Part Number</b></center>
                        </td>
                        <td>
                            <center><b>Warna Produk</b></center>
                        </td>
                        <td>
                            <center><b>Jumlah</b></center>
                        </td>
                    </tr>
                    <?php $no=1; $jumlah = 0; foreach ($barang as $value): ?>
                    <tr>
                        <td>
                            <center>{{ $no }}</center>
                        </td>
                        <td>{{ $value->no_sku }}</td>
                        <td>{{ $value->nama_barang }}</td>
                        <td>{{ $value->part_number }}</td>
                        <td>
                            <?php if(isset($value->warna)){ ?>{{ $value->warna }}<?php } ?></td>
                        <td align="center">{{ $value->jumlah }}</td>
                    </tr>
                    <?php $no++; endforeach; ?>
                </table>
                <br>
                <table>
                    <td><b>&emsp;&emsp;&emsp;Petugas QC</b>
                        <br><br><br>
                        (&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;)
                    </td>
                </table>
            </div>
        </div>
        <br><br><br>
        <!--center><button class="btn btn-success" onclick="printDiv('printMe')">Cetak</button>
              <button class="btn btn-primary" onclick="BackTo()">Back</button></center-->
        <br><br><br>
    </div>

    <script>
        window.onload = function() {
            window.print();
        };

        function printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }

        function BackTo() {
            window.top.close();
        }
    </script>
@endsection
