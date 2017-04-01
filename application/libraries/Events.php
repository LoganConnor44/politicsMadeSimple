<?php namespace PoliticsMadeSimple;
class Events {

	protected $baseUrl = 'https://openstates.org/api/v1/events/';
	protected $paramIndicator = '?';
	protected $key = 'apikey=loganconnor44@gmail.com';
	protected $and = '&';
	protected $state = 'state=';
	protected $response;
	public $upcomingEvents;
	protected $eventData;
	public $howManyEvents = 0;

	public function __construct($stateAbbrev){
		$apiQuery = $this->baseUrl . $this->paramIndicator . $this->state . $stateAbbrev . $this->and . $this->key;
		$apiResponse = file_get_contents($apiQuery);
		$this->response = json_decode($apiResponse);
		$this->upcomingEvents();
		if ($this->upcomingEvents) {
			$this->organizeEventData($this->response);
			$this->howManyEvents();
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
}
