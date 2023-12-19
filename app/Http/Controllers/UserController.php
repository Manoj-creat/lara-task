<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserController extends Controller {

    public function __construct() {
        // parent :: __construct();

    }
    public function index()
    {
        return view('users');
    }

    public function saveData(Request $req) { 
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
        // Log the exception
        \Log::error($e);

        return response()->json(['error' => "internal server error"], 500);
    }
    //    if($response) {
    //     $data =DB::table('Users')->select('*')->get();
    // //     print_r($data);die;
    //     return $data;
    //    }

    }
}