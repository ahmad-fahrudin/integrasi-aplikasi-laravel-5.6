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
                              <li class="breadcrumb-item text-muted" aria-current="page">Pengaturan > <a href="https://stokis.app/?s=inpu+edit+rekening+bank+perusahaan" target="_blank">Akun Bank Perusahaan</a></li>
                          </ol>
                      </nav>
                    </h4>
                     <?php if (Auth::user()->level == "1" ): ?> 
                    <hr>
                    <br>
                    <div class="row">
                      <div class="col-md-6">
                        <form action="{{url('insertrekening')}}" method="post" enctype="multipart/form-data">
                          {{csrf_field()}}
                        <div class="row">
                          <label class="col-lg-6"><strong>Tambah Akun Bank</strong></label>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Nama Bank</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input required type="text" name="nama" class="form-control" placeholder="Ketik nama Bank...">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">No Rekening</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input required type="text" name="no_rekening" class="form-control" placeholder="Ketik nomor rekening...">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Atas Nama</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input required name="ats" type="text" class="form-control" placeholder="Ketik nama pemilik rekening...">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <div class="col-lg-12">
                                <center>
                                <button class="btn btn-primary btn-lg"> Tambah </button>
                                </center>
                          </div>
                        </div>
                       </form>
                      </div>
                    </div>

                  <br><br><hr><br>
                <?php endif; ?>
                  <label><strong>Data Akun Bank Perusahaan</strong></label>
									<div class="table-responsive">
                  <table class="table table-striped table-bordered no-wrap" style="width:100%">
                      <thead>
                          <tr>
                              <th>No</th>
                              <th>Nama Bank</th>
                              <th>No Rekening</th>
                              <th>Atas nama</th>
                              <th>Tindakan</th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php $no=1;foreach ($rekening as $value) {?>
                          <tr>
                              <td>{{$no}}</td>
                              <td>{{$value->nama}}</td>
                              <td>{{$value->no_rekening}}</td>
                              <td>{{$value->ats}}</td>
                              <td>
                                <button class="btn btn-default" onclick="edit('{{$value->id}}','{{$value->nama}}','{{$value->no_rekening}}','{{$value->ats}}')"><i class="icon-pencil"></i></button>
                                <button class="btn btn-default" onclick="Deleted('{{$value->nama}}','{{$value->id}}')"><i class="icon-trash"></i></button>
                              </td>
                          </tr>
                         <?php $no++;} ?>
                      </tbody>
                  </table>
								</div>
              </div>
            </div>
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
          <form action="{{url('updaterekening')}}" method="post" enctype="multipart/form-data">
          {{csrf_field()}}
          <input type="hidden" name="id" id="id">
          Nama Rekening:
          <input required id="nama" name="nama" type="text" class="form-control">
          No Rekening:
          <input required id="no_rek" name="no_rekening" type="text" class="form-control">
          Atas Nama:
          <input required id="ats" name="ats" type="text" class="form-control">
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

    <script>
      var konten = document.getElementById("konten");
        CKEDITOR.replace(konten,{
        language:'en-gb'
      });
      CKEDITOR.config.allowedContent = true;
    </script>
    <script>
      var konten = document.getElementById("konten2");
        CKEDITOR.replace(konten,{
        language:'en-gb'
      });
      CKEDITOR.config.allowedContent = true;
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script>
    function edit(value,nama,no,ats)
    {
       document.getElementById("id").value = value;
       document.getElementById("nama").value = nama;
       document.getElementById("no_rek").value = no;
       document.getElementById("ats").value = ats;
       $('#editmodal').modal('show');
    }

    function Deleted(name,value)
    {
      Swal.fire(
        'Delete '+name+'?',
        'Apakah Anda Yakin?',
        'question'
      ).then((result) => {
        if (result.value) {
          location.href="{{url('/deleterekening/')}}"+"/"+value;
        }
      });
    }
    </script>

@endsection
