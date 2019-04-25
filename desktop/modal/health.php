<?php
/* This file is part of Jeedom.
 *
 * Jeedom is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Jeedom is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Jeedom. If not, see <http://www.gnu.org/licenses/>.
 */

if (!isConnect('admin')) {
	throw new Exception('401 Unauthorized');
}
/*
	DEPLACE DANS 	public static function ScanAmazonAlexa($_logical_id = null, $_exclusion = 0) de core class watchdog.class.php

$json=file_get_contents("http://192.168.0.21:3456/devices");
$json = json_decode($json,true);

foreach($json as $item)
	{



						$device = $item['name'];
						$serial = $item['serial'];
						$type = $item['type'];
						$online = $item['online'];


		$watchdog = watchdog::byLogicalId($serial, 'watchdog');
		if (!is_object($watchdog)) {
			$watchdog = new watchdog();
			$watchdog->setName($device);
			$watchdog->setLogicalId($serial); 
			$watchdog->setEqType_name('watchdog');
			$watchdog->setIsEnable(1);
			$watchdog->setIsVisible(1);
		}
		$watchdog->setConfiguration('serial',$serial); 
		$watchdog->setConfiguration('device',$device);
		$watchdog->setConfiguration('type',$type);
		$watchdog->setStatus('online',$online);
		$watchdog->save();
 }
*/

$eqLogics = watchdog::byType('watchdog');
?>
<table class="table table-condensed tablesorter" id="table_healthNetwork">
	<thead>
		<tr>
			<th>{{Module}}</th>
			<th>{{ID}}</th>
			<th>{{Device}}</th>
			<th>{{Serial}}</th>
			<th>{{Type}}</th>
			<th>{{Présent *}}</th>
			<th>{{Date création}}</th>
		</tr>
	</thead>
	<tbody>
	 <?php
foreach ($eqLogics as $eqLogic) {

	if ($eqLogic->getStatus('online') == 'true') {
		$present = 1;
	}
	if ($present == 1){
		$present = '<span class="label label-success" style="font-size : 1em;" title="{{Présent}}"><i class="fa fa-check-circle"></i></span>';
	} else {
		$present = '<span class="label label-danger" style="font-size : 1em;" title="{{Absent}}"><i class="fa fa-times-circle"></i></span>';
	}
	
	if ((strstr($eqLogic->getName(), "Alexa Apps")))
		$present = '<span class="label label-warning" style="font-size : 1em;" title="{{Inconnu}}"><i class="fa fa-question-circle"></i></span>';

	echo '<tr><td><a href="' . $eqLogic->getLinkToConfiguration() . '" style="text-decoration: none;">' . $eqLogic->getHumanName(true) . '</a></td>';
	echo '<td><span class="label label-info" style="font-size : 1em; cursor : default;">' . $eqLogic->getId() . '</span></td>';
	echo '<td><span class="label label-info" style="font-size : 1em; cursor : default;">' . $eqLogic->getConfiguration('device') . '</span></td>';
	echo '<td><span class="label label-info" style="font-size : 1em; cursor : default;">' . $eqLogic->getConfiguration('serial') . '</span></td>';
	echo '<td><span class="label label-info" style="font-size : 1em; cursor : default;">' . $eqLogic->getConfiguration('type') . '</span></td>';
	echo '<td>' . $present . '</td>';
	echo '<td><span class="label label-info" style="font-size : 1em; cursor : default;">' . $eqLogic->getConfiguration('createtime') . '</span></td></tr>';
}
?>
	</tbody>
</table>
* Pour actualiser la colonne <B>Présent</B>, Faites un <B>Scan</B> sur l'écran précédent.