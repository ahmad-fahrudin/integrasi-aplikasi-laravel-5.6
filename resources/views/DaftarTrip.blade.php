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
                                        <li class="breadcrumb-item text-muted" aria-current="page">Laporan Harian / Trip > <a
                                                href="https://stokis.app/?s=daftar+trip+kiriman" target="_blank">Daftar Trip
                                                Kiriman</a></li>
                                    </ol>
                                </nav>
                            </h4>
                            <hr>
                            <div style="border:2px dashed #eee;border-radius:20px; padding:20px; backgroud:#f5f5f5">
                                <p><strong>Cari No. Trip berdasarkan</strong></p>
                                <div class="col-md-6">
                                    <form name="form1" action="{{ url('caritrip') }}" method="post"
                                        enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <div class="row">
                                            <label class="col-lg-3">No. Kwitansi</label>
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="input-group">
                                                            <input type="text" name="no_kwitansi" class="form-control"
                                                                required placeholder="Ketik No. Kwitansi...">
                                                            <div class="input-group-append">
                                                                <button class="btn btn-success"><i
                                                                        class="fas fa-search"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                </div>
                                </form>
                            </div>
                            <hr>
                            <div style="border:2px dashed #eee;border-radius:20px; padding:20px; backgroud:#f5f5f5">
                                <p><strong>Filter Berdasarkan</strong></p>
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <form name="form1" action="{{ url('daftartrip') }}" method="post"
                                            enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            <div class="row">
                                                <label class="col-lg-3">Range Tanggal</label>
                                                <div class="col-lg-4">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <input onchange="change()" name="date_from" type="date"
                                                                class="form-control" <?php if (isset($date_from)): ?>
                                                                value="{{ $date_from }}" <?php endif; ?>>
                                                        </div>
                                                    </div>
                                                </div>
                                                <label class="col-lg-0.5">&emsp;s/d&emsp;</label>
                                                <div class="col-lg-4">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <input onchange="change()" name="date_to" type="date"
                                                                class="form-control" <?php if (isset($date_to)): ?>
                                                                value="{{ $date_to }}" <?php endif; ?>>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <label class="col-lg-3">Cabang</label>
                                                <div class="col-lg-8">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <select class="form-control" onchange="change2()" id="id_gudang"
                                                                name="id_gudang">
                                                                <?php if (Auth::user()->level == "1" || Auth::user()->gudang == "1" || Auth::user()->gudang == "2"){
                                           foreach ($gudang as $key => $value): if ($value['status'] == "aktif") { ?>
                                                                <option value="{{ $value['id'] }}" <?php if (isset($id_gudang) && $id_gudang == $value['id']): ?>
                                                                    selected <?php endif; ?>>
                                                                    {{ $value['nama_gudang'] }}</option>
                                                                <?php } endforeach;
                                         }else{
                                           foreach ($gudang as $key => $value): if ($value['id'] == Auth::user()->gudang) { ?>
                                                                <option value="{{ $value['id'] }}" <?php if (isset($id_gudang) && $id_gudang == $value['id']): ?>
                                                                    selected <?php endif; ?>>
                                                                    {{ $value['nama_gudang'] }}</option>
                                                                <?php } endforeach;
                                         } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="form-group">
                                                <div class="col-lg-12">
                                                    <center><button disabled id="filter"
                                                            class="btn btn-success btn-lg">Filter Data</button></center>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            </div>
                            <br>
                            <hr>
                            <div class="table-responsive">
                                <table id="example1" class="table table-striped table-bordered no-wrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>No. Trip</th>
                                            <th>Driver</th>
                                            <th>QC</th>
                                            <th>Admin</th>
                                            <th>Kategori Penjualan</th>
                                            <th>Cabang</th>
                                            <th>Nilai Penjualan</th>
                                            <th>Status Laporan</th>
                                            <th>Tindakan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                        if (count($daftar) < 1) {
                          echo '<tr><td colspan="9"><center>Data Belum Ada</center></td></tr>';
                        }else{
                        foreach ($daftar as $key => $value):
                        if($value->penjualan > 0){ ?>
                                        <tr <?php if ($value->available == 'calculated') {
                                        } else {
                                            echo "style='background:#fabcbc'";
                                        } ?>>
                                            <td>{{ $value->tanggal_input }}</td>
                                            <td>{{ $value->no_trip }}</td>
                                            <td><?php if(isset($karyawan[$value->driver])){?> {{ $karyawan[$value->driver] }} <?php } ?>
                                            </td>
                                            <td>{{ $karyawan[$value->qc] }}</td>
                                            <td>{{ $admin[$value->admin] }}</td>
                                            <td>{{ $kategori[$value->kategori] }}</td>
                                            <td>{{ $gudang[$value->id_gudang]['nama_gudang'] }}</td>
                                            <td align="right">{{ ribuan($value->penjualan) }}</td>
                                            <td><?php if ($value->available == 'calculated') {
                                                echo 'Masuk Saldo';
                                            } else {
                                                echo 'Belum Masuk';
                                            } ?></td>
                                            <td>
                                                <?php if (Auth::user()->id == 1): ?>
                                                <button class="btn btn-success"
                                                    onclick="Edit('{{ $value->no_trip }}','<?php if(isset($karyawan[$value->driver])){?> {{ $karyawan[$value->driver] }} <?php }else{ ?><?php } ?>','{{ $karyawan[$value->qc] }}','{{ $gudang[$value->id_gudang]['nama_gudang'] }}','{{ $value->kategori }}')">Edit</button>
                                                <?php endif; ?>
                                                <button class="btn btn-primary"
                                                    onclick="Rincian('{{ $value->no_trip }}','{{ $value->available }}')">Lihat
                                                    Rincian</button>
                                                <a class="btn btn-success" href="{{ url('tripsurat/' . $value->no_trip) }}"
                                                    target="_blank">Surat Jalan Keuangan</a>
                                                <a class="btn btn-warning"
                                                    href="{{ url('cetakrinciantrip/' . $value->no_trip) }}"
                                                    target="_blank">Surat Jalan Gudang</a>
                                            </td>
                                        </tr>
                                        <?php } endforeach; }?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="detail" role="dialog">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">

                    <div class="table-responsive">
                        <table id="examples" class="table table-striped table-bordered no-wrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No. Transfer</th>
                                    <th>Nama</th>
                                    <th>Alamat</th>
                                    <th>Sub Total</th>
                                    <?php if (Auth::user()->level == "1" || Auth::user()->level == "4"): ?>
                                    <th>Tindakan</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="edit" role="dialog">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('/edit_kategori_penjualan') }}" method="post">
                        {{ csrf_field() }}
                        No. Trip:
                        <input type="text" readonly id="no_trip" name="no_trip" class="form-control">
                        Driver:
                        <input type="text" readonly id="driver" class="form-control">
                        QC:
                        <input type="text" readonly id="qc" class="form-control">
                        Cabang:
                        <input type="text" readonly id="gudang" class="form-control">
                        Kategori Penjualan:
                        <select id="kategori" name="kategori" class="form-control">
                            <option value="1">Non Insentif</option>
                            <option value="2">Sales Marketing</option>
                            <option value="3">Membership</option>
                            <option hidden value="4">Grosir HPP Target</option>
                        </select>
                        <br>
                        <center><input type="submit" value="&emsp;Simpan&emsp;" class="btn btn-success"></center>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script>
        function numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        function change() {
            var empt = document.forms["form1"]["date_from"].value;
            var empt2 = document.forms["form1"]["date_to"].value;
            if (empt != "" && empt2 != "") {
                document.getElementById("filter").disabled = false;
            }
        }

        function change2() {
            document.getElementById("filter").disabled = false;
        }

        var ids = "";

        function Edit(no_trip, driver, qc, gudang, kategori) {
            document.getElementById("no_trip").value = no_trip;
            document.getElementById("driver").value = driver;
            document.getElementById("qc").value = qc;
            document.getElementById("gudang").value = gudang;
            document.getElementById("kategori").value = kategori;
            $('#edit').modal('show');
        }

        function Rincian(value, status) {
            var myTable = document.getElementById("examples");
            var rowCount = myTable.rows.length;
            for (var x = rowCount - 1; x > 0; x--) {
                myTable.deleteRow(x);
            }

            $.ajax({
                url: 'detailTrip/' + value,
                type: 'get',
                dataType: 'json',
                async: false,
                success: function(response) {
                    ids = "";
                    var t = $('#examples').DataTable();
                    t.clear().draw();
                    for (var i = 0; i < response.length; i++) {
                        var a = "'" + response[i]['no_kwitansi'] + "'";
                        if (status != "calculated") {
                            t.row.add([
                                response[i]['no_kwitansi'],
                                response[i]['nama_pemilik'],
                                response[i]['alamat'],
                                numberWithCommas(response[i]['sub_total'])
                                <?php if (Auth::user()->level == "1" || Auth::user()->level == "4"): ?>,
                                '<button class="btn btn-danger" onclick="ProsesPending(' + response[i][
                                    'id_detail_trip'
                                ] + ',' + a + ')">Pending</button>'
                                <?php endif; ?>
                            ]).draw(false);
                        } else {
                            t.row.add([
                                response[i]['no_kwitansi'],
                                response[i]['nama_pemilik'],
                                response[i]['alamat'],
                                numberWithCommas(response[i]['sub_total'])
                                <?php if (Auth::user()->level == "1" || Auth::user()->level == "4"): ?>, ' '
                                <?php endif; ?>
                            ]).draw(false);
                        }


                        /*var table = document.getElementById("examples");
                        var lastRow = table.rows.length;
                        var row = table.insertRow(lastRow);
                        row.id = lastRow;

                        var cell1 = row.insertCell(0);
                        var cell2 = row.insertCell(1);
                        var cell3 = row.insertCell(2);
                        var cell4 = row.insertCell(3);
                        <?php if (Auth::user()->level == "1" || Auth::user()->level == "4"): ?>
                        var cell5 = row.insertCell(4);
                        <?php endif; ?>

                        ids += +",";

                        cell1.innerHTML = response[i]['no_kwitansi'];
                        cell2.innerHTML = response[i]['nama_pemilik'];
                        cell3.innerHTML = response[i]['alamat'];
                        cell4.innerHTML = numberWithCommas(response[i]['sub_total']);
                        if (status != "calculated") {
                          <?php if (Auth::user()->level == "1" || Auth::user()->level == "4"): ?>
                          var a = "'"+response[i]['no_kwitansi']+"'";
                          cell5.innerHTML = '<button class="btn btn-danger" onclick="ProsesPending('+response[i]['id_detail_trip']+','+a+')">Pending</button>';
                          <?php endif; ?>
                        }*/
                    }
                    $('#detail').modal('show');
                }
            });
        }


        function ProsesPending(id, kwitansi) {
            Swal.fire(
                'Pindahkan Kuitansi ' + kwitansi + ' Ke Daftar Pending?',
                'Apakah Anda Yakin?',
                'question'
            ).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: 'pendingkwitansi/' + id,
                        type: 'get',
                        dataType: 'json',
                        async: false,
                        success: function(response) {
                            location.href = "{{ url('/daftartrip/') }}";
                        }
                    });
                }
            });
        }
    </script>
@endsection
