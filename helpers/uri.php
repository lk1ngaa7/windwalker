<?php
/**
 * @package     Windwalker.Framework
 * @subpackage  AKHelper
 *
 * @copyright   Copyright (C) 2012 Asikart. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Generated by AKHelper - http://asikart.com
 */


// No direct access
defined('_JEXEC') or die;


class AKHelperUri {
	
	public static function pathAddHost ( $path ) {
		
		if( !$path ) return ;
		
		// build path
	    $uri = new JURI( $path );
	    if( $uri->getHost() ) return $path ;
		
	    $uri->parse( JURI::root() );
		$root_path = $uri->getPath();
		
		if(strpos($path, $root_path) === 0) {
			$num = JString::strlen($root_path) ;
			$path = JString::substr($path, $num) ;
		}
		
	    $uri->setPath( $uri->getPath().$path );
	    $uri->setScheme( 'http' );
	    $uri->setQuery(null);
	    
	    return $uri->toString();
	}
	
	
	
	/*
	 * function pathAddSubfolder
	 * @param $path
	 */
	
	public static function pathAddSubfolder( $path )
	{
		$uri 		= JFactory::getURI() ;
		$host 		= $uri->getScheme().'://'.$uri->getHost();
		$current 	= JURI::root();
		
		$subfolder 	= str_replace( $host, '', $current );
		$subfolder 	= trim($subfolder, '/') ;
		
		return $subfolder . '/' . trim($path, '/') ;
	}
	
	
	
	public static function base64( $action , $url ) {
		
		switch($action) {
			case 'encode' :
				$url = base64_encode( $url );
			break;
			
			case 'decode' :
				$url = str_replace( ' ' , '+' , $url );
				$url = base64_decode( $url );
			break;
		}
		return $url ;
	}
	
	public static function current( $hasQuery = false ) {
		if( $hasQuery )
			return JFactory::getURI()->toString();
		else
			return JURI::current();
	}
	
	
	/*
	 * function component
	 * @param $client
	 */
	
	public static function component($client = 'site', $absoulte = false)
	{
		$root 	= $absoulte ? JURI::base() : '' ;
		$option = JRequest::getVar('option') ;
		
		if($client == 'site'){
			return $root.'components/'.$option ;
		}else{
			return $root.'components/'.$option ;
		}
	}
	
	
	/*
	 * function windwalker
	 * @param $client
	 */
	
	public static function windwalker($absoulte = false)
	{
		$root 	= $absoulte ? JURI::base() : '' ;
		$option = JRequest::getVar('option') ;
		
		return $root.'libraries/windwalker' ;
	}
	
	
	/*
	 * function safe
	 * @param $uri
	 */
	
	public static function safe($uri)
	{
		$uri = (string) $uri ;
		$uri = str_replace(' ', '%20', $uri);
		
		return $uri ;
	}
}


