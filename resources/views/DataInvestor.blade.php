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
                              <li class="breadcrumb-item text-muted" aria-current="page">Data Investor</li>
                          </ol>
                      </nav>
                    </h4>
                    <hr>
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
                              <th>No</th>
                              <th>NIK</th>
                              <th>Nama Lengkap</th>
                              <th>Username</th>
                              <th>Alamat Lengkap</th>
                              <th>No. Telepon</th>
                              <th>No. Rekening</th>
                              <th>Atas Nama</th>
                              <th>Nama Bank</th>
                              <th>Keterangan</th>
                              <?php if (Auth::user()->level == "1" || Auth::user()->level == "4"): ?>
                                <th>Pengembang</th>
                                <th>Leader</th>
                              <?php endif; ?>
                              <th>Tindakan</th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php $no=1;foreach ($investor as $value) { ?>
                          <tr>
                              <td>{{$no}}</td>
                              <td>{{$value->nik}}</td>
                              <td>{{$value->nama_lengkap}}</td>
                              <td>{{$value->nama_investor}}</td>
                              <td><?php echo $value->alamat; ?></td>
                              <td>{{$value->no_hp}}</td>
                              <td>{{$value->no_rekening}}</td>
                              <td>{{$value->ats_bank}}</td>
                              <td>{{$value->nama_bank}}</td>
                              <td><?php echo $value->keterangan; ?></td>
                              <?php if (Auth::user()->level == "1" || Auth::user()->level == "4"): ?>
                                <td><?php if (isset($inv[$value->pengembang])) { echo $inv[$value->pengembang]; }else{ $inv[$value->pengembang] = ""; } ?></td>
                                <td><?php if (isset($inv[$value->leader])) { echo $inv[$value->leader]; }else{ $inv[$value->leader] = ""; } ?></td>
                              <?php endif; ?>
                              <td>
                                <button class="btn btn-default" onclick="edit('{{$value->id}}','{{$inv[$value->pengembang]}}','{{$inv[$value->leader]}}')"><i class="icon-pencil"></i></button>
                                <button class="btn btn-default" onclick="Deleted('{{$value->nama_investor}}','{{$value->id}}')"><i class="icon-trash"></i></button>
                              </td>
                          </tr>
                         <?php $no++; } ?>
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
            <form action="{{url('updateinvestor')}}" method="post" enctype="multipart/form-data">
            {{csrf_field()}}
            <input type="hidden" name="id" id="id">
            NIK:
            <input required id="nik" name="nik" type="text" class="form-control">
            <input required id="old_nik" name="old_nik" type="hidden" class="form-control">
            Nama Lengkap:
            <input type="text" id="nama_lengkap" name="nama_lengkap" class="form-control">
            Username:
            <input required id="nama_investor" name="nama_investor" type="text" readonly class="form-control">
            Alamat Lengkap:
            <textarea id="konten2" class="form-control" name="alamat"></textarea>
            No. Telepon:
            <input required id="no_hp" name="no_hp" type="number" class="form-control">
            No. Rekening:
            <input id="no_rekening" name="no_rekening" type="text" class="form-control">
            Atas Nama:
            <input id="ats_bank" name="ats_bank" type="text" class="form-control">
            Nama Bank:
            <input id="nama_bank" name="nama_bank" type="text" class="form-control">
            Keterangan:
            <input required id="keterangan" name="keterangan" type="text" class="form-control">
            Pengembang:
            <div class="input-group">
              <input id="nama_investor2" name="nama_pengembang" type="text" class="form-control">
              <input id="id2" name="pengembang" type="hidden" class="form-control">
              <div class="input-group-append">
                  <button class="btn btn-outline-secondary" onclick="caribarang()" type="button"><i class="fas fa-search"></i></button>
              </div>
            </div>
            Leader:
            <div class="input-group">
              <input id="nama_investor3" name="nama_leader" type="text" class="form-control">
              <input id="id3" name="leader" type="hidden" class="form-control">
              <div class="input-group-append">
                  <button class="btn btn-outline-secondary" onclick="caribarang2()" type="button"><i class="fas fa-search"></i></button>
              </div>
            </div>
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
                      </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($investor as $value){ ?>
                      <tr onclick="pilihbarang('{{$value->id}}','{{$value->nama_investor}}')">
                          <td>{{$value->nama_investor}}</td>
                          <td>{{$value->alamat}}</td>
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
                <table id="examples3" class="table table-striped table-bordered no-wrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Alamat</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($investor as $value){ ?>
                        <tr onclick="pilihbarang2('{{$value->id}}','{{$value->nama_investor}}')">
                            <td>{{$value->nama_investor}}</td>
                            <td>{{$value->alamat}}</td>
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

    function caribarang(){
      $('#barang').modal('show');
    }
    function pilihbarang(id,nama){
      $('#barang').modal('hide');
      document.getElementById("id2").value = id;
      document.getElementById("nama_investor2").value = nama;
    }
    function caribarang2(){
      $('#barang2').modal('show');
    }
    function pilihbarang2(id,nama){
      $('#barang2').modal('hide');
      document.getElementById("id3").value = id;
      document.getElementById("nama_investor3").value = nama;
    }
    function edit(value,pengembang,leader)
    {
        $.ajax({
           url: 'editInvestor/'+value,
           type: 'get',
           dataType: 'json',
           async: false,
           success: function(response){
             document.getElementById("id").value = response[0]['id'];
             document.getElementById("nik").value = response[0]['nik'];
             document.getElementById("old_nik").value = response[0]['nik'];
             document.getElementById("nama_investor").value = response[0]['nama_investor'];
             document.getElementById("nama_lengkap").value = response[0]['nama_lengkap'];
             document.getElementById("no_hp").value = response[0]['no_hp'];
             document.getElementById("no_rekening").value = response[0]['no_rekening'];
             document.getElementById("ats_bank").value = response[0]['ats_bank'];
             document.getElementById("nama_bank").value = response[0]['nama_bank'];
             document.getElementById("keterangan").value = response[0]['keterangan'];
             document.getElementById("id2").value = response[0]['pengembang'];
             document.getElementById("nama_investor2").value = pengembang;
             document.getElementById("id3").value = response[0]['leader'];
             document.getElementById("nama_investor3").value = leader;
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
        'Hapus Investor '+name+'?',
        'Apakah Anda Yakin?',
        'question'
      ).then((result) => {
        if (result.value) {
          location.href="{{url('/deleteInvestor/')}}"+"/"+value;
        }
      });
    }
    </script>
@endsection
