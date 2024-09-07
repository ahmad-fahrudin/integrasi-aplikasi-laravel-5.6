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
      <center><b><h3>Daftar Order Masuk</h3></b></center>
    <br>
      <div class="table-responsive">
    <table id="printing" class="table table-striped table-bordered no-wrap" style="width:100%">
      <thead>
      <tr>
        <td><b>No Kwitansi</b></td>
        <td><b>Tanggal Order</b></td>
        <td><b>Nama Member</b></td>
        <td><b>Alamat</b></td>
        <td><b>Kota/Kabupaten</b></td>
        <td><b>Gudang</b></td>
        <td><b>No. SKU</b></td>
        <td><b>Nama Barang</b></td>
        <td><b>Part Number</b></td>
        <td><b>Jumlah Order</b></td>
      </tr>
    </thead>
    <tbody>
      <?php $no=1; $jumlah = 0; $cek=""; foreach ($barang as $value):
        if (isset($kota)) {
          if (strtoupper(str_replace(" ","",$konsumen[$value->id_konsumen]['kota'])) == strtoupper(str_replace(" ","",$kota))) { ?>
            <tr>
              <td>
                {{$value->no_kwitansi}}
              </td>
              <td>
                {{date("d-m-Y", strtotime($value->tanggal_order))}}
              </td>
              <td>
                {{$konsumen[$value->id_konsumen]['nama']}}
              </td>
              <td>
                <?php echo $konsumen[$value->id_konsumen]['alamat']; ?>
              </td>
              <td>
                  <?php if(isset($data_kabupaten[$konsumen[$value->id_konsumen]['kota']])){ echo $data_kabupaten[$konsumen[$value->id_konsumen]['kota']]; }else{ ?>
                    {{$konsumen[$value->id_konsumen]['kota']}}
                 <?php } ?>
              </td>
              <td>
                {{$gudang[$value->id_gudang]}}
              </td>
              <td>{{$nmbarang[$value->id_barang]['no_sku']}}</td>
              <td>{{$nmbarang[$value->id_barang]['nama_barang']}}</td>
              <td>{{$nmbarang[$value->id_barang]['part_number']}}</td>
              <td align="center">{{$value->jumlah}}</td>
            </tr>
          <?php } }else{ ?>
        <tr>
          <td>
            {{$value->no_kwitansi}}
          </td>
          <td>
            {{date("d-m-Y", strtotime($value->tanggal_order))}}
          </td>
          <td>
            {{$konsumen[$value->id_konsumen]['nama']}}
          </td>
          <td>
            <?php echo $konsumen[$value->id_konsumen]['alamat']; ?>
          </td>
          <td>
            <?php if(isset($data_kabupaten[$konsumen[$value->id_konsumen]['kota']])){ echo $data_kabupaten[$konsumen[$value->id_konsumen]['kota']]; }else{ ?>
                    {{$konsumen[$value->id_konsumen]['kota']}}
                 <?php } ?>
          </td>
          <td>
            {{$gudang[$value->id_gudang]}}
          </td>
          <td>{{$nmbarang[$value->id_barang]['no_sku']}}</td>
          <td>{{$nmbarang[$value->id_barang]['nama_barang']}}</td>
          <td>{{$nmbarang[$value->id_barang]['part_number']}}</td>
          <td align="center">{{$value->jumlah}}</td>
        </tr>
      <?php $cek = $value->no_kwitansi;
     } endforeach; ?>
    </tbody>
    </table>
    </div>
  </div>

</div>
</div>
</div>
</div>

<script>
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
