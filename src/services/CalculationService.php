<?php

namespace joncollette\craftajaxendpointforhiddencalculations\services;

use Craft;
use craft\base\Component;
use joncollette\craftajaxendpointforhiddencalculations\Plugin as AjaxCalcPlugin;

class CalculationService extends Component
{
    /**
     * Calculates a value based on the provided data.
     * Returns a message if ajaxcalc.php is not defined.
     *
     * @param array $data The input data for the calculation.
     * @return string The result of the calculation or a message.
     */
	public function calculate(array $data): string|array|int
	{
	    // Access the configuration
	    $config = Craft::$app->config->getConfigFromFile('ajaxcalc');
	
	    // Check if the ajaxcalc.php configuration is defined
	    if (empty($config)) {
	        return "The ajaxcalc.php configuration file needs to be defined.";
	    }
	
	    // Ensure the 'formulas' key exists and is an array
	    $formulas = $config['formulas'] ?? [];
	    
	    // Check if the first element (expected formula key) exists in $data
	    if (empty($data) || !isset($data[0])) {
	        return "Formula key is missing or undefined in the data.";
	    }
	
	    // Extract the formula key
	    $formulaKey = $data[0];
	
	    // Check if the formula key exists in the 'formulas' array
	    if (isset($formulas[$formulaKey])) {
	        return $formulas[$formulaKey]($data);
	    } else {
	        return "Formula not found for key: " . $formulaKey;
	    }
	}
}