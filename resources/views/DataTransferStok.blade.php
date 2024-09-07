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
                              <li class="breadcrumb-item text-muted" aria-current="page">Gudang > Transfer Stok > <a href="https://stokis.app/?s=data+transfer+stok+antar+gudang" target="_blank">Data Transfer Stok Antar Gudang</a></li>
                          </ol>
                      </nav>
                    </h4>
                    <hr>

                    <div style="border:2px dashed #eee;border-radius:20px; padding:20px; backgroud:#f5f5f5">
                    <p><strong>Cari Data Berdasarkan</strong></p>
                      <div class="col-md-4">
                      <form action="{{url('datatransferstokbyname')}}" method="post">
                        {{csrf_field()}}
                      <div class="row">
                        <label class="col-lg-3">Nama Barang</label>
                        <div class="col-lg-9">
                            <div class="row">
                                <div class="col-md-11">
                                  <div class="input-group">
                                    <input type="text" name="nama_barang" maxlength="40" class="form-control" placeholder="Ketik nama barang..."
                                    <?php if (isset($nama_barangs)): ?>
                                      value="{{$nama_barangs}}"
                                    <?php endif; ?>
                                    required placeholder="">
                                    <div class="input-group-append">
                                        <button class="btn btn-success"><i class="fas fa-search"></i></button>
                                    </div>
                                  </div>
                                </div>
                            </div>
                        </div>
                      </div>
                    </form>

                      </div>
                    </div>
                    <br>
                    <div style="border:2px dashed #eee;border-radius:20px; padding:20px; backgroud:#f5f5f5">
                    <p><strong>Filter Berdasarkan</strong></p>
                    <form action="{{url('datatransferstok')}}" method="post">
                    {{csrf_field()}}
                    <div class="form-group">
                       <div class="row">
                           <label class="col-lg-1">Transfer Stok</label>
                           <div class="col-lg-3">
                               <div class="row">
                                   <div class="col-md-10">
                                     <select onchange="change()" name="kepada" class="form-control">
                                     <?php foreach ($gudang as $value): ?>
                                       <option value="{{$value->id}}"
                                         <?php if (isset($kepada)): ?>
                                           <?php if ($value->id == $kepada): ?>
                                             selected
                                           <?php endif; ?>
                                         <?php endif; ?>
                                       >{{$value->nama_gudang}}</option>
                                     <?php endforeach; ?>
                                     </select>
                                   </div>
                                   <div class="col-md-2">
                                       ke
                                   </div>
                               </div>
                           </div>
                           <div class="col-lg-4">
                               <div class="row">
                                   <div class="col-md-8">
                                     <select onchange="change()" name="dari" class="form-control">
                                     <?php foreach ($gudang as $value): ?>
                                       <option value="{{$value->id}}"
                                         <?php if (isset($dari)): ?>
                                           <?php if ($value->id == $dari): ?>
                                             selected
                                           <?php endif; ?>
                                         <?php endif; ?>
                                       >{{$value->nama_gudang}}</option>
                                     <?php endforeach; ?>
                                     </select>
                                   </div>
                               </div>
                           </div>
                           <label class="col-lg-1">Status Transfer</label>
                           <div class="col-lg-3">
                               <div class="row">
                                   <div class="col-md-10">
                                     <select name="status_transfer" onchange="change()" class="form-control">
                                       <!--option value="order"
                                         <?php if (isset($status_transfer) && $status_transfer == "order"): ?>
                                           selected
                                         <?php endif; ?>
                                       >Order</option-->
                                       <option value="proses"
                                         <?php if (isset($status_transfer) && $status_transfer == "proses"): ?>
                                           selected
                                         <?php endif; ?>
                                       >Proses</option>
                                       <option value="terkirim"
                                         <?php if (isset($status_transfer) && $status_transfer == "terkirim"): ?>
                                           selected
                                         <?php endif; ?>
                                       >Terkirim</option>
                                     </select>
                                   </div>
                               </div>
                           </div>
                       </div>
                      </div>
                      <div class="form-group">
                         <div class="row">
                             <label class="col-lg-1">Tanggal Proses</label>
                             <div class="col-lg-3">
                                 <div class="row">
                                     <div class="col-md-10">
                                         <input onchange="change()" type="date"
                                           <?php if (isset($from)): ?>
                                             value="{{$from}}"
                                           <?php endif; ?>
                                         name="from" class="form-control">
                                     </div>
                                     <div class="col-md-2">
                                         s/d
                                     </div>
                                 </div>
                             </div>
                             <div class="col-lg-4">
                                 <div class="row">
                                     <div class="col-md-8">
                                         <input onchange="change()" name="to"
                                         <?php if (isset($to)): ?>
                                           value="{{$to}}"
                                         <?php endif; ?>
                                         type="date" class="form-control">
                                     </div>
                                 </div>
                             </div>
                             <label class="col-lg-1" hidden>Nama Barang</label>
                             <div class="col-lg-3" hidden>
                                 <div class="row">
                                     <div class="col-md-10">
                                       <input type="text" id="nama_barang" name="nama_barang" onkeypress="change()" <?php if (isset($nama_barang)): ?>
                                         value="{{$nama_barang}}"
                                       <?php endif; ?>class="form-control">
                                     </div>
                                 </div>
                             </div>
                         </div>
                        </div>

                        <div class="form-group">
                           <div class="col-lg-12">
                               <center><button disabled id="filter" class="btn btn-success btn-lg">Filter Data</button></center>
                           </div>
                        </div>
                      </form>
                      </div>
                      <hr><br>
									<div class="table-responsive">
                  <table id="example" class="table table-striped table-bordered no-wrap" style="width:100%">
                      <thead>
                          <tr>
                              <th>No Transfer</th>
                              <th>Tanggal Proses</th>
                              <th>Tanggal Terima</th>
                              <th>Dari</th>
                              <th>Kepada</th>
                              <th>No. SKU</th>
                              <th>Nama Barang</th>
                              <th>Jumlah Order</th>
                              <th>Jumlah Proses</th>
                              <th>Jumlah Pending</th>
                              <th>Jumlah Batal</th>
                              <th>Jumlah Diterima</th>
                              <th>Admin(P)</th>
                              <th>Admin(G)</th>
                              <th>Admin(V)</th>
                              <th>Driver</th>
                              <th>QC</th>
                              <th>Status</th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($data as $value) { ?>
                          <tr <?php if ($value->status_transfer == "proses"): ?>
                            style="background:#fffca6;"
                          <?php endif; ?>>
                              <td>{{$value->no_transfer}}</td>
                              <td>{{tanggal($value->tanggal_kirim)}}</td>
                              <td>{{tanggal($value->tanggal_terkirim)}}</td>
                              <td>{{$value->dari}}</td>
                              <td>{{$value->kepada}}</td>
                              <td>{{$value->no_sku}}</td>
                              <td>{{$value->nama_barang}}</td>
                              <td>{{ribuan($value->jumlah)}}</td>
                              <td>{{ribuan($value->proses)}}</td>
                              <td>{{ribuan($value->pending)}}</td>
                              <td>{{ribuan($value->retur)}}</td>
                              <td>{{ribuan($value->terkirim)}}</td>
                              <td>{{$value->admin}}</td>
                              <td>{{$value->admin_g}}</td>
                              <td>{{$value->admin_v}}</td>
                              <td>{{$value->driver}}</td>
                              <td>{{$value->qc}}</td>
                              <td>{{$value->status_transfer}}</td>
                          </tr>
                         <?php } ?>
                      </tbody>
                  </table>
								</div>

					<br><br>
                <h4>&nbsp;&nbsp;&nbsp;Cetak Ulang Surat Jalan</h4>
                <div class="col-lg-8">
                  <div class="row">
                    <div class="col-lg-6">
                      <input type="text" id="no_transfer" class="form-control">
                    </div>
                    <div class="col-lg-6">
                      <button class="btn btn-warning" onclick="surattransfer()">Cetak Surat Jalan</button>
                    </div>
                  </div>
                </div>
                <br><br>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

<script>
  function Petugas(){
    document.getElementById("filter").disabled = false;
    document.getElementById("petugas").style.visibility = "visible";
  }
  function change(){
    document.getElementById("filter").disabled = false;
  }
  function surattransfer() {
        var no_transfer = document.getElementById("no_transfer").value;
        window.open("{{url('/surattransfer/')}}"+'/'+no_transfer);
      }
</script>

@endsection
