<?php

abstract class BaseEntity {
    abstract public static function fromArray(array $row): static;
    abstract public function toArray(): array;
}
