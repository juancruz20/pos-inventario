<?php

require_once "extensions/vendor/autoload.php";

use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

/*=============================================
Mostrar errores
=============================================*/

define('DIR',__DIR__);

ini_set("display_errors", 1);
ini_set("log_errors", 1);
ini_set("error_log", DIR."/php_error_log");

/*=============================================
CORS
=============================================*/

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET');
header('content-type: application/json; charset=utf-8');

if(isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "GET"){
	

	class CurlController{
	
		/*=============================================
		Peticiones a la API
		=============================================*/	

		static public function request($url,$method,$fields){

			$curl = curl_init();

			curl_setopt_array($curl, array(
				CURLOPT_URL => 'http://api.pos.com/'.$url,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => $method,
				CURLOPT_POSTFIELDS => $fields,
				CURLOPT_HTTPHEADER => array(
					'Authorization: gdfhdfhsdfyeryr34646fhdfy4564t3456fhgdy'
				),
			));

			$response = curl_exec($curl);

			curl_close($curl);
			$response = json_decode($response);
			return $response;

		}

	}

	/*=============================================
	Traemos info de la orden y los productos
	=============================================*/

	$url = "relations?rel=sales,offices,orders&type=sale,office,order&linkTo=id_order_sale&equalTo=".$_GET["order"]."&select=*";
	$method = "GET";
	$fields = array();

	$getOrder = CurlController::request($url,$method,$fields);

	if($getOrder->status == 200){

		$infoTicket = $getOrder->results;
		
		// Nombre de la impresora compartida
		$connector = new WindowsPrintConnector("smb://COMPUTER/PRINTER");
		$printer = new Printer($connector);

		$printer -> setJustification(Printer::JUSTIFY_CENTER);

		$printer -> text(date("Y-m-d H:i:s")."\n");//Fecha de la factura

		$printer -> feed(1); //Alimentamos el papel 1 vez*/

		$printer -> text(urldecode($infoTicket[0]->title_office)."\n");//Nombre de la empresa

		$printer -> text("NIT: ".$infoTicket[0]->dni_office."\n");//Nit de la empresa

		$printer -> text("Dirección: ".urldecode($infoTicket[0]->address_office)."\n");//Dirección de la empresa

		$printer -> text("Teléfono: ".urldecode($infoTicket[0]->phone_office)."\n");//Teléfono de la empresa

		$printer -> text("Transacción N.".$infoTicket[0]->transaction_order."\n");//Número de factura

		$printer -> feed(1); //Alimentamos el papel 1 vez*/

		/*=============================================
		Traemos info del cliente y vendedor
		=============================================*/

		$url = "clients?linkTo=id_client&equalTo=".$infoTicket[0]->id_client_order."&select=name_client,surname_client";
		$getClient = CurlController::request($url,$method,$fields)->results[0];

		$printer -> text("Cliente: ".urldecode($getClient->name_client)." ".urldecode($getClient->surname_client)."\n");//Nombre del cliente

		$printer -> text("Vendedor: ".urldecode($_GET["name"])."\n");//Nombre del vendedor

		$printer -> feed(2); //Corremos el papel 2 saltos*/	

		/*=============================================
		Traemos info de los productos
		=============================================*/

		foreach ($infoTicket as $key => $value) {

			$url = "relations?rel=sales,products&type=sale,product&linkTo=id_sale&equalTo=".$value->id_sale."&select=title_product,subtotal_sale,qty_sale";
			$infoProduct = CurlController::request($url,$method,$fields)->results[0];

			$printer->setJustification(Printer::JUSTIFY_LEFT);

			$printer->text(urldecode($infoProduct->title_product)."\n");//Nombre del producto

			$printer->setJustification(Printer::JUSTIFY_RIGHT);

			$printer->text("$ ".number_format($infoProduct->subtotal_sale/$infoProduct->qty_sale,2)." Und x ".$infoProduct->qty_sale." = $ ".number_format($infoProduct->subtotal_sale,2)."\n");
		}

		$printer -> feed(2); //Corremos el papel 2 saltos*/	

		$printer->text("NETO: $ ".number_format($infoTicket[0]->subtotal_order,2)."\n"); //ahora va el neto	

		$printer->text("DESCUENTO: $ ".number_format($infoTicket[0]->discount_order,2)."\n"); //ahora va el descuento	

		$printer->text("IMPUESTO: $ ".number_format($infoTicket[0]->tax_order,2)."\n"); //ahora va el impuesto

		$printer->text("--------\n");

		$printer->text("TOTAL: $ ".number_format($infoTicket[0]->total_order,2)."\n"); //ahora va el total

		$printer -> feed(1); //Alimentamos el papel 1 vez*/	

		$printer -> setJustification(Printer::JUSTIFY_CENTER);

		$printer->text("Muchas gracias por su compra"); //Podemos poner también un pie de página

		$printer -> feed(3); //Alimentamos el papel 3 veces*/

		$printer->cut(); // Cortamos el papel. Si nuestra impresora no tiene soporte para ello, no generará ningún error
		$printer->pulse(); // Por medio de la impresora mandamos un pulso. Esto es útil cuando la tenemos conectada por ejemplo a un cajón
		$printer->close(); // Para imprimir realmente, tenemos que "cerrar" la conexión con la impresora. Recuerda incluir esto al final de todos los archivos

	}


}


