<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<style>
  body {
    font-family: Arial, sans-serif;
  }

  h1 {
    text-align: center;
    margin-bottom: 20px;
  }

  table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
  }

  th,
  td {
    border: 1px solid #ccc;
    padding: 8px;
    text-align: center;
  }

  th {
    background-color: #f2f2f2;
    font-weight: bold;
  }

  .tab {
    border-collapse: collapse;
    border: none;
  }

  .tab .first {
    border: none;
  }

  .tab .second {
    border-top: 1px solid #CCC;
    box-shadow: inset 0 1px 0 #CCC;
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

    <br>

    @if(isset($karyawan_))
    <h3 style=" text-align: center;"> Laporan Kinerja {{$karyawan_->name}} pada bulan {{$bulan}} {{$tahun}} </h3>
    @endif
    <div class="block-content block-content-full">
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
            <th class="text-center">Nilai</th>
            <th class="text-center">Skor</th>
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
    </div>
  </div>
  <div class="row">
    <table class="tab" >
      <thead>
        <tr>
          <td class="first"></td>
          <td class="first"></td>
        </tr>
        <tr>
          <td class="first">User Dinilai</td>
          <td class="first">Mengetahui</td>
        </tr>
        <tr>
          <td class="first"></td>
          <td class="first"></td>
        </tr>
        <tr>
          <td class="first"></td>
          <td class="first"></td>
        </tr>
        <tr>
          <td class="first"></td>
          <td class="first"></td>
        </tr>
        <tr>
          <td class="first"></td>
          <td class="first"></td>
        </tr>
        <tr>
          <td class="first"></td>
          <td class="first"></td>
        </tr>
        <tr>
          <td class="first">{{$karyawan_->name}}</td>
          <td class="first">Atasan Langsung</td>
        </tr>
      </thead>
    </table>
  </div>
  <!-- END Dynamic Table with Export Buttons -->
</div>
<!-- END Page Content -->