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
                              <li class="breadcrumb-item text-muted" aria-current="page">Pengaturan > Upah Produksi > <a href="https://stokis.app/?s=upah+produksi+per+satuan+barang" target="_blank">Input Upah Per Hasil Pekerjaan</a></li>
                          </ol>
                    </h4>
                    <hr>
                <div class="row">
                      <div class="col-md-4">
            
            <form action="{{url('tambah_satuan_barang')}}" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
                
                
                No. ID Kerja:
                <div class="table-wrapper">
                    <div class="input-group">
                        <input type="text" id="no_id_pekerjaan" name="no_id_pekerjaan" class="form-control" placeholder="Pilih Pekerjaan" required readonly  style="background:#fff">
                        <div class="input-group-append">
                                          <button class="btn btn-outline-secondary" onclick="CariKaryawan()" type="button"><i class="fas fa-folder-open"></i></button>
                                      </div>
                    </div>
                </div> 
                <br>
                Nama Pekerjaan:
                <input type="text" name="nama_pekerjaan"  class="form-control" id="nama_pekerjaan" readonly>
                <br>
                Divisi:
                <input type="text" name="nama_divisi"  class="form-control" id="nama_divisi" readonly>
                <br>
                Satuan:
                <input type="text" name="satuan"  class="form-control" id="satuan" readonly>
                <br>
                Upah Satuan Hasil Pekerjaan:
                <input type="number" name="harga_satuan"  class="form-control" id="harga_satuan"><br>
                Status Pekerjaan:
                <select class="form-control" name="status_pekerja">
                    <option value="borongan">Borongan</option>
                </select>
                <br>
                <center><button class="btn btn-primary"  id="save-btn">&emsp;Simpan&emsp;</button></center>
            </form>
            
            
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
                
                
                <table id="examples6" class="table table-striped table-bordered no-wrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>No ID</th>
                            <th>Divisi</th>
                            <th>Nama Pekerjaan</th>
                            <th>Satuan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; foreach($data as $key => $value){ ?>
                        <tr onclick="Pilih('{{$value->no_id_pekerjaan}}','{{$value->nama_divisi}}','{{$value->nama_pekerjaan}}','{{$value->satuan}}','{{$value->id_divisi}}')">
                            <td>{{$value->no_id_pekerjaan}}</td>
                            <td>{{$value->nama_divisi}}</td>
                            <td>{{$value->nama_pekerjaan}}</td>
                            <td class="text-right">{{$value->satuan}}</td>
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

function Pilih(no_id_pekerjaan, nama_divisi, nama_pekerjaan,satuan, id_divisi) {
    document.getElementById("no_id_pekerjaan").value = no_id_pekerjaan;
    document.getElementById("nama_pekerjaan").value = nama_pekerjaan;
    document.getElementById("nama_divisi").value = nama_divisi;
    document.getElementById("satuan").value = satuan;
    $('#capmi').modal('hide');
}
</script>
@endsection