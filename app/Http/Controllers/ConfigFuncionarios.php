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

class ConfigFuncionarios extends Controller
{
	public function index(Request $request)
	{
		$Modulo = "ConfigFuncionarios";

		$permUser = Auth::user()->hasPermissionTo("list.ConfigFuncionarios");

		if (!$permUser) {
			return redirect()->route("list.Dashboard", ["id" => "1"]);
		}

		try {



			$data = Session::all();

			if (!isset($data["ConfigFuncionarios"]) || empty($data["ConfigFuncionarios"])) {
				session(["ConfigFuncionarios" => array("status" => "0", "orderBy" => array("column" => "created_at", "sorting" => "1"), "limit" => "10")]);
				$data = Session::all();
			}

			$Filtros = new Security;
			if ($request->input()) {
				$Limpar = false;
				if ($request->input("limparFiltros") == true) {
					$Limpar = true;
				}

				$arrayFilter = $Filtros->TratamentoDeFiltros($request->input(), $Limpar, ["ConfigFuncionarios"]);
				if ($arrayFilter) {
					session(["ConfigFuncionarios" => $arrayFilter]);
					$data = Session::all();
				}
			}


			$columnsTable = DisabledColumns::whereRouteOfList("list.ConfigFuncionarios")
				->first()
				?->columns;

			$ConfigFuncionarios = DB::table("config_funcionarios")

				->select(DB::raw("config_funcionarios.*, DATE_FORMAT(config_funcionarios.created_at, '%d/%m/%Y - %H:%i:%s') as data_final
			
			"));

			if (isset($data["ConfigFuncionarios"]["orderBy"])) {
				$Coluna = $data["ConfigFuncionarios"]["orderBy"]["column"];
				$ConfigFuncionarios =  $ConfigFuncionarios->orderBy("config_funcionarios.$Coluna", $data["ConfigFuncionarios"]["orderBy"]["sorting"] ? "asc" : "desc");
			} else {
				$ConfigFuncionarios =  $ConfigFuncionarios->orderBy("config_funcionarios.created_at", "desc");
			}

			//MODELO DE FILTRO PARA VOCE COLOCAR AQUI, PARA CADA COLUNA DO BANCO DE DADOS DEVERÁ TER UM IF PARA APLICAR O FILTRO, EXCLUIR O FILTRO DE ID, DELETED E UPDATED_AT

			if (isset($data["ConfigFuncionarios"]["nome"])) {
				$AplicaFiltro = $data["ConfigFuncionarios"]["nome"];
				$ConfigFuncionarios = $ConfigFuncionarios->Where("config_funcionarios.nome",  "like", "%" . $AplicaFiltro . "%");
			}

			if (isset($data["ConfigFuncionarios"]["cpf"])) {
				$AplicaFiltro = $data["ConfigFuncionarios"]["cpf"];
				$ConfigFuncionarios = $ConfigFuncionarios->Where("config_funcionarios.cpf",  "like", "%" . $AplicaFiltro . "%");
			}

			if (isset($data["ConfigFuncionarios"]["cargo"])) {
				$AplicaFiltro = $data["ConfigFuncionarios"]["cargo"];
				$ConfigFuncionarios = $ConfigFuncionarios->Where("config_funcionarios.cargo",  "like", "%" . $AplicaFiltro . "%");
			}

			if (isset($data["ConfigFuncionarios"]["email"])) {
				$AplicaFiltro = $data["ConfigFuncionarios"]["email"];
				$ConfigFuncionarios = $ConfigFuncionarios->Where("config_funcionarios.email",  "like", "%" . $AplicaFiltro . "%");
			}

			if (isset($data["ConfigFuncionarios"]["telefone"])) {
				$AplicaFiltro = $data["ConfigFuncionarios"]["telefone"];
				$ConfigFuncionarios = $ConfigFuncionarios->Where("config_funcionarios.telefone",  "like", "%" . $AplicaFiltro . "%");
			}

			if (isset($data["ConfigFuncionarios"]["status"])) {
				$AplicaFiltro = $data["ConfigFuncionarios"]["status"];
				$ConfigFuncionarios = $ConfigFuncionarios->Where("config_funcionarios.status",  "like", "%" . $AplicaFiltro . "%");
			}


			$ConfigFuncionarios = $ConfigFuncionarios->where("config_funcionarios.deleted", "0");

			$ConfigFuncionarios = $ConfigFuncionarios->paginate(($data["ConfigFuncionarios"]["limit"] ?: 10))
				->appends(["page", "orderBy", "searchBy", "limit"]);

			$Acao = "Acessou a listagem do Módulo de ConfigFuncionarios";
			$Logs = new logs;
			$Registra = $Logs->RegistraLog(1, $Modulo, $Acao);
			$Registros = $this->Registros();

			return Inertia::render("ConfigFuncionarios/List", [
				"columnsTable" => $columnsTable,
				"ConfigFuncionarios" => $ConfigFuncionarios,

				"Filtros" => $data["ConfigFuncionarios"],
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
		$Total = DB::table("config_funcionarios")
			->where("config_funcionarios.deleted", "0")
			->count();

		$Ativos = DB::table("config_funcionarios")
			->where("config_funcionarios.deleted", "0")
			->where("config_funcionarios.status", "0")
			->count();

		$Inativos = DB::table("config_funcionarios")
			->where("config_funcionarios.deleted", "0")
			->where("config_funcionarios.status", "1")
			->count();

		$EsseMes = DB::table("config_funcionarios")
			->where("config_funcionarios.deleted", "0")
			->whereMonth("config_funcionarios.created_at", $mes)
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
		$Modulo = "ConfigFuncionarios";
		$permUser = Auth::user()->hasPermissionTo("create.ConfigFuncionarios");

		if (!$permUser) {
			return redirect()->route("list.Dashboard", ["id" => "1"]);
		}
		try {



			$Acao = "Abriu a Tela de Cadastro do Módulo de ConfigFuncionarios";
			$Logs = new logs;
			$Registra = $Logs->RegistraLog(1, $Modulo, $Acao);

			return Inertia::render("ConfigFuncionarios/Create", []);
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
		$ConfigFuncionarios = DB::table("config_funcionarios");
		$ConfigFuncionarios = $ConfigFuncionarios->where("deleted", "0");
		$ConfigFuncionarios = $ConfigFuncionarios->where("token", $id)->first();

		return $ConfigFuncionarios->id;
	}

	public function store(Request $request)
	{
		$Modulo = "ConfigFuncionarios";

		$permUser = Auth::user()->hasPermissionTo("create.ConfigFuncionarios");

		if (!$permUser) {
			return redirect()->route("list.Dashboard", ["id" => "1"]);
		}

		try {


			$data = Session::all();

			$url = null;
			$extensions = "png,jpg,jpeg";
			$formatos_liberados = explode(",", $extensions);
			if ($request->hasFile('anexo')) {
				if($request->file('anexo')->isValid()){
					$ext = $request->file('anexo')->extension();
					if (in_array($ext, $formatos_liberados)) {
						$anexo = $request->file('anexo')->store("ConfigFuncionarios/1");
						$nome = md5(date("Y-m-d H:i:s") . rand(0, 999999999)) . "." . $ext;
						Storage::move($anexo, "ConfigFuncionarios/1/" . $nome);
						$url = "ConfigFuncionarios/1/" . $nome;
						$url = str_replace("/", "-", $url);
					} else {
						$ext = $request->file('anexo')->extension();
						return redirect()->route("form.store.ConfigFuncionarios")->withErrors(["msg" => "Atenção o arquivo enviado foi: {$ext}, por favor envie um arquivo no formato {$extensions}"]);
					}
				}else {
					$ext = $request->file('anexo')->extension();
					return redirect()->route("form.store.ConfigFuncionarios")->withErrors(["msg" => "Atenção o arquivo enviado foi: {$ext}, por favor envie um arquivo no formato {$extensions}"]);
				}
			}


			$save = new stdClass;
			//MODELO DE INSERT PARA VOCE FAZER COM TODAS AS COLUNAS DO BANCO DE DADOS, MENOS ID, DELETED E UPDATED_AT
			$save->nome = $request->nome;
			if($url){
				$save->anexo = $url;
			}
			$save->cpf = $request->cpf;
			$save->cargo = $request->cargo;
			$save->email = $request->email;
			$save->telefone = $request->telefone;

			//ESSAS AQUI SEMPRE TERÃO POR PADRÃO
			$save->status = $request->status;
			$save->token = md5(date("Y-m-d H:i:s") . rand(0, 999999999));

			$save = collect($save)->toArray();
			DB::table("config_funcionarios")
				->insert($save);
			$lastId = DB::getPdo()->lastInsertId();

			$Acao = "Inseriu um Novo Registro no Módulo de ConfigFuncionarios";
			$Logs = new logs;
			$Registra = $Logs->RegistraLog(2, $Modulo, $Acao, $lastId);

			return redirect()->route("list.ConfigFuncionarios");
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

		return redirect()->route("list.ConfigFuncionarios");
	}




	public function edit($IDConfigFuncionarios)
	{
		$Modulo = "ConfigFuncionarios";

		$permUser = Auth::user()->hasPermissionTo("edit.ConfigFuncionarios");

		if (!$permUser) {
			return redirect()->route("list.Dashboard", ["id" => "1"]);
		}

		try {



			$AcaoID = $this->return_id($IDConfigFuncionarios);



			$ConfigFuncionarios = DB::table("config_funcionarios")
				->where("token", $IDConfigFuncionarios)
				->first();

			$Acao = "Abriu a Tela de Edição do Módulo de ConfigFuncionarios";
			$Logs = new logs;
			$Registra = $Logs->RegistraLog(1, $Modulo, $Acao, $AcaoID);

			return Inertia::render("ConfigFuncionarios/Edit", [
				"ConfigFuncionarios" => $ConfigFuncionarios,

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

		$Modulo = "ConfigFuncionarios";

		$permUser = Auth::user()->hasPermissionTo("edit.ConfigFuncionarios");

		if (!$permUser) {
			return redirect()->route("list.Dashboard", ["id" => "1"]);
		}


		try {


			$AcaoID = $this->return_id($id);


			if(!isset($id)){
				$id = 0;
			}
			$AnexoExiste = DB::table("config_funcionarios")
				->where("token", $id)
				->first();
			$url = null;
			$extensions = "png,jpg,jpeg";
			$formatos_liberados = explode(",", $extensions);
			if ($request->hasFile('anexo')) {
				if($request->file('anexo')->isValid()){
					$ext = $request->file('anexo')->extension();
					if (in_array($ext, $formatos_liberados)) {
						$anexo = $request->file('anexo')->store("ConfigFuncionarios/1");
						$nome = md5(date("Y-m-d H:i:s") . rand(0, 999999999)) . "." . $ext;
						Storage::move($anexo, "ConfigFuncionarios/1/" . $nome);
						$url = "ConfigFuncionarios/1/" . $nome;
						$url = str_replace("/", "-", $url);
						if($AnexoExiste){
							Storage::delete("ConfigFuncionarios/1/" . $AnexoExiste->anexo);
						}
					} else {
						$ext = $request->file('anexo')->extension();
						return redirect()->route("form.store.ConfigFuncionarios", ["id" => $id])->withErrors(["msg" => "Atenção o arquivo enviado foi: {$ext}, por favor envie um arquivo no formato {$extensions}"]);
					}
				}else {
					$ext = $request->file('anexo')->extension();
					return redirect()->route("form.store.ConfigFuncionarios", ["id" => $id])->withErrors(["msg" => "Atenção o arquivo enviado foi: {$ext}, por favor envie um arquivo no formato {$extensions}"]);
				}
			}



			$save = new stdClass;

			//MODELO DE INSERT PARA VOCE FAZER COM TODAS AS COLUNAS DO BANCO DE DADOS, MENOS ID, DELETED E UPDATED_AT
			$save->nome = $request->nome;
			if($url){
				$save->anexo = $url;
			}
			$save->cpf = $request->cpf;
			$save->cargo = $request->cargo;
			$save->email = $request->email;
			$save->telefone = $request->telefone;
			

			//ESSAS AQUI SEMPRE TERÃO POR PADRÃO
			$save->status = $request->status;

			$save = collect($save)->toArray();
			DB::table("config_funcionarios")
				->where("token", $id)
				->update($save);



			$Acao = "Editou um registro no Módulo de ConfigFuncionarios";
			$Logs = new logs;
			$Registra = $Logs->RegistraLog(3, $Modulo, $Acao, $AcaoID);

			return redirect()->route("list.ConfigFuncionarios");
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





	public function delete($IDConfigFuncionarios)
	{
		$Modulo = "ConfigFuncionarios";

		$permUser = Auth::user()->hasPermissionTo("delete.ConfigFuncionarios");

		if (!$permUser) {
			return redirect()->route("list.Dashboard", ["id" => "1"]);
		}

		try {

			$AcaoID = $this->return_id($IDConfigFuncionarios);

			DB::table("config_funcionarios")
				->where("token", $IDConfigFuncionarios)
				->update([
					"deleted" => "1",
				]);



			$Acao = "Excluiu um registro no Módulo de ConfigFuncionarios";
			$Logs = new logs;
			$Registra = $Logs->RegistraLog(4, $Modulo, $Acao, $AcaoID);

			return redirect()->route("list.ConfigFuncionarios");
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



	public function deleteSelected($IDConfigFuncionarios = null)
	{
		$Modulo = "ConfigFuncionarios";

		$permUser = Auth::user()->hasPermissionTo("delete.ConfigFuncionarios");

		if (!$permUser) {
			return redirect()->route("list.Dashboard", ["id" => "1"]);
		}

		try {

			$IDsRecebidos = explode(",", $IDConfigFuncionarios);
			$total = count(array_filter($IDsRecebidos));
			if ($total > 0) {
				foreach ($IDsRecebidos as $id) {
					$AcaoID = $this->return_id($id);
					DB::table("config_funcionarios")
						->where("token", $id)
						->update([
							"deleted" => "1",
						]);
					$Acao = "Excluiu um registro no Módulo de ConfigFuncionarios";
					$Logs = new logs;
					$Registra = $Logs->RegistraLog(4, $Modulo, $Acao, $AcaoID);
				}
			}

			return redirect()->route("list.ConfigFuncionarios");
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
		$Modulo = "ConfigFuncionarios";

		$permUser = Auth::user()->hasPermissionTo("delete.ConfigFuncionarios");

		if (!$permUser) {
			return redirect()->route("list.Dashboard", ["id" => "1"]);
		}

		try {

			DB::table("config_funcionarios")
				->update([
					"deleted" => "1",
				]);
			$Acao = "Excluiu TODOS os registros no Módulo de ConfigFuncionarios";
			$Logs = new logs;
			$Registra = $Logs->RegistraLog(4, $Modulo, $Acao, 0);



			return redirect()->route("list.ConfigFuncionarios");
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
		$Modulo = "ConfigFuncionarios";

		$permUser = Auth::user()->hasPermissionTo("delete.ConfigFuncionarios");

		if (!$permUser) {
			return redirect()->route("list.Dashboard", ["id" => "1"]);
		}

		try {

			DB::table("config_funcionarios")
				->update([
					"deleted" => "0",
				]);
			$Acao = "Restaurou TODOS os registros no Módulo de ConfigFuncionarios";
			$Logs = new logs;
			$Registra = $Logs->RegistraLog(4, $Modulo, $Acao, 0);



			return redirect()->route("list.ConfigFuncionarios");
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

		$ConfigFuncionarios = DB::table("config_funcionarios")

			->select(DB::raw("config_funcionarios.*, DATE_FORMAT(config_funcionarios.created_at, '%d/%m/%Y - %H:%i:%s') as data_final
			 
			"))
			->where("config_funcionarios.deleted", "0");

		//MODELO DE FILTRO PARA VOCE COLOCAR AQUI, PARA CADA COLUNA DO BANCO DE DADOS DEVERÁ TER UM IF PARA APLICAR O FILTRO, EXCLUIR O FILTRO DE ID, DELETED E UPDATED_AT

		if (isset($data["ConfigFuncionarios"]["nome"])) {
			$AplicaFiltro = $data["ConfigFuncionarios"]["nome"];
			$ConfigFuncionarios = $ConfigFuncionarios->Where("config_funcionarios.nome",  "like", "%" . $AplicaFiltro . "%");
		}

		if (isset($data["ConfigFuncionarios"]["cpf"])) {
			$AplicaFiltro = $data["ConfigFuncionarios"]["cpf"];
			$ConfigFuncionarios = $ConfigFuncionarios->Where("config_funcionarios.cpf",  "like", "%" . $AplicaFiltro . "%");
		}

		if (isset($data["ConfigFuncionarios"]["cargo"])) {
			$AplicaFiltro = $data["ConfigFuncionarios"]["cargo"];
			$ConfigFuncionarios = $ConfigFuncionarios->Where("config_funcionarios.cargo",  "like", "%" . $AplicaFiltro . "%");
		}

		if (isset($data["ConfigFuncionarios"]["email"])) {
			$AplicaFiltro = $data["ConfigFuncionarios"]["email"];
			$ConfigFuncionarios = $ConfigFuncionarios->Where("config_funcionarios.email",  "like", "%" . $AplicaFiltro . "%");
		}

		if (isset($data["ConfigFuncionarios"]["telefone"])) {
			$AplicaFiltro = $data["ConfigFuncionarios"]["telefone"];
			$ConfigFuncionarios = $ConfigFuncionarios->Where("config_funcionarios.telefone",  "like", "%" . $AplicaFiltro . "%");
		}

		if (isset($data["ConfigFuncionarios"]["status"])) {
			$AplicaFiltro = $data["ConfigFuncionarios"]["status"];
			$ConfigFuncionarios = $ConfigFuncionarios->Where("config_funcionarios.status",  "like", "%" . $AplicaFiltro . "%");
		}
	

		$ConfigFuncionarios = $ConfigFuncionarios->get();

		$Dadosconfig_funcionarios = [];
		foreach ($ConfigFuncionarios as $config_funcionarioss) {
			if ($config_funcionarioss->status == "0") {
				$config_funcionarioss->status = "Ativo";
			}
			if ($config_funcionarioss->status == "1") {
				$config_funcionarioss->status = "Inativo";
			}
			$Dadosconfig_funcionarios[] = [
				//MODELO DE CA,MPO PARA VOCE COLOCAR AQUI, PARA CADA COLUNA DO BANCO DE DADOS DEVERÁ TER UM, EXCLUIR O ID, DELETED E UPDATED_AT
				'nome' => $config_funcionarioss->nome,				
			
			];
		}
		return $Dadosconfig_funcionarios;
	}

	public function exportarRelatorioExcel()
	{

		$permUser = Auth::user()->hasPermissionTo("create.ConfigFuncionarios");

		if (!$permUser) {
			return redirect()->route("list.Dashboard", ["id" => "1"]);
		}


		$filePath = "Relatorio_ConfigFuncionarios.xlsx";

		if (Storage::disk("public")->exists($filePath)) {
			Storage::disk("public")->delete($filePath);
			// Arquivo foi deletado com sucesso
		}

		$cabecalhoAba1 = array('nome', 'placa', 'modelo', 'ano', 'cor', 'valor_compra', 'observacao', 'status', 'Data de Cadastro');

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		$config_funcionarios = $this->DadosRelatorio();

		// Define o título da primeira aba
		$spreadsheet->setActiveSheetIndex(0);
		$spreadsheet->getActiveSheet()->setTitle("ConfigFuncionarios");

		// Adiciona os cabeçalhos da tabela na primeira aba
		$spreadsheet->getActiveSheet()->fromArray($cabecalhoAba1, null, "A1");

		// Adiciona os dados da tabela na primeira aba
		$spreadsheet->getActiveSheet()->fromArray($config_funcionarios, null, "A2");

		// Definindo a largura automática das colunas na primeira aba
		foreach ($spreadsheet->getActiveSheet()->getColumnDimensions() as $col) {
			$col->setAutoSize(true);
		}

		// Habilita a funcionalidade de filtro para as células da primeira aba
		$spreadsheet->getActiveSheet()->setAutoFilter($spreadsheet->getActiveSheet()->calculateWorksheetDimension());


		// Define o nome do arquivo	
		$nomeArquivo = "Relatorio_ConfigFuncionarios.xlsx";
		// Cria o arquivo
		$writer = IOFactory::createWriter($spreadsheet, "Xlsx");
		$writer->save($nomeArquivo);
		$barra = "'/'";
		$barra = str_replace("'", "", $barra);
		$writer->save(storage_path("app" . $barra . "relatorio" . $barra . $nomeArquivo));

		return redirect()->route("download2.files", ["path" => $nomeArquivo]);
	}
}
