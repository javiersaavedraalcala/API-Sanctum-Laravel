<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Student;

use function PHPSTORM_META\map;

class StudentController extends Controller
{

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:students',
            'password' => 'required|confirmed', 
        ]);

        Student::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_no' => $request->phone_no,
        ]);

        return response()->json([
            'status' => 1,
            'message' => 'Student registered succesfully'
        ]);
    }
   
    public function profile()
    {
        return response()->json([
            'status' => 1,
            'message' => 'Student profile information',
            'data' => auth()->user()
        ]);
    }

    public function login(Request $request)
    {
        // validation
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        // check exist
        $student = Student::where('email', $request->email)->first();
        
        if(isset($student->id)) {
            if(Hash::check($request->password, $student->password)) {
                // create token 
                $token = $student->createToken('auth_token')->plainTextToken;
                return response()->json([
                    'status' => 1,
                    'message' => 'Student login successfully',
                    'access_token' => $token
                ]);
            }else {
                return response()->json([
                    'status' => 0,
                    'message' => 'Password didn\'t match'
                ]);
            }
        }else {
            return response()->json([
                'status' => 0,
                'message' => 'Student not found'
            ]);
        }

        // send response
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            'status' => 1,
            'message' => 'Student logged out successfully'
        ]);
    }
}
