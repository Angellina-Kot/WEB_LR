<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Response;
use App\Repositories\ServiceRepository;

final class CategoriesController extends Controller
{
    public function index(): void
    {
        $this->requireMethod('GET');
        $repo = new ServiceRepository($this->pdo);
        Response::ok(['data' => $repo->categories()]);
    }
}
