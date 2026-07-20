<?php
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        $user = $session->get('user');

        // $arguments contient le(s) rôle(s) autorisé(s) sous forme d'id_role (1 = opérateur, 2 = client)
        // ex: ['1'] pour opérateur uniquement, ['1', '2'] pour tous
        if (!$user || !in_array($user['id_role'] ?? null, $arguments ?? [])) {
            return redirect()->to('/')->with('error', 'Accès refusé : droits insuffisants');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Rien à faire après
    }
}