<?php

final class Category extends BaseEntity {
    public function __construct(
        private ?int   $id,
        private string $name,
    ) {
    }

    public static function fromArray(array $row): static {
        return new self(
            id: $row['id']   ?? null,
            name: $row['name']
        );
    }

    public function toArray(): array {
        return [
            'id'   => $this->id,
            'name' => $this->name,
        ];
    }

    public function getId(): int {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }
}
