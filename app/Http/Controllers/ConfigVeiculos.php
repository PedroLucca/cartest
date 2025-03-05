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

class ConfigVeiculos extends Controller
{
	public function index(Request $request)
	{
		$Modulo = "ConfigVeiculos";

		$permUser = Auth::user()->hasPermissionTo("list.ConfigVeiculos");

		if (!$permUser) {
			return redirect()->route("list.Dashboard", ["id" => "1"]);
		}

		try {



			$data = Session::all();

			if (!isset($data["ConfigVeiculos"]) || empty($data["ConfigVeiculos"])) {
				session(["ConfigVeiculos" => array("status" => "0", "orderBy" => array("column" => "created_at", "sorting" => "1"), "limit" => "10")]);
				$data = Session::all();
			}

			$Filtros = new Security;
			if ($request->input()) {
				$Limpar = false;
				if ($request->input("limparFiltros") == true) {
					$Limpar = true;
				}

				$arrayFilter = $Filtros->TratamentoDeFiltros($request->input(), $Limpar, ["ConfigVeiculos"]);
				if ($arrayFilter) {
					session(["ConfigVeiculos" => $arrayFilter]);
					$data = Session::all();
				}
			}


			$columnsTable = DisabledColumns::whereRouteOfList("list.ConfigVeiculos")
				->first()
				?->columns;

			$ConfigVeiculos = DB::table("config_veiculos")

				->select(DB::raw("config_veiculos.*, DATE_FORMAT(config_veiculos.created_at, '%d/%m/%Y - %H:%i:%s') as data_final
			
			"));

			
			$tipos_veiculos = DB::table('util_tipo_veiculos')->where('deleted', '0')->get();
			

			if (isset($data["ConfigVeiculos"]["orderBy"])) {
				$Coluna = $data["ConfigVeiculos"]["orderBy"]["column"];
				$ConfigVeiculos =  $ConfigVeiculos->orderBy("config_veiculos.$Coluna", $data["ConfigVeiculos"]["orderBy"]["sorting"] ? "asc" : "desc");
			} else {
				$ConfigVeiculos =  $ConfigVeiculos->orderBy("config_veiculos.created_at", "desc");
			}

			//MODELO DE FILTRO PARA VOCE COLOCAR AQUI, PARA CADA COLUNA DO BANCO DE DADOS DEVERÁ TER UM IF PARA APLICAR O FILTRO, EXCLUIR O FILTRO DE ID, DELETED E UPDATED_AT

			if(isset($data["ConfigVeiculos"]["nome"])){				
				$AplicaFiltro = $data["ConfigVeiculos"]["nome"];			
				$ConfigVeiculos = $ConfigVeiculos->Where("config_veiculos.nome",  "like", "%" . $AplicaFiltro . "%");			
			}

			if(isset($data["ConfigVeiculos"]["placa"])){				
				$AplicaFiltro = $data["ConfigVeiculos"]["placa"];			
				$ConfigVeiculos = $ConfigVeiculos->Where("config_veiculos.placa",  "like", "%" . $AplicaFiltro . "%");			
			}

			if(isset($data["ConfigVeiculos"]["modelo"])){				
				$AplicaFiltro = $data["ConfigVeiculos"]["modelo"];			
				$ConfigVeiculos = $ConfigVeiculos->Where("config_veiculos.modelo",  "like", "%" . $AplicaFiltro . "%");			
			}

			if(isset($data["ConfigVeiculos"]["ano"])){				
				$AplicaFiltro = $data["ConfigVeiculos"]["ano"];			
				$ConfigVeiculos = $ConfigVeiculos->Where("config_veiculos.ano",  "like", "%" . $AplicaFiltro . "%");			
			}

			if(isset($data["ConfigVeiculos"]["cor"])){				
				$AplicaFiltro = $data["ConfigVeiculos"]["cor"];			
				$ConfigVeiculos = $ConfigVeiculos->Where("config_veiculos.cor",  "like", "%" . $AplicaFiltro . "%");			
			}

			if(isset($data["ConfigVeiculos"]["valor_compra"])){				
				$AplicaFiltro = $data["ConfigVeiculos"]["valor_compra"];			
				$ConfigVeiculos = $ConfigVeiculos->Where("config_veiculos.valor_compra",  "like", "%" . $AplicaFiltro . "%");			
			}

			if(isset($data["ConfigVeiculos"]["tipo_veiculo_id"])){				
				$AplicaFiltro = $data["ConfigVeiculos"]["tipo_veiculo_id"];			
				$ConfigVeiculos = $ConfigVeiculos->Where("config_veiculos.tipo_veiculo_id",  "like", "%" . $AplicaFiltro . "%");			
			}

			if(isset($data["ConfigVeiculos"]["observacao"])){				
				$AplicaFiltro = $data["ConfigVeiculos"]["observacao"];			
				$ConfigVeiculos = $ConfigVeiculos->Where("config_veiculos.observacao",  "like", "%" . $AplicaFiltro . "%");			
			}

			if(isset($data["ConfigVeiculos"]["status"])){				
				$AplicaFiltro = $data["ConfigVeiculos"]["status"];			
				$ConfigVeiculos = $ConfigVeiculos->Where("config_veiculos.status",  "like", "%" . $AplicaFiltro . "%");			
			}
			if(isset($data["ConfigVeiculos"]["created_at"])){				
				$AplicaFiltro = $data["ConfigVeiculos"]["created_at"];			
				$ConfigVeiculos = $ConfigVeiculos->Where("config_veiculos.created_at",  "like", "%" . $AplicaFiltro . "%");			
			}

			$ConfigVeiculos = $ConfigVeiculos->where("config_veiculos.deleted", "0");

			$ConfigVeiculos = $ConfigVeiculos->paginate(($data["ConfigVeiculos"]["limit"] ?: 10))
				->appends(["page", "orderBy", "searchBy", "limit"]);

			$Acao = "Acessou a listagem do Módulo de ConfigVeiculos";
			$Logs = new logs;
			$Registra = $Logs->RegistraLog(1, $Modulo, $Acao);
			$Registros = $this->Registros();
			


			return Inertia::render("ConfigVeiculos/List", [
				"columnsTable" => $columnsTable,
				"ConfigVeiculos" => $ConfigVeiculos,
				"tipos_veiculos" => $tipos_veiculos,
				"Filtros" => $data["ConfigVeiculos"],
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
		$Total = DB::table("config_veiculos")
			->where("config_veiculos.deleted", "0")
			->count();

		$Ativos = DB::table("config_veiculos")
			->where("config_veiculos.deleted", "0")
			->where("config_veiculos.status", "0")
			->count();

		$Inativos = DB::table("config_veiculos")
			->where("config_veiculos.deleted", "0")
			->where("config_veiculos.status", "1")
			->count();

		$EsseMes = DB::table("config_veiculos")
			->where("config_veiculos.deleted", "0")
			->whereMonth("config_veiculos.created_at", $mes)
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
		$Modulo = "ConfigVeiculos";
		$permUser = Auth::user()->hasPermissionTo("create.ConfigVeiculos");

		if (!$permUser) {
			return redirect()->route("list.Dashboard", ["id" => "1"]);
		}
		try {



			$Acao = "Abriu a Tela de Cadastro do Módulo de ConfigVeiculos";
			$Logs = new logs;
			$Registra = $Logs->RegistraLog(1, $Modulo, $Acao);

			$tipos_veiculos = DB::table('util_tipo_veiculos')->where('deleted', '0')->get();

			return Inertia::render("ConfigVeiculos/Create", [
				'tipos_veiculos' => $tipos_veiculos,
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
		$ConfigVeiculos = DB::table("config_veiculos");
		$ConfigVeiculos = $ConfigVeiculos->where("deleted", "0");
		$ConfigVeiculos = $ConfigVeiculos->where("token", $id)->first();

		return $ConfigVeiculos->id;
	}

	public function store(Request $request)
	{
		$Modulo = "ConfigVeiculos";

		$permUser = Auth::user()->hasPermissionTo("create.ConfigVeiculos");

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
						$anexo = $request->file('anexo')->store("ConfigVeiculos/1");
						$nome = md5(date("Y-m-d H:i:s") . rand(0, 999999999)) . "." . $ext;
						Storage::move($anexo, "ConfigVeiculos/1/" . $nome);
						$url = "ConfigVeiculos/1/" . $nome;
						$url = str_replace("/", "-", $url);
					} else {
						$ext = $request->file('anexo')->extension();
						return redirect()->route("form.store.ConfigVeiculos")->withErrors(["msg" => "Atenção o arquivo enviado foi: {$ext}, por favor envie um arquivo no formato {$extensions}"]);
					}
				}else {
					$ext = $request->file('anexo')->extension();
					return redirect()->route("form.store.ConfigVeiculos")->withErrors(["msg" => "Atenção o arquivo enviado foi: {$ext}, por favor envie um arquivo no formato {$extensions}"]);
				}
			}


			$save = new stdClass;
			//MODELO DE INSERT PARA VOCE FAZER COM TODAS AS COLUNAS DO BANCO DE DADOS, MENOS ID, DELETED E UPDATED_AT
			$save->nome = $request->nome;
			$save->placa = $request->placa;
			$save->modelo = $request->modelo;
			if($url){
				$save->anexo = $url;
			}
			$save->ano = $request->ano;
			$save->cor = $request->cor;
			$save->valor_compra = $request->valor_compra;
			$save->tipo_veiculo_id = $request->tipo_veiculo_id;
			$save->observacao = $request->observacao;
			

			//ESSAS AQUI SEMPRE TERÃO POR PADRÃO
			$save->status = $request->status;
			$save->token = md5(date("Y-m-d H:i:s") . rand(0, 999999999));

			$save = collect($save)->toArray();
			DB::table("config_veiculos")
				->insert($save);
			$lastId = DB::getPdo()->lastInsertId();

			$Acao = "Inseriu um Novo Registro no Módulo de ConfigVeiculos";
			$Logs = new logs;
			$Registra = $Logs->RegistraLog(2, $Modulo, $Acao, $lastId);

			return redirect()->route("list.ConfigVeiculos");
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

		return redirect()->route("list.ConfigVeiculos");
	}




	public function edit($IDConfigVeiculos)
	{
		$Modulo = "ConfigVeiculos";

		$permUser = Auth::user()->hasPermissionTo("edit.ConfigVeiculos");

		if (!$permUser) {
			return redirect()->route("list.Dashboard", ["id" => "1"]);
		}

		try {



			$AcaoID = $this->return_id($IDConfigVeiculos);

			$ConfigVeiculos = DB::table("config_veiculos")
				->where("token", $IDConfigVeiculos)
				->first();

			$Acao = "Abriu a Tela de Edição do Módulo de ConfigVeiculos";
			$Logs = new logs;
			$Registra = $Logs->RegistraLog(1, $Modulo, $Acao, $AcaoID);

			$tipos_veiculos = DB::table('util_tipo_veiculos')->where('deleted', '0')->get();

			return Inertia::render("ConfigVeiculos/Edit", [
				"ConfigVeiculos" => $ConfigVeiculos,
				'tipos_veiculos' => $tipos_veiculos,
			
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

		$Modulo = "ConfigVeiculos";

		$permUser = Auth::user()->hasPermissionTo("edit.ConfigVeiculos");

		if (!$permUser) {
			return redirect()->route("list.Dashboard", ["id" => "1"]);
		}


		try {


			$AcaoID = $this->return_id($id);

			if(!isset($id)){
				$id = 0;
			}
			$AnexoExiste = DB::table("config_veiculos")
				->where("token", $id)
				->first();
			$url = null;
			$extensions = "png,jpg,jpeg";
			$formatos_liberados = explode(",", $extensions);
			if ($request->hasFile('anexo')) {
				if($request->file('anexo')->isValid()){
					$ext = $request->file('anexo')->extension();
					if (in_array($ext, $formatos_liberados)) {
						$anexo = $request->file('anexo')->store("ConfigVeiculos/1");
						$nome = md5(date("Y-m-d H:i:s") . rand(0, 999999999)) . "." . $ext;
						Storage::move($anexo, "ConfigVeiculos/1/" . $nome);
						$url = "ConfigVeiculos/1/" . $nome;
						$url = str_replace("/", "-", $url);
						if($AnexoExiste){
							Storage::delete("ConfigVeiculos/1/" . $AnexoExiste->anexo);
						}
					} else {
						$ext = $request->file('anexo')->extension();
						return redirect()->route("form.store.ConfigVeiculos", ["id" => $id])->withErrors(["msg" => "Atenção o arquivo enviado foi: {$ext}, por favor envie um arquivo no formato {$extensions}"]);
					}
				}else {
					$ext = $request->file('anexo')->extension();
					return redirect()->route("form.store.ConfigVeiculos", ["id" => $id])->withErrors(["msg" => "Atenção o arquivo enviado foi: {$ext}, por favor envie um arquivo no formato {$extensions}"]);
				}
			}

			$save = new stdClass;

			//MODELO DE INSERT PARA VOCE FAZER COM TODAS AS COLUNAS DO BANCO DE DADOS, MENOS ID, DELETED E UPDATED_AT
			$save->nome = $request->nome;
			$save->placa = $request->placa;
			$save->modelo = $request->modelo;
			if($url){
				$save->anexo = $url;
			}
			$save->ano = $request->ano;
			$save->cor = $request->cor;
			$save->valor_compra = $request->valor_compra;
			$save->tipo_veiculo_id = $request->tipo_veiculo_id;
			$save->observacao = $request->observacao;
			//ESSAS AQUI SEMPRE TERÃO POR PADRÃO
			$save->status = $request->status;

			$save = collect($save)->toArray();
			DB::table("config_veiculos")
				->where("token", $id)
				->update($save);



			$Acao = "Editou um registro no Módulo de ConfigVeiculos";
			$Logs = new logs;
			$Registra = $Logs->RegistraLog(3, $Modulo, $Acao, $AcaoID);

			return redirect()->route("list.ConfigVeiculos");
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





	public function delete($IDConfigVeiculos)
	{
		$Modulo = "ConfigVeiculos";

		$permUser = Auth::user()->hasPermissionTo("delete.ConfigVeiculos");

		if (!$permUser) {
			return redirect()->route("list.Dashboard", ["id" => "1"]);
		}

		try {

			$AcaoID = $this->return_id($IDConfigVeiculos);

			DB::table("config_veiculos")
				->where("token", $IDConfigVeiculos)
				->update([
					"deleted" => "1",
				]);



			$Acao = "Excluiu um registro no Módulo de ConfigVeiculos";
			$Logs = new logs;
			$Registra = $Logs->RegistraLog(4, $Modulo, $Acao, $AcaoID);

			return redirect()->route("list.ConfigVeiculos");
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



	public function deleteSelected($IDConfigVeiculos = null)
	{
		$Modulo = "ConfigVeiculos";

		$permUser = Auth::user()->hasPermissionTo("delete.ConfigVeiculos");

		if (!$permUser) {
			return redirect()->route("list.Dashboard", ["id" => "1"]);
		}

		try {

			$IDsRecebidos = explode(",", $IDConfigVeiculos);
			$total = count(array_filter($IDsRecebidos));
			if ($total > 0) {
				foreach ($IDsRecebidos as $id) {
					$AcaoID = $this->return_id($id);
					DB::table("config_veiculos")
						->where("token", $id)
						->update([
							"deleted" => "1",
						]);
					$Acao = "Excluiu um registro no Módulo de ConfigVeiculos";
					$Logs = new logs;
					$Registra = $Logs->RegistraLog(4, $Modulo, $Acao, $AcaoID);
				}
			}

			return redirect()->route("list.ConfigVeiculos");
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
		$Modulo = "ConfigVeiculos";

		$permUser = Auth::user()->hasPermissionTo("delete.ConfigVeiculos");

		if (!$permUser) {
			return redirect()->route("list.Dashboard", ["id" => "1"]);
		}

		try {

			DB::table("config_veiculos")
				->update([
					"deleted" => "1",
				]);
			$Acao = "Excluiu TODOS os registros no Módulo de ConfigVeiculos";
			$Logs = new logs;
			$Registra = $Logs->RegistraLog(4, $Modulo, $Acao, 0);



			return redirect()->route("list.ConfigVeiculos");
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
		$Modulo = "ConfigVeiculos";

		$permUser = Auth::user()->hasPermissionTo("delete.ConfigVeiculos");

		if (!$permUser) {
			return redirect()->route("list.Dashboard", ["id" => "1"]);
		}

		try {

			DB::table("config_veiculos")
				->update([
					"deleted" => "0",
				]);
			$Acao = "Restaurou TODOS os registros no Módulo de ConfigVeiculos";
			$Logs = new logs;
			$Registra = $Logs->RegistraLog(4, $Modulo, $Acao, 0);



			return redirect()->route("list.ConfigVeiculos");
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

		$ConfigVeiculos = DB::table("config_veiculos")

			->select(DB::raw("config_veiculos.*, DATE_FORMAT(config_veiculos.created_at, '%d/%m/%Y - %H:%i:%s') as data_final
			 
			"))
			->where("config_veiculos.deleted", "0");

		//MODELO DE FILTRO PARA VOCE COLOCAR AQUI, PARA CADA COLUNA DO BANCO DE DADOS DEVERÁ TER UM IF PARA APLICAR O FILTRO, EXCLUIR O FILTRO DE ID, DELETED E UPDATED_AT
		if(isset($data["ConfigVeiculos"]["nome"])){				
			$AplicaFiltro = $data["ConfigVeiculos"]["nome"];			
			$ConfigVeiculos = $ConfigVeiculos->Where("config_veiculos.nome",  "like", "%" . $AplicaFiltro . "%");			
		}

		if(isset($data["ConfigVeiculos"]["placa"])){				
			$AplicaFiltro = $data["ConfigVeiculos"]["placa"];			
			$ConfigVeiculos = $ConfigVeiculos->Where("config_veiculos.placa",  "like", "%" . $AplicaFiltro . "%");			
		}

		if(isset($data["ConfigVeiculos"]["modelo"])){				
			$AplicaFiltro = $data["ConfigVeiculos"]["modelo"];			
			$ConfigVeiculos = $ConfigVeiculos->Where("config_veiculos.modelo",  "like", "%" . $AplicaFiltro . "%");			
		}

		if(isset($data["ConfigVeiculos"]["ano"])){				
			$AplicaFiltro = $data["ConfigVeiculos"]["ano"];			
			$ConfigVeiculos = $ConfigVeiculos->Where("config_veiculos.ano",  "like", "%" . $AplicaFiltro . "%");			
		}

		if(isset($data["ConfigVeiculos"]["cor"])){				
			$AplicaFiltro = $data["ConfigVeiculos"]["cor"];			
			$ConfigVeiculos = $ConfigVeiculos->Where("config_veiculos.cor",  "like", "%" . $AplicaFiltro . "%");			
		}

		if(isset($data["ConfigVeiculos"]["valor_compra"])){				
			$AplicaFiltro = $data["ConfigVeiculos"]["valor_compra"];			
			$ConfigVeiculos = $ConfigVeiculos->Where("config_veiculos.valor_compra",  "like", "%" . $AplicaFiltro . "%");			
		}

		if(isset($data["ConfigVeiculos"]["tipo_veiculo_id"])){				
			$AplicaFiltro = $data["ConfigVeiculos"]["tipo_veiculo_id"];			
			$ConfigVeiculos = $ConfigVeiculos->Where("config_veiculos.tipo_veiculo_id",  "like", "%" . $AplicaFiltro . "%");			
		}

		if(isset($data["ConfigVeiculos"]["observacao"])){				
			$AplicaFiltro = $data["ConfigVeiculos"]["observacao"];			
			$ConfigVeiculos = $ConfigVeiculos->Where("config_veiculos.observacao",  "like", "%" . $AplicaFiltro . "%");			
		}

		if(isset($data["ConfigVeiculos"]["status"])){				
			$AplicaFiltro = $data["ConfigVeiculos"]["status"];			
			$ConfigVeiculos = $ConfigVeiculos->Where("config_veiculos.status",  "like", "%" . $AplicaFiltro . "%");			
		}
		if(isset($data["ConfigVeiculos"]["created_at"])){				
			$AplicaFiltro = $data["ConfigVeiculos"]["created_at"];			
			$ConfigVeiculos = $ConfigVeiculos->Where("config_veiculos.created_at",  "like", "%" . $AplicaFiltro . "%");			
		}
		
		if (isset($data["ConfigVeiculos"]["nome"])) {
			$AplicaFiltro = $data["ConfigVeiculos"]["nome"];
			$ConfigVeiculos = $ConfigVeiculos->Where("config_veiculos.nome",  "like", "%" . $AplicaFiltro . "%");
		}
	

		$ConfigVeiculos = $ConfigVeiculos->get();

		$Dadosconfig_veiculos = [];
		foreach ($ConfigVeiculos as $config_veiculoss) {
			if ($config_veiculoss->status == "0") {
				$config_veiculoss->status = "Ativo";
			}
			if ($config_veiculoss->status == "1") {
				$config_veiculoss->status = "Inativo";
			}
			$Dadosconfig_veiculos[] = [
				//MODELO DE CA,MPO PARA VOCE COLOCAR AQUI, PARA CADA COLUNA DO BANCO DE DADOS DEVERÁ TER UM, EXCLUIR O ID, DELETED E UPDATED_AT
				'nome' => $config_veiculoss->nome,				
			
			];
		}
		return $Dadosconfig_veiculos;
	}

	public function exportarRelatorioExcel()
	{

		$permUser = Auth::user()->hasPermissionTo("create.ConfigVeiculos");

		if (!$permUser) {
			return redirect()->route("list.Dashboard", ["id" => "1"]);
		}


		$filePath = "Relatorio_ConfigVeiculos.xlsx";

		if (Storage::disk("public")->exists($filePath)) {
			Storage::disk("public")->delete($filePath);
			// Arquivo foi deletado com sucesso
		}

		$cabecalhoAba1 = array('nome', 'placa', 'modelo', 'ano', 'cor', 'valor_compra', 'observacao', 'status', 'Data de Cadastro');

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		$config_veiculos = $this->DadosRelatorio();

		// Define o título da primeira aba
		$spreadsheet->setActiveSheetIndex(0);
		$spreadsheet->getActiveSheet()->setTitle("ConfigVeiculos");

		// Adiciona os cabeçalhos da tabela na primeira aba
		$spreadsheet->getActiveSheet()->fromArray($cabecalhoAba1, null, "A1");

		// Adiciona os dados da tabela na primeira aba
		$spreadsheet->getActiveSheet()->fromArray($config_veiculos, null, "A2");

		// Definindo a largura automática das colunas na primeira aba
		foreach ($spreadsheet->getActiveSheet()->getColumnDimensions() as $col) {
			$col->setAutoSize(true);
		}

		// Habilita a funcionalidade de filtro para as células da primeira aba
		$spreadsheet->getActiveSheet()->setAutoFilter($spreadsheet->getActiveSheet()->calculateWorksheetDimension());


		// Define o nome do arquivo	
		$nomeArquivo = "Relatorio_ConfigVeiculos.xlsx";
		// Cria o arquivo
		$writer = IOFactory::createWriter($spreadsheet, "Xlsx");
		$writer->save($nomeArquivo);
		$barra = "'/'";
		$barra = str_replace("'", "", $barra);
		$writer->save(storage_path("app" . $barra . "relatorio" . $barra . $nomeArquivo));

		return redirect()->route("download2.files", ["path" => $nomeArquivo]);
	}
}
