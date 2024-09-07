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
                              <li class="breadcrumb-item text-muted" aria-current="page">Kinerja Karyawan > <a href="https://stokis.app/?s=kinerja+karyawan" target="_blank">Input Kegiatan Pekerjaan</a></li>
                          </ol>
                      </nav>
                    </h4>
                    <hr>

                    <br>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="row">
                          <label class="col-lg-3">No. Job</label>
                          <div class="col-lg-8">
                            <div class="row">
                                <div class="col-md-11">

                                    <input type="text" name="no_job"  class="form-control" id="no_job" value="{{$nmb}}/{{date('m/Y')}}" readonly>

                                </div>
                            </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Tanggal</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input type="date" name="tanggal"  class="form-control" id="tanggal" value="{{date('Y-m-d')}}">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-6"><strong>Data Karyawan</strong></label>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">ID Karyawan</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <div class="table-wrapper">
                                        <div class="input-group">
                                      <input type="text" id="id_karyawan" name="id_karyawan" class="form-control" placeholder="Pilih Karyawan" readonly  style="background:#fff">
                                     
                                     <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" onclick="CariKaryawan()" type="button"><i class="fas fa-folder-open"></i></button>
                                     </div>
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
                                      <input type="text" name="nama_karyawan"  class="form-control" id="nama_karyawan" readonly>
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
                                      <input type="text" name="alamat"  class="form-control" id="alamat" readonly>
                                  </div>
                              </div>
                          </div>
                        </div>
                        
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Divisi</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                     <select class="form-control" id="divisi" name="divisi" readonly>
                                      <?php foreach($divisi as $key => $value){ ?> 
                                      <option value="{{$value->id_divisi}}">{{$value->nama_divisi}}</option>
                                       <?php } ?>
                                     </select>
                                  </div>
                              </div>
                          </div>
                        </div>

                      </div>

                      <div class="col-md-6">
                        <div hidden class="row">
                          <label class="col-lg-3">Pengawas</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input type="text" name="supervisor"  class="form-control" id="supervisor" value="{{Auth::user()->name}}" readonly>
                                  </div>
                              </div>
                          </div>
                        </div>   

                        <div class="row">
                          <label class="col-lg-6"><strong>Input Pekerjaaan</strong></label>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Nama Pekerjaan</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <div class="table-wrapper">
                                        <div class="input-group">
                                          <input type="hidden" id="no_id_pekerjaan" name="no_id_pekerjaan" class="form-control">
                                          <input type="text" id="nama_pekerjaan" name="nama_pekerjaan" class="form-control" placeholder="Pilih Pekerjaan" readonly  style="background:#fff">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary" onclick="CariPekerjaan()" type="button"><i class="fas fa-folder-open"></i></button>
                                             </div>
                                        </div>
                                    </div>
                                  </div>
                              </div>
                          </div>
                        </div>
                        
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Kategori Kerja</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                     <select name="kategori_kerja"  class="form-control" id="kategori_kerja">
                                         <?php foreach ($kategori as $key => $value) { ?>
                                            <!--<option>{{$value->shift_kerja}}</option>-->
                                         <?php } ?>
                                        <option>Shift 1</option>
                                        <option>Shift 2</option>
                                        <option>lembur</option>
                                     </select>
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Jumlah (Hasil Kerja)</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input type="number" name="jumlah"  class="form-control" id="jumlah" placeholder="0" required>
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Jam Kerja (Jam)</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input type="number" name="jam_kerja"  class="form-control" id="jam_kerja" placeholder="0" required>
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Jam Kerja (Menit)</label>
                          <div class="col-lg-8">
                            <div class="row">
                                <div class="col-md-11">
                                  <input type="number" name="menit_kerja"  class="form-control" id="menit_kerja" value="0">
                                </div>
                            </div>
                          </div>
                        </div>
                       
                        <br>

                        <center><button class="btn btn-primary btn-lg" onclick="Tambah()">&emsp;Tambah&emsp;</button></center>
                                  
                        
                      </div>

                    </div>

                    <br><br>


                  <br><hr>
				  <div class="table-responsive">
                  <table id="cart" class="table table-striped table-bordered no-wrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>Nama Pekerjaan</th>
                            <th>Kategori Kerja</th>
                            <th>Jumlah</th>
                            <th>Jam Kerja (Jam)</th>
                            <th>Jam Kerja (Menit)</th>
                            <th>Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
                  </div>
                <hr><br>
                <center>
                  <button class="btn btn-success btn-lg" id="save" onclick="Simpan()">Simpan</button>
                </center>
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
                    <table id="examples3" class="table table-striped table-bordered no-wrap" style="width:100%">
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
                        <tr  onclick="Pilih('{{$value->id}}','{{$value->nama}}','{{$value->id_divisi}}','{{$value->alamat}}','{{$divisis[$value->id_divisi]->nama_divisi}}')">
                            <td>{{$value->id}}</td>
                            <td>{{$value->nama}}</td>
                            <td><?php echo $value->alamat; ?></td>
                            <td hidden>{{$value->no_hp}}</td>
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

    <div class="modal fade" id="pkrj" role="dialog">
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
                            <th>Pekerjaan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; foreach($pekerjaan as $key => $value){ ?>
                        <tr onclick="PilihPekerjaan('{{$value->no_id_pekerjaan}}','{{$value->nama_pekerjaan}}')">
                            <td>{{$value->no_id_pekerjaan}}</td>
                            <td>{{$value->nama_pekerjaan}}</td>
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

function CariPekerjaan() {
    $('#pkrj').modal('show');
}

function Pilih(id_karyawan, nama_karyawan, id_divisi, alamat_karyawan,nama_divisi) {
    document.getElementById("id_karyawan").value = id_karyawan;
    document.getElementById("nama_karyawan").value = nama_karyawan;
    document.getElementById("alamat").value = alamat_karyawan;
    document.getElementById("divisi").value = id_divisi;
    $('#capmi').modal('hide');
}

function PilihPekerjaan(no_id_pekerjaan, nama_pekerjaan) {
    document.getElementById("no_id_pekerjaan").value = no_id_pekerjaan;
    document.getElementById("nama_pekerjaan").value = nama_pekerjaan;
    $('#pkrj').modal('hide');
}

var jmldata = 0;
function Tambah(){
    var table = document.getElementById("cart");
    var lastRow = table.rows.length;
    var row = table.insertRow(lastRow);
    row.id = lastRow;
    jmldata = Number(jmldata) + 1;
    var no_id_pekerjaan = document.getElementById("no_id_pekerjaan").value;
    var nama_pekerjaan = document.getElementById("nama_pekerjaan").value;
    var kategori_kerja = document.getElementById("kategori_kerja").value;
    var jumlah = document.getElementById("jumlah").value;
    var jam_kerja = document.getElementById("jam_kerja").value;
    var menit_kerja = document.getElementById("menit_kerja").value;

    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    var cell3 = row.insertCell(2);
    var cell4 = row.insertCell(3);
    var cell5 = row.insertCell(4);
    var cell6 = row.insertCell(5);

    cell1.innerHTML = "<p id=nama_pekerjaan" + jmldata + ">" + nama_pekerjaan + "</p>";
    cell2.innerHTML = "<p id=kategori_kerja" + jmldata + ">" + kategori_kerja + "</p>";
    cell3.innerHTML = "<input type='number' id=jumlah" + jmldata + " value='"+jumlah+"'>";
    cell4.innerHTML = "<input type='number' id=jam_kerja" + jmldata + " value='"+jam_kerja+"'>";
    cell5.innerHTML = "<input type='number' id=menit_kerja" + jmldata + " value='"+menit_kerja+"'>";
    cell6.innerHTML = '<button class="btn btn-default" onclick="deletecart('+jmldata+')"><i class="icon-trash"></i></button>';
}

function deletecart(lastRow){
    Swal.fire(
    'Delete this?',
    'Apakah Anda Yakin?',
    'question'
    ).then((result) => {
    if (result.value) {
        var row = document.getElementById(lastRow);
        row.parentNode.removeChild(row);
    }
    });
}

function Simpan(){
    var no_job = document.getElementById("no_job").value;
    var tanggal = document.getElementById("tanggal").value;
    var divisi = document.getElementById("divisi").value;
    var supervisor = document.getElementById("supervisor").value;
    var no_id_pekerjaan = "";
    var nama_pekerjaan = "";
    var kategori_kerja = "";
    var jumlah = "";
    var jam_kerja = "";
    var menit_kerja = "";
    
    for(var i=1; i <= jmldata; i++){
        var elem = document.getElementById("nama_pekerjaan"+i);
        if (typeof(elem) != 'undefined' && elem != null){
            var a = document.getElementById("nama_pekerjaan"+i).innerHTML;
            nama_pekerjaan += a+"|";
            var b = document.getElementById("kategori_kerja"+i).innerHTML;
            kategori_kerja += b+"|";
            var c = document.getElementById("jumlah"+i).value;
            jumlah += c+"|";
            var d = document.getElementById("jam_kerja"+i).value;
            jam_kerja += d+"|";
            var e = document.getElementById("menit_kerja"+i).value;
            menit_kerja += e+"|";
        }
    }
    
    $.post("postkinerjakaryawan",
        {no_job:no_job, tanggal:tanggal, id_karyawan:id_karyawan, divisi:divisi,
            supervisor:supervisor, nama_pekerjaan:nama_pekerjaan, kategori_kerja:kategori_kerja, jumlah:jumlah,
            jam_kerja:jam_kerja,menit_kerja:menit_kerja, _token:"{{ csrf_token() }}"}).done(function(data, textStatus, jqXHR)
            {
                Swal.fire({
                    title: 'Berhasil',
                    icon: 'success',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Lanjutkan!'
                    }).then((result) => {
                    if (result.value) {
                        document.getElementById("save").disabled = true;
                        location.href="{{url('/input_kinerja_karyawan/')}}";
                    }else{
                        document.getElementById("save").disabled = true;
                        location.href="{{url('/input_kinerja_karyawan/')}}";
                    }
                });
            }).fail(function(jqXHR, textStatus, errorThrown)
        {
            alert(textStatus);
    });

}

</script>
@endsection