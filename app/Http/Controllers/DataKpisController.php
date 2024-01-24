<?php

namespace App\Http\Controllers;

use App\Models\DataKpi;
use App\Models\Jabatans;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

class DataKpisController extends Controller
{
    public function index()
    {
        $data_kpi = DB::table('data_kpi')->get();

        return view('pages.data_kpi.index', compact('data_kpi'));
    }

    public function transaksi_kpi_create()
    {

        $data_kpi = [];
        $bulan = '';
        $tahun = '';

        return view('pages.t_data_kpi.index', compact('data_kpi', 'bulan', 'tahun'));
    }
    public function transaksi_kpi_create_search(Request $request)
    {
        $keyword = $request->input('month_year');

        if (empty($keyword)) {
            $error = 'Silahkan Pilih Bulan Dahulu';


            $data_kpi = [];
            $bulan = '';
            $tahun = '';
    
            return view('pages.t_data_kpi.index', compact('data_kpi', 'bulan', 'tahun', 'error'));
        }


        $split = explode('/', $keyword);
        $sessionId = auth()->id();
        $bulan =  $split[0];
        $tahun = $split[1];

        $user = Auth::user();
        $roleNames = $user->getRoleNames();
        $nama_role = $roleNames[0];

        $data_users = DB::table('users')
            ->select('users.name', 'users.id', 'users.unit_kerja_id')
            ->where('users.is_aktif', 0)
            ->where('users.id', $sessionId)
            ->first();
        // dd($nama_role);
        if ($nama_role != "HR" && $nama_role != "admin") {
            $data_kpi = DB::table('users')
                ->select('users.name', 'users.id')
                ->where('users.unit_kerja_id', $data_users->unit_kerja_id)
                ->where('users.is_aktif', 0)
                ->where('users.id', '!=', $sessionId)
                ->get();
        } else {
            $data_kpi = DB::table('users')
                ->select('users.name', 'users.id')
                ->where('users.is_aktif', 0)
                ->where('users.id', '!=', $sessionId)
                ->get();
        }

        foreach ($data_kpi as $key => $value) {
            $transaksi_kpi = DB::table('transaksi_kpi')->whereRaw("bulan = $split[0] and TAHUN = $split[1] and karyawan_id = $value->id")->select('transaksi_kpi.*')->first();
            $value->transaksi_kpi_id = isset($transaksi_kpi) ? $transaksi_kpi->transaksi_kpi_id : '';
            $value->is_pengajuan_perbaikan = isset($transaksi_kpi) ? $transaksi_kpi->is_pengajuan_perbaikan : '';
            $value->is_approved = isset($transaksi_kpi) ? $transaksi_kpi->is_approved : '';
            $bulan =  $split[0];
            $tahun = $split[1];
        }
        return view('pages.t_data_kpi.index', compact('data_kpi', 'bulan', 'tahun'));
    }

    /**
     * Show form for creating user
     * 
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.data_kpi.create');
    }

    /**
     * Store a newly created user
     * 
     * @param User $user
     * @param StoreUserRequest $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            // dd( $request->get('departemen_nama'));
            /* Mencoba membuat entri baru dalam database */
            $dep = DataKpi::create([
                'nama_indikator' => $request->get('nama_indikator'),
                'nilai_0' => $request->get('nilai_0'),
                'nilai_5' => $request->get('nilai_5'),
                'nilai_10' => $request->get('nilai_10'),
                'nilai_15' => $request->get('nilai_15'),
                'bobot' => $request->get('bobot'),
            ]);

            return redirect()->route('data_kpis.index')
                ->withSuccess(__('Data KPI created successfully.'));
        } catch (QueryException $e) {

            $errorMessage = $e->getMessage();
            /* Misalnya, memunculkan error ke pengguna */
            return redirect()->route('data_kpis.index')
                ->withErrors(['message' => "Terjadi kesalahan. $errorMessage"]);
        }
    }

    /**
     * Show user data
     * 
     * @param User $user
     * 
     * @return \Illuminate\Http\Response
     */
    public function show(Departemen $dep)
    {
        return view('departemens.show', [
            'user' => $dep
        ]);
    }

    /**
     * Edit user data
     * 
     * @param Departemen $user
     * 
     * @return \Illuminate\Http\Response
     */
    public function edit(DataKpi $dep, $id)
    {
        $data_kpi = DataKpi::where('data_kpi_id', '=', $id)->first();
        return view('pages.data_kpi.edit', [
            'value' => $data_kpi,
        ]);
    }

    /**
     * Update user data
     * 
     * @param User $user
     * @param UpdateUserRequest $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nama_indikator' => 'required',
            'nilai_0' => 'required',
            'nilai_5' => 'required',
            'nilai_10' => 'required',
            'nilai_15' => 'required',
            'bobot' => 'required',
        ]);
        // Ambil data pengguna dari database berdasarkan ID
        $departemen = DataKpi::where('data_kpi_id', '=', $id)->first();
        if (!$departemen) {
            // Jika data tidak ditemukan, lakukan tindakan yang sesuai, seperti redirect atau memunculkan pesan error
            // return redirect()->back()->with('error', 'Data pengguna tidak ditemukan.');
            return redirect()->route('data_kpi.index')
                ->withErrors(['message' => 'Error, Data pengguna tidak ditemukan.']);
        }
        try {
            DB::table('data_kpi')
                ->where('data_kpi_id', $id)
                ->update([
                    'nama_indikator' => $validatedData['nama_indikator'],
                    'nilai_0' => $validatedData['nilai_0'],
                    'nilai_5' => $validatedData['nilai_5'],
                    'nilai_10' => $validatedData['nilai_10'],
                    'nilai_15' => $validatedData['nilai_15'],
                    'bobot' => $validatedData['bobot'],
                ]);
            return redirect()->route('data_kpis.index')
                ->withSuccess(__("Data KPI  updated successfully."));
        } catch (QueryException $e) {
            $errorMessage = $e->getMessage();
            /* Misalnya, memunculkan error ke pengguna */
            return redirect()->route('data_kpis.index')
                ->withErrors(['message' => 'Error Terjadi kesalahan.']);
        }
    }

    /**
     * Delete user data
     * 
     * @param User $user
     * 
     * @return \Illuminate\Http\Response
     */
    public function destroy(DataKpi $dep, $id)
    {

        try {
            DataKpi::where('data_kpi_id', $id)->delete();
            return redirect()->route('data_kpis.index')
                ->withSuccess(__("Indikator deleted successfully."));
        } catch (QueryException $e) {
            $errorMessage = $e->getMessage();
            /* Misalnya, memunculkan error ke pengguna */
            return redirect()->route('data_kpis.index')
                ->withErrors(['message' => 'Error Terjadi kesalahan.']);
        }
    }

    public function isi_kpi(DataKpi $dep, $id, $bulan, $tahun)
    {

        $karyawan = DB::table('users')
            ->where('users.id', '=', $id)
            ->where('users.is_aktif', 0)
            ->join('jabatan', 'jabatan.jabatan_id', '=', 'users.jabatan_id')
            ->select('users.*', 'jabatan.nama_jabatan')
            ->first();

        $data_kpi = DB::table('data_detail_kpi')
            ->join('jabatan', 'jabatan.jabatan_id', '=', 'data_detail_kpi.jabatan_id')
            ->join('data_kpi', 'data_kpi.data_kpi_id', '=', 'data_detail_kpi.data_kpi_id')
            ->where('data_detail_kpi.is_aktif', '=', 0)
            ->where('jabatan.jabatan_id', '=', $karyawan->jabatan_id)
            ->select(
                'data_kpi.nama_indikator',
                'data_kpi.nilai_0',
                'data_kpi.nilai_5',
                'data_kpi.nilai_10',
                'data_kpi.nilai_15',
                'data_kpi.data_kpi_id',
                'data_kpi.bobot',
                'data_detail_kpi.data_detail_kpi_id'
            )
            ->get();
        return view('pages.t_data_kpi.edit', [
            'data_kpi' => $data_kpi,
            'karyawan' => $karyawan,
            'bulan'    => $bulan,
            'tahun'    => $tahun,
        ]);
    }
    public function update_isi_kpi(DataKpi $dep, $id, $transaksi_kpi_id, $bulan, $tahun)
    {

        $karyawan = DB::table('users')
            ->where('users.id', '=', $id)
            ->where('users.is_aktif', 0)
            ->join('jabatan', 'jabatan.jabatan_id', '=', 'users.jabatan_id')
            ->select('users.*', 'jabatan.nama_jabatan')
            ->first();

        $data_kpi = DB::table('transaksi_detail_kpi')
            ->join('transaksi_kpi', 'transaksi_kpi.transaksi_kpi_id', '=', 'transaksi_detail_kpi.transaksi_kpi_id')
            ->join('jabatan', 'jabatan.jabatan_id', '=', 'transaksi_kpi.jabatan_id')
            ->join('data_kpi', 'data_kpi.data_kpi_id', '=', 'transaksi_detail_kpi.data_kpi_id')
            ->where('transaksi_kpi.transaksi_kpi_id', '=', $transaksi_kpi_id)
            ->selectRaw(
                "data_kpi.nama_indikator,
                data_kpi.nilai_0,
                data_kpi.nilai_5,
                data_kpi.nilai_10,
                data_kpi.nilai_15,
                data_kpi.data_kpi_id,
                data_kpi.bobot,
                transaksi_detail_kpi.nilai,
                transaksi_detail_kpi.komentar_user_penilai,
                transaksi_detail_kpi.komentar_user,
                (transaksi_detail_kpi.nilai * data_kpi.bobot) AS skor
                "
            )
            ->get();
        $data_kpi_id = DB::table('transaksi_kpi')
            ->join('jabatan', 'jabatan.jabatan_id', '=', 'transaksi_kpi.jabatan_id')
            ->where('transaksi_kpi.transaksi_kpi_id', '=', $transaksi_kpi_id)
            ->selectRaw(
                "transaksi_kpi.transaksi_kpi_id"
            )
            ->first();

        return view('pages.t_data_kpi.update', [
            'data_kpi' => $data_kpi,
            'karyawan' => $karyawan,
            'bulan'    => $bulan,
            'tahun'    => $tahun,
            'data_kpi_id' => $data_kpi_id,
        ]);
    }

    public function update_isi_kpi_user(Request $request)
    {

        // $karyawan = DB::table('users')
        //     ->where('users.id', '=', $id)
        //     ->where('users.is_aktif', 0)
        //     ->join('jabatan', 'jabatan.jabatan_id', '=', 'users.jabatan_id')
        //     ->select('users.*', 'jabatan.nama_jabatan')
        //     ->first();
        $id = $request->get('id');

        $data_kpi = DB::table('transaksi_detail_kpi')
            ->join('transaksi_kpi', 'transaksi_kpi.transaksi_kpi_id', '=', 'transaksi_detail_kpi.transaksi_kpi_id')
            ->join('jabatan', 'jabatan.jabatan_id', '=', 'transaksi_kpi.jabatan_id')
            ->join('data_kpi', 'data_kpi.data_kpi_id', '=', 'transaksi_detail_kpi.data_kpi_id')
            ->where('transaksi_kpi.transaksi_kpi_id', '=', $id)
            ->selectRaw(
                "data_kpi.nama_indikator,
                data_kpi.nilai_0,
                data_kpi.nilai_5,
                data_kpi.nilai_10,
                data_kpi.nilai_15,
                data_kpi.data_kpi_id,
                data_kpi.bobot,
                transaksi_detail_kpi.nilai,
                transaksi_detail_kpi.komentar_user_penilai,
                transaksi_detail_kpi.komentar_user,
                (transaksi_detail_kpi.nilai * data_kpi.bobot) AS skor
                "
            )
            ->get();
        $data_kpi_id = DB::table('transaksi_kpi')
            ->join('jabatan', 'jabatan.jabatan_id', '=', 'transaksi_kpi.jabatan_id')
            ->where('transaksi_kpi.transaksi_kpi_id', '=', $id)
            ->selectRaw(
                "transaksi_kpi.transaksi_kpi_id"
            )
            ->first();

        return view('pages.t_data_kpi.update_user', [
            'data_kpi' => $data_kpi,
            'data_kpi_id' => $data_kpi_id,
        ]);
    }

    /**
     * Update user data
     * 
     * @param User $user
     * @param UpdateUserRequest $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function save_kpi(Request $request, $id)
    {

        $array = $request->all();

        $karyawan = DB::table('users')
            ->where('users.id', '=', $id)
            ->where('users.is_aktif', 0)
            ->join('jabatan', 'jabatan.jabatan_id', '=', 'users.jabatan_id')
            ->select('users.*', 'jabatan.nama_jabatan')
            ->first();

        $data_kpi = DB::table('data_detail_kpi')
            ->join('jabatan', 'jabatan.jabatan_id', '=', 'data_detail_kpi.jabatan_id')
            ->join('data_kpi', 'data_kpi.data_kpi_id', '=', 'data_detail_kpi.data_kpi_id')
            ->where('data_detail_kpi.is_aktif', '=', 0)
            ->where('jabatan.jabatan_id', '=', $karyawan->jabatan_id)
            ->select(
                'data_kpi.nama_indikator',
                'data_kpi.nilai_0',
                'data_kpi.nilai_5',
                'data_kpi.nilai_10',
                'data_kpi.nilai_15',
                'data_kpi.data_kpi_id',
                'data_kpi.bobot',
                'data_detail_kpi.data_detail_kpi_id'
            )
            ->count();
        $dt = [];
        foreach ($array as $key => $value) {
            if ($key != "_token" && $key != "_method" &&  $key != "bulan" && $key != "tahun") {
                $dt[$key] = $value;
            }
        }

        try {
            $karyawan = DB::table('users')
                ->where('users.id', '=', $id)
                ->where('users.is_aktif', 0)
                ->join('jabatan', 'jabatan.jabatan_id', '=', 'users.jabatan_id')
                ->select('users.*', 'jabatan.jabatan_id')
                ->first();


            $transaksi_kpi = DB::table('transaksi_kpi')->insert([
                'karyawan_id' => $id,
                'jabatan_id' => $karyawan->jabatan_id,
                'bulan' => $request->get('bulan'),
                'TAHUN' => $request->get('tahun'),
            ]);

            $transaksi_kpi = DB::table('transaksi_kpi')->orderBy('transaksi_kpi_id', 'desc')->first();

            for ($j = 0; $j < $data_kpi; $j++) {
                $transaksi_kpi_detail =  DB::table('transaksi_detail_kpi')->insert([
                    'transaksi_kpi_id' => $transaksi_kpi->transaksi_kpi_id,
                    'data_kpi_id' => $dt["id_$j"],
                    'nilai' => $dt["data_$j"],
                ]);
            }

            $data_kpi = [];
            $bulan = '';
            $tahun = '';
            $successMessage = 'Data successfully saved';


            return view('pages.t_data_kpi.index', compact('data_kpi', 'bulan', 'tahun', 'successMessage'));
            // return redirect()->route('data_kpis.index')
            //     ->withSuccess(__("Data KPI  updated successfully."));
        } catch (QueryException $e) {
            $errorMessage = $e->getMessage();
            /* Misalnya, memunculkan error ke pengguna */
            return redirect()->route('data_kpis.transaksi_kpi_create')
                ->withErrors(['message' => 'Error Terjadi kesalahan.']);
        }
    }

    public function save_update_isi_kpi(Request $request, $id)
    {
        $array = $request->all();



        $data_kpi = DB::table('transaksi_detail_kpi')
            ->where('transaksi_detail_kpi.transaksi_kpi_id', '=', $id)
            ->select(
                'transaksi_kpi_id'
            )
            ->count();
        $dt = [];
        foreach ($array as $key => $value) {
            if ($key != "_token" && $key != "_method" &&  $key != "bulan" && $key != "tahun") {
                $dt[$key] = $value;
            }
        }

        // dd($dt);
        try {

            $transaksi_kpi = DB::table('transaksi_kpi')
                ->where('transaksi_kpi_id', $id)
                ->update([
                    'is_pengajuan_perbaikan' => 0,
                ]);

            for ($j = 0; $j < $data_kpi; $j++) {
                $transaksi_kpi_detail =  DB::table('transaksi_detail_kpi')
                    ->where('transaksi_kpi_id', $id)
                    ->where('data_kpi_id', $dt["id_$j"])
                    ->update([
                        'nilai' => $dt["data_$j"],
                        'komentar_user_penilai' => $dt["komentar_user_penilai_$j"],
                    ]);
            }

            $data_kpi = [];
            $bulan = '';
            $tahun = '';
            $successMessage = 'Data successfully saved';

            return view('pages.t_data_kpi.index', compact('data_kpi', 'bulan', 'tahun', 'successMessage'));
            // return redirect()->route('data_kpis.index')
            //     ->withSuccess(__("Data KPI  updated successfully."));
        } catch (QueryException $e) {
            $errorMessage = $e->getMessage();
            /* Misalnya, memunculkan error ke pengguna */
            // dd($errorMessage);
            return redirect()->route('data_kpis.index')
                ->withErrors(['message' => "Error Terjadi kesalahan. $errorMessage"]);
        }
    }
    public function save_update_isi_kpi_user(Request $request, $id)
    {
        $array = $request->all();



        $data_kpi = DB::table('transaksi_detail_kpi')
            ->where('transaksi_detail_kpi.transaksi_kpi_id', '=', $id)
            ->select(
                'transaksi_kpi_id'
            )
            ->count();
        $dt = [];
        foreach ($array as $key => $value) {
            if ($key != "_token" && $key != "_method" &&  $key != "bulan" && $key != "tahun") {
                $dt[$key] = $value;
            }
        }

        // dd($dt);
        try {

            $transaksi_kpi = DB::table('transaksi_kpi')
                ->where('transaksi_kpi_id', $id)
                ->update([
                    'is_pengajuan_perbaikan' => 1,
                ]);

            for ($j = 0; $j < $data_kpi; $j++) {
                $transaksi_kpi_detail =  DB::table('transaksi_detail_kpi')
                    ->where('transaksi_kpi_id', $id)
                    ->where('data_kpi_id', $dt["id_$j"])
                    ->update([
                        'komentar_user' => $dt["komentar_user_$j"],
                    ]);
            }

            $data_kpi = [];
            $bulan =  $tahun =  $gradding = $nilai_huruf = $transaksi_kpi_id = '';
            $total_skor = $total_bobot = $persentase = 0;
            $sessionId = auth()->id();
            $user = Auth::user();
            $roleNames = $user->getRoleNames();
            $nama_role = $roleNames[0];
    
            $data_users = DB::table('users')
                ->select('users.name', 'users.id', 'users.unit_kerja_id')
                ->where('users.is_aktif', 0)
                ->where('users.id', $sessionId)
                ->first();
            if ($nama_role != "HR" && $nama_role != "admin" && $nama_role != "Staff") {
                $karyawan = DB::table('users')
                    ->select('users.name', 'users.id')
                    ->where('users.unit_kerja_id', $data_users->unit_kerja_id)
                    ->where('users.is_aktif', 0)
                    ->get();
            } else if ($nama_role == "Staff") {
                $karyawan = DB::table('users')
                    ->select('users.name', 'users.id')
                    ->where('users.is_aktif', 0)
                    ->where('users.id', $sessionId)
                    ->get();
            } else {
                $karyawan = DB::table('users')
                    ->select('users.name', 'users.id')
                    ->where('users.is_aktif', 0)
                    ->where('users.id', '!=', $sessionId)
                    ->get();
            }

            return view('pages.laporan_kpi.index', compact('data_kpi', 'bulan', 'tahun', 'karyawan', 'total_skor', 'total_bobot', 'persentase', 'gradding', 'nilai_huruf', 'transaksi_kpi_id'));
            // return redirect()->route('data_kpis.index')
            //     ->withSuccess(__("Data KPI  updated successfully."));
        } catch (QueryException $e) {
            $errorMessage = $e->getMessage();
            /* Misalnya, memunculkan error ke pengguna */
            // dd($errorMessage);
            return redirect()->route('data_kpis.index')
                ->withErrors(['message' => "Error Terjadi kesalahan. $errorMessage"]);
        }
    }


    public function approval_update_isi_kpi_user(Request $request)
    {
        
        $id = $request->get('id');
        $data_kpi = [];
        $bulan =  $tahun =  $gradding = $nilai_huruf = $transaksi_kpi_id = '';
        $total_skor = $total_bobot = $persentase = 0;
        $sessionId = auth()->id();
        $user = Auth::user();
        $roleNames = $user->getRoleNames();
        $nama_role = $roleNames[0];

        $data_users = DB::table('users')
            ->select('users.name', 'users.id', 'users.unit_kerja_id')
            ->where('users.is_aktif', 0)
            ->where('users.id', $sessionId)
            ->first();
        if ($nama_role != "HR" && $nama_role != "admin" && $nama_role != "Staff") {
            $karyawan = DB::table('users')
                ->select('users.name', 'users.id')
                ->where('users.unit_kerja_id', $data_users->unit_kerja_id)
                ->where('users.is_aktif', 0)
                ->get();
        } else if ($nama_role == "Staff") {
            $karyawan = DB::table('users')
                ->select('users.name', 'users.id')
                ->where('users.is_aktif', 0)
                ->where('users.id', $sessionId)
                ->get();
        } else {
            $karyawan = DB::table('users')
                ->select('users.name', 'users.id')
                ->where('users.is_aktif', 0)
                ->where('users.id', '!=', $sessionId)
                ->get();
        }
        try {

            $transaksi_kpi = DB::table('transaksi_kpi')
                ->where('transaksi_kpi_id', $id)
                ->update([
                    'is_approved' => 1,
                ]);


            return view('pages.laporan_kpi.index', compact('data_kpi', 'bulan', 'tahun', 'karyawan', 'total_skor', 'total_bobot', 'persentase', 'gradding', 'nilai_huruf', 'transaksi_kpi_id'));
            // return redirect()->route('data_kpis.index')
            //     ->withSuccess(__("Data KPI  updated successfully."));
        } catch (QueryException $e) {
            $errorMessage = $e->getMessage();
            /* Misalnya, memunculkan error ke pengguna */
            // dd($errorMessage);
            return redirect()->route('data_kpis.index')
                ->withErrors(['message' => "Error Terjadi kesalahan. $errorMessage"]);
        }
    }

    public function laporan_kpi()
    {
        $data_kpi = [];
        $bulan =  $tahun =  $gradding = $nilai_huruf = $transaksi_kpi_id = '';
        $total_skor = $total_bobot = $persentase = 0;
        $sessionId = auth()->id();
        $user = Auth::user();
        $roleNames = $user->getRoleNames();
        $nama_role = $roleNames[0];

        $data_users = DB::table('users')
            ->select('users.name', 'users.id', 'users.unit_kerja_id')
            ->where('users.is_aktif', 0)
            ->where('users.id', $sessionId)
            ->first();
        if ($nama_role != "HR" && $nama_role != "admin" && $nama_role != "Staff") {
            $karyawan = DB::table('users')
                ->select('users.name', 'users.id')
                ->where('users.unit_kerja_id', $data_users->unit_kerja_id)
                ->where('users.is_aktif', 0)
                ->get();
        } else if ($nama_role == "Staff") {
            $karyawan = DB::table('users')
                ->select('users.name', 'users.id')
                ->where('users.is_aktif', 0)
                ->where('users.id', $sessionId)
                ->get();
        } else {
            $karyawan = DB::table('users')
                ->select('users.name', 'users.id')
                ->where('users.is_aktif', 0)
                ->where('users.id', '!=', $sessionId)
                ->get();
        }


        return view('pages.laporan_kpi.index', compact('data_kpi', 'bulan', 'tahun', 'karyawan', 'total_skor', 'total_bobot', 'persentase', 'gradding', 'nilai_huruf', 'transaksi_kpi_id'));
    }

    public function laporan_kpi_search(Request $request)
    {
        $keyword = $request->input('month_year');

        $karyawan = DB::table('users')
            ->where('users.is_aktif', 0)
            ->select('users.name', 'users.id')
            ->get();

        $total_skor = $total_bobot = $persentase = $transaksi_kpi_id =  $is_approved =  0;
        $is_approved =  2;
        if (empty($keyword)) {
            $data_kpi = [];
            $bulan =  $tahun =  $gradding = $nilai_huruf =  '';
            $error = 'Silahkan Pilih Bulan Dahulu';


            return view('pages.laporan_kpi.index', compact('data_kpi', 'bulan', 'tahun', 'karyawan', 'error', 'total_skor', 'total_bobot', 'persentase', 'gradding', 'nilai_huruf'));
        }
        $split = explode('/', $keyword);

        $karyawan_ = DB::table('users')
            ->where('users.id', '=', $request->input('users_id'))
            ->join('jabatan', 'jabatan.jabatan_id', '=', 'users.jabatan_id')
            ->select('users.*', 'jabatan.nama_jabatan', 'jabatan.jabatan_id')
            ->first();

        $data_kpi = DB::table('transaksi_detail_kpi')
            ->join('transaksi_kpi', 'transaksi_kpi.transaksi_kpi_id', '=', 'transaksi_detail_kpi.transaksi_kpi_id')
            ->join('jabatan', 'jabatan.jabatan_id', '=', 'transaksi_kpi.jabatan_id')
            ->join('data_kpi', 'data_kpi.data_kpi_id', '=', 'transaksi_detail_kpi.data_kpi_id')
            ->where('jabatan.jabatan_id', '=', $karyawan_->jabatan_id)
            ->where('transaksi_kpi.karyawan_id', '=', $karyawan_->id)
            ->where('transaksi_kpi.bulan', '=', $split[0])
            ->where('transaksi_kpi.TAHUN', '=', $split[1])
            ->select(
                'data_kpi.nama_indikator',
                'data_kpi.nilai_0',
                'data_kpi.nilai_5',
                'data_kpi.nilai_10',
                'data_kpi.nilai_15',
                'data_kpi.data_kpi_id',
                'data_kpi.bobot',
                'transaksi_detail_kpi.nilai',
                'transaksi_kpi.transaksi_kpi_id',
                'transaksi_kpi.is_approved'
            )
            ->get();

        foreach ($data_kpi as $key => $value) {
            $value->skor = $value->bobot * $value->nilai;
            $value->bobot_ = $value->bobot * 15;
            $value->class = $value->nilai <= 5 ? "highlight" : "";
            $total_skor += $value->skor;
            $total_bobot += $value->bobot_;
            $transaksi_kpi_id = $value->transaksi_kpi_id;
            $is_approved = $value->is_approved;
        }
        $persentase = $total_skor != 0 ? round($total_skor / $total_bobot * 100, 2) : 0;
        if ($persentase == 100) {
            $gradding = "A";
            $nilai_huruf = "Very good";
        } else if ($persentase <= 99 &&  $persentase >= 90) {
            $gradding = "B";
            $nilai_huruf = "Good";
        } else if ($persentase  <= 89 &&  $persentase >= 85) {
            $gradding = "C";
            $nilai_huruf = "Good Enough";
        } else if ($persentase >= 80 &&  $persentase <= 84) {
            $gradding = "D";
            $nilai_huruf = "Less";
        } else {
            $gradding = "E";
            $nilai_huruf = "Very Less";
        }
        // dd($persentase);
        $bulan = $split[0];
        $tahun = $split[1];
        // dd($transaksi_kpi_id);
        return view('pages.laporan_kpi.index', compact('data_kpi', 'bulan', 'tahun', 'karyawan', 'karyawan_', 'total_skor', 'total_bobot', 'persentase', 'gradding', 'nilai_huruf', 'transaksi_kpi_id', 'is_approved'));
    }
    /* Rekap laporan */
    public function laporan_rekap_kpi()
    {
        $data_kpi = [];
        $bulan = '';
        $tahun = '';
        $transaksi_kpi = [];
        $total_skor = $total_bobot = $persentase = 0;

        return view('pages.laporan_kpi.rekap_index', compact('transaksi_kpi', 'bulan', 'tahun'));
    }
    public function laporan_rekap_kpi_search(Request $request)
    {
        $keyword = $request->input('month_year');

        $sessionId = auth()->id();

        $user = Auth::user();
        $roleNames = $user->getRoleNames();
        $nama_role = $roleNames[0];

        $data_users = DB::table('users')
            ->select('users.name', 'users.id', 'users.unit_kerja_id')
            ->where('users.is_aktif', 0)
            ->where('users.id', $sessionId)
            ->first();
        // dd($nama_role);


        $total_skor = $total_bobot = $persentase = 0;
        if (empty($keyword)) {
            $data_kpi = [];
            $bulan = '';
            $tahun = '';
            $transaksi_kpi = [];
            $error = 'Silahkan Pilih Bulan Dahulu';


            return view('pages.laporan_kpi.rekap_index', compact('transaksi_kpi', 'bulan', 'tahun', 'error'));
        }

        $split = explode('/', $keyword);
        if ($nama_role != "HR" && $nama_role != "admin") {

            $transaksi_kpi = DB::table('transaksi_kpi')
                ->join('jabatan', 'jabatan.jabatan_id', '=', 'transaksi_kpi.jabatan_id')
                ->join('users', 'users.id', '=', 'transaksi_kpi.karyawan_id')
                ->join('unit_kerja', 'users.unit_kerja_id', '=', 'unit_kerja.unit_kerja_id')
                ->where('users.unit_kerja_id', $data_users->unit_kerja_id)
                ->where('transaksi_kpi.bulan', '=', $split[0])
                ->where('transaksi_kpi.TAHUN', '=', $split[1])
                ->selectRaw(
                    'transaksi_kpi.transaksi_kpi_id,
                jabatan.jabatan_id,
                users.id,
                users.name,
                unit_kerja.unit_kerja_nama,
                0 as total_skor,
                0 as total_bobot'
                )
                ->get();
        } else {
            $transaksi_kpi = DB::table('transaksi_kpi')
                ->join('jabatan', 'jabatan.jabatan_id', '=', 'transaksi_kpi.jabatan_id')
                ->join('users', 'users.id', '=', 'transaksi_kpi.karyawan_id')
                ->join('unit_kerja', 'users.unit_kerja_id', '=', 'unit_kerja.unit_kerja_id')
                ->where('transaksi_kpi.bulan', '=', $split[0])
                ->where('transaksi_kpi.TAHUN', '=', $split[1])
                ->selectRaw(
                    'transaksi_kpi.transaksi_kpi_id,
                jabatan.jabatan_id,
                users.id,
                users.name,
                unit_kerja.unit_kerja_nama,
                0 as total_skor,
                0 as total_bobot'
                )
                ->get();
        }

        foreach ($transaksi_kpi as $key => $value) {

            $data_kpi = DB::table('transaksi_detail_kpi')
                ->join('transaksi_kpi', 'transaksi_kpi.transaksi_kpi_id', '=', 'transaksi_detail_kpi.transaksi_kpi_id')
                ->join('data_kpi', 'data_kpi.data_kpi_id', '=', 'transaksi_detail_kpi.data_kpi_id')
                ->where('transaksi_kpi.transaksi_kpi_id', '=', $value->transaksi_kpi_id)
                ->select(
                    'data_kpi.bobot',
                    'transaksi_detail_kpi.nilai'
                )
                ->get();

            foreach ($data_kpi as $keys => $values) {
                $skor = $values->bobot * $values->nilai;
                $bobot_ = $values->bobot * 15;
                $value->total_skor += $skor;
                $value->total_bobot += $bobot_;
            }

            $value->persentase = round($value->total_skor / $value->total_bobot * 100, 2);

            if ($value->persentase == 100) {
                $value->gradding = "A";
                $value->badge = "Very Good";
                $value->class_badge = "badge bg-success";
            } else if ($value->persentase <= 99 &&  $value->persentase >= 90) {
                $value->gradding = "B";
                $value->badge = "Good";
                $value->class_badge = "badge bg-primary";
            } else if ($value->persentase  <= 89 &&  $value->persentase >= 85) {
                $value->gradding = "C";
                $value->badge = "Good Enough";
                $value->class_badge = "badge bg-warning";
            } else if ($value->persentase >= 80 &&  $value->persentase <= 84) {
                $value->gradding = "D";
                $value->badge = "Less";
                $value->class_badge = "badge bg-danger";
            } else {
                $value->gradding = "E";
                $value->badge = "Very Less";
                $value->class_badge = "badge bg-danger";
            }
        }
        // dd($persentase);
        $bulan = $split[0];
        $tahun = $split[1];

        return view('pages.laporan_kpi.rekap_index', compact('transaksi_kpi', 'bulan', 'tahun'));
    }

    public function laporan_kpi_export(Request $request)
    {


        // dd($request->all());
        $id = $request->get('id');
        $bulan = $request->get('bulan');
        $tahun = $request->get('tahun');
        $jabatan_id = $id['jabatan_id'];
        $id = $id['id'];

        $karyawan = DB::table('users')
            ->where('users.is_aktif', 0)
            ->select('users.name', 'users.id')
            ->get();

        $total_skor = $total_bobot = $persentase = 0;
        if (empty($bulan)) {
            $data_kpi = [];
            $bulan =  $tahun =  $gradding = $nilai_huruf = '';
            $error = 'Silahkan Pilih Bulan Dahulu';


            return view('pages.laporan_kpi.index', compact('data_kpi', 'bulan', 'tahun', 'karyawan', 'error', 'total_skor', 'total_bobot', 'persentase', 'gradding', 'nilai_huruf'));
        }

        $karyawan_ = DB::table('users')
            ->where('users.id', '=', $id)
            ->join('jabatan', 'jabatan.jabatan_id', '=', 'users.jabatan_id')
            ->select('users.*', 'jabatan.nama_jabatan', 'jabatan.jabatan_id')
            ->first();

        $data_kpi = DB::table('transaksi_detail_kpi')
            ->join('transaksi_kpi', 'transaksi_kpi.transaksi_kpi_id', '=', 'transaksi_detail_kpi.transaksi_kpi_id')
            ->join('jabatan', 'jabatan.jabatan_id', '=', 'transaksi_kpi.jabatan_id')
            ->join('data_kpi', 'data_kpi.data_kpi_id', '=', 'transaksi_detail_kpi.data_kpi_id')
            ->where('jabatan.jabatan_id', '=', $jabatan_id)
            ->where('transaksi_kpi.karyawan_id', '=', $id)
            ->where('transaksi_kpi.bulan', '=', $bulan)
            ->where('transaksi_kpi.TAHUN', '=', $tahun)
            ->select(
                'data_kpi.nama_indikator',
                'data_kpi.nilai_0',
                'data_kpi.nilai_5',
                'data_kpi.nilai_10',
                'data_kpi.nilai_15',
                'data_kpi.data_kpi_id',
                'data_kpi.bobot',
                'transaksi_detail_kpi.nilai'
            )
            ->get();

        foreach ($data_kpi as $key => $value) {
            $value->skor = $value->bobot * $value->nilai;
            $value->bobot_ = $value->bobot * 15;
            $value->class = $value->nilai <= 5 ? "highlight" : "";
            $total_skor += $value->skor;
            $total_bobot += $value->bobot_;
        }
        $persentase = $total_skor != 0 ? round($total_skor / $total_bobot * 100, 2) : 0;
        if ($persentase == 100) {
            $gradding = "A";
            $nilai_huruf = "Very good";
        } else if ($persentase <= 99 &&  $persentase >= 90) {
            $gradding = "B";
            $nilai_huruf = "Good";
        } else if ($persentase  <= 89 &&  $persentase >= 85) {
            $gradding = "C";
            $nilai_huruf = "Good Enough";
        } else if ($persentase >= 80 &&  $persentase <= 84) {
            $gradding = "D";
            $nilai_huruf = "Less";
        } else {
            $gradding = "E";
            $nilai_huruf = "Very Less";
        }
        // dd($persentase);
        $bulan = $bulan;
        $tahun = $tahun;



        // $pdf = PDF::loadview('pages.laporan_kpi.export', ['data_kpi' => $data_kpi, 'bulan' => $bulan, 'tahun' => $tahun, 
        // 'karyawan' => $karyawan, 'karyawan_' => $karyawan_, 'total_skor' => $total_skor, 'total_bobot' => $total_bobot, 
        // 'persentase' => $persentase, 'gradding' => $gradding, 'nilai_huruf' => $nilai_huruf]);

        $html = View::make('pages.laporan_kpi.export', [
            'data_kpi' => $data_kpi, 'bulan' => $bulan, 'tahun' => $tahun,
            'karyawan' => $karyawan, 'karyawan_' => $karyawan_, 'total_skor' => $total_skor, 'total_bobot' => $total_bobot,
            'persentase' => $persentase, 'gradding' => $gradding, 'nilai_huruf' => $nilai_huruf
        ]);

        $pdf = new Dompdf();
        $pdf->loadHtml($html);
        $pdf->setPaper('a4', 'landscape');
        $pdf->render();

        $output = $pdf->output();
        $response = Response::make($output, 200);
        $response->header('Content-Type', 'application/pdf');
        $response->header('Content-Disposition', 'inline; filename="laporan_transaksi.pdf"');

        return $response;
        //mendownload laporan.pdf
        // return $data->download('laporan.pdf');   
        // return $pdf->download('invoice.pdf');
    }
}
