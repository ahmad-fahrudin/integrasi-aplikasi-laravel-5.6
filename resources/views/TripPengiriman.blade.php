@extends('template/nav')
@section('content')
    <script src="{{ asset('system/assets/ckeditor/ckeditor.js') }}"></script>
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
                                                href="https://stokis.app/?s=pengelompokan+trip+kiriman"
                                                target="_blank">Pengelompokan Trip Kiriman</a></li>
                                    </ol>
                                </nav>
                            </h4>
                            <hr>
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <label class="col-lg-3">Tanggal</label>
                                        <div class="col-lg-9">
                                            <div class="row">
                                                <div class="col-md-11">
                                                    <input type="date" id="tanggal_input" value="{{ date('d-m-Y') }}"
                                                        class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <label class="col-lg-3">No. Trip</label>
                                        <div class="col-lg-9">
                                            <div class="row">
                                                <div class="col-md-11">
                                                    <input type="text" id="no_trip"
                                                        value="TP-{{ date('ymd') . $number }}" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <label class="col-lg-3">Pilih Kategori Penjualan</label>
                                        <div class="col-lg-9">
                                            <div class="row">
                                                <div class="col-md-11">
                                                    <!--select id="kategori" class="form-control">
                                                <?php foreach ($kategori as $key => $value): ?>
                                                  <option value="{{ $value->id }}">{{ $value->nama_kategori }}</option>
                                                <?php endforeach; ?>
                                              </select-->
                                                    <select id="kategori" class="form-control">
                                                        <option>--Pilih--</option>
                                                        <option value="1">Non Insentif</option>
                                                        <option value="2">Sales Marketing</option>
                                                        <option value="3">Membership</option>
                                                        <option hidden value="4">Grosir HPP Target</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <label class="col-lg-3">Pilih Cabang</label>
                                        <div class="col-lg-9">
                                            <div class="row">
                                                <div class="col-md-11">
                                                    <?php if (Auth::user()->level == 1){ ?>
                                                    <select id="id_gudang" class="form-control">
                                                        <?php foreach ($gudang as $key => $value): ?>
                                                        <option value="{{ $value->id }}">{{ $value->nama_gudang }}
                                                        </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                    <?php }else{ ?>
                                                    <select id="id_gudang" class="form-control" readonly>
                                                        <?php foreach ($gudang as $key => $value):
                                          if ($value->id == Auth::user()->gudang) { ?>
                                                        <option value="{{ $value->id }}">{{ $value->nama_gudang }}
                                                        </option>
                                                        <?php } endforeach; ?>
                                                    </select>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <label class="col-lg-3">Pengirim</label>
                                        <div class="col-lg-9">
                                            <div class="row">
                                                <div class="col-md-11">
                                                    <div class="input-group">
                                                        <input id="driver" type="text" class="form-control"
                                                            placeholder="Pilih Driver" readonly
                                                            style="background-color:#fff">
                                                        <input id="iddrv" name="driver" type="hidden"
                                                            class="form-control">
                                                        <div class="input-group-append">
                                                            <button class="btn btn-outline-secondary" onclick="caridriver()"
                                                                type="button"><i class="fas fa-folder-open"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <label class="col-lg-3">QC</label>
                                        <div class="col-lg-9">
                                            <div class="row">
                                                <div class="col-md-11">
                                                    <div class="input-group">
                                                        <input id="qc" type="text" class="form-control"
                                                            placeholder="Pilih QC Gudang" readonly
                                                            style="background-color:#fff">
                                                        <input id="idqc" name="qc" type="hidden"
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
                                    <div hidden class="row">
                                        <label class="col-lg-2">Admin</label>
                                        <div class="col-lg-4">
                                            <div class="row">
                                                <div class="col-md-11">
                                                    <input readonly value="{{ Auth::user()->name }}" type="text"
                                                        class="form-control">
                                                    <input readonly id="id_admin" value="{{ Auth::user()->id }}"
                                                        type="hidden" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <br>

                                <div class="col-md-6">
                                    <div class="row">
                                        <label class="col-lg-6"><strong>Penjualan Barang</strong></label>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <label class="col-lg-3">No Kwitansi</label>
                                        <div class="col-lg-9">
                                            <div class="row">
                                                <div class="col-md-11">
                                                    <div class="input-group">
                                                        <input id="id_barang" type="text" class="form-control"
                                                            placeholder="Pilih kwitansi" readonly
                                                            style="background-color:#fff">
                                                        <input id="valbarang" type="hidden" class="form-control">
                                                        <div class="input-group-append">
                                                            <button id="cari_barang" class="btn btn-outline-secondary"
                                                                onclick="caribarang()" type="button"><i
                                                                    class="fas fa-folder-open"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!--div class="row">
                                    <label class="col-lg-3">No. Kwitansi</label>
                                    <div class="col-lg-9">
                                        <div class="row">
                                            <div class="col-md-12">
                                              <div class="input-group">
                                                <input id="id_barang"  type="text" class="form-control" placeholder="Ketik No. Kwitansi...">
                                                <input id="valbarang" type="hidden" class="form-control">
                                                <div class="input-group-append">
                                                    <button id="cari_barang" class="btn btn-outline-secondary" onclick="CariKwitansi()" type="button"><i class="fas fa-search"></i></button>
                                                </div>
                                              </div>
                                            </div>
                                        </div>
                                    </div>
                                  </div-->

                                    <br>
                                    <div class="row">
                                        <label class="col-lg-3">Nama</label>
                                        <div class="col-lg-9">
                                            <div class="row">
                                                <div class="col-md-11">
                                                    <input disabled id="nama_barang" name="nama_barang" type="text"
                                                        class="form-control">
                                                    <input id="id_konsumen" name="id_konsumen" type="hidden"
                                                        class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <label class="col-lg-3">Alamat</label>
                                        <div class="col-lg-9">
                                            <div class="row">
                                                <div class="col-md-11">
                                                    <input id="alamat" name="jumlah" type="text"
                                                        class="form-control" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <label class="col-lg-3">Sub Total</label>
                                        <div class="col-lg-9">
                                            <div class="row">
                                                <div class="col-md-11">
                                                    <input id="sub_total" name="jumlah" type="text"
                                                        class="form-control" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br><br>
                                    <center><button id="tambah" onclick="tambah()" class="btn btn-primary btn-lg">
                                            Tambah </button></center>
                                </div>
                            </div>

                            <br><br>
                            <br><br>
                            <hr><br>
                            <div class="table-responsive">
                                <table id="cart" class="table table-striped table-bordered no-wrap"
                                    style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No. Kwitansi</th>
                                            <th>Nama</th>
                                            <th>Alamat</th>
                                            <th>Sub Total</th>
                                            <th>Tindakan</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                            <br>
                            Nilai Penjualan : <b id="nilai_penjualan">0</b>
                            <center>
                                <button onclick="Simpan()" id="save" disabled
                                    class="btn btn-success btn-lg">Simpan</button>
                                <button onclick="CetakSuratJalan()" id="cetakkwitansi" disabled
                                    class="btn btn-warning btn-lg">Cetak Surat Jalan</button>
                            </center><br>
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
                                    <th>No. Telepon</th>
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
                                    <th>No. Telepon</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($karyawan as $value){ ?>
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
                                    <th>No. Telepon</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($karyawan as $value){ ?>
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

    <div class="modal fade" id="barang" role="dialog">
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
                                    <th>No. Kwitansi</th>
                                    <th>Nama Konsumen</th>
                                    <th>Alamat</th>
                                    <th>Sub Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($kwitansi as $key => $value):
                      if ($value->tagihan > 0){ ?>
                                <tr id="{{ $value->no_kwitansi }}"
                                    onclick="pilihbarang('{{ $value->id_tripost }}','{{ $value->no_kwitansi }}','{{ $konsumen[$value->id_konsumen]['nama'] }}','<?= $konsumen[$value->id_konsumen]['alamat'] ?>','{{ $value->tagihan }}','{{ $value->id_konsumen }}')">
                                    <td>{{ $value->no_kwitansi }}</td>
                                    <td>{{ $konsumen[$value->id_konsumen]['nama'] }}</td>
                                    <td><?= $konsumen[$value->id_konsumen]['alamat'] ?></td>
                                    <td align="right">{{ ribuan($value->tagihan) }}</td>
                                </tr>
                                <?php } endforeach; ?>
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

    <div class="modal fade" id="popup" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">

                    <div class="table-responsive">
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
        var id_barang_keluars = [];
        var id_konsumens = [];
        var sub_totals = [];
        var no_kwitansis = [];
        var key = "";

        var kw = [];

        function numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        function carisuplayer() {
            $('#suplayer').modal('show');
        }

        function pilihsuplayer(sup, id, nama, pemilik, alamat, hp) {
            $('#suplayer').modal('hide');
            document.getElementById("valsuplayer").value = sup;
            document.getElementById("id_suplayer").value = id;
            document.getElementById("nama_pemilik").value = pemilik;
            CKEDITOR.instances['konten2'].setData(alamat);
            //document.getElementById("alamat").value = alamat;
            document.getElementById("no_hp").value = hp;
        }

        function caridriver() {
            $('#drv').modal('show');
        }

        function pilihdriver(id, nama) {
            $('#drv').modal('hide');
            document.getElementById("iddrv").value = id;
            document.getElementById("driver").value = nama;
        }

        function cariqc() {
            $('#qcs').modal('show');
        }

        function pilihqc(id, nama) {
            $('#qcs').modal('hide');
            document.getElementById("idqc").value = id;
            document.getElementById("qc").value = nama;
        }

        function caribarang() {
            $('#barang').modal('show');
        }

        function pilihbarang(id_tripost, no_kwitansi, nama, alamat, tagihan, id_konsumen) {
            alamat = alamat.replace('<p>', '');
            alamat = alamat.replace('</p>', '');

            document.getElementById("id_barang").value = no_kwitansi;
            document.getElementById("valbarang").value = id_tripost;
            document.getElementById("nama_barang").value = nama;
            document.getElementById("alamat").value = alamat;
            //alert(tagihan);
            document.getElementById("sub_total").value = numberWithCommas(tagihan);
            document.getElementById("id_konsumen").value = id_konsumen;
            $('#barang').modal('hide');
        }

        function deletecart(lastRow, sub_total) {
            Swal.fire(
                'Delete this?',
                'Apakah Anda Yakin?',
                'question'
            ).then((result) => {
                if (result.value) {
                    var row = document.getElementById(lastRow);
                    row.parentNode.removeChild(row);

                    var index = kw.indexOf(no_kwitansis[lastRow]);
                    if (index !== -1) {
                        kw.splice(index, 1);
                    }

                    id_barang_keluars[lastRow] = "";
                    id_konsumens[lastRow] = "";
                    sub_totals[lastRow] = "";
                    no_kwitansis[lastRow] = "";

                    var old = document.getElementById("nilai_penjualan").innerHTML;
                    old = old.split(".").join("");
                    var temp = Number(old) - Number(sub_total);
                    document.getElementById("nilai_penjualan").innerHTML = numberWithCommas(temp);

                }
            });

        }

        function tambah() {
            var id_tripost = document.getElementById("valbarang").value;
            var no_kwitansi = document.getElementById("id_barang").value;
            var nama = document.getElementById("nama_barang").value;
            var alamat = document.getElementById("alamat").value;
            var sub_total = document.getElementById("sub_total").value;
            sub_total = sub_total.split(".").join("");
            var id_konsumen = document.getElementById("id_konsumen").value;

            if (kw.includes(no_kwitansi)) {
                Swal.fire({
                    title: 'Data Sudah Diinput',
                    icon: 'success',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Lanjutkan!'
                }).then((result) => {});
            } else {
                if (id_tripost != "") {
                    var table = document.getElementById("cart");
                    var lastRow = table.rows.length;
                    var row = table.insertRow(lastRow);
                    row.id = lastRow;

                    id_barang_keluars[lastRow] = id_tripost;
                    id_konsumens[lastRow] = id_konsumen;
                    sub_totals[lastRow] = sub_total;
                    no_kwitansis[lastRow] = no_kwitansi;

                    var cell1 = row.insertCell(0);
                    var cell2 = row.insertCell(1);
                    var cell3 = row.insertCell(2);
                    var cell4 = row.insertCell(3);
                    var cell5 = row.insertCell(4);
                    cell1.innerHTML = no_kwitansi;
                    cell2.innerHTML = nama;
                    cell3.innerHTML = alamat;
                    cell4.innerHTML = numberWithCommas(sub_total);
                    cell5.innerHTML = '<button class="btn btn-default" onclick="deletecart(' + lastRow + ',' + sub_total +
                        ')"><i class="icon-trash"></i></button>';
                    document.getElementById("valbarang").value = "";
                    document.getElementById("id_barang").value = "";
                    document.getElementById("nama_barang").value = "";
                    document.getElementById("alamat").value = "";
                    document.getElementById("sub_total").value = "";
                    document.getElementById("save").disabled = false;

                    var old = document.getElementById("nilai_penjualan").innerHTML;
                    old = old.split(".").join("");
                    var temp = Number(old) + Number(sub_total);
                    document.getElementById("nilai_penjualan").innerHTML = numberWithCommas(temp);
                    //document.getElementById(no_kwitansi).onclick = "";
                    //document.getElementById(no_kwitansi).style = "background:#8fe69b;";
                    var jj = "'" + String(no_kwitansi) + "'";
                    kw.push(no_kwitansi);

                } else {
                    alert("Isikan Terlebih Dahulu!");
                }
            }
        }

        function Simpan() {
            var tanggal_input = document.getElementById("tanggal_input").value;
            var no_trip = document.getElementById("no_trip").value;
            var kategori = document.getElementById("kategori").value;
            var id_gudang = document.getElementById("id_gudang").value;
            var driver = document.getElementById("iddrv").value;
            var admin = document.getElementById("id_admin").value;
            var qc = document.getElementById("idqc").value;

            if (tanggal_input != "" && driver != "" && qc != "") {
                var upidbarangkeluar;
                var upnokwitansi;
                var upidkonsumen;
                var upsubtotal;
                for (var i = 0; i < sub_totals.length; i++) {
                    if (Number(sub_totals[i]) > 0) {
                        upidbarangkeluar += "," + String(id_barang_keluars[i]);
                        upnokwitansi += "," + String(no_kwitansis[i]);
                        upidkonsumen += "," + String(id_konsumens[i]);
                        upsubtotal += "," + String(sub_totals[i]);
                    }
                }
                document.getElementById("save").disabled = true;
                $.post("trippost", {
                    tanggal_input: tanggal_input,
                    kategori: kategori,
                    id_gudang: id_gudang,
                    driver: driver,
                    qc: qc,
                    admin: admin,
                    id_barang_keluar: upidbarangkeluar,
                    no_kwitansi: upnokwitansi,
                    id_konsumen: upidkonsumen,
                    sub_total: upsubtotal,
                    _token: "{{ csrf_token() }}"
                }).done(function(data, textStatus, jqXHR) {
                    key = data;
                    Swal.fire({
                        title: 'Berhasil',
                        icon: 'success',
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Lanjutkan!'
                    }).then((result) => {
                        document.getElementById("save").disabled = true;
                        document.getElementById("cetakkwitansi").disabled = false;
                    });
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    alert(textStatus);
                });
            } else {
                alert("Isi dahulu semuanya");
            }

        }

        function CetakSuratJalan() {
            window.open("tripsurat" + '/' + key);
        }

        function CetakKwitansi() {
            window.open("tripkwitansi" + '/' + key);
        }

        function CariKwitansi() {
            console.log(kw);
            var v = document.getElementById("id_barang").value;
            if (kw.includes(v)) {
                Swal.fire({
                    title: 'Data Sudah Diinput',
                    icon: 'success',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Lanjutkan!'
                }).then((result) => {});
            } else {
                $.ajax({
                    url: 'searchkwitansi/' + v,
                    type: 'get',
                    dataType: 'json',
                    async: false,
                    success: function(response) {
                        if (response.length > 0) {
                            document.getElementById("id_barang").value = response[0]['no_kwitansi']; //
                            document.getElementById("valbarang").value = response[0]['id_tripost']; //
                            document.getElementById("nama_barang").value = response[1][0]['nama_pemilik'];
                            var alamat = response[1][0]['alamat'];
                            alamat = alamat.replace('<p>', '');
                            alamat = alamat.replace('</p>', '');
                            document.getElementById("alamat").value = alamat;
                            document.getElementById("sub_total").value = numberWithCommas(response[0][
                                'tagihan'
                            ]); //
                            document.getElementById("id_konsumen").value = response[0]['id_konsumen']; //
                        } else {
                            Swal.fire({
                                title: 'Data Tidak Ada',
                                icon: 'success',
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Lanjutkan!'
                            }).then((result) => {});
                        }

                    }
                });
            }
        }
    </script>
@endsection
