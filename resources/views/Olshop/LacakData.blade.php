@extends('template/nav')
@section('content')
<style>
.dot {
  height: 15px;
  width: 15px;
  background-color: #cecece;
  border-radius: 50%;
  display: inline-block;
}
.dotact {
  height: 20px;
  width: 20px;
  background-color: #00d027;
  border-radius: 50%;
  display: inline-block;
}
</style>
<style>

.circle {
  border-radius: 50%;
  background-color: #00d027;
  width: 20px;
  height: 20px;
  position: absolute;
  opacity: 0;
  animation: scaleIn 3s infinite cubic-bezier(.36, .11, .89, .32);
}

@keyframes scaleIn {
  from {
    transform: scale(.5, .5);
    opacity: .5;
  }
  to {
    transform: scale(2.5, 2.5);
    opacity: 0;
  }
}
</style>
<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">
                  <nav aria-label="breadcrumb">
                      <ol class="breadcrumb ">
                          <li class="breadcrumb-item text-muted" aria-current="page">Gudang > Orderan Web Store > <a href="https://stokis.app/?s=lacak+pengiriman+web+store+by+nomor+resi" target="_blank">Lacak Pengiriman</a></li>
                      </ol>
                  </nav>
                </h4>
            <hr>
  <div class="row">
    <div class="col-md-6">
      <div class="card" style="padding:30px;">
        <center><h2>Detail Pengiriman</h2></center><br>
        <?php if(isset($pelacakan->rajaongkir->result) && $pelacakan->rajaongkir->result !== null){ ?>
        <table class="table table-striped ">
          <?php $i=1; $len=count($pelacakan->rajaongkir->result->manifest); foreach (array_reverse($pelacakan->rajaongkir->result->manifest) as $key => $value): ?>
            <tr>
              <td width="25%">{{date("d-M-Y", strtotime($value->manifest_date))}}, {{$value->manifest_time}}</td>
              <?php if ($i == $len){ ?>
                <td>
                  <div class="circle" style="animation-delay: 0s"></div>
                  <div class="circle" style="animation-delay: 1s"></div>
                  <div class="circle" style="animation-delay: 2s"></div>
                </td>
              <?php }else{ ?>
                <td><span class="dot"></span></td>
              <?php } ?>
              <td>{{$value->manifest_description}}<br>{{$value->city_name}}
              </td>
            </tr>
            <?php $i++; endforeach; ?>
          </table>
        <?php }else{ ?>
          No Resi Tidak Ditemukan
        <?php } ?>
        </div>
      </div>
      <?php if(isset($pelacakan->rajaongkir->result) && $pelacakan->rajaongkir->result !== null){ ?>
      <div class="col-md-6">
        <div class="card" style="padding:30px;">
          <center><h2>Info Pengiriman</h2></center><br>
          <table class="table table-striped ">
            <?php if($pelacakan->rajaongkir->result->delivery_status->status == "DELIVERED"){ ?>
              <tr>
                <td>Status</td>
                <td>Sudah Diterima</td>
              </tr>
              <tr>
                <td>Penerima</td>
                <td>{{$pelacakan->rajaongkir->result->delivery_status->pod_receiver}}</td>
              </tr>
              <tr>
                <td>Tanggal</td>
                <td>{{$pelacakan->rajaongkir->result->delivery_status->pod_date}}, {{$pelacakan->rajaongkir->result->delivery_status->pod_time}}</td>
              </tr>
            <?php } ?>
            <?php if($pelacakan->rajaongkir->result->delivery_status->status == "DELIVERED"){ ?>
              <tr>
                <td>Kurir</td>
                <td>{{$pelacakan->rajaongkir->result->summary->courier_name}}</td>
              </tr>
              <tr>
                <td>Nomer Resi</td>
                <td>{{$pelacakan->rajaongkir->result->summary->waybill_number}}</td>
              </tr>
              <tr>
                <td>Tanggal Pengiriman</td>
                <td>{{$pelacakan->rajaongkir->result->summary->waybill_date}}</td>
              </tr>
              <tr>
                <td>Pengirim</td>
                <td>{{$pelacakan->rajaongkir->result->summary->shipper_name}}, {{$pelacakan->rajaongkir->result->summary->origin}}</td>
              </tr>
              <tr>
                <td>Penerima</td>
                <td>{{$pelacakan->rajaongkir->result->summary->receiver_name}}, {{$pelacakan->rajaongkir->result->summary->destination}}</td>
              </tr>
            <?php } ?>
            </table>
          </div>
        </div>
        <?php } ?>
    </div>
    <hr>
    <a href="{{url('daftarpengiriman')}}" class="btn btn-success">Kembali</a>
  </div>
</div>
</div>
</div>
</div>
</div>
@endsection
