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
                              <li class="breadcrumb-item text-muted" aria-current="page">Absensi > <a href="https://stokis.app/?s=absensi" target="_blank">Input Absensi Karyawan</a></li>
                          </ol>
                      </nav>
                    </h4>
                    <hr>
        
        
        <div class="row">
        <div class="col-md-6">
        <div class="row">
            <label class="col-lg-6"><strong>Input Absensi</strong></label>
                </div>
                        <br>
            <form action="{{url('tambah_absensi')}}" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
                No. ID Karyawan:
                <div class="table-wrapper">
                    <div class="input-group">
                        <input id="id" type="hidden" class="form-control">
                        <input type="text" id="id_karyawan" name="id" class="form-control" placeholder="Pilih Karyawan" readonly  style="background:#fff">
                        <span class="input-group-btn">
                            <button class="btn btn-outline-secondary" type="button" onclick="CariKaryawan()"><i
                                    class="fa fa-folder"></i></button>
                        </span>
                    </div>
                </div> 
                <br>
                Nama Karyawan:
                <input type="text" name="nama" class="form-control" id="nama" readonly>
                <br>
                Alamat:
                <input type="text" name="alamat" class="form-control" id="alamat" readonly>
                <br>
                Status Kehadiran:
                <select class="form-control" name="status_kehadiran" id="status_kehadiran" onchange="Kehadiran()">
                    <option value="hadir">Hadir</option>
                    <option value="tidak hadir">Tidak Hadir</option>
                </select>
                <div id="hadir">
                    <br>
                    Tanggal
                    <div class="table-wrapper">
                        <div class="input-group">
                            <input type="date" id="tanggal_hadir" name="tanggal_hadir" class="form-control" onchange="cekabsen()">
                            <span class="input-group-btn">
                                <button class="btn bd bd-l-0 bg-primary tx-gray-600 text-white" type="button" onclick="CreateTanggal('tanggal_hadir')">Tanggal</button>
                            </span>
                        </div>
                    </div> 
                    <br>
                    Jam Masuk
                    <div class="table-wrapper">
                        <div class="input-group">
                            <input type="time" id="jam_masuk" name="jam_masuk" class="form-control">
                            <span class="input-group-btn">
                                <button class="btn bd bd-l-0 bg-primary tx-gray-600 text-white" type="button" onclick="CreateJam('jam_masuk')">Masuk&nbsp;&nbsp;</button>
                            </span>
                        </div>
                    </div> 
                    <br>
                    Jam Pulang
                    <div class="table-wrapper">
                        <div class="input-group">
                            <input type="time" id="jam_pulang" name="jam_pulang" class="form-control">
                            <span class="input-group-btn">
                                <button class="btn bd bd-l-0 bg-primary tx-gray-600 text-white" type="button" onclick="CreateJam('jam_pulang')">Pulang&nbsp;&nbsp;</button>
                            </span>
                        </div>
                    </div> 
                </div>
                
                <div id="tidak_hadir" hidden>
                    <br>
                    Tanggal
                    <div class="table-wrapper">
                        <div class="input-group">
                            <input type="date" id="tanggal_tidak_hadir" name="tanggal_tidak_hadir" class="form-control">
                            <span class="input-group-btn">
                                <button class="btn bd bd-l-0 bg-primary tx-gray-600 text-white" type="button" onclick="CreateTanggal('tanggal_tidak_hadir')">Tanggal</button>
                            </span>
                        </div>
                    </div> 
                    <br>
                    Keterangan
                    <select class="form-control" name="keterangan" id="keterangan">
                        <option value="izin">Izin</option>
                        <option value="sakit">Sakit</option>
                        <option value="alfa">Alfa</option>
                        <option value="cuti">Cuti</option>
                        <option value="Libur">Libur</option>
                    </select>
                </div>

                <br>
                <center>
                <button class="btn btn-lg btn-success btn-lg"  id="save-btn">&emsp;Simpan&emsp;</button>
                </center>
            </form>
            </div>
        </div>
        </div>
        </div>
    
</div>
</div>
</div>
</div>




<div class="modal fade" id="karyawan" role="dialog">
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
                            <th>No.ID</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>No HP</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($karyawan as $key => $value){ ?>
                        <tr onclick="PilihKaryawan('{{$value->id}}','{{$value->nama}}','{{$value->alamat}}')">
                            <td>{{$value->id}}</td>
                            <td>{{$value->nama}}</td>
                            <td><?php echo $value->alamat; ?></td>
                            <td>{{$value->no_hp}}</td>
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

<script>
function CariKaryawan() {
    $('#karyawan').modal('show');
}

function CreateJam(id){
    var currentTime = new Date();
    var jam = currentTime.getHours();
    var menit = currentTime.getMinutes();
    if(Number(jam) < 10){
        jam = "0"+jam;
    }
    if(Number(menit) < 10){
        menit = "0"+menit;
    }
    document.getElementById(id).value = jam + ":" + menit;
}

function CreateTanggal(id){
    var currentTime = new Date();
    var month = currentTime.getMonth() + 1;
    var day = currentTime.getDate();
    var year = currentTime.getFullYear();
    if(Number(month) < 10){
        month = "0"+month;
    }
    if(Number(day) < 10){
        day = "0"+day;
    }
    document.getElementById(id).value = year + "-" + month + "-" + day;
    cekabsen();
}

function PilihKaryawan(id, nama, alamat) {
    document.getElementById("id_karyawan").value = id;
    document.getElementById("nama").value = nama;
    document.getElementById("alamat").value = alamat;
    
    $('#karyawan').modal('hide');
}

function cekabsen(){
    var tanggal_hadir = document.getElementById("tanggal_hadir").value;
    var id_karyawan = document.getElementById("id_karyawan").value;
    $.ajax({
        url: '{{url("cekabsen")}}/' + tanggal_hadir + '/' + id_karyawan,
        type: 'get',
        dataType: 'json',
        async: false,
        success: function(response) {
            document.getElementById("jam_masuk").value = response[0]['jam_masuk'];
            document.getElementById("jam_pulang").value = response[0]['jam_pulang'];
        }
    });
}

function Kehadiran(){
    var status_pekerja = document.getElementById("status_kehadiran").value;
    console.log(status_pekerja);
    if(status_pekerja == "hadir"){
        document.getElementById("tidak_hadir").hidden = true;
        document.getElementById("hadir").hidden = false;
    }else{
        document.getElementById("hadir").hidden = true;
        document.getElementById("tidak_hadir").hidden = false;
    }
}

</script>


@endsection