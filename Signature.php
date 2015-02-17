<?php

	class Signature
	{

		private static $captureForm, $signeeId;
		private static $opts;

		public function __get($property)
		{

		}

		public static function capture()
		{
			self::loadConfig();
			include __DIR__ . "/views/captureForm.php";
		}

		private static function loadConfig()
		{
			self::$opts = file_get_contents(__DIR__ . "/configs/signature-options.json");
		}

		/*	private static function instantiate()
		 {
		 if (!self::$instance) {
		 self::$instance = new self;
		 }
		 return self::$instance;
		 }*/

		public static function saveSignature($signature, $signee = null, $id = null)
		{

			if (!$id && !$signee && !$_POST['sid']) {
				die("Signee and Signee ID cannot both be null - ");
			}

			try {
				file_put_contents(DATA_PATH . "Signatures/" . $id . $signee . "_signature.png.base64", $signature);
			} catch(Exception $e) {
				$return['error'] = "An error occurred - contact the admin & try again, or simply revert to good ol' pen & paper";
				$return['status'] = "error";
			}
			$return['message'] = "Signature Saved Successfully";
			$return['status'] = $return['status'] ? : "success";
			echo json_encode($return);

		}

		public function test()
		{
			self::capture();
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

		public function js()
		{
			header("Content-Type: application/javascript");
			$script = file_get_contents(__DIR__ . "/www/js/signature_pad/signature_pad.js");
			$script .= file_get_contents(__DIR__ . "/www/js/signature_pad/signature_pad_wrapper.js");
			echo $script;
		}

	}
