<?php

namespace App\Http\Controllers\masterData;

use App\Models\Institusi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreInstitusiRequest;
use App\Http\Requests\UpdateInstitusiRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request as FacadesRequest;

class InstitusiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Institusi::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    if (Auth::user()->role == "Admin") {
                        $actionBtn = '
                        <div class="row text-center justify-content-center">';
                        $actionBtn .= '
                            <button id="btn-edit" class="btn btn-warning btn-sm mr-1 my-1"  onclick="edit(' . $row->id . ')"><i class="fas fa-edit"></i></button>
                            <button id="btn-delete" onclick="hapus(' . $row->id . ')" class="btn btn-danger btn-sm mr-1 my-1" value="' . $row->id . '" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fas fa-trash"></i></button>
                        </div>';
                    } else {
                        $actionBtn = '-';
                    }
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('pages.masterData.institusi.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreInstitusiRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama' => 'required|unique:institusi,nama,NULL,id,deleted_at,NULL',
            ],
            [
                'nama.required' => "Nama Institusi Tidak Boleh Dikosongkan",
                'nama.unique' => "Nama Institusi Sudah Terdaftar",
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        Institusi::create($request->all());
        return response()->json(['status' => 'success']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Institusi  $institusi
     * @return \Illuminate\Http\Response
     */
    public function show(Institusi $institusi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Institusi  $institusi
     * @return \Illuminate\Http\Response
     */
    public function edit(Institusi $institusi)
    {
        return $institusi;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateInstitusiRequest  $request
     * @param  \App\Models\Institusi  $institusi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Institusi $institusi)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama' => 'required|unique:institusi,nama,' . $institusi->nama . ',nama,deleted_at,NULL',
            ],
            [
                'nama.required' => "Nama Institusi Tidak Boleh Dikosongkan",
                'nama.unique' => "Nama Institusi Sudah Terdaftar",
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $institusi->update($request->all());
        return response()->json(['status' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Institusi  $institusi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Institusi $institusi)
    {
        $institusi->delete();
        return response()->json(['status' => 'success']);
    }
}
