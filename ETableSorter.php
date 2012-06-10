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
	 * @var boolean When TRUE, the minified version of the plugin is used
	 */	
	public $useMin = true;
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
	 * @var array JS options to initialize the TableSorter Plugin. See related documentation for
	 * complete list of options (http://tablesorter.com/docs/#Configuration)
	 */	
	public $options;
	
	private $_jsFile;
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
			// get client js options in JSON format
			$options=$this->options===array()?'{}' : CJavaScript::encode($this->options);	
						
			// publish and register assets : js, css

			$assets = dirname(__FILE__).'/assets';
			$baseUrl = Yii::app()->assetManager->publish($assets);
			$jsFile=($this->useMin===true?'jquery.tablesorter.min.js':'jquery.tablesorter.js');
			$id=$this->getId();
			$cs=Yii::app()->getClientScript();
			
			$cs->registerCoreScript('jquery')	
				->registerScriptFile($baseUrl.'/'.$jsFile, CClientScript::POS_HEAD)
				->registerScript('Yii.ETableSorter#'.$id,"$(\"#{$this->tableId}\").tablesorter($options);");
				
			if(!empty($this->theme)){
				$cs->registerCssFile($baseUrl.'/themes/'.$this->theme.'/style.css');	
			}			
		}catch(CException $e){
			throw new CException('failed to publish/register assets : '.$e->getMessage());
		}
	}		
}