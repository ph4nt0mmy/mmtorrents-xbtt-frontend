<?php
/*--------------------------------------------------------------*\
	Description:	HTML template class.
	Author:			Brian Lozier (brian@massassi.net)
	License:		Please read the license.txt file.
	Last Updated:	11/27/2002
\*--------------------------------------------------------------*/
class bTemplate {
	// Configuration variables
	var $base_path = '';
	var $reset_vars = TRUE;

	// Delimeters for regular tags
	var $ldelim = '<';
	var $rdelim = ' />';

	// Delimeters for beginnings of loops
	var $BAldelim = '<';
	var $BArdelim = '>';

	// Delimeters for ends of loops
	var $EAldelim = '</';
	var $EArdelim = '>';

	// Internal variables
	var $scalars = array();
	var $arrays  = array();
	var $carrays = array();
	var $ifs     = array();

	/*--------------------------------------------------------------*\
		Method: bTemplate()
		Simply sets the base path (if you don't set the default).
	\*--------------------------------------------------------------*/
	function bTemplate($base_path = NULL, $reset_vars = TRUE) {
		if($base_path) $this->base_path = $base_path;
		$this->reset_vars = $reset_vars;
	}

	/*--------------------------------------------------------------*\
		Method: set()
		Sets all types of variables (scalar, loop, hash).
	\*--------------------------------------------------------------*/
	function set($tag, $var, $if = NULL) {
		if(is_array($var)) {
			$this->arrays[$tag] = $var;
			if($if) {
				$result = $var ? TRUE : FALSE;
				$this->ifs[] = $tag;
				$this->scalars[$tag] = $result;
			}
		}
		else {
			$this->scalars[$tag] = $var;
			if($if) $this->ifs[] = $tag;
		}
	}

	/*--------------------------------------------------------------*\
		Method: set_cloop()
		Sets a cloop (case loop).
	\*--------------------------------------------------------------*/
	function set_cloop($tag, $array, $cases) {
		$this->carrays[$tag] = array(
			'array' => $array,
			'cases' => $cases);
	}

	/*--------------------------------------------------------------*\
		Method: reset_vars()
		Resets the template variables.
	\*--------------------------------------------------------------*/
	function reset_vars($scalars, $arrays, $carrays, $ifs) {
		if($scalars) $this->scalars = array();
		if($arrays)  $this->arrays  = array();
		if($carrays) $this->carrays = array();
		if($ifs)     $this->ifs     = array();
	}

	/*--------------------------------------------------------------*\
		Method: get_tags()
		Formats the tags & returns a two-element array.
	\*--------------------------------------------------------------*/
	function get_tags($tag, $directive) {
		$tags['b'] = $this->BAldelim . $directive . $tag . $this->BArdelim;
		$tags['e'] = $this->EAldelim . $directive . $tag . $this->EArdelim;
		return $tags;
	}

	/*--------------------------------------------------------------*\
		Method: get_tag()
		Formats a tag for a scalar.
	\*--------------------------------------------------------------*/
	function get_tag($tag) {
		return $this->ldelim . 'tag:' . $tag . $this->rdelim;
	}

	/*--------------------------------------------------------------*\
		Method: get_statement()
		Extracts a portion of a template.
	\*--------------------------------------------------------------*/
	function get_statement($t, &$contents) {
		// Locate the statement
		$tag_length = strlen($t['b']);
		$fpos = strpos($contents, $t['b']) + $tag_length;
		$lpos = strpos($contents, $t['e']);
		$length = $lpos - $fpos;

		// Extract & return the statement
		return substr($contents, $fpos, $length);
	}

	/*--------------------------------------------------------------*\
		Method: parse()
		Parses all variables into the template.
	\*--------------------------------------------------------------*/
	function parse($contents) {
		// Process the ifs
		if(!empty($this->ifs)) {
			foreach($this->ifs as $value) {
				$contents = $this->parse_if($value, $contents);
			}
		}

		// Process the scalars
		foreach($this->scalars as $key => $value) {
			$contents = str_replace($this->get_tag($key), $value, $contents);
		}

		// Process the arrays
		foreach($this->arrays as $key => $array) {
			$contents = $this->parse_loop($key, $array, $contents);
		}

		// Process the carrays
		foreach($this->carrays as $key => $array) {
			$contents = $this->parse_cloop($key, $array, $contents);
		}

		// Reset the arrays
		if($this->reset_vars) $this->reset_vars(FALSE, TRUE, TRUE, FALSE);

		// Return the contents
		return $contents;
	}

	/*--------------------------------------------------------------*\
		Method: parse_if()
		Parses an if statement.  There is some weirdness here because
		the <else:tag> tag doesn't conform to convention, so some
		things have to be done manually.
	\*--------------------------------------------------------------*/
	function parse_if($tag, $contents) {
		// Get the tags
		$t = $this->get_tags($tag, 'if:');
		
		// Get the entire statement
		$entire_statement = $this->get_statement($t, $contents);
		
		// Get the else tag
		$tags['b'] = NULL;
		$tags['e'] = $this->BAldelim . 'else:' . $tag . $this->BArdelim;		
		
		// See if there's an else statement
		if(($else = strpos($entire_statement, $tags['e']))) {		
			// Get the if statement
			$if = $this->get_statement($tags, $entire_statement);
		
			// Get the else statement
			$else = substr($entire_statement, $else + strlen($tags['e']));
		}
		else {
			$else = NULL;
			$if = $entire_statement;
		}
		
		// Process the if statement
		$this->scalars[$tag] ? $replace = $if : $replace = $else;

		// Parse & return the template
		return str_replace($t['b'] . $entire_statement . $t['e'], $replace, $contents);
	}

	/*--------------------------------------------------------------*\
		Method: parse_loop()
		Parses a loop (recursive function).
	\*--------------------------------------------------------------*/
	function parse_loop($tag, $array, $contents) {
		// Get the tags & loop
		$t = $this->get_tags($tag, 'loop:');
		$loop = $this->get_statement($t, $contents);
		$parsed = NULL;

		// Process the loop
		foreach($array as $key => $value) {
			if(is_numeric($key) && is_array($value)) {
				$i = $loop;
				foreach($value as $key2 => $value2) {
					if(!is_array($value2)) {
						// Replace associative array tags
						$i = str_replace($this->get_tag($tag . '[].' . $key2), $value2, $i);
					}
					else {
						// Check to see if it's a nested loop
						$i = $this->parse_loop($tag . '[].' . $key2, $value2, $i);
					}
				}
			}
			elseif(is_string($key) && !is_array($value)) {
				$contents = str_replace($this->get_tag($tag . '.' . $key), $value, $contents);
			}
			elseif(!is_array($value)) {
				$i = str_replace($this->get_tag($tag . '[]'), $value, $loop);
			}

			// Add the parsed iteration
			if(isset($i)) $parsed .= rtrim($i);
		}

		// Parse & return the final loop
		return str_replace($t['b'] . $loop . $t['e'], $parsed, $contents);
	}

	/*--------------------------------------------------------------*\
		Method: parse_cloop()
		Parses a cloop (case loop) (recursive function).
	\*--------------------------------------------------------------*/
	function parse_cloop($tag, $array, $contents) {
		// Get the tags & loop
		$t = $this->get_tags($tag, 'cloop:');
		$loop = $this->get_statement($t, $contents);

		// Set up the cases
		$array['cases'][] = 'default';
		$case_content = array();
		$parsed = NULL;

		// Get the case strings
		foreach($array['cases'] as $case) {
			$ctags[$case] = $this->get_tags($case, 'case:');
			$case_content[$case] = $this->get_statement($ctags[$case], $loop);
		}

		// Process the loop
		foreach($array['array'] as $key => $value) {
			if(is_numeric($key) && is_array($value)) {
				// Set up the cases
				if(isset($value['case'])) $current_case = $value['case'];
				else $current_case = 'default';
				unset($value['case']);
				$i = $case_content[$current_case];

				// Loop through each value
				foreach($value as $key2 => $value2) {
					$i = str_replace($this->get_tag($tag . '[].' . $key2), $value2, $i);
				}
			}

			// Add the parsed iteration
			$parsed .= rtrim($i);
		}

		// Parse & return the final loop
		return str_replace($t['b'] . $loop . $t['e'], $parsed, $contents);
	}

	/*--------------------------------------------------------------*\
		Method: fetch()
		Returns the parsed contents of the specified template.
	\*--------------------------------------------------------------*/
	function fetch($file_name) {
		// Prepare the path
		$file = $this->base_path . $file_name;

		// Open the file
		$fp = fopen($file, 'rb');
		if(!$fp) return FALSE;
		
		// Read the file
		$contents = fread($fp, filesize($file));

		// Close the file
		fclose($fp);

		// Parse and return the contents
		return $this->parse($contents);
	}
}
?>