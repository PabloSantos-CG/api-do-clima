# API do Clima

Projeto simples que consulta dados do clima usando uma API externa e guarda as respostas no Redis para acelerar e diminuir chamadas repetidas.

## Tecnologias

- PHP (Laravel)
- Redis para cache
- Composer para dependências

## O que faz

- Busca o clima atual de uma cidade
- Usa cache no Redis para evitar ficar chamando a API externa toda hora
- Controla quantas requisições podem ser feitas para evitar abuso

## Como usar

1. Clone o projeto:

```bash
git clone https://github.com/seu-usuario/weather-api.git
cd weather-api
```

2. Rota para requisição:

```bash
GET http://localhost:8000/api/weather?api_key={api_key}&latitude={latitude}&longitude={longitude}
