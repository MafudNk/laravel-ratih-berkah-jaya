<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class UnitKerjaController extends Controller
{
    public function index()
    {
        $unit = DB::table('unit_kerja')
        ->join('departemen', 'departemen.departemen_id', '=', 'unit_kerja.departemen_id')
        ->select('unit_kerja.*', 'departemen.departemen_nama')
        ->get();

        return view('pages.unit_kerja.index', compact('unit'));
    }

    /**
     * Show form for creating user
     * 
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departemen = Departemen::all();
        return view('pages.unit_kerja.create', compact('departemen'));
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
            $unit = UnitKerja::create([
                'unit_kerja_nama' => $request->get('unit_kerja_nama'),
                'departemen_id' => $request->get('departemen_id'),
            ]);

            return redirect()->route('unit_kerjas.index')
                ->withSuccess(__('Departemen created successfully.'));
        } catch (QueryException $e) {

            $errorMessage = $e->getMessage();
            /* Misalnya, memunculkan error ke pengguna */
            return redirect()->route('unit_kerjas.index')
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
    public function edit(Departemen $dep, $id)
    {
        $unit = DB::table('unit_kerja')
        ->join('departemen', 'departemen.departemen_id', '=', 'unit_kerja.departemen_id')
        ->select('unit_kerja.*', 'departemen.departemen_nama')
        ->where('unit_kerja_id','=', $id)
        ->first();
        
        $departemen = Departemen::all();
        return view('pages.unit_kerja.edit', [
            'data' => $unit,
            'departemen' => $departemen
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
            'unit_kerja_nama' => 'required',
            'departemen_id' => 'required',
        ]);
        // Ambil data pengguna dari database berdasarkan ID
        $unit_kerja = UnitKerja::where('unit_kerja_id', '=', $id)->first();
        if (!$unit_kerja) {
            // Jika data tidak ditemukan, lakukan tindakan yang sesuai, seperti redirect atau memunculkan pesan error
            // return redirect()->back()->with('error', 'Data pengguna tidak ditemukan.');
            return redirect()->route('unit_kerjas.index')
                ->withErrors(['message' => 'Error, Data pengguna tidak ditemukan.']);
        }
        try {
            DB::table('unit_kerja')
            ->where('unit_kerja_id', $id)
            ->update([
                'unit_kerja_nama' => $validatedData['unit_kerja_nama'],
                'departemen_id' => $validatedData['departemen_id'],
            ]);
            return redirect()->route('unit_kerjas.index')
                ->withSuccess(__("Departemen $unit_kerja->unit_kerja_nama updated successfully."));
        } catch (QueryException $e) {
            $errorMessage = $e->getMessage();
            /* Misalnya, memunculkan error ke pengguna */
            return redirect()->route('unit_kerjas.index')
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
    public function destroy(Departemen $dep, $id)
    {
      
        try {
            $unit_kerja = UnitKerja::where('unit_kerja_id', '=', $id)->delete();
            return redirect()->route('unit_kerjas.index')
                ->withSuccess(__("Unit Kerja deleted successfully."));
        } catch (QueryException $e) {
            $errorMessage = $e->getMessage();
            /* Misalnya, memunculkan error ke pengguna */
            return redirect()->route('unit_kerjas.index')
                ->withErrors(['message' => 'Error Terjadi kesalahan.']);
        }
    }
}
