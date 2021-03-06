<?php
session_start();
header("Content-Type: application/json");	

include '../configuration/config.php';
include '../configuration/opendb.php';

$response = array();

$idDriver = $_REQUEST["dv"];

if (!(isset($_SESSION["USUARIO"])) && ($_SESSION["USUARIO"] <> "")) {
	echo json_encode($response);
	exit();
}

$sWhere = "";
if ($idDriver != "0") {
	$sWhere = " AND `DRIVERS`.`IDDRIVER` = " . $idDriver . " "; 
}

$sql = "SELECT `COMMANDS`.`IDCOMMAND`,
			`DRIVERS`.`DNAME`,
		    `COMMANDS`.`CMCOMPANY`,
		    `COMMANDS`.`CMCONTAC`,
		    `COMMANDS`.`CMADDRESS`,
		    `COMMANDS`.`CMSUITE`,
		    `COMMANDS`.`CMCITY`,
		    `COMMANDS`.`CMPC`,
		    `COMMANDS`.`CMPHONE`,
		    `COMMANDS`.`CMCOMPANYDELIVERY`,
		    `COMMANDS`.`CMCONTACDELIVERY`,
		    `COMMANDS`.`CMADDRESSDELIVERY`,
		    `COMMANDS`.`CMSUITEDELIVERY`,
		    `COMMANDS`.`CMCITYDELIVERY`,
		    `COMMANDS`.`CMPCDELIVERY`,
		    `COMMANDS`.`CMPHONEDELIVERY`,
		    `COMMANDS`.`CMQUANTITY`,
		    `COMMANDS`.`CMWEIGHT`,
		    `COMMANDS`.`CMDESCRIPTION`,
		    `COMMANDS`.`CMREFERENCE`,
		    `COMMANDS`.`CMTRANSFER`,
		    `COMMANDS`.`CMINSTRUCTIONS`,
		    `COMMANDS`.`CMDATE`,
		    `COMMANDS`.`CMCREATIONDATE`,
		    `COMMANDS`.`SUBSERVICES_IDSUBSERVICES`,
		    `COMMANDS`.`PROV`,
		    `COMMANDS`.`PROVDELIVERY`,
		    `COMMANDS`.`IDCOMMANDCHILD`,
		    `COMMANDS`.`NOTAS`,
		    `COMMANDS`.`PRECIO`,
		    `COMMANDS`.`MERCHANDISE_IDMERCHANDISE`,
		    `COMMANDS`.`HORA`,
		    CASE `STATUS`.`IDSTATUS` WHEN (SELECT `STATUS`.`IDSTATUS`
				FROM `syswareo_haxpres`.`STATUS`
				WHERE `STATUS`.`INICIA` = 0 AND `STATUS`.`STATUS` = 1 AND `STATUS`.`FINALIZA` = 0 LIMIT 0, 1) THEN `COMMANDS`.`LATITUD` WHEN (SELECT `STATUS`.`IDSTATUS`
				FROM `syswareo_haxpres`.`STATUS`
				WHERE `STATUS`.`INICIA` = 1 AND `STATUS`.`STATUS` = 1 AND `STATUS`.`FINALIZA` = 0 LIMIT 0, 1) THEN `COMMANDS`.`LATITUD` ELSE `COMMANDS`.`LATITUDENT` END AS LATITUD,
			CASE `STATUS`.`IDSTATUS` WHEN (SELECT `STATUS`.`IDSTATUS`
				FROM `syswareo_haxpres`.`STATUS`
				WHERE `STATUS`.`INICIA` = 0 AND `STATUS`.`STATUS` = 1 AND `STATUS`.`FINALIZA` = 0 LIMIT 0, 1) THEN `COMMANDS`.`LONGITUD` WHEN (SELECT `STATUS`.`IDSTATUS`
				FROM `syswareo_haxpres`.`STATUS`
				WHERE `STATUS`.`INICIA` = 1 AND `STATUS`.`STATUS` = 1 AND `STATUS`.`FINALIZA` = 0 LIMIT 0, 1) THEN `COMMANDS`.`LONGITUD` ELSE `COMMANDS`.`LONGITUDENT` END AS LONGITUD,
		    `COMMANDS`.`LATITUD` AS LATITUD1,
		    `COMMANDS`.`LONGITUD` AS LONGITUD1,
		    `COMMANDS`.`LATITUDENT`,
		    `COMMANDS`.`LONGITUDENT`
		FROM `syswareo_haxpres`.`COMMANDS`	
			INNER JOIN`syswareo_haxpres`.`STATUS` ON `STATUS`.`IDSTATUS` = `COMMANDS`.`IDSTATUS`
			INNER JOIN `syswareo_haxpres`.`TYPECOMMAND` ON `TYPECOMMAND`.`IDTYPECOMAMAND` = `COMMANDS`.`IDTYPECOMAMAND`
			INNER JOIN `syswareo_haxpres`.`SCHEDULES` ON `SCHEDULES`.`IDSCHEDULE` = `COMMANDS`.`IDSCHEDULE`
			INNER JOIN `syswareo_haxpres`.`FK_COMMANDS_DRIVERS` ON `FK_COMMANDS_DRIVERS`.`IDCOMMAND` = `COMMANDS`.`IDCOMMAND`
			INNER JOIN `syswareo_haxpres`.`DRIVERS` ON `DRIVERS`.`IDDRIVER` = `FK_COMMANDS_DRIVERS`.`IDDRIVER`
			INNER JOIN `syswareo_haxpres`.`CUSTOMERS` ON `CUSTOMERS`.`IDCUSTOMER` = `COMMANDS`.`IDCUSTOMER`
			INNER JOIN `syswareo_haxpres`.`SUBSERVICES` ON `SUBSERVICES`.`IDSUBSERVICES` = `COMMANDS`.`SUBSERVICES_IDSUBSERVICES`
		WHERE `STATUS`.`GEOCERCA` = 1 AND `STATUS`.`STATUS` = 1 AND `DRIVERS`.`STATUS` = 1
			AND `TYPECOMMAND`.`TCSTATUS` = 1 AND `SCHEDULES`.`STATUS` = 1 AND `SUBSERVICES`.`STATUS` = 1 {$sWhere};";

$registros = mysqli_query($conexion,$sql);
$error = mysqli_error($conexion);
	
while($row = mysqli_fetch_assoc($registros)) {
	$response[] = $row;
}
	
mysqli_free_result($registros);
	
include '../configuration/closedb.php';


echo html_entity_decode(json_encode($response));

?>