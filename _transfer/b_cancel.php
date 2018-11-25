<?php
/*
 * Copyright (C) 2019+ MasterkinG32 <https://masterking32.com>
 * Copyright (C) 2017+ AzerothCore <www.azerothcore.org>, released under GNU GPL v2 license: http://github.com/azerothcore/azerothcore-wotlk/LICENSE-GPL2
 * Copyright (C) 2008-2016 TrinityCore <http://www.trinitycore.org/>
 * Copyright (C) 2005-2009 MaNGOS <http://getmangos.com/>
*/

    ob_start();
    session_start();

    include_once("t_dbfunctions.php");
    include_once("t_functions.php");
    include_once("t_config.php");

    if(isset($_POST['cancel']) && isset($_POST['RealmlistList']) && isset($_POST['GUID'])) {
        $ACCOUNT_ID = _GetCharacterAccountID();
        $ID         = $_POST['cancel'];
        $RealmID    = $_POST['RealmlistList'];
        $GUID       = $_POST['GUID'];
        if(_CheckCharacterOnlineStatus(_HostDBSwitch($RealmID),$DB_PORT, $DBUser, $DBPassword, _CharacterDBSwitch($RealmID), $GUID)) {
            if(CheckTransferStatus($AccountDBHost,$DB_PORT, $DBUser, $DBPassword, $AccountDB, $ID) == 0) {
                if(!_CheckGMAccess($AccountDBHost,$DB_PORT, $DBUser, $DBPassword, $AccountDB, $ACCOUNT_ID, $GMLevel)) {
                    CancelORDenyCharacterTransfer(_HostDBSwitch($RealmID),$DB_PORT, $DBUser, $DBPassword, _CharacterDBSwitch($RealmID), $GUID, $STORAGE);
                    UpdateDumpStatus($AccountDBHost,$DB_PORT, $DBUser, $DBPassword, $AccountDB, $ID, 3);
                    ob_end_flush();
                    die("Transfer with ID: ". $ID ." Canceled");
                } else die("ACCESS DENIED");
            } else die("NOT \"IN PROGRESS\" STATUS");
        } else die("LOG OFF WITH THIS CHARACTER! BEFORE MAKE ANY ACTIONS!");
    } else die("SHIT HAPPENS, ERROR 30");
?>