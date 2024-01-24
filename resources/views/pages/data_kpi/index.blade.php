@extends('layouts.backend')

@section('css')
<!-- Page JS Plugins CSS -->
<link rel="stylesheet" href="{{ asset('js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css') }}">
<link rel="stylesheet" href="{{ asset('js/plugins/datatables-buttons-bs5/css/buttons.bootstrap5.min.css') }}">
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

<!-- Page JS Code -->
@vite(['resources/js/pages/datatables.js'])
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
        Master Data KPI
      </h3>
      <div class="block-option">
        <a href="{{route('data_kpis.create')}}" class="btn btn-sm btn-alt-primary">
          Tambah Data KPI
        </a>
      </div>
    </div>
    <div class="container-fluid">
      @include('layouts.partials.messages')
    </div>
    <div class="block-content block-content-full">
      <!-- DataTables init on table by adding .js-dataTable-buttons class, functionality is initialized in js/pages/tables_datatables.js -->
      <table class="table table-bordered table-striped table-vcenter js-dataTable-buttons fs-sm">
        <thead>
          <tr>
            <th class="text-center" style="width: 80px;">#</th>
            <th>Nama KPI</th>
            <th>Action</th>
            <!-- <th class="d-none d-sm-table-cell" style="width: 30%;">Email</th>
            <th style="width: 15%;">Registered</th> -->
          </tr>
        </thead>
        <tbody>
          @foreach($data_kpi as $key => $data) <tr>
            <td class="text-center">{{ $key+1 }}</td>
            <td class="fw-semibold">
              {{$data->nama_indikator}}
            </td>
            <td>
              <a class="btn btn-sm btn-alt-secondary js-bs-tooltip-enabled" href="{{ route('data_kpis.edit', $data->data_kpi_id) }}" data-bs-toggle="tooltip" aria-label="Update" data-bs-original-title="Update">
                <i class="fa fa-fw fa-pencil"></i>
              </a>
              {!! Form::open(['method' => 'DELETE','route' => ['data_kpis.destroy', $data->data_kpi_id],'style'=>'display:inline']) !!}
                <button type="submit" class="btn btn-sm btn-alt-danger js-bs-tooltip-enabled" data-bs-toggle="tooltip" aria-label="Delete" data-bs-original-title="Delete">
                  <i class="fa fa-fw fa-times"></i>
                </button>
              {!! Form::close() !!}
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
@endsection