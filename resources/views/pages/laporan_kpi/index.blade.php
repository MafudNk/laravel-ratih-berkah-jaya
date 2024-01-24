@extends('layouts.backend')

@section('css')
<!-- Page JS Plugins CSS -->
<link rel="stylesheet" href="{{ asset('js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css') }}">
<link rel="stylesheet" href="{{ asset('js/plugins/datatables-buttons-bs5/css/buttons.bootstrap5.min.css') }}">
<link rel="stylesheet" href="{{asset('js/plugins/flatpickr/flatpickr.min.css')}}">
<link rel="stylesheet" href="{{asset('js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')}}">
<link rel="stylesheet" href="{{ asset('js/plugins/select2/css/select2.min.css') }}">
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
<script src="{{ asset('js/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('js/lib/oneui.app.min.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script>
  One.helpersOnLoad(['jq-select2']);
</script>

<!-- Tambahkan di bagian <head> -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">

<!-- Tambahkan sebelum penutup tag </body> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>


<!-- Page JS Code -->
@endsection

@section('content')

<style>
  .highlight {
    background-color: #fff8ad;
    /* Ganti dengan warna latar belakang yang diinginkan */
  }
</style>
<!-- Page Content -->
<div class="content">
  <!-- Info -->

  <!-- END Dynamic Table Full -->

  <!-- Dynamic Table with Export Buttons -->
  <div class="block block-rounded">
    <div class="block-header block-header-default">
      <h3 class="block-title">
        Laporan KPI
      </h3>

    </div>


    <br>
    <div class="container-fluid">
      @if(isset($error))
      <div class="alert alert-danger" role="alert">
        <i class="fa fa-check"></i>
        {{ $error }}
      </div>
      @endif
    </div>
    <br>
    <div class="container-fluid">
      <form action="{{ route('laporans.laporan_kpi_search') }}">
        <div class="row">
          <div class="col-md-2">
            <input type="text" class="datepicker form-control" data-date-format="mm/yyyy" name="month_year" required readonly placeholder="Periode">
          </div>
          <div class="col-md-2">
            <select class="js-select2 form-select" id="val-kecamatan" name="users_id" style="width: 100%;" data-placeholder="Choose one..">
              @foreach($karyawan as $kar)><!-- Required for data-placeholder attribute to work with Select2 plugin -->
              <option value="{{$kar->id}}">{{$kar->name}}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-2">
            <button type="submit" class="btn btn-alt-primary">Cari</button>

          </div>
        </div>
      </form><br>
      @if(isset($karyawan_))
      @if(isset($is_approved))
      @if($is_approved == 1)
      <a href="{{route('laporans.laporans_kpi_export' , ['id' => $karyawan_, 'bulan' => $bulan, 'tahun' => $tahun])}}" class="btn btn-alt-info" target="_blank">Cetak PDF</a>
      @endif
      @endif
      @endif
    </div>
    @if(isset($karyawan_))
    <h3 style=" text-align: center;"> Laporan Kinerja {{$karyawan_->name}} pada bulan {{$bulan}} {{$tahun}} </h3>
    @endif
    <div class="block-content block-content-full" id="myDiv">
      <!-- DataTables init on table by adding .js-dataTable-buttons class, functionality is initialized in js/pages/tables_datatables.js -->
      <table class="table table-bordered table-striped table-vcenter">
        <thead>
          <tr>
            <th class="text-center" style="width: 5%;">
              #
            </th>
            <th>Nama Indikator</th>
            <th style="width: 5%;">Bobot</th>
            <th style="width: 15%;">Keterangan Nilai 0</th>
            <th style="width: 15%;">Keterangan Nilai 5</th>
            <th style="width: 15%;">Keterangan Nilai 10</th>
            <th style="width: 15%;">Keterangan Nilai 15</th>
            <th class="text-center" style="width: 100px;">Nilai</th>
            <th class="text-center" style="width: 100px;">Skor</th>
          </tr>
        </thead>
        <tbody>
          @foreach($data_kpi as $key => $dt)
          <tr class="{{ $dt->class }}">
            <td class="text-center">
              {{$key+1}}
            </td>
            <td class="fw-semibold fs-sm">
              {{$dt->nama_indikator}}
            </td>
            <td class="fs-sm">{{$dt->bobot}}</td>
            <td class="fs-sm">{{$dt->nilai_0}}</td>
            <td class="fs-sm">{{$dt->nilai_5}}</td>
            <td class="fs-sm">{{$dt->nilai_10}}</td>
            <td class="fs-sm">{{$dt->nilai_15}}</td>
            <td class="fs-sm">{{$dt->nilai}}
            </td>
            <td> {{$dt->skor}}</td>
            @endforeach
          </tr>
          <tr>
            <td colspan="8" style="text-align: center;">Total Skor</td>
            <td>{{$total_skor}}</td>
          </tr>
          <tr>
            <td colspan="8" style="text-align: center;">Total Bobot</td>
            <td>{{$total_bobot}}</td>
          </tr>
          <tr>
            <td colspan="8" style="text-align: center;">Persentase</td>
            <td>{{$persentase}}</td>
          </tr>
          <tr>
            <td colspan="8" style="text-align: center;">Gradding</td>
            <td>{{$gradding}}</td>
          </tr>
        </tbody>
      </table>
      @if(isset($is_approved))
        @if($is_approved == 0)
          @if(isset($karyawan_))
            @if($karyawan_->name == auth()->user()->name)
            <a href="{{route('data_kpis.approval_update_isi_kpi_user' , ['id' => $transaksi_kpi_id])}}" class="btn btn-alt-success">Approval</a>
            <a href="{{route('data_kpis.update_isi_kpi_user' , ['id' => $transaksi_kpi_id])}}" class="btn btn-alt-warning">Pengajuan Nilai</a>
            @endif
          @endif
        @endif
      @endif
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