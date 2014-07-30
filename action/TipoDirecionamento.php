<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/atendimento/componentes/config.php');

if($_POST)
{
	if ($_SESSION['validacaoform'] == base64_encode(date('d-m-Y')))
	{


		$acao = base64_decode($_SESSION['acaoform']);

		switch ($acao)
		{
			case 'cadastrar/TipoDirecionamento' :

				$cadastro = new Cadastro();

				try
				{
					$cadastro->setDados($_POST);

					$cadastro->cadastrarTipoDirecionamento();

					$cadastro->finalizarApp('cadastrar/TipoDirecionamento');

				}catch (Exception $e)
				{
					ClasseException::throwException($e,$_POST,'cadastrar/TipoDirecionamento');
				}
				break;

			case 'alterar/TipoDirecionamento' :
				$alteracao = new Alteracao();

				try
				{

					$alteracao->setDados($_POST);

					$alteracao->alterarTipoDirecionamento();

					$alteracao->finalizarApp();

				}catch (Exception $e)
				{
					ClasseException::throwException($e);
				}
				break;

			default:
				Sessao::destroiSessao();
				break;
					
		}

	}else
	{
		Sessao::destroiSessao();
	}
}else
{
	Sessao::destroiSessao();
}


?>
