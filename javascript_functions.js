function dropdownSelectionCheck(url){
	if (url.value != '#'){
		if (confirm('Are you sure you wish to navigate to '+url.value+'?')) {
			window.location.href=url.value;
		} else {
		    // Do nothing!
		}
	}
}