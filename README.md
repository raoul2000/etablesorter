This Yii extension is a wrapper for the TableSorter [JQuery Plugin](http://tablesorter.com/docs/) 
It allows client side table sorting with minimum effort. 

##Requirements

Yii 1.1 or above (but should work with older versions)

##Usage

To use this extension insert the ETableSorter widget in the view where the target table is
also displayed.

~~~
[php]
<?php
	$this->widget('ext.etablesorter.ETableSorter',array(
	 	'tableId' 			=> 'myTable',
	 	'theme'				=> 'blue',
		'cancelSelection' 	=> true,
		'cssDesc' 			=> 'styleHeader',
		'cssAsc'			=> 'styleAsc',
	  )
	);
?>

<table id="myTable" class="tablesorter"> 
<thead> 
<tr> 
    <th>Last Name</th> 
    <th>First Name</th> 
    <th>Email</th> 
    <th>Due</th> 
    <th>Web Site</th> 
</tr> 
</thead> 
<tbody> 
<tr> 
    <td>Smith</td> 
    <td>John</td> 
    <td>jsmith@gmail.com</td> 
    <td>$50.00</td> 
    <td>http://www.jsmith.com</td> 
</tr> 
<tr> 
    <td>Bach</td> 
    <td>Frank</td> 
    <td>fbach@yahoo.com</td> 
    <td>$50.00</td> 
    <td>http://www.frank.com</td> 
</tr> 
<tr> 
    <td>Doe</td> 
    <td>Jason</td> 
    <td>jdoe@hotmail.com</td> 
    <td>$100.00</td> 
    <td>http://www.jdoe.com</td> 
</tr> 
<tr> 
    <td>Conway</td> 
    <td>Tim</td> 
    <td>tconway@earthlink.net</td> 
    <td>$50.00</td> 
    <td>http://www.timconway.com</td> 
</tr> 
</tbody> 
</table> 

~~~

##Resources

 * [Try out a demo - TableSorted Jquery page](http://tablesorter.com/docs/)
