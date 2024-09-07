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
                              <li class="breadcrumb-item text-muted" aria-current="page">Katalog Produk > <a href="https://stokis.app/?s=tambah+sub+kategori" target="_blank">Sub Kategori Produk</a></li>
                          </ol>
                      </nav>
                    </h4>
                    <hr>
					<div class="table-responsive">
                <nav class="navbar-dark bg-white">
                    <h3 class="card-title text-left d-flex">
                    <ul class="nav nav-tabs border-0" role="tablist">
                    <li class="nav-item">
                    <a class="nav-link show" href="{{url('inputkatalog')}}" target="_blank" ><i data-feather="edit" class="feather-icon"></i> Input Katalog Baru</a>
                    </li>
                    </ul>
                     
                    <a href="{{url('kategoriproduk')}}" target="_blank" class="btn text-danger"><i data-feather="folder-plus" class="feather-icon"></i> Main Kategori</a>
                    <a href="{{url('kategorikatalog')}}" target="_blank" class="btn text-warning"><i data-feather="folder" class="feather-icon"></i> Sub Kategori</a>
                    <a href="{{url('brand')}}" target="_blank" class="btn text-danger"><i data-feather="award" class="feather-icon"></i> Brand</a>
                    <a href="{{url('color')}}" target="_blank" class="btn text-danger"><i data-feather="sun" class="feather-icon"></i> Warna</a>
                    <a hidden href="{{url('label')}}" target="_blank" class="btn text-danger"><i data-feather="tag" class="feather-icon"></i> Label</a>
                    <a href="{{url('datakatalog')}}" target="_blank" class="btn text-danger"><i data-feather="edit-3" class="feather-icon"></i> Edit Katalog</a>
                    </h3>

                    </nav>
                    <hr>
                     
                    <div class="table-responsive">
                    <table id="examples" class="table table-striped table-bordered no-wrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Kategori Utama</th>
                                <th>Sub Kategori</th>
                                <th>Gambar</th>
                                <th>Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                          <?php foreach ($kategori as $value) { ?>
                            <tr>
                                <td>{{$value->id}}</td>
                                <td><?php if (isset($data_kategori[$value->main_kategori])): ?>
                                  {{$data_kategori[$value->main_kategori]}}
                                <?php endif; ?></td>
                                <td>{{$value->nama_kategori}}</td>
                                <td><img src="../../admin/gambar/kategori/{{$value->gbr}}" height="100px"></td>
                                <td>
                                  <button class="btn btn-default" onclick="edit('{{$value->id}}')"><i class="icon-pencil"></i></button>
                                  <button class="btn btn-default" onclick="Deleted('{{$value->nama_kategori}}','{{$value->id}}')"><i class="icon-trash"></i></button>
                                </td>
                            </tr>
                           <?php } ?>
                        </tbody>
                    </table>
                   <button type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#myModal">Tambah Sub Kategori Baru</button>
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
            <center><h3>Tambah Sub Kategori</h3></center>
            <form action="{{url('addkategorikatalog')}}" method="post" enctype="multipart/form-data">
            {{csrf_field()}}
            Pilih Kategori Utama:
            <select class="form-control" name="main_kategori" id="main_kategori">
              <?php foreach ($mainkategori as $key => $value): ?>
                <option value="{{$value->id}}">{{$value->nama_main_kategori}}</option>
              <?php endforeach; ?>
            </select>
            <br>
            Sub Kategori:
            <input required name="nama_kategori" type="text" required class="form-control" placeholder="Ketik nama sub kategori baru...">
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
            <center><h3>Ubah Sub Kategori</h3></center>
            <form action="{{url('updatekategorikatalog')}}" method="post" enctype="multipart/form-data">
            {{csrf_field()}}
            <input type="hidden" name="id" id="id">
            Kategori:
            <select class="form-control" name="main_kategori" id="main_kategori">
              <?php foreach ($mainkategori as $key => $value): ?>
                <option value="{{$value->id}}">{{$value->nama_main_kategori}}</option>
              <?php endforeach; ?>
            </select>
            <br>
            Sub Kategori:
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
           url: 'editkategorikatalog/'+value,
           type: 'get',
           dataType: 'json',
           async: false,
           success: function(response){
             document.getElementById("id").value = response[0]['id'];
             document.getElementById("nama_jabatan").value = response[0]['nama_kategori'];
             document.getElementById("main_kategori").value = response[0]['main_kategori'];
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
          location.href="{{url('/deletekategorikatalog/')}}"+"/"+value;
        }
      });
    }
    </script>

@endsection
