<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{

    public function createProject(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'duration' => 'required',
        ]);
        
        Project::create([
            'name' => $request->name,
            'description' => $request->description,
            'duration' => $request->duration,
            'student_id' => auth()->user()->id
        ]);

        return response()->json([
            'status' => 1,
            'message' => 'Project has been created'
        ]);
    }

    public function listProject()
    {
        $listProjects = Project::where('student_id', auth()->user()->id)->get();
        
        return response()->json([
            'status' => 1,
            'message' => 'Got all projects successfully',
            'data' => $listProjects
        ]);
    }

    public function singleProject($id)
    {

        if(Project::where(['id' => $id, 'student_id' => auth()->user()->id])->exists()) {

            $project = Project::find($id);

            return response()->json([
                'status' => 1,
                'message' => 'Got project successfully',
                'data' => $project
            ]);
        }else {
            return response()->json([
                'status' => 0,
                'message' => 'Project not found', 
            ], 404);
        }
    }

    public function deleteProject($id)
    {
        if(Project::where(['id' => $id, 'student_id' => auth()->user()->id])->exists()) {

            Project::destroy($id);

            return response()->json([
                'status' => 1,
                'message' => 'Project deleted successfully',
            ]);
        }else {

            return response()->json([
                'status' => 0,
                'message' => 'Project not found',
            ]);
        }
    } 
}
