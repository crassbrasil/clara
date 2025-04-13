
<?php
$chave_publica = 'pk_live_FUF01RbBgi0V4BXctjUyLEcqFIDs3d';
$chave_secreta = 'sk_live_n2DcGrRa4ZpxPmtf3QAHszDhCeT2iYj6J7rs6LwawK';
$endpoint = 'https://api.lunacheckout.com/stores/0195c2e7-2e42-715b-a58b-b8772879a089/gateways/183/postback';

$valor = $_GET['valor'] ?? 30; // Valor da doação, padrão R$ 30
$descricao = 'Doação para nossa causa';

// Enviar para a API da Nexus Tech e gerar o QR Code
$data = [
    'valor' => $valor,
    'descricao' => $descricao,
    'chave_publica' => $chave_publica,
    'chave_secreta' => $chave_secreta
];

$options = [
    'http' => [
        'header' => "Content-type: application/x-www-form-urlencoded",
        'method' => 'POST',
        'content' => http_build_query($data),
    ]
];

$context = stream_context_create($options);
$response = file_get_contents($endpoint, false, $context);
$response_data = json_decode($response, true);

// Retornar o QR Code gerado
if (isset($response_data['qr_code'])) {
    echo json_encode(['qr_code' => $response_data['qr_code']]);
} else {
    echo json_encode(['error' => 'Não foi possível gerar o QR Code.']);
}
?>
