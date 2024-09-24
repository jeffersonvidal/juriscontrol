<?php

namespace App\Http\Controllers;

use App\Models\ExternalOffice;
use App\Models\Label;
use App\Models\Priority;
use App\Models\SystemStatus;
use App\Models\Task;
use App\Http\Controllers\Controller;
use App\Models\User;
use HelpersAdm;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    private $helperAdm;

    public function __construct(HelpersAdm $helpersAdm){
        $this->helperAdm = $helpersAdm;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::where('company_id', auth()->user()->company_id)
            ->with('label')
            ->orderBy('id', 'DESC')->get();
        $labels = Label::where('company_id', auth()->user()->company_id)->orderBy('name', 'ASC')->get();
        $externalOffices = ExternalOffice::where('company_id', auth()->user()->company_id)->orderBy('name', 'ASC')->get();
        $users = User::where('company_id', auth()->user()->company_id)->orderBy('name', 'ASC')->get();
        $systemStatus = SystemStatus::all();
        $priorities = Priority::all();

        
        //Carrega a view
        return view('tasks.index', ['tasks' => $tasks, 'labels' => $labels,
        'systemStatus' => $systemStatus, 'priorities' => $priorities, 'externalOffices' => $externalOffices,
        'users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        //
    }
}
