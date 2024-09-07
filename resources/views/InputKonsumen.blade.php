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
                              <li class="breadcrumb-item text-muted" aria-current="page">SDM > Member > <a href="https://stokis.app/?s=input+konsumen" target="_blank">Input Member (Konsumen) Baru</a></li>
                          </ol>
                      </nav>
                    </h4>
                    <hr>
                    <br>
                    <form action="{{url('inputkonsumenact')}}" method="post" enctype="multipart/form-data">
                    <div class="row">
                        {{csrf_field()}}
                      <div class="col-md-6">
                        <div class="row">
                          <label class="col-lg-3">ID Member</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input type="text" required name="id_konsumen" readonly class="form-control" value="{{'PLG'.date('ymd').$number}}">
                                  </div>
                              </div>
                          </div>
                        </div>
                        
                        <br>
                        <div class="row">
                          <label class="col-lg-3">NIK</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input type="number" required name="nik" class="form-control" placeholder="Ketik No. ID Card / KTP atau No. HP Konsumen">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Nama</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input type="text" maxlength="30" required name="nama_pemilik" class="form-control" placeholder="Ketik Nama Konsumen (Nama Usaha + Pemilik)">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        
                        <div class="row">
                          <label class="col-lg-3">Provinsi</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                    <select required id="provinsis" name="provinsi" class="form-control" onchange="CProvinsi('kotas')">
                                      <option disabled selected>Pilih Provinsi</option>
                                      <?php foreach ($provinsi as $key => $value): ?>
                                      <option value="{{$value->id}}">{{$value->name}}</option>
                                      <?php endforeach; ?>
                                    </select>
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Kabupaten/Kota</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                    <select required name="kota"class="form-control" id="kotas" onchange="CKabupaten('kecamatans')">
                                      <option>Pilih Kabupaten/Kota</option>
                                    </select>
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Kecamatan</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                    <select required id="kecamatans" name="kecamatan" class="form-control">
                                        <option>Pilih Kecamatan</option>
                                    </select>
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        
                        <div class="row">
                          <label class="col-lg-3">Alamat<br>(Jalan, Desa RT/RW)</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <textarea required name="alamat" maxlength="40" id="konten" required class="form-control" placeholder="Ketik nama Jalan, Desa RT/RW atau nama Pasar"></textarea>
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
                                      <input type="number" required name="no_hp" class="form-control" placeholder="Ketik No. HP / Whatsapp">
                                  </div>
                              </div>
                          </div>
                        </div>
                       
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Keterangan<br>(Share Lokasi)</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                    <textarea name="keterangan" id="konten2" class="form-control" maxlength="100" placeholder="Kerangan tambahan (opsional)"></textarea>
                                    <!--input type="text" required name="keterangan" class="form-control"-->
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Status Member</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                    <select name="jenis_konsumen" class="form-control">
                                        <?php foreach(status_konsumen_all() as $key => $v){ ?>
                                            <option value="{{$key+1}}">{{$v}}</option>
                                        <?php } ?>
                                    </select>
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Kategori Pajak<br>(*) Perusahaan</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <select name="kategori_konsumen" class="form-control">
                                          <option>Non PKP</option>
                                          <option>PKP</option>
                                      </select>
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row"
                       <?php  if(Auth::user()->level != "1") {
                        echo "hidden";
                        } ?>
                        >
                          <label class="col-lg-3">Cabang</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <select name="kategori" class="form-control">
                                        <?php if (Auth::user()->level == "1"){ ?>
                                          <?php foreach ($kategori as $value): ?>
                                            <option value="{{$value->id}}">{{$value->nama_kategori}}</option>
                                          <?php endforeach; ?>
                                        <?php }else{
                                          foreach ($kategori as $value):
                                          if ($value->id == Auth::user()->gudang) { ?>
                                          <option value="{{$value->id}}">{{$value->nama_kategori}}</option>
                                        <?php } endforeach; }?>
                                      </select>
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div hidden class="row">
                          <label class="col-lg-3">Limit Piutang</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input type="number" required name="limit_piutang" value="10000000" class="form-control" placeholder="Batas Maksimal Piutang" data-a-sign="" data-a-dec="," data-a-pad=false data-a-sep=".">
                                  </div>
                              </div>
                          </div>
                        </div>

                        <div hidden class="row">
                          <label class="col-lg-3">Tempo Piutang</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-4">
                                      <input type="number" required name="tempo_piutang" value="30" class="form-control" placeholder="Jangka Waktu Piutang">
                                  </div>
                                  <div class="col-md-4">
                                      hari
                                  </div>
                              </div>
                          </div>
                        </div>

                        <br>
                        <div class="row">
                          <label class="col-lg-3">Referral</label>
                          <div class="col-lg-9">
                            <div class="input-group">
                              <input required id="nama_referal" type="text" readonly class="form-control" placeholder="Pilih Pereferral Member" style="background:#fff">
                              <input id="id_referal" type="hidden" name="referal_by" class="form-control" <?php if(isset($idpengembang)) { echo "value = '".$idpengembang."'"; } ?>>
                              
                                <div class="input-group-append">
                                    <button id="cari_barang" class="btn btn-outline-secondary" onclick="cariupline('referal')" type="button"><i class="fas fa-folder-open"></i></button>
                                </div>
                              
                            </div>
                          </div>
                        </div>
                        
                        <div hidden class="row">
                          <label class="col-lg-3">Upline 1</label>
                          <div class="col-lg-9">
                            <div class="input-group">
                              <input id="nama_reseller" readonly type="text" class="form-control" placeholder="Upline Pereferral">
                               <input id="id_reseller" type="hidden" name="reseller" class="form-control" <?php if(isset($idpengembang)) { echo "value = '".$idpengembang."'"; } ?>>
                              <?php if(Auth::user()->level != 5){ ?>
                                <div class="input-group-append">
                                    <button id="cari_barang" class="btn btn-outline-secondary" onclick="cariupline('reseller')" type="button"><i class="fas fa-folder-open"></i></button>
                                </div>
                              <?php } ?>
                            </div>
                          </div>
                        </div>
                        
                        <div hidden class="row">
                          <label class="col-lg-3">Upline 2</label>
                          <div class="col-lg-9">
                            <div class="input-group">
                              <input id="nama_agen" readonly type="text" class="form-control" placeholder="Pilih Upline 2">
                              <input id="id_agen" type="hidden" name="agen" class="form-control" <?php if(isset($idleader)) { echo "value = '".$idleader."'"; } ?>>
                              <?php if(Auth::user()->level != 5){ ?>
                                <div class="input-group-append">
                                    <button id="cari_barang" class="btn btn-outline-secondary" onclick="cariupline('agen')" type="button"><i class="fas fa-folder-open"></i></button>
                                </div>
                              <?php } ?>
                            </div>
                          </div>
                        </div>
                        
                        <div hidden class="row">
                          <label class="col-lg-3">Upline 3</label>
                          <div class="col-lg-9">
                            <div class="input-group">
                              <input id="nama_distributor" readonly type="text" class="form-control" placeholder="Pilih Upline 3">
                              <input id="id_distributor" type="hidden" name="distributor" class="form-control" <?php if(isset($idmanager)) { echo "value = '".$idmanager."'"; } ?>>
                              <?php if(Auth::user()->level != 5){ ?>
                                <div class="input-group-append">
                                    <button id="cari_barang" class="btn btn-outline-secondary" onclick="cariupline('distributor')" type="button"><i class="fas fa-folder-open"></i></button>
                                </div>
                              <?php } ?>
                            </div>
                          </div>
                        </div>

                        <br>
                        <div class="row">
                          <label class="col-lg-3">Pengembang</label>
                          <div class="col-lg-9">
                            <div class="input-group">
                              <input required id="nama_kategori" readonly type="text" class="form-control" placeholder="Pilih Pengembang" style="background:#fff"
                              <?php if (Auth::user()->level == "5"): ?>
                                value="{{$namapengembang}}"
                              <?php endif; ?>>
                              <input required id="id_kategori" readonly type="hidden" name="pengembang" class="form-control"
                              <?php if (Auth::user()->level == "5"): ?>
                                value="{{$idpengembang}}"
                              <?php endif; ?>>
                              <?php if (Auth::user()->level != "5"): ?>
                                <div class="input-group-append">
                                    <button id="cari_barang" class="btn btn-outline-secondary" onclick="caripengembang()" type="button"><i class="fas fa-folder-open"></i></button>
                                </div>
                              <?php endif; ?>
                            </div>
                          </div>
                        </div>

                        
                        <div hidden class="row">
                          <label class="col-lg-3">Leader</label>
                          <div class="col-lg-9">
                            <div class="input-group">
                              <input id="nama_leader" readonly type="text" class="form-control" placeholder="Pilih Leader">
                              <input id="id_leader" type="hidden" name="leader" class="form-control" <?php if(isset($idleader)) { echo "value = '".$idleader."'"; } ?>>
                              <?php if(Auth::user()->level != 5){ ?>
                                <div class="input-group-append">
                                    <button id="cari_barang" class="btn btn-outline-secondary" onclick="carileader()" type="button"><i class="fas fa-folder-open"></i></button>
                                </div>
                              <?php } ?>
                            </div>
                          </div>
                        </div>

                        
                        <div hidden class="row">
                          <label class="col-lg-3">Manager</label>
                          <div class="col-lg-9">
                            <div class="input-group">
                              <input id="nama_manager" readonly type="text" class="form-control" placeholder="Pilih Manager">
                              <input id="id_manager" type="hidden" name="manager" class="form-control" <?php if(isset($idmanager)) { echo "value = '".$idmanager."'"; } ?>>
                              <?php if(Auth::user()->level != 5){ ?>
                                <div class="input-group-append">
                                    <button id="cari_barang" class="btn btn-outline-secondary" onclick="carimanager()" type="button"><i class="fas fa-folder-open"></i></button>
                                </div>
                              <?php } ?>
                            </div>
                          </div>
                        </div>
                        <br>

                        <center>
                          <button class="btn btn-success btn-lg">SIMPAN</button>
                        </center>
                      </div>
                    </form>
                    </div>
                    <br>

                    <?php if (Auth::user()->level == "1"): ?>
                    <form method="post" action="{{url('/import/import_konsumen')}}" enctype="multipart/form-data">
                    <!--div class="row">
                      <div class="col-md-6">
                        <div class="row">
                          <label class="col-lg-6"><strong>Import Konsumen</strong></label>
                        </div>
                        <div class="row">
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      {{ csrf_field() }}
                                      <input name="file" type="file">
                                      <button class="btn btn-success">Upload Konsumen</button>
                                  </div>
                              </div>
                          </div>
                        </div>
                      </div>
                    </div-->
                    </form>
                    <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="pengembang" role="dialog">
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
                          <th hidden>NIK</th>
                          <th>Nama</th>
                          <th>Alamat</th>
                          <th>Telepon</th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($pengembang as $value){ ?>
                      <tr onclick="pilihpengembang('{{$value->id}}','{{$value->nama}}','{{$value->pengembang}}','{{$value->leader}}')">
                          <td hidden>{{$value->nik}}</td>
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

      <div class="modal fade" id="leader" role="dialog">
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
                            <th hidden>NIK</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Telepon</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($pengembang as $value){ ?>
                        <tr onclick="pilihleader('{{$value->id}}','{{$value->nama}}')">
                            <td hidden>{{$value->nik}}</td>
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


        <div class="modal fade" id="manager" role="dialog">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body">

                <div class="table-responsive">
                <table id="examples5" class="table table-striped table-bordered no-wrap" style="width:100%">
                    <thead>
                        <tr>
                            <th hidden>NIK</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Telepon</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($pengembang as $value){ ?>
                        <tr onclick="pilihmanager('{{$value->id}}','{{$value->nama}}')">
                            <td hidden>{{$value->nik}}</td>
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
        
        
        <div class="modal fade" id="upline" role="dialog">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body">

                <div class="table-responsive">
                <table id="examples4" class="table table-striped table-bordered no-wrap" style="width:100%">
                    <thead>
                        <tr>
                            <th hidden>NIK</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Telepon</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($pengembang as $value){ ?>
                        <tr onclick="pilihupline('{{$value->id}}','{{$value->nama}}')">
                            <td hidden>{{$value->nik}}</td>
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
        
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>

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
        const karyawan = [];
        <?php foreach ($pengembang as $key => $value) { $st = trim(preg_replace('/\s\s+/', ' ', $value->nama));?>
          karyawan[{{$value->id}}] = "{{$st}}";
        <?php } ?>

        <?php if(isset($idmanager)) { ?>
            document.getElementById("nama_manager").value = karyawan[{{$idmanager}}];
            document.getElementById("nama_distributor").value = karyawan[{{$idmanager}}];
        <?php } ?>

        <?php if(isset($idleader)) { ?>
            document.getElementById("nama_agen").value = karyawan[{{$idleader}}];
            document.getElementById("nama_leader").value = karyawan[{{$idleader}}];
        <?php } ?>
        
        
      function caripengembang(){
        $('#pengembang').modal('show');
      }
      function carileader(){
        $('#leader').modal('show');
      }
      function carimanager(){
        $('#manager').modal('show');
      }
      
      var upl = "";
      function cariupline(value){
        $('#upline').modal('show');
        upl = value;
      }
      
      
      function pilihpengembang(id,nama,leader,manager){
        $('#pengembang').modal('hide');
        document.getElementById("nama_kategori").value = nama;
        document.getElementById("id_kategori").value = id;
        if(leader != ""){
            document.getElementById("id_leader").value = leader;
            document.getElementById("nama_leader").value = karyawan[leader];
        }else{
            document.getElementById("id_leader").value = "";
            document.getElementById("nama_leader").value = "";
        }
        if(manager != ""){
            document.getElementById("nama_manager").value = karyawan[manager];
            document.getElementById("id_manager").value = manager;
        }else{
            document.getElementById("nama_manager").value = "";
            document.getElementById("id_manager").value = "";
        }


      }
      
      function pilihupline(id,nama){
        $('#upline').modal('hide');
        console.log(upl);
        document.getElementById("nama_"+upl).value = nama;
        document.getElementById("id_"+upl).value = id;
        
        if(upl == "referal"){
            $.ajax({
             url: 'getagenreseller/'+id,
             type: 'get',
             dataType: 'json',
             async: false,
             success: function(response){
                document.getElementById("nama_reseller").value = response['nama_reseller'];
                document.getElementById("id_reseller").value = response['reseller'];
                document.getElementById("nama_agen").value = response['nama_agen'];
                document.getElementById("id_agen").value = response['agen'];
                document.getElementById("nama_distributor").value = response['nama_distributor'];
                document.getElementById("id_distributor").value = response['distributor'];
             }
        });
        }
        
      }
      
      function pilihleader(id,nama){
        $('#leader').modal('hide');
        document.getElementById("nama_leader").value = nama;
        document.getElementById("id_leader").value = id;
      }
      function pilihmanager(id,nama){
        $('#manager').modal('hide');
        document.getElementById("nama_manager").value = nama;
        document.getElementById("id_manager").value = id;
      }
      
      
      function CProvinsi(key){
        var val = document.getElementById("provinsis").value;
        $.ajax({
             url: 'getkabupaten/'+val,
             type: 'get',
             dataType: 'json',
             async: false,
             success: function(response){
               document.getElementById(key).innerHTML = "";
               var y = document.getElementById(key);
               var options = document.createElement("option");
               options.text = "Pilih Kabupaten";
               y.add(options);
               for (var i = 0; i < response.length; i++) {
                  var x = document.getElementById(key);
                  var option = document.createElement("option");
                  option.text = response[i]['name'];
                  option.value = response[i]['id'];
                  x.add(option);
               }
             }
        });
      }

      function CKabupaten(key){
      var val = document.getElementById("kotas").value;
      $.ajax({
           url: 'getkecamatan/'+val,
           type: 'get',
           dataType: 'json',
           async: false,
           success: function(response){
             document.getElementById(key).innerHTML = "";

             var y = document.getElementById(key);
             var options = document.createElement("option");
             options.text = "Pilih Kecamatan";
             y.add(options);

             for (var i = 0; i < response.length; i++) {
                var x = document.getElementById(key);
                var option = document.createElement("option");
                option.text = response[i]['name'];
                option.value = response[i]['id'];
                x.add(option);
             }
           }
      });
    }

      </script>
@endsection
