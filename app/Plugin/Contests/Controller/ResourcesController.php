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
class ResourcesController extends ContestsAppController
{
    public $name = 'Resources';
    public function admin_index()
    {
        $this->pageTitle = __l('Resources');
		$condition = array();
		if (!isPluginEnabled('VideoResources')) { 
			$condition['Not']['Resource.id'][] = ConstResourceId::Video;
		}
		if (!isPluginEnabled('ImageResources')) { 
			$condition['Not']['Resource.id'][] = ConstResourceId::Image;
		}
		if (!isPluginEnabled('AudioResources')) { 
			$condition['Not']['Resource.id'][] = ConstResourceId::Audio;
		}
		
		if (!isPluginEnabled('TextResources')) { 
			$condition['Not']['Resource.id'][] = ConstResourceId::Text;
		}
		
        $this->Resource->recursive = 0;
		$resources = $this->paginate($condition);
        $this->set('resources', $resources);
    }
}
