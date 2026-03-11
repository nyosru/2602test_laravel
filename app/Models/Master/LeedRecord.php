<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeedRecord extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $connection = 'second_db';
    protected $fillable = [
        'name',

        // +in contr
        'telegram',
        'whatsapp',
        'fio2',
        'phone2',
        // +in contr
        'cooperativ',
        //        'price',
        'date_start',

        'company',
        'comment',
        //        'content',
        'client_id',
        'client_supplier_id', // Добавляем поле для связи с поставщиком клиента
        'order_product_types_id', // Добавляем поле для связи с поставщиком клиента

        'leed_column_id',
        'user_id',
        'otkaz_reason',
        'leed_id',
        'budget',

        'phone',
        'fio',

        'platform',
        'base_number',
        'link',
        'submit_before',
        'payment_due_date',
        'pay_day_every_year',
        'pay_day_every_month',

        'email',
        'obj_tender',
        'zakazchick',
        'post_day_ot',
        'post_day_do',
        'mesto_dostavki',

        'number1', 'number2', 'number3', 'number4', 'number5', 'number6',
        'date1', 'date2', 'date3', 'date4',
        'dt1', 'dt2', 'dt3',
        'string1', 'string2', 'string3', 'string4',

        'source',
        'call_id',
        'from_number',
        'to_number',
        'status',

    ];

    protected $casts = [
        //        'budget' => 'decimal:2',
        'budget' => 'decimal',
        //        'price' => 'decimal:2',
        //        'price' => 'decimal',

        'date_start' => 'datetime',
        'submit_before' => 'datetime',
        'payment_due_date' => 'datetime',

        'pay_day_every_year' => 'date',

        'pay_day_every_month' => 'integer',
        'post_day_ot' => 'integer',
        'post_day_do' => 'integer',

        //        'number1' => 'decimal:2',
        //        'number2' => 'decimal:2',
        //        'number3' => 'decimal:2',
        //        'number4' => 'decimal:2',
        //        'number5' => 'decimal:2',
        //        'number6' => 'decimal:2',

        'date1' => 'datetime',
        'date2' => 'datetime',
        'date3' => 'datetime',
        'date4' => 'datetime',

        'dt1' => 'datetime',
        'dt2' => 'datetime',
        'dt3' => 'datetime',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function column()
    {
        return $this->belongsTo(LeedColumn::class, 'leed_column_id');
    }

    public function comments()
    {
        return $this->hasMany(Logs2::class);
    }

    public function orders()
    {
        return $this->hasMany(LeedRecordOrder::class);
    }

    public function supplier() // Добавляем метод для связи с ClientSupplier
    {
        return $this->belongsTo(ClientSupplier::class, 'client_supplier_id');
    }

    public function userAssignments() // Добавляем метод для связи с LeadUserAssignment
    {
        return $this->hasMany(LeadUserAssignment::class, 'lead_id');
    }

    //    // Определение отношения один-ко-многим с LeadTransfer
    //    public function transfers()
    //    {
    //        return $this->hasMany(LeadTransfer::class, 'lead_id');
    //    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function productTypes()
    {
        return $this->belongsTo(OrderProductType::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // Связь с моделью LeedRecord
    //    public function leedRecord()
    //    {
    //        return $this->belongsTo(LeedRecord::class, 'leed_id');
    //    }

    public function order()
    {
        return $this->hasOne(\App\Models\Order::class, 'id', 'order_id');
    }

    // Лид-рекорд имеет много комментариев
    public function leedComments()
    {
        return $this->hasMany(LeedRecordComment::class);
    }

    public function userChanges()
    {
        return $this->hasMany(LeedRecordUserChange::class);
    }

    public function notifications()
    {
        return $this->hasMany(LeedNotification::class, 'leed_id');
    }

    /**
     * Получить все макросы, связанные с этим лидом
     */
    public function macros(): HasMany
    {
        return $this->hasMany(Macros::class, 'leed_id');
    }

    public function documents()
    {
        return $this->hasMany(Document::class, 'leed_id');
    }

    /**
     * Движения денег по лиду.
     */
    public function moneyMovements()
    {
        return $this->hasMany(LeedMoneyMovement::class);
    }

    public function getStartVisibleFieldsWithLabels(): array
    {
        $fields = $this->column->board->fieldSettings()
            ->where('show_on_start', true)
            ->orderBy('sort_order')
            ->get(['field_name',
                //                , 'label',
                // 'placeholder'
            ]); // предполагаю, что есть поля label/placeholder

        $result = [];

        foreach ($fields as $setting) {

            //            dump( $setting->orderRequest()->first()->name );
            $fieldName = $setting->field_name;
            //            $label = $setting->label ?? ucfirst($fieldName); // или rename->name, если есть связь
            $label = ucfirst($setting->orderRequest()->first()->name); // или rename->name, если есть связь

            $value = $this->$fieldName ?? null;

            $result[] = [
                //                'field' => $fieldName,
                'label' => $label,
                'value' => $value,
            ];
        }

        return $result;
    }

    public function lessonAttendances(): HasMany
    {
        return $this->hasMany(LessonAttendance::class);
    }

    public function lessons(): BelongsToMany
    {
        return $this->belongsToMany(Lesson::class, 'lesson_attendances')
            ->withPivot('status', 'comment', 'paid', 'paid_amount', 'is_late', 'is_excused')
            ->withTimestamps();
    }

}
