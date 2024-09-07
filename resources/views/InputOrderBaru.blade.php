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
                                        <li class="breadcrumb-item text-muted" aria-current="page">Pemasaran > <a
                                                href="https://stokis.app/?s=cara+input+order+penjualan"
                                                target="_blank">Taking Order (Input Pre Order)</a></li>
                                    </ol>
                                </nav>
                            </h4>
                            <hr>
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <label class="col-lg-3">No. Kwitansi</label>
                                        <div class="col-lg-8">
                                            <div class="row">
                                                <div class="col-md-11">
                                                    <?php date_default_timezone_set('Asia/Jakarta'); ?>
                                                    <input type="text" id="no_kwitansi"
                                                        value="{{ 'GR-' . date('ymd') . $number }}" readonly
                                                        class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <label class="col-lg-3">Tanggal Order</label>
                                        <div class="col-lg-8">
                                            <div class="row">
                                                <div class="col-md-11">
                                                    <input type="date" id="tanggal_order" value="{{ date('Y-m-d') }}"
                                                        readonly class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <label class="col-lg-3">Sales</label>
                                        <div class="col-lg-8">
                                            <div class="row">
                                                <div class="col-md-11">
                                                    <div class="input-group">
                                                        <input id="id_sales" type="hidden" class="form-control">
                                                        <input id="valsales" type="text" class="form-control"
                                                            placeholder="Pilih Nama Sales" readonly
                                                            style="background:#ffff">
                                                        <div class="input-group-append">
                                                            <button class="btn btn-outline-secondary" onclick="carisales()"
                                                                type="button"><i class="fas fa-folder-open"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>



                                    <div hidden class="row">
                                        <label class="col-lg-3">Status Barang</label>
                                        <div class="col-lg-8">
                                            <div class="row">
                                                <div class="col-md-11">
                                                    <input type="text" id="status_barang" value="order" readonly
                                                        class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">

                                    <br>
                                    <div class="row">
                                        <label class="col-lg-3">Nama Cabang</label>
                                        <div class="col-lg-8">
                                            <div class="row">
                                                <div class="col-md-11">
                                                    <select id="id_gudang" class="form-control">
                                                        <?php foreach ($gudang as $value): ?>
                                                        <option value="{{ $value->id }}">{{ $value->nama_gudang }}
                                                        </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <label class="col-lg-3">Status Order</label>
                                        <div class="col-lg-8">
                                            <div class="row">
                                                <div class="col-md-11">
                                                    <select id="status_order" name="kategori" class="form-control">
                                                        <?php if (Auth::user()->level == "5"){ ?>
                                                        <?php foreach ($status_order as $value): if ($value->id == "1") { ?>
                                                        <option value="{{ $value->id }}">{{ $value->nama_status }}
                                                        </option>
                                                        <?php } endforeach; ?>
                                                        <?php }else{ ?>
                                                        <?php foreach ($status_order as $value): if ($value->id != "6") { ?>
                                                        <option value="{{ $value->id }}">{{ $value->nama_status }}
                                                        </option>
                                                        <?php } endforeach; } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <label class="col-lg-3">Catatan</label>
                                        <div class="col-lg-8">
                                            <div class="row">
                                                <div class="col-md-11">

                                                    <input id="ket_tmbhn" type="text" maxlength="50" class="form-control"
                                                        placeholder="Keterangan (opsional)">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div hidden class="row">
                                        <label class="col-lg-2">Leader</label>
                                        <div class="col-lg-4">
                                            <div class="row">
                                                <div class="col-md-11">
                                                    <div class="input-group">
                                                        <input id="id_leader" type="hidden" class="form-control">
                                                        <input id="valleader" type="text" readonly
                                                            class="form-control">
                                                        <!--div class="input-group-append">
                                            <button class="btn btn-outline-secondary" onclick="carileader()" type="button"><i class="fas fa-search"></i></button>
                                        </div-->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <label class="col-lg-2">Manager</label>
                                        <div class="col-lg-4">
                                            <div class="row">
                                                <div class="col-md-11">

                                                    <div class="input-group">
                                                        <input id="id_manager" type="hidden" class="form-control">
                                                        <input id="valmanager" type="text" readonly
                                                            class="form-control">
                                                        <!--div class="input-group-append">
                                            <button class="btn btn-outline-secondary" onclick="carimanager()" type="button"><i class="fas fa-search"></i></button>
                                        </div-->
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div hidden class="row">
                                        <label class="col-lg-2">Admin(P)</label>
                                        <div class="col-lg-4">
                                            <div class="row">
                                                <div class="col-md-11">
                                                    <input type="text" value="{{ Auth::user()->username }}" readonly
                                                        class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <br>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <label class="col-lg-6"><strong>Data Member</strong></label>
                                    </div>

                                    <div class="row" hidden>
                                        <label class="col-lg-3">Kategori</label>
                                        <div class="col-lg-8">
                                            <div class="row">
                                                <div class="col-md-11">
                                                    <select id="kategori" onchange="createkonsumen()" name="kategori"
                                                        class="form-control">
                                                        <option> -- Pilih -- </option>
                                                        <?php
                                        if (Auth::user()->level == "5") {
                                          foreach ($kategori as $value) {
                                            if ($value->id == "1") {
                                              echo '<option value="'.$value->id.'">'.$value->nama_kategori.'</option>';
                                            }
                                          }
                                        }elseif (Auth::user()->gudang == "1") {
                                          foreach ($kategori as $value): ?>
                                                        <option value="{{ $value->id }}">{{ $value->nama_kategori }}
                                                        </option>
                                                        <?php endforeach;
                                        }else{
                                          foreach ($kategori as $value) {
                                            if ($value->id == Auth::user()->gudang) {
                                              echo '<option value="'.$value->id.'">'.$value->nama_kategori.'</option>';
                                            }
                                          }
                                        } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <label class="col-lg-3">ID Member</label>
                                        <div class="col-lg-8">
                                            <div class="row">
                                                <div class="col-md-11">
                                                    <div class="input-group">
                                                        <input id="val_konsumen" type="text" class="form-control"
                                                            placeholder="Pilih Member" readonly style="background:#ffff">
                                                        <input id="id_konsumen" type="hidden" class="form-control">
                                                        <div class="input-group-append">
                                                            <button class="btn btn-outline-secondary"
                                                                onclick="carikonsumen()" type="button"><i
                                                                    class="fas fa-folder-open"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <br>
                                    <div class="row">
                                        <label class="col-lg-3">Nama</label>
                                        <div class="col-lg-8">
                                            <div class="row">
                                                <div class="col-md-11">
                                                    <div class="input-group">
                                                        <input id="nama_pemilik" type="text" class="form-control"
                                                            readonly>
                                                        <div class="input-group-append">
                                                            <button class="btn btn-outline-secondary" type="button"><a
                                                                    href="{{ url('inputkonsumen') }}" target="_blank"><i
                                                                        class="fas fa-plus"></i></a></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <label class="col-lg-3">Alamat</label>
                                        <div class="col-lg-8">
                                            <div class="row">
                                                <div class="col-md-11">
                                                    <p class="form-control1" id="alamat"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div hidden class="row">
                                        <label class="col-lg-3">No. HP</label>
                                        <div class="col-lg-8">
                                            <div class="row">
                                                <div class="col-md-11">
                                                    <input id="no_hp" readonly type="text" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <label class="col-lg-3">Status Member</label>
                                        <div class="col-lg-8">
                                            <div class="row">
                                                <div class="col-md-11">
                                                    <input readonly type="text" class="form-control1"
                                                        id="status_member"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <label class="col-lg-3">Pengembang</label>
                                        <div class="col-lg-8">
                                            <div class="row">
                                                <div class="col-md-11">
                                                    <div class="input-group">
                                                        <input id="id_pengembang" type="hidden" class="form-control">
                                                        <input id="valpengembang" type="text" readonly
                                                            class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                </div>

                                <div class="col-md-6">
                                    <div class="row">
                                        <label class="col-lg-6"><strong>Detail Barang</strong></label>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <label class="col-lg-3">No. SKU</label>
                                        <div class="col-lg-8">
                                            <div class="row">
                                                <div class="col-md-11">
                                                    <div class="input-group">
                                                        <input id="val_barang" type="text" class="form-control"
                                                            placeholder="Pilih Barang" readonly style="background:#ffff">
                                                        <input id="id_barang" type="hidden" class="form-control">
                                                        <div class="input-group-append">
                                                            <button class="btn btn-outline-secondary"
                                                                onclick="caribarang()" type="button"><i
                                                                    class="fas fa-folder-open"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <label class="col-lg-3">Nama Barang</label>
                                        <div class="col-lg-8">
                                            <div class="row">
                                                <div class="col-md-11">
                                                    <input type="text" readonly id="nama_barang" class="form-control">
                                                    <input type="hidden" readonly id="pcs_koli" name="pcs_koli"
                                                        class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <label class="col-lg-3">Harga Net</label>
                                        <div class="col-lg-8">
                                            <div class="row">
                                                <div class="col-md-11">
                                                    <input type="text" readonly id="harga" class="form-control"
                                                        data-a-sign="" value="0" data-a-dec="," data-a-pad=false
                                                        data-a-sep=".">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <label class="col-lg-3">Rekomendasi Harga</label>
                                        <div class="col-lg-8">
                                            <div class="row">
                                                <div class="col-md-11">
                                                    <input type="text" readonly id="cekharga" class="form-control"
                                                        data-a-sign="" value="0" data-a-dec="," data-a-pad=false
                                                        data-a-sep=".">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <label class="col-lg-3">Harga Jual</label>
                                        <div class="col-lg-8">
                                            <div class="row">
                                                <div class="col-md-11">
                                                    <input id="harga_jual" class="form-control" data-a-sign=""
                                                        value="0" data-a-dec="," data-a-pad=false data-a-sep=".">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <label class="col-lg-3">Satuan</label>
                                        <div class="col-lg-3">
                                            <div class="row">
                                                <div class="col-md-11">
                                                    <select id="satuan" name="satuan" class="form-control">
                                                        <option value='Pcs'>Pcs</option>
                                                        <option value='Kolian'>Kolian</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>

                                    <div class="row">
                                        <label class="col-lg-3">Jumlah Order</label>
                                        <div class="col-lg-3">
                                            <div class="row">
                                                <div class="col-md-11">
                                                    <input type="number" id="order" onchange="cekpotongan()"
                                                        class="form-control" placeholder="Qty">
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <br>
                                    <div id="divpotonganpromo" class="row" hidden>
                                        <label class="col-lg-3">Potongan Promo (Per Pcs)</label>
                                        <div class="col-lg-8">
                                            <div class="row">
                                                <div class="col-md-11">
                                                    <input type="text" id="potonganpromo" readonly value="0"
                                                        class="form-control" value="0" data-a-sign=""
                                                        value="0" data-a-dec="," data-a-pad=false data-a-sep=".">
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <br>
                                    <div id="divpotongan" class="row" hidden>
                                        <label class="col-lg-3">Potongan Promo (Per Pcs)</label>
                                        <div class="col-lg-3">
                                            <div class="row">
                                                <div class="col-md-11">
                                                    <input type="text" id="potongan" readonly value="0"
                                                        class="form-control" value="0">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br><br>
                                    <center><button class="btn btn-primary btn-lg" onclick="Tambah()"> Tambahkan </button>
                                    </center>
                                    <br>
                                </div>
                            </div>

                            <br>
                            <hr>
                            <div class="table-responsive">
                                <table id="cart" class="table table-striped table-bordered no-wrap"
                                    style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No. SKU</th>
                                            <th>Nama Barang</th>
                                            <th>Jumlah Order</th>
                                            <th>Harga Jual</th>
                                            <th>Potongan</th>
                                            <th>Jumlah Harga</th>
                                            <th>Tindakan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="5">
                                                <center>Total Bayar</center>
                                            </td>
                                            <td colspan="2">
                                                <center>
                                                    <p id="total_bayar">0</p>
                                                </center>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <br>
                            <center>
                                <button class="btn btn-success btn-lg" id="save" disabled
                                    onclick="Simpan()">Simpan</button>

                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalkonsumen" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">

                    <div class="table-responsive">
                        <table id="examples1" class="table table-striped table-bordered no-wrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th hidden>ID Member</th>
                                    <th>Nama Pemilik</th>
                                    <th>Alamat</th>
                                    <th>No HP</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pelanggan as $key => $value): ?>
                                <tr
                                    onclick="pilihkonsumen('{{ $value->id }}','{{ $value->id_konsumen }}','{{ $value->nama_pemilik }}','{{ $value->alamat }}','{{ $value->no_hp }}','{{ $value->nama }}','{{ $value->pengembang }}','{{ $value->nama_leader }}','{{ $value->leader }}','{{ $value->kota }}','{{ $value->kategori }}','{{ $value->jenis_konsumen }}','{{ $value->manager }}')">
                                    <td hidden>{{ $value->id_konsumen }}</td>
                                    <td>{{ $value->nama_pemilik }}</td>
                                    <td><?php echo $value->alamat; ?></td>
                                    <td>{{ $value->no_hp }}</td>
                                    </td>
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

    <div class="modal fade" id="modalstaff" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">

                    <div class="table-responsive">
                        <table id="examples" class="table table-striped table-bordered no-wrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th hidden>ID Member</th>
                                    <th>Nama</th>
                                    <th>Alamat</th>
                                    <th>No. Telepon</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($staff as $key => $value): ?>
                                <tr
                                    onclick="pilihkonsumen('{{ $value->id }}','{{ $value->id }}','{{ $value->nama }}','{{ $value->alamat }}','{{ $value->no_hp }}','{{ $value->nama }}','{{ $value->id }}','{{ $value->nama }}','{{ $value->id }}','')">
                                    <td hidden>{{ $value->id }}</td>
                                    <td>{{ $value->nama }}</td>
                                    <td><?php echo $value->alamat; ?></td>
                                    <td>{{ $value->no_hp }}</td>
                                    </td>
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

    <div class="modal fade" id="modalsales" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">

                    <div class="table-responsive">
                        <table id="examples6" class="table table-striped table-bordered no-wrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th hidden>NIK</th>
                                    <th>Nama</th>
                                    <th>Alamat</th>
                                    <th>No. Telepon</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($sales as $value){ ?>
                                <tr onclick="pilihsales('{{ $value->id }}','{{ $value->nama }}')">
                                    <td hidden>{{ $value->nik }}</td>
                                    <td>{{ $value->nama }}</td>
                                    <td><?php echo $value->alamat; ?></td>
                                    <td>{{ $value->no_hp }}</td>
                                </tr>
                                <?php } ?>
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

    <div class="modal fade" id="modalpengembang" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">

                    <div class="table-responsive">
                        <table id="examples2" class="table table-striped table-bordered no-wrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th hidden>NIK</th>
                                    <th>Nama</th>
                                    <th>Alamat</th>
                                    <th>No. Telepon</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pengembang as $value){ ?>
                                <tr onclick="pilihpengembang('{{ $value->id }}','{{ $value->nama }}')">
                                    <td hidden>{{ $value->nik }}</td>
                                    <td>{{ $value->nama }}</td>
                                    <td><?php echo $value->alamat; ?></td>
                                    <td>{{ $value->no_hp }}</td>
                                </tr>
                                <?php } ?>
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

    <div class="modal fade" id="modalleader" role="dialog">
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
                                    <th hidden>NIK</th>
                                    <th>Nama</th>
                                    <th>Alamat</th>
                                    <th>No. Telepon</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($leader as $value){ ?>
                                <tr onclick="pilihleader('{{ $value->id }}','{{ $value->nama }}')">
                                    <td hidden>{{ $value->nik }}</td>
                                    <td>{{ $value->nama }}</td>
                                    <td><?php echo $value->alamat; ?></td>
                                    <td>{{ $value->no_hp }}</td>
                                </tr>
                                <?php } ?>
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

    <div class="modal fade" id="modelbarang" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">

                    <div class="table-responsive">
                        <table id="examples5" class="table table-striped table-bordered no-wrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No. SKU</th>
                                    <th>Nama Barang</th>
                                    <th>Item No.</th>
                                    <th>Isi Kolian</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($barang as $value){ ?>
                                <tr
                                    onclick="pilihbarang('{{ $value->id }}','{{ $value->no_sku }}','{{ $value->nama_barang }}','{{ $value->harga }}','{{ $value->harga_hp }}'
                                                          ,'{{ $value->qty1 }}','{{ $value->pot1 }}','{{ $value->qty2 }}','{{ $value->pot2 }}','{{ $value->qty3 }}','{{ $value->pot3 }}','{{ $value->label }}','{{ $value->harga_hpp }}','{{ $value->harga_reseller }}','{{ $value->harga_agen }}','{{ $value->harga_retail }}','{{ $value->pcs_koli }}')">
                                    <td>{{ $value->no_sku }}</td>
                                    <td>{{ $value->nama_barang }}</td>
                                    <td>{{ $value->part_number }}</td>
                                    <td>{{ $value->pcs_koli }}</td>
                                </tr>
                                <?php } ?>
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

    <div class="modal fade" id="editing" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-3">
                            <label>Jumlah Order</label>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="number" id="edorder" class="form-control">
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-3">
                            <label>Harga Jual</label>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="number" id="edhargajual" class="form-control">
                                <input type="hidden" id="edpotongan" class="form-control">
                                <input type="hidden" id="edid" class="form-control">
                            </div>
                        </div>
                    </div>
                    <br>

                    <center><button onclick="save()" class="btn btn-primary btn-lg">Update</button></center>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script>
        var cek_Status_konsumen = "";
        const status_konsumen_member = ["None", "Retail", "Reseller", "Agen", "Distributor", "Pengembang"];

        new AutoNumeric('#harga_jual', "euroPos");
        new AutoNumeric('#harga', "euroPos");
        new AutoNumeric('#cekharga', "euroPos");
        new AutoNumeric('#potonganpromo', "euroPos");
        //new AutoNumeric('#potongan', "euroPos");
        var total_bayar = 0;
        var tempbarang = [];
        var tempjumlah = [];
        var tempharga_jual = [];
        var temppotongan = [];
        var temppotonganpromo = [];
        var tempsub_total = [];
        var tempharga_net = [];

        var prv = "<?= allprevillage() ?>";
        var qty1 = 0;
        var pot1 = 0;
        var qty2 = 0;
        var pot2 = 0;
        var qty3 = 0;
        var pot3 = 0;

        function numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        function pilihbarang(barang, id, nama, harga, harga_hp, qty1v, pot1v, qty2v, pot2v, qty3v, pot3v, label, harga_hpp,
            harga_reseller, harga_agen, harga_retail, pcs_koli) {
            $('#modelbarang').modal('hide');
            document.getElementById("val_barang").value = id;
            document.getElementById("id_barang").value = barang;
            document.getElementById("nama_barang").value = nama;

            if (cek_Status_konsumen == "Pengembang") {
                AutoNumeric.getAutoNumericElement('#harga').set(harga);
                AutoNumeric.getAutoNumericElement('#cekharga').set(harga);
            } else if (cek_Status_konsumen == "Distributor") {
                AutoNumeric.getAutoNumericElement('#harga').set(harga);
                AutoNumeric.getAutoNumericElement('#cekharga').set(harga);
            } else if (cek_Status_konsumen == "Agen") {
                AutoNumeric.getAutoNumericElement('#harga').set(harga);
                AutoNumeric.getAutoNumericElement('#cekharga').set(harga_agen);
            } else if (cek_Status_konsumen == "Reseller") {
                AutoNumeric.getAutoNumericElement('#harga').set(harga);
                AutoNumeric.getAutoNumericElement('#cekharga').set(harga_reseller);
            } else {
                AutoNumeric.getAutoNumericElement('#harga').set(harga);
                AutoNumeric.getAutoNumericElement('#cekharga').set(harga_retail);
            }

            if (label == 1 || label == "1") {
                qty1 = qty1v;
                qty2 = qty2v;
                qty3 = qty3v;
                pot1 = pot1v;
                pot2 = pot2v;
                pot3 = pot3v;
            } else {
                qty1 = 0;
                qty2 = 0;
                qty3 = 0;
                pot1 = 0;
                pot2 = 0;
                pot3 = 0;
                document.getElementById("potongan").value = 0;
                document.getElementById("divpotongan").hidden = "true";
            }
            document.getElementById("pcs_koli").value = pcs_koli;
            var gd = document.getElementById("id_gudang").value;
            var ck_prv = prv.split(",");
            var cek_previllage = false;
            for (var i = 0; i < ck_prv.length; i++) {
                if (Number(gd) == ck_prv[i]) {
                    cek_previllage = true;
                }
            }
            if (cek_previllage) {
                //document.getElementById("harga").value = numberWithCommas(harga_hp);
            } else {
                //document.getElementById("harga").value = numberWithCommas(harga);
            }

            $.ajax({
                url: 'cekpotonganperusahaan/' + barang,
                type: 'get',
                dataType: 'json',
                async: false,
                success: function(response) {
                    if (response.length > 0) {
                        document.getElementById("divpotonganpromo").hidden = false;
                        AutoNumeric.getAutoNumericElement('#potonganpromo').set(response[0]['persentase']);
                    } else {
                        document.getElementById("divpotonganpromo").hidden = true;
                        AutoNumeric.getAutoNumericElement('#potonganpromo').set(0);
                    }
                }
            });

        }

        function pilihkonsumen(id, id_konsumen, nama_pemilik, alamat, no_hp, nama, pengembang, nama_leader, leader, kota,
            kategori, jenis_konsumen, manager) {
            $('#modalkonsumen').modal('hide');
            $('#modalstaff').modal('hide');
            document.getElementById("val_konsumen").value = id_konsumen;
            document.getElementById("id_konsumen").value = id;
            document.getElementById("nama_pemilik").value = nama_pemilik;
            document.getElementById("alamat").innerHTML = alamat;
            document.getElementById("no_hp").value = no_hp;
            document.getElementById("valpengembang").value = nama;
            document.getElementById("id_pengembang").value = pengembang;
            document.getElementById("valleader").value = nama_leader;
            document.getElementById("id_leader").value = leader;
            var id_gudang = document.getElementById("id_gudang").value;
            if (leader == "") {

                Swal.fire({
                    title: 'Leader untuk konsumen belum disesuaikan !',
                    icon: 'success',
                });
            }

            cek_Status_konsumen = status_konsumen_member[jenis_konsumen];
            document.getElementById("status_member").value = status_konsumen_member[jenis_konsumen];



            var st = document.getElementById("status_order").value;
            if (st == "2" || st == "3") {
                document.getElementById("id_manager").value = leader;
                document.getElementById("valmanager").value = nama_leader;
            } else {
                if (manager == "") {
                    $.ajax({
                        url: 'carimanager/' + kota,
                        type: 'get',
                        dataType: 'json',
                        async: false,
                        success: function(response) {
                            if (response.length > 0) {
                                document.getElementById("id_manager").value = response[0]['manager'];
                                document.getElementById("valmanager").value = response[0]['nama'];
                            } else {
                                document.getElementById("id_manager").value = null;
                                document.getElementById("valmanager").value = null;
                            }
                        }
                    });
                } else {
                    $.ajax({
                        url: 'carimanagerbyid/' + manager,
                        type: 'get',
                        dataType: 'json',
                        async: false,
                        success: function(response) {
                            document.getElementById("id_manager").value = manager;
                            document.getElementById("valmanager").value = response[0]['nama'];
                        }
                    });
                }

            }

        }

        function pilihsales(id, nama) {
            $('#modalsales').modal('hide');
            document.getElementById("valsales").value = nama;
            document.getElementById("id_sales").value = id;
        }

        function pilihpengembang(id, nama) {
            $('#modalpengembang').modal('hide');
            document.getElementById("valpengembang").value = nama;
            document.getElementById("id_pengembang").value = id;
        }

        function pilihleader(id, nama) {
            $('#modalleader').modal('hide');
            document.getElementById("valleader").value = nama;
            document.getElementById("id_leader").value = id;
        }


        function cekpotongan() {
            var cek = document.getElementById("order").value;
            var el = document.getElementById("divpotongan");
            var gd = document.getElementById("id_gudang").value;

            var ck_prv = prv.split(",");
            var cek_previllage = false;
            for (var i = 0; i < ck_prv.length; i++) {
                if (Number(gd) == ck_prv[i]) {
                    cek_previllage = true;
                }
            }
            if (cek_previllage) {
                el.hidden = true;
            } else {
                if (qty1 != 0 && Number(cek) >= qty1) {
                    if (Number(cek) >= Number(qty3)) {
                        document.getElementById("potongan").value = numberWithCommas(pot3);
                    } else if (Number(cek) >= Number(qty2)) {
                        document.getElementById("potongan").value = numberWithCommas(pot2);
                    } else if (Number(cek) >= Number(qty1)) {
                        document.getElementById("potongan").value = numberWithCommas(pot1);
                    } else {
                        document.getElementById("potongan").value = 0;
                    }
                    el.hidden = false;
                } else {
                    document.getElementById("potongan").value = 0;
                    el.hidden = true;
                }
            }
        }

        function carikonsumen() {
            var status = document.getElementById("status_order").value;
            if (status == "2" || status == "3") {
                $('#modalstaff').modal('show');
            } else {
                $('#modalkonsumen').modal('show');
            }
        }

        function carisales() {
            $('#modalsales').modal('show');
        }

        function caripengembang() {
            $('#modalpengembang').modal('show');
        }

        function carileader() {
            $('#modalleader').modal('show');
        }

        function caribarang() {
            $('#modelbarang').modal('show');
        }

        function Tambah() {
            var no_sku = document.getElementById("val_barang").value;
            var nama_barang = document.getElementById("nama_barang").value;
            var order = document.getElementById("order").value;
            var kolian = document.getElementById("pcs_koli").value;
            if ($('#satuan').val() == "Pcs") {
                var orderan = order;
            } else {
                var orderan = order * kolian;
            };
            var harga_jual = document.getElementById("harga_jual").value;
            harga_jual = harga_jual.split(".").join("");
            var potongan = document.getElementById("potongan").value;
            var id_barang = document.getElementById("id_barang").value;
            var harga_net = document.getElementById("harga").value;
            harga_net = harga_net.split(".").join("");
            potongan = potongan.split(".").join("");

            var potonganpromo = document.getElementById("potonganpromo").value;
            potonganpromo = potonganpromo.split(".").join("");

            var totalpotongan = Number(potonganpromo) + Number(potongan);

            if (no_sku != "" && order != "" && harga_jual != "" && potongan != "") {
                var table = document.getElementById("cart");
                var lastRow = table.rows.length - 1;
                var row = table.insertRow(lastRow);
                row.id = lastRow;

                var subtotal = orderan * (harga_jual - totalpotongan);
                tempbarang[lastRow] = id_barang;
                tempjumlah[lastRow] = orderan;
                tempharga_jual[lastRow] = harga_jual;
                temppotongan[lastRow] = totalpotongan;
                temppotonganpromo[lastRow] = potonganpromo;
                tempsub_total[lastRow] = subtotal;
                tempharga_net[lastRow] = harga_net;

                var cell1 = row.insertCell(0);
                var cell2 = row.insertCell(1);
                var cell3 = row.insertCell(2);
                var cell4 = row.insertCell(3);
                var cell5 = row.insertCell(4);
                var cell6 = row.insertCell(5);
                var cell7 = row.insertCell(6);
                cell1.innerHTML = no_sku;
                cell2.innerHTML = nama_barang;
                cell3.innerHTML = "<p id=orderan" + lastRow + ">" + orderan + "</p>";
                cell4.innerHTML = "<p id=harga_jual" + lastRow + ">" + numberWithCommas(harga_jual) + "</p>";
                cell5.innerHTML = "<p id=potongan" + lastRow + ">" + totalpotongan + "</p>";
                cell6.innerHTML = "<p id=subtotal" + lastRow + ">" + numberWithCommas(subtotal) + "</p>";
                cell7.innerHTML = '<button hidden class="btn btn-default" onclick="updatecart(' + lastRow + ',' + subtotal +
                    ',' + orderan + ',' + harga_jual + ',' + totalpotongan + ')"><i class="icon-pencil"></i></button>' +
                    '<button class="btn btn-default" onclick="deletecart(' + lastRow + ',' + subtotal +
                    ')"><i class="icon-trash"></i></button>';
                var sum = tempsub_total.reduce(function(a, b) {
                    return a + b;
                }, 0);
                document.getElementById("total_bayar").innerHTML = numberWithCommas(sum);

                document.getElementById("id_barang").value = "";
                document.getElementById("val_barang").value = "";
                document.getElementById("nama_barang").value = "";
                document.getElementById("harga").value = "";
                document.getElementById("order").value = "";
                document.getElementById("harga_jual").value = "";
                //document.getElementById("potongan").value = "";
                document.getElementById("divpotongan").hidden = "true";
                document.getElementById("save").disabled = false;

                document.getElementById("divpotonganpromo").hidden = true;
                AutoNumeric.getAutoNumericElement('#potonganpromo').set(0);


                AutoNumeric.getAutoNumericElement('#harga_jual').set(0);
                AutoNumeric.getAutoNumericElement('#potongan').set(0);
            } else {
                alert("Isi Semua Field");
            }
        }

        function updatecart(lastRow, sub, order, harga_jual, potongan) {
            document.getElementById("edorder").value = order;
            document.getElementById("edhargajual").value = harga_jual;
            document.getElementById("edpotongan").value = potongan;
            document.getElementById("edid").value = lastRow;
            $('#editing').modal('show');
        }

        /*$(document).ready(function() {
            var table = $('#examp').DataTable();
            $('#examp tbody').on('click', 'tr', function () {
                var data = table.row( this ).data();
                //alert( 'You clicked on '+data[0]+'\'s row' );
                pilihkonsumen(data_id[data[0]],data[0],data[1],data[3],data[2],data_nama[data[0]],data_pengembang[data[0]]);
            } );
        } );

        $(document).ready(function() {
            var table = $('#exampes').DataTable();
            $('#exampes tbody').on('click', 'tr', function () {
                var data = table.row( this ).data();
                //alert( 'You clicked on '+data[0]+'\'s row' );
                pilihkonsumen(data_id[data[0]],data[0],data[1],data[3],data[2],data_nama[data[0]],data_pengembang[data[0]]);
            } );
        } );*/
        //window.onload = function(){
        //createkonsumen();
        //};

        var cek = true;
        var data_id = [];
        var data_nama = [];
        var data_pengembang = [];

        function createkonsumen() {
            var kategori = document.getElementById("kategori").value;
            var status = document.getElementById("status_order").value;
            $.ajax({
                url: 'cariKaryawan/' + kategori + "/" + status,
                type: 'get',
                dataType: 'json',
                async: false,
                success: function(response) {
                    var table = $('#examp').DataTable();
                    table.clear().draw();
                    data_id = [];
                    data_nama = [];
                    data_pengembang = [];
                    if (status == "2" || status == "3") {
                        for (var i = 0; i < response.length; i++) {
                            data_id[response[i]['id']] = response[i]['id'];
                            data_nama[response[i]['id']] = response[i]['nama'];
                            data_pengembang[response[i]['id']] = response[i]['id'];

                            table.row.add([
                                response[i]['id'],
                                response[i]['nama'],
                                response[i]['no_hp'],
                                response[i]['alamat']
                            ]).draw(false);
                        }
                    } else {
                        for (var i = 0; i < response.length; i++) {
                            data_id[response[i]['id_konsumen']] = response[i]['id'];
                            data_nama[response[i]['id_konsumen']] = response[i]['nama'];
                            data_pengembang[response[i]['id_konsumen']] = response[i]['pengembang'];

                            table.row.add([
                                response[i]['id_konsumen'],
                                response[i]['nama_pemilik'],
                                response[i]['no_hp'],
                                response[i]['alamat']
                            ]).draw(false);
                        }
                    }

                    $('#barang').modal('show');
                }
            });

        }

        function save() {
            var id = document.getElementById("edid").value;
            var harga_jual = document.getElementById("edhargajual").value;
            var order = document.getElementById("edorder").value;
            var potongan = document.getElementById("edpotongan").value;

            var subtotal = order * (harga_jual - potongan);
            tempjumlah[id] = order;
            tempharga_jual[id] = harga_jual;
            temppotongan[id] = potongan;
            tempsub_total[id] = subtotal;

            document.getElementById("order" + id).innerHTML = numberWithCommas(order);
            document.getElementById("harga_jual" + id).innerHTML = numberWithCommas(harga_jual);
            //document.getElementById("potongan"+id).innerHTML = potongan;
            document.getElementById("subtotal" + id).innerHTML = numberWithCommas(subtotal);
            var sum = tempsub_total.reduce(function(a, b) {
                return a + b;
            }, 0);
            document.getElementById("total_bayar").innerHTML = numberWithCommas(sum);

            $('#editing').modal('hide');

        }

        function deletecart(lastRow, sub) {
            Swal.fire(
                'Hapus Data',
                'Apakah Anda Yakin?',
                'question'
            ).then((result) => {
                if (result.value) {
                    var old = document.getElementById("total_bayar").innerHTML;
                    old = old.split(".").join("");
                    total_bayar = Number(old) - Number(sub);
                    document.getElementById("total_bayar").innerHTML = numberWithCommas(total_bayar);
                    var row = document.getElementById(lastRow);
                    row.parentNode.removeChild(row);

                    tempbarang[lastRow] = "";
                    tempjumlah[lastRow] = "";
                    tempharga_jual[lastRow] = "";
                    temppotongan[lastRow] = "";
                    temppotonganpromo[lastRow] = "";
                    tempsub_total[lastRow] = "";
                    tempharga_net[lastRow] = "";

                }
            });
        }

        function StatusOrder() {
            var value = document.getElementById("status_order").value;
            if (value == "2" || value == "3") {
                document.getElementById("kategori").disabled = true;

                var kategori = document.getElementById("kategori").value;
                var status = document.getElementById("status_order").value;
                $.ajax({
                    url: 'cariKaryawan/' + kategori + "/" + status,
                    type: 'get',
                    dataType: 'json',
                    async: false,
                    success: function(response) {
                        var table = $('#examp').DataTable();
                        table.clear().draw();
                        data_id = [];
                        data_nama = [];
                        data_pengembang = [];
                        for (var i = 0; i < response.length; i++) {
                            data_id[response[i]['id']] = response[i]['id'];
                            data_nama[response[i]['id']] = response[i]['nama'];
                            data_pengembang[response[i]['id']] = response[i]['id'];

                            table.row.add([
                                response[i]['id'],
                                response[i]['nama'],
                                response[i]['no_hp'],
                                response[i]['alamat']
                            ]).draw(false);
                        }

                        $('#barang').modal('show');
                    }
                });

            } else {
                var kategori = document.getElementById("kategori").value;
                var status = document.getElementById("status_order").value;
                $.ajax({
                    url: 'cariKaryawan/' + kategori + "/" + status,
                    type: 'get',
                    dataType: 'json',
                    async: false,
                    success: function(response) {
                        var table = $('#examp').DataTable();
                        table.clear().draw();
                        data_id = [];
                        data_nama = [];
                        data_pengembang = [];
                        for (var i = 0; i < response.length; i++) {
                            data_id[response[i]['id']] = response[i]['id'];
                            data_nama[response[i]['id']] = response[i]['nama'];
                            data_pengembang[response[i]['id']] = response[i]['id'];
                            console.log(response[i]);
                            table.row.add([
                                response[i]['id'],
                                response[i]['nama_pemilik'],
                                response[i]['no_hp'],
                                response[i]['alamat']
                            ]).draw(false);
                        }

                        $('#barang').modal('show');
                    }
                });

                document.getElementById("kategori").disabled = false;
            }
        }

        function Cek() {
            console.log(tempjumlah);
        }

        function Simpan() {
            document.getElementById("save").disabled = true;
            var no_kwitansis = document.getElementById("no_kwitansi").value;
            var tanggal_orders = document.getElementById("tanggal_order").value;
            var status_barangs = document.getElementById("status_barang").value;
            var ket_tmbhn = document.getElementById("ket_tmbhn").value;
            var kategoris = document.getElementById("kategori").value;
            var id_konsumens = document.getElementById("id_konsumen").value;
            var id_gudangs = document.getElementById("id_gudang").value;
            var status_orders = document.getElementById("status_order").value;
            var pengembangs = document.getElementById("id_pengembang").value;
            var saless = document.getElementById("id_sales").value;
            var leaders = document.getElementById("id_leader").value;
            var managers = document.getElementById("id_manager").value;
            var total_bayars = document.getElementById("total_bayar").innerHTML;
            total_bayars = total_bayars.split(".").join("");



            console.log(id_konsumens + leaders + saless + managers);

            if (id_konsumens != "" && leaders != "" && saless != "") {

                $.post("postbarangkeluar", {
                    no_kwitansi: no_kwitansis,
                    tanggal_order: tanggal_orders,
                    status_barang: status_barangs,
                    kategori: kategoris,
                    ket_tmbhn: ket_tmbhn,
                    id_konsumen: id_konsumens,
                    id_gudang: id_gudangs,
                    status_order: status_orders,
                    pengembang: pengembangs,
                    sales: saless,
                    leader: leaders,
                    manager: managers,
                    total_bayar: total_bayars,
                    _token: "{{ csrf_token() }}"
                }).done(function(data, textStatus, jqXHR) {

                    var newkwitansi = data;

                    for (var i = 0; i < tempbarang.length; i++) {
                        if (tempjumlah[i] > 0) {
                            $.post("postdetailbarangkeluar", {
                                no_kwitansi: newkwitansi,
                                tanggal_order: tanggal_orders,
                                status_barang: status_barangs,
                                kategori: kategoris,
                                id_konsumen: id_konsumens,
                                id_gudang: id_gudangs,
                                status_order: status_orders,
                                pengembang: pengembangs,
                                sales: saless,
                                leader: leaders,
                                manager: managers,
                                total_bayar: total_bayars,
                                id_barang: tempbarang[i],
                                harga_net: tempharga_net[i],
                                jumlah: tempjumlah[i],
                                harga_jual: tempharga_jual[i],
                                potongan: temppotongan[i],
                                potonganpromo: temppotonganpromo[i],
                                sub_total: tempsub_total[i],
                                _token: "{{ csrf_token() }}"
                            }).done(function(data, textStatus, jqXHR) {

                                Swal.fire({
                                    title: 'Berhasil',
                                    icon: 'success',
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Lanjutkan!'
                                }).then((result) => {
                                    if (result.value) {
                                        document.getElementById("save").disabled = true;
                                        location.href = "{{ url('/inputorderbaru/') }}";
                                    } else {
                                        document.getElementById("save").disabled = true;
                                        location.href = "{{ url('/inputorderbaru/') }}";
                                    }
                                });
                            }).fail(function(jqXHR, textStatus, errorThrown) {
                                alert(textStatus);
                            });
                        }
                    }

                }).fail(function(jqXHR, textStatus, errorThrown) {
                    alert(textStatus);
                });

            } else {
                alert("isi semua data");
            }
        }
    </script>
@endsection
