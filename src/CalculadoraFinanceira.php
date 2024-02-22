<?php 



class CalculadoraFinanceira {
    
    public float $capital;
    public float $taxa;
    public int $tempo;
    public string $tipo;

    public function verificacao($capital, $taxa, $tempo) {

        if (!is_numeric($capital) || !is_numeric($taxa) || !is_numeric($tempo)) {
            throw new InvalidArgumentException("Todas as entradas devem ser válidas.");
        }

        if ($capital < 0 || $taxa < 0 || $tempo < 0) {
            throw new InvalidArgumentException("Todos os valores devem ser positivos.");
        }

        if ($taxa > 30 || $tempo > 100) {
            throw new InvalidArgumentException("Todos os valores devem estar em um intervalo razoável.");
        }
    }

    public function calcularJurosSimples($capital, $taxa, $tempo) {
        
        $this->verificacao($capital, $taxa, $tempo);

        $taxaDecimal = $taxa/100;

        $juros = $capital * $taxaDecimal * $tempo;

        return round($juros, 2);
    }

    public function calcularJurosCompostos($capital, $taxa, $tempo){
        $this->verificacao($capital, $taxa, $tempo);

        $taxaDecimal = $taxa/100;

        $juros = ($capital * (1 + $taxaDecimal)**$tempo) - $capital;

        return round($juros, 2);
    }

    public function calcularAmortizacao($capital, $taxa, $tempo, $tipo) {
        $this->verificacao($capital, $taxa, $tempo);

        $jurosTotal = 0;
        $parcelasAmortizacao = array();

        $taxaDecimal = $taxa/100;

        switch($tipo) {

            case "SAC":
                $parcelaAmortizacao = $capital / $tempo;
                for ($i = 1; $i <= $tempo; $i++) {
                    $juros = $capital * $taxaDecimal;
                    $jurosTotal += $juros;
                    $parcelasAmortizacao[] = round($parcelaAmortizacao, 2);
                    $capital -= $parcelaAmortizacao;
                }
                break;

            case "Price":
                $parcelaPagar = $capital * $taxaDecimal * pow(1 + $taxaDecimal, $tempo) / (pow(1 + $taxaDecimal, $tempo) - 1);
                for ($i = 1; $i <= $tempo; $i++) {
                    $juros = $capital * $taxaDecimal;
                    $jurosTotal += $juros;
                    $parcelaAmortizacao = $parcelaPagar - $juros;
                    $parcelasAmortizacao[] = round($parcelaAmortizacao, 2);
                    $capital -= $parcelaPagar - $juros;
                }
                break;

            default:
                throw new InvalidArgumentException("Escolha um tipo de amortização válido.");
        }

        return array(round($jurosTotal, 2), $parcelasAmortizacao);
    }
}