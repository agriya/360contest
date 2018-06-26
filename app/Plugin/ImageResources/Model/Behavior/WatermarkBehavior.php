<?php
/**
 * 360Contest
 *
 * PHP version 5
 *
 * @category   PHP
 * @package    360Contest
 * @subpackage Core
 * @author     Agriya <info@agriya.com>
 * @copyright  2018 Agriya Infoway Private Ltd
 * @license    http://www.agriya.com/ Agriya Infoway Licence
 * @link       http://www.agriya.com
 */
/**
 * Model behavior to watermark images
 *
 * @package app
 * @subpackage app.models.behaviors
 */
class WatermarkBehavior extends ModelBehavior
{
    function setup(&$Model, $settings = array())
    {
    }
    function watermark($temp, $class, $size, $currentWidth, $currentHeight, $width, $height)
    {
        if (Configure::read($class . '.' . $size . '.watermark_type')) {
            $watermark_type = Configure::read($class . '.' . $size . '.watermark_type');
        } elseif (Configure::read($class . '.watermark_type')) {
            $watermark_type = Configure::read($class . '.watermark_type');
        }
        if (!empty($watermark_type)) {
            if ($watermark_type == 'Watermark Image') {
                App::import('Model', 'WaterMark');
                $this->WaterMark = new WaterMark();
                $watermark = $this->WaterMark->find('first', array(
                    'conditions' => array(
                        'WaterMark.class' => 'WaterMark'
                    ) ,
                    'recursive' => -1
                ));
                if (!empty($watermark)) {
                    $options['dimension'] = $size;
                    $options['type'] = 'png';
                    $watermark_image_url = Router::url('/', true) . trim(getImageUrl('WaterMark', $watermark['WaterMark'], $options) , '/');
                }
                $watermark_image_info = getimagesize($watermark_image_url);
                $watermark_position_x = $currentWidth;
                $watermark_position_y = $currentHeight;
                $watermark_image_width = $watermark_image_height = 0;
                if (!empty($watermark_image_info)) {
                    $watermark_position_x = ($width*Configure::read('Watermark.watermark_possition_x')) /100;
                    $watermark_position_y = ($height*Configure::read('Watermark.watermark_possition_y')) /100;
                    $watermark_image_width = $watermark_image_info[0];
                    $watermark_image_height = $watermark_image_info[1];
                }
                $watermark = imagecreatefrompng($watermark_image_url);
                imagecopymerge($temp, $watermark, $watermark_position_x, $watermark_position_y, 0, 0, $watermark_image_width, $watermark_image_height, 20);
                imagedestroy($watermark);
            } elseif ($watermark_type == 'Enable Text Watermark') {
                $font = APP . 'Plugin' . DS . 'ImageResources' . DS . 'webroot' . DS . 'fonts' . DS . 'arial.ttf';
                $grey = imagecolorallocate($temp, 128, 128, 128);
                $watermark_text = (Configure::read('Watermark.watermark_text') !== null) ? Configure::read('Watermark.watermark_text') : Configure::read('site.name');
                $op_watermark_text = '';
                for ($i = 0; $i < 10; $i++) {
                    $op_watermark_text.= '   ' . $watermark_text;
                }
                imagettftext($temp, 20, 0, Configure::read('Watermark.watermark_possition_x') , Configure::read('Watermark.watermark_possition_y') , $grey, $font, $op_watermark_text);
            }
        }
        return $temp;
    }
}
?>