<?php

namespace Dds\Traits;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Dds\Classes\DDS;

trait FastModel
{
    // Query Helpers
    public static function scopeIndex($query, array $request, $inital_order, $inital_sort)
    {
        $table = $query->getModel()->getTable();

        $tablesJoineds = [$table];
        foreach ($query->getQuery()->joins ?? [] as $join) {
            $tablesJoineds[] = Str::after($join->table, 'as ');
        }

        $searchable = collect($query->getModel()->searchable)->map(function ($search, $key) use ($tablesJoineds) {
            [$type, $columns] = $search;
            if (is_array($columns)) {
                $tempColumns = [];
                foreach ($columns as $column) {
                    if (in_array(Str::before($column, '.'), $tablesJoineds)) {
                        $tempColumns[] = $column;
                    }
                }
                $search[1] = $tempColumns;
                return !empty($search[1]) ? $search : null;
            } else {
                return in_array(Str::before($columns, '.'), $tablesJoineds) ? $search : null;
            }
        })->reject(null);

        $orderedField = isset($request['field']) && !empty($request['field']) ? $searchable->get($request['field']) : null;

        $order = !is_null($orderedField) ? (is_array($orderedField[1]) ? $orderedField[1][0] : $orderedField[1]) : $inital_order;
        $sort = isset($request['sort']) && !empty($request['sort']) && in_array($request['sort'], ['asc', 'desc']) ? $request['sort'] : ($order == $inital_order ? $inital_sort : 'asc');

        foreach ($request as $search => $value) {
            if (!empty($value) && $searchable->has($search)) {
                [$type, $columns] = $searchable->get($search);
                if (is_array($columns)) {
                    $query = $query->where(function ($subQuery) use ($columns, $value) {
                        $first = true;
                        foreach ($columns as $column) {
                            if ($first) {
                                $first = !$first;
                                $subQuery = $subQuery->where(function ($internQuery) use ($column, $value) {
                                    $internQuery->queryToType($column, 'ilike', $value);
                                });
                            } else {
                                $subQuery = $subQuery->orWhere(function ($internQuery) use ($column, $value) {
                                    $internQuery->queryToType($column, 'ilike', $value);
                                });
                            }
                        }
                    });
                } else {
                    $query = $query->queryToType($columns, $type, $value);
                }
            }
        }

        return $query->orderBy($order, $sort);
    }

    public static function scopeQueryToType($query, $column, $type, $value)
    {
        if (in_array($type, ['like', 'ilike'])) {
            return $query->whereRaw("unaccent(" . $column . ") ilike unaccent('%" . $value . "%')");
        }
        if ($type === 'float') {
            $value = 100 * ((float) str_replace(',', '.', preg_replace('/[^0-9,]/', "", $value)));
            return $query->where($column, '=', $value);
        }
        if ($type === 'minFloat') {
            $value = 100 * ((float) str_replace(',', '.', preg_replace('/[^0-9,]/', "", $value)));
            return $query->where($column, '>=', $value);
        }
        if ($type === 'maxFloat') {
            $value = 100 * ((float) str_replace(',', '.', preg_replace('/[^0-9,]/', "", $value)));
            return $query->where($column, '<=', $value);
        }
        if ($type === 'exist') {
            if ($value == 'true') {
                return $query->whereNotNull($column);
            } elseif ($value == 'false') {
                return $query->whereNull($column);
            }
        }
        if ($type === 'bool') {
            if ($value == 'true') {
                return $query->where($column, '=', true);
            } elseif ($value == 'false') {
                return $query->where($column, '=', false);
            }
        }
        if ($type === 'uuid' && Str::isUuid($value)) {
            return $query->where($column, '=', $value);
        }
        if ($type === 'begin' && strtotime($value)) {
            return $query->whereDate($column, '>=', Carbon::createFromFormat('Y-m-d', $value));
        }
        if ($type === 'date' && strtotime($value)) {
            return $query->whereDate($column, Carbon::createFromFormat('Y-m-d', $value));
        }
        if ($type === 'month' && ($value <= 12 && $value >= 1)) {
            return $query->whereMonth($column, intval($value));
        }
        if ($type === 'year' && intval($value) > 0) {
            return $query->whereYear($column, intval($value));
        }
        if ($type === 'end' && strtotime($value)) {
            return $query->whereDate($column, '<=', Carbon::createFromFormat('Y-m-d', $value));
        }
        if ($type === '=') {
            return $query->where($column, '=', $value);
        }
    }

    public static function scopeQtdPag($query, $qtd)
    {
        return $query->paginate(intval($qtd) > 0 ? intval($qtd) : 100);
    }

    // Text Helpers
    public function formatText($text, $max_text_size = 30)
    {
        if (strlen($text) > $max_text_size) {
            return substr($text, 0, $max_text_size) . '...';
        }
        return $text;
    }

    public function formatName($max_text_size = 30)
    {
        return $this->formatText($this->name, $max_text_size);
    }

    public function formatNome($max_text_size = 30)
    {
        return $this->formatText($this->nome, $max_text_size);
    }

    // Number Helpers
    public function parse2Decimais($field)
    {
        return DDS::intToFloat2C($this->{$field});
    }

    // Date Helpers
    public function parseDate($date)
    {
        return $this->{$date} ? Carbon::parse($this->{$date})->format('d/m/Y') : 'Não Informado';
    }

    public function parseDateFormat($date, $format)
    {
        return Carbon::parse($this->{$date})->format($format);
    }

    public function parseDateTime($datetime)
    {
        return Carbon::parse($this->{$datetime})->format('d/m/Y H:i');
    }

    public function createdAt()
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('d/m/Y H:i');
    }

    public function updatedAt()
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->updated_at)->format('d/m/Y H:i');
    }

    public function deletedAt()
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->deleted_at)->format('d/m/Y H:i');
    }
}
