<?php ?>

<script>
	function createStateSelect(){

		$.ajax({
			url: "<?php echo base_url('Simple/ajaxAllStates')?>",
			success: function(result){
				console.log(result);
			}});


		$statesObj = JSON.parse($statesObj);
		var appendHere = document.getElementById('appendSelectHere');
		var content = document.createElement('div');
		var row = document.createElement('div');
		var inputField = document.createElement('div');
		var select = document.createElement('select');
		content.setAttribute('class', 'card-content blue darken-1');
		row.setAttribute('class', 'row');
		inputField.setAttribute('class', 'input-field col s12');
		inputField.appendChild(select);
		row.appendChild(inputField);
		content.appendChild(row);
		appendHere.appendChild(content);
		console.log($statesObj);
		return true;
	}
</script>
