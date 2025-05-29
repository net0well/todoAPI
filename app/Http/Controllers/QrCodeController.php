<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;

class QrCodeController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/QRCode",
     *     summary="Gera um QR Code a partir de um texto e retorna como SVG",
     *     tags={"QRCode"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"data"},
     *             @OA\Property(property="data", type="string", example="Texto para o QR Code")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="QR Code gerado com sucesso",
     *         @OA\MediaType(
     *             mediaType="image/svg+xml"
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Dados inválidos"
     *     )
     * )
     */
    public function generateQrCode(Request $request)
    {
        $request->validate([
            'data' => 'required|string',
        ]);

        $data = $request->input('data');

        $qrCode = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')->size(300)->generate($data);
        return response($qrCode, 200)->header('Content-Type', 'image/svg+xml');
    }

    /**
     * @OA\Post(
     *     path="/api/QRCodeImg",
     *     summary="Gera um QR Code a partir de um texto e retorna como Imagem PNG",
     *     tags={"QRCode"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"data"},
     *             @OA\Property(property="data", type="string", example="Texto para o QR Code")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="QR Code gerado com sucesso",
     *         @OA\MediaType(
     *             mediaType="image/png"
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Dados inválidos"
     *     )
     * )
     */
    public function generateQrCodeImage(Request $request)
    {
        $request->validate([
        'data' => 'required|string',
    ]);

    $result = Builder::create()
        ->writer(new PngWriter())
        ->data($request->input('data'))
        ->size(300)
        ->margin(10)
        ->build();

    return response($result->getString(), 200)
        ->header('Content-Type', 'image/png');
    }
}
