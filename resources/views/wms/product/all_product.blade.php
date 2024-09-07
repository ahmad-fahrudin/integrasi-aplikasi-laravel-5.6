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
                                        <li class="breadcrumb-item text-muted" aria-current="page">Where House Manage >
                                            Master >
                                            <a href="#" target="_blank">Product</a>
                                        </li>
                                    </ol>
                                </nav>
                            </h4>
                            <hr>
                            <div class="table-responsive">
                                <table id="dr" class="table table-striped table-bordered no-wrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Type</th>
                                            <th>Managed</th>
                                            <th>Code</th>
                                            <th>Name</th>
                                            <th>Barcode</th>
                                            <th>Stock</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($listProducts as $product)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $product['product_type'] }}</td>
                                                <td>{{ $product['product_managed'] }}</td>
                                                <td>{{ $product['product_code'] }}</td>
                                                <td>{{ $product['product_name'] }}</td>
                                                <td>{{ $product['product_code'] }}</td>
                                                <td><button class="btn btn-primary"
                                                        onclick="openLocationModal('{{ $product['product_code'] }}')"
                                                        type="button">Cek Stock</button>
                                                </td>
                                                <td>
                                                    <a href="{{ route('product.detail', $product['product_code']) }}"
                                                        class="btn btn-primary">Details</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="location" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table id="examples" class="table table-striped table-bordered no-wrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Alamat</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($listLocations as $location)
                                    <tr onclick="pilihLocation('{{ $location['location_code'] }}')">
                                        <td>{{ $location['location_name'] }}</td>
                                        <td>{{ $location['address'] }}</td>
                                        <input type="hidden" id="selectedProductCode">
                                    </tr>
                                @endforeach
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
        function openLocationModal(productCode) {
            $('#location').modal('show');
            // Simpan product_code di dalam input tersembunyi untuk digunakan nanti
            $('#selectedProductCode').val(productCode);
        }

        function pilihLocation(locationCode) {
            let productCode = $('#selectedProductCode').val(); // Ambil product_code yang disimpan

            // Kirim AJAX request ke route untuk mengambil stok
            $.ajax({
                url: "{{ route('product.stock') }}", // Ubah dengan route yang sesuai
                method: "POST",
                data: {
                    product_code: productCode,
                    location_code: locationCode,
                    _token: '{{ csrf_token() }}' // Jangan lupa CSRF token
                },
                success: function(response) {
                    // Tampilkan data yang diambil dari response
                    Swal.fire({
                        title: 'Stok Produk',
                        html: `
                            <div class="text-left">
                                <p><strong>Lokasi: </strong>${response.location_name}</p>
                                <p><strong>Produk: </strong>${response.product_name}</p>
                                <p><strong>Stok Tersedia: </strong>${response.stock_available}</p>
                            </div>
                    `,
                        icon: 'info',
                        confirmButtonText: 'OK'
                    });
                }
            });
        }
    </script>
@endsection
