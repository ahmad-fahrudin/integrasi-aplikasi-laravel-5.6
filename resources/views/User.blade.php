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
                             <li class="breadcrumb-item text-muted" aria-current="page">Pengaturan > <a href="https://stokis.app/?s=user+admin" target="_blank">User Level Admin</a></li>
                          </ol>
                      </nav>
                    </h4>
                    <hr>
                    <br>

                    <div class="table-responsive">
                    <div class="card">
                            <div class="card-body">
                                <ul class="nav nav-tabs nav-left nav-bordered mb-3">
                                    <li class="nav-item">
                                        <a href="#single" data-toggle="tab" aria-expanded="true" class="nav-link active">
                                            <i class="mdi mdi-home-variant d-lg-none d-block mr-1"></i>
                                            <span class="d-none d-lg-block">Tambah User Admin</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#multiple" data-toggle="tab" aria-expanded="false" class="nav-link">
                                            <i class="mdi mdi-account-circle d-lg-none d-block mr-1"></i>
                                            <span class="d-none d-lg-block">Tambah User Investor</span>
                                        </a>
                                    </li>
                                </ul>
                                
                                <br>
                                <br>

                                <div class="tab-content">
                                    <div class="tab-pane show active" id="single">

                                      <div class="col-md-6">
                                      <form action="{{url('insertuser')}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="row">
                          <label class="col-lg-3">Nama Karyawan</label>
                          <div class="col-lg-8">
                            <div class="input-group">
                             <input type="text" required id="nama_nama" name="name" class="form-control" readonly style="background:#fff" placeholder="Pilih Karyawan">
                             <input id="nama_nik" name="nik" type="hidden" class="form-control">
                             <div class="input-group-append">
                                 <button class="btn btn-outline-secondary" onclick="cariuser()" type="button"><i class="fas fa-folder-open"></i></button>
                             </div>
                           </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Username</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input type="text" id="nama_username" required readonly name="username" class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Password</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input type="text" id="nama_password" readonly required name="password" class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Level Admin</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-12">
                                    <select required class="form-control" name="level">
                                      <?php foreach ($level as $value) { ?>
                                      <option value="{{$value->id}}">{{$value->nama_level}}</option>
                                      <?php } ?>
                                    </select>
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Akses Cabang</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-12">
                                    <select required class="form-control" name="gudang">
                                      <?php foreach ($gudang as $value) { ?>
                                      <option value="{{$value->id}}">{{$value->nama_gudang}}</option>
                                      <?php } ?>
                                    </select>
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br><br>
                        <div class="row">
                          <div class="col-lg-12">
                            <center>
                            <button class="btn btn-primary btn-lg"> Simpan </button>
                            </center>
                          </div>
                        </div>
                      </form>
                                      </div>
                                    </div>



                                    <div class="tab-pane" id="multiple">

                                      <div class="tab-pane show active" id="home-b2">
                                        <div class="col-md-6">
                                        <form action="{{url('insertuser')}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="row">
                          <label class="col-lg-3">Nama Investor</label>
                          <div class="col-lg-8">
                            <div class="input-group">
                             <input type="text" required id="nama_nama2" readonly name="name" class="form-control" style="background:#fff" placeholder="Pilih Investor">
                             <input id="nama_nik2" name="nik" type="hidden" class="form-control">
                             <div class="input-group-append">
                                 <button class="btn btn-outline-secondary" onclick="carinvestor()" type="button"><i class="fas fa-folder-open"></i></button>
                             </div>
                           </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Username</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input type="text" id="nama_username2" required readonly name="username" class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Password</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input type="text" id="nama_password2" readonly required name="password" class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Level Admin</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-12">
                                    <select required class="form-control" name="level">
                                      <?php foreach ($level as $value) { if ($value->nama_level == "Investor") {?>
                                      <option value="{{$value->id}}">{{$value->nama_level}}</option>
                                    <?php } }?>
                                    </select>
                                    <input type="hidden" name="gudang" value="1">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br><br>
                        <div class="row">
                          <div class="col-lg-12">
                            <center>
                            <button class="btn btn-primary btn-lg"> Simpan </button>
                            </center>
                          </div>
                        </div>
                      </form>
                                        </div>
                                      </div>

                                    </div>
                                </div>
                            </div> <!-- end card-body-->
                        </div> <!-- end card-->
					</div>
                    


                  <br>
                  <label><strong><h3>Data Akun User</h3></strong></label>
									<div class="table-responsive">
                  <table id="examples3" class="table table-striped table-bordered no-wrap" style="width:100%">
                      <thead>
                          <tr>
                              <th>No.</th>
                              <th>Nama Karyawan</th>
                              <th>Username</th>
                              <th>Level Admin</th>
                              <th>Akses Cabang</th>
                              <th>Tindakan</th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php $no=1;foreach ($users as $value) {?>
                          <tr>
                              <td align="center">{{$no}}</td>
                              <td>{{$value->name}}</td>
                              <td>{{$value->username}}</td>
                              <td>{{$value->nama_level}}</td>
                              <td>{{$value->nama_gudang}}</td>
                              <td>
                                <button class="btn btn-default" onclick="edit('{{$value->iduser}}')"><i class="icon-pencil"></i></button>
                                <button class="btn btn-default" onclick="Deleted('{{$value->name}}','{{$value->iduser}}')"><i class="icon-trash"></i></button>
                                <button class="btn btn-default" onclick="Reset('{{$value->name}}','{{$value->iduser}}')"><i class="icon-loop"></i></button>
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
          <h3>Edit Level Admin</h3>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <form action="{{url('updateuser')}}" method="post" enctype="multipart/form-data">
          {{csrf_field()}}
          <input type="hidden" name="id" id="id">
          Nama Karyawan:
          <input required id="name" name="name" type="text" readonly class="form-control">
          <br>
          Username:
          <input required id="username" name="username" type="text" readonly class="form-control">
          <input required id="nik" name="nik" type="hidden" class="form-control">
          <br>
          Level Admin:
          <select required id="level" class="form-control" name="level">
            <?php foreach ($level as $value) { ?>
            <option value="{{$value->id}}">{{$value->nama_level}}</option>
            <?php } ?>
          </select>
          <br>
          Akses Gudang:
          <select required id="gudang" class="form-control" name="gudang">
            <?php foreach ($gudang as $value) { ?>
            <option value="{{$value->id}}">{{$value->nama_gudang}}</option>
            <?php } ?>
          </select>
          <br>
          <div class="col-lg-12">
          <center><input type="submit" class="btn btn-primary" value="Update"></center>
          </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
    </div>

    <div class="modal fade" id="user" role="dialog">
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
                    <?php foreach ($new as $value){ ?>
                      <tr onclick="pilihuser('{{$value->nama}}','{{$value->nik}}')">
                          <td>{{$value->nik}}</td>
                          <td>{{$value->nama}}</td>
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

      <div class="modal fade" id="investor" role="dialog">
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
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Telepon</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($investor as $value){ ?>
                        <tr onclick="pilihuser2('{{$value->nama_investor}}','{{$value->nik}}')">
                            <td>{{$value->nik}}</td>
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script>
    function cariuser(){
      $('#user').modal('show');
    }
    function carinvestor(){
      $('#investor').modal('show');
    }
    function pilihuser(nama,nik){
      $('#user').modal('hide');
      document.getElementById("nama_nama").value = nama;
      document.getElementById("nama_username").value = nama;
      document.getElementById("nama_nik").value = nik;
      document.getElementById("nama_password").value = "12345678";
    }
    function pilihuser2(nama,nik){
      $('#investor').modal('hide');
      document.getElementById("nama_nama2").value = nama;
      document.getElementById("nama_username2").value = nama;
      document.getElementById("nama_nik2").value = nik;
      document.getElementById("nama_password2").value = "12345678";
    }
    function edit(value)
    {
        $.ajax({
           url: 'editUser/'+value,
           type: 'get',
           dataType: 'json',
           async: false,
           success: function(response){
               document.getElementById("id").value = response[0]['id'];
               document.getElementById("name").value = response[0]['name'];
               document.getElementById("username").value = response[0]['username'];
               document.getElementById("nik").value = response[0]['nik'];

               var x = document.getElementById("level");
               for (i = 0; i < x.length; i++) {
                       if (x.options[i].value == response[0]['level']) {
                         x.selectedIndex = i;
                   }
               }

               $('#editmodal').modal('show');
           }
         });
    }

    function Deleted(name,value)
    {
      Swal.fire(
        'Hapur User '+name+'?',
        'Apakah Anda Yakin?',
        'question'
      ).then((result) => {
        if (result.value) {
          location.href="{{url('/deleteuser/')}}"+"/"+value;
        }
      });
    }
    function Reset(name,value)
    {
      Swal.fire(
        'Reset Password '+name+'?',
        'Password akan direset ke <b>12345678</b>, Apakah Anda Yakin?',
        'question'
      ).then((result) => {
        if (result.value) {
          location.href="{{url('/resetuser/')}}"+"/"+value;
        }
      });
    }
    </script>
@endsection
