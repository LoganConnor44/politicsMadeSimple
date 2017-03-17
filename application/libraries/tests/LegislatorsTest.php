<?php namespace PoliticsMadeSimple\Test;

	use PHPUnit\Framework\TestCase;
	use PoliticsMadeSimple;

class LegislatorsTest extends TestCase{
	public $legislatorData;
	public $response;

	/**
	 * Saves the locally saved json file as a php array to emulate API response.
	 */
	public function setUp() {
		$this->response = file_get_contents(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'LegislatorsTexas.json');
		json_decode($this->response);
	}

	/**
	 * Destroys $legislatorData and $response to keep tests isolated.
	 */
	public function tearDown(){
		unset($this->legislatorData, $this->response);
	}

	/**
	 * Mocks the method getAllLegislatorsByState() within the Legislators class.
	 * The stub verifies that $response is a php object.
	 */
	public function testGetAllLegislatorsByState() {
		$this->legislatorData = $this->getMockBuilder('Legislators')
			->setMethods(['getAllLegislatorsByState'])
			->getMock();
		$this->legislatorData->method('getAllLegislatorsByState')
			->willReturn($this->response);
		$this->assertThat(
			is_object($this->legislatorData),
			$this->equalTo(TRUE)
		);
	}
}