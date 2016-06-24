<?php

	//REGISTER ADMUN CUSTOM BUTTONS AND THEIR FUNCTIONS
	function solusvm_AdminCustomButtonArray( $PARAMS ) { global $solusvm; return $solusvm->{__FUNCTION__}($PARAMS); }

	// change VPS hostname
	function solusvm_Update_Hostname( array $PARAMS ) { global $solusvm; return $solusvm->{__FUNCTION__}($PARAMS); }