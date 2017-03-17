<?php
	namespace PoliticsMadeSimple\Events;

	class Events{

		protected $baseUrl = 'https://openstates.org/api/v1/events/';
		protected $paramIndicator = '?';
		protected $key = 'apikey=loganconnor44@gmail.com';
		protected $and = '&';
		protected $state = 'state=';

		public function getEventsForSelectedState($stateAbbrev){
			$apiQuery = $this->baseUrl . $this->paramIndicator . $this->state . $stateAbbrev . $this->and . $this->key;
			$apiResponse = file_get_contents($apiQuery);
			return json_decode($apiResponse);
		}

		public function upcomingEvents($fullApiResponse){
			$areThereUpcomingEvents = TRUE;
			//if there are no events an empty json will be returned
			if(!$fullApiResponse){
				$areThereUpcomingEvents = FALSE;
			}
			return $areThereUpcomingEvents;
		}

		/*
		 * Returns an integer of the upcoming events.
		 *
		 * @param $apiResponse array of objects
		 *
		 * @return $numberOfEvents integer
		 */
		public function howManyEvents($apiReponse){
			return count($apiReponse);
		}
	}
