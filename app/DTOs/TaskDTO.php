<?php

namespace App\DTOs;


class TaskDTO
{
    public function __construct(
        public readonly string $title,
        public readonly ?string $description,
        public readonly string $status
    ) {}

    /**
     * Создание DTO из данных
     */
    public static function fromArray(array $data): self
    {
        return new self(
            title: $data['title'],
            description: $data['description'] ?? null,
            status: $data['status'] ?? 'new'
        );
    }

    /**
     * Преобразхование в массив
     */
    public function toArray(): array
    {
        return [
            'title'         => $this->title,
            'description'   => $this->description,
            'status'        => $this->status
        ];
    }
}
