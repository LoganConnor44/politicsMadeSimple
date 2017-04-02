<?php namespace PoliticsMadeSimple;

use DateTime;

class Events {

	protected $baseUrl = 'https://openstates.org/api/v1/events/';
	protected $paramIndicator = '?';
	protected $key = 'apikey=loganconnor44@gmail.com';
	protected $and = '&';
	protected $state = 'state=';
	protected $response;
	public $upcomingEvents;
	public $eventData;
	public $howManyEvents = 0;
	public $dateDifference;

	public function __construct($stateAbbrev){
		$apiQuery = $this->baseUrl . $this->paramIndicator . $this->state . $stateAbbrev . $this->and . $this->key;
		$apiResponse = file_get_contents($apiQuery);
		$this->response = json_decode($apiResponse);
		$this->upcomingEvents();
		if ($this->upcomingEvents) {
			$this->organizeEventData($this->response);
			$this->howManyEvents();
			date_default_timezone_set("America/New_York");
			$today = new DateTime();
			$today->format('Y-m-d H:i:s');
			foreach ($this->eventData as $data) {
				$dateDifference = $this->dateDifference($data->when, $today);
				$data->dateDifference = $dateDifference;
			}
		}
	}

	/**
	 * Checks if there are events in the response json and assigned a boolean to $upcomingEvents.
	 * NOTE: if there are no events, an empty json will be returned in the response
	 */
	public function upcomingEvents(){
		$this->upcomingEvents = TRUE;
		if(!$this->response){
			$this->upcomingEvents = FALSE;
		}
	}

	/**
	 * Takes the $apiResponse from getEventsForSelectedState() and organizes it by creating the id of the event as the
	 * key of the object.
	 *
	 * @param $apiResponse
	 */
	public function organizeEventData ($apiResponse){
		foreach($apiResponse as $data) {
			$this->eventData[$data->id] = $data;
		}
	}

	/**
	 * Updates the class global count of upcoming events.
	 */
	public function howManyEvents(){
		$this->howManyEvents = count($this->eventData);
	}

	/**
	 * Checks a boolean value if there are upcoming events, and if there are returns a string with the number of events.
	 *
	 * @return string
	 */
	public function htmlIsThereAnUpcomingEvent() {
		if (!$this->eventData) {
			return "There are no upcoming events.";
		}
		return "There are $this->howManyEvents upcoming events.";
	}

	public function htmlQuickView() {
		date_default_timezone_set("America/New_York");
		$today = new DateTime();
		$today->format('Y-m-d H:i:s');
		foreach($this->eventData as $data) {
			$dateDifference = $this->dateDifference($data->when, $today);
			$string = "$data->description";
			$mainArray[] = $string;
		}
		return $mainArray;
	}

	/**
	 * Takes the current date and finds the number of days between then and the date passed in as $when.
	 *
	 * @param string $when
	 * @param DateTime object $now
	 *
	 * @return string $difference
	 */
	public function dateDifference($when, $now){
		$dt = new DateTime($when);
		$difference = $now->diff($dt)->days;
		if ($now > $dt) {
			$difference = -1 * $difference;
		}
		if ($difference < 0 ) {

			$finalString = (string) -1*$difference . " Days Ago";
		} else if ($difference == 0){
			$finalString = "Today";
		} else {
			$finalString = "In " . (string) $difference . " Days";
		}
		return $finalString;
	}
}
