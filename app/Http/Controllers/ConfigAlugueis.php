<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\DisabledColumns;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\Office;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Inertia\Inertia;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Storage;
use stdClass;

class ConfigAlugueis extends Controller
{
	public function index(Request $request)
	{
		$Modulo = "ConfigAlugueis";

		$permUser = Auth::user()->hasPermissionTo("list.ConfigAlugueis");

		if (!$permUser) {
			return redirect()->route("list.Dashboard", ["id" => "1"]);
		}

		try {



			$data = Session::all();

			if (!isset($data["ConfigAlugueis"]) || empty($data["ConfigAlugueis"])) {
				session(["ConfigAlugueis" => array("status" => "0", "orderBy" => array("column" => "created_at", "sorting" => "1"), "limit" => "10")]);
				$data = Session::all();
			}

			$Filtros = new Security;
			if ($request->input()) {
				$Limpar = false;
				if ($request->input("limparFiltros") == true) {
					$Limpar = true;
				}

				$arrayFilter = $Filtros->TratamentoDeFiltros($request->input(), $Limpar, ["ConfigAlugueis"]);
				if ($arrayFilter) {
					session(["ConfigAlugueis" => $arrayFilter]);
					$data = Session::all();
				}
			}


			$columnsTable = DisabledColumns::whereRouteOfList("list.ConfigAlugueis")
				->first()
				?->columns;

			$ConfigAlugueis = DB::table("config_alugueis")

				->select(DB::raw("config_alugueis.*, DATE_FORMAT(config_alugueis.created_at, '%d/%m/%Y - %H:%i:%s') as data_final
			
			"));

			$funcionarios = DB::table('config_funcionarios')->where('deleted', '0')->get();

			$clientes = DB::table('config_clientes')->where('deleted', '0')->get();

			$veiculos = DB::table('config_veiculos')->where('deleted', '0')->get();

			if (isset($data["ConfigAlugueis"]["orderBy"])) {
				$Coluna = $data["ConfigAlugueis"]["orderBy"]["column"];
				$ConfigAlugueis =  $ConfigAlugueis->orderBy("config_alugueis.$Coluna", $data["ConfigAlugueis"]["orderBy"]["sorting"] ? "asc" : "desc");
			} else {
				$ConfigAlugueis =  $ConfigAlugueis->orderBy("config_alugueis.created_at", "desc");
			}

			//MODELO DE FILTRO PARA VOCE COLOCAR AQUI, PARA CADA COLUNA DO BANCO DE DADOS DEVERÁ TER UM IF PARA APLICAR O FILTRO, EXCLUIR O FILTRO DE ID, DELETED E UPDATED_AT
			if (isset($data["ConfigAlugueis"]["cliente_id"])) {
				$AplicaFiltro = $data["ConfigAlugueis"]["cliente_id"];
				$ConfigAlugueis = $ConfigAlugueis->Where("config_alugueis.cliente_id",  "like", "%" . $AplicaFiltro . "%");
			}

			if (isset($data["ConfigAlugueis"]["funcionario_id"])) {
				$AplicaFiltro = $data["ConfigAlugueis"]["funcionario_id"];
				$ConfigAlugueis = $ConfigAlugueis->Where("config_alugueis.funcionario_id",  "like", "%" . $AplicaFiltro . "%");
			}

			if (isset($data["ConfigAlugueis"]["veiculo_id"])) {
				$AplicaFiltro = $data["ConfigAlugueis"]["veiculo_id"];
				$ConfigAlugueis = $ConfigAlugueis->Where("config_alugueis.veiculo_id",  "like", "%" . $AplicaFiltro . "%");
			}

			if (isset($data["ConfigAlugueis"]["data_inicio"])) {
				$AplicaFiltro = $data["ConfigAlugueis"]["data_inicio"];
				$ConfigAlugueis = $ConfigAlugueis->Where("config_alugueis.data_inicio",  "like", "%" . $AplicaFiltro . "%");
			}

			if (isset($data["ConfigAlugueis"]["data_fim"])) {
				$AplicaFiltro = $data["ConfigAlugueis"]["data_fim"];
				$ConfigAlugueis = $ConfigAlugueis->Where("config_alugueis.data_fim",  "like", "%" . $AplicaFiltro . "%");
			}

			if (isset($data["ConfigAlugueis"]["data_devolucao"])) {
				$AplicaFiltro = $data["ConfigAlugueis"]["data_devolucao"];
				$ConfigAlugueis = $ConfigAlugueis->Where("config_alugueis.data_devolucao",  "like", "%" . $AplicaFiltro . "%");
			}

			if (isset($data["ConfigAlugueis"]["valor_diaria"])) {
				$AplicaFiltro = $data["ConfigAlugueis"]["valor_diaria"];
				$ConfigAlugueis = $ConfigAlugueis->Where("config_alugueis.valor_diaria",  "like", "%" . $AplicaFiltro . "%");
			}

			if (isset($data["ConfigAlugueis"]["valor_total"])) {
				$AplicaFiltro = $data["ConfigAlugueis"]["valor_total"];
				$ConfigAlugueis = $ConfigAlugueis->Where("config_alugueis.valor_total",  "like", "%" . $AplicaFiltro . "%");
			}

			if (isset($data["ConfigAlugueis"]["situacao"])) {
				$AplicaFiltro = $data["ConfigAlugueis"]["situacao"];
				$ConfigAlugueis = $ConfigAlugueis->Where("config_alugueis.situacao",  "like", "%" . $AplicaFiltro . "%");
			}

			if (isset($data["ConfigAlugueis"]["observacao"])) {
				$AplicaFiltro = $data["ConfigAlugueis"]["observacao"];
				$ConfigAlugueis = $ConfigAlugueis->Where("config_alugueis.observacao",  "like", "%" . $AplicaFiltro . "%");
			}

			if(isset($data["ConfigAlugueis"]["status"])){				
				$AplicaFiltro = $data["ConfigAlugueis"]["status"];			
				$ConfigAlugueis = $ConfigAlugueis->Where("config_alugueis.status",  "like", "%" . $AplicaFiltro . "%");			
			}

			if(isset($data["ConfigAlugueis"]["created_at"])){				
				$AplicaFiltro = $data["ConfigAlugueis"]["created_at"];			
				$ConfigAlugueis = $ConfigAlugueis->Where("config_alugueis.created_at",  "like", "%" . $AplicaFiltro . "%");			
			}
			


			$ConfigAlugueis = $ConfigAlugueis->where("config_alugueis.deleted", "0");

			$ConfigAlugueis = $ConfigAlugueis->paginate(($data["ConfigAlugueis"]["limit"] ?: 10))
				->appends(["page", "orderBy", "searchBy", "limit"]);

			$Acao = "Acessou a listagem do Módulo de ConfigAlugueis";
			$Logs = new logs;
			$Registra = $Logs->RegistraLog(1, $Modulo, $Acao);
			$Registros = $this->Registros();

			return Inertia::render("ConfigAlugueis/List", [
				"columnsTable" => $columnsTable,
				"ConfigAlugueis" => $ConfigAlugueis,
				'funcionarios' => $funcionarios,
				'clientes' => $clientes,
				'veiculos' => $veiculos,
				"Filtros" => $data["ConfigAlugueis"],
				"Registros" => $Registros,

			]);
		} catch (Exception $e) {

			$Error = $e->getMessage();
			$Error = explode("MESSAGE:", $Error);


			$Pagina = $_SERVER["REQUEST_URI"];

			$Erro = $Error[0];
			$Erro_Completo = $e->getMessage();
			$LogsErrors = new logsErrosController;
			$Registra = $LogsErrors->RegistraErro($Pagina, $Modulo, $Erro, $Erro_Completo);
			abort(403, "Erro localizado e enviado ao LOG de Erros");
		}
	}

	public function Registros()
	{

		$mes = date("m");
		$Total = DB::table("config_alugueis")
			->where("config_alugueis.deleted", "0")
			->count();

		$Ativos = DB::table("config_alugueis")
			->where("config_alugueis.deleted", "0")
			->where("config_alugueis.status", "0")
			->count();

		$Inativos = DB::table("config_alugueis")
			->where("config_alugueis.deleted", "0")
			->where("config_alugueis.status", "1")
			->count();

		$EsseMes = DB::table("config_alugueis")
			->where("config_alugueis.deleted", "0")
			->whereMonth("config_alugueis.created_at", $mes)
			->count();


		$data = new stdClass;
		$data->total = number_format($Total, 0, ",", ".");
		$data->ativo = number_format($Ativos, 0, ",", ".");
		$data->inativo = number_format($Inativos, 0, ",", ".");
		$data->mes = number_format($EsseMes, 0, ",", ".");
		return $data;
	}

	public function create()
	{
		$Modulo = "ConfigAlugueis";
		$permUser = Auth::user()->hasPermissionTo("create.ConfigAlugueis");

		if (!$permUser) {
			return redirect()->route("list.Dashboard", ["id" => "1"]);
		}
		try {



			$Acao = "Abriu a Tela de Cadastro do Módulo de ConfigAlugueis";
			$Logs = new logs;
			$Registra = $Logs->RegistraLog(1, $Modulo, $Acao);

			$funcionarios = DB::table('config_funcionarios')->where('deleted', '0')->get();

			$clientes = DB::table('config_clientes')->where('deleted', '0')->get();

			$veiculos = DB::table('config_veiculos')->where('deleted', '0')->get();

			return Inertia::render("ConfigAlugueis/Create", [
				'funcionarios' => $funcionarios,
				'clientes' => $clientes,
				'veiculos' => $veiculos,
			]);
		} catch (Exception $e) {

			$Error = $e->getMessage();
			$Error = explode("MESSAGE:", $Error);


			$Pagina = $_SERVER["REQUEST_URI"];

			$Erro = $Error[0];
			$Erro_Completo = $e->getMessage();
			$LogsErrors = new logsErrosController;
			$Registra = $LogsErrors->RegistraErro($Pagina, $Modulo, $Erro, $Erro_Completo);
			abort(403, "Erro localizado e enviado ao LOG de Erros");
		}
	}

	public function return_id($id)
	{
		$ConfigAlugueis = DB::table("config_alugueis");
		$ConfigAlugueis = $ConfigAlugueis->where("deleted", "0");
		$ConfigAlugueis = $ConfigAlugueis->where("token", $id)->first();

		return $ConfigAlugueis->id;
	}

	public function store(Request $request)
	{
		$Modulo = "ConfigAlugueis";

		$permUser = Auth::user()->hasPermissionTo("create.ConfigAlugueis");

		if (!$permUser) {
			return redirect()->route("list.Dashboard", ["id" => "1"]);
		}

		try {

			$data = Session::all();

			$save = new stdClass;
			//MODELO DE INSERT PARA VOCE FAZER COM TODAS AS COLUNAS DO BANCO DE DADOS, MENOS ID, DELETED E UPDATED_AT
			$save->cliente_id = $request->cliente_id;
			$save->funcionario_id = $request->funcionario_id;
			$save->veiculo_id = $request->veiculo_id;
			$save->data_inicio = $request->data_inicio;
			$save->data_fim = $request->data_fim;
			$save->data_devolucao = $request->data_devolucao;
			$save->valor_diaria = $request->valor_diaria;
			$save->valor_total = $request->valor_total;
			$save->situacao = $request->situacao;
			$save->observacao = $request->observacao;

			//ESSAS AQUI SEMPRE TERÃO POR PADRÃO
			$save->status = $request->status;
			$save->token = md5(date("Y-m-d H:i:s") . rand(0, 999999999));

			$save = collect($save)->toArray();
			DB::table("config_alugueis")
				->insert($save);
			$lastId = DB::getPdo()->lastInsertId();

			$Acao = "Inseriu um Novo Registro no Módulo de ConfigAlugueis";
			$Logs = new logs;
			$Registra = $Logs->RegistraLog(2, $Modulo, $Acao, $lastId);

			return redirect()->route("list.ConfigAlugueis");
		} catch (Exception $e) {

			$Error = $e->getMessage();
			$Error = explode("MESSAGE:", $Error);


			$Pagina = $_SERVER["REQUEST_URI"];

			$Erro = $Error[0];
			$Erro_Completo = $e->getMessage();
			$LogsErrors = new logsErrosController;
			$Registra = $LogsErrors->RegistraErro($Pagina, $Modulo, $Erro, $Erro_Completo);
			abort(403, "Erro localizado e enviado ao LOG de Erros");
		}

		return redirect()->route("list.ConfigAlugueis");
	}




	public function edit($IDConfigAlugueis)
	{
		$Modulo = "ConfigAlugueis";

		$permUser = Auth::user()->hasPermissionTo("edit.ConfigAlugueis");

		if (!$permUser) {
			return redirect()->route("list.Dashboard", ["id" => "1"]);
		}

		try {

			$AcaoID = $this->return_id($IDConfigAlugueis);

			$ConfigAlugueis = DB::table("config_alugueis")
				->where("token", $IDConfigAlugueis)
				->first();

			$Acao = "Abriu a Tela de Edição do Módulo de ConfigAlugueis";
			$Logs = new logs;
			$Registra = $Logs->RegistraLog(1, $Modulo, $Acao, $AcaoID);

			$funcionarios = DB::table('config_funcionarios')->where('deleted', '0')->get();

			$clientes = DB::table('config_clientes')->where('deleted', '0')->get();

			$veiculos = DB::table('config_veiculos')->where('deleted', '0')->get();

			return Inertia::render("ConfigAlugueis/Edit", [
				"ConfigAlugueis" => $ConfigAlugueis,
				'funcionarios' => $funcionarios,
				'clientes' => $clientes,
				'veiculos' => $veiculos
			]);

		} catch (Exception $e) {

			$Error = $e->getMessage();
			$Error = explode("MESSAGE:", $Error);

			$Pagina = $_SERVER["REQUEST_URI"];

			$Erro = $Error[0];
			$Erro_Completo = $e->getMessage();
			$LogsErrors = new logsErrosController;
			$Registra = $LogsErrors->RegistraErro($Pagina, $Modulo, $Erro, $Erro_Completo);
			abort(403, "Erro localizado e enviado ao LOG de Erros");
		}
	}


	public function update(Request $request, $id)
	{

		$Modulo = "ConfigAlugueis";

		$permUser = Auth::user()->hasPermissionTo("edit.ConfigAlugueis");

		if (!$permUser) {
			return redirect()->route("list.Dashboard", ["id" => "1"]);
		}


		try {

			$AcaoID = $this->return_id($id);

			$save = new stdClass;

			//MODELO DE INSERT PARA VOCE FAZER COM TODAS AS COLUNAS DO BANCO DE DADOS, MENOS ID, DELETED E UPDATED_AT
			$save->cliente_id = $request->cliente_id;
			$save->funcionario_id = $request->funcionario_id;
			$save->veiculo_id = $request->veiculo_id;
			$save->data_inicio = $request->data_inicio;
			$save->data_fim = $request->data_fim;
			$save->data_devolucao = $request->data_devolucao;
			$save->valor_diaria = $request->valor_diaria;
			$save->valor_total = $request->valor_total;
			$save->situacao = $request->situacao;
			$save->observacao = $request->observacao;

			//ESSAS AQUI SEMPRE TERÃO POR PADRÃO
			$save->status = $request->status;

			$save = collect($save)->toArray();
			DB::table("config_alugueis")
				->where("token", $id)
				->update($save);



			$Acao = "Editou um registro no Módulo de ConfigAlugueis";
			$Logs = new logs;
			$Registra = $Logs->RegistraLog(3, $Modulo, $Acao, $AcaoID);

			return redirect()->route("list.ConfigAlugueis");
		} catch (Exception $e) {

			$Error = $e->getMessage();
			$Error = explode("MESSAGE:", $Error);

			$Pagina = $_SERVER["REQUEST_URI"];

			$Erro = $Error[0];
			$Erro_Completo = $e->getMessage();
			$LogsErrors = new logsErrosController;
			$Registra = $LogsErrors->RegistraErro($Pagina, $Modulo, $Erro, $Erro_Completo);
			abort(403, "Erro localizado e enviado ao LOG de Erros");
		}
	}





	public function delete($IDConfigAlugueis)
	{
		$Modulo = "ConfigAlugueis";

		$permUser = Auth::user()->hasPermissionTo("delete.ConfigAlugueis");

		if (!$permUser) {
			return redirect()->route("list.Dashboard", ["id" => "1"]);
		}

		try {

			$AcaoID = $this->return_id($IDConfigAlugueis);

			DB::table("config_alugueis")
				->where("token", $IDConfigAlugueis)
				->update([
					"deleted" => "1",
				]);



			$Acao = "Excluiu um registro no Módulo de ConfigAlugueis";
			$Logs = new logs;
			$Registra = $Logs->RegistraLog(4, $Modulo, $Acao, $AcaoID);

			return redirect()->route("list.ConfigAlugueis");
		} catch (Exception $e) {

			$Error = $e->getMessage();
			$Error = explode("MESSAGE:", $Error);

			$Pagina = $_SERVER["REQUEST_URI"];

			$Erro = $Error[0];
			$Erro_Completo = $e->getMessage();
			$LogsErrors = new logsErrosController;
			$Registra = $LogsErrors->RegistraErro($Pagina, $Modulo, $Erro, $Erro_Completo);

			abort(403, "Erro localizado e enviado ao LOG de Erros");
		}
	}



	public function deleteSelected($IDConfigAlugueis = null)
	{
		$Modulo = "ConfigAlugueis";

		$permUser = Auth::user()->hasPermissionTo("delete.ConfigAlugueis");

		if (!$permUser) {
			return redirect()->route("list.Dashboard", ["id" => "1"]);
		}

		try {

			$IDsRecebidos = explode(",", $IDConfigAlugueis);
			$total = count(array_filter($IDsRecebidos));
			if ($total > 0) {
				foreach ($IDsRecebidos as $id) {
					$AcaoID = $this->return_id($id);
					DB::table("config_alugueis")
						->where("token", $id)
						->update([
							"deleted" => "1",
						]);
					$Acao = "Excluiu um registro no Módulo de ConfigAlugueis";
					$Logs = new logs;
					$Registra = $Logs->RegistraLog(4, $Modulo, $Acao, $AcaoID);
				}
			}

			return redirect()->route("list.ConfigAlugueis");
		} catch (Exception $e) {

			$Error = $e->getMessage();
			$Error = explode("MESSAGE:", $Error);

			$Pagina = $_SERVER["REQUEST_URI"];

			$Erro = $Error[0];
			$Erro_Completo = $e->getMessage();
			$LogsErrors = new logsErrosController;
			$Registra = $LogsErrors->RegistraErro($Pagina, $Modulo, $Erro, $Erro_Completo);

			abort(403, "Erro localizado e enviado ao LOG de Erros");
		}
	}

	public function deletarTodos()
	{
		$Modulo = "ConfigAlugueis";

		$permUser = Auth::user()->hasPermissionTo("delete.ConfigAlugueis");

		if (!$permUser) {
			return redirect()->route("list.Dashboard", ["id" => "1"]);
		}

		try {

			DB::table("config_alugueis")
				->update([
					"deleted" => "1",
				]);
			$Acao = "Excluiu TODOS os registros no Módulo de ConfigAlugueis";
			$Logs = new logs;
			$Registra = $Logs->RegistraLog(4, $Modulo, $Acao, 0);



			return redirect()->route("list.ConfigAlugueis");
		} catch (Exception $e) {

			$Error = $e->getMessage();
			$Error = explode("MESSAGE:", $Error);

			$Pagina = $_SERVER["REQUEST_URI"];

			$Erro = $Error[0];
			$Erro_Completo = $e->getMessage();
			$LogsErrors = new logsErrosController;
			$Registra = $LogsErrors->RegistraErro($Pagina, $Modulo, $Erro, $Erro_Completo);

			abort(403, "Erro localizado e enviado ao LOG de Erros");
		}
	}

	public function RestaurarTodos()
	{
		$Modulo = "ConfigAlugueis";

		$permUser = Auth::user()->hasPermissionTo("delete.ConfigAlugueis");

		if (!$permUser) {
			return redirect()->route("list.Dashboard", ["id" => "1"]);
		}

		try {

			DB::table("config_alugueis")
				->update([
					"deleted" => "0",
				]);
			$Acao = "Restaurou TODOS os registros no Módulo de ConfigAlugueis";
			$Logs = new logs;
			$Registra = $Logs->RegistraLog(4, $Modulo, $Acao, 0);



			return redirect()->route("list.ConfigAlugueis");
		} catch (Exception $e) {

			$Error = $e->getMessage();
			$Error = explode("MESSAGE:", $Error);

			$Pagina = $_SERVER["REQUEST_URI"];

			$Erro = $Error[0];
			$Erro_Completo = $e->getMessage();
			$LogsErrors = new logsErrosController;
			$Registra = $LogsErrors->RegistraErro($Pagina, $Modulo, $Erro, $Erro_Completo);

			abort(403, "Erro localizado e enviado ao LOG de Erros");
		}
	}

	public function DadosRelatorio()
	{
		$data = Session::all();

		$ConfigAlugueis = DB::table("config_alugueis")

			->select(DB::raw("config_alugueis.*, DATE_FORMAT(config_alugueis.created_at, '%d/%m/%Y - %H:%i:%s') as data_final
			 
			"))
			->where("config_alugueis.deleted", "0");

		//MODELO DE FILTRO PARA VOCE COLOCAR AQUI, PARA CADA COLUNA DO BANCO DE DADOS DEVERÁ TER UM IF PARA APLICAR O FILTRO, EXCLUIR O FILTRO DE ID, DELETED E UPDATED_AT

		if (isset($data["ConfigAlugueis"]["cliente_id"])) {
			$AplicaFiltro = $data["ConfigAlugueis"]["cliente_id"];
			$ConfigAlugueis = $ConfigAlugueis->Where("config_alugueis.cliente_id",  "like", "%" . $AplicaFiltro . "%");
		}

		if (isset($data["ConfigAlugueis"]["funcionario_id"])) {
			$AplicaFiltro = $data["ConfigAlugueis"]["funcionario_id"];
			$ConfigAlugueis = $ConfigAlugueis->Where("config_alugueis.funcionario_id",  "like", "%" . $AplicaFiltro . "%");
		}

		if (isset($data["ConfigAlugueis"]["veiculo_id"])) {
			$AplicaFiltro = $data["ConfigAlugueis"]["veiculo_id"];
			$ConfigAlugueis = $ConfigAlugueis->Where("config_alugueis.veiculo_id",  "like", "%" . $AplicaFiltro . "%");
		}

		if (isset($data["ConfigAlugueis"]["data_inicio"])) {
			$AplicaFiltro = $data["ConfigAlugueis"]["data_inicio"];
			$ConfigAlugueis = $ConfigAlugueis->Where("config_alugueis.data_inicio",  "like", "%" . $AplicaFiltro . "%");
		}

		if (isset($data["ConfigAlugueis"]["data_fim"])) {
			$AplicaFiltro = $data["ConfigAlugueis"]["data_fim"];
			$ConfigAlugueis = $ConfigAlugueis->Where("config_alugueis.data_fim",  "like", "%" . $AplicaFiltro . "%");
		}

		if (isset($data["ConfigAlugueis"]["data_devolucao"])) {
			$AplicaFiltro = $data["ConfigAlugueis"]["data_devolucao"];
			$ConfigAlugueis = $ConfigAlugueis->Where("config_alugueis.data_devolucao",  "like", "%" . $AplicaFiltro . "%");
		}

		if (isset($data["ConfigAlugueis"]["valor_diaria"])) {
			$AplicaFiltro = $data["ConfigAlugueis"]["valor_diaria"];
			$ConfigAlugueis = $ConfigAlugueis->Where("config_alugueis.valor_diaria",  "like", "%" . $AplicaFiltro . "%");
		}

		if (isset($data["ConfigAlugueis"]["valor_total"])) {
			$AplicaFiltro = $data["ConfigAlugueis"]["valor_total"];
			$ConfigAlugueis = $ConfigAlugueis->Where("config_alugueis.valor_total",  "like", "%" . $AplicaFiltro . "%");
		}

		if (isset($data["ConfigAlugueis"]["situacao"])) {
			$AplicaFiltro = $data["ConfigAlugueis"]["situacao"];
			$ConfigAlugueis = $ConfigAlugueis->Where("config_alugueis.situacao",  "like", "%" . $AplicaFiltro . "%");
		}

		if (isset($data["ConfigAlugueis"]["observacao"])) {
			$AplicaFiltro = $data["ConfigAlugueis"]["observacao"];
			$ConfigAlugueis = $ConfigAlugueis->Where("config_alugueis.observacao",  "like", "%" . $AplicaFiltro . "%");
		}
			

		$ConfigAlugueis = $ConfigAlugueis->get();

		$Dadosconfig_alugueis = [];
		foreach ($ConfigAlugueis as $config_alugueiss) {
			if ($config_alugueiss->status == "0") {
				$config_alugueiss->status = "Ativo";
			}
			if ($config_alugueiss->status == "1") {
				$config_alugueiss->status = "Inativo";
			}
			$Dadosconfig_alugueis[] = [
				//MODELO DE CA,MPO PARA VOCE COLOCAR AQUI, PARA CADA COLUNA DO BANCO DE DADOS DEVERÁ TER UM, EXCLUIR O ID, DELETED E UPDATED_AT
				'nome' => $config_alugueiss->nome,				
			
			];
		}
		return $Dadosconfig_alugueis;
	}

	public function exportarRelatorioExcel()
	{

		$permUser = Auth::user()->hasPermissionTo("create.ConfigAlugueis");

		if (!$permUser) {
			return redirect()->route("list.Dashboard", ["id" => "1"]);
		}


		$filePath = "Relatorio_ConfigAlugueis.xlsx";

		if (Storage::disk("public")->exists($filePath)) {
			Storage::disk("public")->delete($filePath);
			// Arquivo foi deletado com sucesso
		}

		$cabecalhoAba1 = array('nome', 'placa', 'modelo', 'ano', 'cor', 'valor_compra', 'observacao', 'status', 'Data de Cadastro');

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		$config_alugueis = $this->DadosRelatorio();

		// Define o título da primeira aba
		$spreadsheet->setActiveSheetIndex(0);
		$spreadsheet->getActiveSheet()->setTitle("ConfigAlugueis");

		// Adiciona os cabeçalhos da tabela na primeira aba
		$spreadsheet->getActiveSheet()->fromArray($cabecalhoAba1, null, "A1");

		// Adiciona os dados da tabela na primeira aba
		$spreadsheet->getActiveSheet()->fromArray($config_alugueis, null, "A2");

		// Definindo a largura automática das colunas na primeira aba
		foreach ($spreadsheet->getActiveSheet()->getColumnDimensions() as $col) {
			$col->setAutoSize(true);
		}

		// Habilita a funcionalidade de filtro para as células da primeira aba
		$spreadsheet->getActiveSheet()->setAutoFilter($spreadsheet->getActiveSheet()->calculateWorksheetDimension());


		// Define o nome do arquivo	
		$nomeArquivo = "Relatorio_ConfigAlugueis.xlsx";
		// Cria o arquivo
		$writer = IOFactory::createWriter($spreadsheet, "Xlsx");
		$writer->save($nomeArquivo);
		$barra = "'/'";
		$barra = str_replace("'", "", $barra);
		$writer->save(storage_path("app" . $barra . "relatorio" . $barra . $nomeArquivo));

		return redirect()->route("download2.files", ["path" => $nomeArquivo]);
	}
}
