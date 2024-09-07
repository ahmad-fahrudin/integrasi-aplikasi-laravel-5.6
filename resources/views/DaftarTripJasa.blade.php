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
                              <li class="breadcrumb-item text-muted" aria-current="page">Laporan Harian / Trip > <a href="https://stokis.app/?s=daftar+trip+jasa" target="_blank">Daftar Lap. Jasa</a></li>
                          </ol>
                      </nav>
                    </h4>
                     <hr>
                    <div style="border:2px dashed #eee;border-radius:20px; padding:20px; backgroud:#f5f5f5">
                        <p><strong>Cari No. Trip Jasa berdasarkan</strong></p>
                        <div class="col-md-4">
                         <form name="form1" action="{{url('caritrip')}}" method="post" enctype="multipart/form-data">
                           {{csrf_field()}}
                         <div class="row">
                             <label class="col-lg-3">No. Kwitansi Jasa</label>
                             <div class="col-lg-9">
                                 <div class="row">
                                     <div class="col-md-11">
                                         <div class="input-group">
                                         <input type="text" name="no_kwitansi" class="form-control" required placeholder="Ketik No. Kwitansi Jasa...">
                                         <div class="input-group-append">
                                            <button class="btn btn-success"><i class="fas fa-search"></i></button>
                                        </div>
                                        </div>
                                     </div>

                                 </div>
                              </div>
                         </div>
                         </div>
                         </form>
                      </div>
                    <hr>
                    <div style="border:2px dashed #eee;border-radius:20px; padding:20px; backgroud:#f5f5f5">
                    <p><strong>Filter Berdasarkan</strong></p>
                    <div class="row">
                    <div class="form-group col-md-6">
                       <form name="form1" action="{{url('daftartrip')}}" method="post" enctype="multipart/form-data">
                         {{csrf_field()}}
                       <div class="row">
                           <label class="col-lg-2">Range Tanggal</label>
                           <div class="col-lg-4">
                               <div class="row">
                                   <div class="col-md-12">
                                       <input onchange="change()" name="date_from" type="date" class="form-control"
                                       <?php if (isset($date_from)): ?>
                                         value="{{$date_from}}"
                                       <?php endif; ?>
                                       >
                                   </div>
                                </div>
                            </div>
                           <label class="col-lg-0.5">&emsp;s/d&emsp;</label>
                           <div class="col-lg-4">
                               <div class="row">
                                   <div class="col-md-12">
                                       <input onchange="change()" name="date_to" type="date" class="form-control"
                                       <?php if (isset($date_to)): ?>
                                         value="{{$date_to}}"
                                       <?php endif; ?>>
                                   </div>
                               </div>
                           </div>
                       </div>
                       <br>
                       <div class="row">
                           <label class="col-lg-2">Cabang</label>
                           <div class="col-lg-4">
                               <div class="row">
                                   <div class="col-md-12">
                                       <select class="form-control" onchange="change2()" id="id_gudang" name="id_gudang">
                                         <?php if (Auth::user()->level == "1" || Auth::user()->gudang == "1" || Auth::user()->gudang == "2"){
                                           foreach ($gudang as $key => $value): if ($value['status'] == "aktif") { ?>
                                              <option value="{{$value['id']}}"
                                                <?php if (isset($id_gudang) && $id_gudang == $value['id']): ?>
                                                  selected
                                                <?php endif; ?>>
                                              {{$value['nama_gudang']}}</option>
                                           <?php } endforeach;
                                         }else{
                                           foreach ($gudang as $key => $value): if ($value['id'] == Auth::user()->gudang) { ?>
                                              <option value="{{$value['id']}}"
                                                <?php if (isset($id_gudang) && $id_gudang == $value['id']): ?>
                                                  selected
                                                <?php endif; ?>>
                                              {{$value['nama_gudang']}}</option>
                                           <?php } endforeach;
                                         } ?>
                                       </select>
                                   </div>
                               </div>
                            </div>
                       </div>
                       <br>
                       <div class="form-group">
                          <div class="col-lg-12">
                              <center><button disabled id="filter" class="btn btn-success btn-lg">Filter Data</button></center>
                          </div>
                       </div>
                       </form>
                       </div>
                      </div>

                    </div>

                      <hr><br>
									<div class="table-responsive">
                  <table id="example1" class="table table-striped table-bordered no-wrap" style="width:100%">
                      <thead>
                          <tr>
                              <th>Tanggal</th>
                              <th>No. Trip Jasa</th>
                              <th>Kasir</th>
                              <th>Admin</th>
                              <th>Cabang</th>
                              <th>Nilai Layanan Jasa</th>
                              <th>Status Insentif</th>
                              <th>Tindakan</th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php
                        if (count($daftar) < 1) {
                          echo '<tr><td colspan="9"><center>Data Belum Ada</center></td></tr>';
                        }else{
                        foreach ($daftar as $key => $value):
                        if($value->penjualan > 0){ ?>
                          <tr <?php if($value->available == "calculated"){  }else{ echo "style='background:#fabcbc'"; } ?>>
                            <td>{{$value->tanggal_input}}</td>
                            <td>{{$value->no_trip}}</td>
                            <td>{{$karyawan[$value->kasir]}}</td>
                            <td>{{$admin[$value->admin]}}</td>
                            <td>{{$gudang[$value->id_gudang]['nama_gudang']}}</td>
                            <td align="right">{{ribuan($value->penjualan)}}</td>
                            <td><?php if($value->available == "calculated"){ echo "Masuk Saldo"; }else{ echo "Belum Masuk"; } ?></td>
                            <td>
                                <?php if (Auth::user()->id == 1): ?>
                                    <button hidden class="btn btn-success" onclick="Edit('{{$value->no_trip}}','{{$karyawan[$value->kasir]}}','{{$gudang[$value->id_gudang]['nama_gudang']}}')">Edit</button>
                                <?php endif; ?>
                                <button class="btn btn-primary" onclick="Rincian('{{$value->no_trip}}','{{$value->available}}')">Lihat Rincian</button>
                                <a class="btn btn-success" href="{{url('tripsurat/'.$value->no_trip)}}" target="_blank">Surat Jalan Keuangan</a>
                            </td>
                          </tr>
                        <?php } endforeach; }?>
                      </tbody>
                  </table>
								</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="detail" role="dialog">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">

              <div class="table-responsive">
              <table id="examples" class="table table-striped table-bordered no-wrap" style="width:100%">
                  <thead>
                    <tr>
                        <th>No. Transfer</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Sub Total</th>
                        <?php if (Auth::user()->level == "1" || Auth::user()->level == "4"): ?>
                        <th>Tindakan</th>
                        <?php endif; ?>
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


    <div class="modal fade" id="edit" role="dialog">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
              <form action="{{url('/edit_kategori_penjualan')}}" method="post">
              {{csrf_field()}}
              No. Trip:
              <input type="text" readonly id="no_trip" name="no_trip" class="form-control">
              Driver:
              <input type="text" readonly id="kasir" class="form-control">

              Cabang:
              <input type="text" readonly id="gudang" class="form-control">

              <br>
              <center><input type="submit" value="&emsp;Simpan&emsp;" class="btn btn-success"></center>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script>
function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function change(){
  var empt = document.forms["form1"]["date_from"].value;
  var empt2 = document.forms["form1"]["date_to"].value;
  if (empt != "" && empt2 != "")
    {
      document.getElementById("filter").disabled = false;
    }
}

function change2(){
  document.getElementById("filter").disabled = false;
}

var ids = "";

function Edit(no_trip,kasir,gudang){
  document.getElementById("no_trip").value = no_trip;
  document.getElementById("kasir").value = kasir;
  document.getElementById("gudang").value = gudang;
  $('#edit').modal('show');
}

function Rincian(value,status)
{
  var myTable = document.getElementById("examples");
  var rowCount = myTable.rows.length;
  for (var x=rowCount-1; x>0; x--) {
   myTable.deleteRow(x);
  }

    $.ajax({
       url: 'detailTrip/'+value,
       type: 'get',
       dataType: 'json',
       async: false,
       success: function(response){
         ids = "";
         for (var i = 0; i < response.length; i++) {
           var table = document.getElementById("examples");
           var lastRow = table.rows.length;
           var row = table.insertRow(lastRow);
           row.id = lastRow;

           var cell1 = row.insertCell(0);
           var cell2 = row.insertCell(1);
           var cell3 = row.insertCell(2);
           var cell4 = row.insertCell(3);
           <?php if (Auth::user()->level == "1" || Auth::user()->level == "4"): ?>
           //var cell5 = row.insertCell(4);
           <?php endif; ?>

           ids += +",";

           cell1.innerHTML = response[i]['no_kwitansi'];
           cell2.innerHTML = response[i]['nama_pemilik'];
           cell3.innerHTML = response[i]['alamat'];
           cell4.innerHTML = numberWithCommas(response[i]['sub_total']);
           if (status != "calculated") {
             //var x = document.createElement("INPUT");
             //x.setAttribute("type", "checkbox");
             //x.setAttribute("class", "form-control");
             //x.setAttribute("value", true);
             //x.setAttribute("name", "check"+response[i]['id_detail_trip']);
             //cell5.appendChild(x);
             //document.getElementById("pending").disabled = false;
             <?php if (Auth::user()->level == "1" || Auth::user()->level == "4"): ?>
             //var a = "'"+response[i]['no_kwitansi']+"'";
             //cell5.innerHTML = '<button class="btn btn-danger" onclick="ProsesPending('+response[i]['id_detail_trip']+','+a+')">Pending</button>';
             <?php endif; ?>
           }
         }
         $('#detail').modal('show');
       }
     });
}


function ProsesPending(id,kwitansi){
  Swal.fire(
    'Pindahkan Kuitansi '+kwitansi+' Ke Daftar Pending?',
    'Apakah Anda Yakin?',
    'question'
  ).then((result) => {
    if (result.value) {
      $.ajax({
         url: 'pendingkwitansi/'+id,
         type: 'get',
         dataType: 'json',
         async: false,
         success: function(response){
           location.href="{{url('/daftartrip/')}}";
         }
       });
    }
  });
}

</script>
@endsection
