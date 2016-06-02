<?php

	//add aditional tab fields in the admin service view
	function solusvm_AdminServicesTabFields( array $PARAMS ) { global $solusvm; return $solusvm->{__FUNCTION__}($PARAMS); }

	// customize the client area 
	function solusvm_ClientArea(array $PARAMS ) { global $solusvm; return $solusvm->{__FUNCTION__}($PARAMS); }