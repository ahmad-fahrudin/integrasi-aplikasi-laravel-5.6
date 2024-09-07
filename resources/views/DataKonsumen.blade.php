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
                              <li class="breadcrumb-item text-muted" aria-current="page">SDM > Member > <a href="https://stokis.app/?s=konsumen" target="_blank">Data Member</a></li>
                          </ol>
                      </nav>
                    </h4>
                    <hr>
                    <div style="border:2px dashed #eee;border-radius:20px; padding:20px; backgroud:#f5f5f5">
                    <p><strong>Filter Data Berdasarkan</strong></p>
                    <form name="form1" action="{{url('datakonsumen')}}" method="post" enctype="multipart/form-data">
                      {{csrf_field()}}
                    <div class="form-group">
                       <div class="row">
                           <label class="col-lg-2">Domisili Member</label>
                           <div class="col-lg-6">
                               <div class="row">
                                   <div class="col-md-11">
                                       <input type="text" onchange="change()" id="kota"
                                       <?php if (isset($kota)): ?>
                                         value="{{$kota}}"
                                       <?php endif; ?>
                                        name="kota" class="form-control" placeholder="Ketik nama Kabupaten/Kota">
                                   </div>
                               </div>
                           </div>
                       </div>
                       <br>
                       <div class="row">
                           <label class="col-lg-2">Cabang</label>
                           <div class="col-lg-6">
                               <div class="row">
                                   <div class="col-md-11">
                                     <select name="kategori" onchange="change2()" class="form-control">
                                          <?php if (Auth::user()->level == "1"): ?>
                                              <option value="all">Semua</option>
                                          <?php endif; ?>
                                       <?php foreach ($kategori as $value): ?>
                                         <option value="{{$value->id}}"
                                           <?php if (isset($v_kategori)): ?>
                                             <?php if ($v_kategori == $value->id): ?>
                                               selected
                                             <?php endif; ?>
                                           <?php endif; ?>
                                          >{{$value->nama_kategori}}</option>
                                       <?php endforeach; ?>
                                     </select>
                                   </div>
                               </div>
                           </div>
                       </div>
                       <br>
                       <div class="row">
                           <div class="col-lg-2"></div>
                           <div class="col-lg-6">
                             
                               <div class="row">
                                   <div class="col-md-11 text-lg-left text-center">
                                     <button disabled id="filter" class="btn btn-success btn-lg">Filter Data</button>
                                     </div>
                                </div>

                           </div>
                        </div>
                     </div>
                   </form>
                   </div>
                  <hr><br>
									<div class="table-responsive">
                  <table
                  <?php if (Auth::user()->level == "1"){ ?>
                    id="example"
                  <?php }else{ ?>
                    id="examples"
                  <?php } ?>
                    class="table table-striped table-bordered no-wrap" style="width:100%">
                      <thead>
                          <tr>
                              <th>No.</th>
                              <th>ID Member</th>
                              <th>NIK</th>
                              <th>Nama Konsumen</th>
                              <th>Alamat</th>
                              <th>Kecamatan</th>
                              <th>Kabupaten/Kota</th>
                              <th>Provinsi</th>
                              <th>No. Telepon</th>
                              <th>Email</th>
                              <th>Cabang</th>
                              
                              <th>Status Member</th>
                              <th>Referal Daftar</th>
                              <th hidden>Upline 1</th>
                              <th hidden>Upline 2</th>
                              <th hidden>Upline 3</th>
                              
                              <th>Pengembang</th>
                              <th hidden>Leader</th>
                              <th hidden>Manager</th>
                     
                              <th hidden>Kategori Pajak</th>
                              <th hidden>Limit Piutang (Max)</th>
                              <th hidden>Tempo Piutang (Hari)</th>
                              
                              <th>Keterangan</th>
                              
                              <th>Tindakan</th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php  $no=1;foreach ($konsumen as $value){ ?>
                          <tr>
                              <td align="center">{{$no}}</td>
                              <td>{{$value->id_konsumen}}</td>
                              <td>{{$value->nik}}</td>
                              <td>{{$value->nama_pemilik}}</td>
                              <td><?php echo $value->alamat; ?></td>
                              <td>
                                <?php if (isset($data_kecamatan[$value->kecamatan])){ ?>
                                  {{$data_kecamatan[$value->kecamatan]}}
                                <?php }else{ ?>
                                  {{$value->kecamatan}}
                                <?php } ?>
                              </td>
                              <td><?php if (isset($data_kabupaten[$value->kota])){ ?>
                                {{$data_kabupaten[$value->kota]}}
                              <?php }else{ ?>
                                {{$value->kota}}
                              <?php } ?></td>
                              <td><?php if (isset($data_provinsi[$value->provinsi])){ ?>
                                {{$data_provinsi[$value->provinsi]}}
                              <?php }else{ ?>
                                {{$value->provinsi}}
                              <?php } ?></td>
                              <td>{{$value->no_hp}}</td>
                              <td>
                                <?php if ($value->email){ ?>
                                {{$value->email}}
                                <?php }else{ ?>
                                  -
                                <?php } ?>
                                  </td>
                              <td>{{$value->nama_kategori}}</td>
                              
                              <td>{{status_konsumen($value->jenis_konsumen)}}</td>
                              <td><?php if(isset($value->referal_by)){ echo $karyawan[$value->referal_by]; } ?></td>
                              <td hidden><?php if(isset($value->reseller)){ echo $karyawan[$value->reseller]; } ?></td>
                              <td hidden><?php if(isset($value->agen)){ echo $karyawan[$value->agen]; } ?></td>
                              <td hidden><?php if(isset($value->distributor)){ echo $karyawan[$value->distributor]; } ?></td>
                              
                              <td><?php if ($value->karyawan == null){
                                echo $value->konsumen;
                              }else{
                                echo $value->karyawan;
                              }?></td>
                              <td hidden><?php if (isset($karyawan[$value->leader])){
                                  echo $karyawan[$value->leader];
                                }else{
                                  if (isset($customer[$value->leader])){
                                      echo $customer[$value->leader];
                                    }
                                } ?>
                              </td>
                              <td hidden><?php if (isset($karyawan[$value->manager])){
                                  echo $karyawan[$value->manager];
                                }else{
                                  if (isset($customer[$value->manager])){
                                      echo $customer[$value->manager];
                                    }
                                } ?>
                              </td>
                              
                              <td hidden><?php echo $value->kategori_konsumen; ?></td>
                              <td hidden align="right"><?php echo ribuan($value->limit_piutang); ?></td>
                              <td hidden align="center"><?php echo $value->tempo_piutang; ?></td>
                              
                              <td>
                                <?php if ($value->keterangan){ ?>
                                <?php echo $value->keterangan; ?>
                                <?php }else{ ?>
                                  -
                                <?php } ?>
                                  </td>
                              
                              <td>
                                <button class="btn btn-default" onclick="edit('{{$value->id}}')"><i class="icon-pencil"></i></button>
                                <?php if (Auth::user()->level == "1"): ?>
                                <button class="btn btn-default" onclick="Deleted('{{$value->nama_pemilik}}','{{$value->id}}','{{$value->no_hp}}')"><i class="icon-trash"></i></button>
                                <?php endif; ?>
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
        <h2>Edit Data Member</h2>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <form action="{{url('updatekonsumen')}}" method="post" enctype="multipart/form-data">
          {{csrf_field()}}
          <input type="hidden" name="id" id="id">
          ID Member:
          <input required id="id_konsumen" readonly name="id_konsumen" type="text" class="form-control">
          <br>
          NIK:
          <input required readonly maxlength="20" id="nik"  name="nik" type="text" class="form-control">
          <input required id="old_hp" readonly name="old_hp" type="hidden" class="form-control">
          <br>
          Nama Konsumen:
          <input required readonly maxlength="30" id="nama_pemilik" <?php if(Auth::user()->level != "1"){ echo "readonly"; } ?> name="nama_pemilik" class="form-control">
          <br>
          Provinsi:
          <select required id="provinsis" name="provinsi" class="form-control" onchange="CProvinsi('kotas')">
            <option disabled selected>Pilih Provinsi</option>
            <?php foreach ($provinsi as $key => $value): ?>
            <option value="{{$value->id}}">{{$value->name}}</option>
            <?php endforeach; ?>
          </select>
          <br>
          Kabupaten/Kota:
          <select name="kota"class="form-control" id="kotas" onchange="CKabupaten('kecamatans')">
            <option>Pilih Kabupaten/Kota</option>
          </select>
          <br>
          Kecamatan:
          <select id="kecamatans" name="kecamatan" class="form-control">
              <option>Pilih Kecamatan</option>
          </select>
          <br>
          Alamat (Jalan, Desa RT/RW):
          <textarea id="konten2" maxlength="40" class="form-control" name="alamat"></textarea>
          <br>
          No. Telepon:
          <input required id="no_hp" name="no_hp" <?php if(Auth::user()->level != "1"){ echo "readonly"; } ?> type="number" class="form-control">
          <br>
           <br>
         
            Status Member:
            <select name="jenis_konsumen" id="jenis_konsumen" class="form-control">
                <?php foreach(status_konsumen_all() as $key => $v){ ?>
                    <option value="{{$key+1}}">{{$v}}</option>
                <?php } ?>
            </select>
          <br>
          Kategori Pajak (*) Perusahaan:
          <select name="kategori_konsumen" id="kategori_konsumen" class="form-control">
              <option>PKP</option>
              <option>Non PKP</option>
          </select>
          <br>
          Cabang:
          <select name="kategori" id="kategori" <?php if(Auth::user()->level != "1"){ echo "disabled"; } ?> class="form-control">
            <?php foreach ($kategori as $value): ?>
              <option value="{{$value->id}}">{{$value->nama_kategori}}</option>
            <?php endforeach; ?>
          </select>
          <br>
          Limit Piutang:
          <input type="number" required id="limit_piutang" name="limit_piutang" class="form-control" placeholder="Batas maksimal piutang">
          <br>
          Tempo Piutang (Hari):
          <input type="number" required id="tempo_piutang" name="tempo_piutang" class="form-control" placeholder="Jangka waktu piutang">
          <br>
          Pereferral:
          <div class="input-group">
            <input required id="nama_referal" readonly type="text" class="form-control" style="background:#fff">
            <input id="referal_by" type="hidden" name="referal_by" class="form-control">
            <div class="input-group-append">
                <button id="cari_barang" class="btn btn-outline-secondary" onclick="carirefer('nama_referal','referal_by')" <?php if(Auth::user()->level != "1"){ echo "disabled"; } ?> type="button"><i class="fas fa-folder-open"></i></button>
            </div>
          </div>
          <br>
          Upline 1:
          <div class="input-group">
            <input required id="nama_reseller" readonly type="text" class="form-control" style="background:#fff">
            <input id="reseller" type="hidden" name="reseller" class="form-control">
            <div class="input-group-append">
                <button id="cari_barang" class="btn btn-outline-secondary" onclick="carirefer('nama_reseller','reseller')" <?php if(Auth::user()->level != "1"){ echo "disabled"; } ?> type="button"><i class="fas fa-folder-open"></i></button>
            </div>
          </div>
          <br>
          Upline 2:
          <div class="input-group">
            <input required id="nama_agen" readonly type="text" class="form-control" style="background:#fff">
            <input id="agen" type="hidden" name="agen" class="form-control">
            <div class="input-group-append">
                <button id="cari_barang" class="btn btn-outline-secondary" onclick="carirefer('nama_agen','agen')" <?php if(Auth::user()->level != "1"){ echo "disabled"; } ?> type="button"><i class="fas fa-folder-open"></i></button>
            </div>
          </div>
          <br>
          Upline 3:
          <div class="input-group">
            <input required id="nama_distributor" readonly type="text" class="form-control" style="background:#fff">
            <input id="distributor" type="hidden" name="distributor" class="form-control">
            <div class="input-group-append">
                <button id="cari_barang" class="btn btn-outline-secondary" onclick="carirefer('nama_distributor','distributor')" <?php if(Auth::user()->level != "1"){ echo "disabled"; } ?> type="button"><i class="fas fa-folder-open"></i></button>
            </div>
          </div>
          <br>
          Pengembang:
          <div class="input-group">
            <input required id="nama_kategori" readonly type="text" class="form-control" style="background:#fff">
            <input id="id_kategori" type="hidden" name="pengembang" class="form-control">
            <div class="input-group-append">
                <button id="cari_barang" class="btn btn-outline-secondary" onclick="caripengembang()" <?php if(Auth::user()->level != "1"){ echo "disabled"; } ?> type="button"><i class="fas fa-folder-open"></i></button>
            </div>
          </div>
          <br>
          Leader:
          <div class="input-group">
            <input required id="nama_leader" readonly type="text" class="form-control" style="background:#fff">
            <input id="id_leader" type="hidden" name="leader" class="form-control">
            <div class="input-group-append">
                <button id="cari_barang" class="btn btn-outline-secondary" onclick="carileader()" <?php if(Auth::user()->level != "1"){ echo "disabled"; } ?> type="button"><i class="fas fa-folder-open"></i></button>
            </div>
          </div>
          <br>
          Manager:
          <div class="input-group">
            <input required id="nama_manager" readonly type="text" class="form-control" style="background:#fff">
            <input id="id_manager" type="hidden" name="manager" class="form-control">
            <div class="input-group-append">
                <button id="cari_barang" class="btn btn-outline-secondary" onclick="carimanager()" <?php if(Auth::user()->level != "1"){ echo "disabled"; } ?> type="button"><i class="fas fa-folder-open"></i></button>
            </div>
          </div>
          <br>
          Keterangan:
          <textarea id="keterangan" name="keterangan" maxlength="100" type="text" class="form-control"></textarea>
          
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
                          <th>NIK</th>
                          <th>Nama</th>
                          <th>Alamat</th>
                          <th>Telepon</th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($pengembang as $value){ ?>
                      <tr onclick="pilihpengembang('{{$value->id}}','{{$value->nama}}')">
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
        
        
        <div class="modal fade" id="refer" role="dialog">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body">

                <div class="table-responsive">
                    <input type="hidden" id="id_r">
                    <input type="hidden" id="nama_r">
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
                        <tr onclick="pilihrefer('{{$value->id}}','{{$value->nama}}')">
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

      <script>
        var keterangan = document.getElementById("keterangan");
          CKEDITOR.replace(keterangan,{
          language:'en-gb'
        });
        CKEDITOR.config.allowedContent = true;
      </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script>
    function caripengembang(){
      $('#pengembang').modal('show');
    }
    function carileader(){
      $('#leader').modal('show');
    }
    function carimanager(){
      $('#manager').modal('show');
    }
    function carirefer(nama,id){
        document.getElementById("id_r").value = id;
        document.getElementById("nama_r").value = nama;
        $('#refer').modal('show');
    }
    function pilihpengembang(id,nama){
      $('#pengembang').modal('hide');
      document.getElementById("nama_kategori").value = nama;
      document.getElementById("id_kategori").value = id;
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
    function pilihrefer(id,nama){
        var id_to = document.getElementById("id_r").value;
        var nama_to = document.getElementById("nama_r").value;
        document.getElementById(id_to).value = id;
        document.getElementById(nama_to).value = nama;
        $('#refer').modal('hide');
    }
    function edit(value)
    {
        $.ajax({
           url: 'editKonsumen/'+value,
           type: 'get',
           dataType: 'json',
           async: false,
           success: function(response){
               document.getElementById("id").value = response['konsumen'][0]['id'];
               document.getElementById("id_konsumen").value = response['konsumen'][0]['id_konsumen'];
               document.getElementById("nama_pemilik").value = response['konsumen'][0]['nama_pemilik'];
               //document.getElementById("alamat").value = response[0]['alamat'];
               CKEDITOR.instances['konten2'].setData(response['konsumen'][0]['alamat']);
               document.getElementById("no_hp").value = response['konsumen'][0]['no_hp'];
               document.getElementById("old_hp").value = response['konsumen'][0]['no_hp'];
               document.getElementById("jenis_konsumen").value = response['konsumen'][0]['jenis_konsumen'];

               document.getElementById("provinsis").value = response['konsumen'][0]['provinsi'];
               
               document.getElementById("kategori_konsumen").value = response['konsumen'][0]['kategori_konsumen'];
               document.getElementById("tempo_piutang").value = response['konsumen'][0]['tempo_piutang'];
               document.getElementById("limit_piutang").value = response['konsumen'][0]['limit_piutang'];
               
               CKEDITOR.instances['keterangan'].setData(response['konsumen'][0]['keterangan']);
               //document.getElementById("keterangan").value = response[0]['keterangan'];
               document.getElementById("nama_kategori").value = response['konsumen'][0]['karyawan'];
               document.getElementById("nama_leader").value = response['konsumen'][0]['nama_leader'];
               document.getElementById("nama_manager").value = response['konsumen'][0]['nama_manager'];
               
               document.getElementById("nama_referal").value = response['konsumen'][0]['nama_referal'];
               document.getElementById("nama_reseller").value = response['konsumen'][0]['nama_reseller'];
               document.getElementById("nama_agen").value = response['konsumen'][0]['nama_agen'];
               document.getElementById("nama_distributor").value = response['konsumen'][0]['nama_distributor'];
               
               document.getElementById("nik").value = response['konsumen'][0]['nik'];


               var x = document.getElementById("kategori");
               console.log(x.options.length);
               for (i = 0; i < x.length; i++) {
                       if (x.options[i].value == response['konsumen'][0]['kategori']) {
                         x.selectedIndex = i;
                   }
               }



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
                  if (response['kabupaten'][j]['id'] == response['konsumen'][0]['kota']) {
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
                  if (response['kecamatan'][k]['id'] == response['konsumen'][0]['kecamatan']) {
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
        'Hapus Member '+name+'?',
        'Apakah Anda Yakin?',
        'question'
      ).then((result) => {
        if (result.value) {
          location.href="{{url('/deleteKonsumen/')}}"+"/"+value+"/"+no_hp;
        }
      });
    }
    function change2(){
        document.getElementById("filter").disabled = false;
    }
    function change(){
      var empt2 = document.getElementById("kota").value;
      if (empt2 != "")
        {
          document.getElementById("filter").disabled = false;
        }
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
