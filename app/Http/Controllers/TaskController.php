<?php

namespace App\Http\Controllers;

use App\DTOs\TaskDTO;
use App\Http\Requests\Tasks\ChangeStatusRequest;
use App\Http\Requests\Tasks\StoreRequest;
use App\Http\Requests\Tasks\UpdateRequest;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    protected TaskService $service;

    public function __construct(TaskService $service)
    {
        $this->service = $service;
    }

    /**
     * Список задач
     */
    public function index(Request $request)
    {
        $filters = [
            'status'    => $request->get('status'),
            'search'    => $request->get('search'),
            'sort_by'   => $request->get('sort_by', 'created_at'),
            'order'     => $request->get('order', 'desc'),
            'per_page'  => $request->get('per_page', 10)
        ];

        $tasks  = $this->service->getAll($filters);

        return view('tasks.index', compact('tasks'));
    }

    /**
     * Форма создания задачи
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Создание задачи
     */
    public function store(StoreRequest $request)
    {
        $DTO = TaskDTO::fromArray($request->validated());
        $task = $this->service->createTask($DTO);

        return redirect()
            ->route('tasks.show', $task)
            ->with('success', 'Задача успешно создана!');
    }

    /**
     * Просмотр задачи
     */
    public function show(int $id)
    {
        $task = $this->service->getTask($id);
        return view('tasks.show', compact('task'));
    }

    /**
     * Форма редактирования задачи
     */
    public function edit(int $id)
    {
        $task = $this->service->getTask($id);
        return view('tasks.edit', compact('task'));
    }

    /**
     * Обновление задачи
     */
    public function update(UpdateRequest $request, int $id)
    {
        $DTO = TaskDTO::fromArray($request->validated());
        $task = $this->service->updateTask($id, $DTO);

        return redirect()
            ->route('tasks.show', $task)
            ->with('success', 'Задача успешно обновлена!');
    }

    /**
     * Удаление задачи
     */
    public function destroy(int $id)
    {
        $this->service->deleteTask($id);

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Задача успешно удалена!');
    }

    /**
     * Изменение статус задачи
     */
    public function changeStatus(ChangeStatusRequest $request, int $id)
    {
        $task = $this->service->changeStatus($id, $request->get('status'));

        if ($request->ajax()) {
            return response()->json([
                'success'   => true,
                'task'      => $task,
                'status_text'   => Task::STATUSES[$task->status]
            ]);
        }

        return redirect()
            ->back()
            ->with('success', 'Статус задачи обновлен!');
    }
}
