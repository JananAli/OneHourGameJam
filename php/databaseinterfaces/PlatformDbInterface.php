<?php
define("DB_TABLE_PLATFORM", "platform");

define("DB_COLUMN_PLATFORM_ID",         "platform_id");
define("DB_COLUMN_PLATFORM_NAME",       "platform_name");
define("DB_COLUMN_PLATFORM_ICON_URL",   "platform_icon_url");
define("DB_COLUMN_PLATFORM_DELETED",    "platform_deleted");

class PlatformDbInterface{
    private $dbConnection;
    private $publicColumns = Array(DB_COLUMN_PLATFORM_ID, DB_COLUMN_PLATFORM_NAME, DB_COLUMN_PLATFORM_ICON_URL, DB_COLUMN_PLATFORM_DELETED);
    private $privateColumns = Array();

    function __construct(&$dbConn) {
        $this->dbConnection = $dbConn;
    }

    public function SelectAll(){
        AddActionLog("PlatformDbInterface_SelectAll");
        StartTimer("PlatformDbInterface_SelectAll");

        $sql = "
            SELECT ".DB_COLUMN_PLATFORM_ID.", ".DB_COLUMN_PLATFORM_NAME.", ".DB_COLUMN_PLATFORM_ICON_URL.", ".DB_COLUMN_PLATFORM_DELETED."
            FROM ".DB_TABLE_PLATFORM.";";
        
        StopTimer("PlatformDbInterface_SelectAll");
        return mysqli_query($this->dbConnection, $sql);
    }

    public function Insert($platformName, $iconUrl){
        AddActionLog("PlatformDbInterface_Insert");
        StartTimer("PlatformDbInterface_Insert");

        $escaped_platformName = mysqli_real_escape_string($this->dbConnection, $platformName);
        $escaped_iconUrl = mysqli_real_escape_string($this->dbConnection, $iconUrl);
    
        $sql = "
            INSERT INTO platform
            (platform_id,
            platform_name,
            platform_icon_url,
            platform_deleted)
            VALUES
            (null,
            '$escaped_platformName',
            '$escaped_iconUrl',
            0);
        ";
        $data = mysqli_query($this->dbConnection, $sql);
        
        StopTimer("PlatformDbInterface_Insert");
    }

    public function SelectPublicData(){
        AddActionLog("PlatformDbInterface_SelectPublicData");
        StartTimer("PlatformDbInterface_SelectPublicData");

        $sql = "
            SELECT ".implode(",", $this->publicColumns)."
            FROM ".DB_TABLE_PLATFORM.";
        ";

        StopTimer("PlatformDbInterface_SelectPublicData");
        return mysqli_query($this->dbConnection, $sql);
    }
}

?>