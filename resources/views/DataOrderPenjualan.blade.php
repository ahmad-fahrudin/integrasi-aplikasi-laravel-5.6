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
                              <li class="breadcrumb-item text-muted" aria-current="page">Gudang > Laporan Kiriman > <a href="https://stokis.app/?s=data+barang+keluar+penjualan" target="_blank">Data Barang Keluar (Laporan Penjualan)</a></li>
                          </ol>
                      </nav>
                    </h4>
                    <hr>
                    
                
                    <div style="border:2px dashed #eee;border-radius:20px; padding:20px; backgroud:#f5f5f5">
                    <p><strong>Cari Data Berdasarkan</strong></p>
                    
                <div class="row">
                    <div class="col-md-6">
                    <form action="{{url('caridatapenjualan')}}" method="post">
                      {{csrf_field()}}
                       <div class="row">
                      <label class="col-lg-3">No Kwitansi</label>
                      <div class="col-lg-8">
                          <div class="row">
                              <div class="col-md-11">
                                <div class="input-group">
                                  <input type="text" name="no_kwitansi" class="form-control" maxlength="15" required placeholder="Ketik No. Kwitansi...">
                                  <div class="input-group-append">
                                      <button class="btn btn-success"><i class="fas fa-search"></i></button>
                                  </div>
                                </div>
                              </div>
                          </div>
                      </div>
                    </div>
                    </form>
                    <br>
                    </div>

                   <div class="col-md-6">
                  <form action="{{url('caridatapenjualanbyname')}}" method="post">
                    {{csrf_field()}}
                  <div class="row">
                    <label class="col-lg-3">Nama Barang</label>
                    <div class="col-lg-8">
                        <div class="row">
                            <div class="col-md-11">
                              <div class="input-group">
                                <input type="text" name="nama_barang" maxlength="40" class="form-control"
                                <?php if (isset($nama_barangs)): ?>
                                  value="{{$nama_barangs}}"
                                <?php endif; ?>
                                required placeholder="Ketik Nama Barang...">
                                <div class="input-group-append">
                                    <button class="btn btn-success"><i class="fas fa-search"></i></button>
                                </div>
                              </div>
                            </div>
                        </div>
                    </div>
                  </div>
                </form>
                <br>
                 </div>
                </div>

                </div>
                    
                    
                    
                    <hr>
                <div style="border:2px dashed #eee;border-radius:20px; padding:20px; backgroud:#f5f5f5">
                    <p><strong>Filter Data Berdasarkan</strong></p>
                    <form action="{{url('dataorderpenjualan')}}" method="post">
                    {{csrf_field()}}
                    <div class="row">
                      <div class="col-md-6">
                       <div class="row">
                           <label class="col-lg-3">Tanggal Proses</label>
                           <div class="col-lg-4">
                               <div class="row">
                                   <div class="col-md-12">
                                       <input type="date" name="from"
                                         <?php if (isset($from)): ?>
                                           value="{{$from}}"
                                         <?php endif; ?>
                                       class="form-control">
                                   </div>
                               </div>
                           </div>
                           <label class="col-lg-0.5">&emsp;s/d&emsp;</label>
                           <div class="col-lg-4">
                               <div class="row">
                                   <div class="col-md-11">
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
                           <label class="col-lg-3">Status Order</label>
                           <div class="col-lg-8">
                               <div class="row">
                                   <div class="col-md-11">
                                     <select name="status_order" class="form-control">
                                       <?php foreach ($status_order as $value): ?>
                                         <option value="{{$value->id}}"
                                           <?php if (isset($v_status_order)): ?>
                                             <?php if ($value->id == $v_status_order): ?>
                                               selected
                                             <?php endif; ?>
                                           <?php endif; ?>
                                         >{{$value->nama_status}}</option>
                                       <?php endforeach; ?>
                                     </select>
                                   </div>
                               </div>
                           </div>
                       </div>
                       <br>
                       <div class="row">
                           <label class="col-lg-3">Cabang</label>
                           <div class="col-lg-8">
                               <div class="row">
                                   <div class="col-md-11">
                                     <select name="id_gudang" class="form-control">
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
                           <label class="col-lg-3">Kiriman lebih dari</label>
                           <div class="col-lg-2">
                               <div class="row">
                                   <div class="col-md-12">
                                       <input name="proses" type="number"
                                         <?php if (isset($proses)): ?>
                                           value="{{$proses}}"
                                         <?php endif; ?>
                                       class="form-control" placeholder="0">
                                   </div>
                               </div>
                           </div>
                           <label class="col-lg-4">hari</label>
                       </div>
                       <br>
                      <div class="row">
                          <label class="col-lg-3">Kategori Barang</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input type="radio" <?php if (!isset($branded)): ?>
                                        checked
                                      <?php endif; ?> name="branded" value="">
                                      <label for="male">Semua</label><br>
                                      <input type="radio" <?php if (isset($branded) && $branded == "0"): ?>
                                        checked
                                      <?php endif; ?> name="branded" value="0">
                                      <label for="female">Umum</label><br>
                                      <input type="radio" <?php if (isset($branded) && $branded == "1"): ?>
                                        checked
                                      <?php endif; ?> name="branded" value="1">
                                      <label for="other">Branded</label>

                                  </div>
                              </div>
                          </div>
                      </div>
                       
                       <br>
                       <div class="row" hidden>
                           <label class="col-lg-3">Nama Barang</label>
                           <div class="col-lg-4">
                             <div class="row">
                                 <div class="col-md-11">
                                   <input type="text" id="nama_barang" name="nama_barang" maxlength="50" onchange="change()" <?php if (isset($nama_barang)): ?>
                                     value="{{$nama_barang}}"
                                   <?php endif; ?>class="form-control">
                                 </div>
                             </div>
                           </div>
                       </div>

                     </div>

                     <div class="col-lg-6">
                      <div class="row">
                          <label class="col-lg-3">Status Kiriman</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                    <select name="status_barang" class="form-control">
                                        <option value="terkirim"
                                        <?php if (isset($status_barang) && $status_barang == "terkirim"): ?>
                                          selected
                                        <?php endif; ?>
                                        >Terkirim</option>
                                        <option value="proses"
                                        <?php if (isset($status_barang) && $status_barang == "proses"): ?>
                                          selected
                                        <?php endif; ?>
                                        >Proses</option>
                                        <option value="kirim ulang"
                                        <?php if (isset($status_barang) && $status_barang == "kirim ulang"): ?>
                                          selected
                                        <?php endif; ?>
                                        >Kirim Ulang</option>
                                    </select>
                                  </div>
                              </div>
                          </div>
                      </div>
                      
                      <br>
                      <div class="row">
                          <label class="col-lg-3">Kategori Perusahaan</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <select name="kategori_konsumen" class="form-control">
                                        <option value="Semua">Semua</option>
                                        <option value="PKP" 
                                        <?php if (isset($kategori_konsumen) && $kategori_konsumen == "PKP"): ?> selected<?php endif; ?>
                                        >PKP</option>
                                        <option value="Non PKP" 
                                        <?php if (isset($kategori_konsumen) && $kategori_konsumen == "Non PKP"): ?> selected<?php endif; ?>
                                        >Non PKP</option>
                                    </select>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <br>
                       <div class="row">
                           <label class="col-lg-3">Member</label>
                           <div class="col-lg-8">
                             <div class="row">
                                 <div class="col-md-11">
                                   <div class="input-group">
                                     <input id="name_konsumen" name="name_konsumen"
                                     <?php if (isset($name_konsumen)): ?>
                                       value="{{$name_konsumen}}"
                                     <?php endif; ?>
                                     type="text" class="form-control" placeholder="Pilih Nama Member" readonly style="background:#fff">
                                     <input id="id_konsumen"
                                     <?php if (isset($id_konsumen)): ?>
                                       value="{{$id_konsumen}}"
                                     <?php endif; ?>
                                     name="id_konsumen" type="hidden" class="form-control">
                                     <div class="input-group-append">
                                         <button class="btn btn-outline-secondary" onclick="carikonsumen()" type="button"><i class="fas fa-folder-open"></i></button>
                                     </div>
                                   </div>
                                 </div>
                             </div>
                           </div>
                       </div>
                      <br>
                        <div class="row">
                          <label class="col-lg-3">Petugas</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                    <select name="petugas" id="petugas" class="form-control">
                                        <option value="sales"
                                          <?php if (isset($petugas) && $petugas == "sales"): ?>
                                            selected
                                          <?php endif; ?>
                                        >Sales</option>
                                        <option value="pengembang"
                                          <?php if (isset($petugas) && $petugas == "pengembang"): ?>
                                            selected
                                          <?php endif; ?>
                                        >Pengembang</option>
                                        <option value="leader"
                                          <?php if (isset($petugas) && $petugas == "Leader"): ?>
                                            selected
                                          <?php endif; ?>
                                        >Leader</option>
                                        <option value="manager"
                                          <?php if (isset($petugas) && $petugas == "manager"): ?>
                                            selected
                                          <?php endif; ?>
                                        >Manager</option>
                                        <option value="admin_p"
                                          <?php if (isset($petugas) && $petugas == "admin_p"): ?>
                                            selected
                                          <?php endif; ?>
                                        >Admin (P)</option>
                                        <option value="admin_g"
                                          <?php if (isset($petugas) && $petugas == "admin_g"): ?>
                                            selected
                                          <?php endif; ?>
                                        >Admin (G)</option>
                                        <option value="admin_v"
                                          <?php if (isset($petugas) && $petugas == "admin_v"): ?>
                                            selected
                                          <?php endif; ?>
                                        >Admin (V)</option>
                                        <option value="qc"
                                          <?php if (isset($petugas) && $petugas == "qc"): ?>
                                            selected
                                          <?php endif; ?>
                                        >QC</option>
                                        <option value="pengirim"
                                          <?php if (isset($petugas) && $petugas == "pengirim"): ?>
                                            selected
                                          <?php endif; ?>
                                        >Pengirim</option>
                                    </select>
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3"></label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                    <div class="input-group">
                                      <input id="name"  type="text"
                                      <?php if (isset($id) && ($petugas == "sales" || $petugas == "pemgembang" || $petugas == "leader" || $petugas == "manager" || $petugas == "qc" || $petugas == "pengirim")){ ?>
                                        value="{{$karyawan[$id]['nama']}}"
                                      <?php }else if(isset($id) && ($petugas == "admin_p" || $petugas == "admin_g" || $petugas == "admin_v")){ ?>
                                        value="{{$admin[$id]}}"
                                      <?php } ?>
                                      class="form-control" placeholder="Pilih Nama Petugas" readonly style="background:#fff">
                                      <input id="id" name="id"
                                      <?php if (isset($id)): ?>
                                        value="{{$id}}"
                                      <?php endif; ?>
                                      type="hidden" class="form-control">
                                      <div class="input-group-append">
                                          <button class="btn btn-outline-secondary" onclick="carijabatan()" type="button"><i class="fas fa-folder-open"></i></button>
                                      </div>
                                    </div>
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                      </div>
                    </div>
                    <br><center><button class="btn btn-lg btn-primary">Tampilkan Data</button></center>
                    
                  </form>
                  
                </div>  
 
                <br>
                  <hr>

                  <!--ul class="nav nav-tabs mb-3">
                      <?php foreach ($bulan as $key => $value): ?>
                      <li class="nav-item">
                          <a onclick="Reload({{$key+1}})" data-toggle="tab" aria-expanded="false" class="nav-link
                              <?php if(isset($tab)){
                              if($key+1 == $tab){ ?>
                                active
                              <?php } } ?>
                              ">
                              <i class="mdi mdi-home-variant d-lg-none d-block mr-1"></i>
                              <span class="d-none d-lg-block">&emsp;{{$value}}&emsp;</span>
                          </a>
                      </li>
                      <?php endforeach; ?>
                  </ul-->
				  <div class="table-responsive">
                  <table id="dop" class="table table-striped table-bordered no-wrap" style="width:100%">
                      <thead>
                          <tr>
                              <th>No. Kwitansi</th>
                              <th>Tanggal Proses</th>
                              <th>Tanggal Terkirim</th>
                              <th>Nama Member</th>
                              <th>Alamat</th>
                              <th>No. SKU</th>
                              <th>Nama Barang</th>
                              <th>Item No.</th>
                              <th>Order</th>
                              <th>Proses</th>
                              <th>Pending</th>
                              <th>Batal</th>
                              <th>Terkirim</th>
                              <?php if (Auth::user()->level == "1" || Auth::user()->level == "4"){ ?>
                              <th>Harga HP</th>
                              <th>Harga HPP</th>
                              <?php } ?>
                              <th>Harga Net</th>
                              <th>PPN (11%)</th>
                              <th>Harga Jual</th>
                              <th>Pot. Harga (Promo)</th>
                              <th>Pot. Harga (Qty)</th>
                              <th>Jumlah Harga</th>
                              <th>Sales</th>
                              <th>Pengembang</th>
                              <th>Leader</th>
                              <th>Manager</th>
                              <th>Admin(P)</th>
                              <th>Admin(G)</th>
                              <th>Admin(V)</th>
                              <th>QC</th>
                              <th hidden>Dropper</th>
                              <th>Pengirim</th>
                              <th>Helper</th>
                              <th>Cabang</th>
                              <th>Status Kiriman</th>
                              <th>Status Order</th>
                              <th>Catatan</th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php $total_penjualan=0; $selisih=0; 
                        foreach ($data as $value) { if( !isset($kategori_konsumen)||(isset($kategori_konsumen) && $kategori_konsumen == $konsumen[$value->id_konsumen]['kategori_konsumen'])){
                          if (isset($branded) && $branded == $barang[$value->id_barang]['branded']) {
                            if ($value->proses != "0") {
                                  $OldDate = new DateTime($value->tanggal_proses);
                                  $now = new DateTime(Date('Y-m-d'));
                                  $tempo = $OldDate->diff($now);
                            ?>
                            <tr
                            <?php if ($value->status_barang == "kirim ulang"){ ?>
                              style="background:#ffc0c0;"
                            <?php }elseif($value->status_barang == "proses"){
                                $value->return = "0"; $value->terkirim = "0";
                                if($tempo->days > 6){
                                    echo 'style="background:#ff8989;"';
                                }else{
                                    echo 'style="background:#ffface;"';
                                }
                                } ?>
                            >
                              <td>{{$value->no_kwitansi}}</td>
                              <td>{{tanggal($value->tanggal_proses)}}</td>
                              <td>
                                <?php if (isset($value->tanggal_terkirim) && $value->tanggal_terkirim != "0000-00-00"): ?>
                                  {{tanggal($value->tanggal_terkirim)}}
                                <?php endif; ?>
                              </td>
                          <?php if ($value->status_order == "2" || $value->status_order == "3"){ ?>
                            <td>{{$karyawan[$value->id_konsumen]['nama']}}</td>
                            <td><?php echo $karyawan[$value->id_konsumen]['alamat']; ?></td>
                          <?php }else{ ?>
                            <td>{{$konsumen[$value->id_konsumen]['nama']}}</td>
                            <td><?php echo $konsumen[$value->id_konsumen]['alamat']; ?></td>
                          <?php } ?>
                              <td>{{$barang[$value->id_barang]['no_sku']}}</td>
                              <td>{{$barang[$value->id_barang]['nama_barang']}}</td>
                              <td>{{$barang[$value->id_barang]['part_number']}}</td>
                              <td align="center">{{ribuan($value->jumlah)}}</td>
                              <td align="center">{{ribuan($value->proses)}}</td>
                              <td align="center">{{ribuan($value->pending)}}</td>
                              <td align="center">{{ribuan($value->return)}}</td>
                              <td align="center">{{ribuan($value->terkirim)}}</td>
                              <?php if (Auth::user()->level == "1" || Auth::user()->level == "4"){ ?>
                              <td align="right">
                                <?php if ($value->harga_hp > 0){ ?>
                                  {{rupiah($value->harga_hp)}}
                                <?php }else{ ?>
                                  {{rupiah($text_harga[$value->id_barang]['harga_hp'])}}
                                <?php } ?>
                              </td>
                              <td align="right">
                                <?php if ($value->harga_hpp > 0){ ?>
                                  {{rupiah($value->harga_hpp)}}
                                <?php }else{ ?>
                                  {{rupiah($text_harga[$value->id_barang]['harga_hpp'])}}
                                <?php } ?>
                              </td>
                              <?php } ?>

                              <td align="right">
                                <?php if ($value->terkirim == "0"){ echo "0"; }else{ ?>
                                {{rupiah($value->harga_net)}}
                                <?php } ?>
                              </td>
                              
                              <td align="right"><?php if($konsumen[$value->id_konsumen]['kategori_konsumen'] == "PKP"){ $hsl = 11/111 * $value->harga_jual; echo rupiah($hsl); }else{ $hsl = 0; } ?></td>
                              
                              <td align="right">
                                <?php if ($value->terkirim == "0"){ ?>
                                  0
                                <?php }else{ ?>
                                <?php if($konsumen[$value->id_konsumen]['kategori_konsumen'] == "PKP"){ echo rupiah($value->harga_jual - $hsl); }else{ echo rupiah($value->harga_jual); } ?>
                                <?php } ?></td>
                              <td align="right">
                              <?php
                                echo rupiah($value->potongan);
                              ?>
                              </td>
                              <td align="right">
                              <?php
                                    if($value->terkirim > 0){
                                        echo rupiah($value->sub_potongan / $value->terkirim);
                                    }else{
                                        echo "0";
                                    }
                                     ?>
                              </td>
                              <td align="right">{{rupiah($value->sub_total)}}</td>
                              <td><?php if (isset($karyawan[$value->sales]['nama'])): ?>{{$karyawan[$value->sales]['nama']}}<?php endif; ?></td>
                              <td><?php if (isset($karyawan[$value->pengembang]['nama'])): ?>{{$karyawan[$value->pengembang]['nama']}}<?php endif; ?></td>
                              <td><?php if (isset($karyawan[$value->leader]['nama'])): ?>{{$karyawan[$value->leader]['nama']}}<?php endif; ?></td>
                              <td><?php if (isset($karyawan[$value->manager]['nama'])): ?>{{$karyawan[$value->manager]['nama']}}<?php endif; ?></td>
                              <td>
                                <?php if ($value->admin_p != ""): ?>
                                  {{$admin[$value->admin_p]}}
                                <?php endif; ?>
                              </td>
                              <td>
                                <?php if ($value->admin_g != ""): ?>
                                  {{$admin[$value->admin_g]}}
                                <?php endif; ?>
                              </td>
                              <td>
                                <?php if ($value->admin_v != ""): ?>
                                  {{$admin[$value->admin_v]}}
                                <?php endif; ?>
                              </td>
                              <td><?php if (isset($karyawan[$value->qc]['nama'])): ?>{{$karyawan[$value->qc]['nama']}}<?php endif; ?></td>
                              <td hidden><?php if (isset($karyawan[$value->dropper]['nama'])): ?>{{$karyawan[$value->dropper]['nama']}}<?php endif; ?></td>
                              <td><?php if (isset($karyawan[$value->pengirim]['nama'])): ?>{{$karyawan[$value->pengirim]['nama']}}<?php endif; ?></td>
                              <td><?php if(isset($karyawan[$value->helper]['nama'])){ echo $karyawan[$value->helper]['nama']; }?></td>
                              <td>{{$text_gudang[$value->id_gudang]}}</td>
                              <td>{{$value->status_barang}}</td>
                              <td>{{$text_status_order[$value->status_order]}}</td>
                            </tr>
                           <?php $total_penjualan += $value->sub_total;
                                 if ($value->harga_net > $value->harga_jual) {
                                   $selisih += 0;
                                 }else{
                                   $selisih += ($value->terkirim * ($value->harga_jual - $value->harga_net -  $value->potongan)) - $value->sub_potongan;
                                 }
                           }
                         }else if(!isset($branded)){
                          if ($value->proses != "0") {
                                $OldDate = new DateTime($value->tanggal_proses);
                                $now = new DateTime(Date('Y-m-d'));
                                $tempo = $OldDate->diff($now);
                          ?>
                          <tr
                          <?php if ($value->status_barang == "kirim ulang"){ ?>
                            style="background:#ffc0c0;"
                          <?php }elseif($value->status_barang == "proses"){
                              $value->return = "0"; $value->terkirim = "0";
                              if($tempo->days > 6){
                                  echo 'style="background:#ff8989;"';
                              }else{
                                  echo 'style="background:#ffface;"';
                              }
                              } ?>
                          >
                            <td>{{$value->no_kwitansi}}</td>
                            <td>{{tanggal($value->tanggal_proses)}}</td>
                            <td>
                              <?php if (isset($value->tanggal_terkirim) && $value->tanggal_terkirim != "0000-00-00"): ?>
                                {{tanggal($value->tanggal_terkirim)}}
                              <?php endif; ?>
                            </td>
                        <?php if ($value->status_order == "2" || $value->status_order == "3"){ ?>
                          <td>{{$karyawan[$value->id_konsumen]['nama']}}</td>
                          <td><?php echo $karyawan[$value->id_konsumen]['alamat']; ?></td>
                        <?php }else{ ?>
                          <td>{{$konsumen[$value->id_konsumen]['nama']}}</td>
                          <td><?php echo $konsumen[$value->id_konsumen]['alamat']; ?></td>
                        <?php } ?>
                            <td>{{$barang[$value->id_barang]['no_sku']}}</td>
                            <td>{{$barang[$value->id_barang]['nama_barang']}}</td>
                            <td>{{$barang[$value->id_barang]['part_number']}}</td>
                            <td align="center">{{ribuan($value->jumlah)}}</td>
                            <td align="center">{{ribuan($value->proses)}}</td>
                            <td align="center">{{ribuan($value->pending)}}</td>
                            <td align="center">{{ribuan($value->return)}}</td>
                            <td align="center">{{ribuan($value->terkirim)}}</td>
                            <?php if (Auth::user()->level == "1" || Auth::user()->level == "4"){ ?>
                            <td align="right">
                              <?php if ($value->harga_hp > 0){ ?>
                                {{rupiah($value->harga_hp)}}
                              <?php }else{ ?>
                                {{rupiah($text_harga[$value->id_barang]['harga_hp'])}}
                              <?php } ?>
                            </td>
                            <td align="right">
                              <?php if ($value->harga_hpp > 0){ ?>
                                {{rupiah($value->harga_hpp)}}
                              <?php }else{ ?>
                                {{rupiah($text_harga[$value->id_barang]['harga_hpp'])}}
                              <?php } ?>
                            </td>
                            <?php } ?>

                            <td align="right">
                              <?php if ($value->terkirim == "0"){ echo "0"; }else{ ?>
                              {{rupiah($value->harga_net)}}
                              <?php } ?>
                            </td>
                            <td align="right">
                                
                                <?php if ($konsumen[$value->id_konsumen]['kategori_konsumen'] == "PKP"){ ?> 
                                   <?php if($konsumen[$value->id_konsumen]['kategori_konsumen'] == "PKP"){ $hsl = 11/111 * $value->harga_jual; echo rupiah($hsl); }else{ $hsl = 0; } ?>
                                  <?}else{?>
                                  0
                                <?php } ?>
                                
                                
                               
                                </td>
                            <td align="right">
                              <?php if ($value->terkirim == "0"){ ?>
                                0
                              <?php }else{ ?>
                              <?php if($konsumen[$value->id_konsumen]['kategori_konsumen'] == "PKP"){ echo rupiah($value->harga_jual - $hsl); }else{ echo rupiah($value->harga_jual); } ?>
                              <?php } ?></td>
                            <td align="right"><?php
                                echo rupiah($value->potongan);
                            ?></td>
                            <td align="right"><?php
                                    if($value->terkirim > 0){
                                        echo rupiah(($value->sub_potongan / $value->terkirim));
                                    }else{
                                        echo "0";
                                    }
                            ?></td>
                            <td align="right">{{rupiah($value->sub_total)}}</td>
                            <td><?php if (isset($karyawan[$value->sales]['nama'])): ?>{{$karyawan[$value->sales]['nama']}}<?php endif; ?></td>
                            <td><?php if (isset($karyawan[$value->pengembang]['nama'])): ?>{{$karyawan[$value->pengembang]['nama']}}<?php endif; ?></td>
                            <td><?php if (isset($karyawan[$value->leader]['nama'])): ?>{{$karyawan[$value->leader]['nama']}}<?php endif; ?></td>
                            <td>
                                <?php if (isset($karyawan[$value->manager]['nama'])){ ?> 
                                  <?php if(isset($karyawan[$value->manager]['nama'])) { echo $karyawan[$value->manager]['nama']; } ?>
                                  <?}else{?>
                                  -
                                <?php } ?>
                                </td>
                            <td>
                              <?php if ($value->admin_p != ""): ?>
                                {{$admin[$value->admin_p]}}
                              <?php endif; ?>
                            </td>
                            <td>
                              <?php if ($value->admin_g != ""): ?>
                                {{$admin[$value->admin_g]}}
                              <?php endif; ?>
                            </td>
                            <td>
                              <?php if ($value->admin_v != ""): ?>
                                {{$admin[$value->admin_v]}}
                              <?php endif; ?>
                            </td>
                            <td>
                                <?php if (isset($karyawan[$value->qc]['nama'])){ ?> 
                                  <?php if (isset($karyawan[$value->qc]['nama'])): ?>{{$karyawan[$value->qc]['nama']}}<?php endif; ?>
                                  <?}else{?>
                                  -
                                <?php } ?>
                                </td>
                            <td hidden><?php if (isset($karyawan[$value->dropper]['nama'])): ?>{{$karyawan[$value->dropper]['nama']}}<?php endif; ?></td>
                            <td>
                                <?php if (isset($karyawan[$value->pengirim]['nama'])){ ?> 
                                  <?php if (isset($karyawan[$value->pengirim]['nama'])): ?>{{$karyawan[$value->pengirim]['nama']}}<?php endif; ?>
                                  <?}else{?>
                                  -
                                <?php } ?>
                                </td>
                            <td>
                                <?php if (isset($karyawan[$value->helper]['nama'])){ ?> 
                                  <?php if(isset($karyawan[$value->helper]['nama'])){ echo $karyawan[$value->helper]['nama']; }?>
                                  <?}else{?>
                                  -
                                <?php } ?>
                                </td>
                            <td>{{$text_gudang[$value->id_gudang]}}</td>
                            <td>{{$value->status_barang}}</td>
                            <td>{{$text_status_order[$value->status_order]}}</td>
                            <td>
                                <?php if ($value->ket_tmbhn != null){ ?> 
                                  {{$value->ket_tmbhn}}
                                  <?}else{?>
                                  -
                                <?php } ?>
                                </td>
                          </tr>
                         <?php $total_penjualan += $value->sub_total;
                               if ($value->harga_net > $value->harga_jual) {
                                 $selisih += 0;
                               }else{
                                 $selisih += ($value->terkirim * ($value->harga_jual - $value->harga_net -  $value->potongan)) - $value->sub_potongan;
                               }
                         } } } }?>
                      </tbody>
                  </table>
								</div>

                <br><br>
                <div class="row">
                  <div class="col-lg-6">
                    <h3>Nilai Penjualan : {{rupiah($total_penjualan)}}</h3>
                  </div>
                  <div class="col-lg-6">
                    <h3>Selisih Retail: {{rupiah($selisih)}}</h3>
                  </div>
                </div>
                <hr><br>
                <div style="border:2px dashed #eee;border-radius:20px; padding:20px; backgroud:#f5f5f5">
                <h4>&nbsp;&nbsp;&nbsp;Cetak Ulang Kwitansi</h4>
                <div class="col-lg-8">
                  <div class="row">
                    <div class="col-lg-4">
                      <input type="text" id="no_kwitansi" maxlength="15" class="form-control" placeholder="Ketik No. Kwitansi...">
                    </div>
                    <div class="col-lg-3">
                      <button class="btn btn-danger" onclick="kwitansi()">Cetak Nota Besar</button>
                    </div>
                  </div>
                </div>
                <br>
                <div class="col-lg-8">
                  <div class="row">
                    <div class="col-lg-4">
                      <input type="text" id="no_kwitansi2" maxlength="15" class="form-control" placeholder="Ketik No. Kwitansi...">
                    </div>
                    <div class="col-lg-3">
                      <button class="btn btn-secondary" onclick="cetaknota()">Cetak Nota  POS</button>
                    </div>
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
                        <th>No. ID</th>
                        <th>NIK</th>
                        <th>Nama Petugas</th>
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

      <div class="modal fade" id="konsumen" role="dialog">
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
                          <th>No. ID</th>
                          <th>Nama Member</th>
                          <th>Alamat</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($konsumen as $key => $value): ?>
                        <tr onclick="pilihkonsumen('{{$value['id_konsumen']}}','{{$value['nama']}}')">
                          <td>{{$value['id_konsumen']}}</td>
                          <td>{{$value['nama']}}</td>
                          <td><?=$value['alamat']?></td>
                        </tr>
                      <?php endforeach; ?>
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
      var cek = true;
      var data_id = [];
      $(document).ready(function() {
          var table = $('#exam').DataTable();
          $('#exam tbody').on('click', 'tr', function () {
              var data = table.row( this ).data();
              pilihpetugas(data[0],data[2]);
          } );
      } );

      function carikonsumen(){
        $('#konsumen').modal('show');
      }

      function carijabatan(){
        var value = document.getElementById("petugas").value;

          $.ajax({
             url: 'getHuman/'+value,
             type: 'get',
             dataType: 'json',
             async: false,
             success: function(response){
               var table = $('#exam').DataTable();
               table.clear().draw();
               data_id = [];
               for (var i = 0; i < response.length; i++) {
                 data_id[response[i]['nik']] = response[i]['id'];
                 if (value == "admin_p" || value == "admin_g" || value == "admin_v") {
                   var id = response[i]['id'];
                   var nama = response[i]['name'];
                   table.row.add( [
                     response[i]['id'],
                     response[i]['nik'],
                     response[i]['name']
                     //response[i]['no_hp']
                     //'<button class="btn btn-success" onclick="pilihpetugas('+id+','+"'"+nama+"'"+')">Pilih</button>'
                   ] ).draw( false );
                 }else{
                   var id = response[i]['id'];
                   var nama = response[i]['nama'];
                   table.row.add( [
                     response[i]['id'],
                     response[i]['nik'],
                     response[i]['nama']
                     //response[i]['no_hp']
                     //'<button class="btn btn-success" onclick="pilihpetugas('+id+','+"'"+nama+"'"+')">Pilih</button>'
                   ] ).draw( false );
                 }
               }
               $('#jabatan').modal('show');
             }
           });
      }

      function pilihpetugas(id,nama){
        $('#jabatan').modal('hide');
        document.getElementById("name").value = nama;
        document.getElementById("id").value = id;
      }

      function pilihkonsumen(id,nama){
        $('#konsumen').modal('hide');
        document.getElementById("name_konsumen").value = nama;
        document.getElementById("id_konsumen").value = id;
      }

      function Reload(bulan){
        location.href="{{url('/dataorderpenjualan/')}}"+"/"+bulan;
      }

      function cetaknota() {
        var no_kwitansi2 = document.getElementById("no_kwitansi2").value;
        window.open("{{url('/cetaknota/')}}"+'/'+no_kwitansi2);
      }
      function kwitansi() {
        var no_kwitansi = document.getElementById("no_kwitansi").value;
        window.open("{{url('/kwitansi/')}}"+'/'+no_kwitansi);
      }
      </script>

@endsection
