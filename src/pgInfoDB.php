<?php


namespace Craos\Smart\Backup;


use Exception;

class pgInfoDB
{
    public $Esquemas = [];

    public function __construct()
    {
        $this->Esquemas = $this->ObterEsquemas();
    }

    private function ObterEsquemas()
    {
        $instrucao = <<<SQL
        SELECT
            schema_name as esquema,
            split_part(tamanho, ' ', 1)::int as tamanho,
            split_part(tamanho, ' ', 2)::varchar as peso,
            CASE
                WHEN split_part(tamanho, ' ', 2) = 'kB' THEN 1
                WHEN split_part(tamanho, ' ', 2) = 'MB' THEN 2
                WHEN split_part(tamanho, ' ', 2) = 'GB' THEN 3
            END as tipo
        FROM (
            SELECT schema_name,
                pg_size_pretty(pg_schema_size(a.schema_name)) as tamanho
            FROM (
                SELECT schema_name
                  FROM information_schema.schemata
                 WHERE schema_name not like 'pg%' and schema_name not in ('information_schema')
                 ORDER BY schema_name
            ) AS a
        ) as b
        ORDER BY tipo;
SQL;

        return pg_fetch_all(pg_query($instrucao));
    }
}