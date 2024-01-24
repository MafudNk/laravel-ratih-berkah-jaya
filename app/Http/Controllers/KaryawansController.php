<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Models\Jabatans;
use App\Models\Mutasi;
use App\Models\UnitKerja;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class KaryawansController extends Controller
{
    public function mutasi_index()
    {
        $mutasi = DB::table('mutasi_karyawan')
        ->join('unit_kerja', 'unit_kerja.unit_kerja_id', 'mutasi_karyawan.m_unker_id_old')
        ->join('departemen', 'departemen.departemen_id', 'unit_kerja.departemen_id')
        ->join('jabatan', 'jabatan.jabatan_id', 'mutasi_karyawan.jabatan_id_old')

        ->join('unit_kerja as unker', 'unker.unit_kerja_id', 'mutasi_karyawan.unker_id')
        ->join('departemen as dept', 'dept.departemen_id', 'unker.departemen_id')
        ->join('jabatan as jab', 'jab.jabatan_id', 'mutasi_karyawan.jabatan_id')
        
        ->join('users', 'users.id', 'mutasi_karyawan.karyawan_id')
        
        ->selectRaw('unit_kerja.unit_kerja_nama as unit_kerja_nama_lama , unker.unit_kerja_nama as unit_kerja_nama_baru, 
        departemen.departemen_nama as departemen_nama_baru, dept.departemen_nama as departemen_nama_lama, jabatan.nama_jabatan as nama_jabatan_lama, jab.nama_jabatan as nama_jabatan_baru,
        users.name')
        ->get();
        // dd($mutasi->toSql());
        return view('pages.mutasi.index', compact('mutasi'));
    }

    /**
     * Show form for creating user
     * 
     * @return \Illuminate\Http\Response
     */
    public function mutasi_create()
    {

        $jabatan = Jabatans::all();
        $unker = UnitKerja::all();
        $karyawan = User::where('users.is_aktif', 0)->get();
        return view('pages.mutasi.create', compact('karyawan','jabatan', 'unker') );
    }

    public function mutasi_get($selectedValue)
    {
        $data = User::where('id', $selectedValue)->first();
        $unker = UnitKerja::where('unit_kerja_id','!=', $data->unit_kerja_id)->get();
        $jabatan = Jabatans::where('jabatan_id', '!=', $data->jabatan_id)->get();

        // return view('pages.mutasi.index', compact('mutasi'));
        return response()->json(["unker" => $unker, "jabatan" =>$jabatan]);
    }
    /**
     * Store a newly created user
     * 

     * 
     * @return \Illuminate\Http\Response
     */
    public function mutasi_store(Mutasi $mutasi, Request $request)
    {
        // dd($request->all());
        try {
            $data = User::where('id', $request->get('karyawan_id'))->first();

            /* Mencoba membuat entri baru dalam database */
            $user = Mutasi::create([
                'tanggal_mutasi' => Date('Y-m-d'),
                'unker_id' => $request->get('unit_kerja_id'),
                'jabatan_id' => $request->get('jabatan_id'),
                'karyawan_id' => $request->get('karyawan_id'),	
                'jabatan_id_old' => $data->jabatan_id,
                'm_unker_id_old' => $data->unit_kerja_id,
            ]);

            $user = User::where('id', $request->get('karyawan_id'))
            ->update([
                'unit_kerja_id' => $request->get('unit_kerja_id'),
                'jabatan_id' => $request->get('jabatan_id'),
            ]);
            

            return redirect()->route('karyawans.mutasi_index')
                ->withSuccess(__('Updated created successfully.'));
        } catch (QueryException $e) {

            $errorMessage = $e->getMessage();
            /* Misalnya, memunculkan error ke pengguna */
            return redirect()->route('karyawans.mutasi_index')
                ->withErrors(['message' => "Terjadi kesalahan. $errorMessage"]);
        }
    }
        /* TERMINASI */
    public function terminasi_index()
    {
        $terminasi = DB::table('terminasi_karyawan')
        ->join('users', 'users.id', 'terminasi_karyawan.karyawan_id')
        ->selectRaw('
        users.name, tanggal_terminasi')
        ->get();
        // dd($mutasi->toSql());
        return view('pages.terminasi.index', compact('terminasi'));
    }

    /**
     * Show form for creating user
     * 
     * @return \Illuminate\Http\Response
     */
    public function terminasi_create()
    {

        $karyawan = User::where('is_aktif', 0)->get();
        return view('pages.terminasi.create', compact('karyawan') );
    }

    public function terminasi_store(Request $request)
    {
        // dd($request->all());
        try {
            $data = User::where('id', $request->get('karyawan_id'))->first();

            /* Mencoba membuat entri baru dalam database */
            DB::table('terminasi_karyawan')->insert([
                'tanggal_terminasi' => Date('Y-m-d'),
                'karyawan_id' => $request->get('karyawan_id'),
            ]);

            $user = User::where('id', $request->get('karyawan_id'))
            ->update([
                'is_aktif' => 1,
            ]);
            

            return redirect()->route('karyawans.terminasi_index')
                ->withSuccess(__('Updated created successfully.'));
        } catch (QueryException $e) {

            $errorMessage = $e->getMessage();
            /* Misalnya, memunculkan error ke pengguna */
            return redirect()->route('karyawans.terminasi_index')
                ->withErrors(['message' => "Terjadi kesalahan. $errorMessage"]);
        }
    }
}
