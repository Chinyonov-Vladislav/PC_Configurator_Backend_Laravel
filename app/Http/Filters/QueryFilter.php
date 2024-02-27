<?php

namespace App\Http\Filters;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
abstract class QueryFilter
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Builder
     */
    protected $builder;

    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param Builder $builder
     */
    public function apply(Builder $builder): void
    {
        $this->builder = $builder;
        foreach ($this->fields() as $field => $value) {
            $method = Str::camel($field);
            if (method_exists($this, $method)) {
                if (is_array($value)) {
                    call_user_func([$this, $method], $value);
                } elseif (is_bool($value)|| is_string($value) || is_integer($value) || is_float($value)) {
                    call_user_func_array([$this, $method], (array)$value);
                }
            }
        }
    }

    /**
     * @return array
     */
    protected function fields(): array
    {
        /*return array_filter(
            array_map('trim', $this->request->all())
        );*/
        return $this->trimArray($this->request->all());
    }
    protected function trimArray($array): array
    {
        return array_map(function ($value) {
            return is_array($value) ? $this->trimArray($value) : trim($value);
        }, $array);
    }
}
