<?php

namespace App\Http\Controllers;

use App\Models\Fonctions;
use App\Models\Grades;
use App\Models\Services;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ConfigController extends Controller
{
     /**
      * Create new service
      * @param \Illuminate\Http\Request $request
      * @return \Illuminate\Http\JsonResponse|mixed
      */
     public function saveService(Request $request)
    {
         try {
            $data = $request->validate([
                "libelle"=>"required|string|unique:services,service_libelle",
                "created_by"=> "required|int",
            ]);
            $service = Services::create([
                "service_libelle"=> $data["libelle"],
                "created_by"=> $data["created_by"],
            ]);
            return response()->json([
                "status"=>"success",
                "datas"=>$service
            ]);
        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->all();
            return response()->json(['errors' => $errors ], 422);
        }

    }


    /**
     * Get all Service
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function allServices()
    {
        $services = Services::all();
        return response()->json([
            "status"=> "success",
            "services"=>$services
        ]);
    }

    /**
     * Save fonction
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function saveFonction(Request $request)
    {

        try {
           $data = $request->validate([
                "libelle"=>"required|string|min:4|unique:fonctions,fonction_libelle",
                "created_by"=>"required|int"
            ]);
            $fonction = Fonctions::create([
                "fonction_libelle"=> $data["libelle"],
                "created_by"=>(int)$data["created_by"],
            ]);
            return response()->json([
                "status"=>"success",
                "datas"=>$fonction
            ]);
            // Si la validation réussit, procédez à la logique de création de l'utilisateur ici
        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->all();
            return response()->json(['errors' => $errors ], 422);
        }

    }

    /**
     * Get All fonctions
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function allFonctions()
    {
        $fonctions = Fonctions::all();
        return response()->json([
            "status"=> "success",
            "fonctions"=>$fonctions
        ]);
    }

    /**
     * Save Grade
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function saveGrade(Request $request){
        try{
            $data = $request->validate([
                "libelle"=>"required|string|unique:grades,grade_libelle",
                "created_by"=> "required|int"
            ]);
            $grade = Grades::create([
                "grade_libelle"=> $data["libelle"],
                "created_by"=>$data["created_by"],
            ]);
            return response()->json([
                "status"=>"success",
                "datas"=>$grade
            ]);
        }
         catch (ValidationException $e) {
            $errors = $e->validator->errors()->all();
            return response()->json(['errors' => $errors ], 422);
        }

    }

    public function allGrades(){
        $grades = Grades::all();
        return response()->json([
            "status"=>"success",
            "grades"=>$grades
        ]);
    }
}
