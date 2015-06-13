<?php
/**
 * Wrapper  for BarCode Coder Library (BCC Library)
 *  BCCL Version 2.0
 *    
 *  Porting : jQuery barcode plugin 
 *  Version : 2.0.3
 *   
 *  Date    : 2013-01-06
 *  Author  : DEMONTE Jean-Baptiste <jbdemonte@gmail.com>
 *            HOUREZ Jonathan
 *             
 *  Web site: http://barcode-coder.com/
 *  dual licence :  http://www.cecill.info/licences/Licence_CeCILL_V2-fr.html
 *                  http://www.gnu.org/licenses/gpl.html * 
 * @author Vilochane <vilochane@gmail.com>
 * @link GitHub https://github.com/Vilochane
 * @link yii http://www.yiiframework.com/forum/index.php/user/223499-vilo/
 */
class Barcode extends CWidget {

    public $elementId; /* <div id="barcodeTarget" class="barcodeTarget"></div> OR <canvas id="canvasTarget" width="150" height="150"></canvas> */
    public $value;
    public $type; /* ean8, ean13, upc, std25, int25, code11, code39, code93, code128, codabar, msi, datamatrix */
    public $rectangular = false;
    public $settings = array();
    private $defaultSettings = array(
        'output' => 'css', /* css, bmp, svg, canvas */
        'bgColor' => '#FFFFFF', /*background color*/
        'color' => '#000000', /*"1" Bars color*/
        'barWidth' => 1,
        'barHeight' => 50,
        'moduleSize' => 5,
        'addQuietZone' => 0,
        'posX' => 10,
        'posY' => 20
        );

    public function init() {
        $this->publishAssets();
    }

    public function run() {
        $cs = Yii::app()->clientScript;
        $cs->registerScript(__CLASS__ . uniqid(), $this->getBarcode(), CClientScript::POS_END);
    }

    public function publishAssets() {
        $assets = dirname(__FILE__) . "/assets";
        $baseUrl = Yii::app()->assetManager->publish($assets);
        $cs = Yii::app()->clientScript;
        $cs->registerCoreScript('jquery');
        if (is_dir($assets)) {
            $cs->registerScriptFile($baseUrl . '/jquery-barcode.min.js', CClientScript::POS_HEAD);
        } else {
            throw new Exception("barcode - couldn't publish assets");
        }
    }

    private function getBarcode() {
        if(count($this->settings) > 0){
            $this->defaultSettings = array_merge($this->defaultSettings,$this->settings);
        }
        $settings = CJSON::encode($this->defaultSettings);
        $output = $this->defaultSettings['output'];
        $value = $this->value;
        if ($this->rectangular === true) {
            $value = "{code: $this->value, rect: true}";
        }

        if ($output === 'canvas') {
            $initBarcode = 'clearCanvas(); $("#' . $this->elementId . '").show().barcode(value, type, settings);';
        } else {
            $initBarcode = '$("#' . $this->elementId . '").html("").show().barcode(value, type, settings);';
        }

        $js = "  var value = '$value';"
                . "var type = '$this->type';"
                . "var settings = $settings;"
                . "      function clearCanvas(){
                            var canvas = $('#".$this->elementId."').get(0);
                            var ctx = canvas.getContext('2d');
                            ctx.lineWidth = 1;
                            ctx.lineCap = 'butt';
                            ctx.fillStyle = '#FFFFFF';
                            ctx.strokeStyle  = '#000000';
                            ctx.clearRect (0, 0, canvas.width, canvas.height);
                            ctx.strokeRect (0, 0, canvas.width, canvas.height);
                          }"
                . "$initBarcode"
                . "";        
        return $js;
    }

}
