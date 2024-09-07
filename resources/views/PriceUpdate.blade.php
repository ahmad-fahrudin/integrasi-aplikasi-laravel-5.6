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
                              <li class="breadcrumb-item text-muted" aria-current="page">Pemasaran > Pricelist > <a href="https://stokis.app/?s=input+dan+update+harga+serta+menentukan+potongan+harga+untuk+pembelian+partai" target="_blank">Update Harga</a></li>
                          </ol>
                      </nav>
                    </h4>
                    <hr>
                    <br>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="row">
                          <label class="col-lg-12"><strong>Barang</strong></label>
                        </div>
                        <br>
                        <form name="myForm" action="{{url('priceupdate')}}" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
                          {{csrf_field()}}
                        <div class="row">
                          <label class="col-lg-3">No. SKU</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                    <div class="input-group">
                                      <input id="sku" type="text" class="form-control" placeholder="Pilih Barang" readonly style="background:#fff">
                                      <input id="id" name="id" type="hidden" class="form-control">
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
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input readonly id="nama_barang" type="text" class="form-control">
                                      <input id="id_barang" name="id_barang" type="hidden" class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-12"><strong>Edit Harga Terbaru berdasarkan Level Harga</strong></label>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Harga Coret</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input id="harga_coret" name="harga_coret" type="text" class="form-control" placeholder="0" data-a-sign="" value="0" data-a-dec="," data-a-pad=false data-a-sep=".">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Harga Retail</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input id="harga_retail" name="harga_retail" type="text" class="form-control" placeholder="0" data-a-sign="" value="0" data-a-dec="," data-a-pad=false data-a-sep="." required>
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        
                        <div class="row">
                          <label class="col-lg-3">Harga Reseller</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input id="harga_reseller" name="harga_reseller" type="text" class="form-control" placeholder="0" data-a-sign="" value="0" data-a-dec="," data-a-pad=false data-a-sep="." required>
                                  </div>
                              </div>
                          </div>
                        </div>
                        
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Harga Agen</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input id="harga_agen" name="harga_agen" type="text" class="form-control" placeholder="0" data-a-sign="" value="0" data-a-dec="," data-a-pad=false data-a-sep=".">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                
                        <div class="row">
                          <label class="col-lg-3">Harga Net</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input id="harga" name="harga" type="text" class="form-control" placeholder="0" data-a-sign="" value="0" data-a-dec="," data-a-pad=false data-a-sep="." required>
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Harga HPP</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input id="harga_hpp" name="harga_hpp" type="text" class="form-control" placeholder="0" data-a-sign="" value="0" data-a-dec="," data-a-pad=false data-a-sep="." required>
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Harga HP</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input id="harga_hp" name="harga_hp" type="text" class="form-control" placeholder="0" data-a-sign="" value="0" data-a-dec="," data-a-pad=false data-a-sep="." required>
                                      <input id="old_harga_hp" name="old_harga_hp" type="hidden" class="form-control" required>
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Poin Pembelian</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input id="poin" name="poin" type="text" class="form-control" placeholder="0" data-a-sign="" value="0" data-a-dec="," data-a-pad=false data-a-sep=".">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Bonus Sales</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input id="fee_item" name="fee_item" type="text" class="form-control" placeholder="0" data-a-sign="" value="0" data-a-dec="," data-a-pad=false data-a-sep=".">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <br>
                        <div class="row">
                          <label class="col-lg-12"><strong>Edit Potongan Harga Berdasarkan Level Quantity Pembelian</strong></label>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Label</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <select id="label" name="label" class="form-control">
                                        <option selected value="0">--Pilih Status Label--</option>
                                        <?php foreach ($label as $key => $value): ?>
                                          <option value="{{$value->id}}">{{strtoupper($value->nama)}}</option>
                                        <?php endforeach; ?>
                                      </select>
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Potongan Quantity (1)</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-6">
                                      <input id="qty1" name="qty1" type="number" class="form-control" placeholder="Qty Pengambilan">
                                  </div>
                                  <div class="col-md-6">
                                      <input id="pot1" name="pot1" type="text" class="form-control" placeholder="Pot. harga per Pcs" data-a-sign="" data-a-dec="," data-a-pad=false data-a-sep=".">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Potongan Quantity (2)</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-6">
                                      <input id="qty2" name="qty2" type="number" class="form-control" placeholder="Qty Pengambilan">
                                  </div>
                                  <div class="col-md-6">
                                      <input id="pot2" name="pot2" type="text" class="form-control" placeholder="Pot. harga per Pcs" data-a-sign="" data-a-dec="," data-a-pad=false data-a-sep=".">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Potongan Quantity (3)</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-6">
                                      <input id="qty3" name="qty3" type="number" class="form-control" placeholder="Qty Pengambilan">
                                  </div>
                                  <div class="col-md-6">
                                      <input id="pot3" name="pot3" type="text" class="form-control" placeholder="Pot. harga per Pcs" data-a-sign="" data-a-dec="," data-a-pad=false data-a-sep=".">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-lg-3">Tanggal Update</label>
                          <div class="col-lg-9">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input name="tanggal" type="date" readonly value="{{date('Y-m-d')}}" class="form-control">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <br>
                        <center>
                          <button class="btn btn-success btn-lg">Simpan</button>
                        </center>
                      </form>
                      </div>
                    </div>

              </div>
            </div>
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
                          <th>No SKU</th>
                          <th>Nama Barang</th>
                          <th>Item No.</th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($price as $value){ ?>
                      <tr onclick="pilihbarang('{{$value->id}}','{{$value->no_sku}}','{{$value->nama_barang}}','{{$value->harga_coret}}','{{$value->harga}}','{{$value->harga_hpp}}','{{$value->harga_hp}}','{{$value->harga_retail}}','{{$value->harga_reseller}}','{{$value->harga_agen}}','{{$value->label}}','{{$value->tanggal}}'
                                                ,'{{$value->qty1}}','{{$value->pot1}}','{{$value->qty2}}','{{$value->pot2}}','{{$value->qty3}}','{{$value->pot3}}','{{$value->id_barang}}','{{$value->poin}}','{{$value->fee_item}}','{{$value->part_number}}')">
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
      new AutoNumeric('#harga_coret', "euroPos");
      new AutoNumeric('#harga_retail', "euroPos");
      new AutoNumeric('#harga_reseller', "euroPos");
      new AutoNumeric('#harga_agen', "euroPos");
      new  AutoNumeric('#harga', "euroPos");
      new  AutoNumeric('#harga_hpp', "euroPos");
      new  AutoNumeric('#harga_hp', "euroPos");
      new  AutoNumeric('#poin', "euroPos");
      new  AutoNumeric('#fee_item', "euroPos");
      new  AutoNumeric('#pot1', "euroPos");
      new  AutoNumeric('#pot2', "euroPos");
      new  AutoNumeric('#pot3', "euroPos");
      function caribarang(){
        $('#barang').modal('show');
      }
      function validateForm() {
        let x = document.forms["myForm"]["label"].value;
        let qty1 = document.forms["myForm"]["qty1"].value;
        let pot1 = document.forms["myForm"]["pot1"].value;
        let qty2 = document.forms["myForm"]["qty2"].value;
        let pot2 = document.forms["myForm"]["pot2"].value;
        let qty3 = document.forms["myForm"]["qty3"].value;
        let pot3 = document.forms["myForm"]["pot3"].value;
        if (x == 1) {
          if ( (qty1 != "" && pot1 != "") || (qty2 != "" && pot2 != "") || (qty3 != "" && pot3 != "") ) {
            return true;
          }else{
            Swal.fire({
                title: 'Label ada promo diwajibkan untuk mengisi Potongan Quantity! ganti label ada promo ke discontinue atau pilih jika tidak ada potongan quantity',
                icon: 'info',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Lanjutkan!'
              });
            return false;
          }
        }else{
          return true;
        }

      }
      function pilihbarang(barang,id,nama,coret,harga,hpp,hp,retail,reseller,agen,label,tanggal,qty1,pot1,qty2,pot2,qty3,pot3,id_barang,poin,fee_item,part_number){
        $('#barang').modal('hide');
        document.getElementById("sku").value = id;
        document.getElementById("nama_barang").value = nama;
        document.getElementById("id").value = barang;
        //document.getElementById("harga").value = harga;
        //document.getElementById("harga_hpp").value = hpp;
        //document.getElementById("harga_hp").value = hp;
        AutoNumeric.getAutoNumericElement('#harga_coret').set(coret);
        AutoNumeric.getAutoNumericElement('#harga').set(harga);
        AutoNumeric.getAutoNumericElement('#harga_hpp').set(hpp);
        AutoNumeric.getAutoNumericElement('#harga_hp').set(hp);
        document.getElementById("old_harga_hp").value = hp;
        AutoNumeric.getAutoNumericElement('#poin').set(poin);
        AutoNumeric.getAutoNumericElement('#fee_item').set(fee_item);
        AutoNumeric.getAutoNumericElement('#harga_retail').set(retail);
        AutoNumeric.getAutoNumericElement('#harga_reseller').set(reseller);
        AutoNumeric.getAutoNumericElement('#harga_agen').set(agen);
        //document.getElementById("harga_retail").value = retail;
        if (label != "0" && label != "") {
          document.getElementById("label").value = label;
        }else{
          document.getElementById("label").value = "0";
        }
        document.getElementById("qty1").value = qty1;
        AutoNumeric.getAutoNumericElement('#pot1').set(pot1);
        //ocument.getElementById("pot1").value = pot1;
        document.getElementById("qty2").value = qty2;
        AutoNumeric.getAutoNumericElement('#pot2').set(pot2);
        //document.getElementById("pot2").value = pot2;
        document.getElementById("qty3").value = qty3;
        AutoNumeric.getAutoNumericElement('#pot3').set(pot3);
        //document.getElementById("pot3").value = pot3;
        document.getElementById("id_barang").value = id_barang;
        document.getElementById("part_number").value = part_number;
      }
      </script>
@endsection
