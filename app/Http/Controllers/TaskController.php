<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//Add
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use JWTAuth;
use App\Task;

class TaskController extends Controller
{

    /**
     * @var
     */
    protected $user;

    /**
     * TaskController constructor.
     */
    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
    }

    /**
     * @group Tasks
     * Todos
     * Lista todas as tarefas
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return Task::all();
        // $tasks = $this->user->tasks()->get(['id','descricao', 'done'])->toArray();
        // $tasks = $this->user->tasks()->get(['*'])->toArray();

        $tasks = DB::select('select * from tasks where user_id = ?', [$this->user->id]);

        return $tasks;
    }

    /**
     * @group Tasks
     * Salvar
     * 
     * Salva uma nova tarefa
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // Validacao
        //------------
        $validator = Validator::make($request->all(), [
            'descricao' => 'required|string|max:100'
        ]);

        if ($validator->fails()) {
            $result = [
                'success' => false,
                'message' => 'Verifique os parâmetros de entrada'
            ];
            return response($result, 400);
        }        
        
        // Salva Tarefa
        //---------------
        $dados = $request->json()->all();
        $dados['user_id'] = $this->user->id;

        if ($task = Task::create($dados)) {
            return response()->json([
                'success' => true,
                'message' => 'Task criada com sucesso',
                'task'    => $task
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Falha ao criar task'
            ], 500);
        }
    }

    /**
     * @group Tasks
     * Único
     * Exibe uma task específica
     * 
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        if ($task->user_id == $this->user->id) {
            return $task;
        } else {
            return [];
        }
    }

    /**
     * @group Tasks
     * Atualiza
     * Atualiza uma task específica
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        
        // Valida Usuário
        //-----------------
        if ($task->user_id != $this->user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Não autorizado'
            ], 401);
        }

        // Valida Campos
        //----------------
        $validator = Validator::make($request->all(), [
            'descricao' => 'required|string|max:100',
            'done'      => 'required|boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Verifique os parêmetros de entrada.'
            ], 400);
        }

        // Atualiza a Task
        //------------------
        $dados = $request->json()->all();
        $task->descricao = $dados['descricao'];
        $task->done      = $dados['done'];
        $task->save();

        return $task;

    }

    /**
     * @group Tasks
     * Deletar
     * Deleta uma task específica
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {

        // Valida Usuário
        //-----------------
        if ($task->user_id != $this->user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Não autorizado'
            ], 401);
        }

        // Deleta a task
        //---------------
        if ($task->delete()) {
            return ['success' => true];
        } else {
            return response()->json(['success' => false], 500);
        }
    }

}
