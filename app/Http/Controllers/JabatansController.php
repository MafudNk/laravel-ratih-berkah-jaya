<?php

namespace App\Http\Controllers;

use App\Models\DataKpi;
use App\Models\Jabatans;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class JabatansController extends Controller
{
    public function index()
    {
        $jabatans = DB::table('jabatan')->get();

        return view('pages.jabatan.index', compact('jabatans'));
    }

    /**
     * Show form for creating user
     * 
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('pages.jabatan.create');
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
            $dep = Jabatans::create([
                'nama_jabatan' => $request->get('nama_jabatan'),
            ]);

            return redirect()->route('jabatans.index')
                ->withSuccess(__('Departemen created successfully.'));
        } catch (QueryException $e) {

            $errorMessage = $e->getMessage();
            /* Misalnya, memunculkan error ke pengguna */
            return redirect()->route('jabatans.index')
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
    public function edit(Jabatans $dep, $id)
    {


        $jabatan = Jabatans::where('jabatan_id', '=', $id)->first();
        return view('pages.jabatan.edit', [
            'data' => $jabatan,
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
            'nama_jabatan' => 'required',
        ]);
        // Ambil data pengguna dari database berdasarkan ID
        $departemen = Jabatans::where('jabatan_id', '=', $id)->first();
        if (!$departemen) {
            // Jika data tidak ditemukan, lakukan tindakan yang sesuai, seperti redirect atau memunculkan pesan error
            // return redirect()->back()->with('error', 'Data pengguna tidak ditemukan.');
            return redirect()->route('departemens.index')
                ->withErrors(['message' => 'Error, Data pengguna tidak ditemukan.']);
        }
        try {
            DB::table('jabatan')
                ->where('jabatan_id', $id)
                ->update([
                    'nama_jabatan' => $validatedData['nama_jabatan'],
                ]);
            return redirect()->route('jabatans.index')
                ->withSuccess(__("Jabatan $departemen->nama_jabatan updated successfully."));
        } catch (QueryException $e) {
            $errorMessage = $e->getMessage();
            /* Misalnya, memunculkan error ke pengguna */
            return redirect()->route('jabatans.index')
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
    public function destroy(Jabatans $dep, $id)
    {

        try {
            $departemen = Jabatans::where('jabatan_id', '=', $id)->delete();

            return redirect()->route('jabatans.index')
                ->withSuccess(__("Jabatan deleted successfully."));
        } catch (QueryException $e) {
            $errorMessage = $e->getMessage();
            /* Misalnya, memunculkan error ke pengguna */
            return redirect()->route('jabatans.index')
                ->withErrors(['message' => 'Error Terjadi kesalahan.']);
        }
    }

    public function destroy_data_kpi(Jabatans $dep, $id)
    {

        try {
            DB::table('data_detail_kpi')
                ->where('data_detail_kpi_id', $id)
                ->update([
                    'is_aktif' => 1,
                ]);
            return back()
                ->withSuccess(__("Jabatan deleted successfully."));
        } catch (QueryException $e) {
            $errorMessage = $e->getMessage();
            /* Misalnya, memunculkan error ke pengguna */
            return redirect()->route('jabatans.index')
                ->withErrors(['message' => 'Error Terjadi kesalahan.']);
        }
    }

    public function data_kpi(Jabatans $dep, $id)
    {


        $jabatan = Jabatans::where('jabatan_id', '=', $id)->first();
        $data_kpi = DB::table('data_detail_kpi')
            ->join('jabatan', 'jabatan.jabatan_id', '=', 'data_detail_kpi.jabatan_id')
            ->join('data_kpi', 'data_kpi.data_kpi_id', '=', 'data_detail_kpi.data_kpi_id')
            ->where('data_detail_kpi.is_aktif', '=', 0)
            ->where('jabatan.jabatan_id', '=', $id)
            ->select(
                'data_kpi.nama_indikator',
                'data_kpi.nilai_0',
                'data_kpi.nilai_5',
                'data_kpi.nilai_10',
                'data_kpi.nilai_15',
                'data_kpi.bobot',
                'data_detail_kpi.data_detail_kpi_id'
            )
            ->get();

        return view('pages.jabatan.data_kpi', [
            'data' => $jabatan,
            'data_kpi' => $data_kpi
        ]);
    }

    public function data_kpi_create(Jabatans $dep, $id)
    {
        $jabatan = Jabatans::where('jabatan_id', '=', $id)->first();
        $data_kpi = DataKpi::all();
        return view('pages.jabatan.data_kpi_create', [
            'data' => $jabatan,
            'data_kpi' => $data_kpi
        ]);
    }
    public function update_data_kpi(Request $request, $id)
    {

        $validatedData = $request->validate([
            'data_kpi_id' => 'required',
        ]);
        // dd($validatedData['data_kpi_id']);
        // Ambil data pengguna dari database berdasarkan ID

        try {

            DB::table('data_detail_kpi')->insert([
                'data_kpi_id' =>  $validatedData['data_kpi_id'],
                'jabatan_id' => $id,
            ]);

            return redirect()->route('jabatans.data_kpi', $id)
                ->withSuccess(__("Create successfully."));
        } catch (QueryException $e) {
            $errorMessage = $e->getMessage();
            /* Misalnya, memunculkan error ke pengguna */
            return redirect()->route('jabatans.data_kpi', $id)
                ->withErrors(['message' => "Error Terjadi kesalahan. $errorMessage"]);
        }
    }
}
