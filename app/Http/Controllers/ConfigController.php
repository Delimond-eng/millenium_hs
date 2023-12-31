<?php

namespace App\Http\Controllers;

use App\Models\ExamenLabo;
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
                "created_by"=> "required|int",
                'hopital_id'=> 'required|int|exists:hopitals,id',
                'emplacement_id'=> 'required|int|exists:hopital_emplacements,id',

            ]);
            $service = Services::create([
                "service_libelle"=> $data["libelle"],
                "service_description"=> $data["description"],
                "created_by"=> $data["created_by"],
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
                "created_by"=>"required|int",
                'hopital_id'=> 'required|int|exists:hopitals,id',
            ]);
            $fonction = Fonctions::create([
                "fonction_libelle"=> $data["libelle"],
                "created_by"=>$data["created_by"],
                "hopital_id"=>$data['hopital_id']
            ]);
            return response()->json([
                "status"=>"success",
                "datas"=>$fonction
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
     * Save Grade
     * @param Request $request
     * @return JsonResponse
     */
    public function saveGrade(Request $request):JsonResponse{
        try{
            $data = $request->validate([
                "libelle"=>"required|string",
                "created_by"=> "required|int",
                'hopital_id'=> 'required|int|exists:hopitals,id',
            ]);
            $grade = Grades::create([
                "grade_libelle"=> $data["libelle"],
                "created_by"=>$data["created_by"],
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
     * Examen configuration
     * @param Request $request
     * @return JsonResponse
     */
    public function saveExamenLabo(Request $request):JsonResponse{
        try{
            $data = $request->validate([
                "libelle"=>"required|string",
                "prix"=> "required|string",
                "devise"=> "nullable|string",
                "description"=> "nullable|string",
                'hopital_id'=> 'required|int|exists:hopitals,id',
                'emplacement_id'=> 'required|int|exists:hopital_emplacements,id',
                'created_by'=> 'required|int|exists:users,id',
                'labo_id'=>'required|int|exists:laboratoires,id'
            ]);
            $result = ExamenLabo::create([
                "examen_labo_libelle"=> $data["libelle"],
                "examen_labo_prix"=> $data["prix"],
                "examen_labo_prix_devise"=> $data["devise"],
                "examen_labo_description"=> $data["description"],
                "labo_id"=>$data["labo_id"],
                "created_by"=>$data["created_by"],
                "hopital_id"=>$data["hopital_id"],
                "hopital_emplacement_id"=>$data["emplacement_id"],
            ]);
            return response()->json([
                "status"=>"success",
                "datas"=>$result
            ]);
        }
        catch (ValidationException $e) {
            $errors = $e->validator->errors()->all();
            return response()->json(['errors' => $errors ]);
        }
        catch (\Illuminate\Database\QueryException | \ErrorException $e){
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
        $services = Services::with('emplacement')->where('hopital_id', $hostoId)->get();
        $userRoles = UserRole::all();
        $locations = HopitalEmplacement::all()->where('hopital_id', $hostoId);
        $examens = ExamenLabo::with('emplacement')->where('hopital_id', $hostoId)->get();
        return response()->json([
            "status"=> "success",
            "configs"=>[
                "grades"=> $grades,
                "fonctions"=> $fonctions,
                "services"=>$services,
                "roles"=> $userRoles,
                "emplacements"=>$locations,
                "examens"=>$examens
            ]
        ]);
    }

    /**
     * GET ALL Examens for emplacement
     * @param int $emplacementId
     * @return JsonResponse
     */
    public function  viewExamens(int $emplacementId):JsonResponse{
        $examens = ExamenLabo::all()->where('hopital_emplacement_id', $emplacementId);
        return response()->json([
            "status"=> "success",
            "examens"=>$examens
        ]);
    }
}
