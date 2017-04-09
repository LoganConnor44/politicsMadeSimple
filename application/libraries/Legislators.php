<?php
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

		public function getChamberCounts($fullApiResponse){
			$chamberCounts = array(
				'upper' => 0,
				'lower' => 0
			);
			foreach($fullApiResponse as $legis){
				if($legis->chamber === 'upper'){
					$chamberCounts['upper']++;
				}
				if($legis->chamber === 'lower'){
					$chamberCounts['lower']++;
				}
			}
			return $chamberCounts;
		}

		/*
		 * Takes a full API response for Legislators and creates a new array with all of the available parties, sorts the
		 * arrays, and then removes any duplicates.
		 * NOTE: a known issue is dirty data (specifically Texas) returning Democrat AND Democratic
		 *
		 * @param array of objects $fullApiResponse
		 *
		 * @return array $parties
		 * @todo find solution for SIMILAR strings in an array
		 */
		public function getPartiesInApiResponse($fullApiResponse){
			$parties = array();
			foreach($fullApiResponse as &$legis){
				if(!isset($legis->party)){
					var_dump($legis);
				}
				$parties[trim($legis->party)] = trim($legis->party);
			}
			asort($parties);
			array_unique($parties);
			return $parties;
		}

		public function sortAllLegislatorsByParty($fullApiResponse, $partiesInState){
			$sortedLegislatorsByParty = array();
			foreach($fullApiResponse as $legislator){
				if(in_array($legislator->party, $partiesInState)){
					$sortedLegislatorsByParty[$legislator->party][] = $legislator;
				}
			}
			asort($sortedLegislatorsByParty);
			return $sortedLegislatorsByParty;
		}

		public function getSenateLegislatorsByState($stateAbbrev){
			$apiQuery = $this->baseUrl . $this->paramIndicator . $this->key . $this->and . $this->state . $stateAbbrev .
				$this->and . $this->chamber . 'upper';
			$apiResponse = file_get_contents($apiQuery);
			return json_decode($apiResponse);
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
				'lower'
			);
			foreach($fullApiResponse as $legislator){
				if(in_array($legislator->party, $parties) && in_array($legislator->chamber, $chambers)){
					$sortedLegislatorsByChamber[trim($legislator->party)][trim($legislator->chamber)][] = $legislator;
				}
			}
			asort($sortedLegislatorsByChamber);
			return $sortedLegislatorsByChamber;
		}


	}
