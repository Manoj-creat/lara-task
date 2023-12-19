<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{

    public function __construct()
    {
        // parent :: __construct();

    }

    public function index()
    {
        return view('users');
    }

    public function saveData(Request $req): JsonResponse
    {
        try {
            $exampleModel = new User();
            $exampleModel->name = $req->input('name');
            $exampleModel->email = $req->input('email');
            $exampleModel->phoneNo = $req->input('phoneNo');
            $exampleModel->discription = $req->input('textarea1');
            $exampleModel->roleId = $req->input('role');
            if ($req->hasFile('image')) {
                $file = $req->file('image');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('uploads', $fileName, 'public');
                $exampleModel->image = 'uploads/' . $fileName;
            }
            $response = $exampleModel->save();
            return response()->json(['message' => 'Data saved successfully']);
        } catch (\Exception $e) {
            Log::error($e);
            throw $e;
            return response()->json(['error' => "internal server error"], 500);
        }
    }

    public function getusers(Request $request){
            $data = User::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('imageUrl',function($row){
                    if($row->image){

                    return '<img src="'.asset('storage/'.$row->image).'" width="100px;">';
                    }else{
                        return 'N/A';
                    }
                })
                ->addColumn('action', function($row){
                    return '';
            })
            ->rawColumns(['action','imageUrl'])
       ->make(true);
    }
}
