<?php
	class Officials {
		public function __construct(){
		}

		/*
		 * Dynamically creates an array with the unique parties found in the API response. A counter is then given to each
		 * party as a key/value array.
		 *
		 * @param array $uniqueParties
		 * @param object $officialsByState
		 *
		 * @return array $partyNumber
		 */
		public function separateOfficialsByParty($uniqueParties, $officialsByState){
			$partyNumber = array();
			foreach($uniqueParties as $party){
				$partyNumber[$party] = 0;
			}

			foreach($officialsByState->candidateList->candidate as $official){
				foreach($partyNumber as $party => &$number){
					//temporarily convert 'No Data' back to an empty string to accurately collect officials who do not have
					// data for their party value in the api data
					if($party === 'No Data'){
						$party = '';
					}
					if(trim($official->officeParties) === $party){
						$number++;
					}
				}
			}
			return $partyNumber;
		}

		/*
		 * Keep for PHPUnit
		 * Test against dynamically generated parties
		 */
		public function testSeparateOfficialsByParty($officialsByState){
			$partyNumber = array(
				'reps' => 0,
				'dems' => 0
			);
			foreach($officialsByState->candidateList->candidate as $key => $official){
				if(trim($official->officeParties) === 'Republican'){
					$partyNumber['reps']++;
				}
				if(trim($official->officeParties) === 'Democratic'){
					$partyNumber['dems']++;
				}
			}
			return $partyNumber;
		}

		/*
		 * Saves all unique parties to an array and filters fields that are empty '' as 'No Data'
		 *
		 * @param object $officialsByState
		 *
		 * @return array $allParties
		 */
		public function allPartiesInData($officialsByState){
			$allParties = array();
			foreach($officialsByState->candidateList->candidate as $official) {
				if(!trim($official->officeParties === '')){
					$allParties[] = trim($official->officeParties);
				}
				$allParties[] = 'No Data';
			}
			return array_unique($allParties);
		}
	}
