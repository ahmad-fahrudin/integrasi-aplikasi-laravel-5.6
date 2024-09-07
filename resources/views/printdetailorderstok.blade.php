@extends('template/master')
@section('main-content')
<style>
table {
    margin: auto;
    width: calc(100% - 40px);
}
</style>

    <div class="container-fluid">
        <div class="card">
        <div class="card-body">
<div style="background-color:white;">
  <div id='printMe'>
      <center><b><h3>Daftar Order Stok</h3></b></center>
    <br>
    <div class="table-responsive">
    <table id="printing" class="table table-striped table-bordered no-wrap" style="width:100%">
      <thead>
      <tr>
        <td><center><b>No Transfer</b></center></td>
        <td><center><b>Tanggal Order</b></center></td>
        <td><center><b>Pengorder</b></center></td>
        <td><center><b>Pemroses</b></center></td>
        <td><center><b>No SKU</b></center></td>
        <td><center><b>Nama Barang</b></center></td>
        <td><center><b>Jumlah Order</b></center></td>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($data as $key => $value): ?>
        <tr>
          <td>{{$value->no_transfer}}</td>
          <td>
                {{date("d-m-Y", strtotime($value->tanggal_order))}}
              </td>
          <td>{{$value->dari}}</td>
          <td>{{$value->kepada}}</td>
          <td>{{$value->no_sku}}</td>
          <td>{{$value->nama_barang}} {{$value->part_number}}</td>
          <td><center>{{$value->jumlah}}</center></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
    </table>
  </div>
  </div>
 
  <!--center><button class="btn btn-success" onclick="printDiv('printMe')">Cetak</button>
          <button class="btn btn-primary" onclick="BackTo()">Back</button></center-->

</div>
</div>
</div>
</div>

<script>
    /*$(document).ready(function() {
       var span = 1;
       var prevTD = "";
       var prevTDVal = "";
       $("#myTable tr td:nth-child(1)").each(function() { //for each first td in every tr
          var $this = $(this);
          if ($this.text() == prevTDVal) { // check value of previous td text
             span++;
             if (prevTD != "") {
                prevTD.attr("rowspan", span); // add attribute to previous td
                $this.remove(); // remove current td
             }
          } else {
             prevTD     = $this; // store current td
             prevTDVal  = $this.text();
             span       = 1;
          }
       });
    });*/
</script>

<script>
      /*window.onload = function(){
        window.print();
      };*/

		function printDiv(divName){
			var printContents = document.getElementById(divName).innerHTML;
			var originalContents = document.body.innerHTML;
			document.body.innerHTML = printContents;
			window.print();
			document.body.innerHTML = originalContents;
		}
    function BackTo(){
      window.top.close();
    }
	</script>
@endsection
