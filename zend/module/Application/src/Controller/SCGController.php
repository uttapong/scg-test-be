<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Zend\Cache\StorageFactory;

class SCGController extends AbstractActionController
{
    public function indexAction()
    {
        // echo "adfadfadf";
        //https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=13.8206972,100.5239867&radius=1500&type=restaurant&key=AIzaSyCQWpAtVowR7C1BRlml8_LeRMWSpKUZ1HQ
        $view = new ViewModel();
        $view->setTerminal(true);

        return $view;
    }

    public function searchAction()
    {
//         $view = new \Zend\View\Model\ViewModel();
//         $view->setTerminal(true);
        $headers = $this->getResponse()->getHeaders();
        $headers->addHeaderLine(
             "Access-Control-Allow-Origin: *");
        $endPoint = "https://maps.googleapis.com/maps/api/place/";
        $mapKey = "AIzaSyCQWpAtVowR7C1BRlml8_LeRMWSpKUZ1HQ";
        $searchLocation = $this->getRequest()->getQuery('location');

        if($redis->get('location_'.$searchLocation))return new JsonModel(unserialize ($redis->get('location_'.$searchLocation)));
        
        $searchUrl ="{$endPoint}findplacefromtext/json?input={$searchLocation}&inputtype=textquery&fields=photos,formatted_address,name,rating,opening_hours,geometry&key={$mapKey}";

        // echo $searchUrl;

        $responseLocation = json_decode(file_get_contents($searchUrl),true);
        $resultLatLng = $responseLocation["candidates"][0]["geometry"]["location"];
        if(!$resultLatLng)
            return new JsonModel(['status'=>-1,"message"=>"Location not found"]);
        

        $searchResultUrl = "{$endPoint}nearbysearch/json?location={$resultLatLng['lat']},{$resultLatLng['lng']}&radius=1500&type=restaurant&key={$mapKey}";
        // echo $searchResultUrl;
        $responseList = json_decode(file_get_contents($searchResultUrl),true);
        $redis->set('location_'.$searchLocation, serialize ($responseList['results']));
        // echo file_get_contents($placeUrl);
        return new JsonModel($responseList['results']);
        
        //https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=13.8206972,100.5239867&radius=1500&type=restaurant&key=AIzaSyCQWpAtVowR7C1BRlml8_LeRMWSpKUZ1HQ
        return;
    }

    public function polynomialAction(){
        $headers = $this->getResponse()->getHeaders();
        $headers->addHeaderLine(
             "Access-Control-Allow-Origin: *");

        $redis = new \Redis();
        $redis->connect('redis', 6379);
        $redis->set('message', 'Hello world');

        $numCount =intval( $this->getRequest()->getQuery('count'));
            // print_r(unserialize( $redis->get('count_'.$numCount)));   die();     
        if($redis->get('count_'.$numCount))return new JsonModel(unserialize ($redis->get('count_'.$numCount)));

        $result=array();
        for($i=0;$i<$numCount;$i++){
            array_push($result,3+$i+($i*$i));
        }
        $redis->set('count_'.$numCount, serialize ($result));

        return new JsonModel($result);
    }   
}
