<?php

namespace App\Http\Controllers;

use App\Models\Agents;
use App\Models\Services;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
            "datas"=>$agents
        ]);
    }

    /**
     * create new agent
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data = $request->validate([
            'matricule' => 'required|string',
            'nom' => 'required|string',
            'sexe' => 'required|string|max:1',
            'telephone' => 'required|string|min:10',
            'adresse' => 'required|string',
            'fonction_id'=>'required|int',
            'service_id'=>'required|int',
            'grade_id'=>'required|int',
            'created_by'=> 'required|int',
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
            "datas"=>$agent
        ]);
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