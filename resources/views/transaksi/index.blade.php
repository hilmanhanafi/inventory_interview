<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.101.0">
    <title>Dashboard</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/4.6/examples/dashboard/">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>


    <!-- Custom styles for this template -->
    <link href="dashboard.css" rel="stylesheet">
  </head>
  <body>

<nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
  <a class="navbar-brand col-md-3 col-lg-2 mr-0 px-3" href="#">Inventory</a>
  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <ul class="navbar-nav px-3">
    <li class="nav-item text-nowrap">
      <a class="nav-link" href="{{ url('logout') }}">Logout</a>
    </li>
  </ul>
</nav>

<div class="container-fluid">
  <div class="row">
    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
      <div class="sidebar-sticky pt-3">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link active" href="{{ url('dashboard') }}">
              <span data-feather="home"></span>
              Dashboard <span class="sr-only">(current)</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ url('produk') }}">
              <span data-feather="file"></span>
              Produk
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ url('transaksi') }}">
              <span data-feather="shopping-cart"></span>
              Transaksi
            </a>
          </li>

        </ul>


      </div>
    </nav>

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
      <h2>Penjualan</h2>
      <form action="{{ url('transaksi/add') }}" method="post">
        @csrf
        @method('POST')
        <div class="row">
            <div class="col-md-4">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon1">Tanggal</span>
                    </div>
                    <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ date('Y-m-d') }}">

                  </div>
                  @error('tanggal')
                  <small id="emailHelp" class="form-text text-danger">{{ $message }}</small>

                  @enderror
            </div>
            <div class="col-md-4">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon1">Nama Barang</span>
                    </div>
                    <select name="nama_barang" class="form-control" id="nama_barang">
                        <option value="">PILIH</option>
                        @foreach ($produk as $p)
                            <option value="{{ $p->id }}">{{ $p->nama_barang }}</option>
                        @endforeach
                    </select>
                  </div>
                  @error('nama_barang')
                  <small id="emailHelp" class="form-text text-danger">{{ $message }}</small>

                  @enderror
            </div>
            <div class="col-md-4">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon1">Jumlah</span>
                    </div>
                    <input type="text" class="form-control" id="jumlah" name="jumlah">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Tambahkan</button>
                      </div>
                  </div>
                  @error('jumlah')
                  <small id="emailHelp" class="form-text text-danger">{{ $message }}</small>

                  @enderror
            </div>
         </div>
    </form>
    {{-- <a href="{{ url('transaksi/terbanyak') }}" class="btn btn-primary mb-2">Data Transaksi Terbanyak</a>
    <a href="{{ url('transaksi/terendah') }}" class="btn btn-primary mb-2">Data Transaksi Terendah</a> --}}
    <form action="" method="get">
    <div class="row mb-2">
        <div class="col-sm-7" id="form-range">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">Filter Berjangka</span>
                </div>
                <input type="date" class="form-control" name="start_date" id="start_date" value="{{ request()->start_date }}">
                <input type="date" class="form-control" name="end_date" id="end_date" value="{{ request()->end_date }}">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-outline-secondary button-search-range">Tampilkan</button>
                    <a href="{{ url('transaksi') }}" class="btn btn-outline-secondary">Reset</a>
                </div>
            </div>
        </div>
    </div>
</form>
    <div class="table-responsive">
        <table class="table table-striped table-sm" id="table">
          <thead>
            <tr>
              <th>#</th>
              <th>Nama Barang</th>
              <th>Jenis Barang</th>
              <th>Jumlah Terjual</th>
              <th>Tanggal Transaksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($transaksi as $key => $t )
                <tr>
                    <td>{{ ++$key }}</td>
                    <td>{{ $t->nama_barang }}</td>
                    <td>{{ $t->jenis_barang }}</td>
                    <td>{{ $t->jumlah_terjual }}</td>
                    <td>{{ $t->tanggal_transaksi }}</td>
                </tr>
            @empty

            @endforelse

          </tbody>
        </table>
      </div>
    </main>
  </div>
</div>


    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="dashboard.js"></script>
    <script>
        $('#table').DataTable()
    </script>
  </body>
</html>
