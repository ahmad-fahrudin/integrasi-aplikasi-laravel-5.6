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
                               <li class="breadcrumb-item text-muted" aria-current="page">Pengaturan > <a href="https://stokis.app/?s=Divisi+Pekerjaan" target="_blank">Divisi Pekerjaan</a></li>
                          </ol>
                      </nav>
                    </h4>
                    <hr>
                    <br>

					<div class="table-responsive">
                <table id="examples" class="table table-striped table-bordered no-wrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Divisi</th>
                            <th>Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; foreach($divisi as $key => $value){ ?>
                            <tr>
                                <td>{{$no}}</td>
                                <td>{{$value->nama_divisi}}</td>
                                <td>
                                    <button class="btn btn-default" onclick="Edit('{{$value->id_divisi}}','{{$value->nama_divisi}}')"><i class="icon-pencil"></i></button>
                                    <button class="btn btn-default" onclick="Hapus('{{$value->id_divisi}}','{{$value->nama_divisi}}')"><i class="icon-trash"></i></button>
                                </td>
                            </tr>
                        <?php $no++; } ?>
                    </tbody>
                </table>
                <button type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#myModal">Tambahkan Divisi</button>
            </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>


<div id="myModal" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <form action="{{url('tambah_nama_divisi')}}" method="post" enctype="multipart/form-data">
            {{csrf_field()}}
            <input type="hidden" name="id_divisi" id="id_divisi">
            Nama Divisi:
            <input type="text" name="nama_divisi"  maxlength="40" class="form-control" >
            <br>
            <center><button class="btn btn-primary btn-lg" id="save-btn" >&emsp;Tambah&emsp;</button></center>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>


<div class="modal fade" id="editmodal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          
                    <h4>Edit Nama Divisi</h4>
                 
                <form action="{{url('simpan_divisi')}}" method="post"  enctype="multipart/form-data">
                    {{csrf_field()}}
                    Nama Divisi
                    <input type="text" maxlength="40" name="nama_divisi" id="nama_divisi" class="form-control">
                    <input type="hidden" name="id_divisi" id="id_divisi" class="form-control">
                    <br>
                    <center><button class="btn btn-success">Update</button></center>
                </form>
                
            </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
    </div>

<script>

 function Hapus(id, nama)
    {
      Swal.fire(
        'Delete '+nama+'?',
        'Apakah Anda Yakin?',
        'question'
      ).then((result) => {
        if (result.value) {
          location.href="{{url('/delete_divisi/')}}"+"/"+id;
        }
      });
    }

function Edit(id, nama) {
    document.getElementById("nama_divisi").value = nama;
    document.getElementById("id_divisi").value = id;
    $('#editmodal').modal('show');
}
</script>
@endsection