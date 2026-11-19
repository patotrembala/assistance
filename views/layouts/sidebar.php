<?php
/**
 * Assistance - Sidebar Navigation
 * @var string $currentRoute Rota ativa para marcar o item selecionado
 * @var array $currentUser Dados do usuário logado na sessão
 */
$currentRoute = $currentRoute ?? 'dashboard';
$currentUser = $currentUser ?? ($_SESSION['user'] ?? ['nome' => 'Usuário', 'perfil' => 'admin']);
$isAdmin = ($currentUser['perfil'] ?? '') === 'admin';
$baseUrl = $baseUrl ?? '';
?>
<aside class="app-sidebar">
  <div class="sidebar-header">
    <div class="brand-title">
      <span class="assistance-brand-mark" aria-hidden="true">A<span></span></span>
      Assistance
      <span class="brand-badge"><?= $isAdmin ? 'Admin' : 'Técnico' ?></span>
    </div>
    <button type="button" class="sidebar-close-btn" id="sidebarCloseBtn" aria-label="Fechar menu">✕</button>
  </div>

  <nav class="sidebar-nav" aria-label="Menu principal">
    <div class="nav-section-title">Operação</div>
    <ul class="nav-list">
      <li class="nav-item">
        <a href="<?= $baseUrl ?>/dashboard" class="nav-link <?= $currentRoute === 'dashboard' ? 'active' : '' ?>">
          <span class="icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/></svg></span>
          <span><?= $isAdmin ? 'Dashboard' : 'Meu painel' ?></span>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?= $baseUrl ?>/ordens" class="nav-link <?= str_starts_with($currentRoute, 'ordens') ? 'active' : '' ?>">
          <span class="icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M14.7 6.3a5 5 0 0 0-6.4 6.4L3 18l3 3 5.3-5.3a5 5 0 0 0 6.4-6.4L14 13l-3-3z"/></svg></span>
          <span>Ordens de Serviço</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?= $baseUrl ?>/chamados" class="nav-link <?= str_starts_with($currentRoute, 'chamados') ? 'active' : '' ?>">
          <span class="icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.5 8.5 0 0 1-8.5 8.5H4l-2 2V11.5a9.5 9.5 0 0 1 19 0Z"/><path d="M7 10h10M7 14h6"/></svg></span>
          <span><?= $isAdmin ? 'Chamados Online' : 'Meus chamados' ?></span>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?= $baseUrl ?>/pendencias" class="nav-link <?= str_starts_with($currentRoute, 'pendencias') ? 'active' : '' ?>">
          <span class="icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="4" width="14" height="17" rx="2"/><rect x="9" y="2" width="6" height="4" rx="1"/><path d="M9 11h6M9 16h4"/></svg></span>
          <span><?= $isAdmin ? 'Pendências Internas' : 'Minhas pendências' ?></span>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?= $baseUrl ?>/clientes" class="nav-link <?= str_starts_with($currentRoute, 'clientes') ? 'active' : '' ?>">
          <span class="icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="17" rx="2"/><path d="M8 9h2m4 0h2M8 13h2m4 0h2M10 21v-4h4v4"/></svg></span>
          <span><?= $isAdmin ? 'Clientes' : 'Clientes atendidos' ?></span>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?= $baseUrl ?>/assistance-ia" class="nav-link <?= $currentRoute === 'assistance-ia' ? 'active' : '' ?>">
          <span class="icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="m12 3 2.5 6.5L21 12l-6.5 2.5L12 21l-2.5-6.5L3 12l6.5-2.5Z"/></svg></span>
          <span>Assistente de IA</span>
        </a>
      </li>
    </ul>

    <?php if ($isAdmin): ?>
    <div class="nav-section-title">Administração</div>
    <ul class="nav-list">
      <li class="nav-item">
        <a href="<?= $baseUrl ?>/tipos-servico" class="nav-link <?= str_starts_with($currentRoute, 'tipos-servico') ? 'active' : '' ?>">
          <span class="icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12V4h8l10 10-7 7Z"/><circle cx="7.5" cy="8" r="1"/></svg></span>
          <span>Tipos de Serviço</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?= $baseUrl ?>/usuarios" class="nav-link <?= str_starts_with($currentRoute, 'usuarios') ? 'active' : '' ?>">
          <span class="icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="7" r="3"/><path d="M3 21v-3a6 6 0 0 1 12 0v3M16 4a3 3 0 0 1 0 6m2 5a5 5 0 0 1 3 5"/></svg></span>
          <span>Técnicos & Usuários</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?= $baseUrl ?>/recuperacoes-senha" class="nav-link <?= str_starts_with($currentRoute, 'recuperacoes-senha') ? 'active' : '' ?>">
          <span class="icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="10" width="16" height="11" rx="2"/><path d="M8 10V6a4 4 0 0 1 8 0v4m-4 5v2"/></svg></span>
          <span>Recuperações de Senha<?= !empty($pendingPasswordResetCount) ? ' (' . (int)$pendingPasswordResetCount . ')' : '' ?></span>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?= $baseUrl ?>/auditoria" class="nav-link <?= $currentRoute === 'auditoria' ? 'active' : '' ?>">
          <span class="icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M6 3h12v18l-3-2-3 2-3-2-3 2Z"/><path d="M9 7h6M9 11h6M9 15h3"/></svg></span>
          <span>Auditoria</span>
        </a>
      </li>
    </ul>
    <?php endif; ?>
  </nav>

  <div class="sidebar-footer">
    <div class="sidebar-footer-name"><span class="sidebar-status-dot"></span>Assistance <span class="sidebar-version">v1.0</span></div>
    <div style="font-size: 11px; margin-top: 4px; color: var(--color-slate-500);">Uso interno corporativo</div>
  </div>
</aside>

<style>
.app-sidebar{background:linear-gradient(165deg,#111c30 0%,#0c1424 68%);border-right:1px solid #223047;color:#c0ccde;box-shadow:6px 0 24px rgba(8,15,28,.05);font-family:Inter,ui-sans-serif,system-ui,-apple-system,"Segoe UI",sans-serif}
.app-sidebar .sidebar-header{min-height:88px;padding:24px 18px;border-bottom:1px solid rgba(148,163,184,.12);display:flex;align-items:center}
.app-sidebar .brand-title{display:flex;align-items:center;gap:9px;font-size:15px;font-weight:650;letter-spacing:-.35px;color:#f1f5fb;white-space:nowrap}
.assistance-brand-mark{position:relative;display:inline-flex;align-items:center;justify-content:center;flex:0 0 32px;width:32px;height:32px;border:1px solid #538bff;border-radius:10px;background:linear-gradient(140deg,#3979f7,#2150be);color:white;font-size:18px;font-weight:700;box-shadow:0 4px 14px #1260ee25}
.assistance-brand-mark>span{position:absolute;right:-3px;bottom:-3px;width:9px;height:9px;border:2px solid #111c30;border-radius:50%;background:#47d7b0}
.app-sidebar .brand-badge{padding:3px 5px;border:1px solid #3b4b65;border-radius:5px;background:#1e2b42;color:#a9bddc;font-size:9px;font-weight:650;letter-spacing:.55px;line-height:1.3;text-transform:uppercase;margin:0}
.app-sidebar .sidebar-nav{padding:22px 12px;overflow-y:auto;scrollbar-width:thin;scrollbar-color:#34435c transparent}
.app-sidebar .nav-section-title{padding:0 12px;margin:0 0 12px;color:#7487a4;font-size:10px;font-weight:650;letter-spacing:1.5px;text-transform:uppercase}
.app-sidebar .nav-list{display:flex;flex-direction:column;gap:5px;margin:0 0 30px;padding:0;list-style:none}
.app-sidebar .nav-list:last-child{margin-bottom:0}
.app-sidebar .nav-link{position:relative;display:flex;align-items:center;gap:12px;min-height:43px;padding:11px 12px;border:1px solid transparent;border-radius:9px;color:#adbbd0;font-size:12px;font-weight:500;line-height:1.5;text-decoration:none;transition:background .16s,color .16s,border-color .16s}
.app-sidebar .nav-link .icon{display:inline-flex;align-items:center;justify-content:center;flex:0 0 18px;width:18px;height:18px;margin:0;color:#7f93b0;font-size:0}
.app-sidebar .nav-link .icon svg{display:block;width:18px;height:18px}
.app-sidebar .nav-link:hover{background:#1a2941;color:#f1f5fb}
.app-sidebar .nav-link:hover .icon{color:#c6d8f4}
.app-sidebar .nav-link.active{background:linear-gradient(100deg,#203e72,#1a3054);border-color:#315184;color:#f1f6ff;box-shadow:0 3px 10px #03081520;font-weight:600}
.app-sidebar .nav-link.active:before{content:"";position:absolute;left:-1px;top:12px;bottom:12px;width:3px;border-radius:4px;background:#75a9ff}
.app-sidebar .nav-link.active .icon{color:#8ebaff}
.app-sidebar .nav-link:focus-visible{outline:2px solid #8ebaff;outline-offset:2px}
.app-sidebar .sidebar-footer{padding:20px 24px;border-top:1px solid rgba(148,163,184,.12);color:#8192ad;font-size:11px;background:rgba(4,10,20,.15)}
.sidebar-footer-name{display:flex;align-items:center;gap:7px;color:#aebed4;font-size:11px;font-weight:500}
.sidebar-status-dot{width:6px;height:6px;border-radius:50%;background:#49bba3;box-shadow:0 0 8px #49bba330}
.sidebar-version{margin-left:auto;color:#697d9a;font-size:10px}
.app-sidebar .sidebar-footer>div:last-child{padding-left:13px;color:#697d9a!important;font-size:10px!important;margin-top:6px!important}
@media(prefers-reduced-motion:reduce){.app-sidebar .nav-link{transition:none}}
</style>
