<?php

final class Idea extends BaseEntity {
    public function __construct(
        private ?int               $id,
        private string      $title,
        private string      $description,
        private Category    $category,
        private DateTimeImmutable $createdAt,
        private Status      $status,
        private User        $owner,
    ) {
    }

    public static function fromArray(array $row): static {
        return new self(
            id: $row['id'] ?? null,
            title: $row['title'],
            description: $row['description'],

            category: new Category(
                id: $row['category_id'],
                name: $row['category_name'] ?? ''
            ),

            createdAt: new DateTimeImmutable($row['created_at']),

            status: new Status(
                id: $row['status_id'],
                name: $row['status_name'] ?? ''
            ),

            owner: new User(
                id: $row['owner_id'],
                name: $row['owner_name']  ?? '',
                email: $row['owner_email'] ?? '',
                password: $row['password'] ?? ''
            )
        );
    }
    public function toArray(): array {
        return [
            'id'           => $this->id,
            'title'        => $this->title,
            'description'  => $this->description,
            'category_id'  => $this->category->getId(),
            'created_at'   => $this->createdAt->format('Y-m-d H:i:s'),
            'status_id'    => $this->status->getId(),
            'owner_id'     => $this->owner->getId(),
        ];
    }
}
