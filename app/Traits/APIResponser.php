<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

trait APIResponser
{
    private function successResponse($data, $code)
    {
        return response()->json($data, $code);
    }

    protected function errorResponse($message, $code)
    {
        return response()->json(['error' => $message, 'code' => $code], $code);
    }

    /**   response全部 (多項目)   **/
    protected function showAll(Collection $collection, $code = 200)
    {
        if($collection->isEmpty()){
            return $this->successResponse(['data' => $collection], $code);
        }


        //取得屬於自己的transformer
        $transformer = $collection->first()->transformer;

        //過濾
        $collection = $this->filterData($collection, $transformer);

        //排序
        $collection = $this->sortData($collection, $transformer);

        //取得格式轉換後的資料
        $collection = $this->transformData($collection, $transformer);


        return $this->successResponse($collection, $code);
    }

    /**   response單一項    **/
    protected function showOne(Model $instance, $code = 200)
    {
        $transformer = $instance->transformer;
        $instance = $this->transformData($instance, $transformer);

        return $this->successResponse($instance, $code);
    }

    protected function showMessage($message, $code = 200)
    {
        return $this->successResponse(['data' => $message], $code);
    }


    //**     filter  過濾        **/
    protected function filterData(Collection $collection, $transformer)
    {
        //url : restfulapi.test/user?sort_by=identifier&isVerified=0

        // request()->query 會輸出   [ 'sory_by' => 'identifier'
        //                            'isVerified' => '0'
        //                                                  ]

        foreach(request()->query as $query => $value){
            $attribute = $transformer::originalAttribute($query);

            if(isset($attribute, $value)){
                $collection = $collection->where($attribute, $value);
            }
        }
        return $collection;
    }


    //**      sort  排序         **/
    protected function sortData(Collection $collection, $transformer)
    {
        if(request()->has('sort_by')){

            //**  取transform裡的靜態originalAttribute方法  */
            $attribute = $transformer::originalAttribute(request()->sort_by);

            $collection = $collection->sortBy($attribute);
        }

        return $collection;
    }

    //transform
    protected function transformData($data, $transform)
    {
        $transformation = fractal($data, new $transform);

        return $transformation->toArray();
    }

}