<?php

use PHPUnit\Framework\TestCase;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * subclass to exchange the move_uploaded_file function
 */
class TestablePictureUploader extends PictureUploader
{
    function move_uploaded_file($temporary_name, $target_path)
    {
        return copy($temporary_name, $target_path); 
    } 
}

class PictureUploaderTest extends TestCase {
     

    private $destFolderPath = "/tmp/bildergalerie/PictureUploaderTest";

    /**
     * rm -r
     */
    private static function delTree($dir){
        $files = array_diff(scandir($dir), array('.','..')); 
        foreach ($files as $file) { 
            (is_dir("$dir/$file")) ? PictureUploaderTest::delTree("$dir/$file") : unlink("$dir/$file"); 
        } 
        return rmdir($dir); 
    }

    /**
     * @before
     */
    public function setup()
    {
        // remove tmp folder if exist
        if (is_dir($this->destFolderPath)) { 
            PictureUploaderTest::delTree($this->destFolderPath);
        }
        mkdir($this->destFolderPath, 0777, true); 
    }

    /**
     * @after
     */
    public function tearDown()
    { 
        // remove tmp folder
        if (is_dir($this->destFolderPath)) {
            //PictureUploaderTest::delTree($this->destFolderPath); 
        }
    }
    
    public function testUploadFile() {
        $sourceFilePath = realpath("test/e2e/pictures/twitter.png");  
        $targetName = "_pictureUploaderImage.png";
    
        $tmpFile = array(
            "tmp_name" => $sourceFilePath,
            "name" =>  $targetName 
        );  

        // no file/thumb should exist
        $this->assertFileNotExists($this->destFolderPath . "/" .  $targetName ) ;
        $this->assertFileNotExists($this->destFolderPath . "/thumbs/" . $targetName);

        // perform upload
        $uploader = new TestablePictureUploader($tmpFile, $this->destFolderPath);
        $uploader->uploadFile(32); // small thumb 

        // source file should be copied
        $this->assertFileExists($this->destFolderPath . "/" . $targetName ) ;
        $this->assertEquals(filesize( $sourceFilePath), filesize($this->destFolderPath . "/" . $targetName));

        // thumbnail should be generated and smaller than source file
        $this->assertFileExists($this->destFolderPath . "/thumbs/" . $targetName); 
        $this->assertGreaterThan(5,10);
        $this->assertGreaterThan(filesize($this->destFolderPath . "/thumbs/" . $targetName), filesize($this->destFolderPath . "/" . $targetName));

    } 

}