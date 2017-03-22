<?php defined('BASEPATH') OR exit('No direct script access allowed');

	class Legislature extends CI_Controller{

		public $userDefinedState;
		public $civicDataBy = 'OpenStates.org';

		public function __construct(){
			parent::__construct();
			$this->load->helper('url');
			$this->load->model('simple_m');
			$this->load->library(array(
				'states' => 'states',
				'events' => 'events'
			));
		}

		public function index(){
			$this->userDefinedState = $this->input->post('stateSelect');
			$state = $this->states->linkAbbrevToStateFullName($this->userDefinedState);
			$Legislators = new PoliticsMadeSimple\Legislators();
			$apiResponse = $Legislators->getAllLegislatorsByState($this->userDefinedState);
			$sanitizedResponse = $Legislators->sanitizeFullApiResponse($apiResponse);
			$legisParties = $Legislators->getPartiesInApiResponse($sanitizedResponse);
			$sortedParties = $Legislators->sortAllLegislatorsByParty($sanitizedResponse, $legisParties);
			$sortedByPartyAndChamber = $Legislators->sortChamber($sanitizedResponse, $legisParties);
			$stateDetail = $this->states->getStateDetail($this->userDefinedState);
			$chamberCounts = $Legislators->getChamberCounts($sanitizedResponse);
			$upcomingEvents = $this->events->getEventsForSelectedState($this->userDefinedState);
			$isThereAnUpcomingEvent = $this->events->upcomingEvents($upcomingEvents);
			$isThereAnUpcomingEvent ? $numberOfEvents = $this->events->howManyEvents($upcomingEvents) : $numberOfEvents = FALSE;
			$doesUpperChamberExist = $this->states->doesUpperChamberExist($stateDetail);
			$doesLowerChamberExist = $this->states->doesLowerChamberExist($stateDetail);
			$htmlChamberResponse = $this->formatHtmlBasedOnChamber($doesUpperChamberExist, $doesLowerChamberExist,
				$stateDetail, $chamberCounts);
			$upperChamber = $Legislators->getUpperChamberByState($sanitizedResponse, $legisParties);

			$data = array(
				'stateDetail' => $stateDetail,
				'userDefinedState' => strtoupper($this->userDefinedState),
				'selectedState' => $state,
				'parties' => $sortedParties,
				'totalLegislators' => count($sanitizedResponse),
				'civicDataBy' => $this->civicDataBy,
				'isThereAnUpcomingEvent' => $isThereAnUpcomingEvent,
				'numberOfEvents' => $numberOfEvents,
				'htmlChamberResponse' => $htmlChamberResponse,
				'landingPage' => FALSE,
				'partyAndChamber' => $sortedByPartyAndChamber,
				'upperChamber' => $upperChamber
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
		}

		public function testSortChamberAndParty(){
			$apiResponse = $this->legis->getAllLegislatorsByState('fl');
			$legisParties = $this->legis->getPartiesInApiResponse($apiResponse);
			$sortedByPartyAndChamber = $this->legis->sortChamber($apiResponse, $legisParties);
			echo "<pre>";
			var_dump($sortedByPartyAndChamber);
		}

		public function testDataError(){
			$apiResponse = $this->legis->getAllLegislatorsByState('tx');
			$legisParties = $this->legis->getPartiesInApiResponse($apiResponse);
			$sortedByPartyAndChamber = $this->legis->sortChamber($apiResponse, $legisParties);
			echo "<pre>";
			var_dump($sortedByPartyAndChamber);
		}*/
	}
