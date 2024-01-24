@extends('layouts.backend')


@section('js')
<script src="{{ asset('js/lib/oneui.app.min.js') }}"></script>
<script src="{{ asset('js/lib/jquery.min.js') }}"></script>
<script src="{{ asset('js/plugins/easy-pie-chart/jquery.easypiechart.min.js') }}"></script>
<script src="{{ asset('js/plugins/jquery-sparkline/jquery.sparkline.min.js') }}"></script>
<script src="{{ asset('js/plugins/chart.js/chart.min.js') }}"></script>
<!-- <script src="{{ asset('js/pages/be_comp_charts.min.js') }}"></script> -->

<!-- Page JS Helpers (Easy Pie Chart + jQuery Sparkline Plugins) -->
<script>
  One.helpersOnLoad(['jq-easy-pie-chart', 'jq-sparkline']);
</script>
@vite(['resources/js/pages/dashboard.js'])
endsection

@section('content')
<!-- Hero -->
<div class="bg-body-light">
  <div class="content content-full">
    <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
      <div class="flex-grow-1">
        <h1 class="h3 fw-bold mb-2">
          Dashboard
        </h1>
        <h2 class="fs-base lh-base fw-medium text-muted mb-0">
          
        </h2>
      </div>
      <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-alt">
          <li class="breadcrumb-item">
            <a class="link-fx" href="javascript:void(0)">App</a>
          </li>
          <li class="breadcrumb-item" aria-current="page">
            Dashboard
          </li>
        </ol>
      </nav>
    </div>
  </div>
</div>
<!-- END Hero -->

<!-- Page Content -->
<div class="content">
  <div class="row items-push">
    <div class="col-xl-12">
      <!-- Lines Chart -->
      @role('admin')
      <div class="block block-rounded">
        <div class="block-header block-header-default">
          <h3 class="block-title">Penilaian</h3>
          <div class="block-options">
            <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
              <i class="si si-refresh"></i>
            </button>
          </div>
        </div>
        <div class="block-content block-content-full text-center">
          <div class="py-3">
            <!-- Lines Chart Container -->
            <canvas id="js-chartjs-lines"></canvas>
          </div>
        </div>
      </div>
      @endrole
      <!-- END Lines Chart -->
    </div>
    
  </div>
</div>
<!-- END Page Content -->
<script>
  let chartLinesBarsRadarData, chartPolarPieDonutData;
  var data_user = @json($data_user);
  var data_nilai = @json($data_penilaian);
// Lines/Bar/Radar Chart Data
chartLinesBarsRadarData = {
  labels: ['JAN', 'FEB', 'MAR', 'APR', 'MEI', 'JUN', 'JUL', 'AGS', 'SEP', 'OKT', 'NOV', 'DES'],
  datasets: [
    {
      label: 'Jumlah Karyawan',
      fill: true,
      backgroundColor: 'rgba(171, 227, 125, .5)',
      borderColor: 'rgba(171, 227, 125, 1)',
      pointBackgroundColor: 'rgba(171, 227, 125, 1)',
      pointBorderColor: '#fff',
      pointHoverBackgroundColor: '#fff',
      pointHoverBorderColor: 'rgba(171, 227, 125, 1)',
      data: data_user
    },
    {
      label: 'Jumlah Dinilai',
      fill: true,
      backgroundColor: 'rgba(0, 0, 0, .1)',
      borderColor: 'rgba(0, 0, 0, .3)',
      pointBackgroundColor: 'rgba(0, 0, 0, .3)',
      pointBorderColor: '#fff',
      pointHoverBackgroundColor: '#fff',
      pointHoverBorderColor: 'rgba(0, 0, 0, .3)',
      data: data_nilai
    }
  ]
};
</script>
@endsection