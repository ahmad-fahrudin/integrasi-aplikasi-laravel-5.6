@extends('template/nav')
@section('content')
        <div class="page-wrapper">
        <div class="container-fluid">
            <div class="row">
              <div class="col-md-12">
                <div class="card" style="min-height: 100vh;">
                  <div class="card-body">
                    <div class="pos-f-t">
  
  <nav class="navbar navbar-dark bg-white">
    <h3 class="card-title text-left d-flex">
    <button style="border:solid 1px #eee" class="navbar-toggler text-success" style="color:#444" type="button" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="true" aria-label="Toggle navigation">
      <i data-feather="user" class="feather-icon"></i>
    </button>
    
    <ul class="nav nav-tabs border-0" role="tablist">
    <li class="nav-item">
    <a class="nav-link active show" href="#input" role="tab" data-toggle="tab" style="border:solid 1px #eee"><i data-feather="zoom-in" class="feather-icon"></i></a>
    </li>
    <li class="nav-item">
    <a class="nav-link" href="#barcode" role="tab" data-toggle="tab" style="border:solid 1px #eee"><i data-feather="camera" class="feather-icon"></i></a>
    </li>
    <li hidden class="nav-item">
    <a class="nav-link" href="#tambahan" role="tab" data-toggle="tab" style="border:solid 1px #eee"><i data-feather="edit" class="feather-icon"></i></a>
    </li>
    </ul>
    
    <a href="{{url('/endsession')}}" target="_blank" class="btn text-danger" style="border:solid 1px #eee"><i data-feather="paperclip" class="feather-icon"></i> Histori Kasir</a>
    </h3>
    <h3 class="card-title text-right d-flex">
    <span style="border:1px solid #Fb3200;background:#ff9900;padding:5px;border-radius:10px;color:#fff"><i data-feather="shopping-bag" class="feather-icon"></i> &ensp;<b id="jumlah_belanja">0</b></span>&emsp;&emsp;<span class="d-md-block" style="width:200px;border:1px solid #Fb3200;background:#ff9900;padding:5px;border-radius:10px;color:#fff"><div style="float:left">Rp.</div> <div style="float:right"><b id="total_belanja">0</b>,-</div></span>
    </h3>
  </nav>
  
  <div class="collapse show" id="navbarToggleExternalContent">
    <div class="bg-white">
      <div style="border:2px dashed #eee;border-radius:10px; padding:20px; background:#f5f5f5">
                    <div class="row">
                    <div class="col-md-4">
                        <div class="row ">
                          <label class="col-lg-3">No. Kwitansi</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <?php date_default_timezone_set('Asia/Jakarta'); ?>
                                      <input type="text" id="no_kwitansi" value="{{'GR-'.date('ymd').$number}}" readonly class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Tanggal</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input type="date" id="tanggal_order" value="{{date('Y-m-d')}}" class="form-control" readonly>
                                  </div>
                              </div>
                          </div>
                        </div>
                    </div>
                     <div class="col-md-4">
                        <div class="row">
                          <label class="col-lg-3">Nama</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                   <div class="input-group">
                                    <input id="nama_pemilik" type="text" class="form-control"  readonly>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button"><a href="{{url('inputkonsumen')}}" target="_blank"><i class="fas fa-plus"></i></a></button>
                                    </div>
                                  </div>
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Alamat</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <p class="form-control1" id="alamat"></p>
                                  </div>
                              </div>
                          </div>
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="row" <?php if (Auth::user()->id != 1): ?>hidden<?php endif; ?>>
                          <label class="col-lg-3">Cabang</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <select id="id_gudang" class="form-control">
                                        <?php foreach ($gudang as $value): ?>
                                            <option value="{{$value->id}}">{{$value->nama_gudang}}</option>
                                        <?php endforeach; ?>
                                      </select>
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Status</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input readonly type="text" class="form-control1" id="status_member"></p>
                                  </div>
                              </div>
                          </div>
                        </div>
                    </div>
                    
                </div>
                </div>
                </div>
             </div>
            </div>
                    <hr>

                    <div class="row">
                      <div class="col-md-5">
                        <div class="row">
                          <div class="col-lg-10">
                        <div class="row">
                          <label class="col-lg-3">ID member</label>
                          <div class="col-lg-8">
                            <div class="row">
                                <div class="col-md-11">
                                  <div class="input-group">
                                    <input id="val_konsumen" type="text" class="form-control" placeholder="Pilih Member" readonly style="background:#fff">
                                    <input id="id_konsumen" type="hidden" class="form-control">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" onclick="carikonsumen()" type="button"><i class="fas fa-folder-open"></i></button>
                                    </div>
                                  </div>
                                </div>
                            </div>
                          </div>
                        </div>
                       
                        <br>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade in active show" id="input">
                        <div class="row">
                        <label class="col-lg-3" >Barcode</label>
                            <div class="col-lg-8">
                            <div class="row">
                                <div class="col-md-11">
                                    <div class="input-group">
                                        <input id="barcodescan"  type="text" class="form-control" placeholder="" onchange="onbarcoding()"><div class="wrapper">
                                        </div>
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-outline-secondary border-0" data-toggle="tooltip" data-placement="top" 
                                        title="Untuk scan dengan Barcode Scanner, silahkan klik pada kolom [ | ] terlebih dahulu. Atau Anda juga dapat mengetik langsung kode barcode disini.">
                                        <i data-feather="alert-circle" class="feather-icon"></i></button>
                                    </div>
                                    </div>
                                    <br>
                                </div>
                            </div>
                            </div>
                        </div>
                        
                        <div class="row" id="scrollto">
                          <label class="col-lg-3">No. SKU</label>
                          <div class="col-lg-8">
                            <div class="row">
                                <div class="col-md-11">
                                  <div class="input-group">
                                    <input id="val_barang"  type="text" class="form-control" placeholder="Pilih Barang" readonly style="background:#fff">
                                    <input id="id_barang" type="hidden" class="form-control">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" onclick="caribarang()" type="button"><i class="fas fa-folder-open"></i></button>
                                    </div>
                                  </div>
                                </div>
                            </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Nama Barang</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input type="text" readonly id="nama_barang" class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <div class="row" hidden>
                          <label class="col-lg-3">Harga Net</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input type="text" readonly id="harga" class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Harga</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input id="harga_jual" class="form-control" data-a-sign="" value="0" data-a-dec="," data-a-pad=false data-a-sep="." readonly>
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Jumlah Order</label>
                          <div class="col-lg-3">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input type="number" id="order" onchange="cekpotongan()" class="form-control" placeholder="Qty" value="1">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div id="divpotonganpromo" class="row" hidden>
                          <label class="col-lg-3">Potongan Promo (Per Pcs)</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input type="text" id="potonganpromo" readonly value="0" class="form-control" data-a-sign="" value="0" data-a-dec="," data-a-pad=false data-a-sep=".">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <div id="divpotongan" class="row" hidden>
                          <label class="col-lg-3">Potongan Promo (Per Pcs)</label>
                          <div class="col-lg-3">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input type="text" id="potongan" readonly value="0" class="form-control" value="0" >
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <center><button class="btn btn-primary btn-lg" onclick="Tambah()"> Tambah </button></center>
                        <br>
                        <div class="row" style="display:none;">
                          <label class="col-lg-3">Status Barang</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input type="text" id="status_barang" value="order" readonly class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>   
                    </div>
  
                        <div role="tabpanel" class="tab-pane fade" id="barcode">
                         <div class="row">
                                <div class="col-md-12">
                                    <div class="input-group">
                                    <div id="qr-reader" style="width:100%"></div>
                                    <div id="qr-reader-results"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
  
                        <div role="tabpanel" class="tab-pane fade" id="tambahan">
  
         
                        <div class="row">
                          <label class="col-lg-3">Nama Barang</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input type="text" id="" maxlength="40" class="form-control" placeholder="Ketik nama produk khusus">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Harga HP</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input type="number" id="" class="form-control" placeholder="Ketik Harga Dasar">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Harga</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input type="number" id="" class="form-control" placeholder="Ketik Harga Jual">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Jumlah Order</label>
                          <div class="col-lg-3">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input type="number" id="" class="form-control" placeholder="Qty">
                                  </div>
                              </div>
                          </div>
                        </div>
                        
                        <br>
                        <center><button class="btn btn-primary btn-lg" onclick="Tambah()"> Tambah </button></center>
                        <br>
         

                        </div>
                            </div>                           
    
                            
                          </div>
                        </div>
                        
                        <br>

                        
                      </div>


                      <div class="col-md-7">
                          <h3>Daftar Belanja</h3>

                        <div class="table-responsive">
                        <table id="cart" class="table table-striped table-bordered no-wrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No. SKU</th>
                                    <th>Nama Barang</th>
                                    <th>Qty</th>
                                    <th>Harga</th>
                                    <th>Potongan</th>
                                    <th>Jumlah Harga</th>
                                    <th>Tindakan</th>
                                </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td colspan="8"></td>
                              </tr>
                              <tr>
                                <td colspan="6"><center>Total Bayar</center></td>
                                <td colspan="3"><center><p id="total_bayar">0</p></center></td>
                              </tr>
                            </tbody>
                        </table>
      								</div>
      								
                        <div>
                        <br>
                        <div  <?php if(Auth::user()->level != 1){echo "hidden"; } ?> style="width:100%;height:80px;display:flex">
                        <input type="checkbox" name="pembayaran_lunas" id="pembayaran_lunas" style="width:20px;height:20px;" value="lunas" onclick="Lunaskan()">&emsp;Tandai Sebagai Lunas
                        <div class="col-lg-4">
                        <select id="jenis_pembayaran" class="form-control" onchange="CekBankAktif()" hidden>
                            <option>Tunai</option>
                            <option>Transfer</option>
                        </select>
                        <select id="no_rekening_bank" class="form-control" hidden>
                            <option>--Pilih Rekening Bank--</option>
                            <?php foreach($rekening as $val_rek){ ?>
                            <option value="{{$val_rek->id}}">{{$val_rek->nama}} ({{$val_rek->no_rekening}})</option>
                            <?php } ?>
                        </select>
                        </div>
                        </div>
      					<hr>
      					<br>
                        <div class="row">
                          <label class="col-lg-2">Pembayaran</label>
                          <div class="col-lg-4">
                              <div class="row">
                                  <div class="col-md-11">
                                    <input type="text" id="pembayaran" onchange="CekBayar()" value="0" class="form-control" value="0" data-a-sign="" value="0" data-a-dec="," data-a-pad=false data-a-sep=".">
                                  </div>
                              </div>
                          </div>
                          <label class="col-lg-2">Kembalian</label>
                          <div class="col-lg-4">
                              <div class="row">
                                  <div class="col-md-11">
                                    <input type="text" id="kembalian" readonly value="0" class="form-control" value="0" data-a-sign="" value="0" data-a-dec="," data-a-pad=false data-a-sep=".">
                                  </div>
                              </div>
                          </div>
                        </div>

                      <br>
                      <div style="display:flex;justify-content:center;margin:10px">
                        <button class="btn btn-success btn-lg" id="save" disabled onclick="Simpan()">Proses & Cetak Nota</button>
                        <button hidden class="btn btn-warning btn-lg" id="cetak" target="_blank" disabled onclick="Cetak()">Cetak Nota</button>
                        <button hidden class="btn btn-warning btn-lg d-none" id="cetak2" target="_blank" disabled onclick="Cetak2()">Nota Besar</button>
                      </div>

                        <div class="row">
                          <div class="col-lg-4" style="display:none;">
                            <div class="row">
                                <div class="col-md-11">
                                  <div class="input-group">
                                    <input id="id_pengembang"  type="hidden" class="form-control">
                                    <input id="valpengembang" type="text" readonly class="form-control">
                                  </div>
                                </div>
                            </div>
                          </div>
                         </div>
                        <div class="row">
                          <div class="col-lg-4" style="display:none;">
                            <div class="row">
                                <div class="col-md-11">
                                  <div class="input-group">
                                    <input id="id_leader"  type="hidden" class="form-control">
                                    <input id="valleader" type="text" readonly class="form-control">
                                  </div>
                                </div>
                            </div>
                          </div>
                          <div class="col-lg-4" style="display:none;">
                            <div class="row">
                                <div class="col-md-11">
                                  <?php if (Auth::user()->gudang == "1"){ ?>
                                  <div class="input-group">
                                    <input id="id_manager"  type="hidden" class="form-control">
                                    <input id="valmanager" type="text" readonly class="form-control">
                                  </div>
                                <?php }else{ ?>
                                  <div class="input-group" hidden>
                                    <input id="id_manager" type="hidden" value="1" class="form-control">
                                    <input id="valmanager" value="Master" readonly type="text" class="form-control">
                                  </div>
                                <?php } ?>
                                </div>
                            </div>
                          </div>
                        </div>

                      </div>
                    </div>
                    <br>
                         <div hidden class="col-md-4>
                        <div class="row">
                          <label class="col-lg-3">Kasir</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input type="text" value="{{Auth::user()->username}}" readonly class="form-control">
                                  </div>
                              
                          </div>
                        </div>
                        <br>
                        <div hidden class="row">
                          <label class="col-lg-3">Sales</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                    <div class="input-group">
                                      <input type="text" id="id_sales" value="Auth::user()->id" readonly class="form-control">
                                    </div>
                                  </div>
                              </div>
                            </div>
                        </div>
                        <br>
                        <div class="row" <?php if (Auth::user()->id != 1): ?>hidden<?php endif; ?> hidden>
                          <label class="col-lg-3">Status Order</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <select id="status_order" name="kategori" class="form-control">
                                        <?php if (Auth::user()->level == "5"){ ?>
                                          <?php foreach ($status_order as $value): if ($value->id == "1") { ?>
                                          <option value="{{$value->id}}">{{$value->nama_status}}</option>
                                        <?php } endforeach; ?>
                                        <?php }else{ ?>
                                          <?php foreach ($status_order as $value): if ($value->id != "6") { ?>
                                          <option value="{{$value->id}}">{{$value->nama_status}}</option>
                                        <?php } endforeach; } ?>
                                      </select>
                                  </div>
                              </div>
                          </div>
                        </div>
                        </div>
                            
                        </div>
                        </div>
                        </div>

                    <div class="row">
                      <div class="col-md-6">

                        <div class="row" hidden>
                          <label class="col-lg-3">Kategori</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <select id="kategori" onchange="createkonsumen()" name="kategori" class="form-control">
                                        <option> -- Pilih -- </option>
                                        <?php
                                        if (Auth::user()->level == "5") {
                                          foreach ($kategori as $value) {
                                            if ($value->id == "1") {
                                              echo '<option value="'.$value->id.'">'.$value->nama_kategori.'</option>';
                                            }
                                          }
                                        }elseif (Auth::user()->gudang == "1" || Auth::user()->gudang == "2") {
                                          foreach ($kategori as $value): ?>
                                          <option value="{{$value->id}}">{{$value->nama_kategori}}</option>
                                          <?php endforeach;
                                        }else{
                                          foreach ($kategori as $value) {
                                            if ($value->id == Auth::user()->gudang) {
                                              echo '<option value="'.$value->id.'">'.$value->nama_kategori.'</option>';
                                            }
                                          }
                                        } ?>
                                      </select>
                                  </div>
                              </div>
                          </div>
                        </div>
                        <div class="row" hidden>
                          <label class="col-lg-3">No. HP</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input id="no_hp" readonly type="text" class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>

                      </div>

                      <div class="col-md-6">
                        <div class="row">

                        </div>
                      </div>
                    </div>

    <div class="modal fade" id="modalkonsumen" role="dialog">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">

              <div class="table-responsive">
              <table id="examples1" class="table table-striped table-bordered no-wrap" style="width:100%">
                  <thead>
                      <tr>
                          <th>ID Konsumen</th>
                          <th>Nama Pemilik</th>
                          <th>No HP</th>
                          <th>Alamat</th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($pelanggan as $key => $value): ?>
                      <tr onclick="pilihkonsumen('{{$value->id}}','{{$value->id_konsumen}}','{{$value->nama_pemilik}}','{{$value->alamat}}','{{$value->no_hp}}','{{$value->nama}}','{{$value->pengembang}}','{{$value->nama_leader}}','{{$value->leader}}','{{$value->kota}}','{{$value->kategori}}','{{$value->jenis_konsumen}}')">
                        <td>{{$value->id_konsumen}}</td>
                        <td>{{$value->nama_pemilik}}</td>
                        <td>{{$value->no_hp}}</td>
                        <td><?php echo $value->alamat; ?></td>
                        </td>
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

      <div class="modal fade" id="modalstaff" role="dialog">
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
                            <th>ID Konsumen</th>
                            <th>Nama Pemilik</th>
                            <th>No HP</th>
                            <th>Alamat</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($staff as $key => $value): ?>
                          <tr onclick="pilihkonsumen('{{$value->id}}','{{$value->id}}','{{$value->nama}}','{{$value->alamat}}','{{$value->no_hp}}','{{$value->nama}}','{{$value->id}}','{{$value->nama}}','{{$value->id}}','{{$value->id}}')">
                          <td>{{$value->id}}</td>
                          <td>{{$value->nama}}</td>
                          <td>{{$value->no_hp}}</td>
                          <td><?php echo $value->alamat; ?></td>
                          </td>
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

      <div class="modal fade" id="modalsales" role="dialog">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body">

                <div class="table-responsive">
                <table id="examples6" class="table table-striped table-bordered no-wrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>No HP</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($sales as $value){ ?>
                        <tr onclick="pilihsales('{{$value->id}}','{{$value->nama}}')">
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

        <div class="modal fade" id="modalpengembang" role="dialog">
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
                              <th>No HP</th>
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

          <div class="modal fade" id="modalleader" role="dialog">
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
                                <th>No HP</th>
                            </tr>
                        </thead>
                        <tbody>
                          <?php foreach ($leader as $value){ ?>
                            <tr onclick="pilihleader('{{$value->id}}','{{$value->nama}}')">
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

            <div class="modal fade" id="modalmanager" role="dialog">
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
                                  <th>NIK</th>
                                  <th>Nama</th>
                                  <th>Alamat</th>
                                  <th>No HP</th>
                              </tr>
                          </thead>
                          <tbody>
                            <?php foreach ($manager as $value){ ?>
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

              <div class="modal fade" id="modelbarang" role="dialog">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                      </div>
                      <div class="modal-body">

                        <div class="table-responsive">
                        <table id="examples5" class="table table-striped table-bordered no-wrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No. SKU</th>
                                    <th>Nama Barang</th>
                                    <th>Item No.</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                              <?php foreach ($barang as $value){ ?>
                                <tr onclick="pilihbarang('{{$value->id}}','{{$value->no_sku}}','{{$value->nama_barang}}','{{$value->harga}}','{{$value->harga_hp}}','{{$value->harga_retail}}'
                                                          ,'{{$value->qty1}}','{{$value->pot1}}','{{$value->qty2}}','{{$value->pot2}}','{{$value->qty3}}','{{$value->pot3}}','{{$value->label}}','{{$value->harga_hpp}}','{{$value->harga_reseller}}','{{$value->harga_agen}}','{{$value->part_number}}')">
                                    <td>{{$value->no_sku}}</td>
                                    <td>{{$value->nama_barang}}</td>
                                    <td>{{$value->part_number}}</td>
                                    
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

                <div class="modal fade" id="editing" role="dialog">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                          Order :
                          <input type="number" id="edorder" class="form-control">
                          Harga Jual :
                          <input type="number" id="edhargajual" class="form-control">
                          <input type="hidden" id="edpotongan" class="form-control">
                          <input type="hidden" id="edid" class="form-control">
                          <input type="hidden" id="orderan_stok" class="form-control">
                          <br>
                          <center><button onclick="save()" class="btn btn-primary btn-lg">Update</button></center>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                      </div>
                    </div>
                  </div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script src="aset/html5-qrcode.min.js"></script>
<script>
var delayInMilliseconds = 500;
var is_retail = new Boolean(true);

var cek_Status_konsumen = "";

new AutoNumeric('#harga_jual', "euroPos");
new AutoNumeric('#pembayaran', "euroPos");
new AutoNumeric('#kembalian', "euroPos");
new AutoNumeric('#potonganpromo', "euroPos");

AutoNumeric.getAutoNumericElement('#pembayaran').set(0);
AutoNumeric.getAutoNumericElement('#kembalian').set(0);

var total_bayar = 0;
var tempbarang = [];
var tempjumlah = [];
var tempharga_jual = [];
var temppotongan = [];
var temppotonganpromo = [];
var tempsub_total = [];
var tempharga_net = [];

var prv = "<?= allprevillage()?>";
var qty1 = 0;
var pot1 = 0;
var qty2 = 0;
var pot2 = 0;
var qty3 = 0;
var pot3 = 0;

var line_barang = [];

var no_kwitansi_cetak = "";

function Cetak(){
  const myArr = no_kwitansi_cetak.split(",");
  window.open("{{url('/cetaknota/')}}"+"/"+myArr[1]);
}

function Cetak2(){
  const myArr = no_kwitansi_cetak.split(",");
  window.open("{{url('/kwitansi/')}}"+'/'+myArr[1]);
}

function docReady(fn) {
    // see if DOM is already available
    if (document.readyState === "complete"
        || document.readyState === "interactive") {
        // call on next available tick
        setTimeout(fn, 1000);
    } else {
        document.addEventListener("DOMContentLoaded", fn);
    }
}

function play(){
  var audio = new Audio('aset/beep.wav');
  audio.play();
}

docReady(function () {
    var resultContainer = document.getElementById('qr-reader-results');
    var lastResult, countResults = 0;
    function onScanSuccess(decodedText, decodedResult) {

            console.log(decodedText);
            $.ajax({
               url: 'getBarangKasir/'+decodedText,
               type: 'get',
               dataType: 'json',
               async: false,
               success: function(response){
                 if(response.length > 0){
                   play();
                   document.getElementById("val_barang").value = response[0]['no_sku'];
                   document.getElementById("id_barang").value = response[0]['id'];
                   document.getElementById("nama_barang").value = response[0]['nama_barang'];
                  
                   document.getElementById("order").value = 1;
                   if (is_retail) {
                     AutoNumeric.getAutoNumericElement('#harga_jual').set(response[0]['harga_retail']);
                   }else{
                     AutoNumeric.getAutoNumericElement('#harga_jual').set(response[0]['harga']);
                   }

                   if (response[0]['label'] == "1" || response[0]['label'] == 1) {
                     qty1 = response[0]['qty1'];
                     qty2 = response[0]['qty2'];
                     qty3 = response[0]['qty3'];
                     pot1 = response[0]['pot1'];
                     pot2 = response[0]['pot2'];
                     pot3 = response[0]['pot3'];
                  }else{
                    qty1 = 0;
                    qty2 = 0;
                    qty3 = 0;
                    pot1 = 0;
                    pot2 = 0;
                    pot3 = 0;
                    document.getElementById("potongan").value = 0;
                    document.getElementById("divpotongan").hidden = "true";
                  }
                   var gd = document.getElementById("id_gudang").value;
                   var ck_prv = prv.split(",");
                   var cek_previllage = false;
                   for (var i = 0; i < ck_prv.length; i++) {
                     if (Number(gd) == ck_prv[i]) {
                       cek_previllage = true;
                     }
                   }
                   if (cek_previllage) {
                     document.getElementById("harga").value = numberWithCommas(response[0]['harga_retail']);
                   }else{
                     document.getElementById("harga").value = numberWithCommas(response[0]['harga']);
                   }

                   $.ajax({
                    url: 'cekpotonganperusahaan/'+barang,
                    type: 'get',
                    dataType: 'json',
                    async: false,
                    success: function(response){
                      if (response.length > 0) {
                        document.getElementById("divpotonganpromo").hidden = false;
                        AutoNumeric.getAutoNumericElement('#potonganpromo').set(response[0]['persentase']);
                      }else{
                        document.getElementById("divpotonganpromo").hidden = true;
                        AutoNumeric.getAutoNumericElement('#potonganpromo').set(0);
                      }
                    }
                  });


                   Tambah();
                 }
               }
             });

    }

    var html5QrcodeScanner = new Html5QrcodeScanner(
        "qr-reader", { fps: 1, qrbox: 250 });
    html5QrcodeScanner.render(onScanSuccess);
});


function onbarcoding(){
  var sdf = document.getElementById("barcodescan").value;
  $.ajax({
     url: 'getBarangKasir/'+sdf,
     type: 'get',
     dataType: 'json',
     async: false,
     success: function(response){
       if(response.length > 0){
         play();
         document.getElementById("val_barang").value = response[0]['no_sku'];
         document.getElementById("id_barang").value = response[0]['id'];
         document.getElementById("nama_barang").value = response[0]['nama_barang'];
        
         document.getElementById("order").value = 1;

         if (is_retail) {
             AutoNumeric.getAutoNumericElement('#harga_jual').set(response[0]['harga_retail']);
           }else{
             AutoNumeric.getAutoNumericElement('#harga_jual').set(response[0]['harga']);
           }
         
         
         if (response[0]['label'] == "1" || response[0]['label'] == 1) {
           qty1 = response[0]['qty1'];
           qty2 = response[0]['qty2'];
           qty3 = response[0]['qty3'];
           pot1 = response[0]['pot1'];
           pot2 = response[0]['pot2'];
           pot3 = response[0]['pot3'];
        }else{
          qty1 = 0;
          qty2 = 0;
          qty3 = 0;
          pot1 = 0;
          pot2 = 0;
          pot3 = 0;
          document.getElementById("potongan").value = 0;
          document.getElementById("divpotongan").hidden = "true";
        }
         var gd = document.getElementById("id_gudang").value;
         var ck_prv = prv.split(",");
         var cek_previllage = false;
         for (var i = 0; i < ck_prv.length; i++) {
           if (Number(gd) == ck_prv[i]) {
             cek_previllage = true;
           }
         }
         if (cek_previllage) {
           document.getElementById("harga").value = numberWithCommas(response[0]['harga_retail']);
         }else{
           document.getElementById("harga").value = numberWithCommas(response[0]['harga']);
         }

         $.ajax({
          url: 'cekpotonganperusahaan/'+response[0]['id'],
          type: 'get',
          dataType: 'json',
          async: false,
          success: function(response){
            if (response.length > 0) {
              document.getElementById("divpotonganpromo").hidden = false;
              AutoNumeric.getAutoNumericElement('#potonganpromo').set(response[0]['persentase']);
            }else{
              document.getElementById("divpotonganpromo").hidden = true;
              AutoNumeric.getAutoNumericElement('#potonganpromo').set(0);
            }
          }
        });
        document.getElementById("barcodescan").value = "";
         Tambah();
       }
     }
   });
}


function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function pilihbarang(barang,id,nama,harga,harga_hp,harga_retail,qty1v,pot1v,qty2v,pot2v,qty3v,pot3v,label,harga_hpp,harga_reseller,harga_agen){
  $('#modelbarang').modal('hide');
  document.getElementById("val_barang").value = id;
  document.getElementById("id_barang").value = barang;
  document.getElementById("nama_barang").value = nama;
  if (cek_Status_konsumen == "Distributor") {
    AutoNumeric.getAutoNumericElement('#harga_jual').set(harga);
  }else if(cek_Status_konsumen == "Agen"){
    AutoNumeric.getAutoNumericElement('#harga_jual').set(harga_agen);
  }else if(cek_Status_konsumen == "Reseller"){
    AutoNumeric.getAutoNumericElement('#harga_jual').set(harga_reseller);
  }else{
    AutoNumeric.getAutoNumericElement('#harga_jual').set(harga_retail);  
  }

  if (label == 1 || label == "1") {
    qty1 = qty1v;
    qty2 = qty2v;
    qty3 = qty3v;
    pot1 = pot1v;
    pot2 = pot2v;
    pot3 = pot3v;
  }else{
    qty1 = 0;
    qty2 = 0;
    qty3 = 0;
    pot1 = 0;
    pot2 = 0;
    pot3 = 0;
    document.getElementById("potongan").value = 0;
    document.getElementById("divpotongan").hidden = "true";
  }

  var gd = document.getElementById("id_gudang").value;
  var ck_prv = prv.split(",");
  var cek_previllage = false;
  for (var i = 0; i < ck_prv.length; i++) {
    if (Number(gd) == ck_prv[i]) {
      cek_previllage = true;
    }
  }
  if (cek_previllage) {
    document.getElementById("harga").value = numberWithCommas(harga_hp);
  }else{
    document.getElementById("harga").value = numberWithCommas(harga);
  }


  $.ajax({
   url: 'cekpotonganperusahaan/'+barang,
   type: 'get',
   dataType: 'json',
   async: false,
   success: function(response){
     if (response.length > 0) {
       document.getElementById("divpotonganpromo").hidden = false;
       AutoNumeric.getAutoNumericElement('#potonganpromo').set(response[0]['persentase']);
     }else{
       document.getElementById("divpotonganpromo").hidden = true;
       AutoNumeric.getAutoNumericElement('#potonganpromo').set(0);
     }
   }
 });


  $.ajax({
     url: 'getBarangKasir/'+decodedText,
     type: 'get',
     dataType: 'json',
     async: false,
     success: function(response){
       if(response.length > 0){
         document.getElementById("val_barang").value = response[0]['no_sku'];
         document.getElementById("id_barang").value = response[0]['id'];
         document.getElementById("nama_barang").value = response[0]['nama_barang'];

         AutoNumeric.getAutoNumericElement('#harga_jual').set(response[0]['harga_retail']);
         if (response[0]['label'] == 1 || response[0]['label'] == "1") {
           qty1 = response[0]['qty1'];
           qty2 = response[0]['qty2'];
           qty3 = response[0]['qty3'];
           pot1 = response[0]['pot1'];
           pot2 = response[0]['pot2'];
           pot3 = response[0]['pot3'];
         }else{
           qty1 = 0;
           qty2 = 0;
           qty3 = 0;
           pot1 = 0;
           pot2 = 0;
           pot3 = 0;
         }
         var gd = document.getElementById("id_gudang").value;
         var ck_prv = prv.split(",");
         var cek_previllage = false;
         for (var i = 0; i < ck_prv.length; i++) {
           if (Number(gd) == ck_prv[i]) {
             cek_previllage = true;
           }
         }
         if (cek_previllage) {
           document.getElementById("harga").value = numberWithCommas(response[0]['harga_retail']);
         }else{
           document.getElementById("harga").value = numberWithCommas(response[0]['harga']);
         }


       }
     }
   });


}


function CekBayar(){
  var num_total_bayar = document.getElementById("total_bayar").innerHTML;
  num_total_bayar = num_total_bayar.split(".").join("");
  var num_total_belanja = document.getElementById("total_belanja").innerHTML;
  num_total_belanja = num_total_belanja.split(".").join("");
  if (num_total_bayar == num_total_belanja) {
    var num_pembayaran = document.getElementById("pembayaran").value;
    num_pembayaran = num_pembayaran.split(".").join("");
    var num_kembalian = Number(num_pembayaran) - Number(num_total_bayar);
    AutoNumeric.getAutoNumericElement('#kembalian').set(num_kembalian);
  }
}


function pilihkonsumen(id,id_konsumen,nama_pemilik,alamat,no_hp,nama,pengembang,nama_leader,leader,kota,kategori,jenis_konsumen){
  $('#modalkonsumen').modal('hide');
  $('#modalstaff').modal('hide');
  const status_konsumen_member = ["None","Retail","Reseller","Agen","Distributor"];

  document.getElementById("val_konsumen").value = id_konsumen;
  document.getElementById("id_konsumen").value = id;
  document.getElementById("nama_pemilik").value = nama_pemilik;
  document.getElementById("alamat").innerHTML = alamat;
  document.getElementById("no_hp").value = no_hp;
  document.getElementById("valpengembang").value = nama;
  document.getElementById("id_pengembang").value = pengembang;
  document.getElementById("valleader").value = nama_leader;
  document.getElementById("id_leader").value = leader;
  var id_gudang = document.getElementById("id_gudang").value;
  if (leader == "") {

    Swal.fire({
        title: 'Konsumen Belum Memiliki Leader!',
        icon: 'success',
      });
  }
  
  cek_Status_konsumen = status_konsumen_member[jenis_konsumen];
  document.getElementById("status_member").value = status_konsumen_member[jenis_konsumen];

  /*$.ajax({
     url: 'cekretail/'+no_hp,
     type: 'get',
     dataType: 'json',
     async: false,
     success: function(response){
       if (response == false) {
         is_retail = false;
         document.getElementById("status_member").value = "Reseller";
       }else{
         is_retail = true;
         document.getElementById("status_member").value = "Retail";
       }
     }
   });*/


  var st = document.getElementById("status_order").value;
  if (st == "2" || st == "3") {
    document.getElementById("id_manager").value = leader;
    document.getElementById("valmanager").value = nama_leader;
  }else{
      $.ajax({
         url: 'carimanager/'+kota,
         type: 'get',
         dataType: 'json',
         async: false,
         success: function(response){
           if (response.length > 0) {
             document.getElementById("id_manager").value = response[0]['manager'];
             document.getElementById("valmanager").value = response[0]['nama'];
           }
         }
       });
  }

}

function pilihsales(id,nama){
  $('#modalsales').modal('hide');
  document.getElementById("valsales").value = nama;
  document.getElementById("id_sales").value = id;
}

function pilihpengembang(id,nama){
  $('#modalpengembang').modal('hide');
  document.getElementById("valpengembang").value = nama;
  document.getElementById("id_pengembang").value = id;
}

function pilihleader(id,nama){
  $('#modalleader').modal('hide');
  document.getElementById("valleader").value = nama;
  document.getElementById("id_leader").value = id;
}

function pilihmanager(id,nama){
  $('#modalmanager').modal('hide');
  document.getElementById("valmanager").value = nama;
  document.getElementById("id_manager").value = id;
}

function cekpotongan(){
  var cek = document.getElementById("order").value;
  var el = document.getElementById("divpotongan");
  var gd = document.getElementById("id_gudang").value;

  var ck_prv = prv.split(",");
  var cek_previllage = false;
  for (var i = 0; i < ck_prv.length; i++) {
    if (Number(gd) == ck_prv[i]) {
      cek_previllage = true;
    }
  }
  if (cek_previllage) {
    el.hidden = true;
  }else{
    if (qty1 != 0 && Number(cek) >= qty1) {
      if (Number(cek) >= Number(qty3)) {
        document.getElementById("potongan").value = numberWithCommas(pot3);
      }else if(Number(cek) >= Number(qty2)){
        document.getElementById("potongan").value = numberWithCommas(pot2);
      }else if (Number(cek) >= Number(qty1)) {
        document.getElementById("potongan").value = numberWithCommas(pot1);
      }else{
        document.getElementById("potongan").value = 0;
      }
      el.hidden = false;
    }else{
      document.getElementById("potongan").value = 0;
      el.hidden = true;
    }
  }
}

function carikonsumen(){
  var status = document.getElementById("status_order").value;
  if (status == "2" || status == "3") {
    $('#modalstaff').modal('show');
  }else{
    $('#modalkonsumen').modal('show');
  }
}
function carisales(){
  $('#modalsales').modal('show');
}
function caripengembang(){
  $('#modalpengembang').modal('show');
}
function carileader(){
  $('#modalleader').modal('show');
}
function carimanager(){
  $('#modalmanager').modal('show');
}
function caribarang(){
  $('#modelbarang').modal('show');
}
function Tambah(){
  var key_gudang = document.getElementById("id_gudang").value;
  var orderan_stok = 0;
    var id_barang = document.getElementById("id_barang").value;
  $.ajax({
     url: 'cekstok/'+key_gudang+"/"+id_barang,
     type: 'get',
     dataType: 'json',
     async: false,
     success: function(response){
       orderan_stok = Number(response[0]['jumlah']) - Number(response[0]['reject']);
     }
   });

  var no_sku = document.getElementById("val_barang").value;
  var nama_barang = document.getElementById("nama_barang").value;
  var order = document.getElementById("order").value;
  var harga_jual = document.getElementById("harga_jual").value;
  harga_jual = harga_jual.split(".").join("");
  var potongan = document.getElementById("potongan").value;
  var harga_net = document.getElementById("harga").value;
  harga_net = harga_net.split(".").join("");
  potongan = potongan.split(".").join("");


  var potonganpromo = document.getElementById("potonganpromo").value;
  potonganpromo = potonganpromo.split(".").join("");

  var totalpotongan = Number(potonganpromo)+Number(potongan);


  if(Number(order) > orderan_stok){
    alert("Stok hanya "+orderan_stok);
    order = orderan_stok;
  }

  if (no_sku != "" && order != "" && harga_jual != "" && potongan!= "") {
    var table = document.getElementById("cart");
    var lastRow = table.rows.length - 1;
    var row = table.insertRow(lastRow);
    row.id = lastRow;

    if(line_barang[id_barang] !== undefined){
      var t_jml = document.getElementById("order"+line_barang[id_barang]).innerHTML;
      var t_subtot = document.getElementById("subtotal"+line_barang[id_barang]).innerHTML;
      t_subtot = t_subtot.split(".").join("");
      var t_subit = document.getElementById("harga_jual"+line_barang[id_barang]).innerHTML;
      t_subit = t_subit.split(".").join("");

      if(orderan_stok >= (Number(t_jml)+Number(order))){

        for (var i = 0; i < tempbarang.length; i++) {
          if (tempbarang[i] == id_barang) {
            var key_index_tabel = i;
          }
        }

        var subtotal = ( Number(t_jml)+Number(order) ) * ( harga_jual - totalpotongan);
        tempjumlah[key_index_tabel] = Number(t_jml)+Number(order);
        tempharga_jual[key_index_tabel] = harga_jual;
        temppotongan[key_index_tabel] = totalpotongan;
        temppotonganpromo[key_index_tabel] = potonganpromo;
        tempsub_total[key_index_tabel] = subtotal;
        tempharga_net[key_index_tabel] = harga_net;

        document.getElementById("order"+line_barang[id_barang]).innerHTML = Number(t_jml)+Number(order);
        document.getElementById("subtotal"+line_barang[id_barang]).innerHTML = numberWithCommas(Number(t_subtot) + (Number(t_subit)*Number(order)));
        var sum = tempsub_total.reduce(function(a, b){ return Number(a) + Number(b); }, 0);
        var itm = tempjumlah.reduce(function(a, b){ return Number(a) + Number(b); }, 0);
        tmp_from_total_belanja = document.getElementById("total_belanja").innerHTML;
        tmp_from_total_belanja = tmp_from_total_belanja.split(".").join("");
        document.getElementById("total_belanja").innerHTML = numberWithCommas(Number(tmp_from_total_belanja) + (Number(t_subit)*Number(order)));
        tmp_from_item = document.getElementById("jumlah_belanja").innerHTML;
        tmp_from_item = tmp_from_item.split(".").join("");
        document.getElementById("jumlah_belanja").innerHTML = numberWithCommas(Number(tmp_from_item)+Number(order));
        document.getElementById("total_bayar").innerHTML = numberWithCommas(Number(tmp_from_total_belanja) + (Number(t_subit)*Number(order)));
      }else{
        alert("Stok hanya "+orderan_stok);
      }
    }else{

      var subtotal = order * ( harga_jual - totalpotongan);
      tempbarang[lastRow] = id_barang;
      tempjumlah[lastRow] = order;
      tempharga_jual[lastRow] = harga_jual;
      temppotongan[lastRow] = totalpotongan;
      temppotonganpromo[lastRow] = potonganpromo;
      tempsub_total[lastRow] = subtotal;
      tempharga_net[lastRow] = harga_net;

      line_barang[id_barang] = lastRow;

      var cell1 = row.insertCell(0);
      var cell2 = row.insertCell(1);
      var cell3 = row.insertCell(2);
      var cell4 = row.insertCell(3);
      var cell5 = row.insertCell(4);
      var cell6 = row.insertCell(5);
      var cell7 = row.insertCell(6);


      cell3.innerHTML = "<p id=order"+lastRow+">"+order+"</p>";
      cell6.innerHTML = "<p id=subtotal"+lastRow+">"+numberWithCommas(subtotal)+"</p>";

      cell1.innerHTML = no_sku;
      cell2.innerHTML = nama_barang;
      cell4.innerHTML = "<p id=harga_jual"+lastRow+">"+numberWithCommas(harga_jual)+"</p>";
      cell5.innerHTML = "<p id=potongan"+lastRow+">"+totalpotongan+"</p>";
      cell7.innerHTML = '<button class="btn btn-default" onclick="deletecart('+lastRow+','+subtotal+')"><i class="icon-trash"></i></button>'+
                        '<button class="btn btn-default" onclick="updatecart('+lastRow+','+subtotal+','+order+','+harga_jual+','+totalpotongan+','+orderan_stok+')"><i class="icon-pencil"></i></button>';
      var sum = tempsub_total.reduce(function(a, b){ return Number(a) + Number(b); }, 0);
      var itm = tempjumlah.reduce(function(a, b){ return Number(a) + Number(b); }, 0);
      document.getElementById("total_bayar").innerHTML = numberWithCommas(sum);
      document.getElementById("total_belanja").innerHTML = numberWithCommas(sum);
      document.getElementById("jumlah_belanja").innerHTML = numberWithCommas(itm);
      //AutoNumeric.getAutoNumericElement('#potongan').set(0);

    }
    document.getElementById("id_barang").value = "";
    document.getElementById("val_barang").value = "";
    document.getElementById("nama_barang").value = "";
    document.getElementById("harga").value = "";
    document.getElementById("order").value = "";
    document.getElementById("harga_jual").value = "";
    document.getElementById("divpotongan").hidden = "true";
    document.getElementById("save").disabled = false;
    AutoNumeric.getAutoNumericElement('#harga_jual').set(0);
  }else{
    alert("Isi Semua Field");
  }
}

function updatecart(lastRow,sub,order,harga_jual,potongan,orderan_stok){
  document.getElementById("edorder").value = order;
  document.getElementById("edhargajual").value = harga_jual;
  document.getElementById("edpotongan").value = potongan;
  document.getElementById("edid").value = lastRow;
  document.getElementById("orderan_stok").value = orderan_stok;
  $('#editing').modal('show');
}

/*$(document).ready(function() {
    var table = $('#examp').DataTable();
    $('#examp tbody').on('click', 'tr', function () {
        var data = table.row( this ).data();
        //alert( 'You clicked on '+data[0]+'\'s row' );
        pilihkonsumen(data_id[data[0]],data[0],data[1],data[3],data[2],data_nama[data[0]],data_pengembang[data[0]]);
    } );
} );

$(document).ready(function() {
    var table = $('#exampes').DataTable();
    $('#exampes tbody').on('click', 'tr', function () {
        var data = table.row( this ).data();
        //alert( 'You clicked on '+data[0]+'\'s row' );
        pilihkonsumen(data_id[data[0]],data[0],data[1],data[3],data[2],data_nama[data[0]],data_pengembang[data[0]]);
    } );
} );*/
//window.onload = function(){
  //createkonsumen();
//};

var cek = true;
var data_id = [];
var data_nama = [];
var data_pengembang = [];
function createkonsumen(){
  var kategori = document.getElementById("kategori").value;
  var status = document.getElementById("status_order").value;
  $.ajax({
     url: 'cariKaryawan/'+kategori+"/"+status,
     type: 'get',
     dataType: 'json',
     async: false,
     success: function(response){
       var table = $('#examp').DataTable();
       table.clear().draw();
       data_id = [];
       data_nama = [];
       data_pengembang = [];
       if (status == "2" || status == "3") {
         for (var i = 0; i < response.length; i++) {
           data_id[response[i]['id']] = response[i]['id'];
           data_nama[response[i]['id']] = response[i]['nama'];
           data_pengembang[response[i]['id']] = response[i]['id'];

           table.row.add( [
             response[i]['id'],
             response[i]['nama'],
             response[i]['no_hp'],
             response[i]['alamat']
           ] ).draw( false );
         }
       }else{
         for (var i = 0; i < response.length; i++) {
           data_id[response[i]['id_konsumen']] = response[i]['id'];
           data_nama[response[i]['id_konsumen']] = response[i]['nama'];
           data_pengembang[response[i]['id_konsumen']] = response[i]['pengembang'];

           table.row.add( [
             response[i]['id_konsumen'],
             response[i]['nama_pemilik'],
             response[i]['no_hp'],
             response[i]['alamat']
           ] ).draw( false );
         }
       }

       $('#barang').modal('show');
     }
   });

}

function save(){
  var id = document.getElementById("edid").value;
  var harga_jual = document.getElementById("edhargajual").value;
  var order = document.getElementById("edorder").value;
  var potongan = document.getElementById("edpotongan").value;
  var orderan_stok = document.getElementById("orderan_stok").value;

  if(Number(order) <= Number(orderan_stok)){
    var subtotal = order * ( harga_jual - potongan);
    tempjumlah[id] = order;
    tempharga_jual[id] = harga_jual;
    temppotongan[id] = potongan;
    tempsub_total[id] = subtotal;

    document.getElementById("order"+id).innerHTML = numberWithCommas(order);
    document.getElementById("harga_jual"+id).innerHTML = numberWithCommas(harga_jual);
    //document.getElementById("potongan"+id).innerHTML = potongan;
    document.getElementById("subtotal"+id).innerHTML = numberWithCommas(subtotal);
    var sum = tempsub_total.reduce(function(a, b){ return Number(a) + Number(b); }, 0);
    var itm = tempjumlah.reduce(function(a, b){ return Number(a) + Number(b); }, 0);
    document.getElementById("total_bayar").innerHTML = numberWithCommas(sum);

    document.getElementById("total_belanja").innerHTML = numberWithCommas(sum);
    document.getElementById("jumlah_belanja").innerHTML = numberWithCommas(itm);
  }else{
    alert("Stok hanya "+orderan_stok);
  }

  $('#editing').modal('hide');

}

function deletecart(lastRow,sub){
  Swal.fire(
    'Delete this?',
    'Apakah Anda Yakin?',
    'question'
  ).then((result) => {
    if (result.value) {
      var old = document.getElementById("total_bayar").innerHTML;
      old = old.split(".").join("");
      var itm_hapus = document.getElementById("subtotal"+lastRow).innerHTML;
      itm_hapus = itm_hapus.split(".").join("");
      total_bayar = Number(old) - Number(itm_hapus);

      document.getElementById("total_bayar").innerHTML = numberWithCommas(total_bayar);
      document.getElementById("total_belanja").innerHTML = numberWithCommas(total_bayar);

      var jumlah_hapus = document.getElementById("order"+lastRow).innerHTML;
      jumlah_hapus = jumlah_hapus.split(".").join("");
      var jumlah_sekarang = document.getElementById("jumlah_belanja").innerHTML;
      jumlah_sekarang = jumlah_sekarang.split(".").join("");
      document.getElementById("jumlah_belanja").innerHTML = numberWithCommas(Number(jumlah_sekarang)-Number(jumlah_hapus));

      var row = document.getElementById(lastRow);
      row.parentNode.removeChild(row);

      delete line_barang[tempbarang[lastRow]];

      tempbarang[lastRow] = "";
      tempjumlah[lastRow] = "";
      tempharga_jual[lastRow] = "";
      temppotongan[lastRow] = "";
      temppotonganpromo[lastRow] = "";
      tempsub_total[lastRow] = "";
      tempharga_net[lastRow] = "";

    }
  });
}

function StatusOrder(){
  var value = document.getElementById("status_order").value;
  if (value == "2" || value == "3") {
    document.getElementById("kategori").disabled = true;

    var kategori = document.getElementById("kategori").value;
    var status = document.getElementById("status_order").value;
    $.ajax({
       url: 'cariKaryawan/'+kategori+"/"+status,
       type: 'get',
       dataType: 'json',
       async: false,
       success: function(response){
         var table = $('#examp').DataTable();
         table.clear().draw();
         data_id = [];
         data_nama = [];
         data_pengembang = [];
           for (var i = 0; i < response.length; i++) {
             data_id[response[i]['id']] = response[i]['id'];
             data_nama[response[i]['id']] = response[i]['nama'];
             data_pengembang[response[i]['id']] = response[i]['id'];

             table.row.add( [
               response[i]['id'],
               response[i]['nama'],
               response[i]['no_hp'],
               response[i]['alamat']
             ] ).draw( false );
           }

         $('#barang').modal('show');
       }
     });

  }else{
    var kategori = document.getElementById("kategori").value;
    var status = document.getElementById("status_order").value;
    $.ajax({
       url: 'cariKaryawan/'+kategori+"/"+status,
       type: 'get',
       dataType: 'json',
       async: false,
       success: function(response){
         var table = $('#examp').DataTable();
         table.clear().draw();
         data_id = [];
         data_nama = [];
         data_pengembang = [];
           for (var i = 0; i < response.length; i++) {
             data_id[response[i]['id']] = response[i]['id'];
             data_nama[response[i]['id']] = response[i]['nama'];
             data_pengembang[response[i]['id']] = response[i]['id'];
             console.log(response[i]);
             table.row.add( [
               response[i]['id'],
               response[i]['nama_pemilik'],
               response[i]['no_hp'],
               response[i]['alamat']
             ] ).draw( false );
           }

         $('#barang').modal('show');
       }
     });

    document.getElementById("kategori").disabled = false;
  }
}

function Cek(){
  console.log(tempjumlah);
}

function Lunaskan(){
    var cek_klik = document.getElementById("pembayaran_lunas").checked;
    if(cek_klik){
        document.getElementById("jenis_pembayaran").hidden = false;
    }else{
        document.getElementById("jenis_pembayaran").hidden = true;
    }
}

function CekBankAktif(){
    var ceks = document.getElementById("jenis_pembayaran").value;
    if(ceks == "Transfer"){
        document.getElementById("no_rekening_bank").hidden = false;
    }else{
        document.getElementById("no_rekening_bank").hidden = true;
    }
}

function Simpan(){
  var tandai_pembayaran = document.getElementById("pembayaran_lunas");
  var jenis_pembayaran =document.getElementById("jenis_pembayaran").value;
  var no_rekening_bank =document.getElementById("no_rekening_bank").value;
  
  var nama_pemilik = document.getElementById("nama_pemilik").value ;
  var status_lunas = false;
  if (tandai_pembayaran.checked == true){
    status_lunas = true;
  } else {
    status_lunas = false;
  }
  CekBayar();
  //document.getElementById("save").disabled = true;
  var no_kwitansis = document.getElementById("no_kwitansi").value;
  var tanggal_orders = document.getElementById("tanggal_order").value;
  var status_barangs = document.getElementById("status_barang").value;
  var kategoris = document.getElementById("kategori").value;
  var id_konsumens = document.getElementById("id_konsumen").value;
  var id_gudangs = document.getElementById("id_gudang").value;
  var status_orders = document.getElementById("status_order").value;
  var pengembangs = document.getElementById("id_pengembang").value;
  var saless = document.getElementById("id_sales").value;
  var leaders = document.getElementById("id_leader").value;
  var managers = document.getElementById("id_manager").value;
  var total_bayars = document.getElementById("total_bayar").innerHTML;
  total_bayars = total_bayars.split(".").join("");
  var pembayaran_konsumen = document.getElementById("pembayaran").value;
  pembayaran_konsumen = pembayaran_konsumen.split(".").join("");
  var kembalian_konsumen = document.getElementById("kembalian").value;
  kembalian_konsumen = kembalian_konsumen.split(".").join("");


        console.log(tempsub_total);
        console.log(tempjumlah);

        if (id_konsumens != "" && leaders != "" && saless != "") {

              $.post("postkasir",
                {no_rekening_bank:no_rekening_bank,jenis_pembayaran:jenis_pembayaran,nama_pemilik:nama_pemilik,status_lunas:status_lunas,no_kwitansi:no_kwitansis, tanggal_order:tanggal_orders, status_barang:status_barangs, kategori:kategoris,
                 id_konsumen:id_konsumens, id_gudang:id_gudangs, status_order:status_orders, pengembang:pengembangs,
                 sales:saless, leader:leaders, manager:managers, total_bayar:total_bayars,pembayaran_konsumen:pembayaran_konsumen,kembalian_konsumen:kembalian_konsumen,
                 _token:"{{ csrf_token() }}"}).done(function(data, textStatus, jqXHR)
                    {
                      
                      var newkwitansi = data;
                      no_kwitansi_cetak = data;

                      for (var i = 0; i < tempbarang.length; i++) {
                      if (tempjumlah[i] > 0) {
                      $.post("postkasirdetail",
                        {no_kwitansi:newkwitansi, tanggal_order:tanggal_orders, status_barang:status_barangs, kategori:kategoris,
                         id_konsumen:id_konsumens, id_gudang:id_gudangs, status_order:status_orders, pengembang:pengembangs,
                         sales:saless, leader:leaders, manager:managers, total_bayar:total_bayars,
                         id_barang:tempbarang[i], harga_net:tempharga_net[i], jumlah:tempjumlah[i] , harga_jual:tempharga_jual[i],
                         potongan:temppotongan[i],potonganpromo:temppotonganpromo[i],sub_total:tempsub_total[i], _token:"{{ csrf_token() }}"}).done(function(data, textStatus, jqXHR)
                            {

                                Swal.fire({
                                    title: 'Berhasil',
                                    icon: 'success',
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Lanjutkan!'
                                  }).then((result) => {
                                    if (result.value) {
                                      document.getElementById("save").disabled = true;
                                      document.getElementById("cetak").disabled = false;
                                      document.getElementById("cetak2").disabled = false;
                                    }else{
                                      document.getElementById("save").disabled = true;
                                      document.getElementById("cetak").disabled = false;
                                      document.getElementById("cetak2").disabled = false;
                                    }
                                    const myArr = no_kwitansi_cetak.split(",");
                                    window.open("{{url('/cetaknota/')}}"+"/"+myArr[1]);
                                    location.href="{{url('/kasir/')}}";
                                  });

                            }).fail(function(jqXHR, textStatus, errorThrown)
                        {
                            alert(textStatus);
                        });
                      }
                    }
                    
                    }).fail(function(jqXHR, textStatus, errorThrown)
                {
                    alert(textStatus);
                });

        }else{
          alert("isi semua data");
        } 
}
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>
@endsection
