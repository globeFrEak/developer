<?php

/**
 * File: update_430-440.php.
 * Author: Ulrich Block
 * Date: 02.02.14
 * Contact: <ulrich.block@easy-wi.com>
 *
 * This file is part of Easy-WI.
 *
 * Easy-WI is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Easy-WI is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Easy-WI.  If not, see <http://www.gnu.org/licenses/>.
 *
 * Diese Datei ist Teil von Easy-WI.
 *
 * Easy-WI ist Freie Software: Sie koennen es unter den Bedingungen
 * der GNU General Public License, wie von der Free Software Foundation,
 * Version 3 der Lizenz oder (nach Ihrer Wahl) jeder spaeteren
 * veroeffentlichten Version, weiterverbreiten und/oder modifizieren.
 *
 * Easy-WI wird in der Hoffnung, dass es nuetzlich sein wird, aber
 * OHNE JEDE GEWAEHELEISTUNG, bereitgestellt; sogar ohne die implizite
 * Gewaehrleistung der MARKTFAEHIGKEIT oder EIGNUNG FUER EINEN BESTIMMTEN ZWECK.
 * Siehe die GNU General Public License fuer weitere Details.
 *
 * Sie sollten eine Kopie der GNU General Public License zusammen mit diesem
 * Programm erhalten haben. Wenn nicht, siehe <http://www.gnu.org/licenses/>.
 */

if (isset($include) and $include == true) {
    $query = $sql->prepare("INSERT INTO `easywi_version` (`version`,`de`,`en`) VALUES
('4.40','<div align=\"right\">23.10.2013</div>
<b>Änderungen:</b><br/>
<ul>
<li></li>
</ul>
<br/><br/>
<b>Bugfixes:</b><br/>
<ul>
<li></li>
</ul>
','<div align=\"right\">10.23.2013</div>
<b>Changes:</b><br/>
<ul>
<li></li>
</ul>
<br/><br/>
<b>Bugfixes:</b><br/>
<ul>
<li></li>
</ul>
')");
    $query->execute();
    $response->add('Action: insert_easywi_version done: ');
    $query->closecursor();

    $add = $sql->prepare("CREATE TABLE IF NOT EXISTS `easywi_statistics_current` (
  `gameMasterInstalled` int(10) unsigned DEFAULT 0,
  `gameMasterActive` int(10) unsigned DEFAULT 0,
  `gameMasterServerAvailable` int(10) unsigned DEFAULT 0,
  `gameMasterSlotsAvailable` int(10) unsigned DEFAULT 0,
  `gameMasterCrashed` int(10) unsigned DEFAULT 0,
  `gameserverInstalled` int(10) unsigned DEFAULT 0,
  `gameserverActive` int(10) unsigned DEFAULT 0,
  `gameserverSlotsInstalled` int(10) unsigned DEFAULT 0,
  `gameserverSlotsActive` int(10) unsigned DEFAULT 0,
  `gameserverSlotsUsed` int(10) unsigned DEFAULT 0,
  `gameserverNoPassword` int(10) unsigned DEFAULT 0,
  `gameserverNoTag` int(10) unsigned DEFAULT 0,
  `gameserverNotRunning` int(10) unsigned DEFAULT 0,
  `mysqlMasterInstalled` int(10) unsigned DEFAULT 0,
  `mysqlMasterActive` int(10) unsigned DEFAULT 0,
  `mysqlMasterDBAvailable` int(10) unsigned DEFAULT 0,
  `mysqlMasterCrashed` int(10) unsigned DEFAULT 0,
  `mysqlDBInstalled` int(10) unsigned DEFAULT 0,
  `mysqlDBActive` int(10) unsigned DEFAULT 0,
  `mysqlDBSpaceUsed` int(10) unsigned DEFAULT 0,
  `ticketsCompleted` int(10) unsigned DEFAULT 0,
  `ticketsInProcess` int(10) unsigned DEFAULT 0,
  `ticketsNew` int(10) unsigned DEFAULT 0,
  `userAmount` int(10) unsigned DEFAULT 0,
  `userAmountActive` int(10) unsigned DEFAULT 0,
  `virtualMasterInstalled` int(10) unsigned DEFAULT 0,
  `virtualMasterActive` int(10) unsigned DEFAULT 0,
  `virtualMasterVserverAvailable` int(10) unsigned DEFAULT 0,
  `virtualInstalled` int(10) unsigned DEFAULT 0,
  `virtualActive` int(10) unsigned DEFAULT 0,
  `voiceMasterInstalled` int(10) unsigned DEFAULT 0,
  `voiceMasterActive` int(10) unsigned DEFAULT 0,
  `voiceMasterServerAvailable` int(10) unsigned DEFAULT 0,
  `voiceMasterSlotsAvailable` int(10) unsigned DEFAULT 0,
  `voiceMasterCrashed` int(10) unsigned DEFAULT 0,
  `voiceserverInstalled` int(10) unsigned DEFAULT 0,
  `voiceserverActive` int(10) unsigned DEFAULT 0,
  `voiceserverSlotsInstalled` int(10) unsigned DEFAULT 0,
  `voiceserverSlotsActive` int(10) unsigned DEFAULT 0,
  `voiceserverSlotsUsed` int(10) unsigned DEFAULT 0,
  `voiceserverTrafficAllowed` int(10) unsigned DEFAULT 0,
  `voiceserverTrafficUsed` int(10) unsigned DEFAULT 0,
  `voiceserverCrashed` int(10) unsigned DEFAULT 0,
  `webMasterInstalled` int(10) unsigned DEFAULT 0,
  `webMasterActive` int(10) unsigned DEFAULT 0,
  `webMasterSpaceAvailable` int(10) unsigned DEFAULT 0,
  `webMasterVhostAvailable` int(10) unsigned DEFAULT 0,
  `webspaceInstalled` int(10) unsigned DEFAULT 0,
  `webspaceActive` int(10) unsigned DEFAULT 0,
  `webspaceSpaceGiven` int(10) unsigned DEFAULT 0,
  `webspaceSpaceGivenActive` int(10) unsigned DEFAULT 0,
  `webspaceSpaceUsed` int(10) unsigned DEFAULT 0,
  `userID` int(10) unsigned NOT NULL DEFAULT 0,
  `statDate` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`userID`)
) ENGINE=InnoDB");
    $add->execute();

    $insert = $sql->prepare("INSERT INTO `easywi_statistics_current` (`userID`) VALUES (?) ON DUPLICATE KEY UPDATE `userID`=`userID`");
    $insert->execute(array(0));

    $query = $sql->prepare("SELECT `id` FROM `userdata` WHERE `accounttype`!='a'");
    $query->execute();
    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
        $insert->execute(array($row['id']));
    }

    $query = $sql->prepare("DROP TABLE IF EXISTS `rootsSubnets`");
    $query = $sql->prepare("DROP TABLE IF EXISTS `rootsIP4`");

    $query = $sql->prepare("CREATE TABLE IF NOT EXISTS `rootsSubnets` (
  `subnetID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dhcpServer` int(10) unsigned NOT NULL,
  `active` enum('Y','N') DEFAULT 'Y',
  `subnet` varchar(15) DEFAULT NULL,
  `netmask` varchar(15) DEFAULT NULL,
  `subnetOptions` text,
  `vlan` enum('Y','N') DEFAULT 'N',
  `vlanName` varchar(255),
  PRIMARY KEY (`subnetID`)
) ENGINE=InnoDB");
    $query->execute();

    $query = $sql->prepare("CREATE TABLE IF NOT EXISTS `rootsIP4` (
  `subnetID` int(10) unsigned,
  `ip` varchar(15) DEFAULT NULL,
  `ownerID` int(10) unsigned DEFAULT 0,
  `resellerID` int(10) unsigned DEFAULT 0,
  PRIMARY KEY (`subnetID`,`ip`),KEY(`ownerID`),KEY(`resellerID`)
) ENGINE=InnoDB");
    $query->execute();

    $query = $sql->prepare("SELECT `active`,`subnetOptions`,`ips`,`netmask`,`resellerid` FROM `rootsDHCP`");
    $query2 = $sql->prepare("SELECT 1 FROM `rootsSubnets` WHERE `subnet`=? LIMIT 1");
    $query3 = $sql->prepare("INSERT INTO `rootsSubnets` (`active`,`subnet`,`subnetOptions`,`netmask`,`vlan`,`vlanName`) VALUES (?,?,?,?,'N','')");
    $query4 = $sql->prepare("INSERT INTO `rootsIP4` (`subnetID`,`ip`) VALUES (?,?) ON DUPLICATE KEY UPDATE `ip`=VALUES(`ip`)");

    $query->execute();
    $query->execute();
    foreach ($query->fetchAll(PDO::FETCH_ASSOC) as $row) {
        foreach (explode("\r\n", $row['ips']) as $exip) {

            $ex = explode('.', $exip);

            if (isset($ex[2])) {
                $query2->execute(array($ex[0] . '.' . $ex[1] . '.' . $ex[2] . '.0'));
                if ($query2->rowCount() == 0) {
                    $query3->execute(array($row['active'], $ex[0] . '.' . $ex[1] . '.' . $ex[2] . '.0', str_replace("option subnet-mask %subnet-mask%;\r\n", '', $row['subnetOptions']), $row['netmask']));
                    $lastID = $sql->lastInsertId();
                    for ($lastTriple = 2; $lastTriple < 255; $lastTriple++) {
                        $query4->execute(array($lastID, $ex[0] . '.' . $ex[1] . '.' . $ex[2] . '.' . $lastTriple));
                    }
                }
            }
        }
    }

    $query = $sql->prepare("SELECT `ips`,`resellerid`,`resellersid` FROM `resellerdata`");
    $query2 = $sql->prepare("UPDATE `rootsIP4` SET `ownerID`=?,`resellerID`=? WHERE `ip`=? LIMIT 1");
    $query->execute();
    foreach ($query->fetchAll(PDO::FETCH_ASSOC) as $row) {
        foreach (ipstoarray($row['ips']) as $usedip) {
            $query2->execute(array($row['resellerid'], $row['resellersid'], $usedip));
        }
    }

    $dirSource = EASYWIDIR . '/stuff/';
    $dirTarget = EASYWIDIR . '/stuff/custom_modules/';

    if (!is_dir($dirTarget)) {
        @mkdir($dirTarget);
    }

    if (is_dir($dirTarget)) {

        $query = $sql->prepare("SELECT `file` FROM `modules`");
        $query->execute();
        foreach ($query->fetchAll(PDO::FETCH_ASSOC) as $row) {
            if (is_file($dirSource . $row['file'])) {
                rename($dirSource . $row['file'], $dirTarget . $row['file']);
            }
        }
    }

    foreach (array('admin', 'api', 'cms', 'custom_modules', 'jobs', 'methods', 'user') as $dir) {
        if (is_dir(EASYWIDIR . '/stuff/' . $dir . '/')) {
            foreach (scandir(EASYWIDIR . '/stuff/' . $dir . '/') as $row) {
                if (substr($row, -4) == '.php') {
                    @unlink($dirSource . $row);
                }
            }
        }
    }

    $customDirs = array();

    foreach (scandir(EASYWIDIR . '/template/') as $row) {
        if (strpos($row, '.') === false) {
            $customDirs[] = $row;
            foreach (array('admin', 'ajax', 'cms', 'custom_modules', 'user') as $dir) {
                @mkdir(EASYWIDIR . '/template/' . $row);
            }
        }
    }

    foreach (array('admin', 'ajax', 'cms', 'custom_modules', 'user') as $dir) {

        if (is_dir(EASYWIDIR . '/template/default/' . $dir . '/')) {

            foreach (scandir(EASYWIDIR . '/template/default/' . $dir . '/') as $row) {

                if (substr($row, -4) == '.tpl') {

                    if (is_file(EASYWIDIR . '/template/default/' . $row)) {
                        @unlink(EASYWIDIR . '/template/default/' . $row);
                    }

                    foreach ($customDirs as $custom) {
                        if (is_dir(EASYWIDIR . '/template/' . $custom) and is_file(EASYWIDIR . '/template/' . $custom . '/' . $row)) {
                            @rename(EASYWIDIR . '/template/' . $custom . '/' . $row, EASYWIDIR . '/template/' . $custom . '/' . $dir . '/' . $row);
                        }
                    }
                }
            }
        }
    }

    $query = $sql->prepare("UPDATE `servertypes` SET `steamgame`='S' WHERE `steamgame`='Y'");
    $query->execute();

    $query = $sql->prepare("ALTER TABLE `servertypes` ADD COLUMN `gamebinaryWin` varchar(255) NOT NULL AFTER `gamebinary`");
    $query->execute();

    $query = $sql->prepare("UPDATE `servertypes` SET `gamebinaryWin`='hlds.exe',`os`='B' WHERE `gamebinary`='hlds_run'");
    $query->execute();

    $query = $sql->prepare("UPDATE `servertypes` SET `gamebinaryWin`='srcds.exe',`os`='B' WHERE `gamebinary`='srcds_run'");
    $query->execute();

    $query = $sql->prepare("UPDATE `servertypes` SET `gameq`='mta' WHERE `gameq`='Mta'");
    $query->execute();

    $query = $sql->prepare("DROP TABLE IF EXISTS `voice_server_stats_hours`");
    $query->execute();


} else {
    echo "Error: this file needs to be included by the updater!<br />";
}