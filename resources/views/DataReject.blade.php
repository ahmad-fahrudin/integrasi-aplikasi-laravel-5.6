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
                              <li class="breadcrumb-item text-muted" aria-current="page">Gudang > Stok Rijek > <a href="https://stokis.app/?s=cara+rijek+stok+gudang" target="_blank">Data Rijek Stok</a></li>
                          </ol>
                      </nav>
                    </h4>
                    <hr>
                    <div style="border:2px dashed #eee;border-radius:20px; padding:20px; backgroud:#f5f5f5">
                    <p><strong>Filter Berdasarkan</strong></p>
                    <form action="{{url('datareject')}}" method="post">
                    {{csrf_field()}}
                    <div class="form-group">
                    <div class="row">
                      <div class="col-md-6">
                       <div class="row">
                           <label class="col-lg-3">Tanggal Input</label>
                           <div class="col-lg-5">
                               <div class="row">
                                   <div class="col-md-9">
                                       <input type="date" name="from"
                                         <?php if (isset($from)): ?>
                                           value="{{$from}}"
                                         <?php endif; ?>
                                       class="form-control">
                                   </div>
                                   <label class="col-lg-3">s/d</label>
                               </div>
                           </div>
                           <div class="col-lg-4">
                               <div class="row">
                                   <div class="col-md-12">
                                       <input type="date" name="to"
                                         <?php if (isset($to)): ?>
                                           value="{{$to}}"
                                         <?php endif; ?>
                                       class="form-control">
                                   </div>
                               </div>
                           </div>
                       </div>
                       <br>
                       <div class="row">
                           <label class="col-lg-3">Gudang</label>
                           <div class="col-lg-9">
                               <div class="row">
                                   <div class="col-md-12">
                                     <select name="id_gudang" class="form-control">
                                       <option value="">Semua</option>
                                       <?php foreach ($gudang as $value): ?>
                                         <option value="{{$value->id}}"
                                           <?php if (isset($id_gudang)): ?>
                                             <?php if ($value->id == $id_gudang): ?>
                                               selected
                                             <?php endif; ?>
                                           <?php endif; ?>
                                        >{{$value->nama_gudang}}</option>
                                       <?php endforeach; ?>
                                     </select>
                                   </div>
                               </div>
                           </div>
                       </div>
                       <br>
                       <div class="row">
                           <label class="col-lg-3">Nama Barang</label>
                           <div class="col-lg-9">
                               <div class="row">
                                   <div class="col-md-12">
                                     <input type="text" id="nama_barang" maxlength="40" name="nama_barang" onchange="change()" <?php if (isset($nama_barang)): ?>
                                       value="{{$nama_barang}}"
                                     <?php endif; ?>class="form-control" placeholder="Ketik nama barang...">
                                   </div>
                               </div>
                           </div>
                       </div>
                        <br>
                   <center><button class="btn btn-success btn-lg">Filter Data</button></center>
                     </div>
                   
                   </div>
                   
                  </div>
                  </form>
                  </div>
                  <hr><br>
									<div class="table-responsive">
                  <table id="example" class="table table-striped table-bordered no-wrap" style="width:100%">
                      <thead>
                          <tr>
                              <th>No. Reject</th>
                              <th>Nama Suplayer</th>
                              <th>Alamat</th>
                              <th>No HP</th>
                              <th>Tanggal Input</th>
                              <th>QC</th>
                              <th>Driver</th>
                              <th>Admin(G)</th>
                              <th>Gudang</th>
                              <th>No SKU</th>
                              <th>Nama Barang</th>
                              <th>Jumlah Reject</th>
                              <th>Admin Validasi</th>
                              <th>Alasan</th>
                              <th>Status</th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($reject as $key => $value): ?>
                          <tr
                          <?php if ($value->status == "cancel"): ?>
                            style="background:#ffd4d4;"
                          <?php endif; ?>>
                            <td>{{$value->no_reject}}</td>
                            <td>{{$value->nama_pemilik}}</td>
                            <td><?php echo $value->alamat; ?></td>
                            <td>{{$value->no_hp}}</td>
                            <td>{{tanggal($value->tanggal_input)}}</td>
                            <td>{{$karyawan[$value->qc]}}</td>
                            <td>{{$karyawan[$value->driver]}}</td>
                            <td>{{$admin[$value->admin_g]}}</td>
                            <td>{{$value->nama_gudang}}</td>
                            <td>{{$value->no_sku}}</td>
                            <td>{{$value->nama_barang}}</td>
                            <td>{{$value->jumlah}}</td>
                            <td><?php if(isset($admin[$value->admin_validasi])){
                                echo $admin[$value->admin_validasi]; } ?></td>
                            <td>{{$value->alasan}}</td>
                            <td><?php
                                if ($value->status == "aktif") {
                                  echo "Diterima";
                                }else if($value->status == "cancel"){
                                  echo "Ditolak";
                                }
                             ?></td>
                          </tr>
                        <?php endforeach; ?>
                      </tbody>
                  </table>
                  </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="jabatan" role="dialog">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">

              <div class="table-responsive">
              <table id="exam" class="table table-striped table-bordered no-wrap" style="width:100%">
                  <thead>
                    <tr>
                        <th>ID</th>
                        <th>NIK</th>
                        <th>Nama</th>
                    </tr>
                  </thead>
                  <tbody>
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

@endsection
