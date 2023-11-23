<?php

namespace App\Http\Controllers;

use App\Models\Agents;
use App\Models\Services;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AgentController extends Controller
{

    /**
     * all agents
     * @return \Illuminate\Http\JsonResponse
     */
    public function all(): JsonResponse
    {
        $agents = Agents::with('fonction')
                ->with('service')
                ->with('grade')
                ->with('user')
                ->get();
        return response()->json([
            "status"=>"success",
            "agents"=>$agents
        ]);
    }

    /**
     * create new agent
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try
        {
             $data = $request->validate([
                'matricule' => 'required|string',
                'nom' => 'required|string',
                'sexe' => 'required|string|max:1',
                'telephone' => 'required|string|min:10',
                'adresse' => 'required|string',
                'fonction_id'=>'required|int|exists:fonctions,id',
                'service_id'=>'required|int|exists:services,id',
                'grade_id'=>'required|int|exists:grades,id',
                'created_by'=> 'required|int|exists:users,id',
            ]);
            $agent = Agents::create([
                'agent_matricule' => $data['matricule'],
                'agent_nom' => $data['nom'],
                'agent_sexe' => $data['sexe'],
                'agent_telephone' => $data['telephone'],
                'agent_adresse' => $data['adresse'],
                'fonction_id'=>$data['fonction_id'],
                'grade_id'=>$data['grade_id'],
                'service_id'=>$data['service_id'],
                'created_by'=>$data['created_by'],
            ]);
            return response()->json([
                "status"=>"success",
                "agent"=>$agent
            ]);
        }
        catch (ValidationException $e) {
            $errors = $e->validator->errors()->all();
            return response()->json(['errors' => $errors ], 422);
        }


    }

    /**
     * Assign un agent a un compte utilisateur
     * @param \Illuminate\Http\Request $request
     * @return JsonResponse|mixed
     */
    public function assignAccount(Request $request){
        try{
            $data = $request->validate([
                'agent_id'=>'required|int|exists:agents,id',
                'user_id'=>'required|int|exists:users,id',
            ]);
             // Recherche de l'utilisateur à mettre à jour par son ID
            $user = User::findOrFail($data['user_id']);
            // Mise à jour des attributs de l'utilisateur avec les données validées
            $user->update([
                'agent_id'=> $data['agent_id'],
            ]);
            return response()->json(['user' => $user], 200);
        }
        catch (ValidationException $e) {
            $errors = $e->validator->errors()->all();
            return response()->json(['errors' => $errors ], 422);
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Agents  $agents
     * @return \Illuminate\Http\Response
     */
    public function edit(Agents $agents)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Agents  $agents
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Agents $agents)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Agents  $agents
     * @return \Illuminate\Http\Response
     */
    public function delete(int $id)
    {
        //
    }




}