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
                              <li class="breadcrumb-item text-muted" aria-current="page">Pengaturan > <a href="https://stokis.app/?s=ketentuan+absensi" target="_blank">Ketentuan Absensi (Jam Kerja)</a></li>
                          </ol>
                    </h4>
                    <hr>
                <div class="table-responsive">
                <table id="examples" class="table table-striped table-bordered no-wrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>Hari</th>
                            <th>Shift Kerja</th>
                            <th>Jam Kerja Per Hari</th>
                            <th>Jam Masuk</th>
                            <th>Jam Pulang</th>
                            <th>Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; foreach($data as $key => $value){ ?>
                            <tr>
                                <td>{{harian($value->hari)}}</td>
                                <td>{{$value->shift_kerja}}</td>
                                <td>{{$value->jam_kerja}}</td>
                                <td>{{$value->jam_masuk}}</td>
                                <td>{{$value->jam_pulang}}</td>
                                <td>
                                    <button class="btn btn-default btn-sm" onclick="Edit('{{$value->shift_kerja}}','{{$value->jam_kerja}}','{{$value->jam_masuk}}','{{$value->jam_pulang}}','{{harian($value->hari)}}','{{$value->hari}}')"><i class="icon-pencil"></i></button>
                                </td>
                            </tr>
                        <?php $no++; } ?>
                    </tbody>
                </table>
                
                
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

                    <h4>Edit Ketentuan Absensi</h4>

                <form action="{{url('update_ketentuan_absen')}}" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
                Hari Kerja:
                <input type="text" class="form-control"name="hari" id="nama_hari" readonly>
                <input type="hidden" class="form-control" name="hari" id="hari" readonly>
                Shift Kerja:
                <input type="text" class="form-control" name="shift_kerja" id="shift_kerja" readonly>
                <br>
                Jam Kerja Per Hari:
                <input type="number" name="jam_kerja"  class="form-control" id="jam_kerja">
                Jam Masuk:
                <input type="time" name="jam_masuk"  class="form-control" id="jam_masuk">
                Jam Pulang:
                <input type="time" name="jam_pulang"  class="form-control" id="jam_pulang"><br>
                <center><button class="btn btn-success"  id="save-btn">&emsp;Update&emsp;</button></center>
            </form>
            
            </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
    </div>
<script>
function Edit(shift_kerja, jam_kerja, jam_masuk, jam_pulang, nama_hari, hari) {
    document.getElementById("shift_kerja").value = shift_kerja;
    document.getElementById("jam_kerja").value = jam_kerja;
    document.getElementById("jam_masuk").value = jam_masuk;
    document.getElementById("jam_pulang").value = jam_pulang;
    document.getElementById("nama_hari").value = nama_hari;
    document.getElementById("hari").value = hari;
    $('#capmi').modal('show');
}
</script>
@endsection