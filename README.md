# Biblioteca E.E. Bueno Brandão

Sistema de biblioteca escolar em PHP com MySQL.

## Deploy via Docker

### Passo 1: Build e subir os containers

```bash
docker compose up --build -d
```

### Passo 2: Importar base de dados

Dentro do container Docker MySQL ou localmente:

```bash
docker exec -i $(docker ps -q -f name=biblioteca_db_1) mysql -uroot -proot biblioteca < setup_library_tables.sql
```

### Acessar
- App: `http://localhost:8080`
- Banco: `localhost:3306`

### Variáveis de ambiente
- `DB_HOST` (padrão: `db` em Docker)
- `DB_USER` (padrão: `root`)
- `DB_PASS` (padrão: `root`)
- `DB_NAME` (padrão: `biblioteca`)

## Deploy no EasyPanel

1. Suba o repositório `https://github.com/maxudi/biblioteca.git`.
2. Configure o serviço web para usar `Dockerfile`.
3. Configure as variáveis de ambiente para MySQL.
4. Exporte ou importe `setup_library_tables.sql` no banco de dados.

## Observações

- Use `docker compose down` para parar o ambiente.
- Use `docker compose up -d` para iniciar novamente.
