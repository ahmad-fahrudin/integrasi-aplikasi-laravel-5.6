@extends('template/nav')
@section('content')
<?php //dd($transfer3); ?>
    <div class="page-wrapper">
        <div class="container-fluid">
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">
                      <nav aria-label="breadcrumb">
                          <ol class="breadcrumb ">
                              <li class="breadcrumb-item text-muted" aria-current="page">Gudang > Orderan Gudang > <a href="https://stokis.app/?s=cara+proses+pengeluaran+barang+dan+cetak+nota+untuk+pengiriman" target="_blank">Proses Dikirim (Buat Nota & SPB)</a></li>
                          </ol>
                      </nav>
                    </h4>
                    <hr>
                    <br>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="row">
                          <label class="col-lg-3">No. Kwitansi</label>
                          <div class="col-lg-8">
                            <div class="row">
                                <div class="col-md-11">
                                  <div class="input-group">
                                    <input id="id" type="hidden" class="form-control">
                                    <input id="no_kwitansi" type="text" class="form-control" placeholder="Pilih No. Kwitansi" readonly style="background:#fff">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" onclick="caripenjualan()" type="button"><i class="fas fa-folder-open"></i></button>
                                    </div>
                                  </div>
                                </div>
                            </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Tanggal Order</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input type="date" id="tanggal_order" readonly class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        
                        <div hidden class="row">
                          <label class="col-lg-3">Status Order</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input type="text" id="status_order" value="proses" readonly class="form-control">
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
                                      <input id="nama_gudang" type="text" readonly class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        
                        <div hidden class="row">
                          <label class="col-lg-3">Catatan</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input id="ket_tmbhn" type="text" readonly class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-6"><strong>Data Member</strong></label>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">ID Member</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input id="id_konsumen" type="text" readonly class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        
                        <div class="row">
                          <label class="col-lg-3">Nama</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input id="nama" type="text" readonly class="form-control">
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
                                      <p class="form-control1" id="alamat" style="height:auto;padding-bottom:30px"></p>
                                  </div>
                              </div>
                          </div>
                        </div>
                        
                        <div hidden class="row">
                          <label class="col-lg-3">No. Telepon</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input id="no_hp" type="text" readonly class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        
                        <div hidden class="row">
                          <label class="col-lg-3">Kategori</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input id="kategori" type="text" readonly class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                    
                        <div class="row">
                          <label class="col-lg-3">Limit Piutang Tersedia</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input readonly id="limit_tersedia" class="form-control" value="" data-a-sign="" data-a-dec="," data-a-pad="false" data-a-sep=".">
                                  </div>
                              </div>
                          </div>
                        </div>
                        
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Pengembang</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input id="pengembang" type="text" readonly class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>

                      </div>
                      
                      

                      <div class="col-md-6">
                        <div hidden class="row">
                          <label class="col-lg-3">Tanggal Proses</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input type="date" readonly id="tanggal_proses" value="{{date('Y-m-d')}}" class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>   
                        <br> 
                        <br>
                        <div class="row">
                          <label class="col-lg-6"><strong>Petugas</strong></label>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Sales</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input id="sales" type="text" readonly class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        
                        
                        <div hidden class="row">
                          <label class="col-lg-3">Leader</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input id="leader" type="text" readonly class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        
                        <div hidden class="row">
                          <label class="col-lg-3">Manager</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input id="manager" type="text" readonly class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        
                        <div hidden class="row">
                          <label class="col-lg-3">Admin(P)</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input id="admin_p" type="text" readonly class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">QC Gudang</label>
                          <div class="col-lg-8">
                            <div class="row">
                                <div class="col-md-11">
                                  <div class="input-group">
                                    <input id="nama_qc" required type="text" class="form-control" placeholder="Pilih QC Gudang" readonly style="background:#fff">
                                    <input id="id_qc" required type="hidden" class="form-control">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" onclick="cariqc()" type="button"><i class="fas fa-folder-open"></i></button>
                                    </div>
                                  </div>
                                </div>
                            </div>
                          </div>
                        </div>
                        
                        <div hidden class="row">
                          <label class="col-lg-3">Dropper</label>
                          <div class="col-lg-8">
                            <div class="row">
                                <div class="col-md-11">
                                  <div class="input-group">
                                    <input id="nama_dropper"  type="text" class="form-control" placeholder="Pilih Driver Kiriman" readonly style="background:#fff">
                                    <input id="id_dropper" type="hidden" class="form-control">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" onclick="caridropper()" type="button"><i class="fas fa-folder-open"></i></button>
                                    </div>
                                  </div>
                                </div>
                            </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Pengirim</label>
                          <div class="col-lg-8">
                            <div class="row">
                                <div class="col-md-11">
                                  <div class="input-group">
                                    <input id="nama_pengirim"  type="text" class="form-control" placeholder="Pilih Driver Kiriman" readonly style="background:#fff">
                                    <input id="id_pengirim" type="hidden" class="form-control">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" onclick="caripengirim()" type="button"><i class="fas fa-folder-open"></i></button>
                                    </div>
                                  </div>
                                </div>
                            </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Helper</label>
                          <div class="col-lg-8">
                            <div class="row">
                                <div class="col-md-11">
                                  <div class="input-group">
                                    <input id="nama_helper"  type="text" class="form-control" placeholder="Pilih Helper Kiriman (opsional)" readonly style="background:#fff">
                                    <input id="id_helper" type="hidden" class="form-control">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" onclick="carihelper()" type="button"><i class="fas fa-folder-open"></i></button>
                                    </div>
                                  </div>
                                </div>
                            </div>
                          </div>
                        </div>
                        
                        <div hidden class="row">
                          <label class="col-lg-3">Admin(G)</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input readonly type="text" id="admin_g" readonly value="{{Auth::user()->username}}" class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Ongkos Kirim</label>
                          <div class="col-lg-8">
                              <div class="row">
                                  <div class="col-md-11">
                                      <input type="text" onchange="ongkir()" id="ongkos_kirim" class="form-control" data-a-sign="" value="0" data-a-dec="," data-a-pad=false data-a-sep=".">
                                  </div>
                              </div>
                          </div>
                        </div>
                        
                      </div>

                    </div>

                    <br><br>


                  <br><hr>
				  <div class="table-responsive">
                  <table id="cart" class="table table-striped table-bordered no-wrap" style="width:100%">
                      <thead>
                          <tr style="background:#f5f5f5">
                              <th>No. SKU</th>
                              <th>Nama Barang</th>
                              <th>Item No.</th>
                              <th>Jumlah Order</th>
                              <th>Jumlah Proses</th>
                              <th>Jumlah Pending</th>
                              <th>Harga Jual</th>
                              <th>PPN</th>
                              <th>Potongan</th>
                              <th>Jumlah Harga</th>
                              <th>Tindakan</th>
                          </tr>
                      </thead>
                      <tbody>
                      </tbody>
                  </table>
                  <h3 align="right">Total Bayar = Rp. <b id="total_bayar">0</b>,-</h3>
                  <h3 align="right">Total Keseluruhan = Rp. <b id="keseluruhan">0</b>,-</h3>
								</div>
                <hr><br>
                <center>
                  <!--button class="btn btn-danger btn-lg">Batal</button-->
                  <button class="btn btn-success btn-lg" id="simpan" onclick="Simpan()">Simpan</button>
                  <button class="btn btn-warning btn-lg" id="surat_jalan" disabled onclick="CetakSuratJalan()">Cetak Surat Jalan</button>
                  <button class="btn btn-primary btn-lg" id="cetak_kwitansi" disabled onclick="Cetak2()">Cetak Kwitansi</button>
                  <button class="btn btn-secondary btn-lg" id="cetak_nota" disabled onclick="Cetak3()">Cetak Nota POS</button>
                  <button class="btn btn-danger btn-lg" id="cetak_label" disabled onclick="CetakLabel()">Cetak Label</button>
                </center>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="transfer" role="dialog">
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
                          <th>No. Kwitansi</th>
                          <th>Nama Konsumen</th>
                          <th>Cabang</th>
                          <th>Tanggal Order</th>
                      </tr>
                  </thead>
                  <tbody>
                     <?php foreach ($transfer2 as $value){ ?>
                       <tr onclick="pilihbarang('{{$value->id}}','{{$value->no_kwitansi}}','{{$value->tanggal_order}}','{{$value->id_konsumen}}','{{$value->nama_pemilik}}',
                                                 '{{$value->alamat}}','{{$value->alamat}}','{{$value->no_hp}}','{{$value->nama_gudang}}','{{$value->sales}}',
                                                 '{{$value->pengembang}}','{{$value->leader}}','{{$value->manager}}','{{$value->admin_p}}','{{$value->kategori}}',0,'','0','0')">
                           <td>{{$value->no_kwitansi}}</td>
                           <td>{{$value->nama_pemilik}}</td>
                           <td>{{$value->nama_gudang}}</td>
                           <td>{{$value->tanggal_order}}</td>
                       </tr>
                      <?php } ?>
                      <?php foreach ($transfer3 as $value){

                        if(isset($karyawan[$value->pengembang])){
                          $pengembang = $karyawan[$value->pengembang]['nama'];
                        }else if(isset($konsumen[$value->pengembang]['nama_pemilik'])){
                          $pengembang = $konsumen[$value->pengembang]['nama_pemilik'];
                        }else{
                          $pengembang = "";
                        }

                        if(isset($value->sales)){
                          if(isset($karyawan[$value->sales])){
                            $sales = $karyawan[$value->sales]['nama'];
                          }else{
                            $sales = $konsumen[$value->sales]['nama_pemilik'];
                          }
                        }else{
                          $sales = "";
                        }

                        if(isset($value->leader)){
                          if(isset($karyawan[$value->leader])){
                            $leader = $karyawan[$value->leader]['nama'];
                          }else{
                            $leader = $konsumen[$value->leader]['nama_pemilik'];
                          }
                        }else{
                          $leader = "";
                        }

                        if(isset($value->admin_p)){
                          if(isset($users[$value->admin_p])){
                            $admin_p = $users[$value->admin_p]['name'];
                          }else{
                            $admin_p = "";
                          }
                        }else{
                          $admin_p = "";
                        }

                        if(isset($konsumen[$value->id_konsumen])){
                          $id_kons = $konsumen[$value->id_konsumen]['id_konsumen'];
                          $kategoria = $kategori[$konsumen[$value->id_konsumen]['kategori']]['nama_kategori'];
                        }else{
                          $id_kons = $value->id_konsumen;
                          $kategoria = $value->kategori;
                        }

                        if(isset($karyawan[$value->manager])){
                          $mngr = $karyawan[$value->manager]['nama'];
                        }else{
                          $mngr = "";
                        }

                        if(isset($konsumen[$value->id_konsumen]['nama_pemilik'])){
                          if($value->ongkos_kirim < 1){
                            $value->ongkos_kirim = 0;
                          }
                          if($value->cod < 1){
                            $value->cod = 0;
                          }
                        ?>
                        <tr onclick="pilihbarang('{{$value->id}}','{{$value->no_kwitansi}}','{{$value->tanggal_order}}','{{$id_kons}}',
                                                  '{{$konsumen[$value->id_konsumen]['nama_pemilik']}}','{{$konsumen[$value->id_konsumen]['alamat']}}','{{$konsumen[$value->id_konsumen]['no_hp']}}',
                                                  '{{$gudang[$value->id_gudang]['nama_gudang']}}','{{$sales}}',
                                                 '{{$pengembang}}','{{$leader}}','{{$mngr}}','{{$admin_p}}','{{$kategoria}}',{{$value->ongkos_kirim}},{{$value->cod}},'{{$konsumen[$value->id_konsumen]['kategori_konsumen']}}','{{$konsumen[$value->id_konsumen]['limit_piutang']}}','{{$value->id_konsumen}}')">
                            <td>{{$value->no_kwitansi}}</td>
                            <td>{{$konsumen[$value->id_konsumen]['nama_pemilik']}}</td>
                            <td>{{$gudang[$value->id_gudang]['nama_gudang']}}</td>
                            <td>{{$value->tanggal_order}}</td>
                        </tr>
                       <?php } } ?>
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

      <div class="modal fade" id="qc" role="dialog">
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
                              <th hidden>NIK</th>
                              <th>Nama</th>
                              <th>Alamat</th>
                              <th>No. Telepon</th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($qc as $value){ ?>
                          <tr onclick="pilihqc('{{$value->id}}','{{$value->nama}}')">
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

        <div class="modal fade" id="dropper" role="dialog">
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
                                <th>No. Telepon</th>
                            </tr>
                        </thead>
                        <tbody>
                          <?php foreach ($dropper as $value){ ?>
                            <tr onclick="pilihdropper('{{$value->id}}','{{$value->nama}}')">
                                <td hidden>{{$value->nik}}</td>
                                <td>{{$value->nama}}</td>
                                <td><?php echo $value->alamat; ?></td>
                                <td>{{$value->no_hp}}</td
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

          <div class="modal fade" id="pengirim" role="dialog">
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
                                  <th>No. Telepon</th>
                              </tr>
                          </thead>
                          <tbody>
                            <?php foreach ($pengirim as $value){ ?>
                              <tr onclick="pilihpengirim('{{$value->id}}','{{$value->nama}}')">
                                  <td hidden>{{$value->nik}}</td>
                                  <td>{{$value->nama}}</td>
                                  <td><?php echo $value->alamat; ?></td>
                                  <td>{{$value->no_hp}}</td
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

            <div class="modal fade" id="helper" role="dialog">
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
                                    <th>No. Telepon</th>
                                </tr>
                            </thead>
                            <tbody>
                              <?php foreach ($pengirim as $value){ ?>
                                <tr onclick="pilihhelper('{{$value->id}}','{{$value->nama}}')">
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

      <div class="modal fade" id="edit" role="dialog">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="col-md-1"></div>
                  <div class="col-md-3">
                    <label>Nama Barang</label>
                  </div>
                  <div class="col-md-6">
                    <div class="input-group">
                      <input id="nama_barang" readonly type="text" class="form-control">
                      <input id="id_barang" type="hidden" class="form-control">
                      <div class="input-group-append">
                          <button class="btn btn-outline-secondary" onclick="carigantibarang()" type="button"><i class="fas fa-folder-open"></i></button>
                      </div>
                    </div>
                  </div>
                </div>
                
                <div hidden class="row">
                  <div class="col-md-1"></div>
                  <div class="col-md-3">
                    <label>Part Number</label>
                  </div>
                  <div class="col-md-6">
                    <input id="part_number" readonly class="form-control" >
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col-md-1"></div>
                  <div class="col-md-3">
                    <label>Harga Jual</label>
                  </div>
                  <div class="col-md-6">
                    <input id="hjual" style="background:#eee" class="form-control" maxlength="15" data-a-sign="" value="0" data-a-dec="," data-a-pad=false data-a-sep=".">
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col-md-1"></div>
                  <div class="col-md-3">
                    <label>Jumlah Stok</label>
                  </div>
                  <div class="col-md-6">
                    <input type="number" readonly id="stok" class="form-control">
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col-md-1"></div>
                  <div class="col-md-3">
                    <label>Jumlah Order</label>
                  </div>
                  <div class="col-md-6">
                    <input type="number" readonly id="jumlah" class="form-control">
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col-md-1"></div>
                  <div class="col-md-3">
                    <label>Jumlah Proses</label>
                  </div>
                  <div class="col-md-6">
                    <input type="hidden" readonly id="id_detail" class="form-control">
                    <input type="number" id="proses" class="form-control">
                  </div>
                </div>
                <br>
                <center><button onclick="rubah()" id="change" class="btn btn-primary btn-lg">Proses</button></center>

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
                              <th>Nama Sparepart</th>
                              <th>Part Number</th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($barang as $value){ ?>
                          <tr onclick="pilihgantibarang('{{$value->id}}','{{$value->no_sku}}','{{$value->nama_barang}}','{{$value->harga}}','{{$value->part_number}}')">
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script>
    new AutoNumeric('#hjual', "euroPos");
    new AutoNumeric('#ongkos_kirim', "euroPos");
    new AutoNumeric('#limit_tersedia', "euroPos");

    var temp_ongkir = 0;

    var tempid = [];
    var tempid_barang = [];
    var gudang = [];
    var tempstok = [];
    var simpan = false;
    function caripenjualan(){
      $('#transfer').modal('show');
    }

    function cariqc(){
      $('#qc').modal('show');
    }

    function pilihqc(id,nama){
      $('#qc').modal('hide');
      document.getElementById("id_qc").value = id;
      document.getElementById("nama_qc").value = nama;
    }

    function caridropper(){
      $('#dropper').modal('show');
    }

    function pilihdropper(id,nama){
      $('#dropper').modal('hide');
      document.getElementById("id_dropper").value = id;
      document.getElementById("nama_dropper").value = nama;
    }

    function caripengirim(){
      $('#pengirim').modal('show');
    }

    function pilihpengirim(id,nama){
      $('#pengirim').modal('hide');
      document.getElementById("id_pengirim").value = id;
      document.getElementById("nama_pengirim").value = nama;
    }

    function carihelper(){
      $('#helper').modal('show');
    }

    function pilihhelper(id,nama){
      $('#helper').modal('hide');
      document.getElementById("id_helper").value = id;
      document.getElementById("nama_helper").value = nama;
    }

    function carigantibarang(){
      $('#modelbarang').modal('show');
    }

    function ongkir(){
      var ss = document.getElementById("keseluruhan").innerHTML;
      ss = ss.split(".").join("");
      var dd = document.getElementById("ongkos_kirim").value;
      dd = dd.split(".").join("");
      var tmp = Number(ss) + Number(dd) - Number(temp_ongkir);
      document.getElementById("keseluruhan").innerHTML = numberWithCommas(tmp);
      temp_ongkir = dd;
    }

    function pilihgantibarang(id,sku,nama,harga){
      $('#modelbarang').modal('hide');
      document.getElementById("id_barang").value = id;
      document.getElementById("nama_barang").value = nama;

      $.ajax({
         url: 'pilihstokbaru/'+gudang[0]+'/'+id,
         type: 'get',
         dataType: 'json',
         async: false,
         success: function(response){
           document.getElementById("stok").value = response[0]['jumlah'];
           document.getElementById("proses").min = 0;
           var jumlah = document.getElementById("jumlah").value;

           if(response[0]['jumlah'] > jumlah){
             document.getElementById("proses").max = jumlah;
           }else if( response[0]['jumlah'] == 0){
             document.getElementById("proses").max = 0;
             document.getElementById("proses").value = 0;
           }else{
             document.getElementById("proses").max = response[0]['jumlah'];
           }

           if (response[0]['jumlah'] == 0) {
             document.getElementById("change").disabled = true;
           }else{
             document.getElementById("change").disabled = false;
           }
         }
       });

    }
    var hutang_konsumen = 0;
    var limit_tersedia = 0;
    function pilihbarang(id,no_kwitansi,tanggal_order,id_konsumen,nama_pemilik,alamat,no_hp,nama_gudang,sales,pengembang,leader,manager,admin_p,kategori,ongkos_kir,cod,kategori_konsumen,limit_piutang,id_konsu,ket_tmbhn){
      $('#transfer').modal('hide');
      document.getElementById("id").value = id;
      document.getElementById("no_kwitansi").value = no_kwitansi;
      document.getElementById("tanggal_order").value = tanggal_order;
      document.getElementById("id_konsumen").value = id_konsumen;
      document.getElementById("kategori").value = kategori;
      document.getElementById("nama").value = nama_pemilik;
      document.getElementById("alamat").innerHTML = alamat;
      document.getElementById("no_hp").value = no_hp;
      document.getElementById("nama_gudang").value = nama_gudang;
      document.getElementById("ket_tmbhn").value = ket_tmbhn;
      document.getElementById("sales").value = sales;
      document.getElementById("pengembang").value = pengembang;
      document.getElementById("leader").value = leader;
      document.getElementById("manager").value = manager;
      document.getElementById("admin_p").value = admin_p;
      var totongkir = Number(ongkos_kir) + Number(cod);
      AutoNumeric.set('#ongkos_kirim',totongkir);
      hutang_konsumen = 0;
      $.ajax({
                url: 'cekhutang/'+id_konsu,
                type: 'get',
                dataType: 'json',
                async: false,
                success: function(responsec){
                    hutang_konsumen = Number(responsec);
                    limit_tersedia = Number(limit_piutang) - hutang_konsumen;
                    document.getElementById("limit_tersedia").value = limit_tersedia;
                }
              });
      $.ajax({
         url: 'pilihbarangkeluar/'+no_kwitansi,
         type: 'get',
         dataType: 'json',
         async: false,
         success: function(response){
           var myTable = document.getElementById("cart");
           var rowCount = myTable.rows.length;
           for (var x=rowCount-1; x>0; x--) {
            myTable.deleteRow(x);
           }

           tempid = [];
           tempid_barang = [];
           gudang = [];
           tempstok = [];

           //document.getElementById("total_bayar").innerHTML = response['barang'][0]['total_bayar'];

           for (var i = 0; i < response['barang'].length; i++) {
             var table = document.getElementById("cart");
             var lastRow = table.rows.length;
             var row = table.insertRow(lastRow);
             row.id = lastRow;

             var cell1 = row.insertCell(0);
             var cell2 = row.insertCell(1);
             var cell3 = row.insertCell(2);
             var cell4 = row.insertCell(3);
             var cell5 = row.insertCell(4);
             var cell6 = row.insertCell(5);
             var cell7 = row.insertCell(6);
             var cell8 = row.insertCell(7);
             var cell9 = row.insertCell(8);
             var cell10 = row.insertCell(9);
             var cell11 = row.insertCell(10);

             if (response['barang'][i]['proses'] == null) {
               response['barang'][i]['proses'] = 0;
             }
             if (response['barang'][i]['pending'] == null) {
               response['barang'][i]['pending'] = 0;
             }

             tempid[i] = response['barang'][i]['key'];
             tempid_barang[i] = response['barang'][i]['id_barang'];
             gudang[i] = response['barang'][i]['id_gudang'];
             tempstok[i] = response['barang'][i]['stokgudang'];

             cell1.innerHTML = "<p id=sku"+response['barang'][i]['key']+">"+response['barang'][i]['no_sku']+"</p>";
             cell2.innerHTML = "<p id=nama"+response['barang'][i]['key']+">"+response['barang'][i]['nama_barang']+"</p>";
             cell3.innerHTML = "<p id=nama"+response['barang'][i]['key']+">"+response['barang'][i]['part_number']+"</p>";
             cell4.innerHTML = response['barang'][i]['jumlah'];

             $.ajax({
                url: 'updatedikirim/'+0+"/"+response['barang'][i]['jumlah']+"/"+response['barang'][i]['key'],
                type: 'get',
                dataType: 'json',
                async: false,
                success: function(responses){
                }
              });
             
             if(kategori_konsumen == "PKP"){
                 var cx = Math.round(11/111 * Number(response['barang'][i]['harga_jual']));
                 cell8.innerHTML = numberWithCommas(cx);
             }else{
                 var cx = 0;
                 cell8.innerHTML = "";
             }
             
             cell5.innerHTML = "<p id=proses"+response['barang'][i]['key']+">"+"0"+"</p>";
             cell6.innerHTML = "<p id=pending"+response['barang'][i]['key']+">"+"0"+"</p>";
             cell10.innerHTML = "<p id=subtot"+response['barang'][i]['key']+">"+"0"+"</p>";
             console.log(response['barang'][i]['stokgudang']);
             cell7.innerHTML = "<p id=hj"+response['barang'][i]['key']+">"+numberWithCommas(Number(response['barang'][i]['harga_jual'])-Number(cx))+"</p>";
             cell9.innerHTML = "<p id=pot"+response['barang'][i]['key']+">"+numberWithCommas(response['barang'][i]['potongan'])+"</p>";
             var a = '<button class="btn btn-default" onclick="editJumlah(';
             var b = response['barang'][i]['key']+','+response['barang'][i]['proses']+','+response['barang'][i]['pending']+','+response['barang'][i]['jumlah']+','+response['barang'][i]['stokgudang']+')"><i class="icon-pencil"></i></button>';
             cell11.innerHTML = a+"'"+response['barang'][i]['nama_barang']+"'"+","+response['barang'][i]['harga_jual']+","+response['barang'][i]['id_barang']+","+b;

           }

           console.log(tempstok);
         }
       });
    }

    function editJumlah(nama,hargajual,id_barang,key,proses,pending,jumlah,stok){

      $.ajax({
         url: 'editbarangkeluardikirim/'+key+'/'+gudang[0],
         type: 'get',
         dataType: 'json',
         async: false,
         success: function(response){
           var rejectstok = 0;
           $.ajax({
              url: 'getrejectdata/'+response[0]['id_barang']+'/'+gudang[0],
              type: 'get',
              dataType: 'json',
              async: false,
              success: function(respond){
                if (respond.length > 0) {
                  rejectstok = respond[0]['jumlahreject'];
                }else{
                  rejectstok = 0;
                }
              }
            });
           document.getElementById("nama_barang").value = response[0]['nama_barang'];
           document.getElementById("part_number").value = response[0]['part_number'];
           document.getElementById("id_barang").value = response[0]['id_barang']; //
           document.getElementById("id_detail").value = response[0]['key'];
           document.getElementById("proses").value = "0";
           document.getElementById("jumlah").value = response[0]['jumlah'];
           document.getElementById("stok").value = response[0]['stok'] - rejectstok;
           document.getElementById("proses").min = 0;
           //document.getElementById("hjual").value = response[0]['harga_jual'];
           AutoNumeric.set('#hjual',response[0]['harga_jual']);

           if(response[0]['stok'] > response[0]['jumlah']){
             document.getElementById("proses").max = response[0]['jumlah'];
           }else if( response[0]['stok'] == 0){
             document.getElementById("proses").max = 0;
             document.getElementById("proses").value = 0;
           }else{
             document.getElementById("proses").max = response[0]['stok'];
           }

           if (response[0]['stok'] == 0 || simpan) {
             document.getElementById("change").disabled = true;
           }else{
             document.getElementById("change").disabled = false;
           }

          $('#edit').modal('show');

         }
       });

    }

    function CetakSuratJalan(){
      var no_kwitansi = document.getElementById("no_kwitansi").value;
      window.open("{{url('/surat/')}}"+'/'+no_kwitansi);
    }

    function Cetak2(){
      var no_kwitansi = document.getElementById("no_kwitansi").value;
      window.open("{{url('/kwitansi/')}}"+'/'+no_kwitansi);
    }
    
    function Cetak3(){
      var no_kwitansi = document.getElementById("no_kwitansi").value;
      window.open("{{url('/cetaknota/')}}"+'/'+no_kwitansi);
    }

    function CetakLabel(){
      var no_kwitansi = document.getElementById("no_kwitansi").value;
      window.open("{{url('/cetaklabel/')}}"+'/'+no_kwitansi);
    }

    function rubah(){
      var proses = document.getElementById("proses").value;
      var jumlah = document.getElementById("jumlah").value;
      var id_detail = document.getElementById("id_detail").value;
      var harga_jual = document.getElementById("hjual").value;
      harga_jual = harga_jual.split(".").join("");
      var id_barang = document.getElementById("id_barang").value;
      var stok = document.getElementById("stok").value;

      if (Number(proses) <= Number(stok) && Number(proses) <= Number(jumlah)) {
      $.ajax({
         url: 'updatedikirims/'+proses+"/"+jumlah+"/"+id_detail+"/"+harga_jual+"/"+id_barang,
         type: 'get',
         dataType: 'json',
         async: false,
         success: function(response){
           document.getElementById("proses"+response['id']).innerHTML = response['proses'];
           document.getElementById("pending"+response['id']).innerHTML = response['pending'];
           document.getElementById("sku"+response['id']).innerHTML = response['no_sku'];
           document.getElementById("nama"+response['id']).innerHTML = response['nama_barang'];
           document.getElementById("hj"+response['id']).innerHTML = numberWithCommas(response['harga_jual']);
           var pot = document.getElementById("pot"+response['id']).innerHTML;
           //console.log(response['id']);
           pot = pot.split(".").join("");
           var newsub = (Number(response['harga_jual']) - Number(pot)) * Number(response['proses']);
           document.getElementById("subtot"+response['id']).innerHTML = numberWithCommas(newsub);
           //document.getElementById("subtot"+response['id']).innerHTML = Number(response['proses'] * document.getElementById("hj"+response['id']).innerHTML - document.getElementById("pot"+response['id']).innerHTML);

           var newtotal = 0;
           for (var i = 0; i < tempid.length; i++) {
             var oldtotal = document.getElementById("subtot"+tempid[i]).innerHTML;
             oldtotal = oldtotal.split(".").join("");
             newtotal += Number(oldtotal);
           }
           document.getElementById("total_bayar").innerHTML = numberWithCommas(newtotal);
           var ongkir = document.getElementById("ongkos_kirim").value;
           ongkir = ongkir.split(".").join("");
           var all = Number(ongkir) + Number(newtotal);
           document.getElementById("keseluruhan").innerHTML = numberWithCommas(all);
           $('#edit').modal('hide');
         }
       });
     }else{
       alert("Proses melebihi stok !");
     }
    }

    function Simpan(){
      var next = new Boolean("");
      var tempid_data = "";
      var proses_data = "";
      var pending_data = "";
      for (i = 0; i < tempid.length; i++) {
        var cek = Number(document.getElementById("proses"+tempid[i]).innerHTML);
        if (cek > 0) {
          next = true;
        }

        var prs = document.getElementById("proses"+tempid[i]).innerHTML;
        var pnd = document.getElementById("pending"+tempid[i]).innerHTML;

        tempid_data = tempid_data + tempid[i] + ",";
        proses_data = proses_data + prs + ",";
        pending_data = pending_data + pnd + ",";

      }
      var no_kwitansis = document.getElementById("no_kwitansi").value;
      var droppers = document.getElementById("id_dropper").value;
      var qcs = document.getElementById("id_qc").value;
      var pengirims = document.getElementById("id_pengirim").value;
      var helpers = document.getElementById("id_helper").value;
      var tanggal_prosess = document.getElementById("tanggal_proses").value;
      var total_bayars = document.getElementById("total_bayar").innerHTML;
      total_bayars = total_bayars.split(".").join("");
      var ongkos_kirim = document.getElementById("ongkos_kirim").value;
      ongkos_kirim = ongkos_kirim.split(".").join("");

      if(Number(limit_tersedia) >= Number(total_bayars)){


      if (no_kwitansis != "" && tanggal_prosess != "" && next == true && ongkos_kirim != "") {
        document.getElementById("simpan").disabled = true;
        $.post("updatebarangkeluar",
          {tempid_data:tempid_data,proses_data:proses_data,pending_data:pending_data,total_bayar:total_bayars, no_kwitansi:no_kwitansis, dropper:droppers, qc:qcs, pengirim:pengirims, ongkos_kirim:ongkos_kirim, helper:helpers, tanggal_proses:tanggal_prosess, _token:"{{ csrf_token() }}"}).done(function(data, textStatus, jqXHR)
              {
                  Swal.fire({
                      title: 'Berhasil',
                      icon: 'success',
                      confirmButtonColor: '#3085d6',
                      cancelButtonColor: '#d33',
                      confirmButtonText: 'Lanjutkan!'
                    }).then((result) => {
                      document.getElementById("simpan").disabled = true;
                      document.getElementById("surat_jalan").disabled = false;
                      document.getElementById("cetak_kwitansi").disabled = false;
                      document.getElementById("cetak_nota").disabled = false;
                      document.getElementById("cetak_label").disabled = false;
                      simpan = true;
                    });
              }).fail(function(jqXHR, textStatus, errorThrown)
          {
              alert(textStatus);
          });
      }else{
        alert("Isi dahulu semuanya");
      }
      }else{
          alert("Limit Habis");
      }

    }

    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    </script>
@endsection
