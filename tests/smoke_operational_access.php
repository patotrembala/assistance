<?php
declare(strict_types=1);

// Executa a regra real de autorização sem banco, sessão HTTP ou dados de produção.
$source = (string)file_get_contents(__DIR__ . '/../operations.php');
if (!preg_match('/function opAccess\(.*?(?=function opRows\()/s', $source, $match)) {
    throw new RuntimeException('Não foi possível localizar a regra operacional.');
}
function opFail(int $status, string $message): never
{
    throw new RuntimeException($message, $status);
}
eval($match[0]);

$currentUser = ['id' => 7, 'perfil' => 'tecnico'];
$cases = [
    ['Administrador gerencia outra OS', true, 'ordens', ['tecnico_id' => 9], true, true],
    ['Técnico consulta sua OS', false, 'ordens', ['tecnico_id' => 7], false, true],
    ['Técnico altera sua OS', false, 'ordens', ['tecnico_id' => 7], true, true],
    ['Técnico não consulta OS alheia', false, 'ordens', ['tecnico_id' => 9], false, false],
    ['Técnico não altera OS alheia', false, 'ordens', ['tecnico_id' => 9], true, false],
    ['Técnico consulta OS disponível', false, 'ordens', ['tecnico_id' => null], false, true],
    ['Técnico não altera OS sem assumir', false, 'ordens', ['tecnico_id' => null], true, false],
    ['Técnico altera seu chamado', false, 'chamados', ['tecnico_id' => 7], true, true],
    ['Técnico não altera chamado alheio', false, 'chamados', ['tecnico_id' => 9], true, false],
    ['Técnico altera sua pendência', false, 'pendencias', ['responsavel_id' => 7], true, true],
    ['Técnico não altera pendência alheia', false, 'pendencias', ['responsavel_id' => 9], true, false],
    ['Técnico não gerencia usuários', false, 'usuarios', ['tecnico_id' => 7], true, false],
    ['Técnico não gerencia catálogo', false, 'tipos-servico', ['tecnico_id' => 7], true, false],
];
foreach ($cases as [$label, $admin, $module, $record, $write, $expected]) {
    $isAdmin = $admin;
    $allowed = true;
    try {
        opAccess($module, $record, $write);
    } catch (RuntimeException $e) {
        if ($e->getCode() !== 403) throw $e;
        $allowed = false;
    }
    if ($allowed !== $expected) throw new RuntimeException('Falha: ' . $label);
}
echo 'Permissões operacionais: ' . count($cases) . " cenários OK\n";
