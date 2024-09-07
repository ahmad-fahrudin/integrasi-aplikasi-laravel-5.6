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
                              <li class="breadcrumb-item text-muted" aria-current="page">Pemasaran > Pricelist > <a href="https://stokis.app/?s=daftar+harga+pricelist" target="_blank">Daftar Harga</a></li>
                          </ol>
                      </nav>
                    </h4>
                    <hr>
                    <div style="border:2px dashed #eee;border-radius:20px; padding:20px; backgroud:#f5f5f5">
                    <p><strong>Filter Berdasarkan</strong></p>
                      <div class="form-group">
                         <form name="form1" action="{{url('pricelist')}}" method="post" enctype="multipart/form-data">
                           {{csrf_field()}}
                         <div class="row">
                             <label class="col-lg-2">Kisaran Harga</label>
                             <div class="col-lg-2">
                                 <div class="row">
                                     <div class="col-md-12">
                                         <input type="number" onchange="changeharga()"
                                         <?php if (isset($harga_from)): ?>
                                           value="{{$harga_from}}"
                                         <?php endif; ?>
                                         name="harga_from" class="form-control" placeholder="Harga minimal...">
                                     </div>
                                 </div>
                             </div>

                             <label class="col-lg-0.5">&emsp;s/d</label>

                             <div class="col-lg-2">
                                 <div class="row">
                                     <div class="col-md-12">
                                         <input type="number" onchange="changeharga()"
                                         <?php if (isset($harga_to)): ?>
                                           value="{{$harga_to}}"
                                         <?php endif; ?>
                                         name="harga_to" class="form-control" placeholder="Harga maksimal...">
                                     </div>
                                 </div>
                             </div>
                             <label class="col-lg-1"></label>
                             <label class="col-lg-2 text-left">PKP</label>
                             <div class="col-lg-2">
                                 <div class="row">
                                     <div class="col-md-12">
                                     <input class="form" type="checkbox"
                                     <?php if (isset($branded)): ?>
                                       checked
                                     <?php endif; ?>
                                     onclick="changebrand()" name="branded" value="1">
                                     </div>
                                 </div>
                             </div>
                         </div>
                         <br>
                         <div class="row">
                             <label class="col-lg-2">Tanggal Update</label>
                             <div class="col-lg-2">
                                 <div class="row">
                                     <div class="col-md-12">
                                         <input type="date" onchange="chagedate()"
                                         <?php if (isset($datefrom)): ?>
                                           value="{{$datefrom}}"
                                         <?php endif; ?>
                                         name="tanggal_from" class="form-control">
                                     </div>
                                 </div>
                             </div>
                             <label class="col-lg-0.5">&emsp;s/d</label>
                             <div class="col-lg-2">
                                 <div class="row">
                                     <div class="col-md-12">
                                         <input type="date" onchange="chagedate()"
                                         <?php if (isset($dateto)): ?>
                                           value="{{$dateto}}"
                                         <?php endif; ?>
                                         name="tanggal_to" class="form-control">
                                     </div>
                                 </div>
                             </div>
                         </div>
                           <br>
                           <center><button id="btn" disabled class="btn btn-lg btn-success btn-lg">Filter Data</button></center>
                        </form>
                      </div>
                      </div>
                    <hr><br>
									<div class="table-responsive">
                  <table id="prc" class="table table-striped table-bordered no-wrap" style="width:100%">
                      <thead>
                          <tr>
                              <th>No. SKU</th>
                              <th>Nama Barang</th>
                              <th>Item No.</th>
                              <th>Harga Coret</th>
                              <th>Harga Retail</th>
                              <th>Harga Reseller</th>
                              <th>Harga Agen</th>
                              <th>Harga Net</th>
                              <?php if (Auth::user()->level == "1"|| Auth::user()->level == "2"|| Auth::user()->level == "3"|| Auth::user()->level == "4"): ?>
                              <th>Harga HPP</th>
                              <?php endif; ?>
                              <?php if (Auth::user()->level == "1"|| Auth::user()->level == "4"): ?>
                              <th>Harga HP</th>
                              <?php endif; ?>
                              
                              <th>QTY 1</th>
                              <th>Potongan 1</th>
                              <th>QTY 2</th>
                              <th>Potongan 2</th>
                              <th>QTY 3</th>
                              <th>Potongan 3</th>
                              <th>Poin Pembelian</th>
                              <th>Bonus Sales</th>
                              <th>Tanggal Update</th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($price as $value) { ?>
                          <tr>
                              <td>{{$value->no_sku}}</td>
                              <td>{{$value->nama_barang}}</td>
                              <td>{{$value->part_number}}</td>
                              <td align="right">{{rupiah($value->harga_coret)}}</td>
                              <td align="right">{{rupiah($value->harga_retail)}}</td>
                              <td align="right">{{rupiah($value->harga_reseller)}}</td>
                              <td align="right">{{rupiah($value->harga_agen)}}</td>
                              <td align="right">{{rupiah($value->harga)}}</td>
                              <?php if (Auth::user()->level == "1"|| Auth::user()->level == "2"|| Auth::user()->level == "3"|| Auth::user()->level == "4"): ?>
                              <td align="right">{{rupiah($value->harga_hpp)}}</td>
                              <?php endif; ?>
                              <?php if (Auth::user()->level == "1"|| Auth::user()->level == "4"): ?>
                              <td align="right">{{rupiah($value->harga_hp)}}</td>
                              <?php endif; ?>
                              <td align="center">
                               <?php if ($value->qty1 > 0){ ?> 
                                  {{$value->qty1}}
                                  <?}else{?>
                                  -
                                <?php } ?> 
                                </td>
                              <td align="right">
                                   <?php if ($value->pot1 > 0){ ?> 
                                  {{ribuan($value->pot1)}}
                                  <?}else{?>
                                  -
                                <?php } ?> 
                                  </td>
                              <td align="center">
                               <?php if ($value->qty2 > 0){ ?> 
                                  {{$value->qty2}}
                                  <?}else{?>
                                  -
                                <?php } ?> 
                                </td>
                              <td align="right">
                                   <?php if ($value->pot2 > 0){ ?> 
                                  {{ribuan($value->pot2)}}
                                  <?}else{?>
                                  -
                                <?php } ?> 
                                  </td>
                              <td align="center">
                               <?php if ($value->qty3 > 0){ ?> 
                                  {{$value->qty3}}
                                  <?}else{?>
                                  -
                                <?php } ?> 
                                </td>
                              <td align="right">
                                   <?php if ($value->pot3 > 0){ ?> 
                                  {{ribuan($value->pot3)}}
                                  <?}else{?>
                                  -
                                <?php } ?> 
                                  </td>
                              <td align="center">
                               <?php if ($value->poin > 0){ ?> 
                                  {{$value->poin}}
                                  <?}else{?>
                                  0
                                <?php } ?> 
                                </td>
                                <td align="right">
                               <?php if ($value->fee_item > 0){ ?> 
                                  {{ribuan($value->fee_item)}}
                                  <?}else{?>
                                  0
                                <?php } ?> 
                                </td>
                              <td>{{tanggal($value->tanggal)}}</td>
                          </tr>
                         <?php } ?>
                      </tbody>
                  </table>
								</div>
                <br>
                <br>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
<script>
  function filter(){
    document.getElementById("btn").disabled = false;
  }
  function changeharga(){
    var empt = document.forms["form1"]["harga_from"].value;
    var empt2 = document.forms["form1"]["harga_to"].value;
    if (empt != "" && empt2 != "")
      {
        document.getElementById("btn").disabled = false;
      }
  }
  function changebrand(){
    document.getElementById("btn").disabled = false;
  }
  function chagedate(){
    var empt = document.forms["form1"]["tanggal_from"].value;
    var empt2 = document.forms["form1"]["tanggal_to"].value;
    if (empt != "" && empt2 != "")
      {
        document.getElementById("btn").disabled = false;
      }
  }
</script>
@endsection
