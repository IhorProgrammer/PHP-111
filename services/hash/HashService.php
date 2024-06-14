<?php
interface HashService {
    public function digest( string $input ) : string;
}
