<?php

class CConexao {
    /* -- Configurações Bernardo-- */

    /*
        protected $Host = 'localhost';
        protected $User = 'postgres';
        protected $Password = 'root';
        protected $Porta = '5432';
        protected $DbName = 'fmottors';
        protected $Conexao = null;

    */

    /* -- Config BD REMOTE -- */


    protected $Host='pgsql.fmottors.com.br';
    protected $User='fmottors';
    protected $Password='fmottors230894';
    protected $Porta='5432';
    protected $DbName='fmottors';
    protected $Conexao=null;

    public function __construct() {
        
    }

    public function __destruct() {
        
    }

    public function novaConexao() {

        $this->Conexao = @pg_connect("host='" . $this->Host .
                        "' user='" . $this->User .
                        "' password='" . $this->Password .
                        "'port='" . $this->Porta
                        . "' dbname='" . $this->DbName . "'");

        return $this->Conexao;
    }

    public function verificaConexao() {

        if (!$this->Conexao) {
            echo '<h3>N&atilde;o estamos conectados ao banco [' . $this->DbName . '] em [' . $this->Host . '].</h3>';
            exit;
        } else {
            echo '<h3>Estamos conectados ao banco [' . $this->DbName . '] em [' . $this->Host . '].</h3>';
        }
    }

    public function closeConexao() {

        @pg_close($this->Conexao);
    }
    
    public function getConnection(){
        return $this->Conexao;
    }
            

}

?>
