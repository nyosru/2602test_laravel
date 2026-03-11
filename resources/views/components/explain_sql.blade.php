<?php

use Livewire\Component;
use Illuminate\Support\Facades\DB;

new class extends Component {

    public $sql;
    public $explainResults;

    function mount()
    {
        $this->sql = 123;
    }

    function render()
    {

// 1. Указываем подключение к "другой" базе данных (например, 'second_db')
        $query = \App\Models\Master\Board::
            with(['columns','records'])
//            ->where('status', 'active')
//            ->select('id', 'name', 'created_at')
        ;

// 2. Выполняем EXPLAIN этого запроса
        $this->explainResults = $query->explain();

// 3. Анализируем результат
        dump($this->explainResults);

        return view('livewire.explain-sql');
    }
};
?>

<div>
    <B>запрос:</B>
    <Br/>
    {{ $sql ?? 'x'}}

    <Br/>
    <Br/>
    <Br/>
    для работы с запросом, используем <br/>
    <B>explaine:</B>
    <br/>
    {{ $sql ?? 'x'}}
</div>
