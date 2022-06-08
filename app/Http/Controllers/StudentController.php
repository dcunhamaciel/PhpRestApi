<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Models\Student;
use App\Http\Requests\StudentRequest;

class StudentController extends Controller
{
    public function getAllStudents(): JsonResponse
    {
        $students = Student::orderBy('id')->get();

        $httpStatusCode = empty($students) 
            ? Response::HTTP_NO_CONTENT 
            : Response::HTTP_OK;

        return response()->json($students, $httpStatusCode);
    }
  
    public function createStudent(StudentRequest $request): JsonResponse
    {       
        $student = new Student;
        $student->name = $request->name;
        $student->course = $request->course;
        $student->save();

        return response()->json(["message" => "Student record created"], Response::HTTP_CREATED);
    }
  
    public function getStudent(int $id): JsonResponse
    {
        $student = Student::find($id);

        if (empty($student)) {            
            return response()->json(["message" => "Student not found"], Response::HTTP_NOT_FOUND);
        }

        return response()->json($student, Response::HTTP_OK);
    }
  
    public function updateStudent(StudentRequest $request, int $id): JsonResponse
    {       
        $student = Student::find($id);

        if (empty($student)) {
            return response()->json(["message" => "Student not found"], Response::HTTP_NOT_FOUND);
        }

        $student->name = $request->name;
        $student->course = $request->course;
        $student->save();

        return response()->json(["message" => "Student updated successfully"], Response::HTTP_OK);
    }
  
    public function deleteStudent(int $id): JsonResponse
    {
        $student = Student::find($id);

        if (empty($student)) {
            return response()->json(["message" => "Student not found"], Response::HTTP_NOT_FOUND);
        }

        $student->delete();

        return response()->json(["message" => "Student deleted"], Response::HTTP_ACCEPTED);        
    }
}
