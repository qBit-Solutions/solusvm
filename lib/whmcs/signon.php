<?php

	// initialize single client sign in 
	function solusvm_ServiceSingleSignOn( array $PARAMS ) { global $solusvm; return $solusvm->{__FUNCTION__}($PARAMS); }

	// initalize admin area sign in
	function solusvm_AdminSingleSignOn( array $PARAMS ) { global $solusvm; return $solusvm->{__FUNCTION__}($PARAMS); }