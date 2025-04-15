<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudentModel; 
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class StudentController extends Controller
{
    public function index()
    {
        $students = StudentModel::orderBy('lastname')->get(); 
        return view('student.list', compact('students'));
    }

    public function destroy(Request $request)
    {
        try {
            Log::info('Received Encrypted ID:', ['id' => $request->id]);

            $id = Crypt::decrypt($request->id);
            Log::info('Decrypted ID:', ['id' => $id]);

            $student = Student::find($id);

            if (!$student) {
                return response()->json(['error' => 'Student not found'], 404);
            }

            $student->delete();

            return response()->json(['success' => 'Student deleted successfully']);
        } catch (\Exception $e) {
            Log::error('Error deleting student:', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'Invalid student ID'], 400);
        }
        
    }
    public function update(Request $request, $id)
{
  
    $student = Student::findOrFail($id);

    
    $student->name = $request->name;
    $student->lastname = $request->lastname;
    $student->save();
    return redirect()->route('student.list')->with('success', 'Student updated successfully');
}
}
