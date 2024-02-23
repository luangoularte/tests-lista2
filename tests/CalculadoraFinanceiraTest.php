<?php

require_once "./src/CalculadoraFinanceira.php";
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertEquals;

class CalculadoraFinanceiraTest extends TestCase {

    private readonly CalculadoraFinanceira $CalculadoraFinanceira;

    public function setup(): void {
        $this->CalculadoraFinanceira = new CalculadoraFinanceira;
    }

    //calcularJurosSimples

    public function testCalcularJurosSimplesValoresPositivos() {
        $resposta = $this->CalculadoraFinanceira->calcularJurosSimples(1289, 5, 3);

        $this->assertEquals(193.35, $resposta);
    }

    public function testCalcularJurosSimplesValoresNegativos() {
        $this->expectException(InvalidArgumentException::class);

        $resposta = $this->CalculadoraFinanceira->calcularJurosSimples(-1231, -1, -1);

        $this->assertEquals(1234, $resposta);
    }

    public function testCalcularJurosSimplesValoresExtremos() {
        $this->expectException(InvalidArgumentException::class);

        $resposta = $this->CalculadoraFinanceira->calcularJurosSimples(2000, 32, 120);

        $this->assertEquals(1111, $resposta);
    }

    public function testCalcularJurosSimplesEntradaInválida() {
        $this->expectException(InvalidArgumentException::class);

        $resposta = $this->CalculadoraFinanceira->calcularJurosSimples("mil", "10/100", "2013");

        $this->assertEquals(1111, $resposta);
    }

    //calcularJurosCompostos

    public function testCalcularJurosCompostosValoresPositivos() {
        $resposta = $this->CalculadoraFinanceira->calcularJurosCompostos(2000, 7, 5);

        $this->assertEquals(2805.10, $resposta);
    }

    public function testCalcularJurosCompostosValoresNegativos() {
        $this->expectException(InvalidArgumentException::class);

        $resposta = $this->CalculadoraFinanceira->calcularJurosCompostos(-2000, -7, -5);

        $this->assertEquals(805.10, $resposta);
    }

    public function testCalcularJurosCompostosValoresExtremos() {
        $this->expectException(InvalidArgumentException::class);

        $resposta = $this->CalculadoraFinanceira->calcularJurosCompostos(12000, 321, 120);

        $this->assertEquals(1111, $resposta);
    }

    public function testCalcularJurosCompostosEntradaInválida() {
        $this->expectException(InvalidArgumentException::class);

        $resposta = $this->CalculadoraFinanceira->calcularJurosCompostos("doze", "percentual", "");

        $this->assertEquals(1111, $resposta);
    }

    //calcularAmortizacao

    public function testCalcularAmortizacaoSAC() {
        $resposta = $this->CalculadoraFinanceira->calcularAmortizacao(10000, 5, 4, "SAC");

        $this->assertEquals([1250.00, [2500, 2500, 2500, 2500]], $resposta);
    }

    public function testCalcularAmortizacaoPrice() {
        $resposta = $this->CalculadoraFinanceira->calcularAmortizacao(10000, 5, 4, "Price");
        
        $this->assertEquals([ 1280.47, [2320.12, 2436.12, 2557.93, 2685.83]], $resposta);
    }

    public function testCalcularAmortizacaoValoresNegativos() {
        $this->expectException(InvalidArgumentException::class);

        $resposta = $this->CalculadoraFinanceira->calcularAmortizacao(-10000, -5, -2, "Price");

        $this->assertEquals([123, [4234, 4234]], $resposta);
    }

    public function testCalcularAmortizacaoValoresExtremos() {
        $this->expectException(InvalidArgumentException::class);

        $resposta = $this->CalculadoraFinanceira->calcularAmortizacao(10000, 50, 20000, "SAC");

        $this->assertEquals([0532, [90123, 12312]], $resposta);
    }

    public function testCalcularAmortizacaoEntradaInválida() {
        $this->expectException(InvalidArgumentException::class);

        $resposta = $this->CalculadoraFinanceira->calcularAmortizacao("um", "dois", "", "SAC");

        $this->assertEquals([9034, [3901, 4821]], $resposta);
    }

    public function testCalcularAmortizacaoTipoInválido() {
        $this->expectException(InvalidArgumentException::class);

        $resposta = $this->CalculadoraFinanceira->calcularAmortizacao(20000, 6, 3, "sac");

        $this->assertEquals([9348, [1922, 4572]], $resposta);
    }

}