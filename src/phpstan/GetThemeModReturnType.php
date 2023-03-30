<?php
/**
 * Dynamic return type for get_theme_mod()
 *
 * @package Tracomme2023
 */

namespace Tracomme2023\PHPStan;

use PhpParser\Node\Expr\FuncCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\FunctionReflection;
use PHPStan\Reflection\ParametersAcceptorSelector;
use PHPStan\Type\Constant\ConstantStringType;
use PHPStan\Type\DynamicFunctionReturnTypeExtension;
use PHPStan\Type\MixedType;
use PHPStan\Type\StringType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeCombinator;

/**
 * This class implements dynamic return types for Tracomme2023 specific theme mods.
 */
class GetThemeModReturnType implements DynamicFunctionReturnTypeExtension {

	/**
	 * Tracomme2023 specific theme modifications.
	 *
	 * @var array<int,string>
	 */
	private static $themeMods = [
		'tracomme2023_bootstrap_version',
		'tracomme2023_container_type',
		'tracomme2023_navbar_type',
		'tracomme2023_sidebar_position',
		'tracomme2023_site_info_override',
	];

	public function isFunctionSupported(FunctionReflection $functionReflection): bool
	{
		return $functionReflection->getName() === 'get_theme_mod';
	}

	public function getTypeFromFunctionCall(
		FunctionReflection $functionReflection,
		FuncCall $functionCall,
		Scope $scope
	): Type
	{
		$argType = $scope->getType($functionCall->getArgs()[0]->value);
		$defaultType = ParametersAcceptorSelector::selectFromArgs(
			$scope,
			$functionCall->getArgs(),
			$functionReflection->getVariants()
		)->getReturnType();

		if (!$argType instanceof ConstantStringType) {
			return $defaultType;
		}

		// Return the default value if it is not an Tracomme2023 specific theme mod.
		if (!in_array($argType->getValue(), self::$themeMods, true)) {
			return $defaultType;
		}

		// Without second argument the default value is false, but can be filtered.
		$defaultType = new MixedType();
		if (count($functionCall->getArgs()) > 1) {
			$defaultType = $scope->getType($functionCall->getArgs()[1]->value);
		}

		return TypeCombinator::union(new StringType(), $defaultType);
	}
}
