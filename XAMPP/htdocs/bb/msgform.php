<?php

class msgform
{
	protected $actionURL = 'newThread.php';

	public function __construct($actionURL = NULL) {
		if(isset($actionURL)) $this->actionURL = $actionURL;
	}

	public function getMsgForm($actionURL = NULL){
		if(isset($actionURL)) $this->actionURL = $actionURL;
		elseif(!isset($this->actionURL)) return "ERROR: no action URL defined for msgform";

		$formStr = '
		<form action="' . $this->actionURL . '" method="post">
	        <label for="title">Otsikko:</label>
	        <input type="text" id="title" name="title" required><br><br>

	        <label for="msg">Viesti:</label>
	        <input type="text" id="msg" name="msg" required><br><br>

	        <input type="submit" value="Submit">
    	</form>
    	';

    	return $formStr;

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