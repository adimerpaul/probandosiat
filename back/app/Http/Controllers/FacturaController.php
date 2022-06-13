<?php

namespace App\Http\Controllers;

use DOMDocument;
use Illuminate\Http\Request;
use Phar;
use PharData;
use SimpleXMLElement;

class FacturaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /**
         * @param nit NIT emisor
         * @param fh Fecha y Hora en formato yyyyMMddHHmmssSSS
         * @param sucursal
         * @param mod Modalidad
         * @param temision Tipo de Emision
         * @param cdf Codigo Documento Fiscal
         * @param tds Tipo Documento Sector
         * @param nf Numero de Factura
         * @param pos Punto de Venta
         * @return CUF Codigo Unico de Factura
         */
//        return "20190113163721242----".date('YmdHis000');
        $fh=date('YmdHis000');
        $cuf = new CUF();
        $codigo = $cuf->obtenerCUF(3102229014, $fh, 0, 2, 1, 1, 1, 1, 0);
//        return $codigo;
//        $xml = new DOMDocument();
//        $xml->load('./'.'facturaElectronicaCompraVenta'.'.xml');
//        if (!$xml->schemaValidate('./facturaElectronicaCompraVenta.xsd')) {
//            return "invalid";
//        }
//        else {
//            return "validated";
//        }
//        exit;
        $name="facturaComputarizadaCompraVenta";


        $xml = new SimpleXMLElement("<?xml version='1.0' encoding='UTF-8' standalone='yes'?><$name xsi:noNamespaceSchemaLocation='$name.xsd' xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance'></$name>");
        $cabecera=$xml->addChild('cabecera');
        $cabecera->addChild('nitEmisor', '3102229014');
        $cabecera->addChild('razonSocialEmisor', 'TANTACHUCO QUEVEDO CARLOS EDUARDO');
        $cabecera->addChild("municipio","Oruro");
        $cabecera->addChild("telefono","5261245");
        $cabecera->addChild("numeroFactura","1");
        $cabecera->addChild("cuf",$codigo);
        $cabecera->addChild("cufd","CQUFvQmRXS0RBNzUJGQjcwNThBQzY=Q3nDmmk4Sk9HV1VIwRDFDQzMxMTExQ");
        $cabecera->addChild("codigoSucursal","0");
        $cabecera->addChild("direccion","AV. JORGE LOPEZ #123");
        $child=$cabecera->addChild("codigoPuntoVenta","1");
//        $child->addAttribute("xsi:nil", "true", "http://www.w3.org/2001/XMLSchema-instance");
        $cabecera->addChild("fechaEmision",date('Y-m-d').'T'.date('H:i:s').'.000');
        $cabecera->addChild("nombreRazonSocial","Mi razon social");
        $cabecera->addChild("codigoTipoDocumentoIdentidad","1");
        $cabecera->addChild("numeroDocumento","51158899");
        $child=$cabecera->addChild("complemento","");
        $child->addAttribute("xsi:nil", "true", "http://www.w3.org/2001/XMLSchema-instance");
        $cabecera->addChild("codigoCliente","51158899");
        $cabecera->addChild("codigoMetodoPago","1");
        $child=$cabecera->addChild("numeroTarjeta","");
        $child->addAttribute("xsi:nil", "true", "http://www.w3.org/2001/XMLSchema-instance");
        $cabecera->addChild("montoTotal","100");
        $cabecera->addChild("montoTotalSujetoIva","100");
        $cabecera->addChild("codigoMoneda","1");
        $cabecera->addChild("tipoCambio","1");
        $cabecera->addChild("montoTotalMoneda","100");
        $child=$cabecera->addChild("montoGiftCard","");
        $child->addAttribute("xsi:nil", "true", "http://www.w3.org/2001/XMLSchema-instance");
        $cabecera->addChild("descuentoAdicional","1");
        $child=$cabecera->addChild("codigoExcepcion","");
        $child->addAttribute("xsi:nil", "true", "http://www.w3.org/2001/XMLSchema-instance");
        $child=$cabecera->addChild("cafc","");
        $child->addAttribute("xsi:nil", "true", "http://www.w3.org/2001/XMLSchema-instance");
        $cabecera->addChild("leyenda","Ley N° 453: Tienes derecho a recibir información sobre las características y contenidos de los servicios que utilices.");
        $cabecera->addChild("usuario","pperes");
        $cabecera->addChild("codigoDocumentoSector","1");
        $detalle=$xml->addChild('detalle');
        $detalle->addChild("actividadEconomica","841001");
        $detalle->addChild("codigoProductoSin","99100");
        $detalle->addChild("codigoProducto","1322");
        $detalle->addChild("descripcion","Formulario");
        $detalle->addChild("cantidad","1");
        $detalle->addChild("unidadMedida","58");
        $detalle->addChild("precioUnitario","100");
        $detalle->addChild("montoDescuento","0");
        $detalle->addChild("subTotal","100");
        $detalle->addChild("numeroSerie","124548");
        $detalle->addChild("numeroImei","545454");
        $dom = new DOMDocument('1.0');
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        $dom->loadXML($xml->asXML());

        $nameFile=time();
        $dom->save($nameFile.'.xml');



        $xml = new DOMDocument();
        $xml->load('./'.$nameFile.'.xml');
        if (!$xml->schemaValidate('./facturaComputarizadaCompraVenta.xsd')) {
            return "invalid";
        }
//        else {
//            return "validated";
//        }
//        exit;


//        $valXSD = new ValidacionXSD();
//        if(!$valXSD->validar($nameFile.'.xml','facturaElectronicaCompraVenta.xsd')){
////            var_dump( $valXSD->mostrarError());
//            return "a";
//            exit;
//        }



//        try
//        {
            $a = new PharData($nameFile.'.tar');

            // ADD FILES TO archive.tar FILE
            $a->addFile($nameFile.'.xml');
//            $a->addFile('index.php');

            // COMPRESS archive.tar FILE. COMPRESSED FILE WILL BE archive.tar.gz
            $a->compress(Phar::GZ);

            // NOTE THAT BOTH FILES WILL EXISTS. SO IF YOU WANT YOU CAN UNLINK archive.tar
            unlink($nameFile.'.tar');
//            unlink($nameFile.'.xml');
//        }
//        catch (Exception $e)
//        {
//            echo "Exception : " . $e;
//        }


//        $p = new PharData('sitemap.xml');
////        $p['myfile.txt'] = 'hi';
////        $p['myfile2.txt'] = 'hi';
//        $p1 = $p->compress(Phar::GZ); // copia a /ruta/a/mi.tar.gz



        $archivo=$this->getFileGzip($nameFile.".tar.gz");
//        return $archivo;
        $hash256 = hash('sha256', $archivo);
//        date_default_timezone_set('America/La_Paz');
        $fechaEnvio=date('Y-m-d').'T'.date('H:i:s').'.000';
//        return date("Y-m-d H:i:s");
        $wsdl = $request->url."?WSDL";
        $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJzdWIiOiJjaHVjbyIsImNvZGlnb1Npc3RlbWEiOiI3MjBDOTM5OEQxMDcwQ0QzNTRDNkFDNiIsIm5pdCI6Ikg0c0lBQUFBQUFBQUFETTJOREF5TXJJME1EUUJBQ2FPeHo4S0FBQUEiLCJpZCI6NjcxNzQsImV4cCI6MTY3MjQ0NDgwMCwiaWF0IjoxNjU0MjY0MzgxLCJuaXREZWxlZ2FkbyI6MzEwMjIyOTAxNCwic3Vic2lzdGVtYSI6IlNGRSJ9.7g39gdLKxE-MfQy5KfQnN8gkaRk7IwZkMqBH-wt3DOyN66MWa-aWmDkvmKhmsrsQUUfFgwVaZkxY2Irjmf-dYg";
        $opts = array(
            'http' => array(
                'header' => "apikey: TokenApi {$token}",
            )
        );
        $context = stream_context_create($opts);

        $client = new \SoapClient($wsdl,  [
            'stream_context' => $context,
            'cache_wsdl' => WSDL_CACHE_NONE,
            'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP | SOAP_COMPRESSION_DEFLATE,
            'trace' => 1,
            'use' => SOAP_LITERAL,
            'style' => SOAP_DOCUMENT,
        ]);
        $params = array(
            "SolicitudServicioRecepcionFactura" => [
                //        "codigoAmbiente" => 2,
                //        "codigoModalidad" =>2,
                //        "codigoPuntoVenta" => 1,
                //        "codigoSistema" => "7200230CE6C26990961956E",
                //        "codigoSucursal" => 0,
                //        "cuis" => "B08C2279",
                //        "nit" => 1010413026,
                "codigoAmbiente" => 2,
                "codigoDocumentoSector"=>1,
                "codigoEmision"=>1,
                "codigoModalidad"=>2,
                "codigoPuntoVenta" =>1,
                "codigoSistema" => "720D1CC31111ABFB7058AC6",
                "codigoSucursal" => 0,
                "cufd"=>"CQUFvQmRXS0RBNzUJGQjcwNThBQzY=Q3nDmmk4Sk9HV1VIwRDFDQzMxMTExQ",
                "cuis" => "709890A8",
                "nit" => "3102229014",
                "tipoFacturaDocumento"=>1,
                "archivo" => $archivo,
                "fechaEnvio" => $fechaEnvio,
                "hashArchivo" => $hash256,
            ]
        );

        if(!is_null($client)) {
            $result = $client->recepcionFactura($params);
            $data = $result->RespuestaServicioFacturacion;
            return $data;
            //            print_r($data);
            //            return $data;
        }
        else {
            echo  "error";
        }
    }
    private function getFileGzip($fileName)
    {
        $fileName = $fileName;

        $handle = fopen($fileName, "rb");
        $contents = fread($handle, filesize($fileName));
        fclose($handle);

        return $contents;
//        $fileName = "../api/". $this->carpetaBase ."/" . $carpeta . "/" . $fileName;
//
//        $handle = fopen($fileName, "rb");
//        $contents = fread($handle, filesize($fileName));
//        fclose($handle);

//        return $contents;
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
class CUF {

    /**
     * @param nit NIT emisor
     * @param fh Fecha y Hora en formato yyyyMMddHHmmssSSS
     * @param sucursal
     * @param mod Modalidad
     * @param temision Tipo de Emision
     * @param cdf Codigo Documento Fiscal
     * @param tds Tipo Documento Sector
     * @param nf Numero de Factura
     * @param pos Punto de Venta
     * @return CUF Codigo Unico de Factura
     */
    public function obtenerCUF(string $nit, string $fh, string $sucursal, string $mod, string $temision, string $cdf, string $tds, string $nf, string $pos) {
        $cadena = "";

        /**
         * PASO 1 y PASO2 Completa con ceros cada campo y concatena todo en una
         * sola cadena
         */
        $cadena .= str_pad($nit, 13, '0', STR_PAD_LEFT);
        $cadena .= $fh;
        $cadena .= str_pad($sucursal, 4, '0', STR_PAD_LEFT);
        $cadena .= $mod;
        $cadena .= $temision;
        $cadena .= $cdf;
        $cadena .= str_pad($tds, 2, '0', STR_PAD_LEFT);
        $cadena .= str_pad($nf, 8, '0', STR_PAD_LEFT);
        $cadena .= str_pad($pos, 4, '0', STR_PAD_LEFT);

        /**
         * Paso 3 Obtiene modulo 11 y adjunta resultado a la cadena
         */
        $cadena .= $this->calculaDigitoMod11($cadena, 1, 9, false);

        /**
         * paso 4 Aplica base16
         */
        return $this->base16($cadena);
    }

    /**
     * @see https://impuestos.gob.bo/ ALGORITMO BASE 11 – MÓDULO 11
     * Original codigo java
     */
    public function calculaDigitoMod11(string $dado, int $numDig, int $limMult, bool $x10): string {
        if (!$x10) {
            $numDig = 1;
        }
        for ($n = 1; $n <= $numDig; $n++) {
            $soma = 0;
            $mult = 2;
            for ($i = strlen($dado) - 1; $i >= 0; $i--) {
                $soma += ($mult * substr($dado, $i, 1));
                if (++$mult > $limMult) {
                    $mult = 2;
                }
            }
            if ($x10) {
                $dig = (($soma * 10) % 11) % 10;
            } else {
                $dig = $soma % 11;
            }

            if ($dig == 10) {
                $dado .= "1";
            }
            if ($dig == 11) {
                $dado .= "0";
            }
            if ($dig < 10) {
                $dado .= $dig;
            }
        }
        return substr($dado, strlen($dado) - $numDig, $numDig);
    }

    /**
     * @param string $number cadena
     * @param bool $touppercase TRUE: resultado en mayusculas
     *                          FALSE: Resultado en minusculas
     * @return string Numero hexadecimal
     */
    public function base16(string $number, bool $touppercase = true): string {
        $hexvalues = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
        $hexval = '';
        while ($number != '0') {
            $hexval = $hexvalues[bcmod($number, '16')] . $hexval;
            $number = bcdiv($number, '16', 0);
        }
        return ($touppercase) ? strtoupper($hexval) : $hexval;
    }

}
