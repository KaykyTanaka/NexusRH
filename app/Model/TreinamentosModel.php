<?php
namespace App\Model;

class TreinamentosModel
{
    private $tre_id;
    private $tre_titulo;
    private $tre_descricao;
    private $tre_responsavel;
    private $tre_ativo;


    public function getTreId()
    {
        return $this->tre_id;
    }

    public function setTreId($tre_id)
    {
        $this->tre_id = $tre_id;
    }

    public function getTreTitulo()
    {
        return $this->tre_titulo;
    }

    public function setTreTitulo($tre_titulo)
    {
        $this->tre_titulo = $tre_titulo;
    }

    public function getTreDescricao()
    {
        return $this->tre_descricao;
    }

    public function setTreDescricao($tre_descricao)
    {
        $this->tre_descricao = $tre_descricao;
    }

    public function getTreResponsavel()
    {
        return $this->tre_responsavel;
    }

    public function setTreResponsavel($tre_responsavel)
    {
        $this->tre_responsavel = $tre_responsavel;
    }

    public function getTreAtivo()
    {
        return $this->tre_ativo;
    }

    public function setTreAtivo($tre_ativo)
    {
        $this->tre_ativo = $tre_ativo;
    }
}
