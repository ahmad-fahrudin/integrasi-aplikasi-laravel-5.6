@extends('template/nav')
@section('content')
<script src="{{asset('system/assets/ckeditor/ckeditor.js')}}"></script>
    <div class="page-wrapper">
        <div class="container-fluid">
            <div class="row">

              <div class="col-md-6">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">
                      <nav aria-label="breadcrumb">
                          <ol class="breadcrumb ">
                              <li class="breadcrumb-item text-muted" aria-current="page">Pengaturan > <a href="https://stokis.app/?s=manager+area" target="_blank">Data Manager Area</a></li>
                          </ol>
                      </nav>
                    </h4>
                    <hr>
				<div class="table-responsive">
                  <table id="examples" class="table table-striped table-bordered no-wrap" style="width:100%">
                      <thead>
                          <tr>
                              <th>No</th>
                              <th hidden>ID</th>
                              <th>Manager</th>
                              <th>Kota</th>
                              <th>Tindakan</th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php $no=1;foreach ($manager as $value){ ?>
                          <tr>
                              <td>{{$no}}</td>
                              <td hidden>{{$value->id}}</td>
                              <td>{{$value->nama}}</td>
                              <td>{{$value->kota}}</td>
                              <td>
                                <button class="btn btn-default" onclick="edit('{{$value->id}}','{{$value->nama}}','{{$value->manager}}','{{$value->kota}}')"><i class="icon-pencil"></i></button>
                                <button class="btn btn-default" onclick="Deleted('{{$value->id}}','{{$value->nama}}','{{$value->manager}}','{{$value->kota}}')"><i class="icon-trash"></i></button>
                              </td>
                          </tr>
                         <?php $no++;} ?>
                      </tbody>
                  </table>
		             </div>
              </div>
            </div>
          </div>

            <div class="col-md-6">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb ">
                            <li class="breadcrumb-item text-muted" aria-current="page">Pengaturan > <a href="https://stokis.app/?s=pembagian+area+pemasaran" target="_blank">Input Manager Area</a></li>
                        </ol>
                    </nav>
                  </h4>
                  <hr>

                  <form action="{{url('inputmanager')}}" method="post" enctype="multipart/form-data">
                    {{csrf_field()}}
                    Manager:
                    <div class="input-group">
                      <input id="nama_manager" readonly type="text" class="form-control" placeholder="Pilih Manager Area">
                      <input id="id_manager" type="hidden" name="manager" class="form-control">
                      <div class="input-group-append">
                          <button id="cari_barang" class="btn btn-outline-secondary" onclick="carimanager()" type="button"><i class="fas fa-folder-open"></i></button>
                      </div>
                    </div>
                    <br>
                    Pilih Kota:
                    <input required id="kota"  type="text" class="form-control" placeholder="Ketik dan pilih kota/kab..." onkeyup="showResult(this.value)">
                    <input type="hidden" class="form-control" name="kota" id="val_kota">
                    <input type="hidden" class="form-control" name="id_kota" id="id_kota">
                    <div id="livesearch"></div>
                    <br>
                    <center><input type="submit" class="btn btn-primary" value="Simpan"></center>
                  </form>

            </div>
          </div>
        </div>

        </div>
      </div>
    </div>


    <div class="modal fade" id="edit" role="dialog">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">

              <form action="{{url('updatemanager')}}" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
                <input type="hidden" name="id" id="id">
                Manager:
                <div class="input-group">
                  <input id="nama_m" readonly type="text" class="form-control">
                  <input id="id_m" type="hidden" name="manager" class="form-control">
                  <div class="input-group-append">
                      <button id="cari_barang" class="btn btn-outline-secondary" onclick="carimanager2()" type="button"><i class="fas fa-search"></i></button>
                  </div>
                </div>
                Pilih Kota:
                <input required id="city" name="kota" type="text" class="form-control" placeholder="Ketik kota/kab..." onkeyup="showResultcity(this.value)">
                <input type="hidden" class="form-control" name="kota" id="val_city">
                <input type="hidden" class="form-control" name="id_kota" id="id_city">
                <div id="livesearchcity"></div>
                <br>
                <center><input type="submit" class="btn btn-primary" value="Simpan"></center>
              </form>

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
              <table id="examples2" class="table table-striped table-bordered no-wrap" style="width:100%">
                  <thead>
                      <tr>
                          <th>NIK</th>
                          <th>Nama</th>
                          <th>Alamat</th>
                          <th>No. Telepon</th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($karyawan as $value){ ?>
                      <tr onclick="pilihmanager('{{$value->id}}','{{$value->nama}}')">
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

      <div class="modal fade" id="manager2" role="dialog">
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
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>No. Telepon</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($karyawan as $value){ ?>
                        <tr onclick="pilihmanager2('{{$value->id}}','{{$value->nama}}')">
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


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script>
    function carimanager(){
      $('#manager').modal('show');
    }
    function pilihmanager(id,nama){
      $('#manager').modal('hide');
      document.getElementById("nama_manager").value = nama;
      document.getElementById("id_manager").value = id;
    }

    function carimanager2(){
      $('#manager2').modal('show');
    }
    function pilihmanager2(id,nama){
      $('#manager2').modal('hide');
      document.getElementById("nama_m").value = nama;
      document.getElementById("id_m").value = id;
    }

    function edit(id,nama,manager,kota){
      document.getElementById('city').value = kota;
      document.getElementById('nama_m').value = nama;
      document.getElementById('id_m').value = manager;
      document.getElementById('id').value = id;
      $('#edit').modal('show');
    }

    function Deleted(id,nama,manager,kota)
    {
      Swal.fire(
        'Delete '+kota+' dengan Manager '+nama+'?',
        'Apakah Anda Yakin?',
        'question'
      ).then((result) => {
        if (result.value) {
          location.href="{{url('/deleteManager/')}}"+"/"+id;
        }
      });
    }


    function showResult(str) {
      if(str != ""){
        $.ajax({
           url: 'carikota/'+str,
           type: 'get',
           dataType: 'json',
           async: false,
           success: function(response){
             document.getElementById("livesearch").innerHTML = "";
             if (response.length > 0) {
               for (var i = 0; i < response.length; i++) {
                 var temp = response[i]['id']+","+'"'+response[i]['name']+'"'+","+'"'+response[i]['type']+'"';
                 document.getElementById("livesearch").innerHTML += "<button class='btn btn-default' type='button' onclick='PilihOrg("+temp+")'>"+response[i]['type']+" "+response[i]['name']+"</button>"+"<br>";
               }
             }else{
               document.getElementById("livesearch").innerHTML = "";
             }
           }
         });
      }
    }


    function PilihOrg(id,nama,tipe){
      document.getElementById("kota").value = tipe+" "+nama;
      document.getElementById("val_kota").value = nama;
      document.getElementById("id_kota").value = id;
      document.getElementById("livesearch").innerHTML = "";
    }

    function showResultcity(str) {
      if(str != ""){
        $.ajax({
           url: 'carikota/'+str,
           type: 'get',
           dataType: 'json',
           async: false,
           success: function(response){
             document.getElementById("livesearchcity").innerHTML = "";
             if (response.length > 0) {
               for (var i = 0; i < response.length; i++) {
                 var temp = response[i]['id']+","+'"'+response[i]['name']+'"'+","+'"'+response[i]['type']+'"';
                 document.getElementById("livesearchcity").innerHTML += "<button class='btn btn-default' type='button' onclick='PilihOrgcity("+temp+")'>"+response[i]['type']+" "+response[i]['name']+"</button>"+"<br>";
               }
             }else{
               document.getElementById("livesearchcity").innerHTML = "";
             }
           }
         });
      }
    }


    function PilihOrgcity(id,nama,tipe){
      document.getElementById("city").value = tipe+" "+nama;
      document.getElementById("val_city").value = nama;
      document.getElementById("id_city").value = id;
      document.getElementById("livesearchcity").innerHTML = "";
    }
    </script>

@endsection
