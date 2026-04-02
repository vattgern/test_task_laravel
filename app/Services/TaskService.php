<?php

namespace App\Services;

use App\DTOs\TaskDTO;
use App\Models\Task;

class TaskService
{
    /**
     * Получение пагинации
     *
     * @param array $filters фильтрация
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getAll(array $filters = []): \Illuminate\Pagination\LengthAwarePaginator
    {
        $query = Task::query();

        if (!empty($filters['status']))
            $query->where('status', $filters['status']);

        if (!empty($filters['search']))
            $query->where('title', 'LIKE', '%' . $filters['search'] . '%');

        $query->orderBy(
            $filters['sort_by'] ?? 'created_at',
            $filters['order'] ?? 'desc'
        );

        return $query->paginate($filters['per_page'] ?? 10);
    }

    /**
     * Поиск задачи
     *
     * @param int $id
     *
     * @return ?Task
     */
    public function getTask(int $id): ?Task
    {
        return Task::findOrFail($id);
    }

    /**
     * Создание задачи
     *
     * @param TaskDTO $DTO данные
     *
     * @return Task
     */
    public function createTask(TaskDTO $DTO): Task
    {
        return Task::create([
            'title'         => $DTO->title,
            'description'  => $DTO->description,
            'status'        => $DTO->status
        ]);
    }

    /**
     * Обновление задачи
     *
     * @param int $id номер задачи
     * @param TaskDTO $DTO данные
     *
     * @return Task
     */
    public function updateTask(int $id, TaskDTO $DTO): Task
    {
        $task = Task::findOrFail($id);

        $task->update([
            'title'         => $DTO->title,
            'description'  => $DTO->description,
            'status'        => $DTO->status
        ]);

        return $task;
    }

    /**
     * Удаление задачи
     *
     * @param int $id номер задачи
     *
     * @return bool
     */
    public function deleteTask(int $id): bool
    {
        $task = Task::findOrFail($id);
        return $task->delete();
    }

    /**
     * Изменение статуса задачи
     *
     * @param int $id номер задачи
     * @param string $status на какой статус меняем
     *
     * @return Task
     */
    public function changeStatus(int $id, string $status): Task
    {
        $task = Task::findOrFail($id);
        $task->update([
            'status'    => $status
        ]);

        return $task;
    }
}
