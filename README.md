
Yii-Barcode-Generator
=====================
This extension based on  "Simple jQuery Based Barcode Generator"
Wrapper for BarCode Coder Library (BCC Library Version 2.0) by DEMONTE Jean-Baptiste, HOUREZ Jonathan.
Web site: http://barcode-coder.com/

This extension supports barcode types ean8, ean13, upc, std25, int25, code11, code39, code93, code128, codabar, msi, datamatrix


### **Requirements**
- Yii Version 1.1.13 or later


### **Usage**
- Extract the downloaded zip file and place it inside  application extensions directory.
- Use the following code as per your requirement. 

- "div" or "canvas" must be specified with an id in your view where you want to display the bracode 
"<" div id="showBarcode" ">""<"/div">" OR if output option is canvas "<"canvas id="showBarcode" width="150" height="150"">""<"/canvas">"



- Initialize the widget in your view (simple)

````php
$optionsArray = array(
'elementId'=> 'showBarcode', /* div or canvas id*/
'value'=> '4797001018719', /* value for EAN 13 be careful to set right values for each barcode type */
'type'=>'supported types ean13',/* ean8, ean13, upc, std25, int25, code11, code39, code93, code128, codabar, msi, datamatrix*/

);
$this->widget('ext.barcode.Barcode', $optionsArray);
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

- How to use with CGridView
in gridview 

```php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'st-item-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        'item_code', 
        array('name' => 'item_barcode', 'type' => 'raw', 'value'=>'Common::getItemBarcode(array("itemId"=> $data->item_id, "barocde"=>$data->item_barcode))'),
    ),
));
```

- In Common class under models
```php
class Common{
    /* bracode */

    public static function getItemBarcode($valueArray) {
        $elementId = $valueArray['itemId'] . "_bcode";
        $value = $valueArray['barocde'];
        $type = 'code128'; /* you can set the type dynamically if you want valueArray eg - $valueArray['type']*/
        self::getBarcode(array('elementId' => $elementId, 'value' => $value, 'type' => $type));
        $div = CHtml::tag('div', array('id' => $elementId));        
        if(!empty($value)){
            return $div;
        }
        return NULL;
    }

    /**
     * This function returns the item barcode
     */
    public static function getBarcode($optionsArray) {

        Yii::app()->getController()->widget('ext.barcode.Barcode', $optionsArray);
    }

}
```

- Usage with CDetail View

```php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        array(
            'name' => 'item_barcode',
            'type'=>'raw',
            'value' => Common::getItemBarcode(array("itemId"=> $model->item_id, "barocde"=>$model->item_barcode))
        ),
));
```

### Resources

- Try out a [demo](http://www.jqueryscript.net/demo/Simple-jQuery-Based-Barcode-Generator-Barcode/ "Simple jquery barcode")
