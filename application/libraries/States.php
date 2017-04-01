<?php namespace PoliticsMadeSimple;
	class States {

		protected $baseUrl = 'https://openstates.org/api/v1/metadata/';
		protected $paramIndicator = '?';
		protected $key = 'apikey=loganconnor44@gmail.com';
		protected $and = '&';
		protected $apiResponse;

		protected $statesData;
		protected $stateAbbreviation;
		public $eventsDataAvailable;

		public function __construct(string $stateAbbreviation = ''){
			$apiQuery = $this->baseUrl . $this->paramIndicator . $this->key;
			$apiResponse = file_get_contents($apiQuery);
			$this->statesData = json_decode($apiResponse);
			$this->stateAbbreviation = $stateAbbreviation;
			$this->getEventFlag();
		}

		public function getStatesOverview(){
			$apiQuery = $this->baseUrl . $this->paramIndicator . $this->key;
			$apiResponse = file_get_contents($apiQuery);
			return json_decode($apiResponse);
		}

		/*
		 * Checks if the API response has the property 'upper'
		 *
		 * @param array of objects $fullApiResponse
		 *
		 * @return bool
		 */
		public function doesUpperChamberExist($fullApiResponse){
			return property_exists($fullApiResponse->chambers, 'upper');
		}

		/*
		 * Checks if the API response has the property 'lower'
		 *
		 * @param array of objects $fullApiResponse
		 *
		 * @return bool
		 */
		public function doesLowerChamberExist($fullApiResponse){
			return property_exists($fullApiResponse->chambers, 'lower');
		}

		public function getAllStateNamesAndAbbrevs($statesOverviewResponse){
			$stateNameAndAbbrev = array();
			foreach($statesOverviewResponse as $state){
				$stateNameAndAbbrev[$state->abbreviation] = $state->name;
			}
			return $stateNameAndAbbrev;
		}

		public function linkAbbrevToStateFullName($strAbbrev){
			$localStatesJson = json_decode(file_get_contents(base_url('assets/json/states.json')));
			$state[strtoupper($strAbbrev)] = $localStatesJson->{$strAbbrev};
			return $state;
		}

		public function getStateDetail($userAbbrevState){
			$apiQuery = $this->baseUrl . $userAbbrevState . $this->paramIndicator . $this->key;
			$apiResponse = file_get_contents($apiQuery);
			return json_decode($apiResponse);
		}

		/**
		 * Returns false unless within the states json, the state we are searching for has events as one of the strings
		 * in the attribute feature_flags.
		 *
		 * @return bool
		 */
		public function getEventFlag() {
			$this->eventsDataAvailable = FALSE;
			if(isset($this->statesData)) {
				foreach ($this->statesData as $data) {
					if ($data->abbreviation === $this->stateAbbreviation) {
						if (in_array('events', $data->feature_flags)) {
							$this->eventsDataAvailable = TRUE;
						}
					}
				}
			}
		}
	}
