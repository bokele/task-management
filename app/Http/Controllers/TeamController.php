<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use App\Models\Project;
use App\Http\Requests\StoreTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use App\Models\TeamMember;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('teams.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $projects = Project::orderBy('name')->orderby('name', 'asc')->get();
        $users = User::orderBy('name')->orderby('name', 'asc')->get();
        return view('teams.create', compact('projects', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTeamRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTeamRequest $request)
    {
        if ($request->team_leader == $request->team_leader_assistance) {
            return redirect()->route('teams.create')->with(['message' => 'Team leader can not be the same as the team assistance', 'status' => 'danger']);
        }
        $code = '';
        do {
            $code = random_int(10000, 99999);
        } while (Project::where("code", $code)->first());

        $team = new Team();
        $team->created_by = auth()->id();
        $team->project_id = $request->project_name;
        $team->team_leader_id = $request->team_leader;
        $team->team_leader_assistance_id = $request->team_leader_assistance;
        $team->code = $code;
        $team->name = $request->team_name;
        $team->save();

        return redirect()->route('teams.index')->with(['message' => 'Team has been saved', 'status' => 'success']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function show(Team $team)
    {
        return view('teams.show', compact('team'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function edit(Team $team)
    {
        $projects = Project::orderBy('name')->orderby('name', 'asc')->get();
        $users = User::orderBy('name')->orderby('name', 'asc')->get();
        return view('teams.edit', compact('projects', 'users', 'team'));;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTeamRequest  $request
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTeamRequest $request, Team $team)
    {
        if ($request->team_leader == $request->team_leader_assistance) {
            return redirect()->route('teams.edit', $team->id)->with([['message' => 'Team leader can not be the same as the team assistance', 'status' => 'danger']]);
        }


        $team->created_by = auth()->id();
        $team->project_id = $request->project_name;
        $team->team_leader_id = $request->team_leader;
        $team->team_leader_assistance_id = $request->team_leader_assistance;
        $team->name = $request->team_name;
        $team->update();

        return redirect()->route('teams.index')->with(['message' => 'Team has been updated', 'status' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function destroy(Team $team)
    {
        $teamMemberExist = TeamMember::where('team_id', $team->id)->first();

        if ($teamMemberExist) {
            return redirect()->route('teams.index')->with(['message' => 'You can not delete this Team', 'status' => 'danger']);
        } else {
            $team->delete();
        }
        return redirect()->route('teams.index')->with(['message' => 'Team has been deleted', 'status' => 'success']);
    }
}
