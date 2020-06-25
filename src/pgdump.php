<?php


namespace SmartPgDump;

/**
 * Class pgDump
 * @author Oberdan
 * @since extrai um banco de dados PostgreSQL para um arquivo de script ou outro arquivo.
 * O pg_dump é um utilitário para fazer backup de um banco de dados PostgreSQL . Faz backups consistentes,
 * mesmo que o banco de dados esteja sendo usado simultaneamente.
 * @package SmartServer\Backup
 */
class pgDump
{

    /**
     * Despejar apenas os dados, não o esquema (definições de dados). Os dados da tabela,
     * objetos grandes e valores de sequência são despejados
     * @var bool
     */
    public $DataOnly = false;

    /**
     * Inclua objetos grandes no despejo. Esse é o comportamento padrão, exceto quando --schema , --table ou --schema-only
     * é especificado. A opção -b é, portanto, útil apenas para adicionar objetos grandes a despejos onde um esquema ou
     * tabela específica foi solicitada. Observe que os blobs são considerados dados e, portanto, serão incluídos quando
     * --data-only for usado, mas não quando --schema-only for.
     * @var  bool
     */
    public $Blobs = false;

    /**
     * Comandos de saída para limpar (descartar) objetos do banco de dados antes da saída dos comandos para criá-los.
     * (A restauração pode gerar algumas mensagens de erro inofensivas, se algum objeto não estiver presente no banco de dados
     * de destino.) Esta opção é significativa apenas para o formato de texto sem formatação. Para os formatos de arquivo morto, você pode
     * especificar a opção ao chamar pg_restore
     * @var bool
     */
    public $Clean = false;

    /**
     * Comece a saída com um comando para criar o próprio banco de dados e reconecte-se ao banco de dados criado.
     * (Com um script deste formulário, não importa a qual banco de dados na instalação de destino você se conecta antes de
     * executar o script.) Se --clean também for especificado, o script descartará e recriará o banco de dados de destino
     * antes de reconectá-lo. Esta opção é significativa apenas para o formato de texto sem formatação. Para os formatos de
     * arquivo morto, você pode especificar a opção ao chamar pg_restore .
     * @var bool
     */
    public $Create = false;

    /**
     * Crie o despejo na codificação do conjunto de caracteres especificado. Por padrão, o despejo é criado na codificação
     * do banco de dados. (Outra maneira de obter o mesmo resultado é definir a variável de ambiente PGCLIENTENCODING para
     * a codificação de despejo desejada.)
     * @var string
     */
    public $Encoding = null;

    /**
     * Envie a saída para o arquivo especificado. Este parâmetro pode ser omitido para formatos de saída baseados em arquivo;
     * nesse caso, a saída padrão é usada. No entanto, ele deve ser fornecido para o formato de saída do diretório, onde
     * especifica o diretório de destino em vez de um arquivo. Nesse caso, o diretório é criado por pg_dump e não deve existir
     * antes.
     * @var string
     */
    public $File = null;

    /**
     * Seleciona o formato da saída. O formato pode ser um dos seguintes:
     * p (simples) Saída de um arquivo de script SQL em texto sem formatação (o padrão).
     * c (personalizado) Envie um arquivo de formato personalizado adequado para entrada no pg_restore . Juntamente com o formato de saída do diretório, este é o formato de saída mais flexível, pois permite a seleção manual e a reordenação dos itens arquivados durante a restauração. Esse formato também é compactado por padrão.
     * d (diretório) Envie um arquivo no formato de diretório adequado para entrada no pg_restore . Isso criará um diretório com um arquivo para cada tabela e blob sendo despejado, além de um arquivo chamado Table of Contents descrevendo os objetos despejados em um formato legível por máquina que o pg_restore pode ler. Um arquivo no formato de diretório pode ser manipulado com ferramentas padrão do Unix; por exemplo, arquivos em um arquivo compactado não compactado podem ser compactados com a ferramenta gzip . Esse formato é compactado por padrão e também suporta despejos paralelos.
     * t (tar) Envie um arquivo tar- format adequado para entrada no pg_restore . O formato tar é compatível com o formato do diretório: extrair um arquivo no formato tar produz um arquivo no formato do diretório válido. No entanto, o formato tar não suporta compactação. Além disso, ao usar o formato tar, a ordem relativa dos itens de dados da tabela não pode ser alterada durante a restauração.
     * @var string
     */
    public $Format = null;

    /**
     * Uma opção descontinuada que agora é ignorada
     * @var bool
     */
    public $IgnoreVersion = false;

    /**
     * Execute o despejo em paralelo despejando tabelas njobs simultaneamente. Essa opção reduz o tempo do despejo,
     * mas também aumenta a carga no servidor de banco de dados. Você só pode usar esta opção com o formato de saída do
     * diretório, porque este é o único formato de saída em que vários processos podem gravar seus dados ao mesmo tempo.
     * @var string
     */
    public $Jobs = null;

    /**
     * Despejar apenas esquemas correspondentes ao esquema ; isso seleciona o próprio esquema e todos os seus objetos contidos.
     * Quando essa opção não é especificada, todos os esquemas que não são do sistema no banco de dados de destino serão
     * despejados
     * @var string
     */
    public $Schema = null;

    /**
     * Não despeje nenhum esquema que corresponda ao padrão do esquema.
     * @var string
     */
    public $excludeSchema = null;

    /**
     * @var null
     * Despejar identificadores de objeto ( OID ) como parte dos dados de todas as tabelas. Use esta opção se o seu
     * aplicativo referenciar as colunas OID de alguma forma (por exemplo, em uma restrição de chave estrangeira).
     * Caso contrário, esta opção não deve ser usada.
     * @var bool
     */
    public $Oids = false;

    /**
     * Não produza comandos para definir a propriedade dos objetos para corresponder ao banco de dados original.
     * Por padrão, o pg_dump emite as instruções ALTER OWNER ou SET SESSION AUTHORIZATION para definir a propriedade dos
     * objetos de banco de dados criados. Essas instruções falharão quando o script for executado, a menos que seja
     * iniciado por um superusuário (ou pelo mesmo usuário que possui todos os objetos no script).
     * @var bool
     */
    public $NoOwner = false;

    /**
     * Esta opção está obsoleta, mas ainda aceita para compatibilidade com versões anteriores.
     * @var bool
     */
    public $NoReconnect = false;

    /**
     * Despejar apenas as definições de objeto (esquema), não dados. Esta opção é o inverso de --data-only
     * @var bool
     */
    public $SchemaOnly = false;

    /**
     * Especifique o nome de usuário do superusuário a ser usado ao desativar acionadores. Isso é relevante apenas
     * se --disable-triggers for usado. (Geralmente, é melhor deixar isso de lado e iniciar o script resultante como
     * superusuário.)
     * @var string
     */
    public $SuperUser = null;

    /**
     * Despejar apenas tabelas (ou exibições ou sequências ou tabelas estrangeiras) de tabela correspondente .
     * É possível selecionar várias tabelas escrevendo várias opções -t . Além disso, a tabela de parâmetro é
     * interpretado como um padrão de acordo com as mesmas regras usadas pelo psql 's \ d comandos (consulte Padrões ),
     * de modo que várias tabelas podem também ser selecionados escrevendo caracteres curinga no padrão.
     * Ao usar curingas, tenha cuidado para citar o padrão, se necessário, para impedir que o shell expanda os curingas;
     * @var string
     */
    public $Table = null;

    /**
     * Não despeje nenhuma tabela que corresponda ao padrão da tabela . O padrão é interpretado de acordo com as mesmas
     * regras que para -t . -T pode receber mais de uma vez para excluir tabelas correspondentes a qualquer um dos vários
     * padrões.
     * @var string
     */
    public $ExcludeTable = null;

    /**
     * Especifica o modo detalhado. Isso fará com que o pg_dump produza comentários detalhados sobre o objeto e os horários
     * de início / parada no arquivo de despejo, e avance as mensagens para erro padrão.
     * @var bool
     */
    public $Verbose = false;

    /**
     * Imprima a versão pg_dump e saia.
     * @var bool
     */
    public $Version = false;

    /**
     * Impedir o dumping de privilégios de acesso (comandos de concessão / revogação).
     * @var bool
     */
    public $NoPrivileges = false;

    /**
     * Especifique o nível de compactação a ser usado. Zero significa sem compactação. Para o formato de archive customizado,
     * isso especifica a compactação de segmentos de dados de tabela individuais e o padrão é compactar em um nível moderado.
     * Para saída de texto sem formatação, definir um nível de compactação diferente de zero faz com que
     * todos o arquivo de saída seja compactado, como se tivesse sido alimentado pelo gzip ; mas o padrão é não compactar.
     * O formato de arquivo tar atualmente não suporta compactação.
     * @var string
     */
    public $Compress = null;

    /**
     * Esta opção é para uso por utilitários de atualização no local. Seu uso para outros fins não é recomendado ou suportado.
     * O comportamento da opção pode mudar em versões futuras sem aviso prévio.
     * @var bool
     */
    public $BinaryUpgrade = false;

    /**
     * Despejar dados como comandos INSERT com nomes explícitos de coluna ( tabela INSERT INTO ( coluna , ...) VALUES ... ).
     * Isso tornará a restauração muito lenta; é útil principalmente para criar dumps que podem ser carregados em bancos de
     * dados não PostgreSQL . No entanto, como essa opção gera um comando separado para cada linha, um erro ao recarregar uma
     * linha faz com que apenas essa linha seja perdida, em vez de todos o conteúdo da tabela.
     * @var bool
     */
    public $ColumnInserts = false;

    /**
     * Esta opção desativa o uso de cotação em dólar para corpos de função e força a sua cotação usando a sintaxe de seqüência
     * de caracteres padrão do SQL
     * @var bool
     */
    public $DisableDollarQuoting = false;

    /**
     * Esta opção é relevante apenas ao criar um dump somente de dados. Ele instrui o pg_dump a incluir comandos para desativar
     * temporariamente os gatilhos nas tabelas de destino enquanto os dados são recarregados. Use isso se você tiver
     * verificações de integridade referenciais ou outros gatilhos nas tabelas que você não deseja chamar durante o
     * recarregamento de dados.
     * @var bool
     */
    public $DisableTriggers = false;

    /**
     * Não despeje dados para nenhuma tabela que corresponda ao padrão da tabela . O padrão é interpretado de acordo com as
     * mesmas regras que para -t . --exclude-table-data pode ser fornecido mais de uma vez para excluir tabelas correspondentes
     * a qualquer um dos vários padrões. Essa opção é útil quando você precisa da definição de uma tabela específica,
     * mesmo que não precise dos dados nela.
     * @var string
     */
    public $ExcludeTableData = null;

    /**
     * Despejar dados como comandos INSERT (em vez de COPY ). Isso tornará a restauração muito lenta; é útil principalmente
     * para criar dumps que podem ser carregados em bancos de dados não PostgreSQL . No entanto, como essa opção gera um
     * comando separado para cada linha, um erro ao recarregar uma linha faz com que apenas essa linha seja perdida, em vez
     * de todos o conteúdo da tabela. Observe que a restauração poderá falhar completamente se você reorganizar a ordem das
     * colunas. A opção --column-inserts é segura contra alterações na ordem das colunas, embora ainda mais lenta.
     * @var bool
     */
    public $Inserts = false;

    /**
     * Não espere para sempre para adquirir bloqueios de tabela compartilhada no início do despejo. Em vez disso, falhe se
     * não conseguir bloquear uma tabela dentro do tempo limite especificado . O tempo limite pode ser especificado em
     * qualquer um dos formatos aceitos pelo SET statement_timeout . (Os valores permitidos variam de acordo com a versão do
     * servidor do qual você está descarregando, mas um número inteiro de milissegundos é aceito por todas as versões desde
     * a 7.3. Esta opção é ignorada ao descarregar de um servidor anterior à 7.3.).
     * @var string
     */
    public $LockWaitTimeout = null;

    /**
     * Não despeje etiquetas de segurança.
     * @var bool
     */
    public $NoSecurityLabels = false;

    /**
     * Esta opção permite executar o pg_dump -j em um servidor pré-9.2, consulte a documentação do parâmetro -j para obter mais
     * detalhes.
     * @var bool
     */
    public $NoSynchronizedSnapshots = false;

    /**
     * Não produza comandos para selecionar espaços de tabela. Com esta opção, todos os objetos serão criados em qualquer
     * espaço de tabela que seja o padrão durante a restauração.
     * @var bool
     */
    public $NoTablespaces = false;

    /**
     * Não despeje o conteúdo de tabelas não registradas. Esta opção não afeta se as definições da tabela (esquema) são ou não
     * despejadas; suprime apenas o descarte dos dados da tabela. Os dados em tabelas não registradas são sempre excluídos ao
     * descarregar de um servidor em espera.
     * @var bool
     */
    public $NoUnloggedTableData = false;

    /**
     * Forçar a citação de todos os identificadores. Esta opção é recomendada ao descarregar um banco de dados de um servidor
     * cuja versão principal do PostgreSQL é diferente da do pg_dump ', ou quando a saída se destina a ser carregada em um
     * servidor de uma versão principal diferente. Por padrão, pg_dump cita apenas identificadores que são palavras reservadas
     * em sua própria versão principal. Às vezes, isso resulta em problemas de compatibilidade ao lidar com servidores de
     * outras versões que podem ter conjuntos ligeiramente diferentes de palavras reservadas. O uso de --quote-all-identifiers
     * evita esses problemas, ao preço de um script de despejo mais difícil de ler.
     * @var bool
     */
    public $QuoteAllIdentifiers = false;

    /**
     * Apenas despejar a seção nomeada. O nome da seção pode ser pré-dados , dados ou pós-dados . Esta opção pode ser
     * especificada mais de uma vez para selecionar várias seções. O padrão é despejar todas as seções.
     * @var string
     */
    public $Section = null;

    /**
     * Use uma transação serializável para o dump, para garantir que o instantâneo usado seja consistente com os estados
     * posteriores do banco de dados; mas faça isso aguardando um ponto no fluxo de transações no qual nenhuma anomalia
     * possa estar presente, para que não haja o risco de o dump falhar ou fazer com que outras transações sejam revertidas
     * com um serialization_failure . Consulte o Capítulo 13 para obter mais informações sobre isolamento de transações e
     * controle de concorrência.
     * @var bool
     */
    public $SerializableDeferrable = false;

    /**
     * Emita comandos SET SESSION AUTHORIZATION padrão do SQL em vez de comandos ALTER OWNER para determinar a propriedade
     * do objeto. Isso torna o despejo mais compatível com os padrões, mas, dependendo do histórico dos objetos no despejo,
     * pode não ser restaurado corretamente. Além disso, um dump usando SET SESSION AUTHORIZATION certamente exigirá
     * privilégios de superusuário para restaurar corretamente, enquanto ALTER OWNER requer privilégios menores.
     * @var bool
     */
    public $UseSetSessionAuthorization = false;

    /**
     * Especifica o nome do banco de dados ao qual se conectar. Isso é equivalente a especificar dbname como o primeiro
     * argumento não opcional na linha de comandos.
     * @var string
     */
    public $Dbname = null;

    /**
     * Especifica o nome do host da máquina na qual o servidor está sendo executado. Se o valor começar com uma barra,
     * ele será usado como o diretório do soquete do domínio Unix. O padrão é obtido da variável de ambiente PGHOST ,
     * se configurada, caso contrário, uma conexão de soquete de domínio Unix é tentada.
     * @var string
     */
    public $Host = null;

    /**
     * Especifica a porta TCP ou a extensão do arquivo de soquete de domínio Unix local na qual o servidor está atendendo
     * a conexões. O padrão é a variável de ambiente PGPORT , se configurada, ou um padrão compilado.
     * @var string
     */
    public $Port = null;

    /**
     * Conecta usando o nome de usuário.
     * @var string
     */
    public $Username = null;

    /**
     * Nunca emita um prompt de senha. Se o servidor exigir autenticação por senha e uma senha não estiver disponível por
     * outros meios, como um arquivo .pgpass , a tentativa de conexão falhará. Essa opção pode ser útil em tarefas em lote
     * e scripts em que nenhum usuário está presente para inserir uma senha.
     * @var bool
     */
    public $NoPassword = false;

    /**
     * Force o pg_dump a solicitar uma senha antes de conectar-se a um banco de dados.
     * @var string
     */
    public $Password = null;

    /**
     * Especifica um nome de função a ser usado para criar o dump. Esta opção faz com que o pg_dump emita um comando
     * SET ROLE rolename após a conexão com o banco de dados. É útil quando o usuário autenticado (especificado por -U )
     * não possui privilégios necessários ao pg_dump , mas pode alternar para uma função com os direitos necessários.
     * Algumas instalações têm uma política contra efetuar login diretamente como superusuário, e o uso dessa opção
     * permite que os dumps sejam feitos sem violar a política.
     * @var string
     */
    public $Role = null;


    /**
     * @var pgServer
     */
    private $pgServer;

    /**
     * pgBbackup constructor.
     * @param pgServer $pg
     */
    public function __construct(pgServer $pg)
    {
        $this->pgServer = $pg;
    }

    /**
     * Monta o comando de dump
     * @return string
     */
    public function getDumpCommand()
    {

        $command = [
            'pg_dump'
        ];

        if ($this->DataOnly == true)
            $command[] = '--data-only';

        if ($this->Blobs == true)
            $command[] = '--blobs';

        if ($this->Clean == true)
            $command[] = '--clean';

        if ($this->Create == true)
            $command[] = '--create';

        if ($this->Encoding !== null)
            $command[] = '--encoding ' . $this->Encoding;

        if ($this->File !== null)
            $command[] = '--file ' . $this->File;

        if ($this->Format !== null)
            $command[] = '--format ' . $this->Format;

        if ($this->IgnoreVersion == true)
            $command[] = '--ignore-version';

        if ($this->Jobs !== null)
            $command[] = '--jobs ' . $this->Jobs;

        if ($this->Schema !== null)
            $command[] = '--schema ' . $this->Schema;

        if ($this->excludeSchema !== null)
            $command[] = '--exclude-schema ' . $this->excludeSchema;

        if ($this->Oids == true)
            $command[] = '--oids';

        if ($this->NoOwner == true)
            $command[] = '--no-owner';

        if ($this->NoReconnect == true)
            $command[] = '--no-reconnect';

        if ($this->SchemaOnly == true)
            $command[] = '--schema-only';

        if ($this->SuperUser !== null)
            $command[] = '--superuser ' . $this->SuperUser;

        if ($this->Table !== null)
            $command[] = '--table ' . $this->Table;

        if ($this->ExcludeTable !== null)
            $command[] = '--exclude-table ' . $this->ExcludeTable;

        if ($this->Verbose == true)
            $command[] = '--verbose';

        if ($this->Version == true)
            $command[] = '--version';

        if ($this->NoPrivileges == true)
            $command[] = '--no-privileges';

        if ($this->Compress !== null)
            $command[] = '--compress ' . $this->Compress;

        if ($this->BinaryUpgrade == true)
            $command[] = '--binary-upgrade';

        if ($this->ColumnInserts == true)
            $command[] = '--column-inserts';

        if ($this->DisableDollarQuoting == true)
            $command[] = '--disable-dollar-quoting';

        if ($this->DisableTriggers == true)
            $command[] = '--disable-triggers';

        if ($this->ExcludeTableData !== null)
            $command[] = '--exclude-table-data ' . $this->ExcludeTableData;

        if ($this->Inserts == true)
            $command[] = '--inserts';

        if ($this->LockWaitTimeout !== null)
            $command[] = '--lock-wait-timeout ' . $this->LockWaitTimeout;

        if ($this->NoSecurityLabels == true)
            $command[] = '--no-security-labels';

        if ($this->NoSynchronizedSnapshots == true)
            $command[] = '--no-synchronized-snapshots';

        if ($this->NoTablespaces == true)
            $command[] = '--no-tablespaces';

        if ($this->NoUnloggedTableData == true)
            $command[] = '--no-unlogged-table-data';

        if ($this->QuoteAllIdentifiers == true)
            $command[] = '--quote-all-identifiers';

        if ($this->Section !== null)
            $command[] = '--section ' . $this->Section;

        if ($this->SerializableDeferrable == true)
            $command[] = '--serializable-deferrable';

        if ($this->UseSetSessionAuthorization == true)
            $command[] = '--use-set-session-authorization';

        if ($this->Dbname !== null)
            $command[] = '--dbname ' . $this->Dbname;

        if ($this->Host !== null)
            $command[] = '--host ' . $this->Host;

        if ($this->Port !== null)
            $command[] = '--port ' . $this->Port;

        if ($this->Username !== null)
            $command[] = '--username ' . $this->Username;

        if ($this->NoPassword == true)
            $command[] = '--no-password';

        if ($this->Password !== null)
            $command[] = '--password ' . $this->Password;

        if ($this->Role !== null)
            $command[] = '--role ' . $this->Role;

        $stringcommand = '';
        foreach ($command as $value)
            $stringcommand .= ' ' . $value;

        return $stringcommand;

    }
}