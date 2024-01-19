# AJAX Logic Processor for Craft CMS

The AJAX Logic Processor is a Craft CMS plugin designed to provide a flexible AJAX endpoint for dynamic logic processing and calculations. This plugin enables seamless integration of complex logic operations with Craft CMS, enhancing the capability to handle diverse calculation needs through AJAX requests.

This plugin's primary focus is to obscure formula calculations from savvy users but has other potential use cases.

## Features

- Dynamic AJAX endpoint for processing custom logic and calculations.
- Streamlined integration with Craft CMS 4.
- Flexible architecture allowing for easy extension and customization.
- Robust error handling for reliable operation.

## Requirements

- PHP 8.0.2 or later.
- Craft CMS 4.5.0 or later.

## Installation

1. **If installing via zip, upload the plugin:**
Upload the unzipped plugin folder to

`/path/to/project/plugins/`

2. **Via Composer:**
Open your terminal and go to your Craft project:

`cd /path/to/project`

Then tell Composer to load the plugin:

`composer require jon-collette/craft-ajax-endpoint-for-hidden-calculations`

3. **In the Control Panel:**
Go to Settings → Plugins and click the “Install” button for AJAX Logic Processor.

4. **If pushing updates:**

Push updates to the plugin install via:

`composer update _ajax-endpoint-for-hidden-calculations`

Then clear the autoload:

`composer dump-autoload`

## Configuration

The plugin doesn't require additional configuration. It utilizes `ajaxcalc.php` to define custom logic for calculations. Ensure this file is correctly set up in your `config` directory.

***Example ajaxcalc.php file:***

Note: The array[0] position is used as the formula index. An unlimited number of values can be passed.

```php
return [
    'formulas' => [
    	// $params[0] should match the key
    	'simpleaddition' => function($params) {
            return $params[1] + $params[2];
        },
        // standard math
        'math' => function($params) {
            return $params[1] * $params[2] + $params[3] - 100;
        },
        // logic
        'testformula' => function($params) {
        	$int = $params[1];
			if ($int > 100) {
                return 'Input is over 100';
            } else if ($int < 100) {
            	return 'Input is under 100';
            } else if ( $int == 100) {
            	return 'Input is 100';
            } else {
            	return 'Input didn\'t meet specs';
            }
        },
        // int as key 
        4 => function($params) {
            return 1;
        },
        // string return
        'ping' => function($params) {
            return 'pong';
        },
        // ... other formulas can be added here
    ],
];
```

The plugin will pass some errors via the return:
- `The ajaxcalc.php configuration file needs to be defined.`
- `Formula key is missing or undefined in the data.`
- `Formula not found for key: [key].`
- And system errors from the plugin

## Usage

Send an AJAX request to the provided endpoint with the necessary parameters. The plugin processes the request and returns the result based on the defined logic in `ajaxcalc.php`.

***Example AJAX request:*** Note that the CSRF token is required for security needs and the token needs to be uncached as Craft CMS will cache any page for 24 hours by default. Thusly [No-Cache is highly recommended](https://plugins.craftcms.com/nocache?craft4) is highly recommended. This script is simplest to use as part of a template.TWIG to fetch the user's `craft.app.request.csrfToken`. The data must be sent as part of an array.

```javascript
var csrfTokenValue = "{{ craft.app.request.csrfToken }}";
var dataArray = ["math",1,2];

fetch('/actions/_ajax-endpoint-for-hidden-calculations/calculation/perform-calculation', {
	method: 'POST',
	headers: {
		'Content-Type': 'application/json',
		'X-Requested-With': 'XMLHttpRequest',
		'X-CSRF-Token': csrfTokenValue,
	},
	body: JSON.stringify({
		data: dataArray
	})
}).then(response => response.json()).then(dataReturn => {
	// Do something with dataReturn.result
	console.log(dataReturn.result);
}).catch(error => console.error('Error:', error));
```

## Development and Contributions
Contributions to the plugin are welcome. Please ensure any pull requests maintain the coding standards and functionality of the plugin.

## Support and Documentation

For support and detailed documentation, please reach out to us on GitHub at [example.com](https://example.com).

## Licensing

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for more details.