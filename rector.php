<?php

declare(strict_types=1);

use Rector\CodeQuality\Rector\Class_\InlineConstructorDefaultToPropertyRector;
use Rector\CodeQuality\Rector\If_\ExplicitBoolCompareRector;
use Rector\CodingStyle\Rector\FuncCall\ConsistentPregDelimiterRector;
use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->paths([
        __DIR__ . '/src/',
        __DIR__ . '/tests/'
    ]);

    $rectorConfig->skip([
        \Rector\Php74\Rector\LNumber\AddLiteralSeparatorToNumberRector::class,
        \Rector\CodeQuality\Rector\Ternary\SwitchNegatedTernaryRector::class,
        \Rector\CodeQuality\Rector\Array_\CallableThisArrayToAnonymousFunctionRector::class,
        \Rector\DowngradePhp74\Rector\Property\DowngradeTypedPropertyRector::class
    ]);

    $rectorConfig->rule(InlineConstructorDefaultToPropertyRector::class);
    $rectorConfig->rule(ExplicitBoolCompareRector::class);
    $rectorConfig->rule(\Rector\Php80\Rector\ClassMethod\AddParamBasedOnParentClassMethodRector::class);
    $rectorConfig->rule(\Rector\CodingStyle\Rector\ClassMethod\MakeInheritedMethodVisibilitySameAsParentRector::class);
    $rectorConfig->rule(\Rector\TypeDeclaration\Rector\ClassMethod\AddReturnTypeDeclarationBasedOnParentClassMethodRector::class);
    $rectorConfig->rule(\Rector\TypeDeclaration\Rector\ClassMethod\AddParamTypeFromPropertyTypeRector::class);

    $rectorConfig->importNames(true, true);
    // define sets of rules
    $rectorConfig->sets([
        SetList::CODE_QUALITY,
        SetList::TYPE_DECLARATION,
        SetList::PSR_4,
        SetList::CODING_STYLE,
        SetList::DEAD_CODE,
        LevelSetList::UP_TO_PHP_74,
        //SetList::PHP_74,
    ]);

    $rectorConfig->skip([
        \Rector\Php74\Rector\LNumber\AddLiteralSeparatorToNumberRector::class,
        \Rector\CodeQuality\Rector\Ternary\SwitchNegatedTernaryRector::class,
        \Rector\CodeQuality\Rector\Array_\CallableThisArrayToAnonymousFunctionRector::class,
        \Rector\DowngradePhp74\Rector\Property\DowngradeTypedPropertyRector::class,
        \Rector\TypeDeclaration\Rector\ClassMethod\ArrayShapeFromConstantArrayReturnRector::class,
        \Rector\Php73\Rector\FuncCall\JsonThrowOnErrorRector::class
    ]);

    $rectorConfig->ruleWithConfiguration(ConsistentPregDelimiterRector::class, [
        ConsistentPregDelimiterRector::DELIMITER => '/',
    ]);

    $rectorConfig->phpstanConfig(__DIR__ . '/phpstan.neon');
};
