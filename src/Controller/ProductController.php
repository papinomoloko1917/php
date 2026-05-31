<?php

declare(strict_types=1);

namespace App\Controller;

use App\Support\Validator;

class ProductController extends Controller
{
    public function add()
    {
        return $this->view('admin/products/add');
    }
    public function store(): void
    {
        $data = ['name' => 'Тестовое имя'];
        $rules = ['name' => ['required|min:3|max:255']];

        $validator = new Validator();

        $validator->validate($data, $rules);

        dump($validator->errors());
    }
}
