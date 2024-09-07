@extends('template/nav')
@section('content')
  <script src="{{asset('system/assets/ckeditor/ckeditor.js')}}"></script>
    <div class="page-wrapper">
        <div class="container-fluid">
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">
                      <nav aria-label="breadcrumb">
                          <ol class="breadcrumb ">
                              <li class="breadcrumb-item text-muted" aria-current="page">Pemasaran > Poin Hadiah > <a href="https://stokis.app/?s=tambah+hadiah+poin+member" target="_blank">Daftar Hadiah</a></li>
                          </ol>
                      </nav>
                    </h4>
                    <hr>

                    <div class="row">
                      <div class="col-md-6">
                        <div class="row">
                          <label class="col-lg-6"><strong>Input Hadiah Baru</strong></label>
                        </div>
                        <br>
                        <form action="{{url('simpan_hadiah')}}" method="post" enctype="multipart/form-data">
                          {{csrf_field()}}
                        <div class="row">
                          <label class="col-lg-3">Nama Hadiah</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input type="text" required class="form-control" name="nama" placeholder="Ketik Nama Hadiah">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Jumlah Poin</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input type="text" required name="jumlah_poin" class="form-control" placeholder="Ketik Jumlah Penukaran Poin">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Gambar</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input type="file" required name="gbr">
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
                                      <center><input type="submit" value="Simpan" class="btn btn-primary"></center>
                                  </div>
                              </div>
                          </div>
                        </div>
                        </form>
                        <br>
                        </div>
                    </div>

                    <hr>
                    <div class="table-responsive">
                    <table id="insentif_table" class="table table-striped table-bordered no-wrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Hadiah</th>
                                <th>Jumlah Poin</th>
                                <th>Gambar</th>
                                <th>Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                          <?php $no=1; foreach ($hadiah as $key => $value): ?>
                            <tr>
                              <td>{{$no}}</td>
                              <td>{{$value->nama}}</td>
                              <td>{{ribuan($value->jumlah_poin)}}</td>
                              <td><img src="gambar/hadiah/{{$value->gbr}}" width="300"></td>
                              <td>
                                <button class="btn btn-primary" onclick="Edit('{{$value->id}}','{{$value->nama}}','{{$value->jumlah_poin}}')">edit</button>
                                <button class="btn btn-danger" onclick="Hapus('{{$value->id}}','{{$value->nama}}')">hapus</button>
                              </td>
                            </tr>
                          <?php $no++; endforeach; ?>
                        </tbody>
                    </table>
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
          <div class="modal-body">
            <br>
            <form action="{{url('/updatehadiah')}}" method="post" enctype="multipart/form-data">
            {{csrf_field()}}
            Nama Hadiah<br><input type="text" id="nama" name="nama" class="form-control"><br>
            Jumlah Poin<br><input type="text" id="jumlahpoin" name="jumlah_poin" class="form-control"><br>
            <input type="hidden" name="id" id="id">
            Gambar<br><input type="file" name="gbr"><br><br>
            <input type="submit" value="Update" class="form-control btn-success">
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
    function Edit(id,nama,jumlahpoin){
      document.getElementById("nama").value = nama;
      document.getElementById("jumlahpoin").value = jumlahpoin;
      document.getElementById("id").value = id;
      $('#myModal').modal('show');
    }
    function Hapus(id,nama){
      Swal.fire(
        'Hapus '+'\n'+nama+' ?',
        'Apakah Anda Yakin?',
        'question'
      ).then((result) => {
        if (result.value) {
          location.href="{{url('/hapushadiah/')}}/"+id;
        }
      });
    }
    </script>
@endsection
