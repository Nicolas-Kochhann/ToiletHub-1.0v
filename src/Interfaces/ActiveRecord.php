<?php

namespace Src\Interfaces;

interface ActiveRecord{
    public function save(): bool;
    public function delete(): bool;
    public static function find($id): ?self;
    public static function listAll(): array;
    
    //public static function listWhere(array $conditions): array;
}