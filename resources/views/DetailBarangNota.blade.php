<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        * {
            font-size: 10px;
            font-family: Arial;
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
            width: 45px;
            max-width: 45px;
        }

        td.quantity,
        th.quantity {
            width: 10px;
            max-width: 10px;
            word-break: break-all;
        }

        td.price,
        th.price {
            width: 80px;
            max-width: 80px;
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

        @media print {

            .hidden-print,
            .hidden-print * {
                display: none !important;
            }
        }
    </style>
    <title>Receipt example</title>
</head>

<body>
    <div class="ticket">
        <center><img src="<?php echo asset('system/src/assets/images/' . aplikasi()[0]->icon); ?>" alt="homepage" /></center>
        <br>

        <table>
            <tr>
                <td>No. DO</td>
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

        <table>
            <thead>
                <tr>
                    <th class="description" colspan="2"></th>
                    <th class="price" colspan="2"></th>
                </tr>
            </thead>
            <thead>
                <tr>
                    <th class="description">No SKU</th>
                    <th class="price">Nama</th>
                    <th class="quantity">Qty</th>
                </tr>
            </thead>
            <tbody>
                <?php $no=1; $jumlah = 0; foreach ($barang as $value): ?>
                <tr>
                    <td>{{ $value->no_sku }}</td>
                    <td>{{ $value->nama_barang }}</td>
                    <td align="center">{{ $value->jumlah }}</td>
                </tr>
                <?php $no++; endforeach; ?>
            </tbody>
        </table>
        <br>
        Barang yang sudah dibeli dan atau telah digunakan tidak dapat dikembalikan atau ditukar.<br><br>Terimakasih
    </div>
    <script src="script.js"></script>
    <script>
        window.print();
    </script>
</body>

</html>
