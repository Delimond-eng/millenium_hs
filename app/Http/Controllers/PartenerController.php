<?php

namespace App\Http\Controllers;

use App\Imports\AgentImportClass;
use App\Models\Partener;
use App\Models\PartenerAgent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class PartenerController extends Controller
{
    /**
     * CREATE PARTENER & IMPORT AGENT FROM EXCEL
     * @author GASTON DELIMOND
     * @param Request $request
     * @return JsonResponse
    */
    public function createPartener(Request $request): JsonResponse
    {
        try {
            $data = $request->validate([
                'partener_nom' => 'required|string',
                'partener_adresse' => 'required|string',
                'partener_contact' => 'required|string',
                'hopital_id' => 'required|int|exists:hopitals,id',
                'created_by' => 'required|int|exists:users,id',
                'fichier_agent' => 'required|file:xlsx,xls',
            ]);
            $partener = Partener::create($data);
            if (isset($partener)) {
                $agentImport = new AgentImportClass($partener->id, $data['hopital_id'], $data['created_by']);
                Excel::import($agentImport, $request->file('fichier_agent'));
                return response()->json([
                    "status"=>"success",
                    "partener"=>$partener,
                ]);
            }
        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->all();
            return response()->json(['errors' => $errors]);
        } catch (\ErrorException | \Exception $e) {
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    /**
     * IMPORT AGENT FROM EXCEL ONLY
     * @author GASTON DELIMOND
     * @param Request $request
     * @return JsonResponse
     */

    public function importPartenerAgentFromExcel(Request $request):JsonResponse
    {
        try {
            $data = $request->validate([
                'partener_id' => 'required|string',
                'hopital_id' => 'required|int|exists:hopitals,id',
                'created_by' => 'required|int|exists:users,id',
                'fichier_agent' => 'required|file:xlsx,xls',
            ]);
            $agentImport = new AgentImportClass($data['partener_id'], $data['hopital_id'], $data['created_by']);
            Excel::import($agentImport, $request->file('fichier_agent'));
            return response()->json([
                "status"=>"success",
                "message"=>"Excel data imported successfully !"
            ]);
        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->all();
            return response()->json(['errors' => $errors]);
        } catch (\ErrorException | \Exception $e) {
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    /**
     * Voir la Liste des Entreprises conventionnées et leurs agents respectifs
     * @param int $hopitalId
     * @return JsonResponse
     *@author Gaston Delimond
     */
    public function viewAllParteners(int $hopitalId):JsonResponse
    {
        $parteners = Partener::with('hopital')
            ->with('agents')
            ->where('hopital_id', $hopitalId)
            ->get();
        return response()->json([
            "status"=>"success",
            "parteners" => $parteners
        ]);
    }


    /**
     * Search & match partener data
     * @param Request $request
     * @return JsonResponse
     * @author Gaston Delimond
     * @DateTime 07/2/2024 07:50
     */
    public function search(Request $request): JsonResponse
    {
        $query = $request->input('query');
        $results = PartenerAgent::with('partener')->where('agent_num_convention', '=',$query)->get();
        return response()->json($results);
    }
}
