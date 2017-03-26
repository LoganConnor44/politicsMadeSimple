<?php namespace PoliticsMadeSimple;
	class Legislators {

		protected $baseUrl = 'https://openstates.org/api/v1/legislators/';
		protected $paramIndicator = '?';
		protected $key = 'apikey=loganconnor44@gmail.com';
		protected $and = '&';
		protected $state = 'state=';
		protected $firstName = 'first_name=';
		protected $lastName = 'last_name=';
		protected $chamber = 'chamber=';
		protected $active = 'active=';
		protected $term = 'term=';
		protected $district = 'district=';
		protected $party = 'party=';

		public function getAllLegislatorsByState($stateAbbrev){
			$apiQuery = $this->baseUrl . $this->paramIndicator . $this->key . $this->and . $this->state . $stateAbbrev;
			$apiResponse = file_get_contents($apiQuery);
			return json_decode($apiResponse);
		}

		/**
		 * Removes any legislator data that does not contain a chamber.
		 *
		 * @param $fullApiResponse
		 *
		 * @return mixed $fullApiResponse
		 */
		public function sanitizeFullApiResponse($fullApiResponse){
			foreach($fullApiResponse as $key => &$legislator) {
				//if chamber does not exist - delete the data
				if(!property_exists($legislator, 'chamber')) {
					unset($fullApiResponse[$key]);
				}
				//if party does not exist - set it as 'No Data'
				if(!isset($legislator->party)){
					$legislator->party = 'No Data';
				}
			}
			return $fullApiResponse;
		}

		/**
		 * Counts the number of legislators in the upper and lower chambers. Returns the amount as an array.
		 *
		 * @param array $sanitizedFullApiResponse
		 *
		 * @return array $chamberCounts[CHAMBER] => int
		 */
		public function getChamberCounts(array $sanitizedFullApiResponse){
			$chamberCounts = array(
				'upper' => 0,
				'lower' => 0
			);
			foreach($sanitizedFullApiResponse as $legislator){
				if(isset($legislator->chamber) && $legislator->chamber === 'upper'){
					$chamberCounts['upper']++;
				}
				if(isset($legislator->chamber) && $legislator->chamber === 'lower'){
					$chamberCounts['lower']++;
				}
			}
			return $chamberCounts;
		}

		/**
		 * Takes a full API response for Legislators and creates a new array with all of the available parties, sorts the
		 * arrays, and then removes any duplicates.
		 * NOTE: a known issue is dirty data (specifically Texas) returning Democrat AND Democratic
		 *
		 * @param mixed $sanitizedFullApiResponse
		 *
		 * @return array $parties
		 * @todo find solution for SIMILAR strings in an array
		 */
		public function getPartiesInApiResponse($sanitizedFullApiResponse){
			$parties = array();
			foreach($sanitizedFullApiResponse as &$legis){
				$parties[trim($legis->party)] = trim($legis->party);
			}
			asort($parties);
			array_unique($parties);
			return $parties;
		}

		/**
		 * Takes the full api response, $fullApiResponse, and the parties found in the state, $partiesInState, then
		 * iterates through $fullApiResponse and populates a new array if the legislator has a party associated that is
		 * a party that was passed in as $partiesInState. The returned array is then alphabetically sorted.
		 *
		 * @param mixed $sanitizedResponse
		 * @param array $partiesInState
		 *
		 * @return array $sortedLegislatorsByParty[PARTY][LEGISLATOR OBJECT]
		 */
		public function sortAllLegislatorsByParty($sanitizedResponse, $partiesInState){
			$sortedLegislatorsByParty = array();
			foreach($sanitizedResponse as $legislator){
				if(in_array($legislator->party, $partiesInState)){
					$sortedLegislatorsByParty[$legislator->party][] = $legislator;
				}
			}
			asort($sortedLegislatorsByParty);
			return $sortedLegislatorsByParty;
		}

		/**
		 * Takes a full API response for Legislators and returns a multidimensional array with the parent levels being the
		 * party of the legislator and the children level being the chamber they belong to.
		 *
		 * @param mixed $sanitizedResponse
		 * @param array $parties
		 *
		 * @return array $sortedLegislatorsByChamber[PARTY][CHAMBER][LEGISLATOR OBJECT]
		 */
		public function sortChamber($sanitizedResponse, $parties){
			$sortedLegislatorsByChamber = array();
			$chambers = array(
				'upper',
				'lower',
			);
			foreach($sanitizedResponse as $legislator){
				if(in_array($legislator->party, $parties) && in_array($legislator->chamber, $chambers)){
					$sortedLegislatorsByChamber[trim($legislator->party)][trim($legislator->chamber)][] = $legislator;
				}
			}
			asort($sortedLegislatorsByChamber);
			return $sortedLegislatorsByChamber;
		}

		/**
		 * Takes the return from sortChamber() and creates a new mixed array with only the upper chamber legislator data.
		 * E.G. $upperChamberLegislators[PARTY]['upper'][LEGISLATOR OBJECT]
		 *
		 * NOTE: This function is a convenience function the data is already stored in the return of sortChamber()
		 *
		 * @param $sanitizedResponse
		 * @param $partiesInState
		 *
		 * @return array
		 */
		public function getUpperChamberByState($sanitizedResponse, $partiesInState) {
			$sortedByChamber = $this->sortChamber($sanitizedResponse, $partiesInState);
			$upperChamberLegislators = array();
			foreach ($sortedByChamber as $party => $chamberValue) {
				if (isset($sortedByChamber[$party]['upper'])) {
					$upperChamberLegislators[$party] = $sortedByChamber[$party]['upper'];
				}
			}
			return $upperChamberLegislators;
		}

		/**
		 * Takes the return from sortChamber() and creates a new mixed array with only the lower chamber legislator data.
		 * E.G. $lowerChamberLegislators[PARTY]['upper'][LEGISLATOR OBJECT]
		 *
		 * NOTE: This function is a convenience function the data is already stored in the return of sortChamber()
		 *
		 * @param $sanitizedResponse
		 * @param $partiesInState
		 *
		 * @return array
		 */
		public function getLowerChamberByState($sanitizedResponse, $partiesInState) {
			$sortedByChamber = $this->sortChamber($sanitizedResponse, $partiesInState);
			$lowerChamberLegislators = array();
			foreach ($sortedByChamber as $party => $chamberValue) {
				if (isset($sortedByChamber[$party]['lower'])) {
					$lowerChamberLegislators[$party] = $sortedByChamber[$party]['lower'];
				}
			}
			return $lowerChamberLegislators;
		}

		/**
		 * Takes the array $upperChamberLegislators[PARTY][CHAMBER][LEGISLATOR OBJECT]
		 * This array is then counted to see how many parties are stored, then it counts the next level down, Chamber.
		 * The difference of these two amounts indicates how many legislators are in the upper chamber.
		 *
		 * @param mixed $legislatorsSortedByChamber
		 *
		 * @return int $correctNumberOfOfficialsInChamber
		 */
		public function countAnyChamber(array $legislatorsSortedByChamber) {
			$numberOfParties = count($legislatorsSortedByChamber);
			$correctNumberOfOfficialsInChamber = count($legislatorsSortedByChamber, 1) - $numberOfParties;
			return $correctNumberOfOfficialsInChamber;
		}

		/*
		 * Depreciated
		 * This was an extra call that didn't need to be implemented
		 * Use getUpperChamberByState() instead
		 */
		public function getSenateLegislatorsByState($stateAbbrev){
			$apiQuery = $this->baseUrl . $this->paramIndicator . $this->key . $this->and . $this->state . $stateAbbrev .
				$this->and . $this->chamber . 'upper';
			$apiResponse = file_get_contents($apiQuery);
			return json_decode($apiResponse);
		}

		/*
		 * Takes the return of getSenateLegislatorsByState(), $senatorsByState, and sorts each by $partiesInState
		 */
		public function sortSenatorsByParty($senatorsByState, $partiesInState){
			$sortedSenatorsByParty = array();
			foreach($senatorsByState as $electedOfficial){
				if(in_array($electedOfficial->party, $partiesInState)){
					$sortedSenatorsByParty[$electedOfficial->party][] = $electedOfficial;
				}
			}
			asort($sortedSenatorsByParty);
			return $sortedSenatorsByParty;
		}


	}
