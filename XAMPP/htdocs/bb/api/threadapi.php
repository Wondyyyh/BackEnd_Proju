<?php
// /bb/api/thredapi.php - api entry for thread related REST operations

include("api_include.php");

/**** BELOW ARE DECLARED THE ACTUAL FUNCTIONS STHAT IMPLEMENT VARIOUS OPERATIONS ON DATA   *****/

// this function returns data of individual thread in JSON format (string)
function getthreadDataJSON($threadID)
{
	global $database;
	$threadQuery = "SELECT * FROM `thread` WHERE id = '".$threadID."' LIMIT 1; ";
	$threadData = $database->query($threadQuery);
	$count = $threadData->numRows();
	if(!$count){ // check if a result was found
	  http_response_code(404);
      echo json_encode(['error' => 'thread does not exist']);
      exit();
	}else{
		$results = $threadData->fetchAll();
		return json_encode($results);
	}
}



// this function returns data of all threads in JSON format (string)
function getAllThreadsJSON()
{
	global $database;

	$allthreadsQuery = "SELECT * FROM `thread` WHERE 1; ";

	$threadData = $database->query($allthreadsQuery);
	$count = $threadData->numRows();
	if(!$count){ // check if a result was found
	  http_response_code(404);
      echo json_encode(['error' => 'thread does not exist']);
      exit();
	}else{
		$results = $threadData->fetchAll();
		return json_encode($results);
	}

}

// this function updates data of a thread, defined by argument $threadJSON in JSON format (string)
function updateThreadData( $threadJSON, $id)
{
	global $database;
	$requestBody = json_decode($threadJSON, true);

	$title = $requestBody[0]['title'];
	$author = $requestBody[0]['author'];

	$queryStr = "UPDATE `thread` SET title='".$title."',"
    ." author='".$author."',"
    ." WHERE id = '".$id."';";
    
	$threadData = $database->query($queryStr); // execute query and store results 

    $count = $threadData->affectedRows();

    if($count){ // check if a result was found
    	return true;
	}else{
		return false;
	}

}

// this function creates new thread, defined by argument $threadJSON in JSON format (string)
function createThread( $threadJSON)
{
	global $database;
	$requestBody = json_decode($threadJSON, true);
	/*[{"id":1,"title":"anton","author":"anton1","firstname":"Anton","lastname":"Yrj\u00f6nen","created":"2023-10-04 13:06:26","lastseen":null,"banned":0,"isadmin":0}]*/

	$title = $requestBody[0]['title'];
	$author = $requestBody[0]['author'];

	$queryStr = "INSERT INTO `thread` (title, author) VALUES ('".$title."', '"
	.$author ."');" ;

	$database->query($queryStr); // execute query

	$id = $database->lastInsertID();
	if($id){
		return $id;
	}
	else{
		return false;
	}

}

// this function removes thread (implemented as changing thread banned for now)
function deletethread($threadID)
{
	global $database, $isAdmin;

	// if(!$isAdmin) return false;

    $usrQueryStr = "SELECT id FROM user WHERE username = '" . $_SESSION["username"] . "' LIMIT 1;";
    
    $usrData = $database->query($usrQueryStr); // execute query and store results 

    $count = $usrData->numRows();

    if($count){ // check if a result was found
    	$results = $usrData->fetchAll();
    	$userID = $results[0]['id'];
    }else{
    	header("Location: main.php");
    }
    
    $delQueryStr = "UPDATE `thread` SET hidden=TRUE WHERE id = '" . $threadID . "' AND author = '".$userID."';"; 
	
	$delData = $database->query($delQueryStr); // execute query and store results 

    $count = $delData->numRows();

    if($count){ // check if a result was found, react if necessary
    }else{
    	// react to failure if necessary
    }

    //<------ Stops here

	$queryStr = "UPDATE `thread` SET banned = TRUE WHERE id = '".$threadID."';";
    
	$threadData = $database->query($queryStr); // execute query and store results 
    $count = $threadData->affectedRows();
    if($count){ // check if a result was found
    	return true;
	}else{
		return false;
	}
}


/**** BELOW A SWITCH-CASE STRUCTURE TO HANDLE HTTP ACTIONS AND TO TRIGGER CORRECT WORKER FUNCTIONS *****/

switch ($method | $uri) {
    // get all threads
   case ($method == 'GET' && $uri == '/bb/api/threads'):
       header('Content-Type: application/json');
       //echo json_encode($threads, JSON_PRETTY_PRINT);
       echo getAllThreadsJSON();
       break;
    // get single thread by id
   case ($method == 'GET' && preg_match('/\/api\/threads\/[1-9][0-9]*/', $uri)):
       header('Content-Type: application/json');
       $id = basename($uri); // basename — Returns trailing name component of path
       //echo json_encode(['note' => 'match for thread id '.$id]);
       // fetch thread information from database and send
       echo getthreadDataJSON($id);
       break;
    // add new thread
   case ($method == 'POST' && $uri == '/bb/api/threads'):
       header('Content-Type: application/json');
   
       /*if (empty($id)) {
           http_response_code(404);
           echo json_encode(['error' => 'Please add id of the thread']);
       }*/

       // add new thread to database...
       $success = createThread(file_get_contents('php://input'));

       if($success) echo json_encode(['id' => $success]);
       else{
       	 echo json_encode(['error' => 'thread addition failed']);
       }
       break;
    // update a thread - TODO:
   case ($method == 'PUT' && preg_match('/\/api\/threads\/[1-9][0-9]*/', $uri)):
   		$id = basename($uri);
   		// do the update...
   		header('Content-Type: application/json');
   		$success = updateThreadData(file_get_contents('php://input'),$id);
   		if($success) echo json_encode(['message' => $success]);
       else{
       	 echo json_encode(['error' => 'thread update failed']);
       }
   		break;
   case ($method == 'DELETE' && preg_match('/\/api\/threads\/[1-9][0-9]*/', $uri)):
   		$id = basename($uri);
   		header('Content-Type: application/json');
   		$success = deletethread($id);
   		if($success) echo json_encode(['message' => $success]);
       	else{
       	 	echo json_encode(['error' => 'thread removal failed']);
       	}
   		break;
   default:
       http_response_code(404);
       echo json_encode(['error' => "We cannot find what you're looking for2."]);
       break;


}

?>