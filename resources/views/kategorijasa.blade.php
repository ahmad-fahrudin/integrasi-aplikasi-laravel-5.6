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
                              <li class="breadcrumb-item text-muted" aria-current="page">Layanan Jasa > <a href="https://stokis.app/?s=tambah+kategori+layanan+jasa" target="_blank">Kategori Jasa</a></li>
                          </ol>
                      </nav>
                    </h4>
                    <hr>
					<div class="table-responsive">

                    <div class="table-responsive">
                    <table id="examples" class="table table-striped table-bordered no-wrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Kategori Jasa</th>
                                <th>Gambar</th>
                                <th>Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                          <?php foreach ($kategorijasa as $value) { ?>
                            <tr>
                                <td>{{$value->id}}</td>
                                <td>{{$value->nama_kategori}}</td>
                                <td><img src="{{asset('gambar/kategori/'.$value->gbr)}}" height="100px"></td>
                                <td>
                                  <button class="btn btn-default" onclick="edit('{{$value->id}}')"><i class="icon-pencil"></i></button>
                                  <button class="btn btn-default" onclick="Deleted('{{$value->nama_kategori}}','{{$value->id}}')"><i class="icon-trash"></i></button>
                                </td>
                            </tr>
                           <?php } ?>
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#myModal">Tambah Kategori Jasa</button>
                    <hr>
                  </div>

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
            <center><h3>Tambah Kategori</h3></center>
            <form action="{{url('addkategorijasa')}}" method="post" enctype="multipart/form-data">
            {{csrf_field()}}
            Kategori Jasa:
            <input required name="nama_kategori" type="text" required class="form-control" placeholder="Ketik nama kategori baru...">
            <br>
            Gambar:
            <input required  type="file" name="gbr" class="form-control">
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
            <center><h3>Ubah Kategori Jasa</h3></center>
            <form action="{{url('updatekategorijasa')}}" method="post" enctype="multipart/form-data">
            {{csrf_field()}}
            <input type="hidden" name="id" id="id">
            Kategori Jasa:
            <input required id="nama_jabatan" name="nama_kategori" type="text" class="form-control">
            <br>
            Gambar:
            <input type="file" name="gbr" class="form-control">
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
           url: 'editkategorijasa/'+value,
           type: 'get',
           dataType: 'json',
           async: false,
           success: function(response){
             document.getElementById("id").value = response[0]['id'];
             document.getElementById("nama_jabatan").value = response[0]['nama_kategori'];
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
          location.href="{{url('/deletekategorijasa/')}}"+"/"+value;
        }
      });
    }
    </script>

@endsection
