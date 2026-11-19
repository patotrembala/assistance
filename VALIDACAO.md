# Validação da entrega — 18/11/2026

Repositório: https://github.com/patotrembala/assistance/tree/ethanassistant

## Conferências desta rodada

- Sintaxe dos 59 arquivos PHP: aprovada com PHP local.
- Teste isolado do Pajezinho: aprovado com transporte simulado, sem consumo externo. Inclui respostas de erro esperadas.
- Permissões operacionais: 13 cenários aprovados, incluindo administrador, técnico, OS própria, de outro técnico e disponível para assumir.
- Login, recuperação e privacidade abriram na hospedagem. A revisão autenticada aguarda confirmação do código pelo usuário.
- Marca de apresentação: Assistance; assistente: Pajezinho. Identificadores internos legados são mantidos para compatibilidade.
- Voz personalizada removida. O endpoint antigo responde 410 e não solicita áudio externo. A leitura disponível usa a voz do navegador.
- Manuais de administrador e técnico gerados em PDF e conferidos página a página.
- Configurações particulares, senhas, chaves e sessões não integram o pacote. Os exemplos devem ser preenchidos em ambiente próprio.

## Evidências anteriores e limites

Em 15/11 foram testados cadastro/edição de cliente e criação/conclusão de OS, chamado e pendência. A impressão da OS também foi conferida. Esses testes não substituem uma nova rodada com sessão real de Técnico.

- A revisão visual interna e o fluxo completo de Técnico permanecem pendentes de acesso autenticado.
- Recebimento de recuperação na caixa postal e redefinição final não foram comprovados. Nenhuma senha foi alterada nesta rodada.
- Testes que gravam no banco não foram executados localmente sem uma base isolada. Exclusões permanentes não foram testadas.
- Registros QA anteriores permanecem no banco e afetam indicadores: cliente #6, OS #3 concluída, OS #4 aberta/disponível, chamado #4, pendência #4 e serviço #10 inativo.
- Horários automáticos sem fuso são convertidos pelo deslocamento atual do servidor. Precisão de registros históricos de outro período de horário de verão exige migração específica.

Consulte README.md para instalar e docs/ para os manuais. Este relatório descreve verificações realizadas; não certifica que todas as funções foram testadas ponta a ponta.
