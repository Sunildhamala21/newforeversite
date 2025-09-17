<?php

namespace App\Enums;

enum Difficulty: int
{
    case Beginner = 1;
    case Easy = 2;
    case Moderate = 3;
    case Difficult = 4;
    case Advance = 5;
}
