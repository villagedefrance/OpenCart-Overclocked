<?php 

include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'file_manager/elFinderConnector.class.php';
include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'file_manager/elFinder.class.php';
include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'file_manager/elFinderVolumeDriver.class.php';
include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'file_manager/elFinderVolumeLocalFileSystem.class.php';

class File_manager_lib 
{
  public function __construct($opts) 
  {
    $connector = new elFinderConnector(new elFinder($opts));
    $connector->run();
  }
}