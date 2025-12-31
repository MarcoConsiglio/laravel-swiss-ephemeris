<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\DeadCode\Rector\Assign\RemoveDoubleAssignRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUselessParamTagRector;
use Rector\DeadCode\Rector\Plus\RemoveDeadZeroAndOneOperationRector;
use Rector\Php80\Rector\Class_\ClassPropertyAssignToConstructorPromotionRector;
use Rector\TypeDeclaration\Rector\ArrowFunction\AddArrowFunctionReturnTypeRector;

$level = 22;
return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/config',
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ])
    ->withPhpLevel($level)
    ->withTypeCoverageLevel(18)
    ->withDeadCodeLevel(18)
    ->withCodeQualityLevel($level)
    ->withSkip([
        ClassPropertyAssignToConstructorPromotionRector::class,
        AddArrowFunctionReturnTypeRector::class,
        RemoveDoubleAssignRector::class => [
            __DIR__ . '/tests/Unit/Records/Moon/DraconicRecordTest'
        ],
        RemoveDeadZeroAndOneOperationRector::class => [
            __DIR__ . '/tests/Unit/Traits/WithFuzzyLogicTest.php'
        ],
        // RemoveUselessParamTagRector::class
    ]);
