<?php
// Definição da classe Pessoa
class Pessoa {
    // Atributos
    public $nome;
    public $idade;

    // Método construtor
    public function __construct($nome, $idade) {
        $this->nome = $nome;
        $this->idade = $idade;
    }

    // Método para exibir informações da pessoa
    public function exibirInfo() {
        return "Nome: " . $this->nome . ", Idade: " . $this->idade . " anos.";
    }
}

// Criação de um objeto da classe Pessoa
$pessoa1 = new Pessoa("João", 30);
// Exibição das informações da pessoa
echo $pessoa1->exibirInfo();

// Criação de outro objeto da classe Pessoa
$pessoa2 = new Pessoa("Maria", 25);
// Exibição das informações da pessoa
echo $pessoa2->exibirInfo();        

?>