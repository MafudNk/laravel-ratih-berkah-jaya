@extends('layouts.backend')

@section('css')
<!-- Page JS Plugins CSS -->
<link rel="stylesheet" href="{{ asset('js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css') }}">
<link rel="stylesheet" href="{{ asset('js/plugins/datatables-buttons-bs5/css/buttons.bootstrap5.min.css') }}">
<link rel="stylesheet" href="{{asset('js/plugins/flatpickr/flatpickr.min.css')}}">
<link rel="stylesheet" href="{{asset('js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')}}">
@endsection

@section('js')
<!-- jQuery (required for DataTables plugin) -->
<script src="{{ asset('js/lib/jquery.min.js') }}"></script>

<!-- Page JS Plugins -->
<script src="{{ asset('js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/plugins/datatables-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
<script src="{{ asset('js/plugins/datatables-buttons/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('js/plugins/datatables-buttons-bs5/js/buttons.bootstrap5.min.js') }}"></script>
<script src="{{ asset('js/plugins/datatables-buttons-jszip/jszip.min.js') }}"></script>
<script src="{{ asset('js/plugins/datatables-buttons-pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('js/plugins/datatables-buttons-pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('js/plugins/datatables-buttons/buttons.print.min.js') }}"></script>
<script src="{{ asset('js/plugins/datatables-buttons/buttons.html5.min.js') }}"></script>
<script src="{{asset('js/plugins/flatpickr/flatpickr.min.js')}}"></script>
<script src="{{asset('js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{ asset('js/lib/oneui.app.min.js') }}"></script>

<script>
  One.helpersOnLoad(['js-flatpickr', 'jq-datepicker']);
</script>

<!-- Tambahkan di bagian <head> -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">

<!-- Tambahkan sebelum penutup tag </body> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>


<!-- Page JS Code -->
@endsection

@section('content')


<!-- Page Content -->
<div class="content">
  <!-- Info -->

  <!-- END Dynamic Table Full -->

  <!-- Dynamic Table with Export Buttons -->
  <div class="block block-rounded">
    <div class="block-header block-header-default">
      <h3 class="block-title">
        Transaksi KPI
      </h3>

    </div>
    <div class="container-fluid">
      @if(isset($successMessage))
      <div class="alert alert-success" role="alert">
        <i class="fa fa-check"></i>
        {{ $successMessage }}
      </div>
      @endif
    </div>

    <br>
    <div class="container-fluid">
      <form action="{{ route('data_kpis.transaksi_kpi_create_search') }}">
        <div class="row">
          <div class="col-md-2">
            <input type="text" class="datepicker form-control" data-date-format="mm/yyyy" name="month_year" readonly>
          </div>
          <div class="col-md-2">
            <button type="submit" class="btn btn-alt-primary">Cari</button>
          </div>
        </div>
      </form><br>
      @if($bulan != '')
      {{$bulan}} || {{$tahun}}
      @endif
    </div>


    <div class="block-content block-content-full">
      <!-- DataTables init on table by adding .js-dataTable-buttons class, functionality is initialized in js/pages/tables_datatables.js -->
      <table class="table table-bordered table-striped table-vcenter">
        <thead>
          <tr>
            <th class="text-center" style="width: 80px;">#</th>
            <th>Nama Karyawan</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($data_kpi as $key => $data) <tr>
            <td class="text-center">{{ $key+1 }}</td>
            <td class="fw-semibold">
              {{$data->name}}
            </td>
            <td>
              @if(empty($data->transaksi_kpi_id))
              <a class="btn btn-sm btn-alt-secondary js-bs-tooltip-enabled" href="{{ route('data_kpis.isi_kpi', ['data_kpi' => $data->id, 'bulan' => $bulan, 'tahun' => $tahun]) }}" data-bs-toggle="tooltip" aria-label="Update" data-bs-original-title="Update">
                <i class="fa fa-fw fa-pencil"></i>
              </a>
              @endif
              @if($data->is_pengajuan_perbaikan == 1)
              <a class="btn btn-sm btn-alt-danger js-bs-tooltip-enabled" href="{{ route('data_kpis.update_isi_kpi', ['data_kpi' => $data->id, 'transaksi_kpi_id' => $data->transaksi_kpi_id, 'bulan' => $bulan, 'tahun' => $tahun]) }}" data-bs-toggle="tooltip" aria-label="Update" data-bs-original-title="Update">
                <i class="fa fa-fw fa-pencil"></i>
              </a>
              @endif
              @if($data->is_approved == 1)
              <a class="btn btn-sm btn-alt-success">
                <i class="fa fa-fw fa-check"></i>
              </a>
              @endif

            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
  <!-- END Dynamic Table with Export Buttons -->
</div>
<!-- END Page Content -->
<script>
  $(document).ready(function() {
    $('.datepicker').datepicker({
      minViewMode: 1,
      format: 'mm/yyyy',
      autoclose: true
    });
  });
</script>

@endsection