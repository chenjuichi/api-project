<?php

namespace App\Http\Controllers\Api;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProjectController extends Controller
{
    //
    // CREATE PROJECT API
    public function createProject(Request $request)
    {
        // validation
        $request->validate([
            "name" => "required",
            "description" => "required",
            "duration" => "required"
        ]);

        // student id + create data
        $student_id = auth()->user()->id;
        $student = auth()->user();                  //2021-05-11 add, get current login user 

        $project = new Project();

        //$project->student_id = $student_id;
        $project->name = $request->name;
        $project->description = $request->description;
        $project->duration = $request->duration;

        $project->save();

        //$student->projects()->sync([$project->id]); //2021-05-11, project attach with user
        $student->projects()->attach($project->id); //2021-05-11, project attach with user

        // send response
        return response()->json([
            "status" => 1,
            "message" => "Project has been created"
        ]);
    }

    // LIST PROJECT API
    public function listProject()
    {
        $student_id = auth()->user()->id;
        $student = auth()->user();                  //2021-05-11 add, get current login user 

        //$projects = Project::where("student_id", $student_id)->get(); //2021-05-11 mark,
        $projects = $student->projects()->where('student_id', $student_id)->get();  //for attach
        //$projects = $projects->data;
        
        return response()->json([
            "status" => 1,
            "message" => "Projects",
            //"data" => $projects[1]->name
            "data" => $projects
        ]);
    }

    // SINGLE PROJECT API
    public function singleProject($id)
    {
        //$student_id = auth()->user()->id;
        $student = auth()->user();                  //2021-05-11 add, get current login user 
        $ct = $student->projects()->count();

        if (Project::where(["id" => $id, 
            //"student_id" => $student_id
        ])->exists() && $ct != 0) {

            //$details = Project::where([
            //    "id" => $id,
            //    //"student_id" => $student_id
            //])->first();
            $details = $student->projects()->where('project_id', $id)->first();  //for attach

            return response()->json([
                "status" => 1,
                "message" => "Project detail",
                "data" => $details
            ]);
        }else{

            return response()->json([
                "status" => 0,
                "message" => "Student does not have this project or project not found!"
            ]);
        }
    }

    // DELETE PROJECT API
    public function deleteProject($id)
    {
        //$student_id = auth()->user()->id;
        $student = auth()->user();                  //2021-05-11 add, get current login user 

        if (Project::where([
            "id" => $id,
            //"student_id" => $student_id
        ])->exists()) {

            $student->projects()->toggle($id);  //2021-05-11, for attach

            $project = Project::where([
                "id" => $id,
                //"student_id" => $id
            ])->first();

            $project->delete();

            return response()->json([
                "status" => 1,
                "message" => "Project has been deleted successfully"
            ]);
        } else {
            return response()->json([
                "status" => 0,
                "message" => "Project not found"
            ]);
        }
    }    
}
