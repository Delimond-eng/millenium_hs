<?php

namespace App\Http\Controllers;

use App\Models\Fonctions;
use App\Models\Grades;
use App\Models\HopitalEmplacement;
use App\Models\Services;
use App\Models\UserRole;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ConfigController extends Controller
{
     /**
      * Create new service
      * @param Request $request
      * @return JsonResponse
      */
     public function saveService(Request $request):JsonResponse
    {
         try {
            $data = $request->validate([
                "libelle"=>"required|string",
                "description"=>"nullable|string",
                "created_by"=> "nullable|int",
                'hopital_id'=> 'required|int|exists:hopitals,id',
                'emplacement_id'=> 'required|int|exists:hopital_emplacements,id',
            ]);
            $service = Services::create([
                "service_libelle"=> $data["libelle"],
                "service_description"=> $data["description"],
                "created_by"=> $data["created_by"]??null,
                'hopital_id'=>$data['hopital_id'],
                'hopital_emplacement_id'=>$data['emplacement_id'],
            ]);
            return response()->json([
                "status"=>"success",
                "datas"=>$service
            ]);
        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->all();
            return response()->json(['errors' => $errors ]);
        }
         catch (\Illuminate\Database\QueryException $e){
             return response()->json(['errors' => $e->getMessage() ]);
         }

    }


    /**
     * Get all Service
     * @return JsonResponse
     */
    public function allServices():JsonResponse
    {
        $services = Services::all();
        return response()->json([
            "status"=> "success",
            "services"=>$services
        ]);
    }

    /**
     * Save fonction
     * @param Request $request
     * @return JsonResponse
     */
    public function saveFonction(Request $request): JsonResponse
    {

        try {
           $data = $request->validate([
                "libelle"=>"required|string",
                "created_by"=>"nullable|int",
                'hopital_id'=> 'required|int|exists:hopitals,id',
            ]);
            $fonction = Fonctions::create([
                "fonction_libelle"=> $data["libelle"],
                "created_by"=>$data["created_by"] ?? 0,
                "hopital_id"=>$data['hopital_id']
            ]);
            return response()->json([
                "status"=>"success",
                "datas"=>$fonction
            ]);
            // Si la validation réussit, procédez à la logique de création de l'utilisateur ici
        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->all();
            return response()->json(['errors' => $errors ]);
        }
        catch (\Illuminate\Database\QueryException $e){
            return response()->json(['errors' => $e->getMessage() ]);
        }

    }

    /**
     * Save Grade
     * @param Request $request
     * @return JsonResponse
     */
    public function saveGrade(Request $request):JsonResponse{
        try{
            $data = $request->validate([
                "libelle"=>"required|string",
                "created_by"=> "nullable|int",
                'hopital_id'=> 'required|int|exists:hopitals,id',
            ]);
            $grade = Grades::create([
                "grade_libelle"=> $data["libelle"],
                "created_by"=>$data["created_by"] ?? 0,
                "hopital_id"=>$data["hopital_id"]
            ]);
            return response()->json([
                "status"=>"success",
                "datas"=>$grade
            ]);
        }
         catch (ValidationException $e) {
            $errors = $e->validator->errors()->all();
            return response()->json(['errors' => $errors ]);
        }
        catch (\Illuminate\Database\QueryException $e){
            return response()->json(['errors' => $e->getMessage() ]);
        }

    }


    /**
     * Save User roles
     * @param Request $request
     * @return JsonResponse
     */
    public function saveRole(Request $request):JsonResponse{
        try{
            $data = $request->validate([
                "libelle"=>"required|string",
                'hopital_id'=> 'required|int|exists:hopitals,id',
            ]);
            $role = UserRole::create([
                "role"=> $data["libelle"],
                "hopital_id"=>$data["hopital_id"]
            ]);
            return response()->json([
                "status"=>"success",
                "role"=>$role
            ]);
        }
        catch (ValidationException $e) {
            $errors = $e->validator->errors()->all();
            return response()->json(['errors' => $errors ]);
        }
        catch (\Illuminate\Database\QueryException $e){
            return response()->json(['errors' => $e->getMessage() ]);
        }

    }


    /**
     * GET ALL CONFIGS DATA
     * @param int $hostoId
     * @return JsonResponse
     */
    public function allConfigs(int $hostoId) :JsonResponse{
        $grades = Grades::all()->where('hopital_id', $hostoId);
        $fonctions = Fonctions::all()->where('hopital_id', $hostoId);
        $services = Services::all()->where('hopital_id', $hostoId);
        $userRoles = UserRole::all()->where('hopital_id', $hostoId);
        $locations = HopitalEmplacement::all()->where('hopital_id', $hostoId);
        return response()->json([
            "status"=> "success",
            "configs"=>[
                "grades"=> $grades,
                "fonctions"=> $fonctions,
                "services"=>$services,
                "roles"=> $userRoles,
                "emplacements"=>$locations
            ]
        ]);
    }
}
