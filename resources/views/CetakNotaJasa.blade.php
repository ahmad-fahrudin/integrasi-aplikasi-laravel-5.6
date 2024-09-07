<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <style>
        * {
    font-size: 9px;
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
    width: 15px;
    max-width: 15px;
    word-break: break-all;
}

td.price,
th.price {
    width: 55px;
    max-width: 55px;
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
            <div align="center">
            <?php $texts=str_ireplace('<p>','',$alamat_gudang[0]->alamat);
                  $texts=str_ireplace('</p>','', $texts); ?>
            <?=$texts?> <?=$alamat_gudang[0]->name?>, <?=$alamat_gudang[0]->regency_name?> (<?=$alamat_gudang[0]->no_hp?>)
            </div>
            <br>
            <table>
                <thead>
                    <tr>
                        <th class="description" colspan="2">{{$transfer[0]->id_konsumen}}<br>{{$transfer[0]->nama_pemilik}}</th>
                        <th class="price" colspan="2">{{$nota}}</th>
                    </tr>
                </thead>
                <thead>
                    <tr>
                        <th class="description">Layanan</th>
                        <th class="quantity">Qt</th>
                        <th class="price">Rp</th>
                        <th class="price">Rp</th>
                    </tr>
                </thead>
                <tbody>
                  <?php $n=1; foreach ($detail as $key => $values): ?>
                  <?php
                  $no=1;
                  $jumlah=0;
                  $total=0;
                  $potongan=0;
                  $total_item=0;
                  $total_potongan=0;
                  foreach ($values as $value):
            				if ($no < 11) { ?>
                    <tr>
                      <td class="description"><div class="b" style="letter-spacing:1px">{{$value['nama_barang']}}<br>
                      </div></td>
                      <td class="quantity" align="center" style="letter-spacing:1px">{{ribuan($value['proses'])}}</td>
                      <td class="price" align="right" style="letter-spacing:1px">{{ribuan($value['harga_jual'])}}</td>
                      <td class="price" align="right" style="letter-spacing:1px">{{ribuan($value['sub_total'])}}</td>
                    </tr>
                  <?php $no++; $n++; $jumlah += $value['proses']; $total+= $value['sub_total'];;
                        $total_item+=$value['sub_total']; } endforeach; ?>
                  <?php endforeach; ?>
                  <tr>
                    <td class="description"><div class="b" style="letter-spacing:1px"><br></div></td>
                    <td class="quantity" align="center" style="letter-spacing:1px"></td>
                    <td class="price" align="right" style="letter-spacing:1px" colspan="2"></td>
                  </tr>
                  <tr>
                    <td class="description"><div class="b" style="letter-spacing:1px"><b>Total Jasa</b></div></td>
                    <td class="quantity" align="center" style="letter-spacing:1px">{{ribuan($jumlah)}}</td>
                    <td class="price" align="right" style="letter-spacing:1px" colspan="2">{{ribuan($total_item)}}</td>
                  </tr>
                  <tr>
                    <td class="description"><div class="b" style="letter-spacing:1px"><b>Total Potongan</b></div></td>
                    <td class="quantity" align="center" style="letter-spacing:1px"></td>
                    <td class="price" align="right" style="letter-spacing:1px" colspan="2">{{ribuan($transfer[0]->potongan)}}</td>
                  </tr>
                  <tr>
                    <td class="description"><div class="b" style="letter-spacing:1px"><b>Total Biaya</b></div></td>
                    <td class="quantity" align="center" style="letter-spacing:1px"></td>
                    <td class="price" align="right" style="letter-spacing:1px" colspan="2">{{ribuan($total-$transfer[0]->potongan)}}</td>
                  </tr>
                  <tr>
                    <td class="description"><div class="b" style="letter-spacing:1px"><br></div></td>
                    <td class="quantity" align="center" style="letter-spacing:1px"></td>
                    <td class="price" align="right" style="letter-spacing:1px" colspan="2"></td>
                  </tr>
                  
                  <tr hidden>
                    <td class="description"><div class="b" style="letter-spacing:1px"><b>Uang Tunai</b></div></td>
                    <td class="quantity" align="center" style="letter-spacing:1px"></td>
                    <td class="price" align="right" style="letter-spacing:1px" colspan="2">{{ribuan($transfer[0]->pembayaran_konsumen)}}</td>
                  </tr>
                  <tr hidden>
                    <td class="description"><div class="b" style="letter-spacing:1px"><b>Kembalian</b></div></td>
                    <td class="quantity" align="center" style="letter-spacing:1px"></td>
                    <td class="price" align="right" style="letter-spacing:1px" colspan="2">{{ribuan($transfer[0]->kembalian_konsumen)}}</td>
                  </tr>

                  <tr>
                    <td class="description" colspan="2"><div class="b" style="letter-spacing:1px">{{date('Y-m-d H:i:s')}}</div></td>
                    <td class="price" align="right" style="letter-spacing:1px" colspan="2">Kasir {{Auth::user()->username}}</td>
                  </tr>
                </tbody>
            </table>
            <br>
            <div align="left">
            <b>Perhatian</b><br> Khusus garansi service berlaku 7 hari.<br><br>Terimakasih
            </div>
        </div>
        </div>
        </center>
        <script src="script.js"></script>
        <script>
        window.print();
        </script>
    </body>
</html>
