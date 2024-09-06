<?php

namespace App\Http\Controllers\masterData;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Institusi;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $role = User::groupBy('role')->pluck('role')->toArray();
        if ($request->ajax()) {
            $data = Profile::with('user')->orderBy('created_at', 'DESC');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('username', function ($row) {
                    return $row->user->username;
                })
                ->addColumn('institusi', function ($row) {
                    return $row->institusi->nama;
                })
                ->addColumn('role', function ($row) {
                    if ($row->user->role == 'Admin') {
                        return '<span class="badge badge-primary">Admin</span>';
                    } else if ($row->user->role == 'Sub Admin') {
                        return '<span class="badge badge-warning">Sub Admin</span>';
                    } else if ($row->user->role == 'Surveyor') {
                        return '<span class="badge badge-success">Surveyor</span>';
                    } else if ($row->user->role == 'Institusi') {
                        return '<span class="badge badge-info">Institusi/Universitas</span>';
                    } else if ($row->user->role == 'Supervisor') {
                        return '<span class="badge badge-secondary">Supervisor/DPL</span>';
                    }
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '
                        <div class="row text-center justify-content-center">';
                    $actionBtn .= '
                            <a href="' . route('profile.show', $row->id) . '" class="btn btn-info btn-sm mr-1 my-1" data-toggle="tooltip" data-placement="top" title="Lihat"><i class="fas fa-eye"></i></a>
                            <a href="' . route('profile.edit', $row->id) . '" id="btn-edit" class="btn btn-warning btn-sm mr-1 my-1" data-toggle="tooltip" data-placement="top" title="Ubah"><i class="fas fa-edit"></i></a>
                            <button id="btn-delete" onclick="hapus(' . $row->id . ')" class="btn btn-danger btn-sm mr-1 my-1" value="' . $row->id . '" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fas fa-trash"></i></button>
                        </div>';
                    return $actionBtn;
                })

                ->filter(function ($query) use ($request) {
                    if ($request->search != '') {
                        $query->whereHas('user', function ($query) use ($request) {
                            $query->where("users.username", "LIKE", "%$request->search%")
                                ->orWhere("profiles.nama_lengkap", "LIKE", "%$request->search%");
                        });
                    }

                    if (!empty($request->role)) {
                        $query->whereHas('user', function ($query) use ($request) {
                            $query->where('users.role', $request->role);
                        });
                    }
                })
                ->rawColumns(['username', 'role', 'action'])
                ->make(true);
        }
        return view('pages.masterData.profile.index', compact('role'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $data = [
            'users' => User::doesntHave('profile')->get(),
            'institusi' => Institusi::latest()->get(),
        ];
        return view('pages.masterData.profile.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProfileRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'user_id' => ['required', Rule::unique('profiles')->withoutTrashed()],
                'institusi_id' => 'required',
                'nama_lengkap' => 'required',
                'jenis_kelamin' => 'required',
                'tempat_lahir' => 'required',
                'tanggal_lahir' => 'required',
                'alamat' => 'required',
                'provinsi' => 'required',
                'kabupaten_kota' => 'required',
                'kecamatan' => 'required',
                'desa_kelurahan' => 'required',
                'nomor_hp' => 'required',
            ],
            [
                'user_id.required' => 'Nama Pengguna tidak boleh kosong',
                'user_id.unique' => 'Nama Pengguna sudah terdaftar',
                'institusi_id.required' => 'Institusi tidak boleh kosong',
                'institusi_id.unique' => 'Institusi sudah terdaftar',
                'nama_lengkap.required' => 'Nama Lengkap tidak boleh kosong',
                'jenis_kelamin.required' => 'Jenis Kelamin tidak boleh kosong',
                'tempat_lahir.required' => 'Tempat Lahir tidak boleh kosong',
                'tanggal_lahir.required' => 'Tanggal Lahir tidak boleh kosong',
                'alamat.required' => 'Alamat tidak boleh kosong',
                'provinsi.required' => 'Provinsi tidak boleh kosong',
                'kabupaten_kota.required' => 'Kabupaten/Kota tidak boleh kosong',
                'kecamatan.required' => 'Kecamatan tidak boleh kosong',
                'desa_kelurahan.required' => 'Desa/Kelurahan tidak boleh kosong',
                'nomor_hp.required' => 'Nomor HP tidak boleh kosong',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $data = [
            'user_id' => $request->user_id,
            'institusi_id' => $request->institusi_id,
            'nama_lengkap' => $request->nama_lengkap,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' =>  date("Y-m-d", strtotime($request->tanggal_lahir)),
            'alamat' => $request->alamat,
            'provinsi' => $request->provinsi,
            'kabupaten_kota' => $request->kabupaten_kota,
            'kecamatan' => $request->kecamatan,
            'desa_kelurahan' => $request->desa_kelurahan,
            'nomor_hp' => $request->nomor_hp,
            'email' => $request->email,
        ];

        Profile::create($data);

        return response()->json(['success' => 'Success']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function show(Profile $profile)
    {
        return view('pages.masterData.profile.show', compact('profile'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function edit(Profile $profile)
    {
        $data = [
            'profile' => Profile::select('*', DB::raw('DATE_FORMAT(tanggal_lahir, "%d/%m/%Y") AS tanggal_lahir'))->where('id', '=', $profile->id)->first(),
            'users' => User::all(),
            'institusi' => Institusi::latest()->get(),
        ];
        return view('pages.masterData.profile.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProfileRequest  $request
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Profile $profile)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'user_id' => ['required', Rule::unique('profiles')->ignore($profile->id)->withoutTrashed()],
                'institusi_id' => 'required',
                'nama_lengkap' => 'required',
                'jenis_kelamin' => 'required',
                'tempat_lahir' => 'required',
                'tanggal_lahir' => 'required',
                'alamat' => 'required',
                'provinsi' => 'required',
                'kabupaten_kota' => 'required',
                'kecamatan' => 'required',
                'desa_kelurahan' => 'required',
                'nomor_hp' => 'required',
            ],
            [
                'user_id.required' => 'Nama Pengguna tidak boleh kosong',
                'user_id.unique' => 'Nama Pengguna sudah terdaftar',
                'institusi_id.required' => 'Institusi tidak boleh kosong',
                'institusi_id.unique' => 'Institusi sudah terdaftar',
                'nama_pengguna.unique' => 'Nama Pengguna sudah terdaftar',
                'nama_lengkap.required' => 'Nama Lengkap tidak boleh kosong',
                'jenis_kelamin.required' => 'Jenis Kelamin tidak boleh kosong',
                'tempat_lahir.required' => 'Tempat Lahir tidak boleh kosong',
                'tanggal_lahir.required' => 'Tanggal Lahir tidak boleh kosong',
                'alamat.required' => 'Alamat tidak boleh kosong',
                'provinsi.required' => 'Provinsi tidak boleh kosong',
                'kabupaten_kota.required' => 'Kabupaten/Kota tidak boleh kosong',
                'kecamatan.required' => 'Kecamatan tidak boleh kosong',
                'desa_kelurahan.required' => 'Desa/Kelurahan tidak boleh kosong',
                'nomor_hp.required' => 'Nomor HP tidak boleh'
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $data = [
            // 'user_id' => $request->user_id,
            'institusi_id' => $request->institusi_id,
            'nama_lengkap' => $request->nama_lengkap,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' =>  date("Y-m-d", strtotime($request->tanggal_lahir)),
            'alamat' => $request->alamat,
            'provinsi' => $request->provinsi,
            'kabupaten_kota' => $request->kabupaten_kota,
            'kecamatan' => $request->kecamatan,
            'desa_kelurahan' => $request->desa_kelurahan,
            'nomor_hp' => $request->nomor_hp,
            'email' => $request->email,
        ];

        $profile->update($data);

        return response()->json(['success' => 'Success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profile $profile)
    {
        $profile->delete();
        return response()->json([
            'res' => 'success'
        ]);
    }
}
