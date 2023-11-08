<?php

class msgform
{
	protected $actionURL = NULL;
	protected $hiddenInputs ="";

	public function __construct($actionURL = NULL) {
		if(isset($actionURL)) $this->actionURL = $actionURL;
	}
	
	
	public function getMsgForm($actionURL = NULL, $msgID = NULL){
		if(isset($actionURL)) $this->actionURL = $actionURL;
		elseif(!isset($this->actionURL)) return "ERROR: no action URL defined for msgform";

		$msgTit="";
		$msgCont="";

		if($msgID){
			// we want existing msg to be edited:
			// 1) get msg contents from database
			// 2) add id data into form for saving changes after submit
			$msg = $this->getMsgInfo($msgID);
			$msgTit= $msg['title'];
			$msgCont=$msg['content'];
			$this->addHidden('msgid', $msgID); 
		}

		$formStr = '
		<form action="' . $this->actionURL . '" method="post">
	        <label for="title">Otsikko:</label>
	        <input type="text" id="title" name="title" size="50" required value="'.$msgTit.'"><br><br>

	        <label for="msg">Viesti:</label>
	        <textarea id="msg" name="msg" rows="6" cols="50">'.$msgCont.'</textarea><br><br>

	        <input type="submit" value="Submit">';

    	$formStr .= $this->hiddenInputs . '</form>';

    	return $formStr;

	}

	public function addHidden($name, $value)
	{
		$this->hiddenInputs .= '<input type="hidden" id="'.$name.'" name="'.$name.'" value="'.$value.'" >';

	}

	protected function getMsgInfo($id)
	{
		global $database;

		$retVal=NULL;
		$queryStr = "SELECT title, content FROM msg "
    		. " WHERE  msg.id = ".$id." AND msg.hidden = FALSE LIMIT 1; ";

    	$data = $database->query($queryStr); // execute query and store results 

    	$count = $data->numRows();
    	if($count){ // check if a result was found
	        $results = $data->fetchAll();
	        foreach($results as $singleRes){
	   
	            $msgTitle = $singleRes['title']; 
	            $msgCont = $singleRes['content'];
	            $retVal = array("title" => $msgTitle, "content" => $msgCont);

	        }
    	}

		return $retVal;
	}

}




/*
USAGE:
$form = new msgform("inputHandler.php");
$formHTMLstr = $form->getMsgForm();
OR:
$form = new msgform();
$formHTMLstr = $form->getMsgForm("inputHandler.php");
*/

?>