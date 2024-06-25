<?php
namespace App\View;
use TCPDF;

require dirname(__DIR__, 2) . '/vendor/autoload.php';
use \App\Controller\TreinamentosController;
use \App\Controller\LoginController;
//use \App\View\Vendor\TCPDF\TCPDF;
$banco = new LoginController();
if (!isset($_SESSION['usuario'])) {
    $banco->destroy_sessoes();
    header('Location: LoginView.php');
}

//include library
include('vendor/TCPDF/tcpdf.php');

//make TCPDF object
$pdf = new TCPDF('P','mm','A4');

//remove default header and footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

//add page
$pdf->AddPage();

//add content (student list)
//title
$idTreinamento = $_GET["idTreinamento"];
$dadosTreino = (new TreinamentosController())->getTreinamentosById($idTreinamento);
$dadosColabsTreino = (new TreinamentosController())->getColaboradoresByTreinamentoId($idTreinamento);
if($dadosTreino == false || $dadosColabsTreino == null){
	header('Location: viewTreinamentos.php');
}
//var_dump($dadosTreino);

$pdf->SetFont('Helvetica','',14);
$pdf->Cell(190,10,"Relatório de Treinamento",0,1,'C');

$pdf->SetFont('Helvetica','',10);
$pdf->Cell(190,10,"Relatório: " . $dadosTreino['tre_titulo'] ,0,1,'C');

$pdf->SetFont('Helvetica','',10);
$pdf->Cell(25,5,"Colaboradores: ",0);
$colaboradores = "";
$numColabs = count($dadosColabsTreino);
$i = 0;
foreach($dadosColabsTreino as $colabs){
	$separador = "";
	if(++$i != $numColabs){ $separador = ", ";}
	else{ $separador = "";}
	$colaboradores .=  $colabs['pes_nome'] . $separador;
}
$pdf->Cell(30,0,$colaboradores, 0);
$pdf->Ln();
$pdf->Cell(50,5,"Responsável Pelo Treinamento",0);
$pdf->Cell(0,5,": " . $dadosTreino['tre_responsavel'],0);
$pdf->Ln();
$pdf->Ln(2);

//make the table
$html = "
	<table>
		<tr>
			<th>Descrição</th>
			<th>Status do Treinamento</th>
		</tr>
		";
$ativo = "";
if($dadosTreino['tre_ativo'] == 1){
	$ativo = "Ativo";
}else if($dadosTreino['tre_ativo'] == 0){
	$ativo = "Desativo";
}
$html .= "
 			<tr>
 				<td>". $dadosTreino['tre_descricao'] ."</td>
 				<td>". $ativo ."</td>
 			</tr>
 			";		

$html .= "
	</table>
	<style>
	table {
		border-collapse:collapse;
		padding: 1%;
	}
	th,td {
		border:1px solid #888;
		padding: 20%;
	}
	table tr th {
		background-color:#888;
		color:#fff;
		font-weight:bold;
	}
	</style>
";
//WriteHTMLCell
$pdf->WriteHTMLCell(192,0,9,'',$html,0);	


//output
$pdf->Output();










