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
                Laporan Rekap KPI
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
            <form action="{{ route('laporans.laporan_rekap_kpi_search') }}">
                <div class="row">
                    <div class="col-md-2">
                        <input type="text" class="datepicker form-control" data-date-format="mm/yyyy" name="month_year" required readonly placeholder="Periode">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-alt-primary">Cari</button>
                    </div>
                </div>
            </form><br>
        </div>
        @if(isset($karyawan_))
        <h3 style=" text-align: center;"> Laporan Kinerja {{$karyawan_->name}} pada bulan {{$bulan}} {{$tahun}} </h3>
        @endif
        <div class="block-content block-content-full">
            <!-- DataTables init on table by adding .js-dataTable-buttons class, functionality is initialized in js/pages/tables_datatables.js -->
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Nama Karyawan</th>
                        <th>Nama Unit Kerja</th>
                        <th>Bobot</th>
                        <th>Nilai</th>
                        <th>Persentase</th>
                        <th>Nilai Angka</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transaksi_kpi as $dt)
                    <tr>
                        <td>{{$dt->name}}</td>
                        <td>{{$dt->unit_kerja_nama}}</td>
                        <td>{{$dt->total_bobot}}</td>
                        <td>{{$dt->total_skor}}</td>
                        <td>{{$dt->persentase}} %</td>
                        <td>{{$dt->gradding}} <span class="{{$dt->class_badge}}">{{$dt->badge}}</span></td>
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