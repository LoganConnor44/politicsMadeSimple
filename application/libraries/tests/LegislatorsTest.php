<?php namespace PoliticsMadeSimple\Test;

	use PHPUnit\Framework\TestCase;
	use PoliticsMadeSimple\Legislators;

	class LegislatorsTest extends TestCase{

	public $legislatorData;
	public $response;

	/**
	 * Saves the locally saved json file as a php array to emulate API response.
	 */
	public function setUp() {
		$json = file_get_contents(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'LegislatorsTexas.json');
		$this->response = json_decode($json);
	}

	/**
	 * Destroys $legislatorData and $response to keep tests isolated.
	 */
	public function tearDown(){
		unset($this->legislatorData, $this->response);
	}

	/**
	 * Verifies that each object has the property 'chamber'
	 */
	public function testSanitizeFullApiResponse() {
		foreach($this->response as $key => &$legislator) {
			if(!property_exists($legislator, 'chamber')) {
				unset($this->response[$key]);
			}
		}
		foreach ($this->response as $legislator) {
			$this->assertTrue(property_exists($legislator, 'chamber'));
		}
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

	/**
	 * Records a count of the upper and lower chambers then takes the sum of those numbers and verifies that it matches
	 * the total of objects.
	 */
	public function testGetChamberCounts() {
		$Legislators = new Legislators();
		$sanitizedResponse = $Legislators->sanitizeFullApiResponse($this->response);
		$testChamberCounts = array(
			'upper' => 0,
			'lower' => 0
		);
		foreach($sanitizedResponse as $key => &$legislator) {
			if(isset($legislator->chamber) && $legislator->chamber === 'upper') {
				$testChamberCounts['upper']++;
			}
			if(isset($legislator->chamber) && $legislator->chamber === 'lower') {
				$testChamberCounts['lower']++;
			}
		}
		if(isset($testChamberCounts['upper'])) {
			$this->assertGreaterThan(2, $testChamberCounts['upper']);
		}
		if(isset($testChamberCounts['lower'])) {
			$this->assertGreaterThan(2, $testChamberCounts['lower']);
		}
		$totalNumberOfLegislators = count($sanitizedResponse);
		$sumOfChambers = $testChamberCounts['upper'] + $testChamberCounts['lower'];

		$this->assertEquals($totalNumberOfLegislators, $sumOfChambers);
	}

	/**
	 * Verifies that the data in the response matches the extracted, unique values.
	 */
	public function testGetPartiesInApiResponse() {
		$Legislators = new Legislators();
		$sanitizedResponse = $Legislators->sanitizeFullApiResponse($this->response);
		$parties = array();
		foreach($sanitizedResponse as &$legis){
			$parties[trim($legis->party)] = trim($legis->party);
		}
		asort($parties);
		array_unique($parties);
		$partiesInString = '';
		foreach ($parties as $party) {
			$partiesInString .= ' ' . $party;
		}
		foreach ($sanitizedResponse as $legislator) {
			$evaluate = FALSE;
			if (strpos($partiesInString, $legislator->party)) {
				$evaluate = TRUE;
			}
			$this->assertTrue($evaluate);
		}
	}

	/**
	 * Creates an array that has all legislators sorted by political party as a key value pair.
	 * Verifies that the sum of all the sorted legislators still equates to the sum of the original array.
	 */
	public function testSortAllLegislatorsByParty(){
		$Legislators = new Legislators();
		$sanitizedResponse = $Legislators->sanitizeFullApiResponse($this->response);
		$partiesInState = $Legislators->getPartiesInApiResponse($this->response);
		$sortedLegislatorsByParty = array();
		foreach($sanitizedResponse as $legislator){
			if(in_array($legislator->party, $partiesInState)){
				$sortedLegislatorsByParty[$legislator->party][] = $legislator;
			}
		}
		asort($sortedLegislatorsByParty);
		$countingArray = array();
		foreach ($sortedLegislatorsByParty as $party => $legislatorsByParty) {
			$countingArray[$party] = count($legislatorsByParty);
		}
		$this->assertEquals(array_sum($countingArray), count($sanitizedResponse));
	}
}