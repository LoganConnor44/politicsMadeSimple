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

	/**
	 * Creates an array that has all legislators sorted by political party AND chamber as a key value pair.
	 * E.G. $sortedLegislatorsByChamber[PARTY][CHAMBER][LEGISLATOR OBJECT]
	 * Verifies that the number of sorted elements equals the number of elements in $sanitizedResponse
	 *
	 * NOTE: This could be refactored to not use foreach within a foreach
	 */
	public function testSortChamber(){
		$Legislators = new Legislators();
		$sanitizedResponse = $Legislators->sanitizeFullApiResponse($this->response);
		$partiesInState = $Legislators->getPartiesInApiResponse($this->response);
		$sortedLegislatorsByChamber = array();
		$chambers = array(
			'upper',
			'lower',
		);
		foreach ($sanitizedResponse as $legislator) {
			if (in_array($legislator->party, $partiesInState) && in_array($legislator->chamber, $chambers)) {
				$sortedLegislatorsByChamber[trim($legislator->party)][trim($legislator->chamber)][] = $legislator;
			}
		}
		asort($sortedLegislatorsByChamber);
		$sortCount = 0;
		foreach ($sortedLegislatorsByChamber as $party) {
			foreach ($party as $chamber) {
				$sortCount += count($chamber);
			}
		}
		$this->assertEquals($sortCount, count($sanitizedResponse));
	}

	/**
	 * Takes the return from sortChamber() and creates a new mixed array with only the upper chamber legislator data.
	 * E.G. $upperChamberLegislators[PARTY]['upper'][LEGISLATOR OBJECT]
	 * Verifies that the newly created array matches the original array, $sanitizedResponse
	 */
	public function testGetUpperChamberByState() {
		$Legislators = new Legislators();
		$sanitizedResponse = $Legislators->sanitizeFullApiResponse($this->response);
		$partiesInState = $Legislators->getPartiesInApiResponse($this->response);
		$sortedByChamber = $Legislators->sortChamber($sanitizedResponse, $partiesInState);
		$upperChamberLegislators = array();
		foreach ($sortedByChamber as $party => $chamberValue) {
			if (isset($sortedByChamber[$party]['upper'])) {
				$upperChamberLegislators[$party] = $sortedByChamber[$party]['upper'];
			}
		}
		$sanitizedResponseUpperCount = 0;
		foreach ($sanitizedResponse as $legislator) {
			if(isset($legislator->chamber) && $legislator->chamber === 'upper') {
				$sanitizedResponseUpperCount++;
			}
		}
		$numberOfUpperChamber = count($upperChamberLegislators, 1) - count($upperChamberLegislators);
		$this->assertEquals($numberOfUpperChamber, $sanitizedResponseUpperCount);
	}

	/**
	 * Takes the array $upperChamberLegislators[PARTY][CHAMBER][LEGISLATOR OBJECT]
	 * This array is then counted to see how many parties are stored, then it counts the next level down, Chamber. The
	 * difference of these two amounts indicates how many legislators are in the upper chamber.
	 * Verifies by having a counter starting at zero and only incrementing when the chamber is set and it is set to
	 * 'upper'.
	 */
	public function testCountUpperChamber() {
		$Legislators = new Legislators();
		$sanitizedResponse = $Legislators->sanitizeFullApiResponse($this->response);
		$partiesInState = $Legislators->getPartiesInApiResponse($this->response);
		$upperChamber = $Legislators->getUpperChamberByState($sanitizedResponse, $partiesInState);
		$numberOfParties = count($upperChamber);
		$numberOfUppers = count($upperChamber, 1) - $numberOfParties;
		$count = 0;
		foreach ($sanitizedResponse as $legislator) {
			if (isset($legislator->chamber) && $legislator->chamber === 'upper') {
				$count++;
			}
		}
		$this->assertTrue($numberOfUppers - $count === 0);
	}
}