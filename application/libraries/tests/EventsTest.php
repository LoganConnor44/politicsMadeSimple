<?php namespace PoliticsMadeSimple\Test;

use PHPUnit\Framework\TestCase;
use PoliticsMadeSimple\Events;

class EventsTest extends TestCase
{

	public $eventData;
	public $response;

	/**
	 * Saves the locally saved json file as a php array to emulate API response.
	 */
	public function setUp()
	{
		$json = file_get_contents(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'eventsTexas.json');
		$this->response = json_decode($json);
	}

	/**
	 * Destroys $eventData and $response to keep tests isolated.
	 */
	public function tearDown()
	{
		unset($this->eventData, $this->response);
	}

	/**
	 * Verifies that the description is a valid string
	 */
	public function testGetEventDescription() {
		foreach($this->response as $data) {
			$this->assertTrue(is_string($data->description));
		}
	}

	/**
	 * Saves the response to the class global $response and sets the id of the event the key of the new object.
	 * Verifies that an individual event record is an object.
	 * Verifies that the description within the object is a valid string.
	 */
	public function testOrganizeEventData(){
		foreach($this->response as $data) {
			$this->eventData[$data->id] = $data;
		}
		$this->assertTrue(is_object($this->eventData['TXE00029278']));
		$this->assertTrue(is_string($this->eventData['TXE00029278']->description));
	}
}
