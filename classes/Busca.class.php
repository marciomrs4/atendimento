<?php
class Busca extends Dados
{

	public function getLayoutUsuario($usu_codigo)
	{
		$tblayout = new TbLayout();

		try
		{
			$usu_codigo = ($usu_codigo == '') ? 1 : $usu_codigo;
			$dados = $tblayout->selecLayoutUsuario($usu_codigo);
			return($dados);

		} catch (PDOException $e)
		{
			throw new PDOException($e->getMessage(), $e->getCode());
		}
	}

	public function listarChamado()
	{

		#Dados da busca usado para diferenciar, pois caso contrario h� um
		#conflito de nomes com abertura de chamados e listava ou DEPTO.
		$this->dados['pro_codigo_busca'];

		switch ($this->dados['verpor'])
		{

			case 0 : #Todos

				$this->dados['dep_codigo_solicitado'] = $_SESSION['dep_codigo'];
				$this->dados['usu_codigo_solicitante'] = $_SESSION['usu_codigo'];
				$this->dados['sta_codigo'] = ($this->dados['sta_codigo'] == '') ? '%' : $this->dados['sta_codigo'];
				$this->dados['pro_codigo'] = ($this->dados['pro_codigo_busca'] == '') ? '%' : $this->dados['pro_codigo_busca'];
				$this->dados['usu_nome'] = ($this->dados['usu_nome'] == '') ? '%' : $this->dados['usu_nome'];
				$this->dados['sol_descricao_solicitacao'] = ($this->dados['sol_descricao_solicitacao'] == '') ? '%' : $this->dados['sol_descricao_solicitacao'];

				$tbsolicitacao = new TbSolicitacao();

				$dados = $tbsolicitacao->selectSolicitacoesDepartmentoTodos($this->dados);

				return($dados);

				break;
					
			case 1 : #Chamados que abri, ou seja fiz a solicita��o

				$tbsolicitacao = new TbSolicitacao();

				$this->dados['usu_codigo_solicitante'] = $_SESSION['usu_codigo'];
				$this->dados['sta_codigo'] = ($this->dados['sta_codigo'] == '') ? '%' : $this->dados['sta_codigo'];
				$this->dados['pro_codigo'] = ($this->dados['pro_codigo_busca'] == '') ? '%' : $this->dados['pro_codigo_busca'];
				$this->dados['usu_nome'] = ($this->dados['usu_nome'] == '') ? '%' : $this->dados['usu_nome'];
				$this->dados['sol_descricao_solicitacao'] = ($this->dados['sol_descricao_solicitacao'] == '') ? '%' : $this->dados['sol_descricao_solicitacao'];


				$dados = $tbsolicitacao->selectMinhasSolicitacoes($this->dados);

				return($dados);

				break;
					
			case 2 : #Chamados abertos para minha equipe

				$this->dados['dep_codigo_solicitado'] = $_SESSION['dep_codigo'];
				$this->dados['sta_codigo'] = ($this->dados['sta_codigo'] == '') ? '%' : $this->dados['sta_codigo'];
				$this->dados['pro_codigo'] = ($this->dados['pro_codigo_busca'] == '') ? '%' : $this->dados['pro_codigo_busca'];
				$this->dados['usu_nome'] = ($this->dados['usu_nome'] == '') ? '%' : $this->dados['usu_nome'];
				$this->dados['sol_descricao_solicitacao'] = ($this->dados['sol_descricao_solicitacao'] == '') ? '%' : $this->dados['sol_descricao_solicitacao'];

				$tbsolicitacao = new TbSolicitacao();

				$dados = $tbsolicitacao->selectSolicitacoesDepartmento($this->dados);

				return($dados);

				break;
					
			case 3 : #Chamados que estou atendendo, ou seja que foi passado pra mim

				$tbsolicitacao = new TbSolicitacao();

				$this->dados['usu_codigo_atendente'] = $_SESSION['usu_codigo'];
				$this->dados['sta_codigo'] = ($this->dados['sta_codigo'] == '') ? '%' : $this->dados['sta_codigo'];
				$this->dados['pro_codigo'] = ($this->dados['pro_codigo_busca'] == '') ? '%' : $this->dados['pro_codigo_busca'];
				$this->dados['usu_nome'] = ($this->dados['usu_nome'] == '') ? '%' : $this->dados['usu_nome'];
				$this->dados['sol_descricao_solicitacao'] = ($this->dados['sol_descricao_solicitacao'] == '') ? '%' : $this->dados['sol_descricao_solicitacao'];

				$dados = $tbsolicitacao->selectMinhasTarefas($this->dados);

				return($dados);

				break;
					
			default:

				break;
					
		}
	}

	public function listarChamadoSolicitante()
	{
		$tbsolicitacao = new TbSolicitacao();

		$this->dados['dep_codigo_solicitado'] = ($this->dados['dep_codigo_busca'] == '') ? '%' : $this->dados['dep_codigo_busca'];
		$this->dados['sta_codigo'] = ($this->dados['sta_codigo'] == '') ? '%' : $this->dados['sta_codigo'];
		$this->dados['pro_codigo'] = ($this->dados['pro_codigo_busca'] == '') ? '%' : $this->dados['pro_codigo_busca'];
		$this->dados['usu_nome'] = ($this->dados['usu_nome'] == '') ? '%' : $this->dados['usu_nome'];
		$this->dados['sol_descricao_solicitacao'] = ($this->dados['sol_descricao_solicitacao'] == '') ? '%' : $this->dados['sol_descricao_solicitacao'];
		$this->dados['dep_codigo'] = $_SESSION['dep_codigo'];
			
		$dados = $tbsolicitacao->selectSolicitacoesSolicitante($this->dados);

		return($dados);
	}

	public function listarProblema()
	{
		$this->dados['dep_codigo'] = ($this->dados['dep_codigo'] == '') ? '%' : $this->dados['dep_codigo'];

		$tbproblema = new TbProblema();

		$dados = $tbproblema->listarProblemaDepartamento($this->dados['dep_codigo']);

		return($dados);

	}

	public function listarChecklist()
	{

		$tbchecklist = new TbChecklist();

		$dados = $tbchecklist->listarChecklist();

		return($dados);

	}

	public function listarTempo()
	{

		$this->dados['dep_codigo'] = ($this->dados['dep_codigo'] == '') ? '%' : $this->dados['dep_codigo'];

		$tbtempoatendimento = new TbTempoAtendimento();
		$dados = $tbtempoatendimento->listarTempoAtendimento($this->dados['dep_codigo']);

		return($dados);

	}

	public function listarPrioridade()
	{

		$this->dados['dep_codigo'] = ($this->dados['dep_codigo'] == '') ? '%' : $this->dados['dep_codigo'];

		$tbprioridade = new TbPrioridade();
		$dados = $tbprioridade->listarPrioridades($this->dados['dep_codigo']);

		return($dados);

	}

	public function listarItemCheckList()
	{
		$tbitemcklist = new TbItemChecklist();

		$dados = $tbitemcklist->listarChecklist(self::getValueGet('che_codigo'));

		return($dados);
	}

	public function listarExecutarCheckList()
	{
		$tbitemcklist = new TbItemChecklist();

		$dados = $tbitemcklist->listarItemChecklist(self::getDados('che_codigo'));

		return($dados);
	}

	public function buscaRapidaChamado()
	{

		try
		{
			if($this->dados['sol_codigo'] == '')
			{
				throw new Exception('',300);

			}else{
					
				ValidarNumeros::validaNumero($this->dados['sol_codigo'],'N�mero do Chamado');
					
					
				#Instacia da classe Solicitacao
				$tbsolicitacao = new TbSolicitacao();

				#Pega o Resultado
				$solicitacao = $tbsolicitacao->getFormReceptor($this->dados['sol_codigo']);
					
				#Verifica se o chamado existe
				if(!$solicitacao['sol_codigo'])
				{
					throw new Exception('Chamado n�o encontrado');
				}
			}

			try
			{


				$tbatendimentosolicitante = new TbAtendenteSolicitacao();
				$solicitacao['usu_codigo'] = $tbatendimentosolicitante->confirmarAtendente($this->dados['sol_codigo']);

				return($solicitacao);

			} catch (PDOException $e)
			{
				throw new PDOException($e->getMessage(),$e->getCode());
			}


		} catch (Exception $e)
		{
			throw new Exception($e->getMessage(),$e->getCode());
		}


	}

	public function getRelatorioPDF()
	{

		try
		{

			#Instacia da classe Solicitacao
			$tbsolicitacao = new TbSolicitacao();

			#Pega o Resultado
			$solicitacao = $tbsolicitacao->getFormReceptor($this->getValueGet('sol_codigo'));

			#Verifica se o chamado existe
			if(!$solicitacao['sol_codigo'])
			{
				throw new Exception('Chamado n�o encontrado');
			}


			try
			{


				$tbatendimentosolicitante = new TbAtendenteSolicitacao();
				$solicitacao['usu_codigo'] = $tbatendimentosolicitante->confirmarAtendente($this->getValueGet('sol_codigo'));

				return($solicitacao);

			} catch (PDOException $e)
			{
				throw new PDOException($e->getMessage(),$e->getCode());
			}


		} catch (Exception $e)
		{
			throw new Exception($e->getMessage(),$e->getCode());
		}


	}


	#Utilizado na tela de Atendimento
	public function listarAtendimento()
	{

		try
		{
			#Instancia da Tabela de Atendimento
			$tbAtendimento = new TbAtendimento();
			
			
/* 			Removido o filtro
 * 			$this->dados['at_descricao'] = ($this->dados['at_descricao_busca'] == '') ? '%' : $this->dados['at_descricao_busca']; */
			
			$this->dados['sat_codigo'] = ($this->dados['sat_codigo'] == '') ? '%' : $this->dados['sat_codigo'];
			$this->dados['ta_codigo'] =  ($this->dados['ta_codigo_busca'] == '') ? '%' : $this->dados['ta_codigo_busca'];
			$this->dados['usu_codigo'] = ($this->dados['usu_codigo'] == '') ? '%' : $this->dados['usu_codigo'];
			$this->dados['td_codigo'] = ($this->dados['td_codigo'] == '') ? '%' : $this->dados['td_codigo'];
			$this->dados['at_paciente'] = ($this->dados['at_paciente'] == '') ? '%' : $this->dados['at_paciente'];
			
			$this->dados['ttp_codigo'] = ($this->dados['ttp_codigo'] == '') ? '%' : $this->dados['ttp_codigo'];

			$this->dados['at_localidade'] = ($this->dados['at_localidade'] == '') ? '0' : '1';

			$this->dados['at_processo'] = ($this->dados['at_processo'] == '') ? '%' : $this->dados['at_processo'];

			$this->dados['at_medicamento'] = ($this->dados['at_medicamento'] == '') ? '%' : $this->dados['at_medicamento'];	
			
			$this->dados['data1'] = ($this->dados['data1'] == '') ? $tbAtendimento->getMenorDataPendente() : ValidarDatas::dataBanco($this->dados['data1']);
			$this->dados['data2'] = ($this->dados['data2'] == '') ? date('Y-m-d') : ValidarDatas::dataBanco($this->dados['data2']);

				

				
			$dados = $tbAtendimento->listarTelaPrincial($this->dados);
				
			return($dados);
				
				
		} catch (Exception $e)
		{
			throw new Exception($e->getMessage(), $e->getCode());
		}

	}

	#Utilizado na tela de Atendimento Analitico
	public function listarAtendimentoAnalitico()
	{
	
		try
		{
			
			#Instancia da Tabela de Atendimento
			$tbAtendimento = new TbAtendimento();
		
			$this->dados['sat_codigo'] = ($this->dados['sat_codigo'] == '') ? '%' : $this->dados['sat_codigo'];
			$this->dados['ta_codigo'] =  ($this->dados['ta_codigo_busca'] == '') ? '%' : $this->dados['ta_codigo_busca'];
		
			$this->dados['data1'] = ($this->dados['data1'] == '') ? ValidarDatas::dataAnterior(date('d-m-Y'), -1) : $this->dados['data1'];
			$this->dados['data2'] = ($this->dados['data2'] == '') ? date('Y-m-d') : ValidarDatas::dataBanco($this->dados['data2']);
	
			$this->dados['data1'] = ValidarDatas::dataBanco($this->dados['data1']);
			
			
			$dados = $tbAtendimento->relatorioAtendimentoAnalitico($this->dados);
	
			return($dados);
	
	
	} catch (Exception $e){
			throw new Exception($e->getMessage(), $e->getCode());
		}
	
	}
	
	#Utilizado na tela de BuscaAtendimento
	public function listarBuscaAtendimento()
	{

		try
		{

			$tbAtendimento = new TbAtendimento();
				
			//$this->dados['at_codigo'] = 5;
				
			$dados = $tbAtendimento->getForm($this->dados['at_codigo']);
				
			//$this->dados['data1']
			//$this->dados['data2']

				
			return($dados);
				
				
		} catch (Exception $e)
		{
			throw new Exception($e->getMessage(), $e->getCode());
		}

	}

	public function getRelatorioAtendimentoPDF()
	{

		try
		{

			#Instacia da classe Solicitacao
			$tbAtendimento = new TbAtendimento();

			#Pega o Resultado
			$atendimento = $tbAtendimento->getForm($this->getValueGet('at_codigo'));

			#Verifica se o chamado existe
			if(!$atendimento['at_codigo'])
			{
				throw new Exception('Atendimento n�o encontrado');
			}


			return($atendimento);
				
		} catch (Exception $e)
		{
			throw new Exception($e->getMessage(),$e->getCode());
		}


	}

	public function getRelatorioTempoAtendimento()
	{

		try
		{

						
			#Instacia da classe Solicitacao
			$tbAtendimento = new TbAtendimento();
			
			
			$this->dados['sat_codigo'] = ($this->dados['sat_codigo'] == '') ? '3' : $this->dados['sat_codigo'];
					
			$this->dados['dataUm'] = ($this->dados['dataUm'] == '') ? $tbAtendimento->getMenorDataFinalizado() : ValidarDatas::dataBanco($this->dados['dataUm']);
			$this->dados['dataDois'] = ($this->dados['dataDois'] == '') ? date('Y-m-d') : ValidarDatas::dataBanco($this->dados['dataDois']);
			

			#Pega o Resultado
			$dados = $tbAtendimento->listarRelatioTempoAtendimento($this->dados);



			return($dados);
				
		} catch (Exception $e)
		{
			throw new Exception($e->getMessage(),$e->getCode());
		}


	}

	public function getRelatorioStatusAtendimento()
	{

		try
		{
			
			#Instacia da classe Solicitacao
			$tbAtendimento = new TbAtendimento();			
					
			$this->dados['dataUm'] = ($this->dados['dataUm'] == '') ? $tbAtendimento->getMenorDataFinalizado() : ValidarDatas::dataBanco($this->dados['dataUm']);
			$this->dados['dataDois'] = ($this->dados['dataDois'] == '') ? date('Y-m-d') : ValidarDatas::dataBanco($this->dados['dataDois']);
			

			#Pega o Resultado
			$dados = $tbAtendimento->listarRelatioStatusAtendimento($this->dados);



			return($dados);
				
		} catch (Exception $e)
		{
			throw new Exception($e->getMessage(),$e->getCode());
		}


	}
	
	public function getRelatorioTipoAtendimentoStatus()
	{
	
		try{
			
		#Instacia da classe Solicitacao
		$tbAtendimento = new TbAtendimento();
			
		$this->dados['dataUm'] = ($this->dados['dataUm'] == '') ? $tbAtendimento->getMenorDataFinalizado() : ValidarDatas::dataBanco($this->dados['dataUm']);
		$this->dados['dataDois'] = ($this->dados['dataDois'] == '') ? date('Y-m-d') : ValidarDatas::dataBanco($this->dados['dataDois']);
		
		#Pega o Resultado
		$dados = $tbAtendimento->listarAtendimentoPorTipoStatus($this->dados);
	
		return($dados);
	
		} catch (Exception $e){
			throw new Exception($e->getMessage(),$e->getCode());
		  }
	}
	
	public function listarTipoResposta()
	{
	
		try{
				
			$tbTipoResposta = new TbTipoResposta();
			
			$this->dados['at_codigo'] = ($this->dados['at_codigo'] == '') ? '%' : $this->dados['at_codigo'];
	
			#Pega o Resultado
			$dados = $tbTipoResposta->listarTipoResposta($this->dados);
	
			return($dados);
	
		} catch (Exception $e){
		throw new Exception($e->getMessage(),$e->getCode());
		}
	}
	
	public function listarTipoApontamento()
	{
	
		try{
	
 			$tbTipoApontamento = new TbTipoApontamento();
				
			$this->dados['at_codigo'] = ($this->dados['at_codigo'] == '') ? '%' : $this->dados['at_codigo'];
	
			#Pega o Resultado
			$dados = $tbTipoApontamento->listarTipoApontamento($this->dados);

			return($dados);
 
		} catch (Exception $e){
		throw new Exception($e->getMessage(),$e->getCode());
		}
	}

	public function listarTipoProcesso()
	{
	
		try{
	
			$tbTipoProcesso = new TbTipoProcesso();
	
			//$this->dados['at_codigo'] = ($this->dados['at_codigo'] == '') ? '%' : $this->dados['at_codigo'];
	
			#Pega o Resultado
			$dados = $tbTipoProcesso->listarCadastroTipoProcesso();
	
			return($dados);
	
		} catch (Exception $e){
			throw new Exception($e->getMessage(),$e->getCode());
		}
	}
	
}
?>