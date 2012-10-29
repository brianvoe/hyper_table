<?php 

class hyper_table {
	// Table variables
	public $table_id = '';
	public $table_class = '';
	public $table_style = '';
	public $table_border = 0;
	public $table_padding = 0;
	public $table_spacing = 0;

    // Set data
    public $columns = array();
    public $data = array();

    // Header row
    public $header_row = '';
	public $row_info_num = 0;

	// Body rows
    public $odd_class = '';
    public $even_class = '';
    public $body_rows = '';

    function set_info($info = array()) {
        $this->data = (is_object($info) ? (array) $info: $info);
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
        // if object convert to associative array
    	$this->columns = $header['columns'];

    	$this->header_row = '<thead>';
    	$this->header_row .= '<tr>';
    	foreach($this->columns as $column) {
    		// Set variables
    		$class = (isset($column['atag']['class']) ? 'class="'.$column['atag']['class'].'"': '');
    		$title = (isset($column['atag']['title']) ? 'title="'.$column['atag']['title'].'"': '');
    		$href = (isset($column['atag']['href']) ? $column['atag']['href']: '');

    		$this->header_row .= '<td '.(isset($column['style']) ? 'style="'.$column['style'].'"': '').'>';
    		$this->header_row .= (isset($column['atag']) ? '<a '.$class.' '.$title.' href="'.$href.'">': '');
    		$this->header_row .= (isset($column['title']) ? $column['title']: '');
    		$this->header_row .= (isset($column['atag']) ? '</a>': '');
    		$this->header_row .= '</td>';
    	}
    	$this->header_row .= '</tr>';
    	$this->header_row .= '</thead>';
    }

    function set_body($info = array()) {
        // Set variables
        $this->odd_class = (isset($info['odd_class']) ? 'class="'.$info['odd_class'].'"': ($this->odd_class == '' ? '': 'class="'.$this->odd_class.'"'));
        $this->even_class = (isset($info['even_class']) ? 'class="'.$info['even_class'].'"': ($this->even_class == '' ? '': 'class="'.$this->even_class.'"'));
        $row_num = 1;
        $this->row_info_num = 0;

        $this->body_rows = '<tbody>';
        if($this->data){
            foreach($this->data as $row) {
                $row = (is_object($row) ? (array) $row: $row); // Ensure its an array
                // Loop through rows
                $this->body_rows .= '<tr '.($row_num % 2 ? $this->even_class: $this->odd_class).'>';
                foreach($this->columns as $column) {
                    // Loop through columns
                    $this->body_rows .= '<td>';
                    if(isset($column['value'])) {
                        $this->body_rows .= $this->replace_data($column['value']);
                    } else if(isset($column['dbval'])) {
                        $this->body_rows .= $row[$column['dbval']];
                    } else {
                        if(!isset($column['func'])){
                            $this->body_rows .= '';
                        } else {
                            if(isset($info['funcs'][$column['func']])) {
                                // If it has a function run to update value
                                $this->body_rows .= $this->replace_data($info['funcs'][$column['func']]($this));
                            } else {
                                $this->body_rows .= $row[$column['func']];
                            }
                        }
                    }
                    $this->body_rows .= '</td>';
                }
                $this->body_rows .= '</tr>';
                $row_num++;
                $this->row_info_num++;
            }
        }
        $this->body_rows .= '</tbody>';
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

    function replace_data($value) {
    	$row_info = $this->data[$this->row_info_num];
        // Replace {{column}} is dbvalue
        foreach($row_info as $dbkey => $dbvalue) {
            $value = str_replace('{{'.$dbkey.'}}', $dbvalue, $value);
        }
        return $value;
    }

}

?>