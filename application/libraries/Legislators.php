<?php namespace PoliticsMadeSimple;
	class Legislators{

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
		 * @return array $chamberCounts
		 */
		public function getChamberCounts($sanitizedFullApiResponse){
			$chamberCounts = array(
				'upper' => 0,
				'lower' => 0
			);
			foreach($sanitizedFullApiResponse as $legis){
				if($legis->chamber === 'upper'){
					$chamberCounts['upper']++;
				}
				if($legis->chamber === 'lower'){
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

		/*
		 * Takes a full API response for Legislators and returns a multidimensional array with the parent levels being the
		 * party of the legislator and the children level being the chamber they belong to.
		 *
		 * @param array of objects $fullApiResponse
		 * @param array $parties
		 *
		 * @return array $sortedLegislatorsByChamber[PARTY][CHAMBER][LEGISLATOR OBJECT]
		 */
		public function sortChamber($fullApiResponse, $parties){
			$sortedLegislatorsByChamber = array();
			$chambers = array(
				'upper',
				'lower',
			);
			foreach($fullApiResponse as $legislator){
				if(in_array($legislator->party, $parties) && in_array($legislator->chamber, $chambers)){
					$sortedLegislatorsByChamber[trim($legislator->party)][trim($legislator->chamber)][] = $legislator;
				}
			}
			asort($sortedLegislatorsByChamber);
			return $sortedLegislatorsByChamber;
		}

		/*
		 *
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
