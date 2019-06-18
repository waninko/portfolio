<?php 
include("../../../lib/initiate.inc");
include(NOCACHE_H);
include(COMMON_INC_H);
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Allow-Origin: http://localhost:8080');
    //header('Access-Control-Allow-Origin: http://localhost:8081');
    header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
    header('Access-Control-Allow-Headers: token, Content-Type');
    header('Access-Control-Max-Age: 1728000');
    header('Content-Length: 0');
    header('Content-Type: text/plain');
    die();
}

header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Origin: http://localhost:8080');
//header('Access-Control-Allow-Origin: http://localhost:8081');
header('Content-Type: application/json');

$module = $_GET['module'];
if (!isset($_SESSION['usr_id']) && $module!="login"){
    returnError("Trying to access module \"" . $module . "\" without being logged in.");
}

switch($module)
{
    case 'login':
        login();
        break;
    case 'logout':
        unset($_SESSION['usr_id']);
        break;
    case 'applicationList':
        applicationList();
        break;
    case 'departmentListFromApplication':
        departmentListFromApplication();
        break;
    case 'user':
        user();
        break;
    case 'editPassword':
        editPassword(); 
        break;  
    case 'editCode':
        editCode(); 
        break; 
    case 'editIntegrationCode' :
        editIntegrationCode();
        break;
    case 'newUser':
        newuser();
        break;    
    case 'deActivate':
        deActivate(); 
        break;
    case 'activate':
        activate(); 
        break;
    default:
        returnError("Unknown module: " . $module);
}

function returnError($message){
    $returnValue = new stdClass();
    $returnValue->error = $message;
    $returnValue->usr_id = $_SESSION['usr_id'];
    echo json_encode($returnValue);
    die();
}

################## LOGIN  ################################
function login(){
    $jsonData = json_decode(file_get_contents("php://input"));
    $returnValue = new stdClass();
    $returnValue->success = false;
    $DB = new DB_Sql();
    $countApps = new DB_Sql();
    $dataArray = [];
  
    $DB->prepareAndExecute(
    "SELECT id, name FROM system.usr WHERE lower(username)=lower($1) AND password=crypt($2,password) AND disabled=0",
    [$jsonData->username, $jsonData->password]);
  
    if ($DB->numRows() == 0) {
       
        unset($_SESSION['usr_id']);
        echo json_encode($returnValue);
    } else {
        $returnValue->success=true;
        $name = $DB->getField("name");
        $id = $DB->getField("id");
        
        
    $DB->prepareAndExecute("SELECT department_id,  application_id  FROM hgoffline.usr_dep AS ud WHERE ud.id = $1", $id);
     // en SELECT COUNT som teller antall apper
    $countApps->prepareAndExecute("SELECT COUNT(application_id) as c FROM hgoffline.usr_dep WHERE id = $1", $id);    
    

    if ($DB->numRows() <= 0) {
        $returnValue->success = false;
        echo json_encode($returnValue);
    } else {
        // Henter fra sql-resultatet
        $depId = $DB->getField("department_id");
        $appId =$DB->getField("application_id");
        $countedIDs = $countApps->GetField("c");
            
        $_SESSION['username'] = $jsonData->username; //ta vare på login navn
        $_SESSION['usr_id'] = $id; // Saves user id
        $_SESSION['dep_id'] = $depId;
        $_SESSION['counted_apps'] = $countedIDs;
        if($countedIDs == 1){
            $_SESSION['app_id'] = $appId; 
        }else {
            $_SESSION['app_id'] = null; 
        }

        $returnValue->login = true;
        $returnValue->name = $name;
        $returnValue->departmentId = $depId;
        $returnValue->applicationId = $appId;
        $returnValue->sessionUsrId =  $_SESSION['usr_id']; 
        $returnValue->countedIDs = $countedIDs;           
        echo json_encode($returnValue);
        }
        
       
    }
   
}

#################### DEPARTMENT ##########################
function departmentListFromApplication(){
    $DB = new DB_Sql();
    
    $jsonData = json_decode(file_get_contents("php://input"));
    $selectedApplicationId = $jsonData->applicationId;
    $usrId = $_SESSION['usr_id'];
    $_SESSION['app_id'] = $selectedApplicationId;

    
    $params = [$usrId, $selectedApplicationId];


    $sql =  " SELECT d.name, d.id, d.application_id " .
            " FROM hgoffline.department d " . 
            " JOIN hgoffline.usr_dep ud ON (d.id = ud.department_id OR ud.department_id = -1) AND d.application_id = ud.application_id " .
            " WHERE ud.id = $1 AND ud.application_id = $2 ";

    $DB->prepareAndExecute($sql, $params);

    do {
        $row = new stdClass();
        $row->id = $DB->getField("id");
        $row->name = $DB->getField("name");
        $row->applicationId = $DB->getField("application_id");
        $dataArray[] = $row;
    } 
    while ($DB->MoveNext());
  
    printf(json_encode($dataArray));
}


############## APPLICATION ############
function applicationList(){
    $DB = new DB_Sql();
    $DB1 = new DB_Sql();
    $jsonData = json_decode(file_get_contents("php://input"));
        
    $session_userId= $_SESSION['usr_id'];

    
    if ($_SESSION['counted_apps'] > 1) {
        $usersAppIdsSQL = "SELECT ud.application_id, app.id, app.name" .
        " FROM hgoffline.usr_dep ud" .
        " INNER JOIN hgoffline.application app ON app.id = ud.application_id" .
        " WHERE ud.id=$1";
        $DB->prepareAndExecute($usersAppIdsSQL, $session_userId);           
        
        $appNames=[];
             
        do {
            $row = new stdClass();
            $row->name = $DB->getField("name");
            $row->appId = $DB->getField("application_id");                           
            $appNames[] = $row;
        } 
        while ($DB->MoveNext());
        printf(json_encode($appNames));
    }
    else{
        department();
    }
 
}  
  

############## USER ######################
function user(){
    $DB = new DB_Sql();
    $dataArray = [];
	$cont=file_get_contents("php://input");
    $jsonData = json_decode($cont);
    $departmentId = (int)$jsonData->departmentId;
    $applicationId = $_SESSION["app_id"];
    
   
    $sql =  "SELECT visual, username, code, activated, id, application_id, department, " .
            "integrationcode, deleted, password "  .  
            "FROM hgoffline.user hu " . 
            "WHERE application_id=$1 AND department=$2 AND deleted = 0";
    $params =[$applicationId]; 
 
    if ($departmentId  >= 0) $params[] = $departmentId; //vanlig bruker
    elseif ($departmentId == -1){ 
        // Gi feilmelding - må velge avdeling;
        } //superbruker
    else unset($_SESSION['usr_id']); //ikke bruker
        
    $DB->prepareAndExecute($sql, $params);
        if ($DB->numRows() >= 0) {
            do {
                $row = new stdClass();
                $row->name = $DB->getField("visual");
                $row->app_id = $DB->getField("application_id");
                $row->dep_id = $DB->getField("department");
                $row->id = $DB->getField("id");
                $row->integrationcode = $DB->getField("integrationcode");
                $row->deleted = $DB->getField("deleted");
                $row->password = $DB->getField("password");
                $row->code = $DB->getField("code");
                $row->activated = $DB->getField("activated");
                $row->username = $DB->getField("username");
                $row->loggedUsrDep = $departmentId;//sende med innlogget bruker sin egen dep.ID for å bruke til "gå tilbake til department" knappen
                $dataArray[] = $row;
                } 
            while ($DB->MoveNext());
        } 
    echo json_encode($dataArray);
}


##########  EDIT   ##########################
function editPassword(){
    $jsonData = json_decode(file_get_contents("php://input"));
   
    $newPassword = $jsonData->newPassword;
    $selectedUser = (int)$jsonData->selectedUser;
    $DB = new DB_Sql();
    $dataArray = [];
    if($newPassword == ''|| $selectedUser == ''){ 
    die();
    }
    else{
    $sql =  "UPDATE hgoffline.user SET password=$1 WHERE id=$2 AND application_id =$3"; 
    $params =[$newPassword, $selectedUser, $_SESSION['app_id']];
    
    $DB->prepareAndExecute($sql, $params);
    }
}

function editIntegrationCode(){
    $jsonData = json_decode(file_get_contents("php://input"));
    $DB = new DB_Sql();
    $sql = "UPDATE hgoffline.user SET integrationcode=$1 WHERE id=$2";
    $params = [
        $newIntegrationCode =$jsonData->newIntegrationCode,
        $selectedUser = $jsonData->selectedUser
    ];

    
    $DB->prepareAndExecute($sql,$params);
}


function editCode(){
    $jsonData = json_decode(file_get_contents("php://input"));
    //$newIntegrationCode = (string)$jsonData->code;
    
    $selectedUser = (int)$jsonData->selectedUserId;
    $DB = new DB_Sql();


$getAppId = "SELECT application_id FROM hgoffline.user WHERE id=$1";
$DB->PrepareAndExecute($getAppId, [$selectedUser]);
$SelectedUserApp = $DB->getField("application_id");

    $count=0;
	$res="";
    $strSQL="SELECT prefix FROM hgoffline.application WHERE id=$1";
    $DB->PrepareAndExecute($strSQL, [$SelectedUserApp]);
    
    $prefix=strtolower($DB->GetField("prefix"));
	while($res=="")
	{
		$test=$prefix.rand(1000,9999);
		$strSQL="SELECT count(*) AS c FROM hgoffline.user ";
		$strSQL.="WHERE deleted=0 AND application_id=$1 AND lower(code)=$2";
        $DB->PrepareAndExecute($strSQL, [$SelectedUserApp,$test]);
        
		if ($DB->GetField("c")==0)
            $res=$test;  
		else
		{
			$count++;
			if (!($count%10))
				$prefix.=rand (0, 9);
        }
        
    }
   
    $params =[$res, $selectedUser];
   
    
    
  $DB->prepareAndExecute("UPDATE hgoffline.user SET code=$1 WHERE id=$2 AND activated=1", $params);
  $code = $res;
 
  echo json_encode($code);


  
}
################### NEW USER ##########
function newUser(){
    $jsonData = json_decode(file_get_contents("php://input"));

    $DB = new DB_Sql();
    $visual = $jsonData->visualName;
    $i=0;

    $sqlSelect = "SELECT visual FROM hgoffline.user WHERE visual=$1";
    $DB->prepareAndExecute($sqlSelect,$visual);

    while($DB->NumRows()>0)
        $DB->prepareAndExecute($sqlSelect,$visual.(++$i));

    if ($i>0)
        $visual.=$i;

    $username = $jsonData->userName;
    $i=0;
    
    $sqlSelect1 = "SELECT username FROM hgoffline.user WHERE username=$1";
    $DB->prepareAndExecute($sqlSelect1,$username);
    
    while($DB->NumRows()>0)
        $DB->prepareAndExecute($sqlSelect1,$username.(++$i));
    
    if ($i>0)
        $username.=$i;
    $sql = "INSERT INTO hgoffline.user (code, visual, application_id, department, integrationcode, username, password) ". 
            "VALUES ($1, $2, $3, $4, $5, $6, $7)";
            $params =[
                $code = '',
                $visual = $visual,
                $applicationId = $jsonData->applicationId,
                $departmentId = $jsonData->departmentId,
                $integrationcode = $jsonData->intCode,  
                $username = $username,
                $password = $jsonData->newUserPassword
            ];                    
 $DB -> prepareAndExecute($sql, $params);
    }




############ DEACTIVATE  ######################
function deActivate(){
    $jsonData = json_decode(file_get_contents("php://input"));
    
    $deActivateUser = (bool)$jsonData->deActivateUser;
    $selectedUser = (int)$jsonData->selectedUser;
    $DB = new DB_Sql();

    if($deActivateUser == true){ $deActivateUser == 1;}
    else{ $deActivateUser == 0;}

    $params =[$deActivateUser,$selectedUser ];
   
    $DB->prepareAndExecute("UPDATE hgoffline.user SET deleted = $1 WHERE id =$2", $params);
}



