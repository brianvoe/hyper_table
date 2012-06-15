<?php 

class hyper_table {
	public $variable_one = '';

	function __construct($data = array()) {
		foreach($data as $key => $value){
			if(isset($this->{$key})){
	    		$this->{$key} = $value;
	    	}
	    } 
    }

}

?>