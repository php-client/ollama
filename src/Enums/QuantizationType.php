<?php

declare(strict_types=1);

namespace PhpClient\Ollama\Enums;

enum QuantizationType: string
{
    case Q2K = 'q2_K';
    case Q3KL = 'q3_K_L';
    case Q3KM = 'q3_K_M';
    case Q3KS = 'q3_K_S';
    case Q40 = 'q4_0';
    case Q41 = 'q4_1';
    case Q4KM = 'q4_K_M';
    case Q4KS = 'q4_K_S';
    case Q50 = 'q5_0';
    case Q51 = 'q5_1';
    case Q5KM = 'q5_K_M';
    case Q5KS = 'q5_K_S';
    case Q6K = 'q6_K';
    case Q80 = 'q8_0';
}
