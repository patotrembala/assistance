<?php
// A voz personalizada foi removida; este endpoint não chama provedores externos.
if (!isset($currentUser, $pdo, $requestUri)) { http_response_code(404); exit; }
if (!in_array($requestUri, ['/assistance-ia/voz', '/ethan-ia/voz'], true)) return;
header('Cache-Control: no-store, private');
header('Content-Type: application/json; charset=utf-8');
http_response_code(410);
echo json_encode(['error' => 'A voz personalizada foi removida. Use a leitura do navegador.'], JSON_UNESCAPED_UNICODE);
exit;
