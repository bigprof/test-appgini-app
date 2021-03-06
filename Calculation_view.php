<?php
// This script and data application were generated by AppGini 5.81
// Download AppGini for free from https://bigprof.com/appgini/download/

	$currDir=dirname(__FILE__);
	include("$currDir/defaultLang.php");
	include("$currDir/language.php");
	include("$currDir/lib.php");
	@include("$currDir/hooks/Calculation.php");
	include("$currDir/Calculation_dml.php");

	// mm: can the current member access this page?
	$perm=getTablePermissions('Calculation');
	if(!$perm[0]) {
		echo error_message($Translation['tableAccessDenied'], false);
		echo '<script>setTimeout("window.location=\'index.php?signOut=1\'", 2000);</script>';
		exit;
	}

	$x = new DataList;
	$x->TableName = "Calculation";

	// Fields that can be displayed in the table view
	$x->QueryFieldsTV = array(
		"`Calculation`.`ID2`" => "ID2",
		"`Calculation`.`Total`" => "Total",
	);
	// mapping incoming sort by requests to actual query fields
	$x->SortFields = array(
		1 => 1,
		2 => '`Calculation`.`Total`',
	);

	// Fields that can be displayed in the csv file
	$x->QueryFieldsCSV = array(
		"`Calculation`.`ID2`" => "ID2",
		"`Calculation`.`Total`" => "Total",
	);
	// Fields that can be filtered
	$x->QueryFieldsFilters = array(
		"`Calculation`.`ID2`" => "ID2",
		"`Calculation`.`Total`" => "Total",
	);

	// Fields that can be quick searched
	$x->QueryFieldsQS = array(
		"`Calculation`.`ID2`" => "ID2",
		"`Calculation`.`Total`" => "Total",
	);

	// Lookup fields that can be used as filterers
	$x->filterers = array();

	$x->QueryFrom = "`Calculation` ";
	$x->QueryWhere = '';
	$x->QueryOrder = '';

	$x->AllowSelection = 1;
	$x->HideTableView = ($perm[2]==0 ? 1 : 0);
	$x->AllowDelete = $perm[4];
	$x->AllowMassDelete = false;
	$x->AllowInsert = $perm[1];
	$x->AllowUpdate = $perm[3];
	$x->SeparateDV = 1;
	$x->AllowDeleteOfParents = 0;
	$x->AllowFilters = 1;
	$x->AllowSavingFilters = 0;
	$x->AllowSorting = 1;
	$x->AllowNavigation = 1;
	$x->AllowPrinting = 1;
	$x->AllowPrintingDV = 1;
	$x->AllowCSV = 1;
	$x->RecordsPerPage = 10;
	$x->QuickSearch = 1;
	$x->QuickSearchText = $Translation["quick search"];
	$x->ScriptFileName = "Calculation_view.php";
	$x->RedirectAfterInsert = "Calculation_view.php?SelectedID=#ID#";
	$x->TableTitle = "Calculation";
	$x->TableIcon = "table.gif";
	$x->PrimaryKey = "`Calculation`.`ID2`";

	$x->ColWidth   = array(  150);
	$x->ColCaption = array("Total");
	$x->ColFieldName = array('Total');
	$x->ColNumber  = array(2);

	// template paths below are based on the app main directory
	$x->Template = 'templates/Calculation_templateTV.html';
	$x->SelectedTemplate = 'templates/Calculation_templateTVS.html';
	$x->TemplateDV = 'templates/Calculation_templateDV.html';
	$x->TemplateDVP = 'templates/Calculation_templateDVP.html';

	$x->ShowTableHeader = 1;
	$x->TVClasses = "";
	$x->DVClasses = "";
	$x->HighlightColor = '#FFF0C2';
	$x->HasCalculatedFields = true;

	// mm: build the query based on current member's permissions
	$DisplayRecords = $_REQUEST['DisplayRecords'];
	if(!in_array($DisplayRecords, array('user', 'group'))) { $DisplayRecords = 'all'; }
	if($perm[2]==1 || ($perm[2]>1 && $DisplayRecords=='user' && !$_REQUEST['NoFilter_x'])) { // view owner only
		$x->QueryFrom.=', membership_userrecords';
		$x->QueryWhere="where `Calculation`.`ID2`=membership_userrecords.pkValue and membership_userrecords.tableName='Calculation' and lcase(membership_userrecords.memberID)='".getLoggedMemberID()."'";
	}elseif($perm[2]==2 || ($perm[2]>2 && $DisplayRecords=='group' && !$_REQUEST['NoFilter_x'])) { // view group only
		$x->QueryFrom.=', membership_userrecords';
		$x->QueryWhere="where `Calculation`.`ID2`=membership_userrecords.pkValue and membership_userrecords.tableName='Calculation' and membership_userrecords.groupID='".getLoggedGroupID()."'";
	}elseif($perm[2]==3) { // view all
		// no further action
	}elseif($perm[2]==0) { // view none
		$x->QueryFields = array("Not enough permissions" => "NEP");
		$x->QueryFrom = '`Calculation`';
		$x->QueryWhere = '';
		$x->DefaultSortField = '';
	}
	// hook: Calculation_init
	$render=TRUE;
	if(function_exists('Calculation_init')) {
		$args=array();
		$render=Calculation_init($x, getMemberInfo(), $args);
	}

	if($render) $x->Render();

	// hook: Calculation_header
	$headerCode='';
	if(function_exists('Calculation_header')) {
		$args=array();
		$headerCode=Calculation_header($x->ContentType, getMemberInfo(), $args);
	}  
	if(!$headerCode) {
		include_once("$currDir/header.php"); 
	}else{
		ob_start(); include_once("$currDir/header.php"); $dHeader=ob_get_contents(); ob_end_clean();
		echo str_replace('<%%HEADER%%>', $dHeader, $headerCode);
	}

	echo $x->HTML;
	// hook: Calculation_footer
	$footerCode='';
	if(function_exists('Calculation_footer')) {
		$args=array();
		$footerCode=Calculation_footer($x->ContentType, getMemberInfo(), $args);
	}  
	if(!$footerCode) {
		include_once("$currDir/footer.php"); 
	}else{
		ob_start(); include_once("$currDir/footer.php"); $dFooter=ob_get_contents(); ob_end_clean();
		echo str_replace('<%%FOOTER%%>', $dFooter, $footerCode);
	}
?>