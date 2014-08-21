<?php
$optionsArray = array(
'elementId'=> 'showBarcode', /* div or canvas id*/
'value'=> '4797001018719', /* value for EAN 13 be careful to set right values for each barcode type */
'type'=>'supported types ean13',/* ean8, ean13, upc, std25, int25, code11, code39, code93, code128, codabar, msi, datamatrix*/

);
$this->widget('ext.barcode.Barcode', $optionsArray);
~~~

- Widget with advanced options 
- Kindly note there are specific setting for canvas output and datamatrix type if     not set default settings will be applied.
?>
