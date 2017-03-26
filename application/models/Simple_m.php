<?php
	require __DIR__ . '/../libraries/Legislators.php';
	require __DIR__ . '/../libraries/States.php';

	use PoliticsMadeSimple\Legislators;

	Class Simple_m extends CI_Model
	{
		public $Legislators;

		public function __construct() {
			$this->Legislators = new Legislators();
		}

		public function getStateData($stateId)
		{
			$iface = "/State.getState";
			$args = "?key=" . _KEY_ . "&o=" . _OUTPUT_ . "&stateId=" . $stateId;
			$json = file_get_contents(_APISERVER_ . $iface . $args);
			//$xml_object = new SimpleXMLElement($xml);
			return json_decode($json);
		}

		public function getOfficeByOfficeState($officeID)
		{
			$iface = "/Address.getOfficeByOfficeState";
			$args = "?key=" . _KEY_ . "&o=" . _OUTPUT_ . "&officeID=" . $officeID;
			$json = file_get_contents(_APISERVER_ . $iface . $args);
			//$xml_object = new SimpleXMLElement($xml);
			return json_decode($json);
		}

		public function getBillsByYear($year)
		{
			$iface = "/Votes.getCategories";
			$args = "?key=" . _KEY_ . "&o=" . _OUTPUT_ . "&year=" . $year;
			$json = file_get_contents(_APISERVER_ . $iface . $args);
			//$xml_object = new SimpleXMLElement($xml);
			return json_decode($json);
		}

		public function getBillsByYearAndState($year, $stateID = NULL)
		{
			$iface = "/Votes.getBillsByYearState";
			$args = "?key=" . _KEY_ . "&o=" . _OUTPUT_ . "&year=" . $year . "&stateID=" . $stateID;
			$json = file_get_contents(_APISERVER_ . $iface . $args);
			return json_decode($json);
		}

		public function getDetailedBillsData($billID)
		{
			$iface = "/Votes.getBill";
			$args = "?key=" . _KEY_ . "&o=" . _OUTPUT_ . "&billID=" . $billID;
			$json = file_get_contents(_APISERVER_ . $iface . $args);
			//$xml_object = new SimpleXMLElement($xml);
			return json_decode($json);
		}

		public function getCurrentStateOfficials($officialsByState)
		{
			foreach($officialsByState->candidateList->candidate->officeParties as &$party)
			{
				if($party == "Democratic")
				{
					unset($party);
				}
			}
			return $officialsByState;
		}

		public function getAllFullStateNamesAndAbbrev()
		{
			$iface = "/State.getStateIDs";
			$args = "?key=" . _KEY_ . "&o=" . _OUTPUT_;
			$json = file_get_contents(_APISERVER_ . $iface . $args);
			//$xml_object = new SimpleXMLElement($xml);
			return json_decode($json);
		}

		public function getElectionsByYearAndState($year, $stateID)
		{
			$iface = "/Election.getElectionByYearState";
			$args = "?key=" . _KEY_ . "&o=" . _OUTPUT_ . "&year=" . $year . "&stateId=" . $stateID;
			$json = file_get_contents(_APISERVER_ . $iface . $args);
			return json_decode($json);
		}

		public function getAllStateOfficials($stateId)
		{
			$iface = "/Officials.getStatewide";
			$args = "?key=" . _KEY_ . "&o=" . _OUTPUT_ . "&stateId=" . $stateId;
			$json = file_get_contents(_APISERVER_ . $iface . $args);
			return json_decode($json);
		}

		public function getByOfficeState($officeId)
		{
			$iface = "/Officials.getByOfficeState";
			$args = "?key=" . _KEY_ . "&o=" . _OUTPUT_ . "&officeId=" . $officeId;
			$json = file_get_contents(_APISERVER_ . $iface . $args);
			return json_decode($json);
		}

		public function getLeadershipPositions($stateId)
		{
			$iface = "/Leadership.getPositions";
			$args = "?key=" . _KEY_ . "&o=" . _OUTPUT_ . "&stateId=" . $stateId;
			$json = file_get_contents(_APISERVER_ . $iface . $args);
			return json_decode($json);
		}

		public function getAllStates()
		{
			return json_decode(file_get_contents(base_url('vendor/jsonFiles/allStates.json')));
		}
	}
