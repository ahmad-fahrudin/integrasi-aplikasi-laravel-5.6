<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <style>
        * {
    font-size: 10px;
    font-family:Arial;
}

td,
th,
tr,
table {
    border-top: 1px solid black;
    border-collapse: collapse;
}

td.description,
th.description {
    width: 65px;
    max-width: 65px;
}

td.quantity,
th.quantity {
    width: 35px;
    max-width: 35px;
    word-break: break-all;
}

td.price,
th.price {
    width: 35px;
    max-width: 35px;
    word-break: break-all;
}

.centered {
    text-align: center;
    align-content: center;
}

.ticket {
    width: 185px;
    max-width: 185px;
}

img {
    width: 75%;
}

 body {background:#eee;}
        .areap {background:#fff;padding: 5px;}

@media print {
    .hidden-print,
    .hidden-print * {
        display: none !important;
    }
}
        </style>
        <title>Cetak Nota Jasa</title>
    </head>
    <body>
        <center>
        
        <div class="ticket">
            <div class="areap">
            <center><img src="<?php echo asset('gambar/'.aplikasi()[0]->icon); ?>"  alt="homepage" /></center>
            <br>
            <table>
                <thead>
                    <tr>
                        <td>No Trip</td>
                        <td colspan='2'>{{$surat[0]->no_trip}}</td>
                    </tr>
                    <tr>
                        <td>Tanggal</td>
                        <td colspan='2'>{{$surat[0]->tanggal_create}}</td>
                    </tr>
                    <tr>
                        <td>Kasir</td>
                        <td colspan='2'>{{$karyawan[$surat[0]->kasir]}}</td>
                    </tr>
                    <tr>
                        <th class="description">Kwitansi</th>
                        <th class="quantity">Nama</th>
                        <th class="price">Total</th>
                    </tr>
                </thead>
                <tbody>
                  <?php                 
                  session_start();
                  unset($_SESSION['trip']);
                  $total=0; foreach($surat as $value){ $total+=$value->sub_total;?>
                    <tr>
                        <td>{{$value->no_kwitansi}}</td>
                        <td>{{$konsumen[$value->id_konsumen]['nama']}}</td>
                        <td>{{ribuan($value->sub_total)}} <?php if(isset($bayar[$value->no_kwitansi])){ echo "(Lunas)"; }?></td>
                    </tr>
                  <?php } ?>
                    <tr>
                        <td colspan='2'>Total Penjualan</td>
                        <td>{{ribuan($total)}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        </div>
        </center>
        <script src="script.js"></script>
        <script>
        window.print();
        </script>
    </body>
</html>
