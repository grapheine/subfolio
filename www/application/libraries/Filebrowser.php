<?php

/**
 *  Filebrowser
 */
class Filebrowser {
  var $config_name    = "auth";

  var $folder         = "";
  var $fullfolderpath = "";
  
  var $file           = "";
  var $filepath       = "";
  var $fullfilepath   = "";

  var $files          = array();

  var $properties     = array();

  public function __construct($config_name='filebrowser') {
    $this->config = Kohana::config($config_name);
    $this->config_name = $config_name;
    
    $this->folder = $this->config['directory'];
    $this->path = '';
  }


	public static function instance($config_name='filebrowser') {
    static $instance;
    // Load the Authlite instance
    empty($instance) and $instance = new Filebrowser($config_name);
    return $instance;
	}

  public function set_path($path='') {
    $fullpath = $this->config['directory']."/".$path;
    
    if (is_dir($fullpath)) {
      $this->folder = $path;
      $this->fullfolderpath = $fullpath;

      $this->file = '';
      $this->fullfilepath = '';
    } else {

      $this->folder = dirname($path);
      $this->fullfolderpath = $this->config['directory']."/".dirname($path);

      $this->file         = basename($path);
      $this->filepath     = $path;
      $this->fullfilepath = $this->config['directory']."/".$path;
    }
    chdir($this->fullfolderpath."/");
  }  

  public function is_file() {
    if ($this->file == '') {
      return false;
    } else {
      return true;
    }
  }

  public function is_dir() {
    if ($this->file == '') {
      return true;
    } else {
      return false;
    }
  }

  public function get_file_list($kind=null){
    $files = array();
    foreach (glob("*") as $filename) {
      if (!is_dir($filename)) {
        $stats = stat($filename);
        $ff = new FileFolder($filename, $this->folder, 'file', $stats, 'comment');
        
        if ($kind != null) {
          $filekind = $this->get_kind($filename);
          if ($filekind === $kind) {
            $files[] = $ff;
          }
        } else {
          $files[] = $ff;
        }
      }
    }
    
    return $files;
  }

  public function get_folder_list($pattern='*'){
    $folders = array();
    foreach (glob("*") as $filename) {
      if (is_dir($filename)) {
        $stats = stat($filename);
        $ff = new FileFolder($filename, $this->folder, 'file', $stats, 'comment');
        $folders[] = $ff;
      }
    }
    return $folders;
  }

  public function get_link($name) {
    if ($this->folder == "") {
      $link = "/".$name;
    } else {
      $link = "/".$this->folder."/".$name;
    }
    return $link;
  }

  public function get_file_url() {
    return "/directory/".$this->filepath;
  }




  
  function get_kind($file) {
    $path_parts = pathinfo($file);
    $extension = $path_parts['extension'];

  	// get the extention
    $extension = strtolower($extension);
    $kind = "none";
  
    if ($extension <> "") {
      switch ($extension) {
        case '':
          $kind = 'gen';
        break;
  
        case 'dir':
          $kind = 'dir';
        break;
  
        case 'png':
        case 'gif':
        case 'jpg':
          $kind = 'img';
        break;
  
        case 'ai':
        case 'eps':
          $kind = 'ai';
        break;
  
        case 'indd':
        $kind = 'indd';
        break;
        
        case 'psd':
        case 'tif':
        case 'tiff':
          $kind = 'psd';
        break;
        
        case 'bmp':
          $kind = 'gen';
        break;
        
        case 'lnk':
        case 'fr':
        case 'biz':
        case 'com':
        case 'net':
        case 'org':
        case 'html':
          $kind = 'net';
        break;
        
        case 'pop':
          $kind = 'pop';
        break;
        
        case 'xml':
        case 'txt':
        case 'php':
          $kind = 'txt';
        break;
        
        case 'swf':
          $kind = 'fla';
        break;
        
        case 'cut':
          $kind = 'cut';
        break;
        
        case 'dcr':
          $kind = 'dcr';
        break;
        
        case 'mel':
          $kind = 'mel';
        break;
        
        case 'sit':
        case 'zip':
        case 'dmg':
        case 'gz':
          $kind = 'zip';
        break;
        
        case 'suit':
          $kind = 'fnt';
        break;
        
        case 'avi':
        case 'mov':
        case 'mpg':
        case 'mpeg':
          $kind = 'vid';
        break;
        
        case 'mp3':
        case 'wav':
          $kind = 'snd';
        break;
        
        case 'php':
          $kind = 'php';
        break;
        
        case 'pdf':
          $kind = 'pdf';
        break;
        
        case 'doc':
        case 'rtf':
        case 'sql':
          $kind = 'doc';
        break;
        
        case 'ppt':
          $kind = 'ppt';
        break;
        
        case 'xls':
          $kind = 'xls';
        break;
        
        case 'site':
          $kind = 'site';
        break;
        
        case 'mail':
          $kind = 'mail';
        break;
        
        default:
          $kind = "unknown";
      }
    }
    
    return $kind;
  }
  
  function get_kind_display($file) {
    $kind = $this->get_kind($file);
    if ($kind<> "") {
      switch ($kind) {
        case 'gen':
          $display = '';
        break;
    
        case 'dir':
          $display = 'Folder';
        break;
    
        case 'doc':
          $display = 'Word Document';
        break;
    
        case 'ppt':
          $display = 'Powerpoint Document';
        break;
    
        case 'xls':
          $display = 'Excel Document';
        break;
    
        case 'img':
          $display = 'Image';
        break;
    
        case 'ai':
          $display = 'Illustrator File';
        break;
                  
        case 'indd':
          $display = 'InDesign Document';
        break;
                  
        case 'psd':
          $display = 'Photoshop File';
        break;
  
        case 'cut':
          $display = 'Shortcut';
        break;
  
        case 'net':
          $display = 'Internet Location';
        break;
  
        case 'pop':
          $display = 'Popup Window';
        break;
            
        case 'txt':
          $display = 'Text';
        break;
  
        case 'snd':
          $display = 'Audio File';
        break;
  
        case 'vid':
          $display = 'Movie';
        break;
  
        case 'fla':
          $display = 'Flash Movie';
        break;
  
        case 'ftr':
          $display = 'Feature';
        break;
  
        case 'zip':
        case 'dmg':
        case 'sit':
          $display = 'Archive';
        break;
  
        case 'php':
          $display = 'Script';
        break;
  
        case 'dcr':
          $display = 'Shockwave Movie';
        break;
  
        case 'pdf':
          $display = 'PDF Document';
        break;
  
        case 'fnt':
          $display = 'Font Suitcase';
        break;
  
        case 'site':
          $display = 'Mini Site';
        break;
  
        case 'mail':
          $display = 'Contact Form';
        break;
  
        default:
          $display = $kind;
      }
    }
    return $display;
  }
  
}


?>