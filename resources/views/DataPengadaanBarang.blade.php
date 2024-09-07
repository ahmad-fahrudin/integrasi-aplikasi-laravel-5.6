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
                              <li class="breadcrumb-item text-muted" aria-current="page">Keuangan > Projek Pengadaan Barang > <a href="https://stokis.app/?s=catatan+transaksi+projek+pengadaan+barang" target="_blank">Data Transaksi Projek</a></li>
                          </ol>
                      </nav>
                    </h4>
                    <hr>
                    <?php if (Auth::user()->level == "1" || Auth::user()->level == "4"): ?>
                    <div style="border:2px dashed #eee;border-radius:20px; padding:20px; backgroud:#f5f5f5">
                    <p><strong>Filter Berdasarkan</strong></p>
                    <div class="form-group">
                       <form name="form1" action="{{url('datapengadaanbarang')}}" method="post" enctype="multipart/form-data">
                         {{csrf_field()}}
                       <div class="row">
                             <input name="id_pengambil" value="{{Auth::user()->id}}" type="hidden" class="form-control">
                             <input name="nama_pengambil" value="{{Auth::user()->name}}" type="hidden" class="form-control">
                           <label class="col-lg-1">Investor</label>
                           <div class="col-lg-4">
                               <div class="row">
                                   <div class="col-md-10">
                                      <div class="input-group">
                                       <input id="nama_investor" name="nama_pengambil" placeholder="Pilih Investor" readonly style="background:#fff"
                                         <?php if (isset($nama_pengambil)){ echo "value='".$nama_pengambil."'";  }?>
                                       type="text" class="form-control">
                                       <input id="id_investor" name="id_pengambil"
                                         <?php if (isset($id_pengambil)){ echo "value='".$id_pengambil."'";  }?>
                                       type="hidden" class="form-control">
                                       <div class="input-group-append">
                                           <button class="btn btn-outline-secondary" onclick="cariinvestor()" type="button"><i class="fas fa-folder-open"></i></button>
                                       </div>
                                     </div>
                                   </div>
                               </div>
                           </div>

                           <!--label class="col-lg-1">Status</label>
                           <div class="col-lg-4">
                               <div class="row">
                                   <div class="col-md-10">
                                      <select name="status" class="form-control">
                                        <option value="semua" <?php if (isset($status) && $status == "semua"){ echo "selected"; } ?> >Semua</option>
                                        <option value="" <?php if (isset($status) && $status == "pending"){ echo "selected"; } ?>>Pending</option>
                                        <option value="proses" <?php if (isset($status) && $status == "proses"){ echo "selected"; } ?>>Proses</option>
                                        <option value="selesai" <?php if (isset($status) && $status == "selesai"){ echo "selected"; } ?>>Selesai</option>
                                      </select>
                                   </div>
                               </div>
                           </div-->
                           <button id="filter" class="btn btn-success btn-sm">Filter Data</button>
                       </div>
                      </div>

                      </form>
                      </div>
                    <hr>
                      <?php endif; ?>


                  <div class="table-responsive">
                  <?php
                  $a=1;
                        $no=1;
                        $total_investasi = 0;
                        $total_estimasi = 0;
                        $total_investasi_pending = 0;
                        $total_estimasi_pending = 0;
                        $pending = 0;
                        $proses = 0;
                        $selesai = 0;

                  $total_investasi_proses = 0;
                  $total_estimasi_proses = 0;
                  if(count($pengadaan_proses) > 0){ ?>
                  <h2><center>Projek Pengadaan Barang Proses</center></h2>
                  <table id="example" class="table table-striped table-bordered no-wrap" style="width:100%">
                      <thead>
                          <tr>
                              <th>No. SKU</th>
                              <th>Nama Barang</th>
                              <th>Jumlah Pengadaan</th>
                              <th>Tanggal Ambil</th>
                              <th>Pembiayaan</th>
                              <th>Bagi Hasil</th>
                              <th>Estimasi Waktu</th>
                              <th>Investor</th>
                              <th>Tanggal Proses</th>
                              <th>Status</th>
                              <th>Tindakan</th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php
                        foreach ($pengadaan_proses as $key => $value):
                          $total_investasi += $value->jumlah_investasi;
                          $total_investasi_proses += $value->jumlah_investasi;
                          
                          if(Auth::user()->level == 1){
                              $total_estimasi += $value->estimasi_pendapatan;
                               $total_estimasi_proses += $value->estimasi_pendapatan;
                          }else{
                              if (cek_investor_punya_pengembang() > 0) {
                                $total_estimasi += persentase_pengadaan()*$value->estimasi_pendapatan;
                                $total_estimasi_proses += persentase_pengadaan()*$value->estimasi_pendapatan;
                              }else{
                                $total_estimasi += persentase_pengadaan()*$value->estimasi_pendapatan;
                                $total_estimasi_proses += persentase_pengadaan()*$value->estimasi_pendapatan;
                              }
                          }
                          
                          if ($value->status == "proses") {
                            $proses += $value->jumlah_investasi;
                          }else{
                            $selesai += $value->jumlah_investasi;
                          }

                          $date = new DateTime($value->tanggal_proses);
                          $date->modify("+".$value->estimasi_waktu." day");
                          $temp = $date->format("Y-m-d");

                          $OldDate = new DateTime($value->tgl_ambil);
                          $now = new DateTime(Date('Y-m-d'));
                          $ava = $OldDate->diff($now);
                          ?>
                          <tr id="dt{{$no}}"
                          <?php if ($value->status == "selesai"){ ?>
                            style="background:#c9ffce;"
                          <?php }else if($temp < date('Y-m-d')){ ?>
                            style="background:#ffc8c8;"
                          <?php } ?>
                          >
                            <td>{{$barang[$value->id_barang]['no_sku']}}</td>
                            <td>{{$barang[$value->id_barang]['nama_barang']}}</td>
                            <td align="center">{{$value->jumlah_kulakan}}</td>
                            <td>{{$value->tgl_ambil}}</td>
                            <td align="right">{{ribuan($value->jumlah_investasi)}}</td>
                            <td align="right">
                              <?php 
                              if(Auth::user()->level == 1){
                                  echo ribuan($value->estimasi_pendapatan);
                              }else{
                                  if (cek_investor_punya_pengembang() > 0) {
                                    echo ribuan(persentase_pengadaan()*$value->estimasi_pendapatan);
                                  }else{
                                    echo ribuan(persentase_pengadaan()*($value->estimasi_pendapatan));
                                  }
                              }
                              ?></td>
                            <td align="right" id="estimasi_waktu{{$no}}">
                              <?php if ($value->estimasi_waktu - $ava->days < 1) {
                                echo "0";
                              }else{
                                echo $value->estimasi_waktu - $ava->days;
                              }?> Hari</td>
                            <td>{{$admin[$value->id_pengambil]}}</td>
                            <td><?php if (isset($value->tanggal_proses)) { echo tanggal($value->tanggal_proses); } ?></td>
                            <td>
                              <?php if ($value->status == ""){ ?>
                                Proses
                              <?php }else{ echo $value->status; } ?>
                            </td>
                            <td>

                            <?php if (Auth::user()->level == "1"): ?>
                              <button class="btn btn-danger" onclick="Deleted('{{$barang[$value->id_barang]['nama_barang']}}','{{$value->id}}','{{$admin[$value->id_pengambil]}}')">Delete</button>
                            <?php endif; ?>

                          </td>
                          </tr>
                        <?php $no++; endforeach; ?>
                      </tbody>
                  </table>
                  <br>
                  <div class="row">
                    <div class="col-md-3"><h4>Jumlah Proses : {{ribuan($proses)}}</h4></div>
                    <div class="col-md-3"><h4>Jumlah Bagi Hasil Proses: {{ribuan($total_estimasi_proses)}}</h4></div>
                  </div>
                  <br><hr><br>
                  <?php } ?>



                  <h2><center>Projek Pengadaan Barang Selesai</center></h2>
                  <table id="example1" class="table table-striped table-bordered no-wrap" style="width:100%">
                      <thead>
                          <tr>
                              <th>No. SKU</th>
                              <th>Nama Barang</th>
                              <th>Jumlah Pengadaan</th>
                              <th>Tanggal Ambil</th>
                              <th>Pembiayaan</th>
                              <th>Bagi Hasil</th>
                              <th>Estimasi Waktu</th>
                              <th>Investor</th>
                              <th>Tanggal Proses</th>
                              <th>Status</th>
                              <th>Tindakan</th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php
                        $total_investasi_selesai = 0;
                        $total_estimasi_selesai = 0;
                        foreach ($pengadaan_selesai as $key => $value):
                          if ($value->status == "selesai") {
                          $total_investasi += $value->jumlah_investasi;
                          $total_investasi_selesai += $value->jumlah_investasi;
                          
                          if(Auth::user()->level == 1){
                              $total_estimasi += $value->estimasi_pendapatan;
                              $total_estimasi_selesai += $value->estimasi_pendapatan;
                          }else{
                              if (cek_investor_punya_pengembang() > 0) {
                                $total_estimasi += persentase_pengadaan()*$value->estimasi_pendapatan;
                                $total_estimasi_selesai += persentase_pengadaan()*$value->estimasi_pendapatan;
                              }else{
                                $total_estimasi += $value->estimasi_pendapatan;
                                $total_estimasi_selesai += $value->estimasi_pendapatan;
                              }
                          } 
                            
                          if ($value->status == "") {
                            $pending += $value->jumlah_investasi;
                          }else if ($value->status == "proses") {
                            $proses += $value->jumlah_investasi;
                          }else{
                            $selesai += $value->jumlah_investasi;
                          }

                          $date = new DateTime($value->tanggal_proses);
                          $date->modify("+".$value->estimasi_waktu." day");
                          $temp = $date->format("Y-m-d");

                          $OldDate = new DateTime($value->tgl_ambil);
                          $now = new DateTime(Date('Y-m-d'));
                          $ava = $OldDate->diff($now);
                          ?>
                          <tr id="dt{{$no}}"
                          <?php if ($value->status == "selesai"){ ?>
                            style="background:#c9ffce;"
                          <?php }else if($temp < date('Y-m-d')){ ?>
                            style="background:#ffc8c8;"
                          <?php } ?>
                          >
                            <td>{{$barang[$value->id_barang]['no_sku']}}</td>
                            <td>{{$barang[$value->id_barang]['nama_barang']}}</td>
                            <td align="center">{{$value->jumlah_kulakan}}</td>
                            <td>{{$value->tgl_ambil}}</td>
                            <td align="right">{{ribuan($value->jumlah_investasi)}}</td>
                            <td align="right">
                              <?php
                              if(Auth::user()->level == 1){
                                  echo ribuan($value->estimasi_pendapatan);
                              }else{
                                  if (cek_investor_punya_pengembang() > 0) {
                                    echo ribuan(persentase_pengadaan()*$value->estimasi_pendapatan);
                                  }else{
                                    echo ribuan($value->estimasi_pendapatan);
                                  }
                              }?></td>
                            <td align="right" id="estimasi_waktu{{$no}}">
                              <?php if ($value->estimasi_waktu - $ava->days < 1) {
                                echo "0";
                              }else{
                                echo $value->estimasi_waktu - $ava->days;
                              }?> Hari</td>
                            <td>{{$admin[$value->id_pengambil]}}</td>
                            <td><?php if (isset($value->tanggal_proses)) { echo tanggal($value->tanggal_proses); } ?></td>
                            <td>
                              <?php if ($value->status == ""){ ?>
                                Pending
                              <?php }else{ echo $value->status; } ?>
                            </td>
                            <td>

                            <?php if (Auth::user()->level == "1"): ?>
                              <button class="btn btn-default" onclick="Deleted('{{$barang[$value->id_barang]['nama_barang']}}','{{$value->id}}','{{$admin[$value->id_pengambil]}}')"><i class="icon-trash"></i></button>
                            <?php endif; ?>

                          </td>
                          </tr>
                        <?php $no++; } endforeach; ?>
                      </tbody>
                  </table>
                  <br>
                  <div class="row">
                    <div class="col-md-3"><h4>Jumlah Selesai : {{ribuan($selesai)}}</h4></div>
                    <div class="col-md-3"><h4>Jumlah Bagi Hasil Selesai: {{ribuan($total_estimasi_selesai)}}</h4></div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-md-3"><h3>Total Pembiayaan : {{ribuan($total_investasi)}}</h3></div>
                    <div class="col-md-3"><h3>Total Bagi Hasil : {{ribuan($total_estimasi)}}</h3></div>
                  </div>
                  <br><br>
								</div>
              </div>
            </div>
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
                          <th>No</th>
                          <th>Nama</th>
                          <th>Alamat</th>
                          <th>Telepon</th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php $no=1; foreach ($investor as $value){ ?>
                      <tr onclick="pilihinvestor('{{$value['id']}}','{{$value['nama']}}')">
                          <td>{{$no}}</td>
                          <td>{{$value['nama']}}</td>
                          <td><?php echo $value['alamat']; ?></td>
                          <td>{{$value['no_hp']}}</td>
                      </tr>
                     <?php $no++; } ?>
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
    function Proses(nama,id,pengambil){
      Swal.fire(
        'Proses \n'+nama+'\n dengan Investor \n'+pengambil+' ?',
        'Apakah Anda Yakin?',
        'question'
      ).then((result) => {
        if (result.value) {
          status = 'proses';
          $.ajax({
             url: 'prosesinves/'+id+'/'+status,
             type: 'get',
             dataType: 'json',
             async: false,
             success: function(response){
               Swal.fire({
                   title: 'Berhasil',
                   icon: 'success',
                   confirmButtonColor: '#3085d6',
                   cancelButtonColor: '#d33',
                   confirmButtonText: 'Lanjutkan!'
                 }).then((result) => {
                   if (result.value) {
                      location.href="{{url('/datapengadaanbarang/')}}";
                   }else{
                      location.href="{{url('/datapengadaanbarang/')}}";
                   }
                 });
             }
           });
        }
      });
    }

    <?php if (Auth::user()->level == 1) { ?>
    function Deleted(nama,id,pengambil){
      Swal.fire(
        'Delete '+nama+'?',
        'Apakah Anda Yakin?',
        'question'
      ).then((result) => {
        if (result.value) {
          status = 'delete';
          $.ajax({
             url: 'deleteinvestbaru/'+id,
             type: 'get',
             dataType: 'json',
             async: false,
             success: function(response){
               Swal.fire({
                   title: 'Berhasil',
                   icon: 'success',
                   confirmButtonColor: '#3085d6',
                   cancelButtonColor: '#d33',
                   confirmButtonText: 'Lanjutkan!'
                 }).then((result) => {
                   if (result.value) {
                      location.href="{{url('/datapengadaanbarang/')}}";
                   }else{
                      location.href="{{url('/datapengadaanbarang/')}}";
                   }
                 });
             }
           });
        }
      });
    }
    <?php } ?>

    function cariinvestor(){
      $('#investor').modal('show');
    }

    function pilihinvestor(id,nama){
      document.getElementById("id_investor").value = id;
      document.getElementById("nama_investor").value = nama;
      $('#investor').modal('hide');
    }

    </script>
@endsection
