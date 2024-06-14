<?php
include_once("services/hash/HashService.php");

class SHA256HashService implements HashService {

    public function digest(string $input): string {
        return mb_substr(hash('sha256', $input), 0, 36, 'UTF-8');
    }
    
}