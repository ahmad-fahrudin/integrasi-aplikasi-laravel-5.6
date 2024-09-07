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
                              <li class="breadcrumb-item text-muted" aria-current="page">Pengaturan > <a href="https://stokis.app/?s=kategori+jabatan+karyawan" target="_blank">Jabatan Karyawan</a></li>
                          </ol>
                      </nav>
                    </h4>
                    <hr>

									<div class="table-responsive">
                  <table id="examples" class="table table-striped table-bordered no-wrap" style="width:100%">
                      <thead>
                          <tr>
                              <th>No</th>
                              <th hidden>ID</th>
                              <th>Nama Jabatan</th>
                              <th hidden>Tindakan</th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php $no=1;foreach ($jabatan as $value) { ?>
                          <tr>
                              <td>{{$no}}</td>
                              <td hidden>{{$value->id}}</td>
                              <td>{{$value->nama_jabatan}}</td>
                              <td hidden>
                                <button class="btn btn-default" onclick="edit('{{$value->id}}')"><i class="icon-pencil"></i></button>
                                <button  class="btn btn-default" onclick="Deleted('{{$value->nama_jabatan}}','{{$value->id}}')"><i class="icon-trash"></i></button>
                              </td>
                          </tr>
                         <?php $no++;} ?>
                      </tbody>
                  </table>
                  <button type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#myModal">Tambahkan Jabatan</button>
		            </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div id="myModal" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <form action="{{url('postjabatan')}}" method="post" enctype="multipart/form-data">
            {{csrf_field()}}
            Nama Jabatan:
            <input required name="nama_jabatan" type="text" class="form-control">
            <br>
            <center><input type="submit" class="btn btn-success" value="Tambahkan"></center>
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
            <form action="{{url('updatejabatan')}}" method="post" enctype="multipart/form-data">
            {{csrf_field()}}
            <input type="hidden" name="id" id="id">
            Nama Jabatan:
            <input required id="nama_jabatan" name="nama_jabatan" type="text" class="form-control">
            <br>
            <center><input type="submit" class="btn btn-primary" value="Update"></center>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script>
    function edit(value)
    {
        $.ajax({
           url: 'editJabatan/'+value,
           type: 'get',
           dataType: 'json',
           async: false,
           success: function(response){
             document.getElementById("id").value = response[0]['id'];
             document.getElementById("nama_jabatan").value = response[0]['nama_jabatan'];

             $('#editmodal').modal('show');
           }
         });
    }

    function Deleted(name,value)
    {
      Swal.fire(
        'Delete '+name+'?',
        'Apakah Anda Yakin?',
        'question'
      ).then((result) => {
        if (result.value) {
          location.href="{{url('/deleteJabatan/')}}"+"/"+value;
        }
      });
    }
    </script>
@endsection
