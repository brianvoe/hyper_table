<?php 

class hyper_table {
	// Table variables
	public $table_id = '';
	public $table_class = '';
	public $table_style = '';
	public $table_border = 0;
	public $table_padding = 0;
	public $table_spacing = 0;

	// Columns
	public $columns = array();

	// Header row
	public $header_row = '';

	// Body rows
	public $body_rows = '';

	function __construct() {
		// set construct

    }

    function set_table($table = array()) {
    	$this->table_id = (isset($table['id']) ? $table['id'] : $this->table_id);
    	$this->table_class = (isset($table['class']) ? $table['class'] : $this->table_class);
    	$this->table_style = (isset($table['style']) ? $table['style'] : $this->table_style);
    	$this->table_border = (isset($table['border']) ? $table['border'] : $this->table_border);
    	$this->table_padding = (isset($table['padding']) ? $table['padding'] : $this->table_padding);
    	$this->table_spacing = (isset($table['spacing']) ? $table['spacing'] : $this->table_spacing);
    }

    function set_header($header = array()) {
    	$this->columns = array();

    	$this->header_row = '<thead>';
    	$this->header_row .= '<tr>';
    	foreach($header['columns'] as $key => $column) {
    		array_push($this->columns, $key);
    		$this->header_row .= '<td>';
    		$this->header_row .= (isset($column['atag']) ? '<a '.(isset($column['atag']['class']) ? 'class="'.$column['atag']['class'].'"': '').' '.(isset($column['atag']['title']) ? 'title="'.$column['atag']['title'].'"': '').' href="'.$column['atag']['href'].'">': '');
    		$this->header_row .= $column['title'];
    		$this->header_row .= (isset($column['atag']) ? '</a>': '');
    		$this->header_row .= '</td>';
    	}
    	$this->header_row .= '</tr>';
    	$this->header_row .= '</thead>';
    }

    function set_body($info = array()) {
    	$this->body_rows = '<tbody>';
    	foreach($info['info'] as $row) {
    		$this->body_rows .= '<tr>';
    		foreach($this->columns as $column) {
    			$this->body_rows .= '<td>';
    			if(isset($info['funcs'][$column])) {
    				$this->body_rows .= $info['funcs'][$column]($row[$column]);
    			} else {
    				$this->body_rows .= $row[$column];
    			}
    			$this->body_rows .= '</td>';
    		}
    		$this->body_rows .= '</tr>';
    	}
    	$this->body_rows .= '</body>';
    }

    function generate() {
    	$id = ($this->table_id != '' ? 'id="'.$this->table_id.'"': '');
    	$class = ($this->table_class != '' ? 'class="'.$this->table_class.'"': '');
    	$style = ($this->table_style != '' ? 'style="'.$this->table_style.'"': '');
    	$border = ($this->table_border != '' ? 'border="'.$this->table_border.'"': '');
    	$padding = ($this->table_padding != '' ? 'cellpadding="'.$this->table_padding.'"': '');
    	$spacing = ($this->table_spacing != '' ? 'cellspacing="'.$this->table_spacing.'"': '');

    	$table = '<table '.$id.' '.$class.' '.$style.' '.$border.' '.$padding.' '.$spacing.'>';
    	$table .= $this->header_row;
    	$table .= $this->body_rows;
    	$table .= '</table>';

    	return $table;
    }

}

?>