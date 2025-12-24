<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Php80\Rector\Class_\ClassPropertyAssignToConstructorPromotionRector;

$level = 22;
return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/config',
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ])
    ->withPhpLevel($level)
    ->withTypeCoverageLevel(5)
    ->withDeadCodeLevel(12)
    ->withCodeQualityLevel($level)
    ->withSkip([
        ClassPropertyAssignToConstructorPromotionRector::class
    ]);
