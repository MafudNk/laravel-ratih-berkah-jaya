<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index() 
    {
        $data_user = [];
        $data_penilaian = [];
        $tahun = Date('Y');
        for ($i=1; $i < 13; $i++) { 
            $jumlah_user = User::where('is_aktif', 0)->count();
            $transaksi_kpi = DB::table('transaksi_kpi')->whereRaw("bulan = $i and TAHUN = $tahun")->select('transaksi_kpi.transaksi_kpi_id')->count();
            $data_user[] = $jumlah_user;
            $data_penilaian[] = isset($transaksi_kpi) ? $transaksi_kpi : 0; 
        }
        
        // dd($data_penilaian);


        // ->where()
        return view('dashboard', ["data_user" => $data_user, "data_penilaian" => $data_penilaian]);
    }
}
