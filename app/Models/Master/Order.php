<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'name',

        // дата монтажа
        'ready_dates',

        'dogovor_number',

        'montag_date',
        'montag_date_comment',

        // срок изготовления
        'production_time',
        // гарантийный срок
        'guarantee_period',

        // дизайнер
        'design',

        'updated_at',

        'order_form_data',
        'form_data',
        'form_id',
        'form_type',

        'manager_id',

        'in_archive',
        'last_log_id',
        'price',
        'price_without_decor',
        'price_stone_countertop',
        'last_roles_log_id',
        'last_change_staff_id',
        'last_change_ts',
        'contract_id',
        'urgently',
        'group_id',
        'brigade_id',

        'types',
        'type_payments',
        'type_payments_month',
        'forms_payment',

        'order_payment_type_id',
        'order_product_type_id',

        'discount',
        // адрес монтажа
        'adres',
        'labels',

        'success_payment',
        'comment_akcia',

        'order_schedule',
        'order_tfmf',
        'summa_work',
        'summa_install',
        'summa_dop',
        'summa_dop2',
        'payment_dop',
        'comment_dop',
        'virtual_order_id',
        'virtual_service_id',
        'service',
        'usluga',
        'summa_mebel',
        'summa_build',
        'summa_zamer',
        'summa_dost',
        'summa_gruz',
        'summa_tech',
        'summa_manager',
    ];

    protected $casts = [
        'ready_dates' => 'array',
        'last_change_ts' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $appends = ['viruchka'];

    public function getViruchkaAttribute()
    {
        return $this->price -

            $this->summa_work -
            $this->design -
            $this->summa_install +
            $this->summa_dop +
            $this->summa_dop2 -
            $this->summa_mebel -
            $this->summa_build -
            $this->summa_zamer -
            $this->summa_dost -
            $this->summa_gruz -
            $this->summa_tech -
            $this->summa_manager;
        //        return 'the translated tag';
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    //
    //    public function manager()
    //    {
    //        return $this->belongsTo(User::class, 'manager_id'); // Предполагаем, что менеджеры - это пользователи
    //    }
    //
    //    public function form()
    //    {
    //        return $this->belongsTo(Form::class); // Предполагая, что есть модель Form
    //    }
    //
    //    public function brigade()
    //    {
    //        return $this->belongsTo(Brigade::class); // Предполагая, что есть модель Brigade
    //    }
    //
    //    public function contract()
    //    {
    //        return $this->belongsTo(Contract::class); // Предполагая, что есть модель Contract
    //    }
    // Обратная связь "Один к одному" с моделью Contract
    public function contract()
    {
        return $this->belongsTo(Contract::class, 'id', 'order_original');
    }

    // Связь с моделью OrderPaymentType
    public function paymentType()
    {
        return $this->belongsTo(OrderPaymentType::class, 'order_payment_type_id');
    }

    public function productType()
    {
        return $this->belongsTo(OrderProductType::class, 'order_product_type_id');
    }

    /**
     * Связь с моделью OrderPayment.
     * Один заказ может иметь несколько платежей.
     */
    public function payments()
    {
        return $this->hasMany(OrderPayment::class, 'order_id');
    }

    //    /**
    //     * Связь с моделью Client.
    //     * Один заказ может принадлежать одному клиенту.
    //     */
    //    public function client()
    //    {
    //        return $this->belongsTo(Client::class, 'client_id');
    //    }
    //
    //    /**
    //     * Связь с моделью Staff.
    //     * Один заказ может принадлежать одному менеджеру.
    //     */
    public function manager()
    {
        return $this->belongsTo(Staff::class, 'manager_id');
    }

    //    public function contract()
    //    {
    //        return $this->belongsTo(Contracts::class, 'contract_id');
    //    }
    //
    //    /**
    //     * Связь с моделью Brigade.
    //     * Один заказ может принадлежать одной бригаде.
    //     */
    //    public function brigade()
    //    {
    //        return $this->belongsTo(Brigade::class, 'brigade_id');
    //    }
    //
    //    /**
    //     * Связь с моделью Group.
    //     * Один заказ может принадлежать одной группе.
    //     */
    //    public function group()
    //    {
    //        return $this->belongsTo(Group::class, 'group_id');
    //    }
    //
    //    /**
    //     * Связь с моделью Form.
    //     * Один заказ может принадлежать одной форме.
    //     */
    //    public function form()
    //    {
    //        return $this->belongsTo(Forms::class, 'form_id');
    //    }
    //
    //    /**
    //     * Связь с моделью Log.
    //     * Один заказ может иметь много логов.
    //     */
    //    public function logs()
    //    {
    //        return $this->hasMany(Log::class);
    //    }
    //
    //    public function orders_logs()
    //    {
    //        return $this->hasMany(OrderLog::class, 'order_id');
    //    }
    //
    public function last_roles_log()
    {
        return $this->belongsTo(OrderLog::class, 'last_roles_log_id');
    }
    //
    //    public function leedRecord()
    //    {
    //        return $this->belongsTo(\App\Models\LeedRecord::class, 'order_id');
    //    }

    public function labels()
    {
        return $this->belongsToMany(OrderLabel::class, 'orders_labels_orders', 'order_id', 'label_id');
    }

    public function logs()
    {
        return $this->hasMany(Logs2::class, 'order_id');
    }
}
