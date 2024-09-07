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
                              <li class="breadcrumb-item text-muted" aria-current="page">SDM > Karyawan > <a href="https://stokis.app/?s=data+karyawan" target="_blank">Data Karyawan</a></li>
                          </ol>
                      </nav>
                    </h4>
                    <hr>
                  <br>

				  <div class="table-responsive">
                  <table id="example" class="table table-striped table-bordered no-wrap" style="width:100%">
                      <thead>
                          <tr>
                              <th>No.</th>
                              <th>NIK</th>
                              <th>Nama Lengkap</th>
                              <th>Username</th>
                              <th>Jabatan</th>
                              <th>Mulai Kerja</th>
                              <th>Alamat</th>
                              <th>Kecamatan</th>
                              <th>Kabupaten/Kota</th>
                              <th>Provinsi</th>
                              <th>No. Telepon</th>
                              <th>Nama Bank</th>
                              <th>No. Rekening</th>
                              <th>Atas Nama</th>
                              <th>Pengembang</th>
                              <th>Leader</th>
                              <th>Berkas Lamaran</th>
                              <?php if (Auth::user()->level == "1"): ?>
                                <th>Tindakan</th>
                              <?php endif; ?>
                          </tr>
                      </thead>
                      <tbody>
                        <?php $no=1;foreach ($karyawan as $datakaryawan) { ?>
                          <tr>
                              <td align="center">{{$no}}</td>
                              <td>{{$datakaryawan->nik}}</td>
                              <td>{{$datakaryawan->nama_lengkap}}</td>
                              <td>{{$datakaryawan->nama}}</td>
                              <td>{{$datakaryawan->nama_jabatan}}</td>
                              <td>{{date("d-m-Y", strtotime($datakaryawan->mulai_kerja))}}</td>
                              <td><?php echo $datakaryawan->alamat; ?></td>
                              
                              <td>
                                <?php if (isset($data_kecamatan[$datakaryawan->kecamatan])){ ?>
                                  {{$data_kecamatan[$datakaryawan->kecamatan]}}
                                <?php }else{ ?>
                                  {{$datakaryawan->kecamatan}}
                                <?php } ?>
                              </td>
                              <td><?php if (isset($data_kabupaten[$datakaryawan->kota])){ ?>
                                {{$data_kabupaten[$datakaryawan->kota]}}
                              <?php }else{ ?>
                                {{$datakaryawan->kota}}
                              <?php } ?></td>
                              <td><?php if (isset($data_provinsi[$datakaryawan->provinsi])){ ?>
                                {{$data_provinsi[$datakaryawan->provinsi]}}
                              <?php }else{ ?>
                                {{$datakaryawan->provinsi}}
                              <?php } ?></td>
                              
                              <td>{{$datakaryawan->no_hp}}</td>
                              
                              <td>
                                <?php if ($datakaryawan->nama_bank){ ?>
                                  {{$datakaryawan->nama_bank}}
                                <?php }else{ ?>
                                  -
                                <?php } ?>
                                  </td>
                              <td>
                                <?php if ($datakaryawan->no_rekening){ ?>
                                  {{$datakaryawan->no_rekening}}</a>
                                <?php }else{ ?>
                                  -
                                <?php } ?>
                                  </td>
                              <td>
                                <?php if ($datakaryawan->ats_bank){ ?>
                                {{$datakaryawan->ats_bank}}
                                <?php }else{ ?>
                                  -
                                <?php } ?>
                                  </td>
                              
                              <td><?php if(isset($name_karyawan[$datakaryawan->pengembang])) { echo $name_karyawan[$datakaryawan->pengembang]; } ?></td>
                              <td><?php if(isset($name_karyawan[$datakaryawan->leader])) { echo $name_karyawan[$datakaryawan->leader]; } ?></td>
                               <td>
                                <?php if ($datakaryawan->file){ ?>
                                  <a href="<?php echo "gambar/file/".$datakaryawan->file; ?>" download>{{$datakaryawan->file}}</a>
                                <?php }else{ ?>
                                  -
                                <?php } ?>
                                  
                                  </td>
                              <?php if (Auth::user()->level == "1"): ?>
                              <td>
                                <button class="btn btn-default" onclick="edit('{{$datakaryawan->id}}')"><i class="icon-pencil"></i></button>
                                <button class="btn btn-default" onclick="Deleted('{{$datakaryawan->nama}}','{{$datakaryawan->id}}','{{$datakaryawan->no_hp}}')"><i class="icon-trash"></i></button>
                              </td>
                              <?php endif; ?>
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
        <h2>Edit Data Karyawan</h2>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <form action="{{url('updatekaryawan')}}" method="post" enctype="multipart/form-data">
          {{csrf_field()}}
          <input type="hidden" name="id" id="id">
          NIK:
          <input required id="nik" name="nik" type="text" class="form-control" maxlength="20">
          <input required id="old_nik" name="old_nik" type="hidden" class="form-control">
          <br>
          Nama lengkap:
          <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" maxlength="25">
          <br>
          Username:
          <input required id="nama" name="nama" type="text" readonly class="form-control" maxlength="10" style="background:#fff">
          <br>
          Jabatan:
          <select id="jabatan" required class="form-control" name="jabatan">
            <?php foreach ($jabatan as $datajabatan) { ?>
            <option value="{{$datajabatan->id}}">{{$datajabatan->nama_jabatan}}</option>
            <?php } ?>
          </select>
          <br>
          Mulai Kerja:
          <input required id="mulai_kerja" name="mulai_kerja" type="date" class="form-control">
          <br>
          Provinsi:
          <select required id="provinsis" name="provinsi" class="form-control" onchange="CProvinsi('kotas')">
            <option disabled selected>Pilih Provinsi</option>
            <?php foreach ($provinsi as $key => $value): ?>
            <option value="{{$value->id}}">{{$value->name}}</option>
            <?php endforeach; ?>
          </select>
          <br>
          Kabupaten / Kota:
          <select required name="kota"class="form-control" id="kotas" onchange="CKabupaten('kecamatans')">
            <option>Pilih Kabupaten/Kota</option>
          </select>
          <br>
          Kecamatan:
          <select required id="kecamatans" name="kecamatan" class="form-control">
              <option>Pilih Kecamatan</option>
          </select>
          
          <br>
          Alamat (Jalan, Desa, RT/RW):
          <textarea required id="konten2" name="alamat" class="form-control" maxlength="50"></textarea>
          <br>
          No. Telepon:
          <input required id="no_hp" name="no_hp" type="number" class="form-control">
          <input readonly id="old_hp" name="old_hp" type="hidden" class="form-control">
          
          <br>
          Nama Bank:
          <input id="nama_bank" name="nama_bank" type="text" class="form-control" maxlength="30" placeholder="Ketik Nama Bank untuk pembayaran Gaji / Insentif">
          <br>
          No Rekening:
          <input id="no_rekening" name="no_rekening" type="text" class="form-control" maxlength="16" placeholder="Ketik No. Rekening Bank">
          <br>
          Atas Nama:
          <input id="ats_bank" name="ats_bank" type="text" class="form-control" maxlength="30" placeholder="Ketik nama pemilik rekening">
          <br>
          Divisi
          <select id="id_divisi" required class="form-control" name="id_divisi">
            <?php foreach ($divisi as $datadivisi) { ?>
            <option value="{{$datadivisi->id_divisi}}">{{$datadivisi->nama_divisi}}</option>
            <?php } ?>
          </select>
           <br>
          Status Pekerja
            <select class="form-control" name="status_pekerja" id="status_pekerja">
                <option value="tetap">Tetap</option>
                <option value="harian">Harian</option>
                <option hidden value="peralihan 1">Peralihan 1</option>
                <option hidden value="peralihan 2">Peralihan 2</option>
                <option value="borongan">Borongan</option>
            </select>
         <br>
          Gaji Pokok:
            <input type="number" name="gaji_pokok"  class="form-control" id="gaji_pokok">
            <br>
          BPJS Kesehatan:
            <input type="number" name="bpjs_kesehatan"  class="form-control" id="bpjs_kesehatan">
            <br>
          BPJS Ketenagakerjaan:
           <input type="number" name="bpjs_ketenagakerjaan"  class="form-control" id="bpjs_ketenagakerjaan">
         
          <br>
          Pengembang:
          <div class="input-group">
            <input required id="nama_pengembang" readonly type="text" name="nama_pengembang" class="form-control" style="background:#fff">
            <input id="id_pengembang" type="hidden" name="pengembang" class="form-control">
            <div class="input-group-append">
                <button id="cari_barang" class="btn btn-outline-secondary" onclick="caripengembang()" <?php if(Auth::user()->level != "1"){ echo "disabled"; } ?> type="button"><i class="fas fa-folder-open"></i></button>
            </div>
          </div>
          <br>
          Leader:
          <div class="input-group">
            <input required id="nama_leader" readonly type="text" name="nama_leader" class="form-control" style="background:#fff">
            <input id="id_leader" type="hidden" name="leader" class="form-control">
            <div class="input-group-append">
                <button id="cari_barang" class="btn btn-outline-secondary" onclick="carileader()" <?php if(Auth::user()->level != "1"){ echo "disabled"; } ?> type="button"><i class="fas fa-folder-open"></i></button>
            </div>
          </div>
         <br>
          File:<br>
          <input name="file" type="file"><br>
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
    var konten = document.getElementById("konten2");
      CKEDITOR.replace(konten,{
      language:'en-gb'
    });
    CKEDITOR.config.allowedContent = true;
  </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script>
    const karyawan = [];
    <?php foreach ($karyawan as $key => $value) { $st = trim(preg_replace('/\s\s+/', ' ', $value->nama));?>
      karyawan[{{$value->id}}] = "{{$st}}";
    <?php } ?>


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

    function edit(value)
    {
        $.ajax({
           url: 'editKaryawan/'+value,
           type: 'get',
           dataType: 'json',
           async: false,
           success: function(response){
               document.getElementById("nik").value = response[0]['nik'];
               document.getElementById("old_nik").value = response[0]['nik'];
               document.getElementById("nama").value = response[0]['nama'];
               document.getElementById("id").value = response[0]['id'];
               CKEDITOR.instances['konten2'].setData(response[0]['alamat']);
               document.getElementById("nama_lengkap").value = response[0]['nama_lengkap'];
               document.getElementById("no_hp").value = response[0]['no_hp'];
               document.getElementById("old_hp").value = response[0]['no_hp'];
               document.getElementById("mulai_kerja").value = response[0]['mulai_kerja'];

               document.getElementById("ats_bank").value = response[0]['ats_bank'];
               document.getElementById("no_rekening").value = response[0]['no_rekening'];
               document.getElementById("nama_bank").value = response[0]['nama_bank'];
               
               document.getElementById("status_pekerja").value = response[0]['status_pekerja'];
               document.getElementById("gaji_pokok").value = response[0]['gaji_pokok'];
               document.getElementById("bpjs_kesehatan").value = response[0]['bpjs_kesehatan'];
               document.getElementById("bpjs_ketenagakerjaan").value = response[0]['bpjs_ketenagakerjaan'];

               if(response[0]['pengembang'] != null){
                   document.getElementById("id_pengembang").value = response[0]['pengembang'];
                   document.getElementById("nama_pengembang").value = karyawan[response[0]['pengembang']];
               }

               if(response[0]['leader'] != null){
                   document.getElementById("id_leader").value = response[0]['leader'];
                   document.getElementById("nama_leader").value = karyawan[response[0]['leader']];
               }

                var x = document.getElementById("jabatan");
                console.log(x.options.length);
                for (i = 0; i < x.length; i++) {
                        if (x.options[i].value == response[0]['idoption']) {
                          x.selectedIndex = i;
                    }
                }
                
                var t = document.getElementById("id_divisi");
                console.log(t.options.length);
                for (i = 0; i < t.length; i++) {
                        if (t.options[i].value == response[0]['idoption']) {
                          t.selectedIndex = i;
                    }
                }
                
               document.getElementById("provinsis").value = response[0]['provinsi'];
               document.getElementById("kotas").innerHTML = "";
               var y = document.getElementById("kotas");
               var options = document.createElement("option");
               options.text = "Pilih Kabupaten";
               y.add(options);
               for(j = 0; j < response['kabupaten'].length; j++){
                  var x = document.getElementById("kotas");
                  var option = document.createElement("option");
                  option.text = response['kabupaten'][j]['name'];
                  option.value = response['kabupaten'][j]['id'];
                  if (response['kabupaten'][j]['id'] == response[0]['kota']) {
                    option.selected = true;
                  }
                  x.add(option);
               }

               document.getElementById("kecamatans").innerHTML = "";
               var z = document.getElementById("kecamatans");
               var options = document.createElement("option");
               options.text = "Pilih Kecamatan";
               z.add(options);
               for(k = 0; k < response['kecamatan'].length; k++){
                  var v = document.getElementById("kecamatans");
                  var option = document.createElement("option");
                  option.text = response['kecamatan'][k]['name'];
                  option.value = response['kecamatan'][k]['id'];
                  if (response['kecamatan'][k]['id'] == response[0]['kecamatan']) {
                    option.selected = true;
                  }
                  v.add(option);
               }
                
                
               $('#editmodal').modal('show');
           }
         });
    }

    function Deleted(name,value,no_hp)
    {
      Swal.fire(
        'Hapus karyawan '+name+'?',
        'Apakah Anda Yakin?',
        'question'
      ).then((result) => {
        if (result.value) {
          location.href="{{url('/deleteKaryawan/')}}"+"/"+value+"/"+no_hp;
        }
      });
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
