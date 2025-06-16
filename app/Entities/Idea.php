<?php

class Idea {
    private string $title;
    private string $description;
    private Category $category;
    private DateTimeImmutable $createdAt;
    private Status $status;
    private User $owner;
}
