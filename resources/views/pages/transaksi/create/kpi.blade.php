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
<!-- Hero -->
<!-- <div class="bg-body-light">
    <div class="content content-full">
      <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
        <div class="flex-grow-1">
          <h1 class="h3 fw-bold mb-2">
            DataTables Example
          </h1>
          <h2 class="fs-base lh-base fw-medium text-muted mb-0">
            Plugin Integration
          </h2>
        </div>
        <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-alt">
            <li class="breadcrumb-item">
              <a class="link-fx" href="javascript:void(0)">Examples</a>
            </li>
            <li class="breadcrumb-item" aria-current="page">
              DataTables
            </li>
          </ol>
        </nav>
      </div>
    </div>
  </div> -->
<!-- END Hero -->

<!-- Page Content -->
<div class="content">


    <!-- Dynamic Table with Export Buttons -->
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">
                Penilaian Data KPI
            </h3>
            <div class="block-option">
                <!-- <a href="/create/data_kpi" class="btn btn-sm btn-alt-primary">
          Tambah Data KPI
        </a> -->
            </div>
        </div>
        <div class="block-content block-content-full">
            <!-- DataTables init on table by adding .js-dataTable-buttons class, functionality is initialized in js/pages/tables_datatables.js -->
            <table class="table table-bordered table-striped table-vcenter js-dataTable-full fs-sm">
                  <thead>
                    <tr>
                      <th class="text-center" style="width: 80px;">#</th>
                      <th>Nilai</th>
                      <th>Nama Indikator</th>
                      <th>Nilai 0</th>
                      <th>Nilai 5</th>
                      <th>Nilai 10</th>
                      <th>Nilai 15</th>
                      <th>Periode Penilaian </th>
                      <th>Bobot</th>
                      <th>Skor</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="text-center">1</td>
                      <th  style="width: 8%;">
                        <select class="js-select2 form-select" id="val-kota" name="val-kota"  data-placeholder="Choose one..">
                          <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                          <option value="0">0</option>
                          <option value="5">5</option>
                          <option value="10">10</option>
                          <option value="15">15</option>
                        </select>
                      </th>
                      <th >
                      Keterlambatan
                      </th>
                      <th >
                      >3 kali/bulan
                      </th>
                      <th >
                      1-2
                      </th>
                      <th >
                        0
                      </th>
                      <th>
                      Selalu datang  lebih awal dari jam kerja yang diwajibkan
                      </th>
                      <th>Bulanan</th>
                      <th>2.5</th>
                      <th></th>
                    </tr>
                    <tr>
                      <td class="text-center">2</td>
                      <th  style="width: 8%;">
                        <select class="js-select2 form-select" id="val-kota" name="val-kota"  data-placeholder="Choose one..">
                          <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                          <option value="0">0</option>
                          <option value="5">5</option>
                          <option value="10">10</option>
                          <option value="15">15</option>
                        </select>
                      </th>
                      <th >
                      Kepatuhan Terhadap Prosedur 
                      </th>
                      <th >
                      Sangat sering  melakukan pelanggaran/kesalahan prosedur dalam  kerja
                      </th>
                      <th >
                      Kadang2 (tidak selalu/tidak sering)masih  melakukan kesalahan/pelanggaran terhadap prosedur kerja 
                      </th>
                      <th >
                      Selalu menjalankan prosedur kerja dengan tepat tanpa pelanggaran/kesalahan
                      </th>
                      <th>
                      Dapat memberi masukan yang konstruktif atas prosedur kerja yang ada
                      </th>
                      <th>Bulanan</th>
                      <th>5</th>
                      <th></th>
                    </tr>
                    <tr>
                      <td class="text-center">3</td>
                      <th  style="width: 8%;">
                        <select class="js-select2 form-select" id="val-kota" name="val-kota"  data-placeholder="Choose one..">
                          <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                          <option value="0">0</option>
                          <option value="5">5</option>
                          <option value="10">10</option>
                        </select>
                      </th>
                      <th >
                      Sanksi Administratif
                      </th>
                      <th >
                      >1 X Teguran Tertulis dan atau pernah mendapatkan Surat Peringatan 
                      </th>
                      <th >
                      1 kali Teguran Tertulis
                      </th>
                      <th >
                      Tidak pernah mendapatkan Sanksi Administratif
                      </th>
                      <th>
                      
                      </th>
                      <th>Bulanan</th>
                      <th>2.5</th>
                      <th></th>
                    </tr>
                    <tr>
                      <td class="text-center">4</td>
                      <th  style="width: 8%;">
                        <select class="js-select2 form-select" id="val-kota" name="val-kota"  data-placeholder="Choose one..">
                          <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                          <option value="0">0</option>
                          <option value="5">5</option>
                          <option value="10">10</option>
                          <option value="15">15</option>
                        </select>
                      </th>
                      <th >
                      Sikap dan Antusiasme dalam Bekerja
                      </th>
                      <th >
                      Seringkali menunjukkan sikap yang negatif, kurang/tidak antusias dan kurang bersemangat dalam bekerja
                      </th>
                      <th >
                      Sikap dan antusiasme  datar  , tidak menunjukkan semangat yang tinggi dan lamban/kurang cekatan  dalam  bekerja
                      </th>
                      <th >
                      Selalu menunjukkan sikap yang positif dan antusiasme tinggi , bersemangat dan cekatan dalam bekerja
                      </th>
                      <th>
                      Memiliki kemauan dan kemampuan untuk membangun sikap positif serta meningkatkan mampu meningkatkan antusiasme di lingkungan kerjanya
                      </th>
                      <th>Bulanan</th>
                      <th>2.5</th>
                      <th></th>
                    </tr>
                    <tr>
                      <td class="text-center">5</td>
                      <th  style="width: 8%;">
                        <select class="js-select2 form-select" id="val-kota" name="val-kota"  data-placeholder="Choose one..">
                          <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                          <option value="0">0</option>
                          <option value="5">5</option>
                          <option value="10">10</option>
                          <option value="15">15</option>
                        </select>
                      </th>
                      <th >
                      Motivasi dan ketekunan dalam bekerja
                      </th>
                      <th >
                      Seringkali melontarkan pernyataan negatif bila menghadapi tantangan dalam pekerjaan, kurang motivasi, kurang tekun dan mudah menyerah
                      </th>
                      <th >
                      Memiliki motivasi yang cukup dan tekun  dalam bekerja namun belum konsisten 
                      </th>
                      <th >
                      Selalu memiliki motivasi tinggi, tekun dan tidak mudah menyerah bila menghadapi tantangan
                      </th>
                      <th>
                     mampu menjadi motivator yang baik di lingkungan kerjanya
                      </th>
                      <th>Bulanan</th>
                      <th>2.5</th>
                      <th></th>
                    </tr>

                  </tbody>
                </table>
        </div>
    </div>
    <!-- END Dynamic Table with Export Buttons -->
</div>
<!-- END Page Content -->
@endsection