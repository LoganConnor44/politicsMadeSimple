<?php defined('BASEPATH') OR exit('No direct script access allowed');

	class Legislature extends CI_Controller{

		public $userDefinedState;
		public $civicDataBy = 'OpenStates.org';

		public function __construct(){
			parent::__construct();
			$this->load->helper('url');
			$this->load->model('simple_m');
		}

		public function index(){
			$this->userDefinedState = $this->input->post('stateSelect');
			$States = new PoliticsMadeSimple\States();
			$state = $States->linkAbbrevToStateFullName($this->userDefinedState);
			$Legislators = new PoliticsMadeSimple\Legislators();
			$apiResponse = $Legislators->getAllLegislatorsByState($this->userDefinedState);
			$sanitizedResponse = $Legislators->sanitizeFullApiResponse($apiResponse);
			$legisParties = $Legislators->getPartiesInApiResponse($sanitizedResponse);
			$sortedParties = $Legislators->sortAllLegislatorsByParty($sanitizedResponse, $legisParties);
			$sortedByPartyAndChamber = $Legislators->sortChamber($sanitizedResponse, $legisParties);
			$stateDetail = $States->getStateDetail($this->userDefinedState);
			$chamberCounts = $Legislators->getChamberCounts($sanitizedResponse);
			$Events = new \PoliticsMadeSimple\Events();
			$upcomingEvents = $Events->getEventsForSelectedState($this->userDefinedState);
			$isThereAnUpcomingEvent = $Events->upcomingEvents($upcomingEvents);
			$isThereAnUpcomingEvent ? $numberOfEvents = $Events->howManyEvents($upcomingEvents) : $numberOfEvents = FALSE;
			$doesUpperChamberExist = $States->doesUpperChamberExist($stateDetail);
			$doesLowerChamberExist = $States->doesLowerChamberExist($stateDetail);
			$htmlChamberResponse = $this->formatHtmlBasedOnChamber($doesUpperChamberExist, $doesLowerChamberExist,
				$stateDetail, $chamberCounts);
			$upperChamber = $Legislators->getUpperChamberByState($sanitizedResponse, $legisParties);
			$numberOfUpperLegislators = $Legislators->countAnyChamber($upperChamber);
			$partyDistributionHtml = $this->formatHtmlPartyDistribution($sortedParties, 'PARTY_DISTRIBUTION');
			$upperChamberHtml = $this->formatHtmlPartyDistribution($sortedByPartyAndChamber, 'UPPER_CHAMBER');
			$lowerChamberHtml = $this->formatHtmlPartyDistribution($sortedByPartyAndChamber, 'LOWER_CHAMBER');

			$data = array(
				'stateDetail' => $stateDetail,
				'userDefinedState' => strtoupper($this->userDefinedState),
				'selectedState' => $state,
				'stateFullName' => $state[strtoupper($this->userDefinedState)],
				'parties' => $sortedParties,
				'totalLegislators' => count($sanitizedResponse),
				'civicDataBy' => $this->civicDataBy,
				'isThereAnUpcomingEvent' => $isThereAnUpcomingEvent,
				'numberOfEvents' => $numberOfEvents,
				'htmlChamberResponse' => $htmlChamberResponse,
				'landingPage' => FALSE,
				'partyAndChamber' => $sortedByPartyAndChamber,
				'upperChamber' => $upperChamber,
				'partyDistribution' => $partyDistributionHtml,
				'upperChamberHtml' => $upperChamberHtml,
				'lowerChamberHtml' => $lowerChamberHtml,
				'numberOfUpper' => $chamberCounts['upper'],
				'numberOfLower' => $chamberCounts['lower'],
				'eventsCardTemplate' => array(
					'cardColour' => 'amber',
					'cardTitle' => 'Title Goes Here',
					'cardSubtitle' => 'Subtitle Goes Here'
				)
			);
			$this->load->view('stateLegislators_v', $data);
		}

		public function formatHtmlBasedOnChamber($doesUpperChamberExist, $doesLowerChamberExist, $state, $chamberCounts){
			$htmlResponse = '';
			//lower does not exist
			if($doesUpperChamberExist && !$doesLowerChamberExist){
				$htmlResponse = '<p>' . $state->name . ' has ' . $chamberCounts['upper'] . ' ' . $state->chambers->upper->title
					. 's.' . $state->name . 'is one of the few states that does not have a lower chamber. This is called 
				unicameralism.</p>';
			}
			//upper does not exist
			if(!$doesUpperChamberExist && $doesLowerChamberExist){
				$htmlResponse = '<p>' . $state->name . ' has ' . $chamberCounts['lower'] . ' ' . $state->chambers->lower->title
					. 's.' . $state->name . 'is one of the few states that does not have an upper chamber. This is called 
				unicameralism.</p>';
			}
			//both exist
			if($doesUpperChamberExist && $doesLowerChamberExist){
				$htmlResponse = '<p>' . $state->name . ' has ' . $chamberCounts['upper'] . ' ' . $state->chambers->upper->title
					. 's and ' . $chamberCounts['lower'] . ' ' . $state->chambers->lower->title . 's.</p>';
			}

			return $htmlResponse;
		}

		public function formatHtmlPartyDistribution(array $sortedParties, string $viewElement) {
			$htmlString = '';
			$i = count($sortedParties);
			switch ($viewElement) {
				case 'PARTY_DISTRIBUTION' :
					foreach ($sortedParties as $party => $officialsData) {
						if ($i >= 2) {
							$htmlString .= count($officialsData) .' ' . $party . 's, ';
							$i--;
						} else {
							$htmlString .= ' and ' . count($officialsData) .' ' . $party . 's';
						}
					}
					break;
				case 'UPPER_CHAMBER' :
					foreach($sortedParties as $party => $officialsData) {
						if (isset($officialsData['upper'])) {
							$countOfData = count($officialsData['upper']);
						} else {
							$countOfData = 0;
						}
						if ($i >= 2) {
							$htmlString .= $countOfData . ' ' . $party . 's, ';
							$i--;
						} else {
							$htmlString .= ' and ' . $countOfData . ' ' . $party . 's';
						}
					}
					break;
				case 'LOWER_CHAMBER' :
					foreach($sortedParties as $party => $officialsData) {
						if (isset($officialsData['lower'])) {
							$countOfData = count($officialsData['lower']);
						} else {
							$countOfData = 0;
						}
						if ($i >= 2) {
							$htmlString .= $countOfData . ' ' . $party . 's, ';
							$i--;
						} else {
							$htmlString .= ' and ' . $countOfData . ' ' . $party . 's';
						}
					}
					break;
			}
			return $htmlString;
		}

		/*public function test(){
			$apiResponse = $this->legis->getAllLegislatorsByState('tx');
			$legisParties = $this->legis->getPartiesInApiResponse($apiResponse);
			$sortedByPartyAndChamber = $this->legis->sortChamber($apiResponse, $legisParties);
			echo "<pre>";
			var_dump($sortedByPartyAndChamber);
		}

		public function testUpper(){
			$results = $this->legis->getSenateLegislatorsByState('FL');
			echo "<pre>";
			print_r($results);
		}

		public function testSortSenate(){
			$results = $this->legis->getSenateLegislatorsByState('fl');
			$parties = $this->legis->getPartiesInApiResponse($results);
			echo "<pre>";
			var_dump($this->legis->sortSenatorsByParty($results, $parties));
		}

		public function testEvents(){
			$fullResponse = $this->events->getEventsForSelectedState('fl');
			$result = $this->events->upcomingEvents($fullResponse);
			$numberOfEvents = $this->events->howManyEvents($fullResponse);
			var_dump($result);
		}*/

		public function testSortChamberAndParty(){
			$Legislature = new PoliticsMadeSimple\Legislators();
			$apiResponse = $Legislature->getAllLegislatorsByState('fl');
			$legisParties = $Legislature->getPartiesInApiResponse($apiResponse);
			$sortedByPartyAndChamber = $Legislature->sortChamber($apiResponse, $legisParties);
			echo "<pre>";
			foreach ($sortedByPartyAndChamber as $party => $data) {
				var_dump($data['lower']);
			}
		}

		/*public function testDataError(){
			$apiResponse = $this->legis->getAllLegislatorsByState('tx');
			$legisParties = $this->legis->getPartiesInApiResponse($apiResponse);
			$sortedByPartyAndChamber = $this->legis->sortChamber($apiResponse, $legisParties);
			echo "<pre>";
			var_dump($sortedByPartyAndChamber);
		}*/
	}
