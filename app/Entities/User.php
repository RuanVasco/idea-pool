<?php

class User extends BaseEntity {

    public function __construct(
        private readonly ?int $id,
        private string $name,
        private string $email,
        private string $password
    ) {
    }

    public static function fromArray(array $row): self {
        return new self(
            id: $row['id'] ?? null,
            name: $row['name'],
            email: $row['email'],
            password: $row['password']
        );
    }

    public function toArray(): array {
        return [
            'id'       => $this->id,
            'name'     => $this->name,
            'email'    => $this->email,
            'password' => $this->password,
        ];
    }

    public function getId(): int {
        return $this->id;
    }
}
