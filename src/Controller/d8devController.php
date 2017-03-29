<?php
/**
* @file
* @author My Name
* Contains \Drupal\d8dev\Controller\d8devController.
* Please include this file under your
* d8dev(module_root_folder)/src/Controller/
*/
namespace Drupal\d8dev\Controller;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Response;
use Drupal\node\Entity\Node;

/**
* Provides route responses for the d8dev module.
*/
class d8devController extends ControllerBase
{
	/**
	* Returns a simple page.
	*
	* @return array
	* A simple renderable array.
	*/
	public function myPage() {
		/*
		$element = array(
			'#type' => 'markup',
			'#markup' => 'Hello, World!.. un casso',
		);
		return $element;
		*/

        //$dtStart = new DateTime(Input::get('startDate'));
        $dt = new \DateTime();
        $dataInizio = $dt->format('Y-m-d\TH:i:s'); //format('Y-m-d H:i:s');
        $dt->modify('+60 minute');
        $dataFine = $dt->format('Y-m-d\TH:i:s');

        $game_play = Node::create(['type' => 'gameplay']);
        $game_play->set('title', 'partita_auto_4');
        $game_play->set('field_inizio', $dataInizio);
        $game_play->set('field_fine', $dataFine);
        $game_play->set('field_tipogame', 1);
        $game_play->enforceIsNew();
        $game_play->save();

		// utilizzo di symfony per JSON response...
		$response = new Response();
		$response->setContent(json_encode(array('hello' => 'world', 'goodbye' => 'world')));
		$response->headers->set('Content-Type', 'application/json');
		return $response;
	}
}

?>