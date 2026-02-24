<?php

namespace App\View\Components;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\View\Component;
use Illuminate\View\View;

class ProductExplain extends Component
{
    public string $visualExplainUrl;

    public string $sql;

    /**
     * @var array<int, mixed>
     */
    public array $bindings;

    public function __construct()
    {
        $query = Product::query()
            ->select([
                'products.*',
                DB::raw('price * 1.2 as price_with_vat'),
            ])
            ->where('price', '>', 1000)
            ->where(function ($q) {
                $q->where('name', 'like', '%pro%')
                    ->orWhere('description', 'like', '%sale%');
            })
            ->orderByDesc('price_with_vat')
            ->limit(100);

        $this->visualExplainUrl = $query->visualExplain();
        $this->sql = $query->toSql();
        $this->bindings = $query->getBindings();
    }

    public function render(): View
    {
        return view('components.product-explain');
    }
}

