<?php

namespace CMS\System\Component\HttpFoundation\File;

use Symfony\Component\HttpFoundation\File\UploadedFile as SUploadedFile;
use CMS\System\Bundle\CoreBundle\Services\Core as CMSCore;

class UploadedFile extends SUploadedFile {

    public function __construct($dir, $originalName){
        
        $dir = CMSCore::init()->getUploadsDir().'/'.$dir;
        
        parent::__construct($dir, $originalName);
    }
}
