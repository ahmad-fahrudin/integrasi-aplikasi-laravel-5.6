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
        .areap {background:#fff;padding:5px}

@media print {
    .hidden-print,
    .hidden-print * {
        display: none !important;
    }
}
        </style>
        <title>Cetak Nota Kasir</title>
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
                        <th class="description" align="left">Barang</th>
                        <th class="quantity">Qt</th>
                        <th class="price">Rp</th>
                        <th class="price">Rp</th>
                    </tr>
                </thead>
                <tbody>
                  <?php
                  $no=1;
                  $jumlah=0;
                  $total=0;
                  $return=0;
                  $return_bayar=0;
                  $potongan=0;
                  $total_item=0;
                  $total_potongan=0;
                  $n=1; foreach ($detail as $key => $values): ?>
                  <?php
                  foreach ($values as $value): ?>
                    <tr>
                      <td class="description"><div class="b" style="letter-spacing:1px">{{$value['nama_barang']}} ( {{$value['part_number']}})<br>
                        <?php if ($value['potongan'] > 0): ?>
                          Potongan {{ribuan($value['potongan'])}}
                        <?php endif; ?>
                      </div></td>
                      <td class="quantity" align="center" style="letter-spacing:1px">{{ribuan($value['proses'])}}
                      <?php if ($value['return'] > 0): ?>
                          -{{ribuan($value['return'])}}
                      <?php endif; ?> 
                      </td>
                      <td class="price" align="right" style="letter-spacing:1px">{{ribuan($value['harga_jual'])}}</td>
                      <td class="price" align="right" style="letter-spacing:1px">{{ribuan($value['sub_total']+($value['potongan']*$value['proses']))}}</td>
                    </tr>
                  <?php $no++; $n++; $jumlah += $value['proses']-$value['return']; $total+= $value['sub_total']; $potongan+=$value['potongan'];
                        $total_item+=$value['sub_total']+($value['potongan']*$value['proses']); $total_potongan+=$value['potongan']*$value['proses'];$return_bayar +=$value['return']*($value['harga_jual']-$value['potongan']);  endforeach; ?>
                  <?php endforeach; ?>
                  <tr>
                    <td class="description"><div class="b" style="letter-spacing:1px"><br></div></td>
                    <td class="quantity" align="center" style="letter-spacing:1px"></td>
                    <td class="price" align="right" style="letter-spacing:1px" colspan="2"></td>
                  </tr>
                  <tr>
                    <td class="description"><div class="b" style="letter-spacing:1px"><b>Total Item</b></div></td>
                    <td class="quantity" align="center" style="letter-spacing:1px">{{ribuan($jumlah)}}</td>
                    <td class="price" align="right" style="letter-spacing:1px" colspan="2">{{ribuan($total_item)}}</td>
                  </tr>
                  <tr>
                    <td class="description"><div class="b" style="letter-spacing:1px"><b>Total Potongan</b></div></td>
                    <td class="quantity" align="center" style="letter-spacing:1px"></td>
                    <td class="price" align="right" style="letter-spacing:1px" colspan="2">{{ribuan($total_potongan)}}</td>
                  </tr>
                  <tr>
                    <td class="description"><div class="b" style="letter-spacing:1px"><b>Total Belanja</b></div></td>
                    <td class="quantity" align="center" style="letter-spacing:1px"></td>
                    <td class="price" align="right" style="letter-spacing:1px" colspan="2"><b>{{ribuan($total)}}</b></td>
                  </tr>
                  <tr>
                    <td class="description"><div class="b" style="letter-spacing:1px"><br></div></td>
                    <td class="quantity" align="center" style="letter-spacing:1px"></td>
                    <td class="price" align="right" style="letter-spacing:1px" colspan="2"></td>
                  </tr>
                  <tr>
                    <td class="description"><div class="b" style="letter-spacing:1px"><b>Uang Tunai</b></div></td>
                    <td class="quantity" align="center" style="letter-spacing:1px"></td>
                    <td class="price" align="right" style="letter-spacing:1px" colspan="2">{{ribuan($transfer[0]->pembayaran_konsumen)}}</td>
                  </tr>
                  <tr>
                    <td class="description"><div class="b" style="letter-spacing:1px"><b>Kembalian</b></div></td>
                    <td class="quantity" align="center" style="letter-spacing:1px"></td>
                    <td class="price" align="right" style="letter-spacing:1px" colspan="2">{{ribuan($transfer[0]->kembalian_konsumen)}}
                    <?php if ($value['return'] > 0): ?>
                            <br>
                          +{{ribuan($return_bayar)}}
                      <?php endif; ?> 
                    </td>
                  </tr>
                  <tr>
                    <td class="description" colspan="2"><div class="b" style="letter-spacing:1px">{{date('Y-m-d H:i:s')}}</div></td>
                    <td class="price" align="right" style="letter-spacing:1px" colspan="2">Kasir {{Auth::user()->username}}</td>
                  </tr>
                </tbody>
            </table>
            <br>
            <div align="center"><br>Terima kasih</div>
            </div>
        </div>
        </center>
        
        <script src="script.js"></script>
        <script>
        window.print();
        </script>
    </body>
</html>
