<?php
$pageTitle = 'Conversa com Pajezinho - Assistance';
$currentRoute = 'ethan-ia';
$baseUrl = $baseUrl ?? '';
$aiConfigured = $aiConfigured ?? false;
$aiUsesChatGptPlan = $aiUsesChatGptPlan ?? false;
$aiError = $aiError ?? null;
$chatHistory = $chatHistory ?? [];
$draftQuestion = $draftQuestion ?? '';
$hasConversation = count($chatHistory) > 0;
$isQuotaNotice = is_string($aiError) && str_contains($aiError, 'créditos de IA');

require __DIR__ . '/../layouts/header.php';
require __DIR__ . '/../layouts/sidebar.php';
?>

<main class="app-main">
  <?php require __DIR__ . '/../layouts/topbar.php'; ?>

  <div class="app-content ai-workspace-content">
    <?php require __DIR__ . '/../layouts/flash.php'; ?>

    <div class="ai-chat-shell">
      <header class="ai-chat-topbar">
        <div class="ai-chat-identity">
          <div class="ai-avatar" aria-hidden="true">P</div>
          <div>
            <div class="ai-chat-title-row">
              <h1>Pajezinho</h1>
              <span class="ai-online-dot" aria-hidden="true"></span>
              <span class="ai-online-label"><?= $aiConfigured ? 'Disponível' : 'Indisponível' ?></span>
            </div>
            <p>Assistente de diagnóstico técnico</p>
            <?php if ($aiUsesChatGptPlan): ?>
              <span class="ai-plan-badge">Conectado ao seu ChatGPT</span>
            <?php endif; ?>
          </div>
        </div>

        <form method="POST" action="<?= $baseUrl ?>/assistance-ia/chat/limpar">
          <input type="hidden" name="_token" value="<?= htmlspecialchars($csrfToken) ?>">
          <button type="submit" class="btn btn-outline btn-sm ai-new-ticket">
            <span aria-hidden="true">＋</span> Novo chamado
          </button>
        </form>
      </header>


      
      <?php if (!$aiConfigured): ?>
        <div class="alert alert-info ai-chat-alert">
          <span>A chave privada da IA ainda não foi reconhecida neste ambiente.</span>
        </div>
      <?php endif; ?>

      <?php if ($aiError): ?>
        <div class="<?= $isQuotaNotice ? 'ai-service-note' : 'alert alert-danger ai-chat-alert' ?>">
          <?php if ($isQuotaNotice): ?><span class="ai-service-note-icon" aria-hidden="true">i</span><?php endif; ?>
          <span><?= htmlspecialchars($aiError) ?></span>
        </div>
      <?php endif; ?>

      <section class="ai-conversation" data-ai-conversation aria-live="polite" aria-label="Conversa com o Pajezinho">
        <?php if (!$hasConversation): ?>
          <div class="ai-chat-welcome">
            <div class="ai-welcome-mark" aria-hidden="true">P</div>
            <span class="ai-welcome-eyebrow">NOVO CHAMADO ASSISTIDO</span>
            <h2>O que está acontecendo?</h2>
            <p>Descreva o problema como se estivesse conversando com outro técnico. Eu farei perguntas, sugerirei testes e ajudarei a registrar a solução.</p>

            <div class="ai-prompt-suggestions" aria-label="Exemplos de chamados">
              <button type="button" data-ai-prompt="O computador liga, mas não apresenta imagem no monitor.">Computador sem vídeo</button>
              <button type="button" data-ai-prompt="O usuário está conectado ao Wi-Fi, mas não consegue acessar a internet.">Sem acesso à internet</button>
              <button type="button" data-ai-prompt="A impressora aparece como offline e não imprime os documentos enviados.">Impressora offline</button>
            </div>
          </div>
        <?php else: ?>
          <div class="ai-conversation-start"><span>Chamado iniciado agora</span></div>
          <?php foreach ($chatHistory as $messageIndex => $message): ?>
            <?php $isAssistant = ($message['role'] ?? '') === 'assistant'; ?>
            <article class="ai-chat-message <?= $isAssistant ? 'from-ethan' : 'from-technician' ?>">
              <?php if ($isAssistant): ?><div class="ai-message-avatar" aria-hidden="true">P</div><?php endif; ?>
              <div class="ai-message-content">
                <div class="ai-message-meta"><?= $isAssistant ? 'Pajezinho' : 'Você' ?></div>
                <div class="ai-message-bubble"><?= nl2br(htmlspecialchars((string)($message['content'] ?? ''))) ?></div>

                <?php if ($isAssistant): ?><div class="ai-voice-controls"><button type="button" class="ai-voice-button" data-paje-voice hidden aria-pressed="false">Ouvir resposta</button><span class="sr-only" data-voice-status role="status" aria-live="polite"></span></div><?php endif; ?>

                
              </div>
            </article>
          <?php endforeach; ?>
        <?php endif; ?>
      </section>

      <?php if ($hasConversation): ?><div class="ai-draft-action" style="padding:12px 22px;border-top:1px solid var(--color-slate-200)"><form method="POST" action="/assistance-ia/rascunho"><input type="hidden" name="_token" value="<?= htmlspecialchars($csrfToken) ?>"><button class="btn btn-outline btn-sm" type="submit">Preparar rascunho de ordem de serviço</button><p class="form-text">Você revisa cliente, equipamento e sugestões antes de salvar. Nenhum atendimento é criado automaticamente.</p></form></div><?php endif; ?><footer class="ai-composer-wrap">
        <form method="POST" action="<?= $baseUrl ?>/assistance-ia/perguntar" class="ai-composer" data-ai-chat-form>
          <input type="hidden" name="_token" value="<?= htmlspecialchars($csrfToken) ?>">
          <label for="pergunta" class="sr-only">Mensagem para o Pajezinho</label>
          <textarea id="pergunta" name="pergunta" maxlength="3000" required <?= !$aiConfigured ? 'disabled' : '' ?> placeholder="Descreva o problema, os sintomas e o que você já tentou..." rows="1"><?= htmlspecialchars($draftQuestion) ?></textarea>
          <button type="submit" class="ai-send-button" <?= !$aiConfigured ? 'disabled' : '' ?> aria-label="Enviar mensagem">
            <span>Enviar</span><span aria-hidden="true">➜</span>
          </button>
        </form>
        <p class="ai-composer-hint"><span class="ai-keyboard-hint">Enter para enviar · Shift + Enter para quebrar linha · </span>Não informe senhas ou chaves de acesso.</p>
      </footer>
    </div>
  </div>

<style>
.ai-workspace-content .ai-chat-shell{display:flex;flex-direction:column;min-height:calc(100dvh - 112px)}
.ai-workspace-content .ai-chat-topbar{flex-shrink:0}
.ai-workspace-content .ai-conversation{flex:1 0 auto;min-height:0}
.ai-workspace-content .ai-composer-wrap{flex-shrink:0;margin-top:auto}
.ai-workspace-content .ai-draft-action{flex-shrink:0}
@media(max-width:600px){.ai-workspace-content .ai-chat-shell{min-height:calc(100dvh - 92px)}}
.ai-voice-controls{margin-top:9px}.ai-voice-button{min-height:40px;padding:8px 13px;border:1px solid #b8cce8;border-radius:10px;background:transparent;color:inherit;font:600 12px Arial,sans-serif;cursor:pointer}.ai-voice-button:hover,.ai-voice-button[aria-pressed="true"]{background:rgba(37,99,235,.12)}.ai-voice-button:focus-visible{outline:2px solid #3b82f6;outline-offset:3px}.ai-voice-button[hidden]{display:none}

.paje-talk{flex:0 0 auto;margin:14px 20px;padding:15px 17px;border:1px solid #bed5fa;border-radius:15px;background:rgba(37,99,235,.06)}.paje-talk-top{display:flex;align-items:center;justify-content:space-between;gap:14px}.paje-talk strong{font-size:14px}.paje-talk-top p{margin:5px 0 0;font-size:12px;line-height:1.5;color:var(--color-slate-500)}.paje-talk-actions{display:flex;gap:8px;flex-shrink:0}.paje-talk button{min-height:42px;border-radius:10px;padding:9px 14px;font:600 13px Arial,sans-serif;cursor:pointer}.paje-talk-start{background:#155de1;border:1px solid #155de1;color:white}.paje-talk-start:disabled{opacity:.6;cursor:default}.paje-talk-end{background:transparent;color:inherit;border:1px solid #e59d9d}.paje-talk button[hidden],.paje-talk audio[hidden]{display:none}.paje-talk-state{display:flex;align-items:center;gap:9px;margin-top:13px;font-size:12px;line-height:1.5}.paje-talk-dot{width:8px;height:8px;border-radius:50%;background:#889ab4;flex:0 0 8px}.paje-talk[data-state="listening"] .paje-talk-dot{background:#16a34a;box-shadow:0 0 0 4px rgba(22,163,74,.14)}.paje-talk[data-state="thinking"] .paje-talk-dot{background:#2563eb;animation:paje-pulse 1s infinite}.paje-talk[data-state="speaking"] .paje-talk-dot{background:#9333ea}.paje-talk-heard{font-size:12px;line-height:1.5;margin:8px 0 0;overflow-wrap:anywhere}.paje-talk-heard:empty{display:none}.paje-talk-info{font-size:11px;line-height:1.6;margin-top:10px;color:var(--color-slate-500)}.paje-talk-info summary{cursor:pointer}.paje-talk-info p{margin:8px 0 0}.ai-voice-controls{display:flex;flex-wrap:wrap;gap:8px;align-items:center}.ai-voice-controls p,.ai-voice-controls audio,.ai-voice-controls [data-fish-status]{flex-basis:100%}@keyframes paje-pulse{50%{opacity:.3}}@media(prefers-reduced-motion:reduce){.paje-talk-dot{animation:none!important}}@media(max-width:600px){.paje-talk{margin:10px;padding:12px}.paje-talk-top{align-items:flex-start;flex-direction:column;gap:10px}.paje-talk-actions{width:100%}.paje-talk-start{flex:1}.paje-talk-state{margin-top:10px}}

/* Painel compacto de conversa, sem player nativo. */
.ai-chat-shell .paje-talk{margin:12px 18px;padding:13px 14px;border:1px solid rgba(117,147,190,.24);border-radius:14px;background:rgba(59,130,246,.045)}.ai-chat-shell .paje-talk-top{flex-direction:row;align-items:center;gap:10px}.paje-talk-identity{display:flex;align-items:center;gap:10px;min-width:0}.paje-talk-symbol{display:flex;align-items:center;justify-content:center;width:35px;height:35px;border-radius:11px;color:#4387fa;background:rgba(59,130,246,.13);flex:0 0 35px}.ai-chat-shell .paje-talk strong{font-size:13px;line-height:1.4}.ai-chat-shell .paje-talk-top p{font-size:11px;margin:2px 0 0}.ai-chat-shell .paje-talk-actions{width:auto;flex:0 0 auto}.ai-chat-shell .paje-talk button{font-size:12px;min-height:40px;padding:8px 12px;white-space:nowrap}.ai-chat-shell .paje-talk-end{color:#e77d7d;border-color:rgba(231,125,125,.4);background:rgba(231,125,125,.07)}.ai-chat-shell .paje-talk-state{margin-top:11px;font-size:12px}.paje-talk-heard{opacity:.7;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}.ai-chat-shell .paje-talk-info{margin-top:8px;font-size:10px;opacity:.7}.ai-chat-shell.paje-call-active .ai-draft-action,.ai-chat-shell.paje-call-active .ai-composer-wrap,.ai-chat-shell.paje-call-active .ai-voice-controls{display:none!important}.ai-chat-shell.paje-call-active .paje-talk-symbol{box-shadow:0 0 0 3px rgba(59,130,246,.08)}.ai-chat-shell.paje-call-active .ai-conversation{flex:1 1 0!important;min-height:0!important;overflow:auto!important}.ai-chat-shell.paje-call-active .ai-conversation:not(:has(.ai-chat-message)){visibility:hidden}.ai-chat-shell.paje-call-active .paje-talk-info{display:none}.ai-chat-shell.paje-call-active .paje-talk-top p{display:none}.ai-chat-shell.paje-call-active .paje-talk-state{font-weight:500}.paje-talk[data-state="speaking"] .paje-talk-symbol{color:#a78bfa;background:rgba(139,92,246,.12)}
@media(max-width:600px){.ai-chat-shell .paje-talk{margin:10px;padding:12px}.ai-chat-shell .paje-talk-symbol{width:30px;height:30px;flex-basis:30px;border-radius:9px}.paje-talk-identity{gap:8px}.ai-chat-shell .paje-talk strong{font-size:12px}.ai-chat-shell .paje-talk button{font-size:11px;padding:8px 10px;min-height:40px}.ai-chat-shell .ai-draft-action{padding:9px 12px!important}.ai-chat-shell .ai-draft-action .form-text{display:none}.ai-chat-shell .ai-draft-action .btn{min-height:36px!important;font-size:11px!important}.ai-chat-shell .paje-talk-heard{font-size:11px}.ai-chat-shell.paje-call-active .paje-talk{margin-bottom:4px}}
</style>








<script>
(function(){
 var active=null,run=0;
 function stop(){run++;if(window.speechSynthesis)window.speechSynthesis.cancel();if(active){active.textContent='Ouvir resposta';active.setAttribute('aria-pressed','false');active=null;}}
 function show(){if('speechSynthesis' in window && 'SpeechSynthesisUtterance' in window)document.querySelectorAll('[data-paje-voice]').forEach(function(b){b.hidden=false;});}
 document.addEventListener('click',function(e){var b=e.target.closest('[data-paje-voice]');if(!b)return;if(active===b){stop();return;}stop();var text=b.closest('.ai-message-content').querySelector('.ai-message-bubble').innerText;var parts=[],part='';text.trim().split(/\s+/).forEach(function(word){if(part.length+word.length>180&&part){parts.push(part);part='';}part+=(part?' ':'')+word;});if(part)parts.push(part);active=b;b.textContent='Parar leitura';b.setAttribute('aria-pressed','true');var current=run;function next(){if(current!==run)return;if(!parts.length){stop();return;}var utterance=new SpeechSynthesisUtterance(parts.shift());utterance.lang='pt-BR';var voices=speechSynthesis.getVoices();utterance.voice=voices.find(function(v){return /^pt[-_]BR$/i.test(v.lang)&&v.localService;})||voices.find(function(v){return /^pt/i.test(v.lang);})||null;utterance.onend=next;utterance.onerror=stop;speechSynthesis.speak(utterance);}next();});
 document.addEventListener('paje:messages',show);show();document.querySelectorAll('form').forEach(function(f){f.addEventListener('submit',stop);});window.addEventListener('pagehide',stop);
})();
</script>
<?php require __DIR__ . '/../layouts/footer.php'; ?>
