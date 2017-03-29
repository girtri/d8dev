<?php
/**
* @file
* Contains \Drupal\d8dev\Plugin\field\formatter\RecipeFormatter.
*/
namespace Drupal\d8dev\Plugin\Field\FieldFormatter;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;
/**
* Plugin implementation of the 'number_decimal' formatter.
*
* The 'Default' formatter is different for integer fields on the one hand, and
* for decimal and float fields on the other hand, in order to be able to use
* different settings.
*
* @FieldFormatter(
*  id = "recipe_time",
*  label = @Translation("Duration"),
*  field_types = {
*    "integer",
*    "decimal",
*    "float"
*  }
* )
*/

class RecipeFormatter extends FormatterBase 
{
	/**
	* {@inheritdoc}
	*/
	public function viewElements(FieldItemListInterface $items, $langcode)
	{
		$elements = array();

		foreach ($items as $delta => $item) {
			//$hours = $item->value;
			$hours = floor($item->value / 60); //divide by minutes in 1 hour and get floor
			$minutes = $item->value % 60; //remainder of minutes

			//get greatest common denominator of minutes to convert to fraction of hours
			$minutes_gcd = gcd($minutes, 60);

			//&frasl; is the html entity for the fraction separator, and we use the sup and sub html element to give the appearance of a fraction.
			$valore = 60/$minutes_gcd;
			$minutes_fraction = $minutes/$minutes_gcd ."/".$valore ;

			//$minutes_fraction = '<sup>' .$minutes/$minutes_gcd .'</sup>&frasl;<sub>' .$valore . '</sub>';

			$markup = $hours > 0 ? $hours.' and '.$minutes_fraction . ' hours' : $minutes_fraction.' hours';
			
			$elements[$delta] = array(
				'#theme' => 'recipe_time_display',
				'#value' => $markup,
			);
		}
		return $elements;
	}
}

/**
* Simple helper function to get gcd of minutes
*/
function gcd($a, $b) {
	$b = ( $a == 0) ? 0 : $b;
	return ( $a % $b ) ? gcd($b, abs($a - $b)) : $b;
}
