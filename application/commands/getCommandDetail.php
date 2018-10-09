<?php

include '../../../application/configuration/config.php';
include '../../../application/configuration/opendb.php';

$command = array();

if ($_SESSION["USUARIO"][0]['IDROLES'] == 1) {
	$sql = "SELECT `COMMANDS`.`IDCOMMAND` AS iComanda,
				`TYPECOMMAND`.`TCNAME` AS sTipoComanda,
				`STATUS`.`SNAME` AS sEstatus,
				`FK_COMMANDS_DRIVERS`.`FCDDATE` AS sDespachada,
				`COMMANDS`.`CMCREATIONDATE` AS sFechaRegistro,
				`COMMANDS`.`CMADDRESS` AS sDireccion,
				`COMMANDS`.`CMSUITE` AS sSuite,		
				`COMMANDS`.`CMCITY` AS sCiudad,
				`COMMANDS`.`CMPC` AS sCP,
				`COMMANDS`.`CMADDRESSDELIVERY` AS sDireccionEntrega,
				`COMMANDS`.`CMSUITEDELIVERY` AS sSuiteEntrega,
				`COMMANDS`.`CMCITYDELIVERY` AS sCiudadEntrega,
				`COMMANDS`.`CMPCDELIVERY` AS sCPEntrega,
				`COMMANDS`.`CMINSTRUCTIONS` AS sInstrucciones,
				TRACINGCONFIRM.`TDATE` AS sDateConfirm,
				TRACINGPICKUP.`TDATE` AS sDatePickup,
				TRACINGDELIVERY.`TDATE` AS sDateDelivery,
				TRACINGPICKUP.`TIMAGEN` AS oImgPickup,
				TRACINGDELIVERY.`TIMAGEN` AS oImgDelivery,
				TRACINGDELIVERY.`TNOMBRE` AS sNombre,
				`SIGNATURES`.`SGSCORE`,
				`SIGNATURES`.`SGIMAGESIGNATURE`,
				`DRIVERS`.`dNAME` as NameChofer
			FROM `syswareo_haxpres`.`COMMANDS`
				INNER JOIN`syswareo_haxpres`.`STATUS`
					ON `STATUS`.`IDSTATUS` = `COMMANDS`.`IDSTATUS`
				INNER JOIN `syswareo_haxpres`.`TYPECOMMAND`
					ON `TYPECOMMAND`.`IDTYPECOMAMAND` = `COMMANDS`.`IDTYPECOMAMAND`
				INNER JOIN `syswareo_haxpres`.`SCHEDULES`
					ON `SCHEDULES`.`IDSCHEDULE` = `COMMANDS`.`IDSCHEDULE`
				LEFT JOIN `syswareo_haxpres`.`FK_COMMANDS_DRIVERS`
					ON `FK_COMMANDS_DRIVERS`.`IDCOMMAND` = `COMMANDS`.`IDCOMMAND`
				LEFT JOIN `syswareo_haxpres`.`DRIVERS`
					ON `DRIVERS`.`IDDRIVER` = `FK_COMMANDS_DRIVERS`.`IDDRIVER`
				LEFT JOIN `syswareo_haxpres`.`TRACINGS` AS TRACINGCONFIRM
					ON TRACINGCONFIRM.`IDCOMMAND` = `COMMANDS`.`IDCOMMAND` AND TRACINGCONFIRM.`IDSTATUS` = 2
				LEFT JOIN `syswareo_haxpres`.`TRACINGS` AS TRACINGPICKUP
					ON TRACINGPICKUP.`IDCOMMAND` = `COMMANDS`.`IDCOMMAND` AND TRACINGPICKUP.`IDSTATUS` = 3
				LEFT JOIN `syswareo_haxpres`.`TRACINGS` AS TRACINGDELIVERY
					ON TRACINGDELIVERY.`IDCOMMAND` = `COMMANDS`.`IDCOMMAND` AND TRACINGDELIVERY.`IDSTATUS` = 4
				LEFT JOIN `syswareo_haxpres`.`SIGNATURES`
					ON `SIGNATURES`.`IDCOMMAND` = `COMMANDS`.`IDCOMMAND`
			WHERE `COMMANDS`.`IDCOMMAND` = {$_REQUEST['iCommand']};";
} else {
	$sql = "SELECT `COMMANDS`.`IDCOMMAND` AS iComanda,
				`TYPECOMMAND`.`TCNAME` AS sTipoComanda,
				`STATUS`.`SNAME` AS sEstatus,
				`FK_COMMANDS_DRIVERS`.`FCDDATE` AS sDespachada,
				`COMMANDS`.`CMCREATIONDATE` AS sFechaRegistro,
				`COMMANDS`.`CMADDRESS` AS sDireccion,
				`COMMANDS`.`CMSUITE` AS sSuite,		
				`COMMANDS`.`CMCITY` AS sCiudad,
				`COMMANDS`.`CMPC` AS sCP,
				`COMMANDS`.`CMADDRESSDELIVERY` AS sDireccionEntrega,
				`COMMANDS`.`CMSUITEDELIVERY` AS sSuiteEntrega,
				`COMMANDS`.`CMCITYDELIVERY` AS sCiudadEntrega,
				`COMMANDS`.`CMPCDELIVERY` AS sCPEntrega,
				`COMMANDS`.`CMINSTRUCTIONS` AS sInstrucciones,
				TRACINGCONFIRM.`TDATE` AS sDateConfirm,
				TRACINGPICKUP.`TDATE` AS sDatePickup,
				TRACINGDELIVERY.`TDATE` AS sDateDelivery,
				TRACINGPICKUP.`TIMAGEN` AS oImgPickup,
				TRACINGDELIVERY.`TIMAGEN` AS oImgDelivery,
				TRACINGDELIVERY.`TNOMBRE` AS sNombre,
				`SIGNATURES`.`SGSCORE`,
				`SIGNATURES`.`SGIMAGESIGNATURE`,
				`DRIVERS`.`dNAME` as NameChofer
			FROM `syswareo_haxpres`.`COMMANDS`
				INNER JOIN`syswareo_haxpres`.`STATUS`
					ON `STATUS`.`IDSTATUS` = `COMMANDS`.`IDSTATUS`
				INNER JOIN `syswareo_haxpres`.`TYPECOMMAND`
					ON `TYPECOMMAND`.`IDTYPECOMAMAND` = `COMMANDS`.`IDTYPECOMAMAND`
				INNER JOIN `syswareo_haxpres`.`SCHEDULES`
					ON `SCHEDULES`.`IDSCHEDULE` = `COMMANDS`.`IDSCHEDULE`
				LEFT JOIN `syswareo_haxpres`.`FK_COMMANDS_DRIVERS`
					ON `FK_COMMANDS_DRIVERS`.`IDCOMMAND` = `COMMANDS`.`IDCOMMAND`
				LEFT JOIN `syswareo_haxpres`.`DRIVERS`
					ON `DRIVERS`.`IDDRIVER` = `FK_COMMANDS_DRIVERS`.`IDDRIVER`
				LEFT JOIN `syswareo_haxpres`.`TRACINGS` AS TRACINGCONFIRM
					ON TRACINGCONFIRM.`IDCOMMAND` = `COMMANDS`.`IDCOMMAND` AND TRACINGCONFIRM.`IDSTATUS` = 2
				LEFT JOIN `syswareo_haxpres`.`TRACINGS` AS TRACINGPICKUP
					ON TRACINGPICKUP.`IDCOMMAND` = `COMMANDS`.`IDCOMMAND` AND TRACINGPICKUP.`IDSTATUS` = 3
				LEFT JOIN `syswareo_haxpres`.`TRACINGS` AS TRACINGDELIVERY
					ON TRACINGDELIVERY.`IDCOMMAND` = `COMMANDS`.`IDCOMMAND` AND TRACINGDELIVERY.`IDSTATUS` = 4
				LEFT JOIN `syswareo_haxpres`.`SIGNATURES`
					ON `SIGNATURES`.`IDCOMMAND` = `COMMANDS`.`IDCOMMAND`
			WHERE `COMMANDS`.`IDCOMMAND` = {$_REQUEST['iCommand']}
				AND `COMMANDS`.`IDCUSTOMER` = {$_SESSION["USUARIO"][0]['IDCUSTOMER']};";
}


$registros = mysqli_query($conexion, $sql);
$error     = mysqli_error($conexion);

while ($row = mysqli_fetch_assoc($registros)) {
    $command = $row;
}

mysqli_free_result($registros);

include '../../../application/configuration/closedb.php';

?>