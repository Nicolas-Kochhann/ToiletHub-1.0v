<?php

namespace Src\Interfaces;

interface ActiveRecord{
    public function save(): bool;
    public static function delete(int $id): bool;
    public static function find(int $id): ?self;
    public static function listAll(): array;
    
    //public static function listWhere(array $conditions): array;
}