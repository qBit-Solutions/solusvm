<?php

	// Set module configurable options
	function solusvm_ConfigOptions( array $PARAMS ) { global $solusvm; return $solusvm->{__FUNCTION__}($PARAMS); }
	// Define module metadata
	function solusvm_MetaData(array $PARAMS ) { global $solusvm; return $solusvm->{__FUNCTION__}($PARAMS); }