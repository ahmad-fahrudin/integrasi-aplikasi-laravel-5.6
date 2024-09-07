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
                              <li class="breadcrumb-item text-muted" aria-current="page">SDM > Karyawan > <a href="https://stokis.app/?s=input+karyawan" target="_blank">Input Karyawan Baru</a></li>
                          </ol>
                      </nav>
                    </h4>
                    <hr>
                    <br>
                    <form action="{{url('inputkaryawanact')}}" method="post" enctype="multipart/form-data">
                      {{csrf_field()}}
                    <div class="row">
                      <div class="col-md-6">
                        <div class="row">
                          <label class="col-lg-3">NIK</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input required name="nik" type="number" class="form-control" placeholder="Ketik No. ID Card / KTP atau No. HP Karyawan">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Nama Lengkap</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input required type="text" class="form-control" name="nama_lengkap" maxlength="30" placeholder="Ketik nama lengkap">
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
                                      <input required name="nama" type="text" class="form-control" maxlength="10" placeholder="Ketik nama panggilan / username akun">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Mulai Kerja</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input required name="mulai_kerja" type="date" class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Jabatan</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                    <select required class="form-control" name="jabatan">
                                        <option>--Pilih--</option>
                                      <?php foreach ($jabatan as $datajabatan) { ?>
                                      <option value="{{$datajabatan->id}}">{{$datajabatan->nama_jabatan}}</option>
                                      <?php } ?>
                                    </select>
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
                                      <textarea id="konten" required name="alamat" class="form-control" placeholder="Ketik nama Jalan (Pasar), Desa, RT/RW"></textarea>
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
                                      <input required name="no_hp" type="number" class="form-control" placeholder="Ketik No. HP / Whatsapp">
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
                                      <input type="text" name="nama_bank" maxlength="30" class="form-control" placeholder="Ketik Nama Bank untuk pembayaran Gaji / Insentif">
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
                                      <input type="text" name="no_rekening" maxlength="20" class="form-control" placeholder="Ketik No. Rekening Bank">
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
                                      <input type="text" name="ats_bank" maxlength="30" class="form-control" placeholder="Ketik nama pemilik rekening">
                                  </div>
                              </div>
                          </div>
                        </div>
                       
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Divisi</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <select required class="form-control" name="id_divisi">
                                        <option>--Pilih--</option>
                                      <?php foreach ($divisi as $datadivisi) { ?>
                                      <option value="{{$datadivisi->id_divisi}}">{{$datadivisi->nama_divisi}}</option>
                                      <?php } ?>
                                    </select>
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Status Karyawan</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <select class="form-control" name="status_pekerja">
                                         <option value="tetap">Tetap</option>
                                         <option value="harian">Harian</option>
                                         <option hidden value="peralihan 1">Peralihan 1</option>
                                         <option hidden value="peralihan 2">Peralihan 2</option>
                                         <option value="borongan">Borongan</option>
                                      </select>
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Gaji Pokok</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input type="number" name="gaji_pokok" class="form-control" placeholder="Ketik Gaji Pokok"  value="0">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">BPJS Kesehatan</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                  <input type="number" name="bpjs_kesehatan" class="form-control" placeholder="Ketik Pembayaran BPJS Kesehatan"  value="0">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">BPJS Ketenagakerjaan</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input type="number" name="bpjs_ketenagakerjaan" class="form-control" placeholder="Ketik Pembayaran BPJS Ketenagakerjaan"  value="0">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Pengembang</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <div class="input-group">
                                        <input required id="nama_pengembang" readonly name="nama_pengembang" type="text" class="form-control" placeholder="Pilih Pengembang" style="background:#fff">
                                        <input id="id_pengembang" type="hidden" name="pengembang" class="form-control">
                                        <div class="input-group-append">
                                            <button id="cari_barang" class="btn btn-outline-secondary" onclick="caripengembang()" <?php if(Auth::user()->level != "1"){ echo "disabled"; } ?> type="button"><i class="fas fa-folder-open"></i></button>
                                        </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Leader</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <div class="input-group">
                                        <input required id="nama_leader" readonly name="nama_leader" type="text" class="form-control" placeholder="Pilih Leader" style="background:#fff">
                                        <input id="id_leader" type="hidden" name="leader" class="form-control">
                                        <div class="input-group-append">
                                            <button id="cari_barang" class="btn btn-outline-secondary" onclick="carileader()" <?php if(Auth::user()->level != "1"){ echo "disabled"; } ?> type="button"><i class="fas fa-folder-open"></i></button>
                                        </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Berkas Lamaran</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input name="file" type="file">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
           
                        <center>
                          <input type="submit" value="SIMPAN" class=" btn btn-success btn-lg">
                          </form>
                        </center>
                      </div>
                    </div>
                    <br>
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
                      <tr onclick="pilihpengembang('{{$value->id}}','{{$value->nama}}')">
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
    
    
    <script>
        function caripengembang(){
          $('#pengembang').modal('show');
        }
        function carileader(){
          $('#leader').modal('show');
        }
        function pilihpengembang(id,nama){
          $('#pengembang').modal('hide');
          document.getElementById("nama_pengembang").value = nama;
          document.getElementById("id_pengembang").value = id;
        }
        function pilihleader(id,nama){
          $('#leader').modal('hide');
          document.getElementById("nama_leader").value = nama;
          document.getElementById("id_leader").value = id;
        }
    
          var konten = document.getElementById("konten");
            CKEDITOR.replace(konten,{
            language:'en-gb'
          });
          CKEDITOR.config.allowedContent = true;
        
        
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
