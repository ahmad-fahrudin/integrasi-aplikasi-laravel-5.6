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
                              <li class="breadcrumb-item text-muted" aria-current="page">SDM > Supplier Barang > <a href="https://stokis.app/?s=supplier+barang" target="_blank">Data Supplier Barang</a></li>
                          </ol>
                      </nav>
                    </h4>
                    <hr>
                    <div style="border:2px dashed #eee;border-radius:20px; padding:20px; backgroud:#f5f5f5">
                    <p><strong>Filter Data Berdasarkan</strong></p>
                    <div class="form-group">
                         
                       <div class="row">
                           <div class="col-md-6">
                           <form name="form1" action="{{url('datasuplayer')}}" method="post" enctype="multipart/form-data">
                               {{csrf_field()}}
                           <div class="row">
                           <label class="col-lg-3">Lokasi Kulakan</label>
                           <div class="col-lg-8">
                             
                               <div class="row">
                                   <div class="col-md-11">
                                       <input onchange="change()" type="text"
                                       <?php if (isset($kota)): ?>
                                         value="{{$kota}}"
                                       <?php endif; ?> name="kota" maxlength="40" class="form-control" placeholder="Ketik nama Kabupaten/Kota">
                                   </div>
                                </div>
                            </div>
                            </div>
                         <br>   
                        <div class="row">
                           <div class="col-lg-3"></div>
                           <div class="col-lg-8">
                             
                               <div class="row">
                                   <div class="col-md-11 text-lg-left text-center">
                                     <button disabled id="filter" class="btn btn-success btn-lg">Filter Data</button>
                                     </div>
                                </div>

                           </div>
                        </div>
                       </form>
                       </div>
                       </div>
                       </div>
                      </div>
                
                  <hr><br>
									<div class="table-responsive">
                  <table
                  <?php if (Auth::user()->level == "1"){ ?>
                    id="example"
                  <?php }else{ ?>
                    id="examples"
                  <?php } ?>
                  id="example" class="table table-striped table-bordered no-wrap" style="width:100%">
                      <thead>
                          <tr>
                              <th>No.</th>
                              <th>ID Supplier</th>
                              <th>Nama Supplier</th>
                              <th>Alamat</th>
                              <th>Kabupaten/Kota</th>
                              <th>No. Telepon</th>
                              <th>Catatan</th>
                              <th>Tindakan</th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php $no=1;foreach ($suplayer as $value) { ?>
                          <tr>
                              <td align="center">{{$no}}</td>
                              <td>{{$value->id_suplayer}}</td>
                              <td>{{$value->nama_pemilik}}</td>
                              <td><?php echo $value->alamat; ?></td>
                              <td>{{$value->kota}}</td>
                              <td>{{$value->no_hp}}</td>
                              <td>
                                  <?php if ($value->keterangan){ ?>
                                  {{$value->keterangan}}</a>
                                <?php }else{ ?>
                                  -
                                <?php } ?>
                                  </td>
                              <td>
                                <button class="btn btn-default" onclick="edit('{{$value->id}}')"><i class="icon-pencil"></i></button>
                                <button class="btn btn-default" onclick="Deleted('{{$value->nama_pemilik}}','{{$value->id}}')"><i class="icon-trash"></i></button>
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
            <h3>Edit Data Supplier</h3>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <form action="{{url('updatesuplayer')}}" method="post" enctype="multipart/form-data">
            {{csrf_field()}}
            <input type="hidden" name="id" id="id">
            <br>
            ID Supplier:
            <input required id="id_suplayer" readonly name="id_suplayer" type="text" class="form-control">
            <br>
            Nama Supplier:
            <input required id="nama_pemilik" maxlength="40" name="nama_pemilik" class="form-control">
            <br>
            Alamat:
            <textarea required id="konten2" class="form-control" name="alamat"></textarea>
            <br>
            Kabupaten/Kota:
            <input required id="kota" maxlength="30" name="kota" type="text" class="form-control">
            <br>
            No. Telepon:
            <input required id="no_hp" maxlength="15" name="no_hp" type="number" class="form-control">
            <br>
            Catatan:
            <textarea id="keterangan" maxlength="100" name="keterangan" type="text" class="form-control"></textarea>
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
      var konten = document.getElementById("konten2");
        CKEDITOR.replace(konten,{
        language:'en-gb'
      });
      CKEDITOR.config.allowedContent = true;
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script>
    function edit(value)
    {
        $.ajax({
           url: 'editSuplayer/'+value,
           type: 'get',
           dataType: 'json',
           async: false,
           success: function(response){
             document.getElementById("id").value = response[0]['id'];
             document.getElementById("id_suplayer").value = response[0]['id_suplayer'];
             document.getElementById("nama_pemilik").value = response[0]['nama_pemilik'];
             //document.getElementById("alamat").value = response[0]['alamat'];
             document.getElementById("no_hp").value = response[0]['no_hp'];
             document.getElementById("kota").value = response[0]['kota'];
             document.getElementById("keterangan").value = response[0]['keterangan'];
             CKEDITOR.instances['konten2'].setData(response[0]['alamat']);
             $('#editmodal').modal('show');
           }
         });
    }

    function change(){
      var empt = document.forms["form1"]["kota"].value;
      if (empt != "")
        {
          document.getElementById("filter").disabled = false;
        }
    }

    function Deleted(name,value)
    {
      Swal.fire(
        'Hapus '+name+'?',
        'Apakah Anda Yakin?',
        'question'
      ).then((result) => {
        if (result.value) {
          location.href="{{url('/deleteSuplayer/')}}"+"/"+value;
        }
      });
    }
    </script>
@endsection
