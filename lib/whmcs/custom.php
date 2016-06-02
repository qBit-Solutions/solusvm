<?php

	//REGISTER ADMUN CUSTOM BUTTONS AND THEIR FUNCTIONS
	function solusvm_AdminCustomButtonArray( $PARAMS ) { global $solusvm; return $solusvm->{__FUNCTION__}($PARAMS); }

	// Enable TUN/TAP feature on the VPS
	function solusvm_TUN( array $PARAMS ) { global $solusvm; return $solusvm->{__FUNCTION__}($PARAMS); }

	// enable TUN/TAP feature on the VPS
	function solusvm_PPP( array $PARAMS ) { global $solusvm; return $solusvm->{__FUNCTION__}($PARAMS); }

	// reset bandwidth usage
	function solusvm_resetBW( array $PARAMS ) {	global $solusvm; return $solusvm->{__FUNCTION__}($PARAMS); }

	// change VPS hostname
	function solusvm_change_hostname( array $PARAMS ) { global $solusvm; return $solusvm->{__FUNCTION__}($PARAMS); }