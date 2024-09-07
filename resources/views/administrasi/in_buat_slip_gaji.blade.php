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
                              <li class="breadcrumb-item text-muted" aria-current="page">Payroll > Slip Gaji > <a href="https://stokis.app/?s=kinerja+karyawan" target="_blank">Buat Slip Gaji</a></li>
                          </ol>
                      </nav>
                    </h4>
                    <hr>

                    <br>
            
            
            <label class="section-title">BUAT SLIP GAJI</label>
            <hr>
            <div class="row">
                <div class="col-md-4">
                    <b>Periode Penggajian:</b><br>
                    Dari:
                    <input type="date" name="mulai"  class="form-control" id="mulai" readonly>
                    <br>
                    Sampai:
                    <input type="date" name="sampai"  class="form-control" id="sampai" readonly>
                    <br>
                    <b>Pilih Karyawan:</b><br><br>
                    No ID Karyawan
                    <div class="table-wrapper">
                        <div class="input-group">
                            <input type="text" id="id_karyawan" name="id_karyawan" class="form-control" placeholder="Pilih Karyawan" readonly  style="background:#fff">
                            <span class="input-group-btn">
                                <button class="btn bd bd-l-0 bg-primary tx-gray-600 text-white" type="button" onclick="CariKaryawan()"><i
                                        class="fa fa-folder"></i></button>
                            </span>
                        </div>
                    </div> 
                    <br>
                    Nama Karyawan:
                    <input type="text" name="nama_karyawan"  class="form-control" id="nama_karyawan" readonly>
                    <br>
                    Alamat:
                    <input type="text" name="alamat"  class="form-control" id="alamat" readonly>  
                    <br>
                    No. HP:
                    <input type="text" name="no_hp"  class="form-control" id="no_hp" readonly>  
                    <br>
                    No. Rekening:
                    <input type="text" name="no_rekening"  class="form-control" id="no_rekening" readonly>  
                    <br>
                    Status Pekerja:
                    <input type="text" name="status_pekerja"  class="form-control" id="status_pekerja" readonly>  
                    <br>
                    <hr>
                    <b>Periode Absensi:</b><br><br>
                    Dari:
                    <input type="date" name="mulai_absen"  class="form-control" id="mulai_absen">
                    <br>
                    Sampai:
                    <input type="date" name="sampai_absen"  class="form-control" id="sampai_absen">
                    <br>
                    <center><button class='btn btn-success btn-sm' onclick="ProsesAbsen()">Tambilkan Data Absensi</button></center>
                    <br><br>
                    Masuk:
                    <input type="text" name="masuk"  class="form-control" id="masuk" readonly> 
                    <br>
                    Sakit:
                    <input type="text" name="sakit"  class="form-control" id="sakit" readonly>  
                    <br>
                    Izin:
                    <input type="text" name="izin"  class="form-control" id="izin" readonly>  
                    <br>
                    Alfa:
                    <input type="text" name="alfa"  class="form-control" id="alfa" readonly>
                    <br>
                    Rolling:
                    <input type="text" name="rolling"  class="form-control" id="rolling" readonly> 
                    <input hidden type="text" name="libur"  class="form-control" id="libur" readonly> 
                    <br>
                    Terlambat Masuk:
                    <input type="text" name="terlambat"  class="form-control" id="terlambat" readonly>   
                    <br>
                    Pulang Cepat:
                    <input type="text" name="pulang_cepat"  class="form-control" id="pulang_cepat" readonly>
                    <br>
                    Prosentase Kinerja  
                    <input type="text" name="rata_rata_prosentase"  class="form-control" id="rata_rata_prosentase" readonly>
                    <br>
                </div>
                <div class="col-md-4">
                    Status Pembayaran:
                    <select name="status_pembayaran"  class="form-control" id="status_pembayaran" readonly>
                        <option>Pending</option>
                    </select>
                    <br>
                    Status Penggajian
                    <select name="status_penggajian"  class="form-control" id="status_penggajian">
                        <option>Harian</option>
                        <option>Borongan</option>
                        <option>Perubahan BH-HB</option>
                        <option>Peralihan 1</option>
                        <option>Peralihan 2</option>
                    </select>
                    <br>
                    <b>Pendapatan:</b><br><br>
                    Gaji Pokok:
                    <input type="text" name="gaji_pokok"  class="form-control" id="gaji_pokok" readonly>
                    <br>
                    No. ID Upah:
                    <div class="table-wrapper">
                        <div class="input-group">
                            <input type="text" id="no_id_upah" name="no_id_upah" class="form-control" placeholder="Pilih ID Upah Kinerja" readonly  style="background:#fff">
                            <span class="input-group-btn">
                                <button class="btn bd bd-l-0 bg-primary tx-gray-600 text-white" type="button" onclick="CariID()" id="crid" disabled><i
                                        class="fa fa-folder"></i></button>
                            </span>
                        </div>
                    </div>
                    <br>
                    Upah Kinerja:
                    <input type="text" name="upah_kinerja"  class="form-control" id="upah_kinerja" readonly>
                    <br>
                    Bonus Kehadiran:
                    <input type="text" name="bonus_kehadiran"  class="form-control" id="bonus_kehadiran" readonly>
                    <br>
                    Bonus Kinerja:
                    <input type="text" name="bonus_kinerja"  class="form-control" id="bonus_kinerja" readonly>
                    <br>
                    Pendapatan Lain:<br>
                    <br>
                    <div class="row">
                        <div class="col"><input type="text" maxlength="25" id="ketpendapatanlain1" placeholder="Ketik Keterangan 1" class="form-control"></div>
                        <div class="col"><input type="number" id="valpendapatanlain1" placeholder="0" class="form-control" onchange="TotalGaji();"></div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col"><input type="text" maxlength="25" id="ketpendapatanlain2" placeholder="Ketik Keterangan 2" class="form-control"></div>
                        <div class="col"><input type="number" id="valpendapatanlain2" placeholder="0" class="form-control" onchange="TotalGaji();"></div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col"><input type="text" maxlength="25" id="ketpendapatanlain3" placeholder="Ketik Keterangan 3" class="form-control"></div>
                        <div class="col"><input type="number" id="valpendapatanlain3" placeholder="0" class="form-control" onchange="TotalGaji();"></div>
                    </div>
                    <br>
                    <hr>
                    <b>Potongan:</b><br><br>
                    Potongan Gaji Pokok:
                    <input type="text" name="potongan_gaji_pokok"  class="form-control" id="potongan_gaji_pokok" readonly>
                    <br>
                    BPJS Kesehatan:
                    <input type="text" name="bpjs_kesehatan"  class="form-control" id="bpjs_kesehatan" readonly>
                    <br>
                    BPJS Ketenagakerjaan:
                    <input type="text" name="bpjs_ketenagakerjaan"  class="form-control" id="bpjs_ketenagakerjaan" readonly>
                    <br>
                    Potongan Lain:<br>
                    <br>
                    <div class="row">
                        <div class="col"><input type="text" maxlength="25" id="ketpotonganlain1" placeholder="Ketik Keterangan 1" class="form-control"></div>
                        <div class="col"><input type="number" id="valpotonganlain1" placeholder="0" class="form-control" onchange="TotalGaji();"></div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col"><input type="text" maxlength="25" id="ketpotonganlain2" placeholder="Ketik Keterangan 2" class="form-control"></div>
                        <div class="col"><input type="number" id="valpotonganlain2" placeholder="0" class="form-control" onchange="TotalGaji();"></div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col"><input type="text" maxlength="25" id="ketpotonganlain3" placeholder="Ketik Keterangan 3" class="form-control"></div>
                        <div class="col"><input type="number" id="valpotonganlain3" placeholder="0" class="form-control" onchange="TotalGaji();"></div>
                    </div>
                    <br>
                    <hr>
                    <div class="row">
                        <strong>
                    <div class="col">
                    Total Penerimaan:
                    </div>
                    <div class="col">
                    <p id="total_gaji"></p>
                    </div>
                    </strong>
                    </div>
                    <hr>
                    <center>
                    <button class="btn btn-primary btn-lg" onclick="Simpan()" id="save">&emsp;Simpan&emsp;</button>
                    <button class="btn btn-warning btn-lg" onclick="Cetak()" id="cetak">&emsp;Cetak Slip Gaji&emsp;</button>
                    </center>
                </div>
            </div>
            
            
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>


        <div class="modal fade" id="capmi" role="dialog">
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
                            <th>No ID</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th hidden>No HP</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; foreach($karyawan as $key => $value){ ?>
                        <tr onclick="Pilih('{{$value->id}}','{{$value->nama}}','{{$value->id_divisi}}','{{$value->alamat}}','{{$value->status_pekerja}}','{{$value->no_hp}}','{{$value->no_rekening}}'
                                    ,'{{$value->gaji_pokok}}','{{$value->bpjs_kesehatan}}','{{$value->bpjs_ketenagakerjaan}}')">
                            <td>{{$value->id}}</td>
                            <td>{{$value->nama}}</td>
                            <td>{{$value->alamat}}</td>
                        </tr>
                        <?php $no++; } ?>
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

        <div class="modal fade" id="sdsd" role="dialog">
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
                            <th>No ID Upah</th>
                            <th>No ID Karyawan</th>
                            <th>Status Penggajian</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; foreach($upah as $key => $value){ ?>
                        <tr onclick="PilihUpah('{{$value->no_id_upah}}','{{$value->status_penggajian}}','{{$value->mulai}}','{{$value->sampai}}','{{$value->id_karyawan}}')">
                            <td>{{$value->no_id_upah}}</td>
                            <td>{{$value->id_karyawan}}</td>
                            <td>{{$value->status_penggajian}}</td>
                        </tr>
                        <?php $no++; } ?>
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
function CariKaryawan() {
    $('#capmi').modal('show');
}

function CariID(){
    $('#sdsd').modal('show');
}

function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}
var id_post = "";
function Pilih(id, nama, id_divisi, alamat, status_pekerja, no_hp, no_rekening, gaji_pokok, bpjs_kesehatan, bpjs_ketenagakerjaan) {
    document.getElementById("id").value = id;
    document.getElementById("nama").value = nama;
    document.getElementById("alamat").value = alamat;
    document.getElementById("status_pekerja").value = status_pekerja;
    document.getElementById("no_hp").value = no_hp;
    document.getElementById("no_rekening").value = no_rekening;

    document.getElementById("gaji_pokok").value = numberWithCommas(gaji_pokok);
    document.getElementById("bpjs_kesehatan").value = numberWithCommas(bpjs_kesehatan);
    document.getElementById("bpjs_ketenagakerjaan").value = numberWithCommas(bpjs_ketenagakerjaan);

    dt3.search( id_karyawan ).draw();
    
    document.getElementById("crid").disabled = false;
    
    document.getElementById("no_id_upah").value = "";
    document.getElementById("status_penggajian").value = "";
    document.getElementById("mulai").value = "";
    document.getElementById("sampai").value = "";
    document.getElementById("upah_kinerja").value = "";
    document.getElementById("rata_rata_prosentase").value = "";
    document.getElementById("bonus_kinerja").value = 0;
    document.getElementById("masuk").value = "";
    document.getElementById("sakit").value = "";
    document.getElementById("izin").value = "";
    document.getElementById("alfa").value = "";
    document.getElementById("rolling").value = "";
    document.getElementById("libur").value = "";
    document.getElementById("terlambat").value = "";
    document.getElementById("pulang_cepat").value = "";
    document.getElementById("bonus_kehadiran").value = 0;
    document.getElementById("potongan_gaji_pokok").value = 0;
    TotalGaji();
    $('#capmi').modal('hide');
}

function ProsesAbsen(){
    var mulai_absen = document.getElementById("mulai_absen").value;
    var sampai_absen = document.getElementById("sampai_absen").value;
    var id_karyawan = document.getElementById("id_karyawan").value;
    document.getElementById("mulai").value = mulai_absen;
    document.getElementById("sampai").value = sampai_absen;
    document.getElementById("upah_kinerja").value = 0;
    document.getElementById("bonus_kehadiran").value = 0;
    document.getElementById("bonus_kinerja").value = 0;
    document.getElementById("rata_rata_prosentase").value = 0;
    
    $.ajax({
        url: '{{url("cekabsensi")}}/' + id_karyawan +"/"+mulai_absen+"/"+sampai_absen,
        type: 'get',
        dataType: 'json',
        async: false,
        success: function(response) {
            document.getElementById("masuk").value = response['masuk'];
            document.getElementById("sakit").value = response['sakit'];
            document.getElementById("izin").value = response['izin'];
            document.getElementById("alfa").value = response['alfa'];
            document.getElementById("rolling").value = response['rolling'];
            document.getElementById("libur").value = response['libur'];
            document.getElementById("terlambat").value = response['terlambat'];
            document.getElementById("pulang_cepat").value = response['pulang_cepat'];
            
            //var max_month = Number({{date('t')}}) - ( Number(response['sakit'])+Number(response['izin'])+Number(response['alfa'])+Number(response['terlambat'])+Number(response['pulang_cepat'])+Number(response['rolling']) );
            var max_month = Number(response['masuk']);
            console.log(max_month);
            
            if(max_month > 21 && (response['sakit'] == 0 && response['izin'] == 0 && response['alfa'] == 0 && response['terlambat'] == 0 && response['pulang_cepat'] == 0)){
                document.getElementById("bonus_kehadiran").value = numberWithCommas(100000);
            }else if(max_month > 21 && (response['tidak_masuk'] == 1 || ( Number(response['sakit']) + Number(response['izin']) + Number(response['alfa']) + Number(response['pulang_cepat']) + Number(response['terlambat']) > 0))){
                document.getElementById("bonus_kehadiran").value = numberWithCommas(50000);
            }else if(max_month > 2 || ( Number(response['sakit']) + Number(response['izin']) + Number(response['alfa']) + Number(response['pulang_cepat']) + Number(response['terlambat']) > 2)){
                document.getElementById("bonus_kehadiran").value = 0;
            }else{
                document.getElementById("bonus_kehadiran").value = 0;
            }

            var jumlah_hari = Number(response['masuk']) + Number(response['sakit']) + Number(response['izin']) + Number(response['alfa'])+ Number(response['pulang_cepat']);
            var tm = Number(response['sakit']) + Number(response['izin']) + Number(response['alfa']) + Number(response['pulang_cepat']);
            var gaji_pokok = document.getElementById("gaji_pokok").value;
            gaji_pokok = gaji_pokok.split('.').join('');
            if(Number(jumlah_hari)<1){
                jumlah_hari = 1;
            }
            if(Number(tm)<1){
                tm = 1;
            }
            console.log(gaji_pokok);
            console.log(jumlah_hari);
            console.log(tm);
            var potongan = Math.round(Number(gaji_pokok) / Number(jumlah_hari) * Number(tm));
            if(gaji_pokok < 1){
                document.getElementById("potongan_gaji_pokok").value = 0;
            }else{
                document.getElementById("potongan_gaji_pokok").value = numberWithCommas(potongan);
            }
        }
    });
    TotalGaji();
}

function PilihUpah(no_id_upah,status_penggajian,mulai,sampai,id_karyawan){
    document.getElementById("no_id_upah").value = no_id_upah;
    document.getElementById("status_penggajian").value = status_penggajian;
    document.getElementById("mulai").value = mulai;
    document.getElementById("sampai").value = sampai;
    $.ajax({
        url: '{{url("cekgaji")}}/' + no_id_upah,
        type: 'get',
        dataType: 'json',
        async: false,
        success: function(response) {
            document.getElementById("upah_kinerja").value = numberWithCommas(response['gaji']); 
            document.getElementById("rata_rata_prosentase").value = response['hasil'];
            if(Number(response['hasil'])>50){
                document.getElementById("bonus_kinerja").value = numberWithCommas(150000);
            }else{
                document.getElementById("bonus_kinerja").value = 0;
            }
            
        }
    });

    $.ajax({
        url: '{{url("cekabsensi")}}/' + id_karyawan +"/"+mulai+"/"+sampai,
        type: 'get',
        dataType: 'json',
        async: false,
        success: function(response) {
            
            if(Number(response['uang_kopi'])>0){
                var upah_kinerja = document.getElementById("upah_kinerja").value;
                upah_kinerja = upah_kinerja.split('.').join('');
                var has_upah = Number(upah_kinerja) + response['uang_kopi'];
                document.getElementById("upah_kinerja").value = numberWithCommas(has_upah);
            }
            
            document.getElementById("masuk").value = response['masuk'];
            document.getElementById("sakit").value = response['sakit'];
            document.getElementById("izin").value = response['izin'];
            document.getElementById("alfa").value = response['alfa'];
            document.getElementById("rolling").value = response['rolling'];
            document.getElementById("libur").value = response['libur'];
            document.getElementById("terlambat").value = response['terlambat'];
            document.getElementById("pulang_cepat").value = response['pulang_cepat'];
            
            var max_month = Number({{date('t')}}) - (Number(response['rolling'])+Number(response['libur']) );
            console.log(max_month);
            
            if(response['masuk'] > max_month || (response['sakit'] == 0 && response['izin'] == 0 && response['alfa'] == 0 && response['terlambat'] == 0 && response['pulang_cepat'] == 0)){
                document.getElementById("bonus_kehadiran").value = numberWithCommas(100000);
            }else if(response['masuk'] > max_month  || (response['tidak_masuk'] == 1 || ( Number(response['sakit']) + Number(response['izin']) + Number(response['alfa']) + Number(response['pulang_cepat']) + Number(response['terlambat']) > 0))){
                document.getElementById("bonus_kehadiran").value = numberWithCommas(50000);
            }else if(response['tidak_masuk'] > 2 || ( Number(response['sakit']) + Number(response['izin']) + Number(response['alfa']) + Number(response['pulang_cepat']) + Number(response['terlambat']) > 2)){
                document.getElementById("bonus_kehadiran").value = 0;
            }else{
                document.getElementById("bonus_kehadiran").value = 0;
            }

            var jumlah_hari = Number(response['masuk']) + Number(response['sakit']) + Number(response['izin']) + Number(response['alfa'])+ Number(response['pulang_cepat']);
            var tm = Number(response['sakit']) + Number(response['izin']) + Number(response['alfa']) + Number(response['pulang_cepat']);
            var gaji_pokok = document.getElementById("gaji_pokok").value;
            gaji_pokok = gaji_pokok.split('.').join('');
            if(Number(jumlah_hari)<1){
                jumlah_hari = 1;
            }
            if(Number(tm)<1){
                tm = 1;
            }
            var potongan = Number(gaji_pokok) / Number(jumlah_hari) * Number(tm);
            //console.log(gaji_pokok);
            //console.log(jumlah_hari);
            //console.log(tm);
            if(gaji_pokok < 1){
                document.getElementById("potongan_gaji_pokok").value = 0;
            }else{
                document.getElementById("potongan_gaji_pokok").value = numberWithCommas(potongan);
            }
        }
    });
    TotalGaji();
    $('#sdsd').modal('hide');
}

function TotalGaji(){
    
    var gaji_pokok = document.getElementById("gaji_pokok").value;
    gaji_pokok = gaji_pokok.split('.').join('');
    var upah_kinerja = document.getElementById("upah_kinerja").value;
    upah_kinerja = upah_kinerja.split('.').join('');
    var bonus_kehadiran = document.getElementById("bonus_kehadiran").value;
    bonus_kehadiran = bonus_kehadiran.split('.').join('');
    var bonus_kinerja = document.getElementById("bonus_kinerja").value;
    bonus_kinerja = bonus_kinerja.split('.').join('');
    var valpendapatanlain1 = document.getElementById("valpendapatanlain1").value;
    valpendapatanlain1 = valpendapatanlain1.split('.').join('');
    var valpendapatanlain2 = document.getElementById("valpendapatanlain2").value;
    valpendapatanlain2 = valpendapatanlain2.split('.').join('');
    var valpendapatanlain3 = document.getElementById("valpendapatanlain3").value;
    valpendapatanlain3 = valpendapatanlain3.split('.').join('');
    
    
    var potongan_gaji_pokok = document.getElementById("potongan_gaji_pokok").value;
    potongan_gaji_pokok = potongan_gaji_pokok.split('.').join('');
    var bpjs_kesehatan = document.getElementById("bpjs_kesehatan").value;
    bpjs_kesehatan = bpjs_kesehatan.split('.').join('');
    var bpjs_ketenagakerjaan = document.getElementById("bpjs_ketenagakerjaan").value;
    bpjs_ketenagakerjaan = bpjs_ketenagakerjaan.split('.').join('');
    var valpotonganlain1 = document.getElementById("valpotonganlain1").value;
    valpotonganlain1 = valpotonganlain1.split('.').join('');
    var valpotonganlain2 = document.getElementById("valpotonganlain2").value;
    valpotonganlain2 = valpotonganlain2.split('.').join('');
    var valpotonganlain3 = document.getElementById("valpotonganlain3").value;
    valpotonganlain3 = valpotonganlain3.split('.').join('');
    
    var total_gaji = Number(gaji_pokok) + Number(upah_kinerja) + Number(bonus_kehadiran) + Number(bonus_kinerja) + Number(valpendapatanlain1) + Number(valpendapatanlain2) + Number(valpendapatanlain3)
                    - Number(potongan_gaji_pokok) - Number(bpjs_kesehatan) - Number(bpjs_ketenagakerjaan) - Number(valpotonganlain1) - Number(valpotonganlain2) - Number(valpotonganlain3);
    
    document.getElementById("total_gaji").innerHTML = numberWithCommas(total_gaji);
    console.log(total_gaji);
}

function Cetak(){
    var key = document.getElementById("no_id_upah").value;
    location.href="{{url('/cetakslipgaji/')}}/"+id_post;
}

function Simpan(){
    var mulai = document.getElementById("mulai").value;
    var sampai = document.getElementById("sampai").value;
    var id_karyawan = document.getElementById("id_karyawan").value;
    var masuk = document.getElementById("masuk").value;
    var sakit = document.getElementById("sakit").value;
    var izin = document.getElementById("izin").value;
    var alfa = document.getElementById("alfa").value;
    var rolling = document.getElementById("rolling").value;
    var libur = document.getElementById("libur").value;
    var terlambat = document.getElementById("terlambat").value;
    var pulang_cepat = document.getElementById("pulang_cepat").value;
    var rata_rata_prosentase = document.getElementById("rata_rata_prosentase").value;
    var status_pembayaran = document.getElementById("status_pembayaran").value;
    var status_penggajian = document.getElementById("status_penggajian").value;
    var gaji_pokok = document.getElementById("gaji_pokok").value;
    gaji_pokok = gaji_pokok.split('.').join('');
    var no_id_upah = document.getElementById("no_id_upah").value;
    var upah_kinerja = document.getElementById("upah_kinerja").value;
    upah_kinerja = upah_kinerja.split('.').join('');
    var bonus_kehadiran = document.getElementById("bonus_kehadiran").value;
    bonus_kehadiran = bonus_kehadiran.split('.').join('');
    var bonus_kinerja = document.getElementById("bonus_kinerja").value;
    bonus_kinerja = bonus_kinerja.split('.').join('');
    var potongan_gaji_pokok = document.getElementById("potongan_gaji_pokok").value;
    potongan_gaji_pokok = potongan_gaji_pokok.split('.').join('');
    var bpjs_kesehatan = document.getElementById("bpjs_kesehatan").value;
    bpjs_kesehatan = bpjs_kesehatan.split('.').join('');
    var bpjs_ketenagakerjaan = document.getElementById("bpjs_ketenagakerjaan").value;
    bpjs_ketenagakerjaan = bpjs_ketenagakerjaan.split('.').join('');

    var ketpendapatanlain1 = document.getElementById("ketpendapatanlain1").value;
    var valpendapatanlain1 = document.getElementById("valpendapatanlain1").value;
    valpendapatanlain1 = valpendapatanlain1.split('.').join('');
    var ketpendapatanlain2 = document.getElementById("ketpendapatanlain2").value;
    var valpendapatanlain2 = document.getElementById("valpendapatanlain2").value;
    valpendapatanlain2 = valpendapatanlain2.split('.').join('');
    var ketpendapatanlain3 = document.getElementById("ketpendapatanlain3").value;
    var valpendapatanlain3 = document.getElementById("valpendapatanlain3").value;
    valpendapatanlain3 = valpendapatanlain3.split('.').join('');

    var ketpotonganlain1 = document.getElementById("ketpotonganlain1").value;
    var valpotonganlain1 = document.getElementById("valpotonganlain1").value;
    valpotonganlain1 = valpotonganlain1.split('.').join('');
    var ketpotonganlain2 = document.getElementById("ketpotonganlain2").value;
    var valpotonganlain2 = document.getElementById("valpotonganlain2").value;
    valpotonganlain2 = valpotonganlain2.split('.').join('');
    var ketpotonganlain3 = document.getElementById("ketpotonganlain3").value;
    var valpotonganlain3 = document.getElementById("valpotonganlain3").value;
    valpotonganlain3 = valpotonganlain3.split('.').join('');
    
    var total_gaji = document.getElementById("total_gaji").innerHTML;
    total_gaji = total_gaji.split('.').join('');
    
    $.post("postslipgaji",
        {   mulai:mulai,
            sampai:sampai, 
            id_karyawan:id_karyawan, 
            masuk:masuk,
            sakit:sakit, 
            izin:izin, 
            alfa:alfa,
            rolling:rolling,
            libur:libur,
            terlambat:terlambat,
            pulang_cepat:pulang_cepat,
            rata_rata_prosentase:rata_rata_prosentase,
            status_pembayaran:status_pembayaran,
            status_penggajian:status_penggajian,
            gaji_pokok:gaji_pokok,
            no_id_upah:no_id_upah,
            upah_kinerja:upah_kinerja,
            bonus_kehadiran:bonus_kehadiran,
            bonus_kinerja:bonus_kinerja,
            potongan_gaji_pokok:potongan_gaji_pokok,
            bpjs_kesehatan:bpjs_kesehatan,
            bpjs_ketenagakerjaan:bpjs_ketenagakerjaan,
            ketpendapatanlain1:ketpendapatanlain1,
            valpendapatanlain1:valpendapatanlain1,
            ketpendapatanlain2:ketpendapatanlain2,
            valpendapatanlain2:valpendapatanlain2,
            ketpendapatanlain3:ketpendapatanlain3,
            valpendapatanlain3:valpendapatanlain3,
            ketpotonganlain1:ketpotonganlain1,
            valpotonganlain1:valpotonganlain1,
            ketpotonganlain2:ketpotonganlain2,
            valpotonganlain2:valpotonganlain2,
            ketpotonganlain3:ketpotonganlain3,
            valpotonganlain3:valpotonganlain3,
            total_gaji:total_gaji,
            _token:"{{ csrf_token() }}"}).done(function(data, textStatus, jqXHR)
            {
                console.log(data);
                id_post = data;
                Swal.fire({
                    title: 'Berhasil',
                    icon: 'success',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Lanjutkan!'
                    }).then((result) => {
                    if (result.value) {
                        document.getElementById("save").disabled = true;
                        document.getElementById("cetak").disabled = false;
                    }else{
                        document.getElementById("save").disabled = true;
                        document.getElementById("cetak").disabled = false;
                    }
                });
            }).fail(function(jqXHR, textStatus, errorThrown)
        {
            alert(textStatus);
    });

}
</script>
@endsection