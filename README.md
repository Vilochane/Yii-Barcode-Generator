
Yii-Barcode-Generator
=====================
This extension based on  "Simple jQuery Based Barcode Generator"
Wrapper for BarCode Coder Library (BCC Library Version 2.0) by DEMONTE Jean-Baptiste, HOUREZ Jonathan.
Web site: http://barcode-coder.com/

This extension supports barcode types ean8, ean13, upc, std25, int25, code11, code39, 
code93, code128, codabar, msi, datamatrix


### **Requirements**
- Yii Version 1.1.13 or later


### **Usage**
- Extract the downloaded zip file and place it inside  application extensions directory.
- Use the following code as per your requirement. 

- "div" or "canvas" must be specified with an id in your view where you want to display the bracode 
"<" div id="showBarcode" ">""<"/div">" OR if output option is canvas "<"canvas id="showBarcode" width="150" height="150"">""<"/canvas">"

- Version 1.2 update Fixed the Bug Regarding CDetail View not displaying. Removed div element creation.
- Version 1.1 update Same as the previous but no need of the div element, minor modification of the Common Class function.

#### Helper Class Common under models (No need to call the extension initialization):
````php
class Common{
    /* bracode */
    public static function getItemBarcode($valueArray) {
        $elementId = $valueArray['itemId'] . "_bcode"; /*the div element id*/
        $value = $valueArray['barocde'];
        $type = 'code128'; /* you can set the type dynamically if you want valueArray eg - $valueArray['type']*/
        self::getBarcode(array('elementId' => $elementId, 'value' => $value, 'type' => $type)); 
 return CHtml::tag('div', array('id' => $elementId));
    }
 
    /**
     * This function returns the item barcode
     */
    public static function getBarcode($optionsArray) {
 
        Yii::app()->getController()->widget('ext.Yii-Barcode-Generator.Barcode', $optionsArray);
    }
 
}
````
#### Usage with helper class Common: 
- Usage with CGridView

````php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'st-item-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        'item_code', 
        array('name' => 'item_barcode', 'type' => 'raw', 'value'=>'Common::getItemBarcode(array("itemId"=> $data->item_id, "barocde"=>$data->item_barcode))'),
    ),
));
````
- Usage with CDetail View

````php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        array(
            'name' => 'item_barcode',
            'type'=>'raw',
            'value' => Common::getItemBarcode(array("itemId"=> $model->item_id, "barocde"=>$model->item_barcode))
        ),
));
````
- Usage with a View

````php
/* if multiple barcodes make sure itemId is unique*/
$optionsArray = array(
'itemId'=> 'barcode-div', /*id for div or canvas */
'barocde'=> '4797001018719', /* value for EAN 13 be careful to set right values for each barcode type */
'type'=>'ean13',/*supported types  ean8, ean13, upc, std25, int25, code11, code39, code93, code128, codabar, msi, datamatrix*/
 
);
echo Common::getItemBarcode($optionsArray);
````

#### Initialize the widget in your view regular way by initializing the widget:

````php
echo '<div id="showBarcode"><div>'; //the same id should be given to the extension item id 
 
$optionsArray = array(
'elementId'=> 'showBarcode', /*id of div or canvas*/
'value'=> '4797001018719', /* value for EAN 13 be careful to set right values for each barcode type */
'type'=>'ean13',/*supported types  ean8, ean13, upc, std25, int25, code11, code39, code93, code128, codabar, msi, datamatrix*/
 
);
$this->widget('ext.Yii-Barcode-Generator.Barcode', $optionsArray);
````


- Widget with advanced options 
- Kindly note there are specific setting for canvas output and datamatrix type if not set default settings will be applied.

```php
$optionsArray = array(
'elementId'=>'showBarcode',
'value'=>'4797001018719',
'type' => 'code128',
'settings'=>array(
   'output'=>'css' /*css, bmp, canvas note- bmp and canvas incompatible wtih IE*/,
   /*if the output setting canvas*/
   'posX' => 10,
   'posY' => 20,
   /* */
   'bgColor'=>'#00FF00', /*background color*/
   'color' => '#000000', /*"1" Bars color*/
   'barWidth' => 1,
   'barHeight' => 50,   
   /*-----------below settings only for datamatrix--------------------*/
   'moduleSize' => 5,
   'addQuietZone' => 0, /*Quiet Zone Modules */
 ),
'rectangular'=> true /* true or false*/
 /* */
);
```

### Resources
 
- Try out a [demo](http://www.jqueryscript.net/demo/Simple-jQuery-Based-Barcode-Generator-Barcode/ "Simple jquery barcode")
