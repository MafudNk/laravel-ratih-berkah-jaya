<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class DepartemensController extends Controller
{
    public function index()
    {
        $departemens = DB::table('departemen')->get();

        return view('pages.departemen.index', compact('departemens'));
    }

    /**
     * Show form for creating user
     * 
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.departemen.create');
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
            $dep = Departemen::create([
                'departemen_nama' => $request->get('departemen_nama'),
            ]);

            return redirect()->route('departemens.index')
                ->withSuccess(__('Departemen created successfully.'));
        } catch (QueryException $e) {

            $errorMessage = $e->getMessage();
            /* Misalnya, memunculkan error ke pengguna */
            return redirect()->route('departemens.index')
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
        $departemen = Departemen::where('departemen_id', '=', $id)->first();
        // dd($departemen->departemen_nama);
        return view('pages.departemen.edit', [
            'data' => $departemen,
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
            'departemen_nama' => 'required',
        ]);
        // Ambil data pengguna dari database berdasarkan ID
        $departemen = Departemen::where('departemen_id', '=', $id)->first();
        if (!$departemen) {
            // Jika data tidak ditemukan, lakukan tindakan yang sesuai, seperti redirect atau memunculkan pesan error
            // return redirect()->back()->with('error', 'Data pengguna tidak ditemukan.');
            return redirect()->route('departemens.index')
                ->withErrors(['message' => 'Error, Data pengguna tidak ditemukan.']);
        }
        try {
            DB::table('departemen')
            ->where('departemen_id', $id)
            ->update([
                'departemen_nama' => $validatedData['departemen_nama'],
            ]);
            return redirect()->route('departemens.index')
                ->withSuccess(__("Departemen $departemen->departemen_nama updated successfully."));
        } catch (QueryException $e) {
            $errorMessage = $e->getMessage();
            /* Misalnya, memunculkan error ke pengguna */
            return redirect()->route('departemens.index')
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
            Departemen::where('departemen_id', $id)->delete();
            return redirect()->route('departemens.index')
                ->withSuccess(__("Departemen deleted successfully."));
        } catch (QueryException $e) {
            $errorMessage = $e->getMessage();
            /* Misalnya, memunculkan error ke pengguna */
            return redirect()->route('departemens.index')
                ->withErrors(['message' => 'Error Terjadi kesalahan.']);
        }
    }
}
