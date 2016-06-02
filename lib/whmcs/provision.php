<?php

	//  Run VPS create functions on SolusVM master
	function solusvm_CreateAccount( array $PARAMS ) { global $solusvm; return $solusvm->{__FUNCTION__}($PARAMS); }

	// Run VPS suspend function on SolusVM master
	function solusvm_SuspendAccount( array $PARAMS ) { global $solusvm; return $solusvm->{__FUNCTION__}($PARAMS); }

	// Run VPS un-suspend function on SolusVM master
	function solusvm_UnsuspendAccount( array $PARAMS ) { global $solusvm; return $solusvm->{__FUNCTION__}($PARAMS); }

	//Run VPS terminate function on SolusVM master
	function solusvm_TerminateAccount( array $PARAMS ) { global $solusvm; return $solusvm->{__FUNCTION__}($PARAMS); }

	//Run VPS change root password function on SolusVM master
	function solusvm_ChangePassword( array $PARAMS ) { global $solusvm; return $solusvm->{__FUNCTION__}($PARAMS); }

	//Run change plan function on SolusVM master
	function solusvm_ChangePackage( array $PARAMS ) { global $solusvm; return $solusvm->{__FUNCTION__}($PARAMS); }

	// test the connection between WHMCS and SolusVM master
	function solusvm_TestConnection( array $PARAMS ) { global $solusvm; return $solusvm->{__FUNCTION__}($PARAMS); }

	// update VPS resources usage
	function solusvm_UsageUpdate( array $PARAMS ) { global $solusvm; return $solusvm->{__FUNCTION__}($PARAMS);}