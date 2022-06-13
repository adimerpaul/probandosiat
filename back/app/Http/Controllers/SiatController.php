<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SiatController extends Controller
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
        for ($i = 1; $i <= 150; $i++) {
    //            echo $i;
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
                "SolicitudCufd" => [
    //        "codigoAmbiente" => 2,
    //        "codigoModalidad" =>2,
    //        "codigoPuntoVenta" => 1,
    //        "codigoSistema" => "7200230CE6C26990961956E",
    //        "codigoSucursal" => 0,
    //        "cuis" => "B08C2279",
    //        "nit" => 1010413026,
                    "codigoAmbiente" => $request->codigoAmbiente,
                    "codigoModalidad"=>$request->codigoModalidad,
                    "codigoPuntoVenta" =>$request->codigoPuntoVenta,
                    "codigoSistema" => $request->codigoSistema,
                    "codigoSucursal" => $request->codigoSucursal,
                    "cuis" => $request->cuis,
                    "nit" => $request->nit,
                ]
            );

            if(!is_null($client)) {
                $result = $client->cufd($params);
    //            $data = $result->RespuestaListaActividadesDocumentoSector;
    //            print_r($data);
    //            return $data;
            }
            else {
                echo  "error";
            }
        }
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
