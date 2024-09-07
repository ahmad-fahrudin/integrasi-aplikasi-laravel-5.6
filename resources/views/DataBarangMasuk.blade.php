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
                                        <li class="breadcrumb-item text-muted" aria-current="page">Gudang > Barang Masuk > <a
                                                href="https://stokis.app/?s=daftar+barang+masuk+dari+pembelian"
                                                target="_blank">Daftar Barang Masuk</a></li>
                                    </ol>
                                </nav>
                            </h4>
                            <hr>
                            <div style="border:2px dashed #eee;border-radius:20px; padding:20px; backgroud:#f5f5f5">
                                <p><strong>Filter Berdasarkan</strong></p>
                                <div class="form-group">
                                    <form name="form1" action="{{ url('barangmasuk') }}" method="post"
                                        enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <div class="row">
                                            <label class="col-lg-1">Tanggal Masuk</label>
                                            <div class="col-lg-2">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <input onchange="change()" name="date_from" type="date"
                                                            class="form-control" <?php if (isset($date_from)): ?>
                                                            value="{{ $date_from }}" <?php endif; ?>>
                                                    </div>
                                                </div>
                                            </div>
                                            <label class="col-lg-0.5">&emsp;s/d&emsp;</label>
                                            <div class="col-lg-2">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <input onchange="change()" name="date_to" type="date"
                                                            class="form-control" <?php if (isset($date_to)): ?>
                                                            value="{{ $date_to }}" <?php endif; ?>>
                                                    </div>
                                                </div>
                                            </div>
                                            <label class="col-lg-1">Pengorder</label>
                                            <div class="col-lg-4">
                                                <div class="row">
                                                    <div class="col-md-10">
                                                        <div class="input-group">
                                                            <input id="id_driver" <?php if (isset($id_driver)): ?>
                                                                value="{{ $val_driver[$id_driver] }}" <?php endif; ?>
                                                                type="text" class="form-control"
                                                                placeholder="Pilih Pengorder" readonly
                                                                style="background:#fff">
                                                            <input id="valdriver" name="driver" <?php if (isset($id_driver)): ?>
                                                                value="{{ $id_driver }}" <?php endif; ?>
                                                                type="hidden" class="form-control">
                                                            <div class="input-group-append">
                                                                <button class="btn btn-outline-secondary"
                                                                    onclick="caridriver()" type="button"><i
                                                                        class="fas fa-folder-open"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-lg-1">Supplier</label>
                                        <div class="col-lg-4">
                                            <div class="row">
                                                <div class="col-md-11">
                                                    <div class="input-group">
                                                        <input id="id_suplayer" <?php if (isset($id_suplayer)): ?>
                                                            value="{{ $val_suplayer[$id_suplayer] }}" <?php endif; ?>
                                                            type="text" class="form-control" placeholder="Pilih Supplier"
                                                            readonly style="background:#fff">
                                                        <input id="valsuplayer" name="suplayer" <?php if (isset($id_suplayer)): ?>
                                                            value="{{ $id_suplayer }}" <?php endif; ?> type="hidden"
                                                            class="form-control">
                                                        <div class="input-group-append">
                                                            <button class="btn btn-outline-secondary"
                                                                onclick="carisuplayer()" type="button"><i
                                                                    class="fas fa-folder-open"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <label
                                            class="col-lg-0.5">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&emsp;</label>
                                        <label class="col-lg-1">QC Penerima</label>
                                        <div class="col-lg-4">
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <div class="input-group">
                                                        <input id="id_qc" type="text" <?php if (isset($id_qc)): ?>
                                                            value="{{ $val_qc[$id_qc] }}" <?php endif; ?>
                                                            class="form-control" placeholder="Pilih QC Gudang" readonly
                                                            style="background:#fff">
                                                        <input id="valqc" name="qc" <?php if (isset($id_qc)): ?>
                                                            value="{{ $id_qc }}" <?php endif; ?> type="hidden"
                                                            class="form-control">
                                                        <div class="input-group-append">
                                                            <button class="btn btn-outline-secondary" onclick="cariqc()"
                                                                type="button"><i class="fas fa-folder-open"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <label class="col-lg-1">Nama Barang</label>
                                        <div class="col-lg-4">
                                            <div class="row">
                                                <div class="col-md-11">
                                                    <div class="input-group">
                                                        <input onkeypress="change()" id="nama_barang" maxlength="40"
                                                            name="nama_barang" <?php if (isset($nama_barang)): ?>
                                                            value="{{ $nama_barang }}" <?php endif; ?>
                                                            type="text" class="form-control"
                                                            placeholder="Ketik nama barang...">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <br>
                                <div class="form-group">
                                    <div class="col-lg-12">
                                        <center><button disabled id="filter" class="btn btn-success btn-lg">Filter
                                                Data</button></center>
                                    </div>
                                </div>
                                </form>
                            </div>
                            <hr><br>
                            <div class="table-responsive">
                                <table id="example" class="table table-striped table-bordered no-wrap"
                                    style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No Faktur</th>
                                            <th>Tanggal Masuk</th>
                                            <th>Suplayer</th>
                                            <th>Alamat</th>
                                            <th>No. SKU</th>
                                            <th>Item No.</th>
                                            <th>Nama Barang</th>
                                            <th>Jumlah</th>
                                            <th>Pengorder</th>
                                            <th>QC Penerima</th>
                                            <th>Admin</th>
                                            <th>Gudang</th>
                                            <th>Kategori</th>
                                            <th>Catatan</th>
                                            <?php if (Auth::user()->level == "1"): ?>
                                            <th>Tindakan</th>
                                            <?php endif; ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($barangmasuk as $value) { ?>
                                        <tr>
                                            <td>{{ $value->no_faktur }}</td>
                                            <td>{{ tanggal($value->tgl_masuk) }}</td>
                                            <td>{{ $value->nama_pemilik }}</td>
                                            <td><?php echo $value->alamat; ?></td>
                                            <td>{{ $value->no_sku }}</td>
                                            <td>{{ $value->part_number }}</td>
                                            <td>{{ $value->nama_barang }}</td>
                                            <td>{{ ribuan($value->jumlah) }} {{ $value->satuan_pcs }}

                                                <?php if ($value->pcs_koli == 1) {
                                                    echo '';
                                                } else {
                                                    echo '( ';
                                                    echo ribuan($value->jumlah % $value->pcs_koli) . ' ' . $value->satuan_pcs . ',  ' . floor($value->jumlah / $value->pcs_koli) . ' ' . $value->satuan_koli . '';
                                                    echo ' )';
                                                } ?>

                                            </td>
                                            <td>{{ $value->driver }}</td>
                                            <td>{{ $value->qc }}</td>
                                            <td>{{ $value->admin }}</td>
                                            <td>{{ $value->nama_gudang }}</td>
                                            <td>{{ $value->kategori }}</td>
                                            <td>{{ $value->noted }}</td>
                                            <?php if (Auth::user()->level == "1"): ?>
                                            <td>
                                                <button class="btn btn-default" onclick="edit('{{ $value->id }}')"><i
                                                        class="icon-pencil"></i></button>
                                                <button class="btn btn-default"
                                                    onclick="Deleted('{{ $value->no_faktur }}','{{ $value->id }}')"><i
                                                        class="icon-trash"></i></button>
                                            </td>
                                            <?php endif; ?>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="suplayer" role="dialog">
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
                                    <th>ID Suplayer</th>
                                    <th>Nama</th>
                                    <th>Alamat</th>
                                    <th hidden>Telepon</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($suplayer as $value){ ?>
                                <tr onclick="pilihsuplayer('{{ $value->nama_pemilik }}','{{ $value->id }}')">
                                    <td>{{ $value->id_suplayer }}</td>
                                    <td>{{ $value->nama_pemilik }}</td>
                                    <td><?php echo $value->alamat; ?></td>
                                    <td hidden>{{ $value->no_hp }}</td>
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

    <div class="modal fade" id="drv" role="dialog">
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
                                    <th>NIK</th>
                                    <th>Nama</th>
                                    <th>Alamat</th>
                                    <th>Telepon</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($driver as $value){ ?>
                                <tr onclick="pilihdriver('{{ $value->id }}','{{ $value->nama }}')">
                                    <td>{{ $value->nik }}</td>
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

    <div class="modal fade" id="qcs" role="dialog">
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
                                    <th>NIK</th>
                                    <th>Nama</th>
                                    <th>Alamat</th>
                                    <th>Telepon</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($qc as $value){ ?>
                                <tr onclick="pilihqc('{{ $value->id }}','{{ $value->nama }}')">
                                    <td>{{ $value->nik }}</td>
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


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script>
        function Deleted(nama, value) {
            Swal.fire(
                'Delete ' + nama + '?',
                'Apakah Anda Yakin?',
                'question'
            ).then((result) => {
                if (result.value) {
                    location.href = 'deleteBarangMasuk/' + value;
                }
            });

        }

        function change() {
            var empt = document.forms["form1"]["date_from"].value;
            var empt2 = document.forms["form1"]["date_to"].value;
            var emp3 = document.getElementById("nama_barang").value;
            if ((empt != "" && empt2 != "") || emp3 != "") {
                document.getElementById("filter").disabled = false;
            }
        }

        function carisuplayer() {
            $('#suplayer').modal('show');
        }

        function caridriver() {
            $('#drv').modal('show');
        }

        function cariqc() {
            $('#qcs').modal('show');
        }

        function pilihsuplayer(usaha, id) {
            document.getElementById("filter").disabled = false;
            $('#suplayer').modal('hide');
            document.getElementById("valsuplayer").value = id;
            document.getElementById("id_suplayer").value = usaha;
        }

        function pilihdriver(id, nama) {
            document.getElementById("filter").disabled = false;
            $('#drv').modal('hide');
            document.getElementById("id_driver").value = nama;
            document.getElementById("valdriver").value = id;
        }

        function pilihqc(id, nama) {
            document.getElementById("filter").disabled = false;
            $('#qcs').modal('hide');
            document.getElementById("valqc").value = id;
            document.getElementById("id_qc").value = nama;
        }

        function edit(value) {
            location.href = 'editBarangMasuk/' + value;
        }
    </script>
@endsection
