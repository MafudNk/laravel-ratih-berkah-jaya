@extends('layouts.backend')

@section('css')
<!-- Page JS Plugins CSS -->
<link rel="stylesheet" href="{{ asset('js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css') }}">
<link rel="stylesheet" href="{{ asset('js/plugins/datatables-buttons-bs5/css/buttons.bootstrap5.min.css') }}">
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
<script src="{{ asset('js/plugins/select2/js/select2.full.min.js') }}"></script>
<!-- <script src="{{ asset('js/oneui.app.min.js') }}"></script> -->
<!-- Page JS Code -->
<!-- @vite(['resources/js/pages/karyawan.js']) -->
<!-- <script>One.helpersOnLoad(['jq-select2']);</script> -->
@endsection

@section('content')
<div class="content">

  <!-- Dynamic Table with Export Buttons -->
  <div class="block block-rounded">
    <div class="block-header block-header-default">
      <h3 class="block-title">
        ISI KPI
      </h3>

    </div>
    <div class="block-content block-content-full">

      <form class="js-validation" action="{{ route('data_kpis.save_kpi', $karyawan->id) }}" method="POST">
        @csrf
        @method('patch')
        <div class="block block-rounded">

          <div class="block-content block-content-full">
            <!-- Regular -->
            <div class="row">
              <div class="col-md-4">
                <table class="table table-bordered table-striped table-vcenter">
                  <thead>
                    <tr>
                      <th>Nama Karyawan</th>
                      <th>{{$karyawan->name}}</th>
                    </tr>
                    <tr>
                      <th>Nama Jabatan</th>
                      <th>{{$karyawan->nama_jabatan}}</th>
                    </tr>
                    <tr>
                      <th>Periode Penilaian</th>
                      <th>{{$bulan}} - {{$tahun}}</th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>

            <br>
            <br>

            <input type="hidden" name="bulan" value="{{ $bulan }}">
            <input type="hidden" name="tahun" value="{{ $tahun }}">
            <div class="table-responsive">
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
                  <tr>
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
                    <td>
                      <input type="hidden" name="id_{{$key}}" value="{{ $dt->data_kpi_id }}">
                      <select class="form-control" name="data_{{$key}}" id="data_{{$key}}" required onchange="getSelectedValue({{ $dt->bobot }}, {{$key}})">
                        <option value="">- Pilih Nilai -</option>
                        <option value="0">0</option>
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="15">15</option>

                      </select>
                      <!-- <div class="btn-group">
                      <button type="button" class="btn btn-sm btn-alt-danger js-bs-tooltip-enabled" data-bs-toggle="tooltip" aria-label="Delete" data-bs-original-title="Delete">
                        <i class="fa fa-fw fa-times"></i>
                      </button>
                    </div> -->
                    </td>
                    <td> <input type="text" class="form-control" readonly name="skor_{{$key}}" id="skor_{{$key}}"></td>
                    @endforeach
                  </tr>
                </tbody>
              </table>
            </div>
            <!-- END Regular -->

            <!-- END Advanced -->


            <!-- END Third Party Plugins -->

            <!-- Submit -->
            <div class="row items-push">
              <div class="col-lg-12">
                <button type="submit" class="btn btn-alt-primary">Submit</button>
              </div>
            </div>
            <!-- END Submit -->
          </div>
        </div>
      </form>

    </div>
  </div>
  <!-- END Dynamic Table with Export Buttons -->
</div>
<!-- END Page Content -->
<script>
  function getSelectedValue(row, key) {
    var select = document.getElementById("data_" + key);
    var skor = document.getElementById("skor_" + key);

    skor.value = select.value * row;
  }
</script>
@endsection