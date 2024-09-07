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
                              <li class="breadcrumb-item text-muted" aria-current="page">Barang Masuk</li>
                              <li class="breadcrumb-item text-muted" aria-current="page">Data Barang Masuk</li>
                          </ol>
                      </nav>
                    </h4>
                    <hr>
                    <div class="row">
                      <div class="col-md-6">
                    <form action="{{url('updatebarangmasuk')}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <input type="hidden" value="{{$barang[0]->id}}" name="id" id="id">
                        Suplayer:
                        <div class="input-group">

                        <input id="id_suplayer" name="suplayer" type="hidden" value="{{$barang[0]->id_suplayer}}" class="form-control">
                        <input type="text" readonly required id="nama_suplayer" value="{{$barang[0]->suplayer}}" class="form-control">

                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" onclick="carisuplayer()" type="button"><i class="fas fa-folder-open"></i></button>
                        </div>
                        </div>
                        Jumlah:
                        <input required name="jumlah" type="number" value="{{$barang[0]->jumlah}}" id="jumlah" class="form-control">
                        <input required name="tempjumlah" type="hidden" value="{{$barang[0]->jumlah}}" id="jumlah_temp" class="form-control">
                        <input required name="gudang" type="hidden" value="{{$barang[0]->gudang}}" id="jumlah" class="form-control">
                        <input required name="barang" type="hidden" value="{{$barang[0]->barang}}" id="jumlah" class="form-control">
                        Driver:
                        <div class="input-group">

                        <input id="id_driver" name="driver" type="hidden" value="{{$barang[0]->id_driver}}" class="form-control">
                        <input type="text" readonly required value="{{$barang[0]->driver}}" id="nama_driver" class="form-control">

                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" onclick="caridriver()" type="button"><i class="fas fa-folder-open"></i></button>
                        </div>
                        </div>
                        Admin:
                        <div class="input-group">

                        <input id="id_admin" name="admin" type="hidden" value="{{$barang[0]->id_admin}}" class="form-control">
                        <input type="text" readonly class="form-control" value="{{$barang[0]->admin}}" id="nama_admin">

                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" onclick="cariadmin()" type="button"><i class="fas fa-folder-open"></i></button>
                        </div>
                        </div>
                        QC:
                        <div class="input-group">

                        <input id="id_qc" type="hidden" name="qc" value="{{$barang[0]->id_qc}}" class="form-control">
                        <input required type="text" readonly value="{{$barang[0]->qc}}" id="nama_qc" class="form-control">

                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" onclick="cariqc()" type="button"><i class="fas fa-folder-open"></i></button>
                        </div>
                        </div>
                        <br>
                        <center><input type="submit" class="btn btn-primary" value="Update"></center>
                    </form>
                    </div>
                    </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="suplayer" role="dialog">
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
                          <th>ID Suplayer</th>
                          <th>Nama Pemilik</th>
                          <th>Alamat</th>
                          <th>Telepon</th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($suplayer as $value){ ?>
                      <tr onclick="pilihsuplayer('{{$value->id}}','{{$value->nama_pemilik}}')">
                          <td>{{$value->id_suplayer}}</td>
                          <td>{{$value->nama_pemilik}}</td>
                          <td>{{$value->alamat}}</td>
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

      <div class="modal fade" id="drv" role="dialog">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body">

                <div class="table-responsive">
                <table id="examples1" class="table table-striped table-bordered no-wrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Telepon</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($driver as $value){ ?>
                        <tr onclick="pilihdriver('{{$value->id}}','{{$value->nama}}')">
                            <td>{{$value->nik}}</td>
                            <td>{{$value->nama}}</td>
                            <td>{{$value->alamat}}</td>
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

        <div class="modal fade" id="qcs" role="dialog">
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
                              <th>NIK</th>
                              <th>Nama</th>
                              <th>Alamat</th>
                              <th>Telepon</th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($qc as $value){ ?>
                          <tr onclick="pilihqc('{{$value->id}}','{{$value->nama}}')">
                              <td>{{$value->nik}}</td>
                              <td>{{$value->nama}}</td>
                              <td>{{$value->alamat}}</td>
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

        <div class="modal fade" id="admins" role="dialog">
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
                              <th>ID</th>
                              <th>Nama</th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($admin as $value){ ?>
                          <tr onclick="pilihadmin('{{$value->id}}','{{$value->name}}')">
                              <td>{{$value->id}}</td>
                              <td>{{$value->name}}</td>
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
      <script>

          function carisuplayer(){
            $('#suplayer').modal('show');
          }
          function caridriver(){
            $('#drv').modal('show');
          }
          function cariqc(){
            $('#qcs').modal('show');
          }
          function cariadmin(){
            $('#admins').modal('show');
          }

          function pilihsuplayer(id,nama){
            $('#suplayer').modal('hide');
            document.getElementById("nama_suplayer").value = nama;
            document.getElementById("id_suplayer").value = id;
          }
          function pilihdriver(id,nama){
            $('#drv').modal('hide');
            document.getElementById("id_driver").value = id;
            document.getElementById("nama_driver").value = nama;
          }
          function pilihqc(id,nama){
            $('#qcs').modal('hide');
            document.getElementById("id_qc").value = id;
            document.getElementById("nama_qc").value = nama;
          }
          function pilihadmin(id,nama){
            $('#admins').modal('hide');
            document.getElementById("id_admin").value = id;
            document.getElementById("nama_admin").value = nama;
          }

      </script>
@endsection
