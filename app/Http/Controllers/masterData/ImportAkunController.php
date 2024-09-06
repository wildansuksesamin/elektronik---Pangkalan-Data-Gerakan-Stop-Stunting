<?php

namespace App\Http\Controllers\masterData;

use App\Http\Controllers\Controller;
use App\Imports\AkunImport;
use App\Models\Institusi;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class ImportAkunController extends Controller
{
    public function index()
    {
        $daftarInstitusi = Institusi::orderBy('nama', 'asc')->get();
        return view('pages.masterData.importAkun.index', compact(['daftarInstitusi']));
    }

    public function importData(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'file_akun' => 'required|mimes:xls,xlsx',
                'role' => 'required',
                'institusi_id' => 'required'
            ],
            [
                'file_akun.required' => "File Survey Tidak Boleh Dikosongkan",
                'file_akun.mimes' => "File Survey Harus Berupa File Excel",
                'role.required' => 'Role tidak boleh dikosongkan',
                'institusi_id.required' => 'Institusi tidak boleh dikosongkan'
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $role = $request->role;
        $institusi_id = $request->institusi_id;

        Excel::import(new AkunImport($role, $institusi_id), $request->file_akun);
        return response()->json([
            'res' => 'success'
        ]);
    }
}
