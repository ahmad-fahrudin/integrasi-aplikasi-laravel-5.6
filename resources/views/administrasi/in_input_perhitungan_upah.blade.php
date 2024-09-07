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
                             <li class="breadcrumb-item text-muted" aria-current="page">Payroll > Perhitungan upah > <a href="https://stokis.app/?s=buat+perhitungan+upah" target="_blank">Buat Perhitungan Upah</a></li>
                          </ol>
                      </nav>
                    </h4>
                    <hr>
                    <br>
                    
                    
                    <div class="row">
                      <div class="col-md-6">
                        <div class="row">
                          <label class="col-lg-3">No. ID Upah</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input type="text" name="no_id_upah"  class="form-control" id="no_id_upah" value="G-{{$nmb}}/{{date('m/Y')}}" readonly>
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Pilih Karyawan</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <div class="input-group">
                                         <input type="text" id="id_karyawan" name="id_karyawan" class="form-control" placeholder="Pilih Karyawan" readonly  style="background:#fff">
                                          <div class="input-group-append">
                                            <button class="btn-outline-secondary btn" type="button" onclick="CariKaryawan()"><i
                                              class="fa fa-folder"></i></button>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Nama karyawan</label>
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
                          <label class="col-lg-3">Status Karyawan</label>
                          <div class="col-lg-8">
                            <div class="row">
                                <div class="col-md-11">
                                  <input type="text" name="status_pekerja"  class="form-control" id="status_pekerja" readonly> 
                                </div>
                            </div>
                          </div>
                         </div>
                      
                      </div>
                      
                      <div class="col-md-6">
                        <div class="row">
                          <label class="col-lg-3">Status Pembayaran</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <select name="status_pembayaran"  class="form-control" id="status_pembayaran" readonly>
                                        <option>Proses</option>
                                      </select>
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Status Penggajian</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <select name="status_penggajian"  class="form-control" id="status_penggajian">
                                            <option>Harian</option>
                                            <option>Borongan</option>
                                            <option>Perubahan BH-HB</option>
                                            <option>Peralihan 1</option>
                                            <option>Peralihan 2</option>
                                        </select>
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <label>Periode Penggajian</label><br>
                        <div class="row">
                          <label class="col-lg-3">Dari Tanggal</label>
                          <div class="col-lg-8">
                            <div class="row">
                                <div class="col-md-11">
                                  <input type="date" name="mulai" id="mulai" class="form-control">
                                </div>
                            </div>
                          </div>
                          </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Sampai Tanggal</label>
                          <div class="col-lg-8">
                            <div class="row">
                                <div class="col-md-11">
                                  <input type="date" name="sampai" id="sampai" class="form-control">
                                </div>
                            </div>
                          </div>
                           
                          
                         </div>
                         <br>
                         <div class="row">
                        <label class="col-lg-3"></label>
                          <div class="col-lg-8">
                             <div class="row">
                                  <div class="col-md-11">
                                     <center><button class="btn btn-success btn-lg" onclick="Tampilkan()">&emsp;Tampilkan Data&emsp;</button></center>
                                    </div>
                                </div>
                             </div>
                         </div>
                      </div>
                    </div>
                    
            <br>
            <hr>
            <div class="table-responsive">
                <table id="cart" class="table table-striped table-bordered no-wrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>No Job</th>
                            <th>Tanggal</th>
                            <th>Nama Pekerjaan</th>
                            <th>Devisi</th>
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
            <br>
            <center><button class="btn btn-primary btn-lg" id="save" onclick="Simpan()">Simpan</button></center>
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
                            <th>No HP</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; foreach($karyawan as $key => $value){ ?>
                        <tr onclick="Pilih('{{$value->id}}','{{$value->nama}}','{{$value->id_divisi}}','{{$value->alamat}}','{{$value->status_pekerja}}')">
                            <td>{{$value->id}}</td>
                            <td>{{$value->nama}}</td>
                            <td><?php echo $value->alamat; ?></td>
                            <td>{{$value->no_hp}}</td>
                        </tr>
                        <?php $no++; } ?>
                    </tbody>
                </table>
            <</div>

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

function Pilih(id_karyawan, nama_karyawan, id_divisi, alamat_karyawan, status_pekerja) {
    document.getElementById("id_karyawan").value = id_karyawan;
    document.getElementById("nama_karyawan").value = nama_karyawan;
    document.getElementById("alamat").value = alamat_karyawan;
    document.getElementById("status_pekerja").value = status_pekerja;
    $('#capmi').modal('hide');
}
var jmldata = 0;

function Tampilkan(){
    var mulai = document.getElementById("mulai").value;
    var sampai = document.getElementById("sampai").value;
    var id_karyawan = document.getElementById("id_karyawan").value;
    $.ajax({
        url: '{{url("getkinerja")}}/' + mulai+'/'+sampai+'/'+id_karyawan,
        type: 'get',
        dataType: 'json',
        async: false,
        success: function(response) {
           var myTable = document.getElementById("cart");
           var rowCount = myTable.rows.length;
           for (var x=rowCount-1; x>0; x--) {
            myTable.deleteRow(x);
           }
           
            for (var i = 0; i < response.length; i++) {
                var table = document.getElementById("cart");
                var lastRow = table.rows.length;
                var row = table.insertRow(lastRow);
                row.id = lastRow;
                jmldata = lastRow;
                var cell1 = row.insertCell(0);
                var cell2 = row.insertCell(1);
                var cell3 = row.insertCell(2);
                var cell4 = row.insertCell(3);
                var cell5 = row.insertCell(4);
                var cell6 = row.insertCell(5);
                var cell7 = row.insertCell(6);
                var cell8 = row.insertCell(7);
                var cell9 = row.insertCell(8);

                cell1.innerHTML = "<p>"+response[i]['no_job']+ "</p>"+"<input type='hidden' id='id_job"+lastRow+"' value='"+response[i]['id']+"'>";
                cell2.innerHTML = "<p>"+response[i]['tanggal']+"</p>";
                cell3.innerHTML = "<p>"+response[i]['nama_pekerjaan']+"</p>";
                cell4.innerHTML = "<p>"+response[i]['nama_divisi']+"</p>";
                cell5.innerHTML = "<p>"+response[i]['kategori_kerja']+"</p>";
                cell6.innerHTML = "<p>"+response[i]['jumlah']+"</p>";
                cell7.innerHTML = "<p>"+response[i]['jam_kerja_floor']+"</p>";
                cell8.innerHTML = "<p>"+response[i]['menit_kerja_floor']+"</p>";
                cell9.innerHTML = '<button class="btn btn-danger btn-sm" onclick="deletecart('+lastRow+')">Delete</button>';
            }
        }
    });
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
    var no_id_upah = document.getElementById("no_id_upah").value;
    var d_karyawan = document.getElementById("id_karyawan").value;
    var status_pembayaran = document.getElementById("status_pembayaran").value;
    var status_penggajian = document.getElementById("status_penggajian").value;
    var mulai = document.getElementById("mulai").value;
    var sampai = document.getElementById("sampai").value;

    var id_job = "";

    for(var i=0; i <= jmldata; i++){
        var elem = document.getElementById("id_job"+i);
        if (typeof(elem) != 'undefined' && elem != null){
            var a = document.getElementById("id_job"+i).value;
            id_job += a+"|";
        }
    }
    
    $.post("postperhitunganupah",
        {no_id_upah:no_id_upah, id_karyawan:id_karyawan, status_pembayaran:status_pembayaran, status_penggajian:status_penggajian,
            mulai:mulai, sampai:sampai,
            id_job:id_job, _token:"{{ csrf_token() }}"}).done(function(data, textStatus, jqXHR)
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
                        location.href="{{url('/data_perhitungan_upah/')}}";
                    }else{
                        document.getElementById("save").disabled = true;
                        location.href="{{url('/data_perhitungan_upah/')}}";
                    }
                })
            }).fail(function(jqXHR, textStatus, errorThrown)
        {
            alert(textStatus);
    });

}

</script>
@endsection