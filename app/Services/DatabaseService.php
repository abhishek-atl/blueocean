<?php

namespace App\Services;

use Illuminate\Support\Arr;

class DatabaseService
{
    public function getByParams($class, $params)
    {
        $object = new $class;
        $query = $object::query()->whereRaw('1=1');

        if (isset($params['select'])) {
            $query->select($params['select']);
        }

        // return if single object is needed
        if (isset($params['id'])) {
            $query->where('id', $params['id']);
            $record = $query->first();
            return $record;
        }

        // Implement Where clause
        if (isset($params['where'])) {
            foreach ($params['where'] as $key => $value) {
                $query->where($key, $value);
            }
        }

        // like clause
        if (isset($params['like'])) {
            $query->where(function ($qb) use ($params) {
                foreach ($params['like'] as $key => $value) {
                    $qb->orWhere($key, 'like', '%' . $value . '%');
                }
            });
        }

        // add relation to main object
        if (isset($params['with'])) {
            $withes = Arr::wrap($params['with']);
            foreach ($withes as $with) {
                $query->with($with);
            }
        }

        // Implement Sort
        $sortBy = isset($params['sort_by']) ?  $params['sort_by'] : 'created_at';
        $sortOrder = (isset($params['sort_order']) && $params['sort_order'] === 'asc') ? 'asc' : 'desc';

        $query->orderBy($sortBy, $sortOrder);

        if (isset($params['all'])) {
            return $query->get();
        } else {
            return $query->paginate(config('custom.db.per_page'));
        }
    }

    public function find($class, $id)
    {
        $object = new $class;
        return $object::find($id);
    }

    public function save($class, $params)
    {
        $object = new $class;
        if (isset($params['id'])) {
            $entity = $object->where(['id' => $params['id']])->first();
            $entity->update($params);
            return $entity;
        } else {
            $entity = $object->create($params);
            return $entity;
        }
    }

    public function destroy($class, $id)
    {
        $object = new $class;
        $entity = $object->find($id);
        if ($entity) {
            try {
                $entity->delete();
                return true;
            } catch (\Exception $e) {
                return false;
            }
        }
        return false;
    }
}
