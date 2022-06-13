<?php

namespace App\CodeGenerator;

class TimeStampShortCodeGenerator implements ShortCodeGenerator
{

    public function generate(): string
    {
        return time();
    }
}