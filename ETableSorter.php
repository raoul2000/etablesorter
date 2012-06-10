<?php
/**
 * This class implements the TableSorter JQuery Plugin.
 * It initialize the plugin and in particular the id of the table that will be
 * handled by the plugin.<br/>
 * The example below initialize the TableSorter Plugin for the table with id 'myTableId'. The
 * 'green' theme will be used, and it will be displayed  sorted on the first column and third 
 * column, order asc <br>
 * <pre>
 * $this->widget('ext.tablesorter.ETableSorter',array(
 *	'tableId' => 'myTableId',
 *	'theme'=> 'green',
 *	'options'=> array(
 *		'sortList'=> array(
 *			array(0,0),
 *			array(2,0)
 *		),
 *	)
 * ));
 * </pre>
 * see : http://tablesorter.com/docs/
 */
class ETableSorter extends CWidget {
	
	/**
	 * @var boolean (default TRUE) Indicates if tablesorter should disable selection of text in the table header (TH). Makes header behave 
	 * more like a button.
	 */
	public $cancelSelection;
	/**
	 * @var string (default headerSortUp) The CSS style used to style the header when sorting ascending.
	 */
	public $cssAsc;
	/**
	 * @var string (default headerSortDown) The CSS style used to style the header when sorting descending 
	 */
	public $cssDesc;
	/**
	 * @var string (default header) The CSS style used to style the header in its unsorted state.
	 */
	public $cssHeader;
	/**
	 * @var boolean (default FALSE) Boolean flag indicating if tablesorter should display debuging information usefull for development.
	 * (debug information are displayed in the console).
	 */
	public $debug;
	/**
	 * @var string (default NULL)  An object of instructions for per-column controls in the format: headers: { 0: { option: setting }, ... } For example, 
	 * to disable sorting on the first two columns of a table: headers: { 0: { sorter: false}, 1: {sorter: false} }
	 */
	public $headers;
	/**
	 * @var array Use to add an additional forced sort that will be appended to the dynamic selections by the user. For example, can be used to sort people 
	 * alphabetically after some other user-selected sort that results in rows with the same value like dates or money due. It can help prevent data 
	 * from appearing as though it has a random secondary sort.
	 */
	public $sortForce;
	/**
	 * @var array An array of instructions for per-column sorting and direction in the format: [[columnIndex, sortDirection], ... ] where columnIndex is a 
	 * zero-based index for your columns left-to-right and sortDirection is 0 for Ascending and 1 for Descending. A valid argument that sorts ascending 
	 * first by column 1 and then column 2 looks like: [[0,0],[1,0]]
	 */	
	public $sortList;
	/**
	 * @var string (default shiftKey) The key used to select more than one column for multi-column sorting. Defaults to the shift key. Other options might be ctrlKey, altKey.
	 * Reference: http://developer.mozilla.org/en/docs/DOM:event#Properties
	 */
	public $sortMultiSortKey;
	/**
	 * @var Defines which method is used to extract data from a table cell for sorting. Built-in options include "simple" and "complex". Use complex 
	 * if you have data marked up inside of a table cell like: <td><strong><em>123 Main Street</em></strong></td>. Complex can be slow in 
	 * large tables so consider writing your own text extraction function "myTextExtraction" which you define like:
	 * <pre>var myTextExtraction = function(node)  
	 * {  
	 *        // extract data from markup and return it  
     * 	     return node.childNodes[0].childNodes[0].innerHTML; 
	 *  } 
	 * </pre>
	 * tablesorter will pass a jQuery object containing the contents of the current cell for you to parse and return. Thanks to Josh Nathanson for the examples.
	 */
	public $textExtraction;
	/**
	 * @var boolean (default FALSE) Indicates if tablesorter should apply fixed widths to the table columns. This is useful for the Pager companion. 
	 * Requires the {@link http://tablesorter.com/docs/#Download-Addons} jQuery dimension plugin to work.
	 */
	public $widthFixed;
	
	////////////////////////////////////////////////////////////////////////////////////
	// attributes below are not part of the original Table Sorter Plugin option set
	
	protected $supportedClientOptions = array(
		'cancelSelection','cssAsc','cssDesc','cssHeader','debug','headers','sortForce','sortList',
		'sortMultiSortKey','textExtraction','widthFixed'
	);	
	/**
	 * @var string unique identifier for the table that is managed by the TableSorter Plugin.
	 * If it is not set, an exception is thrown.
	 */	
	public $tableId=null;
	/**
	 * @var string Built-in theme name to use for the table that is handled by the TableSorter
	 * Plugin. Possible values are : blue, green, neutral. If not set, then it is user responsability
	 * to provide the CSS file.
	 */		
	public $theme=null;
	/**
	 * @see CWidget::run()
	 */
	public function run()
	{		
		if(empty($this->tableId)){
			throw new CException('missing table id : tableId', -1);
		}
		$this->registerClientScript();
	}
	/**
	 * Publish and register all required assets
	 * @throws CException
	 */
	public function registerClientScript()
	{
		try{
	
			// publish and register assets : js, css

			$assets = dirname(__FILE__).'/assets';
			$baseUrl = Yii::app()->assetManager->publish($assets,false,0,YII_DEBUG);
			$jsFile=( defined(YII_DEBUG) ? 'jquery.tablesorter.js' : 'jquery.tablesorter.min.js');
			
			$id=$this->getId();
			$cs=Yii::app()->getClientScript();
			
			$cs->registerCoreScript('jquery');
			$cs->registerScriptFile($baseUrl.'/'.$jsFile, CClientScript::POS_HEAD);
			$cs->registerScript('Yii.ETableSorter#'.$id,"$(\"#{$this->tableId}\").tablesorter(".CJavaScript::encode($this->getClientOptions()).");");
				
			if(!empty($this->theme)){
				$cs->registerCssFile($baseUrl.'/themes/'.$this->theme.'/style.css');	
			}			
		}catch(CException $e){
			throw new CException('failed to publish/register assets : '.$e->getMessage());
		}
	}	
	/**
	 * Creates the associative array that contains all Guiders plugin options.
	 * @return array Guiders init parameters
	 */
	protected function getClientOptions(){
		$options=array();
		foreach($this->supportedClientOptions as $property) {
			if(!empty($this->$property)){
				$options[$property]=$this->$property;
			}
		}
		return $options;
	}		
}