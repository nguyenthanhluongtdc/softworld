<?php


class FileUploadUtil {

    private static function checkFile($file, $extension) {
        $check = 0;
        if(!isset($file) || $file["error"] != 0) {
            $check = 1;  
        }
        $fileType = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
        // Check file extension
        if(array_key_exists($fileType, $extension)) {
            $check = 2;
        }
        // Check file size
        if ($file["size"] > AppConfig::$FILE_UPLOAD_MAX_SIZE) {
            $check = 3;
        }
        return $check;
    }
    /**
    * Upload file:
    * Returns: filename: success, 1: file upload error, 2: file extension error, 3: file size error
    */
    public static function uploadFile($functionId, $file, $desFolder, $extension) {
        $result = FileUploadUtil::checkFile($file, $extension);
        if($result == 0) {
            if (!is_dir($desFolder) && !mkdir($desFolder)){
              die("Error creating folder $desFile");
            }
            $FileName = FileUploadUtil::getFileName($functionId, $file);
            $desFile = $desFolder."/".$FileName;
            if (!move_uploaded_file($file["tmp_name"], $desFile)) {
                // move file is error.
                $result = 1;
            }
            else{
                return array(
                    'FileName' => $FileName
                    ,'OldName' => $file['name']
                );
            }
        }
        return $result;
    }

    public static function getFileName($functionId, $file) {
        $imageFileType = pathinfo($file["name"], PATHINFO_EXTENSION);
        return $functionId."_".DateUtil::getCurrentDatetime("Ymdhis") .".".$imageFileType;
    }

    public static function delete($path) {
        if(!unlink($path)) {
            return false;
        }
        return true;
    }

    public static function MoveFile($fromFile,$toFile){
        fopen($toFile, "w");
        if(@rename($fromFile,$toFile)){
            fclose($toFile);
            return true;
        }  
        return die('can not move file from $fromFile to $toFile');
    }

    public static function CreateFolder($dirName, $rights=0777){
        $dirs = explode('/', $dirName);
        $dir='';
        foreach ($dirs as $part) {
            $dir.=$part.'/';
            if (!is_dir($dir) && strlen($dir)>0)
                mkdir($dir, $rights);
        }
    }
    // read file
    public static function readCSV($pathUrl, $numCharacter) {
        $file_handle = fopen($pathUrl, 'r');
        $line_of_text = array();
        while (!feof($file_handle)) {
            $line_of_text[] = fgetcsv($file_handle, $numCharacter);
        }
        fclose($file_handle);
        return $line_of_text;
    }


}





?>