<?php

namespace Core\Lib;

use Core\App;

class Model
{

    protected static string $table = "";
    protected static ?string $alias = null;
    protected static string $pk = "id";
    protected static array $fields = [];

    public function __construct($values = null)
    {
        foreach(static::$fields as $field)
        {
            $this->{$field} = $values[$field] ?? null;
        }
    }

    public function __set($key, $value)
    {
        $this->{$key} = $value;
    }

    public static function table()
    {
        return static::$table;
    }

    public static function pk()
    {
        return static::$pk;
    }

    public static function fields()
    {
        return static::$fields;
    }

    public static function all()
    {
        $queryRows = App::$db->createQueryBuilder()->select('*')->from(static::$table)->fetchAllAssociative();
        $rows = [];
        foreach ($queryRows as $queryRow)
        {
            $rows[] = new static($queryRow);
        }
        return $rows;
    }

    public static function find($pk_value)
    {
        $query = App::$db->createQueryBuilder()->select('*')->from(static::$table)->where(static::$pk . ' = :value')->setParameter('value', $pk_value)->fetchAssociative();
        if (! $query)
        {
            return null;
        }
        return new static($query);
    }

    public function save()
    {
        if ($this->{static::$pk} != null)
        {
            $old = static::find($this->{static::$pk} ?? null);
            if (! $old)
            {
                return $this->insert();
            }
            else
            {
                return $this->update();
            }
        }
        else
        {
            return $this->insert();
        }
    }

    public function delete()
    {
        $delete = App::$db->createQueryBuilder()->delete(static::$table)->where(static::$pk . " = ?")->setParameter(0, $this->{static::$pk})->executeQuery();
        return [$delete, $this];
    }

    protected function insert()
    {
        $values = [];
        foreach (static::$fields as $field)
        {
            if ($field != static::$pk)
            {
                $values[$field] = '?';
            }
        }
        $insert = App::$db->createQueryBuilder()->insert(static::$table)->values($values);
        $i = 0;
        foreach ($values as $k => $value)
        {
            $insert = $insert->setParameter($i, $this->{$k});
            $i++;
        }
        $result = $insert->executeQuery();
        $this->{static::$pk} = App::$db->lastInsertId();
        return $result;
    }

    protected function update()
    {
        $update = App::$db->createQueryBuilder()->update(static::$table);
        foreach (static::$fields as $i => $field)
        {
            if ($field != static::$pk)
            {
                $update = $update->set($field, '?')->setParameter($i, $this->{$field});
            }
        }
        return $update->where(static::$pk . " = ?")->setParameter(count(static::$fields), $this->{static::$pk})->executeQuery();
    }

}