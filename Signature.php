<?php

class Signature
{

    private static $captureForm;
    private static $opts;

    public function __get($property)
    {

    }

    public static function capture()
    {

        self::verifyInstallation();

        if (defined(SIGNATURE_CAPTURE_OPTS)) {
            self::$opts = json_encode(unserialize(SIGNATURE_CAPTURE_OPTS), JSON_PRETTY_PRINT);
        } else {
            self::$opts = json_encode(array(
                "minWidth" => .1,
                "maxWidth" => 5,
                "penColor" => "rgb(40,40,40)",
                "backgroundColor" => "rgb(255,255,255)",
                "onEnd" => 'function(){ $("#signatureCapture > button").removeAttr("disabled");)}',
            ));
        }

        include DATA_PATH . "Signatures/captureForm.php";
        //		echo self::$captureForm ? : self::$captureForm =
        // file_get_contents(DATA_PATH . "Signatures/captureForm.php");
    }

    public static function saveSignature($id = null, $signee = null, $signature)
    {

        if (!$id && !$signee) {
            die("Signee and Signee ID cannot both be null - ");
        }

        try {
            file_put_contents(DATA_PATH . "Signatures/" . $id . $signee . "sig", $signature);
        } catch(Exception $e) {
            echo "An error occurred - contact the admin & try again, or simply revert to good ol' pen & paper";
        }
        echo "Signature Saved Successfully ";

    }

    private static function verifyInstallation()
    {

        if (!defined(DATA_PATH)) {
            define("DATA_PATH", "./");
        }

    }

    public function process()
    {
        Signature::saveSignature(filter_var($_POST['signeeId'], FILTER_VALIDATE_INT), filter_var($_POST['signee'], FILTER_SANITIZE_STRING), $_POST['signature']);

    }

    public function loadSignature()
    {

    }

    protected function updateAssets()
    {
        $updateSite = "https://github.com/szimek/signature_pad/archive/master.zip";
    }

    public function deleteSignature()
    {

    }

}
