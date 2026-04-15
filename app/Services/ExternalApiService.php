<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ExternalApiService
{
    protected string $baseUrl;
    protected string $apiToken; // Token para autenticar a UMP Congress App na API externa

    public function __construct()
    {
        // Certifique-se de definir estas variáveis no seu arquivo .env
        $this->baseUrl = config('services.plataforma_api.base_url');
        $this->apiToken = config('services.plataforma_api.token');

        if (empty($this->baseUrl) || empty($this->apiToken)) {
            Log::error('External API Service: Base URL or API Token not configured.');
            // Você pode jogar uma exceção aqui ou lidar de outra forma
            throw new \Exception('Configuração da API Externa ausente.');
        }
    }

    /**
     * Realiza uma requisição GET para a API externa.
     *
     * @param string $endpoint O endpoint específico da API (ex: '/federations', '/umplocals')
     * @param array $query Parâmetros de query opcionais
     * @return array|null Dados da resposta JSON ou null em caso de erro
     */
    public function get(string $endpoint, array $query = []): ?array
    {
        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $this->apiToken, // Token de segurança
            ])->get($this->baseUrl . $endpoint, $query);

            // Verifica se a requisição foi bem-sucedida (status 2xx)
            if ($response->successful()) {
                return $response->json();
            }

            Log::error("External API GET Error: {$response->status()} - {$response->body()} for endpoint {$endpoint}");
            return null;

        } catch (\Exception $e) {
            Log::error("External API GET Exception for endpoint {$endpoint}: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Realiza uma requisição POST para a API externa.
     *
     * @param string $endpoint O endpoint específico da API
     * @param array $data Dados a serem enviados no corpo da requisição
     * @return array|null Dados da resposta JSON ou null em caso de erro
     */
    public function post(string $endpoint, array $data): ?array
    {
        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $this->apiToken,
            ])->post($this->baseUrl . $endpoint, $data);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error("External API POST Error: {$response->status()} - {$response->body()} for endpoint {$endpoint}");
            return null;

        } catch (\Exception $e) {
            Log::error("External API POST Exception for endpoint {$endpoint}: " . $e->getMessage());
            return null;
        }
    }

    
    /**
     * Exemplo de método para buscar federações.
     * @return array|null
     */
    public function getFederacoes(): ?array
    {
        $sinodalId = auth()->user()->tenant_id;

        return $this->get("/federacoes/{$sinodalId}");
    }

    /**
     * Exemplo de método para buscar UMPs locais (se houver um endpoint separado).
     * @return array|null
     */
    public function getUmpLocais(): ?array
    {
        $federacaoId = auth()->user()->tenant_id;

        return $this->get("/federacoes/{$federacaoId}/umps-locais");
    }

    public function validarToken(string $token): bool
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->apiToken, // Token de segurança
        ])->get($this->baseUrl . "/validar-token/{$token}");

        if ($response->successful()) {
            return true;
        }

        return false;
    }

    public function isSinodal(string $token): bool	
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->apiToken, // Token de segurança
        ])->get($this->baseUrl . "/is-sinodal/{$token}");

        if ($response->successful()) {
            return $response->json();
        }
        
        throw new \Exception('Erro ao verificar se o usuário é sinodal: ' . $response->body());
    }

    public function getUnidades(): ?array
    {
        if (auth()->user()->sinodal) {
            return self::getFederacoes();
        }

        return self::getUmpLocais();
    }
}