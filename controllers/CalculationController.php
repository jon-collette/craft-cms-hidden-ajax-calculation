<?php

namespace joncollette\craftajaxendpointforhiddencalculations\controllers;

use Craft;
use craft\web\Controller;
use joncollette\craftajaxendpointforhiddencalculations\Plugin as AjaxCalcPlugin;
use yii\web\Response;

class CalculationController extends Controller
{
    protected array|bool|int $allowAnonymous = true;
    public $enableCsrfValidation = true;

    public function actionPerformCalculation(): Response
    {
        $this->requirePostRequest();
        
        // Fetch the data from the request
        $data = Craft::$app->getRequest()->getBodyParam('data');

        // Validate or type cast the $data
        if (!is_array($data)) {
            // Handle invalid data format
            Craft::error('Invalid data format for calculationController', __METHOD__);
            return $this->asErrorJson('Invalid data format');
        }

        // Call the calculation service to perform the calculation
        try {
            $result = AjaxCalcPlugin::getInstance()->calculationService->calculate($data);
		} catch (\Exception $e) {
		    // Log the full exception message
		    Craft::error('Error during calculationController: ' . $e->getMessage(), __METHOD__);

		    // Consider returning the exception message for debugging (remove in production)
		    return $this->asErrorJson('Error during calculation: ' . $e->getMessage());
		}

        // Return the result as JSON
        return $this->asJson(['result' => $result]);
    }
}
