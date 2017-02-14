<?php
	class Events{

		protected $baseUrl = 'https://openstates.org/api/v1/events/';
		protected $paramIndicator = '?';
		protected $key = 'apikey=loganconnor44@gmail.com';
		protected $and = '&';
		protected $state = 'state=';

		public function getEventsForSelectedState($stateAbbrev){
			$apiQuery = $this->baseUrl . $this->paramIndicator . $this->state . $stateAbbrev . $this->key;
			$apiResponse = file_get_contents($apiQuery);
			return json_decode($apiResponse);
		}

		public function upcomingEvents($fullApiResponse){
			$areThereUpcomingEvents = TRUE;
			if(!$fullApiResponse){
				$areThereUpcomingEvents = FALSE;
			}
			return $areThereUpcomingEvents;
		}
	}
