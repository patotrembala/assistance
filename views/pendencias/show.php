<?php
/**
 * Assistance - Detalhes da Pendência Interna (RF13 / RN11 / RN12)
 * @var array $pendencia Dados da pendência interna
 */
$pageTitle = htmlspecialchars($pendencia['titulo'] ?? 'Pendência') . ' - Assistance';
$currentRoute = 'pendencias';
$baseUrl = $baseUrl ?? '';
$currentUser = $currentUser ?? ($_SESSION['user'] ?? ['id' => 1, 'nome' => 'Técnico', 'perfil' => 'tecnico']);
$isAtrasada = !empty($pendencia['prazo_violado']);
$isConcluida = in_array($pendencia['status'] ?? '', ['Concluída', 'Cancelada']);

require __DIR__ . '/../layouts/header.php';
require __DIR__ . '/../layouts/sidebar.php';
?>

<main class="app-main">
  <?php require __DIR__ . '/../layouts/topbar.php'; ?>

  <div class="app-content pending-detail-view">
    <?php require __DIR__ . '/../layouts/flash.php'; ?>

    <div class="page-header record-detail-header">
      <div class="page-title-wrap">
        <span class="record-eyebrow">Pendência interna · #<?= (int)($pendencia['id'] ?? 0) ?></span>
        <div class="record-heading-row">
          <h1><?= htmlspecialchars($pendencia['titulo'] ?? 'Pendência sem título') ?></h1>
          <?= renderStatusBadge($pendencia['status'] ?? 'Pendente') ?>
          <?php if (!empty($pendencia['prioridade'])): ?>
            <span class="badge badge-prioridade-<?= strtolower($pendencia['prioridade']) ?>">
              Prioridade <?= ucfirst(htmlspecialchars($pendencia['prioridade'])) ?>
            </span>
          <?php endif; ?>
          <?php if ($isAtrasada): ?>
            <span class="badge-prazo-violado">Prazo violado</span>
          <?php endif; ?>
        </div>
        <p class="page-subtitle">Acompanhe o responsável, o prazo e todas as alterações desta atividade.</p>
      </div>

      <div class="page-actions">
        <a href="<?= $baseUrl ?>/pendencias" class="btn btn-outline">
          <span aria-hidden="true">←</span> Voltar
        </a>

        <?php if (!$isConcluida): ?>
          <form action="<?= $baseUrl ?>/pendencias/<?= (int)$pendencia['id'] ?>/concluir" method="POST" style="margin: 0;">
            <input type="hidden" name="_token" value="<?= htmlspecialchars($csrfToken) ?>">
            <button type="submit" class="btn btn-primary">
              <span aria-hidden="true">✓</span> Concluir tarefa
            </button>
          </form>
        <?php endif; ?>

        <a href="<?= $baseUrl ?>/pendencias/<?= (int)$pendencia['id'] ?>/editar" class="btn btn-secondary">
          <span aria-hidden="true">✎</span> Editar
        </a>

        <button
          type="button"
          class="btn btn-outline record-delete-button"
          data-modal-target="modalExclusao"
          data-record-id="<?= (int)$pendencia['id'] ?>"
          data-record-name="Pendência: <?= htmlspecialchars($pendencia['titulo'] ?? '') ?>"
          onclick="document.getElementById('formConfirmarExclusao').action='<?= $baseUrl ?>/pendencias/<?= (int)$pendencia['id'] ?>/excluir'"
        >
          <span aria-hidden="true">⌫</span> Excluir
        </button>
      </div>
    </div>

    <div class="record-main-grid">
      <section class="card record-card task-description-card">
          <div class="card-header">
            <div class="record-card-heading">
              <span class="record-card-icon" aria-hidden="true">≡</span>
              <div>
                <span class="record-card-kicker">Detalhes da atividade</span>
                <h2 class="card-title">Descrição da tarefa</h2>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="task-description-text">
                <?= !empty($pendencia['descricao']) ? htmlspecialchars($pendencia['descricao']) : '<em>Sem descrição detalhada registrada.</em>' ?>
            </div>
          </div>
      </section>

      <aside class="card record-card execution-summary-card">
          <div class="card-header">
            <div class="record-card-heading">
              <span class="record-card-icon" aria-hidden="true">✓</span>
              <div>
                <span class="record-card-kicker">Resumo operacional</span>
                <h2 class="card-title">Execução</h2>
              </div>
            </div>
          </div>
          <div class="card-body execution-list">
            <div class="execution-item">
              <span class="execution-item-icon" aria-hidden="true">R</span>
              <div>
                <span class="execution-label">Responsável</span>
                <strong><?= htmlspecialchars($pendencia['responsavel_nome'] ?? 'Não atribuído') ?></strong>
              </div>
            </div>

            <div class="execution-item">
              <span class="execution-item-icon" aria-hidden="true">!</span>
              <div>
                <span class="execution-label">Prioridade</span>
                <span class="badge badge-prioridade-<?= strtolower($pendencia['prioridade'] ?? 'media') ?>">
                  <?= ucfirst(htmlspecialchars($pendencia['prioridade'] ?? 'Média')) ?>
                </span>
              </div>
            </div>

            <div class="execution-item <?= $isAtrasada ? 'is-overdue' : '' ?>">
              <span class="execution-item-icon" aria-hidden="true">◷</span>
              <div>
                <span class="execution-label">Prazo limite</span>
                <strong><?= htmlspecialchars($pendencia['prazo_formatado'] ?? $pendencia['prazo'] ?? '-') ?></strong>
                <?php if ($isAtrasada): ?>
                  <span class="execution-warning">Atenção necessária</span>
                <?php endif; ?>
              </div>
            </div>

            <?php if (!empty($pendencia['concluido_em'])): ?>
              <div class="execution-item is-completed">
                <span class="execution-item-icon" aria-hidden="true">✓</span>
                <div>
                  <span class="execution-label">Concluída em</span>
                  <strong><?= htmlspecialchars($pendencia['concluido_em_formatada'] ?? $pendencia['concluido_em']) ?></strong>
                </div>
              </div>
            <?php endif; ?>
          </div>
      </aside>
    </div>

    <section class="card record-card history-card">
      <div class="card-header history-card-header">
        <div class="record-card-heading">
          <span class="record-card-icon" aria-hidden="true">↻</span>
          <div>
            <span class="record-card-kicker">Rastreabilidade</span>
            <h2 class="card-title">Histórico do atendimento</h2>
          </div>
        </div>
        <span class="history-count"><?= count($historicoAtendimento ?? []) ?> registro(s)</span>
      </div>
      <div class="card-body">
        <?php if (empty($historicoAtendimento)): ?>
          <div class="history-empty">
            <span aria-hidden="true">○</span>
            <p>Nenhuma alteração registrada até o momento.</p>
          </div>
        <?php else: ?>
          <ol class="record-timeline">
            <?php foreach ($historicoAtendimento as $historyItem): ?>
              <?php
                $historyDetails = json_decode((string)($historyItem['detalhes_json'] ?? ''), true);
                $historyDetails = is_array($historyDetails) ? $historyDetails : [];
                $historyAction = match ((string)($historyItem['acao'] ?? '')) {
                    'criar' => 'Pendência criada',
                    'atualizar' => 'Dados atualizados',
                    'concluir' => 'Pendência concluída',
                    default => ucfirst(str_replace('_', ' ', (string)($historyItem['acao'] ?? 'Alteração registrada'))),
                };
                $historyStatus = $historyDetails['status'] ?? null;
                if (is_string($historyStatus) && function_exists('opDisplay')) {
                    $historyStatus = opDisplay($historyStatus);
                }
              ?>
              <li class="timeline-event">
                <span class="timeline-dot" aria-hidden="true"></span>
                <div class="timeline-content">
                  <div class="timeline-main">
                    <strong><?= htmlspecialchars($historyAction) ?></strong>
                    <span>por <?= htmlspecialchars($historyItem['usuario_nome'] ?? 'Sistema') ?></span>
                  </div>
                  <time datetime="<?= htmlspecialchars($historyItem['criado_em'] ?? '') ?>">
                    <?= !empty($historyItem['criado_em']) ? date('d/m/Y · H:i', strtotime($historyItem['criado_em'])) : '-' ?>
                  </time>
                  <?php if ($historyStatus): ?>
                    <div class="timeline-status"><?= renderStatusBadge((string)$historyStatus) ?></div>
                  <?php endif; ?>
                </div>
              </li>
            <?php endforeach; ?>
          </ol>
        <?php endif; ?>
      </div>
    </section>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
