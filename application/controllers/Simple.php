<?php defined('BASEPATH') OR exit('No direct script access allowed');
	class Simple extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			$this->load->model('Simple_m', 'simple');
			$this->load->helper('url');
			$this->load->library(array(
				'officials' => 'offs',
				'legislators' => 'legis',
				'states' => 'states',
				'events' => 'events'
			));
		}

		public function index()
		{
			$redirectMethodNames = array(
				'officialsByState' => 'officialsByState',
				'elections' => 'elections',
				'legislators' => 'legislators',
				'bills' => 'bills'
			);

			$statesOverview = $this->states->getStatesOverview();
			$stateNamesAndAbbrev = $this->states->getAllStateNamesAndAbbrevs($statesOverview);

			$data = array(
				'states' => $stateNamesAndAbbrev,
				'methodNames' => $redirectMethodNames,
				'landingPage' => TRUE,
			);
			$this->load->view('main_v', $data);
		}

		public function ajaxAllStates()
		{
			$statesOverview = $this->states->getStatesOverview();
			$stateNamesAndAbbrev = $this->states->getAllStateNamesAndAbbrevs($statesOverview);
			return $stateNamesAndAbbrev;
		}

		public function testing()
		{
			$statesOverview = $this->states->getStatesOverview();

			$data = array(
				'billsJSON' => $this->simple->getBillsByYearAndState('2016'),
				'statesOverview' => $statesOverview,
				'stateNames' => $this->states->getAllStateNamesAndAbbrevs($statesOverview)
			);
			$this->load->view('test_v', $data);
		}

		public function testEvents(){
			$statesOverview = $this->states->getStatesOverview();
			$statesOverview = $this->events->getEventsForSelectedState();
		}

		public function elections()
		{
			$year = date("Y");
			$userDefinedState = $this->input->post('stateSelect');
			$electionResponse = $this->simple->getElectionsByYearAndState($year, $userDefinedState);
			$formattedElectionResponse = $this->formatElectionsData($electionResponse);

			$data = array(
				'electionResponse' => $formattedElectionResponse,
				'selectedState' => $userDefinedState,
				'currentYear' => $year
			);
			$this->load->view('stateElections_v', $data);
		}

		public function legislators()
		{
			$civicDataBy = 'OpenStates.org';
			$userDefinedState = $this->input->post('stateSelect');
			$apiResponse = $this->legis->getAllLegislatorsByState($userDefinedState);
			$sortedParties = $this->legis->sortAllLegislatorsByParty($apiResponse);

			$data = array(
				'selectedState' => strtoupper($userDefinedState),
				'officials' => $sortedParties,
				'totalLegislators' => count($apiResponse),
				'civicDataBy' => $civicDataBy
			);
			$this->load->view('stateLegislators_v', $data);
		}

		/*
		 * deprecated
		 */
		/*public function officials()
		{
			$civicDataBy = 'VoteSmart.org';
			$userDefinedState = $this->input->post('stateSelect');
			$officialsByState = $this->simple->getAllStateOfficials($userDefinedState);
			$uniqueParties = $this->offs->allPartiesInData($officialsByState);
			$partiesOfficial = $this->offs->separateOfficialsByParty($uniqueParties, $officialsByState);

			$data = array(
				'selectedState' => $userDefinedState,
				'officials' => $partiesOfficial,
				'civicDataBy' => $civicDataBy
			);
			$this->load->view('stateOfficials_v', $data);
		}*/

		public function formatElectionsData($electionResponse)
		{
			foreach($electionResponse as $keyNames => &$electionValue)
			{
				if(property_exists($electionValue, 'error'))
				{
					$electionValue = $electionValue->error->errorMessage;
				}
				if(property_exists($electionValue, 'election'))
				{
					$electionValue = $electionValue->election;
				}
			}
			return $electionResponse;
		}

		public function formatOfficialsData($officialResponse)
		{
			//only return officials who are active
			foreach($officialResponse->candidateList->candidate as $key => $official)
			{
				if($official->officeStatus != 'active')
				{
					//unset($officialResponse->candidateList->candidate[$key]);
				}
			}
			return $officialResponse;
		}



		public function testingElections()
		{
			$userDefinedState = 'VA';
			$year = date("Y");

			$electionResponse = $this->simple->getElectionsByYearAndState($year, $userDefinedState);
			$formattedElectionResponse = $this->formatElectionsData($electionResponse);

			$data = array(
				'electionResponse' => $formattedElectionResponse
			);
			$this->load->view('testElections_v', $data);
		}

		public function formatAllStates($states)
		{
			if(property_exists($states->stateList, 'list'))
			{
				foreach($states->stateList->list->state as $state)
				{
					$stateKeyValueArray[$state->stateId] = $state->name;
				}
				//asort() maintains the array keys; sort() does not
				asort($stateKeyValueArray);
				return $stateKeyValueArray;
			}
			else
			{
				return 0;
			}
		}

		public function testGetAllStates()
		{
			$states = $this->simple->getAllFullStateNamesAndAbbrev();
			if(property_exists($states->stateList, 'list'))
			{
				foreach($states->stateList->list->state as $state)
				{
					$sortedStates[$state->stateId] = $state->name;
				}
				sort($sortedStates);
				var_dump($sortedStates);
			}
			else
			{
				var_dump($states);
			}
		}

		public function example()
		{
			require_once("/Applications/MAMP/htdocs/voteSmartProj/application/vendor/php-votesmart-master/VoteSmart.php");

			// Initialize the VoteSmart object
			$obj = new VoteSmart('CandidateBio.getBio', array(
				'candidateId' => 9026
			));

			// Get the SimpleXML object
			$x = $obj->getXmlObj();



			$this->load->view('example_v', $x);
		}

		public function district()
		{
			require_once("/Applications/MAMP/htdocs/voteSmartProj/application/vendor/php-votesmart-master/district.php");
			// Initialize the District class
			$district_object = new District();

			// Get the SimpleXML object
			$x = $district_object->getByOfficeState(6, 'PA');
			$this->load->view('district_v', $x);
		}

		public function echos()
		{
			echo dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
		}

		public function testOpenStates(){
			$apiResponse = $this->legis->getAllLegislatorsByState('FL');
			$sortedParties = $this->legis->sortAllLegislatorsByParty($apiResponse);
			echo "<pre>";
			var_dump($sortedParties);

			$data = array(
				'numberOfLegislators' => count($apiResponse)
			);
		}

		public function testLeadershipPositions(){
			echo "<pre>";
			var_dump($this->legis->getAllLegislatorsByState('FL'));
		}

		public function getSpeakOfHouse(){
			$apiResponse = $this->simple->getByOfficeState('5');
			foreach($apiResponse->candidateList->candidate as $official)
			{
				if(trim($official->officeTypeId) === 'C'){
					var_dump($official);
				}
			}
		}
	}
