<?php
namespace Sensibilis\Controller;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class Image 
{
   protected $app;

   // constructor receives container instance
   public function __construct($app) {
       $this->app = $app;
   }
   
   public function icon(Request $request, Response $response, $args){
   	    $identicon = new \Identicon\Identicon();
   	    $identicon->displayImage($args['string']);
   	    return $response;
   }
}
