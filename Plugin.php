<?php

namespace joncollette\craftajaxendpointforhiddencalculations;

use Craft;
use craft\base\Plugin as BasePlugin;
use joncollette\craftajaxendpointforhiddencalculations\services\CalculationService;

class Plugin extends BasePlugin
{
    public string $schemaVersion = '1.0.0';
    public bool $hasCpSettings = false;

    public static function config(): array
    {
        return [
            'components' => [
                'calculationService' => CalculationService::class,
            ],
        ];
    }

    public function init(): void
    {
        parent::init();
        // Register the calculation service
        $this->setComponents([
            'calculationService' => CalculationService::class,
        ]);
    }
}