<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Event;
use App\Models\ExternalOffice;
use App\Models\Label;
use App\Models\Priority;
use App\Models\SystemStatus;
use App\Models\Task;
use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use DB;
use Exception;
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
        $labels = Label::where('company_id', auth()->user()->company_id)->orderBy('name', 'ASC')->get();
        $externalOffices = ExternalOffice::where('company_id', auth()->user()->company_id)->orderBy('name', 'ASC')->get();
        $users = User::where('company_id', auth()->user()->company_id)->orderBy('name', 'ASC')->get();
        $systemStatus = SystemStatus::all();
        $priorities = Priority::all();
        $tasks = Task::with(['user', 'label', 'priority', 'externalOffice'])
        ->where('company_id', auth()->user()->company_id)
        ->orderByRaw("FIELD(status, 'completed'), delivery_date ASC")
        ->get(); //todos registros com status = completed vai para o fim da listagem


        //return view('tasks.index', compact('tasks'));
        
        //Carrega a view
        return view('tasks.index', ['tasks' => $tasks, 'labels' => $labels,
        'systemStatus' => $systemStatus, 'priorities' => $priorities, 'externalOffices' => $externalOffices,
        'users' => $users, 'helper' => new HelpersAdm,]);
    }

    /**Envia registros para popular tabela na index */
    public function getall()
    {
        $tasks = Task::where('company_id', auth()->user()->company_id)
        ->with(['label', 'user', 'externalOffice', 'priority'])
        ->orderByRaw("FIELD(status, 'completed'), id DESC")
        ->get(); //todos registros com status = completed vai para o fim da listagem

        $labels = Label::where('company_id', auth()->user()->company_id)->orderBy('name', 'ASC')->get();
        $externalOffices = ExternalOffice::where('company_id', auth()->user()->company_id)->orderBy('name', 'ASC')->get();
        $users = User::where('company_id', auth()->user()->company_id)->orderBy('name', 'ASC')->get();
        $systemStatus = SystemStatus::all();
        $priorities = Priority::all();
        $helper = new HelpersAdm;

        return response()->json([$tasks, $labels, $systemStatus, $priorities, $externalOffices, $users, $helper]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskRequest $request)
    {
        //Validar o formulário
        $request->validated();

        //garantir que salve nas duas tabelas do banco de dados
        DB::beginTransaction();

        try {
            //Model da tabela - campos a serem salvos
            $task = new Task();
            $task->title = $request->title;
            $task->description = $request->description;
            $task->delivery_date = $request->delivery_date;
            $task->end_date = $request->end_date;
            $task->responsible_id = $request->responsible_id;
            $task->author_id = $request->author_id;
            $task->client = $request->client;
            $task->process_number = $request->process_number;
            $task->court = $request->court;
            $task->priority = $request->priority;
            $task->label_id = $request->label_id;
            $task->status = $request->status;
            $task->source = $request->source;
            $task->company_id = $request->company_id;
            $task->save();
            //dd($task);

            /**Salva tarefa na tabela eventos */
            $event = new Event();
            $event->company_id = $request->company_id;
            $event->author_id = $request->author_id;
            $event->responsible_id = $request->responsible_id;
            $event->start = $request->end_date;
            $event->end = $request->delivery_date;
            $event->is_all_day = 1;
            $event->status = 0;
            $event->title = $request->title;
            $event->description = $request->description;
            $event->color = '#50301E';
            $event->event_id = $task->id;
            $event->save();

            //comita depois de tudo ter sido salvo
            DB::commit();

            //Redireciona para outra página após cadastrar com sucesso
            return response()->json( ['success' => 'Registro cadastrado com sucesso!']);
        } catch (Exception $e) {
            //Desfazer a transação caso não consiga cadastrar com sucesso no BD
            DB::rollBack();

            //Redireciona para outra página se der erro
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        $tasks = Task::where('company_id', auth()->user()->company_id)
            ->with('label')
            ->orderBy('id', 'DESC')->get();
        $labels = Label::where('company_id', auth()->user()->company_id)->orderBy('name', 'ASC')->get();
        $externalOffices = ExternalOffice::where('company_id', auth()->user()->company_id)->orderBy('name', 'ASC')->get();
        $users = User::where('company_id', auth()->user()->company_id)->orderBy('name', 'ASC')->get();
        $systemStatus = SystemStatus::all();
        $priorities = Priority::all();
        
        return response()->json([$tasks, $labels, $systemStatus, $priorities, $externalOffices, $users]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskRequest $request, Task $task)
    {
        //Validar o formulário
        $request->validated();

        //garantir que salve nas duas tabelas do banco de dados
        DB::beginTransaction();

        try {
            //Model da tabela - campos a serem salvos
            $task->title = $request->title;
            $task->description = $request->description;
            $task->delivery_date = $request->delivery_date;
            $task->end_date = $request->end_date;
            $task->responsible_id = $request->responsible_id;
            $task->author_id = $request->author_id;
            $task->client = $request->client;
            $task->process_number = $request->process_number;
            $task->court = $request->court;
            $task->priority = $request->priority;
            $task->label_id = $request->label_id;
            $task->status = $request->status;
            $task->source = $request->source;
            $task->company_id = $request->company_id;
            $task->update();
            //dd($task);

            /**Verifica se a tarefa está cadastrado em eventos */
            $theEvent = Event::where('event_id', $request->id)->first();
            /**Se existir o evento, salva alterações */
            if ($theEvent) {
                $theEvent->company_id = $request->company_id;
                $theEvent->author_id = $request->author_id;
                $theEvent->responsible_id = $request->responsible_id;
                $theEvent->start = $request->end_date;
                $theEvent->end = $request->delivery_date;
                $theEvent->is_all_day = 1;
                $theEvent->status = 0;
                $theEvent->title = $request->title;
                $theEvent->description = $request->description;
                $theEvent->color = '#50301E';
                $theEvent->event_id = $task->id;
                $theEvent->update();
            } else {
                /**Se não existir o evento, cadastra */
                $event = new Event();
                $event->company_id = $request->company_id;
                $event->author_id = $request->author_id;
                $event->responsible_id = $request->responsible_id;
                $event->start = $request->end_date;
                $event->end = $request->delivery_date;
                $event->is_all_day = 1;
                $event->status = 0;
                $event->title = $request->title;
                $event->description = $request->description;
                $event->color = '#50301E';
                $event->event_id = $task->id;
                $event->save();
            }

            

            //comita depois de tudo ter sido salvo
            DB::commit();

            //Redireciona para outra página após cadastrar com sucesso
            return response()->json( ['success' => 'Registro alterado com sucesso!']);
        } catch (Exception $e) {
            //Desfazer a transação caso não consiga cadastrar com sucesso no BD
            DB::rollBack();

            //Redireciona para outra página se der erro
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return response()->json(null, 204);
    }
}
