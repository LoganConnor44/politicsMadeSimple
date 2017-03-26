<?php namespace PoliticsMadeSimple\Test;

use PHPUnit\Framework\TestCase;

class MetaDataTest extends TestCase {

	public $legislatorData;
	public $response;

	/**
	 * Saves the locally saved json file as a php array to emulate API response.
	 */
	public function setUp() {
		$json = file_get_contents(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'metaDataTexas.json');
		$this->response = json_decode($json);
	}

	/**
	 * Destroys $legislatorData and $response to keep tests isolated.
	 */
	public function tearDown() {
		unset($this->legislatorData, $this->response);
	}

	/**
	 * Determines if the meta data states response has Events data.
	 * The test has data so $haveEventData should present as true.
	 */
	public function testGetEventFlag() {
		$haveEventData = FALSE;
		if(isset($this->response[0]->feature_flags)) {
			foreach ($this->response[0]->feature_flags as $flags) {
				if ($flags === 'events') {
					$haveEventData = TRUE;
				}
			}
		}
		$this->assertTrue($haveEventData);
	}
}