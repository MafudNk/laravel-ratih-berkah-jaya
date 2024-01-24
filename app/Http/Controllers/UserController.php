<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Jabatans;
use App\Models\UnitKerja;
use Illuminate\Database\QueryException;

class UserController extends Controller
{
    /**
     * Display all users
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::latest()->paginate(10);

        return view('pages.users.index', compact('users'));
    }

    /**
     * Show form for creating user
     * 
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $jabatan = Jabatans::all();
        $unker = UnitKerja::all();
        return view('pages.users.create', compact('jabatan', 'unker') );
    }

    /**
     * Store a newly created user
     * 
     * @param User $user
     * @param StoreUserRequest $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(User $user, Request $request)
    {
        try {
            /* Mencoba membuat entri baru dalam database */
            $user = User::create([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'username' => $request->get('username'),
                'password' => $request->get('password'),
                'karyawan_alamat' => $request->get('karyawan_alamat'),
                'karyawan_nik' => $request->get('karyawan_nik'),
                'karyawan_kelahiran' => $request->get('karyawan_kelahiran'),
                'karyawan_tanggal_lahir' => $request->get('karyawan_tanggal_lahir'),
                'karyawan_ktp' => $request->get('karyawan_ktp'),
                'jabatan_id' => $request->get('jabatan_id'),
                'unit_kerja_id' => $request->get('unit_kerja_id'),
                'karyawan_kota_id' => $request->get('karyawan_kota_id'),
                'karyawan_kecamatan_id' => $request->get('karyawan_kecamatan_id'),
            ]);

            return redirect()->route('users.index')
                ->withSuccess(__('User created successfully.'));
        } catch (QueryException $e) {

            $errorMessage = $e->getMessage();
            /* Misalnya, memunculkan error ke pengguna */
            return redirect()->route('users.index')
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
    public function show(User $user)
    {
        return view('users.show', [
            'user' => $user
        ]);
    }

    /**
     * Edit user data
     * 
     * @param User $user
     * 
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        // dd($user);
        $jabatan = Jabatans::all();
        $unker = UnitKerja::all();
        return view('pages.users.edit', [
            'user' => $user,
            'userRole' => $user->roles->pluck('name')->toArray(),
            'roles' => Role::latest()->get(),
            'jabatan' => $jabatan,
            'unker' => $unker
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
        
        // $validatedData = $request->validate([
        //     'name' => 'required',
        //     'email' => 'required|email:rfc,dns|unique:users,email,'.$id,
        //     'username' => 'required|unique:users,username,'.$id,
        //     'karyawan_alamat' => 'required',
        //     'karyawan_nik' => 'required',
        //     'karyawan_kelahiran' => 'required',
        //     'karyawan_tanggal_lahir' => 'required',
        //     'karyawan_ktp' => 'required',
        // ]);
        // dd($id);
        // Ambil data pengguna dari database berdasarkan ID
        $user = User::find($id);
        if (!$user) {
            // Jika data tidak ditemukan, lakukan tindakan yang sesuai, seperti redirect atau memunculkan pesan error
            // return redirect()->back()->with('error', 'Data pengguna tidak ditemukan.');
            return redirect()->route('users.index')
                ->withErrors(['message' => 'Error, Data pengguna tidak ditemukan.']);
        }
        try {
            $user->name = $request->get('name');
            $user->email = $request->get('email');
            $user->username = $request->get('username');
            $user->karyawan_alamat = $request->get('karyawan_alamat');
            $user->karyawan_nik = $request->get('karyawan_nik');
            $user->karyawan_kelahiran = $request->get('karyawan_kelahiran');
            $user->karyawan_tanggal_lahir = $request->get('karyawan_tanggal_lahir');
            $user->karyawan_ktp = $request->get('karyawan_ktp');
            $user->jabatan_id = $request->get('jabatan_id');
            $user->unit_kerja_id = $request->get('unit_kerja_id');
            $user->karyawan_kota_id = $request->get('karyawan_kota_id');
            $user->karyawan_kecamatan_id = $request->get('karyawan_kecamatan_id');
            if ($request->filled('password')) {
                // Jika input field 'password' diisi, lakukan update password
                $user->password = $request->password;
            }
            $user->save();
            
            $user->syncRoles($request->get('role'));

            return redirect()->route('users.index')
                ->withSuccess(__("User $user->name updated successfully."));
        } catch (QueryException $e) {
            $errorMessage = $e->getMessage();
            dd($errorMessage);
            /* Misalnya, memunculkan error ke pengguna */
            return redirect()->route('users.index')
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
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')
            ->withSuccess(__('User deleted successfully.'));
    }
}
