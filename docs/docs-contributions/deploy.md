---
currentMenu: docs-deploy
---

# Deploy documentazione

Come anticipato nella sezione contributi tutta la documentazione viene gestita
tramite i due tools gh-pages e couscous.
In linea generale il depoly della documentazione è composto
da due distinte operazioni
- rendering in locale (couscous)
- commit del risultato del rendering sul branch `gh-pages`

Per semplicità i vari passaggi necessari per l'update della documentazione online
sono gestiti in modo automatico con action manuale `Documentation builder`.

Se si è in possesso dei necessari privilegi è possibile [aprire la pagina](https://github.com/zerai/ils-jb/actions/workflows/documentation.yaml) 
dell'action relativa e premere il pulsante 'Run workflow'.