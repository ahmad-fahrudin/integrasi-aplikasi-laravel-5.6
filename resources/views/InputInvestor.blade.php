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
                              <li class="breadcrumb-item text-muted" aria-current="page"><a href="https://stokis.id/input-edit-dan-hapus-data-investor/" target="_blank">Input Investor Baru</a></li>
                          </ol>
                      </nav>
                    </h4>
                    <hr>
                    <br>
                    <div class="row">
                      <div class="col-md-6">
                          <form action="{{url('inputinvestoract')}}" method="post" enctype="multipart/form-data">
                          {{csrf_field()}}
                          <div class="row">
                            <label class="col-lg-3">NIK</label>
                            <div class="col-lg-9">
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="number" required name="nik" class="form-control" placeholder="Ketik No. ID Card / KTP">
                                    </div>
                                </div>
                            </div>
                          </div>
                          <br>
                        <div class="row">
                          <label class="col-lg-3">Nama Investor</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input type="text" maxlength="30" class="form-control" name="nama_lengkap" placeholder="Ketik nama Investor">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Username</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input type="text" maxlength="10" required name="nama_investor" class="form-control" placeholder="Ketik nama panggilan / username akun">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Alamat Lengkap</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <textarea name="alamat" maxlength="60" id="konten" required class="form-control"></textarea>
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">No. Telepon</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input type="text" maxlength="15" required name="no_hp" class="form-control" placeholder="Ketik No. HP / Whatsapp">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Nama Bank</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input type="text" maxlength="30" name="nama_bank" class="form-control" placeholder="Ketik nama bank">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">No. Rekening</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input type="text" maxlength="20" name="no_rekening" class="form-control" placeholder="Ketik Nomor Rekening Bank">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Atas Nama</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input type="text" maxlength="30" name="ats_bank" class="form-control" placeholder="Ketik nama pemilik rekening">
                                  </div>
                              </div>
                          </div>
                        </div>
                        
                        <div class="row">
                          <label class="col-lg-3">Catatan</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <textarea name="keterangan" maxlength="100" id="konten2" class="form-control"></textarea>
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Pengembang</label>
                          <div class="col-lg-9">
                            <div class="col-md-14">
                              <div class="input-group">
                                <input id="nama_investor" type="text" readonly class="form-control" placeholder="Pilih Pengembang" style="background:#fff">
                                <input id="id" name="pengembang" type="hidden" class="form-control">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" onclick="caribarang()" type="button"><i class="fas fa-folder-open"></i></button>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Leader</label>
                          <div class="col-lg-9">
                            <div class="col-md-14">
                              <div class="input-group">
                                <input id="nama_investor2" type="text" readonly class="form-control" placeholder="Pilih Leader" style="background:#fff">
                                <input id="id2" name="leader" type="hidden" class="form-control">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" onclick="caribarang2()" type="button"><i class="fas fa-folder-open"></i></button>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <br>
                        <center>
                          <button class="btn btn-success btn-lg">Simpan</button>
                        </center>
                       </form>
                      </div>

                    </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>


    <div class="modal fade" id="barang" role="dialog">
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
                          <th>Nama</th>
                          <th>Alamat</th>
                          <th>No. Telepon</th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($investor as $value){ ?>
                      <tr onclick="pilihbarang('{{$value->id}}','{{$value->nama_investor}}')">
                          <td>{{$value->nama_investor}}</td>
                          <td><?php echo $value->alamat; ?></td>
                          <td>{{$value->no_hp}}</td>
                      </tr>
                     <?php } ?>
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

      <div class="modal fade" id="barang2" role="dialog">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body">

                <div class="table-responsive">
                <table id="examples2" class="table table-striped table-bordered no-wrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>No. Telepon</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($investor as $value){ ?>
                        <tr onclick="pilihbarang2('{{$value->id}}','{{$value->nama_investor}}')">
                            <td>{{$value->nama_investor}}</td>
                            <td><?php echo $value->alamat; ?></td>
                            <td>{{$value->no_hp}}</td>
                        </tr>
                       <?php } ?>
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
      var konten = document.getElementById("konten");
        CKEDITOR.replace(konten,{
        language:'en-gb'
      });
      CKEDITOR.config.allowedContent = true;
    </script>
    <script>
      var konten2 = document.getElementById("konten2");
        CKEDITOR.replace(konten2,{
        language:'en-gb'
      });
      CKEDITOR.config.allowedContent = true;
    </script>
    <script>
    function caribarang(){
      $('#barang').modal('show');
    }
    function pilihbarang(id,nama){
      $('#barang').modal('hide');
      document.getElementById("id").value = id;
      document.getElementById("nama_investor").value = nama;
    }
    function caribarang2(){
      $('#barang2').modal('show');
    }
    function pilihbarang2(id,nama){
      $('#barang2').modal('hide');
      document.getElementById("id2").value = id;
      document.getElementById("nama_investor2").value = nama;
    }
    </script>
@endsection
