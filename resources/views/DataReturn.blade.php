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
                                        <li class="breadcrumb-item text-muted" aria-current="page">Gudang > Retur Penjualan >
                                            <a href="https://stokis.app/?s=data+rerur+penjualan+barang+kembali"
                                                target="_blank">Data Retur</a></li>
                                    </ol>
                                </nav>
                            </h4>
                            <hr>
                            <div style="border:2px dashed #eee;border-radius:20px; padding:20px; backgroud:#f5f5f5">
                                <p><strong>Filter Berdasarkan</strong></p>
                                <form action="{{ url('datareturn') }}" method="post">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <label class="col-lg-3">Tanggal Kembali</label>
                                                    <div class="col-lg-5">
                                                        <div class="row">
                                                            <div class="col-md-9">
                                                                <input type="date" name="from" <?php if (isset($from)): ?>
                                                                    value="{{ $from }}" <?php endif; ?>
                                                                    class="form-control">
                                                            </div>
                                                            <label class="col-lg-3">s/d</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <input type="date" name="to" <?php if (isset($to)): ?>
                                                                    value="{{ $to }}" <?php endif; ?>
                                                                    class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <label class="col-lg-3">Cabang</label>
                                                    <div class="col-lg-9">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <select name="id_gudang" class="form-control">
                                                                    <option value="">Semua</option>
                                                                    <?php foreach ($gudang as $value): ?>
                                                                    <option value="{{ $value->id }}" <?php if (isset($id_gudang)): ?>
                                                                        <?php if ($value->id == $id_gudang): ?> selected <?php endif; ?>
                                                                        <?php endif; ?>>{{ $value->nama_gudang }}
                                                                    </option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <label class="col-lg-3">Nama Barang</label>
                                                    <div class="col-lg-9">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <input type="text" id="nama_barang" name="nama_barang"
                                                                    onchange="change()" <?php if (isset($nama_barang)): ?>
                                                                    value="{{ $nama_barang }}"
                                                                    <?php endif; ?>class="form-control"
                                                                    placeholder="Ketik nama barang...">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row" style="display:none">
                                                    <label class="col-lg-3">Admin</label>
                                                    <div class="col-lg-9">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="col-md-12">
                                                                    <div class="input-group">
                                                                        <input id="adm" type="text" name="nama"
                                                                            class="form-control" <?php if (isset($nama)): ?>
                                                                            value="{{ $nama }}"
                                                                            <?php endif; ?>>
                                                                        <input id="idadm" name="admin_r" type="hidden"
                                                                            class="form-control" <?php if (isset($admin_r)): ?>
                                                                            value="{{ $admin_r }}"
                                                                            <?php endif; ?>>
                                                                        <div class="input-group-append">
                                                                            <button class="btn btn-outline-secondary"
                                                                                onclick="cariadmin()" type="button"><i
                                                                                    class="fas fa-search"></i></button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <label class="col-lg-3"></label>
                                                    <div class="col-lg-9">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <center><button class="btn btn-success btn-lg">Filter
                                                                        Data</button></center>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                        </div>

                                    </div>
                                </form>
                            </div>
                            <br>
                            <hr>
                            <div class="table-responsive">
                                <table id="dr" class="table table-striped table-bordered no-wrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No. Kwitansi</th>
                                            <th>Tanggal Terkirim</th>
                                            <th>Tanggal Kembali</th>
                                            <th>Nama Konsumen</th>
                                            <th>Alamat</th>
                                            <th>No SKU</th>
                                            <th>Nama Barang</th>
                                            <th>Jumlah Terkirim</th>
                                            <th>Jumlah Kembali</th>
                                            <th>Harga Net</th>
                                            <th>Harga Jual</th>
                                            <th>Potongan Promo</th>
                                            <th>Potongan Harga</th>
                                            <th>Jumlah Harga (R)</th>
                                            <th>Sales</th>
                                            <th>Pengembang</th>
                                            <th>Leader</th>
                                            <th>Manager</th>
                                            <th>Admin(P)</th>
                                            <th>Admin(G)</th>
                                            <th>Admin(V)</th>
                                            <th>Admin(R)</th>
                                            <th>QC</th>
                                            <th>Dropper</th>
                                            <th>Pengirim</th>
                                            <th>Cabang</th>
                                            <th>Status Order</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php foreach ($reject as $key => $value): if ($value->kembali != 0) {
                          if ($value->terkirim == 0) {
                            $value->terkirim = 1;
                          }
                          ?>
                                        <tr>
                                            <td>{{ $value->no_kwitansi }}</td>
                                            <td>{{ tanggal($value->tanggal_terkirim) }}</td>
                                            <td>{{ tanggal($value->tanggal_return) }}</td>
                                            <td>{{ $value->nama_pemilik }}</td>
                                            <td><?php echo $value->alamat; ?></td>
                                            <td>{{ $brg[$value->id_barang]['no_sku'] }}</td>
                                            <td>{{ $brg[$value->id_barang]['nama_barang'] }}</td>
                                            <td>{{ $value->terkirim }}</td>
                                            <td>{{ $value->kembali }}</td>
                                            <td>{{ rupiah($value->harga_net) }}</td>
                                            <td>{{ rupiah($value->harga_jual) }}</td>
                                            <td>{{ rupiah($value->potongan) }}</td>
                                            <td>{{ rupiah($value->sub_potongan / $value->terkirim) }}</td>
                                            <td>{{ rupiah($value->kembali * ($value->harga_jual - $value->potongan - $value->sub_potongan / $value->terkirim)) }}
                                            </td>
                                            <td><?php if (isset($karyawan[$value->sales])){ ?>{{ $karyawan[$value->sales] }}<?php } ?></td>
                                            <td>{{ $karyawan[$value->pengembang] }}</td>
                                            <td>{{ $karyawan[$value->leader] }}</td>
                                            <td><?php if (isset($karyawan[$value->manager])){ ?>{{ $karyawan[$value->manager] }}<?php } ?>
                                            </td>
                                            <td>{{ $admin[$value->admin_p] }}</td>
                                            <td>{{ $admin[$value->admin_g] }}</td>
                                            <td>{{ $admin[$value->admin_v] }}</td>
                                            <td>{{ $admin[$value->admin_r] }}</td>
                                            <td><?php if (isset($karyawan[$value->qc])){ ?>{{ $karyawan[$value->qc] }}{{ $karyawan[$value->qc] }}<?php } ?>
                                            </td>
                                            <td><?php if (isset($karyawan[$value->dropper])){ ?>{{ $karyawan[$value->dropper] }}<?php } ?>
                                            </td>
                                            <td><?php if (isset($karyawan[$value->pengirim])){ ?>{{ $karyawan[$value->pengirim] }}<?php } ?>
                                            </td>
                                            <td>{{ $gdg[$value->id_gudang] }}</td>
                                            <td>{{ $sts[$value->status_order] }}</td>
                                        </tr>
                                        <?php } endforeach; ?>

                                        <?php foreach ($rejects as $key => $value): if ($value->kembali != 0) {
                            if ($value->terkirim == 0) {
                            $value->terkirim = 1;
                          }
                          ?>
                                        <tr>
                                            <td>{{ $value->no_kwitansi }}</td>
                                            <td>{{ tanggal($value->tanggal_terkirim) }}</td>
                                            <td>{{ tanggal($value->tanggal_return) }}</td>
                                            <td>{{ $value->nama_pemilik }}</td>
                                            <td><?php echo $value->alamat; ?></td>
                                            <td>{{ $brg[$value->id_barang]['no_sku'] }}</td>
                                            <td>{{ $brg[$value->id_barang]['nama_barang'] }}</td>
                                            <td>{{ $value->terkirim }}</td>
                                            <td>{{ $value->kembali }}</td>
                                            <td>{{ $value->harga_net }}</td>
                                            <td>{{ $value->harga_jual }}</td>
                                            <td>{{ rupiah($value->potongan) }}</td>
                                            <td>{{ rupiah($value->sub_potongan / $value->terkirim) }}</td>
                                            <td>{{ rupiah($value->kembali * ($value->harga_jual - $value->potongan - $value->sub_potongan / $value->terkirim)) }}
                                            </td>
                                            <td><?php if (isset($karyawan[$value->sales])){ ?>{{ $karyawan[$value->sales] }}<?php } ?></td>
                                            <td>{{ $karyawan[$value->pengembang] }}</td>
                                            <td>{{ $karyawan[$value->leader] }}</td>
                                            <td><?php if (isset($karyawan[$value->manager])){ ?>{{ $karyawan[$value->manager] }}<?php } ?>
                                            </td>
                                            <td>{{ $admin[$value->admin_p] }}</td>
                                            <td>{{ $admin[$value->admin_g] }}</td>
                                            <td>{{ $admin[$value->admin_v] }}</td>
                                            <td>{{ $admin[$value->admin_r] }}</td>
                                            <td>{{ $karyawan[$value->qc] }}</td>
                                            <td><?php if (isset($karyawan[$value->dropper])){ ?>{{ $karyawan[$value->dropper] }}<?php } ?>
                                            </td>
                                            <td><?php if (isset($karyawan[$value->pengirim])){ ?>{{ $karyawan[$value->pengirim] }}<?php } ?>
                                            </td>
                                            <td>{{ $gdg[$value->id_gudang] }}</td>
                                            <td>{{ $sts[$value->status_order] }}</td>
                                        </tr>
                                        <?php } endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="admin" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">

                    <div class="table-responsive">
                        <table id="examples3" class="table table-striped table-bordered no-wrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>NIK</th>
                                    <th>Nama</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($user as $key => $value): ?>
                                <tr
                                    onclick="pilihadmin('{{ $value->id }}','{{ $value->nik }}','{{ $value->name }}')">
                                    <td>{{ $value->id }}</td>
                                    <td>{{ $value->nik }}</td>
                                    <td>{{ $value->name }}</td>
                                </tr>
                                <?php endforeach; ?>
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

    <script>
        function cariadmin() {
            $('#admin').modal('show');
        }

        function pilihadmin(id, nik, nama) {
            $('#admin').modal('hide');
            document.getElementById("idadm").value = id;
            document.getElementById("adm").value = nama;
        }
    </script>
@endsection
